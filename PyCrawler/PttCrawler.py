import connDB
import config as cfg
import time
import traceback
import logging
import os
import re
import sys
import requests
from urllib.parse import urljoin
from bs4 import BeautifulSoup
from os import system
system("title PttCrawler") #set cmd title

conn = connDB.MyConnecter() #連接資料庫物件
conn.connect() #開始連接

PTT_URL = 'https://www.ptt.cc'
hotboards = 'https://www.ptt.cc/bbs/hotboards.html'

def getChildBoard(link,getPage=1):
	board_count = 0
	result = requests.get(url=link, cookies={'over18':'1'})
	soup = BeautifulSoup(result.text,'html.parser')
	child_list = soup.select('a.board')
	for child in child_list:
		try:
			child_link = PTT_URL+child['href']
			if(child_link.split('/')[-3] == 'bbs'):
				board_name = child.find(class_='board-name').text
				board_class = child.find(class_='board-class').text
				board_title = child.find(class_='board-title').text
				board_count += 1
				parse_article(board_name, board_class, getPage)
				#print(child_link,board_name,board_class,board_title)
			else:
				board_name = child.find(class_='board-name').text
				if(board_name == '0ClassRoot'):
					continue
				# print('===========================','進入',child_link,'========================')
				board_count += getChildBoard(child_link)
		except:
			pass
	return board_count

def parse_article(board_name, board_class,getPage):
	print(board_name)
	page = 0
	url = PTT_URL + '/bbs/' + board_name + '/index.html'
	while(page<getPage and url != PTT_URL + '/bbs/' + board_name + '/index1.html'):
		page +=1
		resp = requests.get(url, cookies={'over18': '1'})
		if resp.status_code != 200:
			print('invalid url:', resp.url)
			return
		soup = BeautifulSoup(resp.text, 'html.parser')
		divs = soup.find_all("div", "r-ent")
		for div in divs:
			try:
				# ex. link would be <a href="/bbs/PublicServan/M.1127742013.A.240.html">Re: [問題] 職等</a>
				href = div.find('a')['href']
				link = PTT_URL + href
				article_id = re.sub('\.html', '', href.split('/')[-1])
				# print(link,article_id)
				parse(link, article_id, board_name, board_class)
			except:
				pass

		prev_page = soup.select('.btn.wide')[1]['href']
		url = PTT_URL + prev_page
		# print(url)

def parse(link, article_id, board, board_class, timeout=3):
	result = requests.get(url=link, cookies={'over18': '1'})
	if result.status_code != 200:
		print('invalid url:', resp.url)

	soup = BeautifulSoup(result.text, 'html.parser')
	main_content = soup.find(id="main-content")
	metas = main_content.select('div.article-metaline') #上面欄位
	author = ''
	title = ''
	date = ''
	if metas:
		author = metas[0].select('span.article-meta-value')[0].string if metas[0].select('span.article-meta-value')[0] else author
		title = metas[1].select('span.article-meta-value')[0].string if metas[1].select('span.article-meta-value')[0] else title
		date = metas[2].select('span.article-meta-value')[0].string if metas[2].select('span.article-meta-value')[0] else date
		if(date):
			date = time.strptime(date,"%a %b %d %H:%M:%S %Y")
			date = time.mktime(date)

		# remove meta nodes
		for meta in metas:
			meta.extract()
		for meta in main_content.select('div.article-metaline-right'):
			meta.extract()
            
	pushes = main_content.find_all('div', class_='push')
	for push in pushes:
		push.extract()

	try:
		ip = main_content.find(text=re.compile(u'※ 發信站:'))
		ip = re.search('[0-9]*\.[0-9]*\.[0-9]*\.[0-9]*', ip).group()
	except:
		ip = "None"

	filtered = [ v for v in main_content.stripped_strings if v[0] not in [u'※', u'◆'] and v[:2] not in [u'--'] ]
	expr = re.compile(r'[^\u4e00-\u9fa5\u3002\uff1b\uff0c\uff1a\u201c\u201d\uff08\uff09\u3001\uff1f\u300a\u300b\s\w:/-_.?~%()]')
	for i in range(len(filtered)):
		filtered[i] = re.sub(expr, '', filtered[i])

	filtered = [_f for _f in filtered if _f]  # remove empty strings
	filtered = [x for x in filtered if article_id not in x]  # remove last line containing the url of the article
	content = ' '.join(filtered)
	content = re.sub(r'(\s)+', ' ', content)

	# push messages
	p, b, n = 0, 0, 0
	messages = []
	for push in pushes:
		if not push.find('span', 'push-tag'):
			continue
		push_tag = push.find('span', 'push-tag').string.strip(' \t\n\r')
		push_userid = push.find('span', 'push-userid').string.strip(' \t\n\r')
		# if find is None: find().strings -> list -> ' '.join; else the current way
		push_content = push.find('span', 'push-content').strings
		push_content = ' '.join(push_content)[1:].strip(' \t\n\r')  # remove ':'
		push_ipdatetime = push.find('span', 'push-ipdatetime').string.strip(' \t\n\r')
		messages.append( {'push_tag': push_tag, 'push_userid': push_userid, 'push_content': push_content, 'push_ipdatetime': push_ipdatetime} )
		if push_tag == u'推':
			p += 1
		elif push_tag == u'噓':
			b += 1
		else:
			n += 1

	# count: 推噓文相抵後的數量; all: 推文總數
	message_count = {'all': p+b+n, 'count': p-b, 'push': p, 'boo': b, "neutral": n}

	data = {'article_id' : connDB.escape_str(article_id), 
			'board_name' : connDB.escape_str(board), 
			'board_class' : connDB.escape_str(board_class),
			'title' : connDB.escape_str(title),
			'content' : connDB.escape_str(content),
			'author_name' : connDB.escape_str(author),
			'author_ip' : ip,
			'create_time' : date,
			'push' : p,
			'shush' : b,
			'neutral' : n,
			'url' : link,}

	conn.insert_replace(table='ptt', data=data) #replace to database table

	# print(link)
	# print(board)
	# print(board_class)
	# print(article_id)
	# print(title)
	# print(author)
	# print(date)
	# print(content)
	# print(ip)
	# print(p)
	# print(b)
	# print(n)

	# print('date',date)
	# print('msgs', messages)
	# print ('mscounts', message_count)

getChildBoard(hotboards,50)
while True:
	getChildBoard(hotboards,10)
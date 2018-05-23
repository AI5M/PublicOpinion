import connDB
import config as cfg
import time
import traceback
import logging
import os
import requests as req
from urllib.parse import urljoin
from bs4 import BeautifulSoup as bs
from os import system
system("title LtnRealtimeCrawler") #set cmd title

if(os.path.exists("./log/ltn.log")):
	os.remove("./log/ltn.log")

def writeLogging(page=0, category="", title="", url=""):
	print('something wrong in page',page)
	print('title =', title)
	traceback.print_exc()
	logging.info('something wrong in page'+str(page))
	logging.info('category='+category)
	logging.info('title='+title)
	logging.info('site_url='+url)
	logging.info(traceback.format_exc())

#處理內文和時間的7種方法
def composing_1(boardname,soup): #政治 社會 國際 財經 生活 英文排版用
	create_time = soup.select('.text span')[0].text.strip()
	create_time = time.strptime(create_time,"%Y-%m-%d %H:%M")
	content = ""
	for para in soup.select('.text p'):
		content += para.text.strip()
	return content, create_time
            
def composing_2(boardname,soup): #評論排版用
	if len(soup.select('.mobile_none'))==0:
		create_time = soup.select('.writer_date')[0].text.strip()
	else:
		create_time = soup.select('.mobile_none')[0].text.strip()
	create_time = time.strptime(create_time,"%Y-%m-%d %H:%M")
	content = ""
	for para in soup.select('.cont p'):
		content += para.text.strip()
	return content, create_time

def composing_3(boardname,soup): #體育排版用
	create_time = soup.select('.c_time')[0].text.strip()
	create_time = time.strptime(create_time,"%Y/%m/%d %H:%M")
	content = ""
	for para in soup.select('.news_p p'):
		content += para.text.strip()
	return content, create_time
    
def composing_4(boardname,soup): #娛樂排版用
	create_time = soup.select('.date')[0].text.strip()
	create_time = time.strptime(create_time,"%Y/%m/%d %H:%M")
	content = ""
	for para in soup.select('.news_content p'):
		content += para.text.strip()
	return content, create_time

def composing_5(boardname,soup): #時尚排版用
	create_time = soup.select('.label-date')[0].text.strip()
	create_time = time.strptime(create_time,"%b. %d %Y")
	content = ""
	for para in soup.select('article.boxTitle p'):
		content += para.text.strip()
	#content = re.sub('/^func.*\(\);$/','',content)# 我想換掉(func開頭();結尾的字串 但換不掉
	return content, create_time

def composing_6(boardname,soup): #3C排版用
	create_time = soup.select('.writer')[0].select('span')[1].text.strip()
	create_time = time.strptime(create_time,"%Y-%m-%d %H:%M")
	content = ""
	for para in soup.select('.cont.boxTitle p'):
		content += para.text.strip()
	content = content[:content.rfind('你可能還想看')-1]
	return content, create_time

def composing_7(boardname,soup): #汽車排版用
	create_time = soup.select('.con_writer')[0].select('span')[0].text.strip()
	create_time = time.strptime(create_time,"%Y/%m/%d %H:%M")
	content = ""
	for para in soup.select('.con p'):
		content += para.text.strip()
	return content, create_time

def ClassifyBoard(boardname,soup):
	getFunction = {
		'評論':composing_2,
		'體育':composing_3,
		'娛樂':composing_4,
		'時尚':composing_5,
		'3C':composing_6,
		'汽車':composing_7
	}
	return getFunction.get(boardname, composing_1)(boardname,soup)

#set log
logging.basicConfig(level=logging.INFO,
                	format='%(message)s',
                	filename='./log/ltn.log') #filemode預設為'a'

category_dict = cfg.category_dict #category_id
conn = connDB.MyConnecter() #連接資料庫物件
conn.connect() #開始連接

defwebsite = 'http://news.ltn.com.tw/list/breakingnews/all/'
while(True):
	result = req.get(defwebsite).text
	soup = bs(result,'html.parser')
	total_page = soup.select('.p_last')[0]['href']
	total_page = int(total_page[total_page.rfind('/')+1:])
	page = 1
	# total_page = 1
	while(page < total_page+1):
		try:
			print('page:',page)

			website = defwebsite+str(page)
			result = req.get(website).text
			soup = bs(result,'html.parser')
			news_list = soup.select('ul.list.imm li')
			for news in news_list:
				try:
					site_url = news.select('.tit')[0]['href']
					board = news.select('.tagarea a')
					city = ''
					if(len(board) > 1 ):
						city = board[1].text.strip()
					category = board[0].text.strip()

					result = req.get(site_url).text
					soup = bs(result,'html.parser')

					title = news.select('p')[0].text.strip()
					category_id = category_dict[category]
					content,create_time = ClassifyBoard(category,soup)
					create_time = time.mktime(create_time) #將時間元組改傳換為時間戳

					data = {'title' : connDB.escape_str(title), 
							'category_id' : category_id, 
							'content' : connDB.escape_str(content),
							'create_time' : create_time,
							'site_url' : site_url,
							'city' : city}

					conn.insert_ignore(table='ltn_realtime', data=data)
					# print(title)
					# print(category_id)
					# print(content)
					# print(create_time)
					# print(site_url)
					# print(city)

				except:
					if(not title):
						title=""
					writeLogging(page=page, category=category ,title=title , url=site_url)
					time.sleep(10)
			page += 1
		except:
			logging.info('**********page wrong**********')
			writeLogging(page=page)
			logging.info('**********page wrong**********')
			time.sleep(10)

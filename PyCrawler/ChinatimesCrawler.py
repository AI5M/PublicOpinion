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
system("title ChinatimesCrawler") #set cmd title

if(os.path.exists("./log/chinatimes.log")):
	os.remove("./log/chinatimes.log")

def writeLogging(page=0, category="", title="", url=""):
	print('something wrong in page',page)
	print('title =', title)
	traceback.print_exc()
	logging.info('something wrong in page'+str(page))
	logging.info('category='+category)
	logging.info('title='+title)
	logging.info('site_url='+url)
	logging.info(traceback.format_exc())

#set log
logging.basicConfig(level=logging.INFO,
                	format='%(message)s',
                	filename='./log/chinatimes.log') #filemode預設為'a'

category_dict = cfg.category_dict #category_id
conn = connDB.MyConnecter()
conn.connect()

board_dic = dict(政治='http://www.chinatimes.com/politic/total/',生活='http://www.chinatimes.com/life/total/',
				娛樂='http://www.chinatimes.com/star/total/',社會='http://www.chinatimes.com/society/total/',
				國際='http://www.chinatimes.com/world/total/',兩岸='http://www.chinatimes.com/chinese/total/',
				軍事='http://www.chinatimes.com/armament/total/',體育='http://www.chinatimes.com/sports/total/',
				旅遊='http://www.chinatimes.com/travel/total/',言論='http://opinion.chinatimes.com/total/',
				財經='http://www.chinatimes.com/money/realtimenews',話題='http://hottopic.chinatimes.com/total/',
				健康='http://www.chinatimes.com/healthcare/total',#旺車='http://want-car.chinatimes.com/news/',
				樂時尚='http://styletc.chinatimes.com/list/', 校園='http://campus.chinatimes.com/bulletin/',
				科技='http://www.chinatimes.com/technologynews/total/',#網路投票='http://ivoting.chinatimes.com/'
				)
#特殊網站: 財經(有內版), 旺車(只抓新聞),校園(只抓新消息)
#特殊網站: 旅遊,國際,言論,話題,校園, 文章網址是相對路徑

MaxPage = 2
while(True):
	timestamp = time.time()

	for board_name,board_url in board_dic.items():
		result = req.get(board_url).text
		soup = bs(result,'html.parser')
		print(board_name)
		total_page = soup.select('.pagination.clear-fix')
		if total_page:
			total_page = int(total_page[0]['data-count'])
		else:
			total_page = 1

		page = 1
		while(page < total_page+1 and page<=MaxPage):
			try:
				print('page:',page)

				website = board_url + "?page={}".format(page)
				result = req.get(website).text
				soup = bs(result,'html.parser')

				if(board_name == '財經'):
					news_list = soup.select('.news-list h2')
				else:
					news_list = soup.select('.news-list h3')

				for news in news_list:
					try:
						site_url = news.select('a')[0]['href']
						if(board_name=="國際" or board_name=="兩岸" or board_name=="軍事" or board_name=='旅遊' or
							board_name=="言論" or board_name=="話題" or board_name=="校園"):
							site_url = urljoin(board_url,site_url)

						result = req.get(site_url).text
						soup = bs(result,'html.parser')

						title = soup.select('hgroup h1')[0].text.strip()
						category_id = category_dict[board_name]
						create_time = soup.select('.reporter time')[0].text.strip()
						create_time = time.strptime(create_time,"%Y年%m月%d日 %H:%M")
						create_time = time.mktime(create_time)
						author = soup.select('.rp_name a')
						author = author[0].text.strip() if author else ''

						content = ""
						for para in soup.select('.arttext p'):
							content += para.text.strip()

						data = {'title' : connDB.escape_str(title), 
								'category_id' : category_id, 
								'content' : connDB.escape_str(content),
								'create_time' : create_time,
								'author' : author,
								'site_url' : site_url}

						conn.insert_ignore(table='chinatimes', data=data)
						# print(title)
						# print(category_id)
						# print(content)
						# print(create_time)
						# print(author)
						# print(site_url)
						time.sleep(1)
					except:
						if(not title):
							title=""
						writeLogging(page=page, category=board_name, title=title, url=site_url);
						time.sleep(10)
						continue

				page += 1
				time.sleep(30)
			except:
				logging.info('**********page wrong**********')
				writeLogging(page=page)
				logging.info('**********page wrong**********')
				time.sleep(10)

	timestamp = time.time()
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
system("title AppleCrawler") #set cmd title

if(os.path.exists("./log/apple.log")):
	os.remove("./log/apple.log")

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
                	filename='./log/apple.log') #filemode預設為'a'

category_dict = cfg.category_dict #category_id
conn = connDB.MyConnecter() #連接資料庫物件
conn.connect() #開始連接

MAXPAGES = 5
while(True):
	# list declaration
	page = 1
	timestamp = time.time()
	while(page<=MAXPAGES):
		try:
			print('page:',page)

			website = 'https://tw.appledaily.com/new/realtime/{}'.format(page) 
			result = req.get(website).text
			if(result == '<script>alert("網址不存在 !");location.href="/";</script>'):
				break

			soup = bs(result,'html.parser')
			news_list = soup.select('.rtddt')

			for news in news_list:	#進入文章網站
				try:
					site_url = news.select('a')[0]['href']
					#site_url = urljoin(website,site_url)
					category = news.h2.string
					category_id = category_dict[category]

					result = req.get(site_url).text
					soup = bs(result,'html.parser')

					title = soup.select('hgroup h1')[0].text.strip()
					view = soup.select('.ndArticle_view')
					view = view[0].text if len(view) else 0  #'a' if (determine statements) else 'b'     
					create_time = soup.select('.ndArticle_creat')[0].text
					#將時間依照格式轉換為time物件
					create_time = time.strptime(create_time.replace("出版時間：",""),'%Y/%m/%d %H:%M')
					create_time = time.mktime(create_time) #將時間元組改傳換為時間戳

					content = soup.select('.ndArticle_margin p')[0]
					if content.style:		#把sytle標籤去掉
						for cont in content.style:
							cont.extract()
					content = content.text.strip()

					data = {'title' : connDB.escape_str(title), 
							'category_id' : category_id, 
							'content' : connDB.escape_str(content),
							'create_time' : create_time,
							'view' : view,
							'site_url' : site_url}
					conn.insert_replace(table='apple', data=data) #replace to database table

					#list append

					# print(title)
					# print(category_id)
					# print(content)
					# print(create_time)
					# print(view)
					# print(site_url)
					time.sleep(1)
				except:
					if(not title):
						title = ""
					writeLogging(page=page, title=title, url=site_url)
					time.sleep(10)

			page += 1 #下一頁
			time.sleep(30)
		except:
			logging.info('**********page wrong**********')
			writeLogging(page=page)
			logging.info('**********page wrong**********')
			time.sleep(10)
	print('cost time :',round(time.time()-timestamp,2),'second')
	MAXPAGES = 5 #第一次過後只取前3頁


# titleList = []
# viewList = []
# createTimeList = []
# contentList = []
# categoryList = []
# urlList=[]

# titleList.append(title)
# viewList.append(view)
# createTimeList.append(create_time)
# contentList.append(content)
# categoryList.append(category)
# urlList.append(site_url)
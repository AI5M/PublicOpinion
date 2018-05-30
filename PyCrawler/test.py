# import DBconfig as cfg
# import pymysql

# conn = pymysql.connect(	user = 'ken-alex',
# 					password = '0000',
# 					host = 'localhost',
# 					db = 'public_opinion',
# 					port = 3306,)
# cursor = conn.cursor()

# dic = dict(title='title', category_id='2',view= 3,create_time=21321654, site_url='url',content='content')
# colname = list(dic.keys())
# row = list(dic.values())

# query = "insert into "+'apple'+"("
# for i in range(len(colname)):
# 	if i != 0:
# 		query += ','
# 	query += colname[i]
# query +=") values ("
# for i in range(len(row)):
# 	if i != 0:
# 		query +=','
# 	query += "'{}'".format(row[i])
# query +=');'

# print(query)
# cursor.execute(query)
# conn.commit()
# from bs4 import BeautifulSoup as bs
# markup = '<a href="http://example.com/">I linked to <i>example.com</i><i>example.com</i><i>example.com</i></a>'
# soup = bs(markup,'html.parser')
# a_tag = soup.a

# i_tag = a_tag.i.extract()
# i_tag = a_tag.i.extract()
# i_tag = a_tag.i.extract()
# # for s in soup('i'):
# # 	s.extract()

# print(a_tag)
# <a href="http://example.com/">I linked to</a>


# <i>example.com</i>
# import time
# t = '2018年05月15日	12:00'
# time.strptime(t,'%Y年%m月%d日 %H:%M')

# x=('好','你好')
# print(",".join(x,'=1323'))
# a = 'aaa'+eval(str(x))
# print(a)
# import json
# text = ('北市男持刀狠刺妻子　兒救母也遭砍傷','北市男持刀狠刺妻子　兒救母也遭砍傷')
# text = {'title':'北市男持刀狠刺妻子　兒救母也遭砍傷','ti':'北市男持刀狠刺妻子　兒救母也遭砍傷'}
# result = ''

# text = list(text.values())
# for i in range(len(text)):
# 	result += text[i]
# print(result)

# import logging

# logging.basicConfig(
#                 level    = logging.DEBUG,
#                 format   = 'line:%(lineno)-d %(message)s',
#                 filename = 'C:/Users/alex8/Desktop/logging.log',
#                 filemode = 'a');
# logging.info('123456')

import time
# create_time = soup.select('.reporter time')[0].text.strip()


create_time = time.localtime(1527653700);
create_time = time.gmtime(1527654240);


# create_time = time.strptime(create_time,"%a %b %d %H:%M:%S %Y")
# create_time = time.strptime(create_time,"%Y-%m-%d %H:%M")
print(create_time)


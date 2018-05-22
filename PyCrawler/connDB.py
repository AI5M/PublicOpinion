import config as cfg
import pymysql

class MyConnecter():
	def __init__(self):
		self.user = cfg.mysql['user']
		self.password = cfg.mysql['password']
		self.host = cfg.mysql['host']
		self.db = cfg.mysql['db']
		self.port = cfg.mysql['port']

	def connect(self):
		self.conn = pymysql.connect(user=self.user,
								password = self.password,
								host = self.host,
								db = self.db,
								port = self.port,
								charset = "utf8")
		self.cursor = self.conn.cursor()

	def insert_ignore(self, table, data):
		colname = tuple(data.keys())
		row = list(data.values())

		sql = "insert ignore into "+table+"("
		sql += ",".join(colname)
		sql += ") values ("
		for i in range(len(row)):
			if i != 0:
				sql += ','
			sql += "'"+str(row[i])+"'"
		sql += ')'
		# print(sql)
		self.cursor.execute(sql)
		self.conn.commit()

	def insert_replace(self, table, data):
		colname = tuple(data.keys())
		row = list(data.values())

		sql = "replace into "+table+"("
		sql += ",".join(colname)
		sql += ") values ("
		for i in range(len(row)):
			if i != 0:
				sql += ','
			sql += "'"+str(row[i])+"'"
		sql += ')'
		# print(sql)
		self.cursor.execute(sql)
		self.conn.commit()

	def insert_update(self, table, data, update):
		colname = tuple(data.keys())
		row = list(data.values())
		update = list(update)

		sql = "insert ignore into "+table+"("
		sql += ",".join(colname)
		sql += ") values ("
		for i in range(len(row)):
			if i != 0:
				sql += ','
			sql += "'"+str(row[i])+"'"

		sql += ") ON DUPLICATE KEY UPDATE "
		for i in range(len(update)):
			if i != 0:
				sql += ','
			sql += update[i] + '=' + str(data[update[i]])
		
		# print(sql)
		self.cursor.execute(sql)
		self.conn.commit()

def escape_str(s):
	return(pymysql.escape_string(s))

		
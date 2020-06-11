import json
import pymysql
#创建数据库和表

conn = pymysql.connect(host='127.0.0.1',
                       port=3306,
                       user='root',
                       passwd='',
                       db ='steam_SQL',
                       charset='utf8')
cursor = conn.cursor()

f=open('steamgame.json',encoding='utf-8')
temp = json.load(f)

for index, line in enumerate(temp):
    try:
        cursor.execute("insert into steamgame (game_id,name,release_date,developer,price,rate_num,pos_rate,tags,related_games,language,description,game_url)\
                        values(%s,%s,%s,%s,%s,%d,%d,%s,%s,%s,%s,%s)", list(line.values()))
        if not (index % 3430):
            conn.commit()
    except:
        continue
else:
    conn.commit()
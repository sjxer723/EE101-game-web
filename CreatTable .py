import pymysql
#创建数据库和表

conn = pymysql.connect(host='127.0.0.1',
                       port=3306,
                       user='root',
                       passwd='',
                       charset='utf8')
cursor = conn.cursor()
cursor.execute('DROP DATABASE IF EXISTS steam_SQL')
cursor.execute('create DATABASE if not exists steam_SQL character set UTF8mb4 collate utf8mb4_general_ci')
conn.commit()
conn = pymysql.connect(host='127.0.0.1',
                       port=3306,
                       user='root',
                       passwd='',
                       db='steam_SQL',
                       charset='utf8')
cursor = conn.cursor()
cursor.execute('CREATE TABLE `steamgame`(\
                `game_id`INT,\
                `name` VARCHAR(100) BINARY uniqueNOT NULL,\
                `release_date` VARCHAR(100),\
                `developer` VARCHAR(1000),\
                `price` VARCHAR(100),\
                `rate_num`INT,\
                `pos_rate`INT,\
                `tags`TEXT(1000),\
                `related_games`TEXT,\
                `language`TEXT,\
                `description` TEXT(20000),\
                `game_url` VARCHAR(300),\
                PRIMARY KEY (`name`))\
                ENGINE=InnoDB,\
                DEFAULT CHARACTER SET = utf8mb4')
conn.commit()
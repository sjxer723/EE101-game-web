import json
f=open('steamgame_2.json',encoding='utf-8')
#将数据导入程序中
data=json.load(f)
index=0
#遍历data，打印列表中的每一个字典
for dict_data in data:
    print(dict_data['game_id'],dict_data['pos_rate'])
    
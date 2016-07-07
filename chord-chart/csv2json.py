import os
import json

__csv__ = './visual'
__json__ = './json'

csv_list = os.listdir(__csv__)


def toJson():
  for csv in csv_list:
    #print 'file:', csv
    csv_name = __csv__ + '/' + csv
    json_name = __json__ + '/' + csv.split('.')[0] + '.json'
    f = open(csv_name, 'r')
    head = f.readline()
    head_cols = head.split(',')
    enum_head_cols = enumerate(head_cols)
    
    result_dict = {}
  
    lines = f.readlines()
    for line in lines:
      cur_cols = line.split(',')
      cur_key = ''
      for x1,y1 in enumerate(cur_cols):

      	if x1 == 0:
      	  cur_key = y1.replace('\r', '').replace('\n', '')
          result_dict[cur_key] = {}
          continue
       
        for x2,y2 in enumerate(head_cols):
          
          if x2 == 0:
            continue
        
          key = y2.replace('\r', '').replace('\n', '')
          val = cur_cols[x2].replace('\r', '').replace('\n', '')
          result_dict[cur_key][key] = val
    f.close()

    f_to = open(json_name, 'w')
    f_to.write(json.dumps(result_dict))
    f_to.close()

toJson()






  
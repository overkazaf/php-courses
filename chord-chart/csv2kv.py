import os
import json

__dir__ = './symbol'
__json__ = './json'

def parse():
  files = os.listdir(__dir__)
  for file in files:
    filepath = __dir__ + '/' + file
    f = open(filepath, 'r')
    head = f.readline()
    lines = f.readlines()

    headcol = head.split(',')

    l = []
    for line in lines:
      obj = {}
      kv = line.split(',')
      obj[headcol[0].replace('\r', '').replace('\n', '')] = kv[0].replace('\r', '').replace('\n', '')
      obj[headcol[1].replace('\r', '').replace('\n', '')] = kv[1].replace('\r', '').replace('\n', '')
      l.append(obj)
    
    f.close()
    fjson = __json__ + '/' + file.split('.')[0] + '.json'
    fw = open(fjson, 'w')
    fw.write(json.dumps(l))
    fw.close()

parse()
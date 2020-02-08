#!/usr/bin/env python3.7
import re
import os
import sys

def move_file(f):
    count=0
    line=f.readline()
    while line:
       ### print(f.tell())
        count=count+1
        searchobj=re.search(r'#include\s+"(.*?)"',line)
        ###print(f.tell())
        if(searchobj):
            #row=sys._getframe().f_lineno
           # print(row)
            position_f=f.tell()
            f.seek(0)
            lines_me=[]
            for line_f in f:
                lines_me.append(line_f)
            print(position_f)
            f1_name=searchobj.group(1)
            for relpath, dirs, files in os.walk('/home/tzx/Desktop'):
                if f1_name in files:
                    full_path = os.path.join('/home/tzx/Desktop/testprp', relpath, f1_name)
                    print(full_path)
                    f2=open(full_path,'r+')
                    f2.seek(0)
                    temp_co=count
                    count1,lines_you=move_file(f2)

                    f2.seek(0)
                    lines_you=[]
                    for lines in f2:
                        lines_you.append(lines)
                    f2.close()
                    lines_me[temp_co-1]='/*'+lines_me[temp_co-1].strip('\n')+'*/'+'\n'
                    temp_lines_me_you=lines_me[:temp_co]+lines_you[:]+lines_me[temp_co:]
                    f.seek(0)
                    f.truncate()
                    f.writelines(temp_lines_me_you)
                    f.seek(position_f+4,0)
        line=f.readline()
    print("success")
    return count,

f1=open('/home/tzx/Desktop/testprp','rb')
f2=open('/home/tzx/Desktop/sLinkList.i','w+')
f1.seek(0)
print(f1.tell())
move_file(f1,f2)
f1.close()



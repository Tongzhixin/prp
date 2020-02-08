#!/usr/bin/env python3.7
import re,os

def move_file(f):
    flag=False
    count=0
    lines_me=[]
    count_list=[]
    lines_list=[]
    f.seek(0)
    for line_f in f:
        lines_me.append(line_f)
    f.seek(0)
    for line in f:
        count=count+1
        searchobj=re.search(r'#include\s+"(.*?)"',line)
        if searchobj:            
            f1_name=searchobj.group(1)
            for relpath, dirs, files in os.walk('/home/tzx/Desktop'):
                if f1_name in files:
                    flag=True
                    full_path = os.path.join('/home/tzx/Desktop', relpath, f1_name)
                    print(full_path)
                    f2=open(full_path,'r+')
                    lines_list.append(move_file(f2))
                    f2.close()
                    count_list.append(count)
            print(count_list)
    if flag:
        lines_me_list=[]
        it=iter(count_list)
        print(count_list)
        count_temp=0
        for x in it:
        #    print(x)
            lines_me[x-1]='/*'+lines_me[x-1].strip('\n')+'*/'+'\n'
            lines_me_list.append(lines_me[count_temp:x])
            count_temp=x
        lines_me_list.append(lines_me[count_temp:])
 #       print(lines_me_list)
        it2=iter(lines_me_list)
        lines_me_you=next(it2)
 #      print(next(it2))
        it3=iter(lines_list)
        it1=iter(count_list)
        count2=0
        for y in it1:
            lines_me_you=lines_me_you+next(it3)+next(it2)

        return lines_me_you

    else:
        return lines_me




f1=open('/home/tzx/Desktop/sLinkList.cpp','r')
f2=open('/home/tzx/Desktop/sLinkList.i','w')
f2.writelines(move_file(f1))
f2.close()
f1.close()

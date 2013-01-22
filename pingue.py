#!/usr/bin/python
# -*- coding: UTF8 -*- 
import xmlrpclib
import MySQLdb
import datetime,time
try:
    server = xmlrpclib.ServerProxy("http://10.50.1.2:10018")
except:
    pass
fichier=open("items.txt","r")

for line in fichier:
    (serveur,item)=line.split(";")
    item=item.replace(chr(13),'').replace(chr(10),'')
    print item
    try:   
        res = server.opcserver.valeur(serveur,item)
        print res
        timestamp=datetime.datetime.fromtimestamp(time.mktime(time.strptime(res['ITEM TIMESTAMP'],"%m/%d/%y %H:%M:%S"))).strftime('%Y-%m-%d %H:%M:%S')
    except:    
        res={}
        timestamp=str(datetime.datetime.fromtimestamp(time.time()))
        res['ITEM QUALITY']='Bad'
        print "Pas de reponse"
        pass
    if res['ITEM QUALITY'] == 'Bad':
        res['ITEM VALUE']=  None


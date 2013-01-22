#!/usr/bin/python
# -*- coding: UTF8 -*- 
import xmlrpclib
import MySQLdb
import datetime,time
try:
    server = xmlrpclib.ServerProxy("http://10.50.1.2:10018")
except:
    pass
fichier_lav=open("items_lav.txt","r")
fichier_cs01=open("items_cs01.txt","r")

conn = MySQLdb.connect('localhost','root','root', 'opc')
curs = conn.cursor()
curs.execute("select now()")
datet= str(curs.fetchone()[0])
for line in fichier_cs01:
    (serveur,item)=line.split(";")
    item=item.replace(chr(13),'').replace(chr(10),'')
    print item
    try:   
        res = server.opcserver.valeur(serveur,item)
        timestamp=datetime.datetime.fromtimestamp(time.mktime(time.strptime(res['ITEM TIMESTAMP'],"%m/%d/%y %H:%M:%S"))).strftime('%Y-%m-%d %H:%M:%S')
    except:    
        res={}
        timestamp=str(datetime.datetime.fromtimestamp(time.time()))
        res['Item Value']=0.0
        res['Item Quality']='Bad'
        pass
for line in fichier_lav:
    (serveur,item)=line.split(";")
    item=item.replace(chr(13),'').replace(chr(10),'')
    print item
    try:   
        res = server.opcserver.valeur(serveur,item)
        timestamp=datetime.datetime.fromtimestamp(time.mktime(time.strptime(res['ITEM TIMESTAMP'],"%m/%d/%y %H:%M:%S"))).strftime('%Y-%m-%d %H:%M:%S')
    except:    
        res={}
        timestamp=str(datetime.datetime.fromtimestamp(time.time()))
        res['Item Value']=0.0
        res['Item Quality']='Bad'
        pass
    
    requete ="insert into valeurs (dateenreg,timestamp,serveur,item,valeur,etat) values ('"+datet+"','"+timestamp+"','"+serveur+"','"+item+"','"+str(res['ITEM VALUE'])+"','"+res['ITEM QUALITY']+"')"
    curs.execute(requete)
    curs.execute("commit")
curs.close()
conn.close() 



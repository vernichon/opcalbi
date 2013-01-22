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
conn = MySQLdb.connect('localhost','root','root', 'opc')
curs = conn.cursor()
curs.execute("select now()")
datet= str(curs.fetchone()[0])
for line in fichier:
    (serveur,item)=line.split(";")
    item=item.replace(chr(13),'').replace(chr(10),'')
    print serveur
    print item
    try:   
        res = server.opcserver.valeur(serveur,item)
        timestamp=datetime.datetime.fromtimestamp(time.mktime(time.strptime(res['ITEM TIMESTAMP'],"%m/%d/%y %H:%M:%S"))).strftime('%Y-%m-%d %H:%M:%S')
    except:    
        res={}
        timestamp=str(datetime.datetime.fromtimestamp(time.time()))
        res['ITEM QUALITY']='Bad'
        print "Pas de reponse"
        pass
    if res['ITEM QUALITY'] == 'Bad':
        res['ITEM VALUE']=None
    requete ="insert into valeurs (dateenreg,timestamp,serveur,item,valeur,etat) values ('"+datet+"','"+timestamp+"','"+serveur+"','"+item+"','"+str(res['ITEM VALUE'])+"','"+res['ITEM QUALITY']+"')"
    curs.execute(requete)
    curs.execute("commit")
curs.close()
conn.close() 



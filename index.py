#!/usr/bin/python

from mod_python import apache
import sys,calendar, SimpleXMLRPCServer,psycopg2 as pg2,socket 
#conn = pg2.connect("dbname='openkiosk' user='adminmedia' password='adminmedia' host='localhost' ")
#cur=conn.cursor()
import xmlrpclib,time
import urllib2
def  handler(req):
    req.content_type = 'text/html'
    req.write('<html><head>')
    req.write('<script type="text/JavaScript">')
    req.write('function timedRefresh(timeoutPeriod) {')
    req.write('setTimeout("location.reload(true);",timeoutPeriod);')
    req.write('}')
    req.write('</script>')
    req.write("""
    <script type="text/javascript" src="/js/swfobject.js"></script>
<script type="text/javascript">
swfobject.embedSWF(
"open-flash-chart.swf", "sjy", "550", "400",
"9.0.0", "expressInstall.swf",
{"data-file":"/datasjy.php"} );
</script>
    """)
    req.write("""
    <script type="text/javascript" src="/js/swfobject.js"></script>
<script type="text/javascript">
swfobject.embedSWF(
"open-flash-chart.swf", "ref", "550", "400",
"9.0.0", "expressInstall.swf",
{"data-file":"/dataref.php"} );
</script>
    """)
    req.write("""
    <script type="text/javascript" src="/js/swfobject.js"></script>
<script type="text/javascript">
swfobject.embedSWF(
"open-flash-chart.swf", "rdb", "550", "400",
"9.0.0", "expressInstall.swf",
{"data-file":"/datardb.php"} );
</script>
    """)
    
    
    req.write('<meta http-equiv="Content-Type" content="text/html;charset="UTF-8" />')
    req.write('<title>Serveur OPC</title>')
    req.write('</head><body>')
  
    req.write('<div id=valeur onLoad="javascript:timedRefresh(10000)">')
    req.write(time.strftime('%d-%m-%Y %H:%M:%S')+'</br>')
    controle(req)
    req.write(time.strftime('%d-%m-%Y %H:%M:%S')+'</br>')
    req.write('</div>')
    
    req.write('<div id=rdb onLoad="javascript:timedRefresh(10000)"></div>')
    req.write('<div id=sjy onLoad="javascript:timedRefresh(10000)"></div>')
    req.write('<div id=ref onLoad="javascript:timedRefresh(10000)"></div>')
    #~ onLoad="javascript:timedRefresh(10000)
    req.write('</body></html>')	
    return apache.OK
server = xmlrpclib.ServerProxy("http://10.50.1.2:10018")
def controle(req):
    valnegstju=server.opcserver.valeur('EH_Wetzer.OPC_DA_Server.4','lav.LAVZSJY_-.VT_R8')
    valposstju=server.opcserver.valeur('EH_Wetzer.OPC_DA_Server.4','lav.LAVZSJY_+.VT_R8')
    valnegref=server.opcserver.valeur('EH_Wetzer.OPC_DA_Server.4','lav.LAVZREF-.VT_R8')
    valposref=server.opcserver.valeur('EH_Wetzer.OPC_DA_Server.4','lav.LAVZREF+.VT_R8')
    valnegrdb=server.opcserver.valeur('EH_Wetzer.OPC_DA_Server.4','rdb.LAVZRDB-.VT_R8')
    valposrdb=server.opcserver.valeur('EH_Wetzer.OPC_DA_Server.4','rdb.LAVZRDB+.VT_R8')
    req.write('Debit N&eacute;gatif saint juery : '+str(valnegstju['Item Value'])+'</br>')
    req.write('Debit Positif   saint juery : '+str(valposstju['Item Value'])+'</br></br>')
    req.write('Debit N&eacute;gatif Refoulement : '+str(valnegref['Item Value'])+'</br>')
    req.write('Debit Positif Refoulement : '+str(valposref['Item Value'])+'</br></br>')
    req.write('Debit N&eacute;gatif Rue du bain : '+str(valnegrdb['Item Value'])+'</br>')
    req.write('Debit Positif   Rue du bain : '+str(valposrdb['Item Value'])+'</br></br>')

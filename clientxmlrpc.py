import xmlrpclib

server = xmlrpclib.ServerProxy("http://10.50.1.2:10018")
print  server.opcserver.valeur('EH_Wetzer.OPC_DA_Server.4','lav.LAVZSJY_-.VT_R8')
#~ print server
#~ serveurs = server.opcserver.serveurs()
#~ for serveur in serveurs:
    #~ print serveur
    #~ items = server.opcserver.liste(serveur)
    #~ for item in items:
        #~ print item

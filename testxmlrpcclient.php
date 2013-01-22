<?php
require_once('xmlrpc.inc');
$xmlrpc_client=new xmlrpc_client("http://10.50.1.2:10018");

$msg = new xmlrpcmsg('valeur');
$msg->addParam(new xmlrpcval('S7200.OPCServer','string'));
$msg->addParam(new xmlrpcval('MicroWin.CS01.USER1.VITESSE_P2_GAO','string'));

$xmlrpc_resp=$xmlrpc_client->send($msg);
$resp=$xmlrpc_resp->value()->scalarval();
print $resp['ITEM VALUE']->scalarval();
?>
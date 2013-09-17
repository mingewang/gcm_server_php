<?php

/**
* Copyright (C) 2013-2013 Min Wang 
* (aka mingewang@gmail.com - www.comrite.com)
* gcm_server_php is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*/
 
openlog("gcmlog", LOG_PID | LOG_PERROR, LOG_LOCAL0);

syslog(LOG_DEBUG,"starting");
syslog(LOG_DEBUG,"params is : " . $_POST["params"]);
/**
 * Registering a user device
 */
//why can not isset on json params?
// always return 500 if check here
//if ( isset($_POST["params"] ) {

    // {"reg_id":"xdfdf","sip_uris":["<sip:12345@192.168.1.26>"]}
    //$params =  '{"reg_id":"xdfdf","sip_uris":["<sip:12345@192.168.1.26>"]}'; 
    $params = $_POST["params"];

    syslog(LOG_DEBUG,$params);

    // {"regid":regid, "sipuris" : {sipuri1,sipur2} }
    $json_params = json_decode($params);
    //var_dump($json_params);

    $gcm_regid = $json_params->{"reg_id"} ; // GCM Registration ID
    syslog(LOG_DEBUG,"regid is " . $gcm_regid);

    $sip_uris = $json_params->{"sip_uris"};
    syslog(LOG_DEBUG,"sip_uris is: " . $sip_uris);

    // Store user details in db
    include_once './db_api.php';
    include_once './GCM.php';
 
    $db = new GCM_DB();
    $gcm = new GCM();

    //$sip_uris = explode(",","<sip:test@test1.com>,<sip:test2@test2.com>");
    //$gcm_regid = "xdfdf";
    // sync sipuri with db 
    $res = $db->syncUser($sip_uris, $gcm_regid);
 
//} else {
    // missing para 
 //   syslog(LOG_ERR,"Post request missing params!!  " );
//}

closelog();

?>

<?php

/**
* Copyright (C) 2013-2013 Min Wang 
* (aka mingewang@gmail.com - www.comrite.com)
* gcm_server_php is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*/

/**
* incoming url:
* push csipsimple to register
* http://push.ng-voice.com/push.php?from=494034927219&to=491792021244&control=register
* push csipsimple to un-register
* incoming http://push.ng-voice.com/push.php?from=494034927219&to=491792021244&control=unregister
*/

$to = $_GET["to"];
$control_msg = $_GET["control"];

if ( isset($to) && isset($control_msg) ) {
    //$regId = "APA91bHkka1kvsLtc2T0GnoHmBBpuyT5fcjr1Z3cQUFBPwLOErt45HxAi7wZnWTZMs9quP5NTWGnMisnCneSfTchk0Ojo-suRjvh5snFbg7ZlnWxjzthSI6qBXlKAmgnmvjYHl-w19b-sKs8H4CVv8qXTj8aCrpTEg";

    include_once './db_api.php';
    include_once './GCM.php';
    $db = new GCM_DB();
    $gcm = new GCM();

    $registatoin_ids =  $db->findUserRegId($to);
    // construte gcm msg 
    $message = array("incoming_msg" => $control_msg);
    //$registatoin_ids = array($regId);
    $result = $gcm->send_notification($registatoin_ids, $message);
    //var_dump($result);
    //echo $result;
} else {

  echo "no to and contrl";
}

?>

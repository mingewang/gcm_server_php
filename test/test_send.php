<?php
//if (isset($_GET["regId"]) && isset($_GET["message"])) {
    //$regId = $_GET["regId"];
    $regId = "APA91bHkka1kvsLtc2T0GnoHmBBpuyT5fcjr1Z3cQUFBPwLOErt45HxAi7wZnWTZMs9quP5NTWGnMisnCneSfTchk0Ojo-suRjvh5snFbg7ZlnWxjzthSI6qBXlKAmgnmvjYHl-w19b-sKs8H4CVv8qXTj8aCrpTEg";
    $message = "register";
     
    include_once '../src/GCM.php';
     
    $gcm = new GCM();
 
    $registatoin_ids = array($regId);
    $message = array("incoming_msg" => $message);

    var_dump("test"); 
    $result = $gcm->send_notification($registatoin_ids, $message);

    echo " result is \n";
    var_dump($result);
 
    echo $result;
//}
?>

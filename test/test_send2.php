<?php
//if (isset($_GET["regId"]) && isset($_GET["message"])) {
    //$regId = $_GET["regId"];
    $regId = "APA91bHPXF9OV0OZhMmAMPwRGViCREO4aKHC8t9lQdsUr5713VPU-wtlDOEOmgDBzzMJp-BSJm2Tdsj7zFN9-ROHqm0jgmCXLCzje4wNH8sMnW1ulcBwd3rw-WTRHEd98ZDx2Qr7Ok60_e1aSySUtqsbX5JvPSMBfw";
    $message = "unregister";
     
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

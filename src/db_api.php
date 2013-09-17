<?php

/**
* Copyright (C) 2013-2013 Min Wang 
* (aka mingewang@gmail.com - www.comrite.com)
* gcm_server_php is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*/
 
require_once 'config.php';

class GCM_DB {

    const TABLE_NAME = "device_apps"; 
    private $link;
 
    //put your code here
    // constructor
    function __construct() {
	$this->link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
	//var_dump($link);
    }
 
    // destructor
    function __destruct() {
        $this->link->close(); 
    }

    // sync user array with regid
    // sipuri = [<sipurl1>,<sipurl2>]
    public function syncUser($sip_uris, $reg_id) {
	//var_dump($sip_uris);
	//var_dump($this->link);
	//var_dump("$reg_id");
        $result = $this->link->query("SELECT id, sip_uri FROM ". self::TABLE_NAME  ." WHERE reg_id = '$reg_id'");
	
	$to_be_deleted_sip_uris_ids = [];
	$old_sip_uris = [];
	while( $row = $result->fetch_row() ) {
		$old_sip_uris[] = $row[1];
		//var_dump($row);
		if( ! in_array($row[1],$sip_uris) ) {
			$to_be_deleted_sip_uris_ids[] = $row[0];
		}
	}

	// delete no-existed one
	foreach($to_be_deleted_sip_uris_ids as $id ) {
        	$result = $this->link->query("DELETE FROM ". self::TABLE_NAME ." WHERE id = '$id'");
	}

	//var_dump($old_sip_uris);
	// add new one
	foreach($sip_uris as $uri) {
		if( !in_array($uri,$old_sip_uris) ) {
			list($scheme, $user,$host,$port,$params) = $this->parse_sip_uri($uri);
			//var_dump($parsed_uri);
			$query = "INSERT INTO ". self::TABLE_NAME ."(sip_uri, reg_id, created_at,updated_at, scheme, user, host, port, params) VALUES('$uri', '$reg_id', NOW(), NOW(), '$scheme','$user','$host','$port', '$params')";
			//echo $query;
			$ret = $this->link->query($query);
		}
	}

    }

 
    /**
     * parse sipuri : <sip:user@host:port;params>
     */
    private function parse_sip_uri($uri) {
	$tmp_uri = $uri;
	$tmp_uri = str_replace('<','',$tmp_uri);
	$tmp_uri = str_replace('>','',$tmp_uri);
	$pattern = '/(.*):(.*)@(.*)/';
	if( preg_match($pattern,$tmp_uri,$matches) ){
		$scheme = $matches[1];
		$user = $matches[2];
		$domain = $matches[3];
		list($host_port,$params)=preg_split('/;/',$domain,2);
		list($host,$port)=preg_split('/:/',$host_port);

		if( !$port ) $port = "5060";
		//if( !$params ) $params = "";

		//return array("scheme"=>$scheme, "user"=>$user,"host"=>$host,"port"=>$port,"params"=>$params);
		return array($scheme, $user,$host,$port,$params);
	}

	return NULL;	
	
    }
 
    /**
     * Getting all sipuri 
     */
    public function getAllSipUris() {
	$ret = [];
        $result = $this->link->query("SELECT * FROM ". self::TABLE_NAME);
	while( $row = $result->fetch_array() ) {
		$ret[] =  $row;
	}	
	//var_dump($ret);
        return $ret;
    }

    /**
     * search user by phone number
     */
    public function findUserRegId($to) {
	$ret = [];
        $result = $this->link->query("SELECT reg_id FROM ". self::TABLE_NAME
		. " WHERE user = ". $this->link->real_escape_string($to));

	while( $row = $result->fetch_array() ) {
		$ret[] =  $row['reg_id'];
	}	
	return $ret;
    }
 
}
 
?>

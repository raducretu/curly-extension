<?php
include('qr.php');

$size		= 	200;

$type 		= 	isset( $_GET["type"] ) ? $_GET["type"] : null;
$title 		= 	isset( $_GET["title"] ) ? $_GET["title"] : null;
$url 		= 	isset( $_GET["url"] ) ? $_GET["url"] : null;
$name 		= 	isset( $_GET["name"] ) ? $_GET["name"] : null;
$address 	= 	isset( $_GET["address"] ) ? $_GET["address"] : null;
$phone 		= 	isset( $_GET["phone"] ) ? $_GET["phone"] : null;
$email 		= 	isset( $_GET["email"] ) ? $_GET["email"] : null;
$subject 	= 	isset( $_GET["subject"] ) ? $_GET["subject"] : null;
$message	= 	isset( $_GET["message"] ) ? $_GET["message"] : null;
$lat 		= 	isset( $_GET["lat"] ) ? $_GET["lat"] : null;
$lon 		= 	isset( $_GET["lon"] ) ? $_GET["lon"] : null;
$height 	= 	isset( $_GET["height"] ) ? $_GET["height"] : null;
$text 		= 	isset( $_GET["text"] ) ? $_GET["text"] : null;
$wifi_type 	= 	isset( $_GET["wifi_type"] ) ? $_GET["wifi_type"] : null;
$ssid 		= 	isset( $_GET["ssid"] ) ? $_GET["ssid"] : null;
$password 	= 	isset( $_GET["password"] ) ? $_GET["password"] : null;
$size	 	= 	isset( $_GET["size"] ) ? $_GET["size"] : null;

$qr = new BarcodeQR(); 

switch($type){
	
	case 'url' 		: 	$qr->url($url); break;
	case 'contact' 	:	$qr->contact($name, $address, $phone, $email); break;
	case 'email' 	:	$qr->email($email, $subject, $message); break;
	case 'geo' 		:	$qr->geo($lat, $lon, $height); break;
	case 'phone' 	:	$qr->phone($phone); break;
	case 'sms' 		:	$qr->sms($phone, $message); break;
	case 'text' 	:	$qr->text($text); break;
	case 'wifi' 	:	$qr->wifi($wifi_type, $ssid, $password); break;
	case 'bookmark' :	$qr->bookmark($text, $url); break;

}

$qr->draw($size);

?>
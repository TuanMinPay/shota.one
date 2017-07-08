<?php
/**
 *      [HoaKhuya] (C)2010-2099 Hacking simple source Orzg.
 *      Drark license payto BitcoinAddress: 1HikvH2jnMNg4rDJHykMMk31gpyr2qrhU4
 *		Coders : develop@execs.com;yuna.elin@yandex.ru;tonghua@dr.com;
 *
 *      $Id: database.php [BuildDB.155478522] 03/07/2017 1:57 CH $
    
*/
session_start();ob_start();
error_reporting(0);
$http = explode('"',$_SERVER['HTTP_CF_VISITOR'])[5];
if ($http=="http") { $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];header('Location: ' . $redirect);}
ELSE {echo $http;}
define ("database","yFedzS_db/");
define ("config","incl/config.db");
include 'incl/function/function.class.php'; 
include 'incl/function/function.go.class.php';
	
$C_CONFIG_KEY="Xsu9A9J7Z7CymA63Y5c9uy3S9jdRa7GbEP6v87n8w2cVG4juBBBW5YEzcxNR3w4";
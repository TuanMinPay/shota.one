<?php
/**
 *      [HoaKhuya] (C)2010-2099 Hacking simple source Orzg.
 *      Drark license payto BitcoinAddress: 1HikvH2jnMNg4rDJHykMMk31gpyr2qrhU4
 *		Coders : develop@execs.com;yuna.elin@yandex.ru;tonghua@dr.com;
 *
 *      $Id: return.php [BuildDB.155478522] 07/07/2017 3:50 CH $
    
*/
include 'incl/database.php';

$C = new shorten;
$D = new go;

if ($_GET['makeurl']){ echo $C->makeurl();}
if ($_GET['bypass']){echo $D->check();}
if ($_GET['passwd']){echo $D->passprotect();}
if ($_GET['verfy']){echo $D->checkpwd();}
?>
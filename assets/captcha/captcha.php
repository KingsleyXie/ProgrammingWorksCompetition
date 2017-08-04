<?php

session_start();
require "ValidateCode.class.php";

$_captcha = new ValidateCode();
$_captcha->doimg();
$_SESSION["captcha"] = $_captcha->getCode();

/*---------------------------------------------------------------------
`ValidateCode.class.php` and `elephant.ttf` are from:
	http://blog.csdn.net/liruxing1715/article/details/6897286
---------------------------------------------------------------------*/
?>

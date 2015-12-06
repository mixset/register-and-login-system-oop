<?php
/**
 @Author: Dominik Ryńko
 @Website: http://www.rynko.pl/
 @Version: 1.0
*/

// Flush the output buffer
ob_start();

// Start session
session_start();

// Include classes from /core dir
function __autoload($className)
{
 if(preg_match('/^[a-z][0-9a-z]*(_[0-9a-z]+)*$/i', $className))
 {
  require 'core/'.$className.'.class.php';
 }
}

// Create new object of core class
$core = new Core;

// Set new variable with object of PDO 
$pdo = $core -> DBconnection();

// Create new object of session class
$session = new Session;

$templatePath = 'template/';

// Include header file
require $templatePath.'header.php';

// Include front file
require $templatePath.'front.php';

// Include footer file
require $templatePath.'footer.php';

// End buffer
ob_end_flush();

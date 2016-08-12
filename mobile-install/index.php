<?php
// Config
require_once('../config.php');

// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Registry
$registry = new Registry();

// Database 
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

// Create category mobile image table

$db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "category_mobile` (`category_id` int(11) NOT NULL, `image` varchar(255) NOT NULL, PRIMARY KEY(`category_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8");

echo '<p>Done... Please remove this folder after installation...</p>';
?>
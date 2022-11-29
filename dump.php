<?php
require_once('wp-config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$database = DB_NAME;
$user = DB_USERNAME;
$pass = DB_PASSWORD;
$host = DB_HOST;

$dir = dirname(__FILE__) . '/db/dump.sql';

echo "<h3>Backing up database to `<code>{$dir}</code>`</h3>";

exec("mysqldump --user={$user} --password={$pass} --host={$host} {$database} --result-file={$dir} 2>&1", $output);

var_dump($output);
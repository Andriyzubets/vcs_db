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
if(isset($_GET['return']) and $_GET['return'] == 1) {
	$output = 'fir';

	$conn =new mysqli($host,$user,$pass,$database);

	$query = '';
	$sqlScript = file($dir);
	foreach ($sqlScript as $line)	{

		$startWith = substr(trim($line), 0 ,2);
		$endWith = substr(trim($line), -1 ,1);

		if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
			continue;
		}
		
		$query = $query . $line;
		if ($endWith == ';') {
			mysqli_query($conn,$query) or die('<div class="error-response sql-import-response">Problem in executing the SQL query <b>' . $query. '</b></div>');
			$query= '';
		}
	}
	echo '<div class="success-response sql-import-response">SQL file imported successfully</div>';
} else {
	$output = 'sec';
	exec("mysqldump --user={$user} --password={$pass} --host={$host} {$database} --result-file={$dir} 2>&1", $output);
}

var_dump($output);
<?php
error_reporting(E_ALL);
require('../../config/config.php');
$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die('Could not connect to database server ' . DB_HOST);
mysql_select_db(DB_NAME, $link) or die('Could not select database ' . DB_NAME);

$id = $_GET['id'];

//$cs = 'character set '.config_option('character_set', 'utf8');
//$co = 'collate '.config_option('collation', 'utf8_unicode_ci');

$cs = 'character set utf8';
$co = 'collate utf8_unicode_ci';

$sql = file_get_contents("$id.sql");
$sql = str_replace('{$tp}', DB_PREFIX, $sql);
$sql = str_replace('<?php echo $table_prefix ?>', DB_PREFIX, $sql);
$sql = str_replace('<?php echo $default_collation ?>', $co, $sql);
$sql = str_replace('<?php echo $default_charset ?>', $cs, $sql);

$total_queries = 0;
$executed_queries = 0;

$summary = executeMultipleQueries($sql, $total_queries, $executed_queries, $link);

if (!is_array($summary)){
	echo 'No queries executed.';
} else {
	echo '<p><strong>Summary</strong>' . "<br>\n";
	echo 'Total queries in SQL: ' . $summary['total_queries'] . " <br>\n";
	echo 'Total executed queries: ' . $summary['executed_queries']  . " <br>\n";
	echo 'Total successful queries: ' . $summary['successful_queries']  . " <br>\n";
	echo 'Total failed queries: ' . $summary['failed_queries']  . " <br>\n";
	echo '</p>';
}

mysql_close($link);


    function executeMultipleQueries($sql, $total_queries, $executed_queries, $link) {
      if (!trim($sql)) {
        $total_queries = 0;
        $executed_queries = 0;
        return true;
      } // if
      
      // Make it work on PHP 5.0.4
      $sql = str_replace(array("\r\n", "\r"), array("\n", "\n"), $sql);
      
      $queries = explode(";\n", $sql);
      if (!is_array($queries) || !count($queries)) {
        $total_queries = 0;
        $executed_queries = 0;
        return true;
      } // if
      
      $total_queries = count($queries);
	  $query_count = 0;
	  $successful_queries = 0;
	  $failed_queries = 0;
	  echo "<h4>Database Upgrade Queries:</h4>";
      foreach ($queries as $query) {
		$query_count++;
        if (trim($query)) {
		  echo '<p>' . $query_count . '. ' . $query;
          
		  //execute query:
		  if (mysql_query(trim($query), $link)) {
			$successful_queries++;
            echo " <span style='color:green; font-weight:bold;'>- OK</span></p>\n";
          } else {
			$failed_queries++;
			echo " <span style='color:red; font-weight:bold;'>- FAIL</span><br>\n";
            echo "<span style='color:red; text-decoration:underline;'>" . mysql_error(). "</span></p>\n";
          } // if
		  $executed_queries++;
		  
        } // if
      } // if
      
      $summary = array(
	  					'total_queries' => $total_queries,
						'executed_queries' => $executed_queries,
						'successful_queries' => $successful_queries,
						'failed_queries' => $failed_queries
					   );
	  return $summary;
    } // executeMultipleQueries
?>
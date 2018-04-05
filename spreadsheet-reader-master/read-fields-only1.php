<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '-1');
set_time_limit(3600);


$filename = 'create_main.sql';
unlink($filename);
$handle = fopen($filename, 'a') or die('Cannot open file:  '.$filename);	
	// If you need to parse XLS files, include php-excel-reader
	//require('php-excel-reader/excel_reader2.php');

	require('SpreadsheetReader.php');

	//$spreadsheet_reader = new SpreadsheetReader('Product_Spec_Migration-fields-only.xlsx');
	$spreadsheet_reader = new SpreadsheetReader('Product_Spec_Migration.xlsx');

	foreach ($spreadsheet_reader as $Row)
	{
		print '<pre>';
		

			foreach($Row as $key=>$field){
				print $key . " " . $field . "<br/>";
				//if($key <= 1454){
					//if( trim($field) != ""){
						//$array_element = trim($field);
						//$array_key = $key;
						//$string_for_array = '"' . $array_key . '"XX"' . $array_element . '",';
						//print $string_for_array;
						//print "<br/>";
						//$insert_string = "`" . trim($field) . "` text,";
						//print $insert_string;
						//print "\r\n";
						//print $insert_string;						
					//}

					//fwrite($handle, $insert_string);
					//print $field;
					//print "<br/>";
					//print "\r\n";					
				//}
				

				//print $insert_string;
				//fclose($handle);
			}
			

		print '</pre>';
	}

	
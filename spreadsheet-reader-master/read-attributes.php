<?php
// Read attributes from Excel and create SQL file with insert statements
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '-1');
set_time_limit(3600);

$set_to_read = $_GET['set'];
switch(strtolower($set_to_read)){
	case "a":
		$filename = 'add_products_attributes-1-499.sql';
		$filetoread = 'Product_Spec_Migration-1-499.xlsx';
		break;
	case "b":
		$filename = 'add_products_attributes-500-999.sql';
		$filetoread = 'Product_Spec_Migration-500-999.xlsx';
		break;	
	case "c":
		$filename = 'add_products_attributes-1000-1499.sql';
		$filetoread = 'Product_Spec_Migration-1000-1499.xlsx';
		break;	
	case "d":
		$filename = 'add_products_attributes-1500-1999.sql';
		$filetoread = 'Product_Spec_Migration-1500-1999.xlsx';
		break;	
	case "e":
		$filename = 'add_products_attributes-2000-2279.sql';
		$filetoread = 'Product_Spec_Migration-2000-2279.xlsx';
		break;			
}

unlink($filename);
$handle = fopen($filename, 'w') or die('Cannot open file:  '.$filename);	


// If you need to parse XLS files, include php-excel-reader
//require('php-excel-reader/excel_reader2.php');

include ('functions.php'); // contains pre-determined array of data fields for attributes
	
	require('SpreadsheetReader.php');

	$spreadsheet_reader = new SpreadsheetReader($filetoread);
	
	foreach ($spreadsheet_reader as $Row){
		print '<pre>';

		$handle = fopen($filename, 'a') or die('Cannot open file:  '.$filename);
			foreach($Row as $key=>$field){
				
				if($key <= 1454){
					
					$record_id = $Row[0];
				
					if( $key >= 4 ){
						$product_attribute = $fields_array[$key]; // $fields_array contains the column names from the original Excel file
						if( $field != ""){
							$product_attribute_value = trim($field);
							$insert_string = "INSERT INTO `pd_products_attributes_beta` (`Product_ID`,`Product_Attribute`,`Product_Attribute_Value`) VALUES ('".$record_id."','".$product_attribute."','".$product_attribute_value."');"; 
							$insert_string .= "\r\n";
							
							fwrite($handle, $insert_string);	
							$insert_string = "";
						}
					}
				}
			}
			
			// close file
			fclose($handle);			

		print '</pre>';
	}

	
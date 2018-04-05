<?php

/*
* build_nav
* @param $products Object with arrays
*/
function build_nav( $products_object, $category = "lasers" ){
	switch( $category ){
		case "lasers":
			$category_header = "Lasers";
			break;
		case "components":
			$category_header = "Components";
			break;
		case "tools_systems":
			$category_header = "Tools & Systems";
			break;
	}
	$products_items_array = array(); // array to hold individual arrays
	
	$products_columns_array = array("Product Name","Application","Technology","Wavelength","Power","Mode","Pulse Width","Compare");
	
	foreach( $products_object as $key=>$value){
		
		$product_name = trim(preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $value->Name));
		$products_items_columns = array(
			"product_name"=>$product_name,
			"application"=>$value->application,
			"technology"=>"OPS",
			"wavelength"=>$value->wavelength,
			"power"=>$value->power,
			"mode"=>$value->mode,
			"pulse_width"=>$value->pulse_width,
			"url"=>$value->url,
			"compare"=>"<compare_checkbox>",
		);			
		$products_items_array[] = $products_items_columns;
	}
	
	$products_array = array("name"=>$category_header,"columns"=>$products_columns_array,"items"=>$products_items_array);	
	//$categories = array("categories"=>array($products_array));
	return $products_array;	
}

function build_nav_lmc( $products ){

	$products_array = array("name"=>"Laser Measurement","columns"=>$products_columns_array,"items"=>$products_items_array);
	
	$categories = array("categories"=>array($products_array));
	
	$energy_sensors_items = array();
	
	// iterate through all the Energy Products and make multidimentional array
	foreach( $products as $product){
		
		$url = $product->url;
		$energy_sensors_items[] = array(
			"url"=>$url, 
			"columns"=>"energy_sensors:".$product->Name,
					"detector_diameter:".$product->detector_diameter,
					"max_energy:" . $product->max_energy,
					"min_wavelength:" . $product->min_wavelength,
					"max_wavelength:". $product->max_wavelength,
					"max_repetition_rate:". $product->max_repetition_rate
		);		
	}
		//print_r($energy_sensors_items);
		$lmc_items_columns1 = array(
			"energy_sensors"=>"Excimer: Energy Max Sensors",
			"detector_diameter"=>"50/25",
			"min_energy"=>"500 µJ",
			"max_energy"=> "1 J",
			"min_wavelength"=>"0.19",
			"max_wavelength"=>"0.266",
			"max_repetition_rate"=>"200"
		);
		$lmc_items_columns2 = array(
			"energy_sensors"=>"High Rep-Rate: Energy Max Sensors",
			"detector_diameter"=>"50/25/10",
			"min_energy"=>"500 µJ",
			"max_energy"=> "1 J",
			"min_wavelength"=>"0.193",
			"max_wavelength"=>"2.1",
			"max_repetition_rate"=>"10000"
		);	
		$lmc_items_columns3 = array(
			"energy_sensors"=>"Multipurpose: Energy Max Sensors",
			"detector_diameter"=>"50/25/10",
			"min_energy"=>"1 mJ",
			"max_energy"=> "2 J",
			"min_wavelength"=>"0.19",
			"max_wavelength"=>"12",
			"max_repetition_rate"=>"300"
		);		
		$energy_sensors_columns = array("Energy Sensors",
			"Detector Diameter",
			"Min. Energy",
			"Max. Energy",
			"Min. Wavelength",
			"Max. Wavelength",
			"Max. Repetition Rate"
		);
		$power_sensors_columns = array("Power Sensors",
			"Detector Diameter",
			"Min. Energy",
			"Max. Energy",
			"Min. Wavelength",
			"Max. Wavelength",
			"Max. Repetition Rate"
		);	
		$power_energy_columns = array("Power & Energy Meters",
			"Measurement Type",
			"Statistics",
			"Data Logging",
			"Graphing",
			"PC Interface"
		);		
		/*
		$energy_sensors_items = array(
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$lmc_items_columns1),	
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$lmc_items_columns2),
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$lmc_items_columns3),			
		);
		$power_sensors_items = array(
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$lmc_items_columns1),	
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$lmc_items_columns2),
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$lmc_items_columns3),			
		);		
		$power_energy_items = array(
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$lmc_items_columns1),	
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$lmc_items_columns2),
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$lmc_items_columns3),			
		);		
		
		$lmc_subcategories = array(
			array("name"=>"Energy Sensors","image"=>"/assets/site_images/energy-sensors.jpg","columns"=>$energy_sensors_columns,"items"=>$energy_sensors_items),
			array("name"=>"Power Sensors","image"=>"/assets/site_images/power-sensors.jpg","columns"=>$power_sensors_columns,"items"=>$power_sensors_items),
			array("name"=>"Power & Energy Meters","image"=>"/assets/site_images/power-energy-meters.jpg","columns"=>$power_energy_columns,"items"=>$power_energy_items)
			);
			
		$laser_measurement_array = array("name"=>"Laser Measurement","sub_categories"=>$lmc_subcategories);	
		*/
	return $laser_measurement_array;	
}


function build_nav_json(){

		$categories_array =  array("name"=>"Lasers","Components","Laser Measurement","Tools & Systems");
		$columns_array = array("Product Name","Application","Technology","Wavelength","Power","Mode","Pulse Width","Compare");
		$lmc_subcategories = array("name"=>"Energy Sensors","image"=>"/assets/site_images/energy-sensors.jpg");
		
		// Items columns
		// Items are individual products
		$laser_items_columns = array(
			"product_name"=>"Astrella",
			"application"=>"Scientific",
			"technology"=>"OPS",
			"wavelength"=>"Deep UV",
			"power"=>"< 100 mW",
			"mode"=>"CW",
			"pulse_width"=>"Nano",
			"compare"=>"<compare_checkbox>",
		);

		// this array needs to be built dynamically
		$lasers_items_array = array(
			array("url"=>"https://www.coherent.com/lasers/laser/astrella-ultrafast-tisapphire-amplifier","columns"=>$laser_items_columns),
			array("url"=>"https://www.coherent.com/lasers/laser/industrial-short-pulse-lasers/avia-lx-compact-dpss-lasers","columns"=>$laser_items_columns),
			array("url"=>"https://edge.coherent.com/assets/product_images/IMG_DiamondGEM-100_850x850_0915.jpg","columns"=>$laser_items_columns)
		);
		$lasers_array = array("name"=>"Lasers","columns"=>$columns_array,"items"=>$lasers_items_array);
		
		$components_items_columns1 = array(
			"product_name"=>"Component One",
			"column_name"=>"Scientific",
			"technology"=>"OPS",
			"wavelength"=>"Deep UV",
			"power"=>"< 100 mW",
			"mode"=>"CW",
			"pulse_width"=>"Nano",
			"compare"=>"<compare_checkbox>"
		);
		
		$components_items_columns2 = array(
			"product_name"=>"Component Two",
			"column_name"=>"Microelectronics",
			"technology"=>"Diode",
			"wavelength"=>"UV",
			"power"=>"100-499",
			"mode"=>"Pulsed",
			"pulse_width"=>"Pico",
			"compare"=>"<compare_checkbox>"
		);
		$components_items_columns3 = array(
			"product_name"=>"Component Three",
			"column_name"=>"Defense",
			"technology"=>"DPSS",
			"wavelength"=>"Violet",
			"power"=>"100-499",
			"mode"=>"Pulsed",
			"pulse_width"=>"Pico",
			"compare"=>"<compare_checkbox>"
		);		
		$components_items_array = array(
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$components_items_columns1),
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$components_items_columns2),
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$components_items_columns3)			
		);
		$components_array = array("name"=>"Components","columns"=>$columns_array,"items"=>$components_items_array);
		
		
		$lmc_items_columns1 = array(
			"energy_sensors"=>"Excimer: Energy Max Sensors",
			"detector_diameter"=>"50/25",
			"min_energy"=>"500 µJ",
			"max_energy"=> "1 J",
			"min_wavelength"=>"0.19",
			"max_wavelength"=>"0.266",
			"max_repetition_rate"=>"200"
		);
		$lmc_items_columns2 = array(
			"energy_sensors"=>"High Rep-Rate: Energy Max Sensors",
			"detector_diameter"=>"50/25/10",
			"min_energy"=>"500 µJ",
			"max_energy"=> "1 J",
			"min_wavelength"=>"0.193",
			"max_wavelength"=>"2.1",
			"max_repetition_rate"=>"10000"
		);	
		$lmc_items_columns3 = array(
			"energy_sensors"=>"Multipurpose: Energy Max Sensors",
			"detector_diameter"=>"50/25/10",
			"min_energy"=>"1 mJ",
			"max_energy"=> "2 J",
			"min_wavelength"=>"0.19",
			"max_wavelength"=>"12",
			"max_repetition_rate"=>"300"
		);		
		$lmc_subcategories_columns = array("Energy Sensors",
			"Detector Diameter",
			"Min. Energy",
			"Max. Energy",
			"Min. Wavelength",
			"Max. Wavelength",
			"Max. Repetition Rate"
		);
		$lmc_subcategories_items = array(
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$lmc_items_columns1),	
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$lmc_items_columns2),
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$lmc_items_columns3),			
		);
		$lmc_subcategories_items2 = array(
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$lmc_items_columns1),	
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$lmc_items_columns2),
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure","columns"=>$lmc_items_columns3),			
		);		
		
		
		$lmc_subcategories = array(
			array("name"=>"Energy Sensors","image"=>"/assets/site_images/energy-sensors.jpg","columns"=>$lmc_subcategories_columns,"items"=>$lmc_subcategories_items),
			array("name"=>"Power Sensors","image"=>"/assets/site_images/power-sensors.jpg","columns"=>$lmc_subcategories_columns,"items"=>$lmc_subcategories_items2),
			array("name"=>"Power & Energy Meters","image"=>"/assets/site_images/power-energy-meters.jpg","columns"=>$lmc_subcategories_columns,"items"=>$lmc_subcategories_items2)
			);
			
		$laser_measurement_array = array("name"=>"Laser Measurement","sub_categories"=>$lmc_subcategories);
		
		$tools_systems_items_columns = array(
			"product_name"=>"Tool One",
			"column_name"=>"Scientific",
			"technology"=>"OPS",
			"wavelength"=>"Deep UV",
			"power"=>"< 100 mW",
			"mode"=>"CW",
			"pulse_width"=>"Nano",
			"compare"=>"<compare_checkbox>"
		);
		$tools_systems_items_columns2 = array(
			"product_name"=>"Tool Two",
			"column_name"=>"Microelectronics",
			"technology"=>"Diode",
			"wavelength"=>"UV",
			"power"=>"100-499",
			"mode"=>"Pulsed",
			"pulse_width"=>"Pico",
			"compare"=>"<compare_checkbox>"
		);
		$tools_systems_items_columns3 = array(
			"product_name"=>"Tool Three",
			"column_name"=>"Defense",
			"technology"=>"DPSS",
			"wavelength"=>"Violet",
			"power"=>"500-1W",
			"mode"=>"Pulsed",
			"pulse_width"=>"Nano",
			"compare"=>"<compare_checkbox>"
		);
		
		$tools_systems_items = array(
			array(
				"url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure",
				"columns"=>$tools_systems_items_columns
			),
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure",
			"columns"=>$tools_systems_items_columns2),
			array("url"=>"https://www.coherent.com/lasers/laser/continuous-wave-cw/azure",
			"columns"=>$tools_systems_items_columns3)
		);
		
		$tools_systems_columns = array(
			"Product Name",
			"Column Name",
			"Technology",
			"Wavelength",
			"Power",
			"Mode",
			"Pulse Width",
			"Compare"
		);
		$tools_systems_array = array(
			"name"=>"Tools & Systems",
			"columns"=>$tools_systems_columns,
			"items"=>$tools_systems_items
		);		

	$nav = array("categories"=>array($lasers_array, $components_array, $laser_measurement_array, $tools_systems_array));		
	return $nav;
}
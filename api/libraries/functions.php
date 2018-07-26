<?php

/*
* build_nav
* @param $products Object with arrays
*/
function build_nav( $products_object, $category = "lasers" ){
	switch( $category ){
		case "lasers":
			$category_header = "Lasers";
			$applications_key_filter = "Lasers Applications Filter List";
			$technology_key_filter = "Lasers Technology Filter List";
			$wavelength_key_filter = "Lasers Wavelength Filter List";
			$pulse_width_key_filter = "Lasers Pulse Width Filter List";
			break;
		case "components":
			$category_header = "Components";
			$applications_key_filter = "Components Applications Filter List";
			$technology_key_filter = "Components Technology Filter List";	
			$wavelength_key_filter = "Components Wavelength Filter List";	
			$pulse_width_key_filter = "Components Pulse Width Filter List";			
			break;
		case "tools_systems":
			$category_header = "Tools & Systems";
			$applications_key_filter = "Tools & Systems Applications Filter List";
			$technology_key_filter = "Tools & Systems Technology Filter List";
			$wavelength_key_filter = "Tools & Systems Wavelength Filter List";
			$pulse_width_key_filter = "Tools & Systems Pulse Width Filter List";	
			$material_thickness_key_filter = "";
			$material_type_key_filter = "";
			$motion_type_key_filter = "";
			$max_work_area_key_filter = "";
			break;
	}
	$products_items_array = array(); // array to hold individual arrays
	
	$applications_array = "";
	$technology_array = "";
	$wavelength_array = "";
	$pulse_width_array = "";
	$mode_array = "";
	$power_array = "";
	
	$products_columns_array = array("Product Name","Application","Technology","Wavelength","Power","Mode","Pulse Width");
	
	foreach( $products_object as $key=>$value){
		
		$product_name = trim(preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $value->Name));
		if(strlen(trim( $value->power )) > 0){
			$power =  trim(preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $value->power));
			$power_item_array = explode(",",$power);
			$power = trim(max($power_item_array));
		}else{
			$power =  "";
		}
		/*
		if( !empty($value->technology) ){
			$technology =  trim(preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $value->technology));
			$technology_array[] = $technology;
		}else{
			$technology =  "";
		}
		*/
		if( !empty($value->wavelength) ){
			$wavelength =  $value->wavelength;
			$wavelength_array[] = $wavelength;
		}else{
			$wavelength =  "";
		}
		if( !empty($value->mode) ){
			$mode =  $value->mode;
		}else{
			$mode =  "";
		}
		// Pulse width is stored in the database as a comma delimited string
		// split string into an array and then use this array 
		if( !empty($value->pulse_width) ){
			$pulse_width = trim($value->pulse_width);
			//$pulse_width =  $value->pulse_width;
			$pulse_width = explode(",",$pulse_width);
			foreach( $pulse_width as $indie_value){
				$pulse_width_array[] = $indie_value;
			}			
		}else{
			$pulse_width =  "";
		}	
		
		// URL
		if( !empty($value->url)){
			$url =  $value->url;
		}else{
			$url =  "";
		}	
		
		// Begin section where filter arrays/lists are created
		
		// Applications

		print_r($value->application);
		if( !empty($value->application)){
			$application =  $value->application;
			$application_array =  explode(",",$application);
			if( is_array($application_array) ){
				foreach( $application_array as $indie_value){
					$application_array[] = ltrim($indie_value);
				}
			}			
		}else{
			$application =  "";
		}
		/*
		if( is_array($value->application) ){
			$application =  implode(",",$value->application);
			foreach( $value->application as $indie_value){
				$applications_array[] = $indie_value;
			}
		}else{
			$application =  "";
		}
		*/
		// Technology
		if( !empty(trim($value->technology)) || strlen($value->technology) > 0){
			$technology =  trim(preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $value->technology));
			$technology =  explode(",",$technology);
			if( is_array($technology) ){
				foreach( $technology as $indie_value){
					$technology_array[] = ltrim($indie_value);
				}
			}else{
				$technology_array[] = ltrim($technology);
			}
		}		

		// Power
		
		if( !empty(trim($value->power)) || strlen($value->power) > 0){
			$power_value =  trim(preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $value->power));
			$power_value =  explode(",",$power_value);

			if( is_array($power_value) ){
				foreach( $power_value as $indie_value){
					if( !empty($indie_value) ){
						$power_array[] = ltrim($indie_value);	
					}				
				}
			}else{
				$power_array[] = ltrim($power);
			}
		}
		

		// Mode
		if( !empty(trim($value->mode)) || strlen($value->mode) > 0){
			$mode =  trim(preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $value->mode));
			$mode =  explode(",",$mode);
			if( is_array($mode) ){
				foreach( $mode as $indie_value){
					$mode_array[] = ltrim($indie_value);
				}
			}else{
				$mode_array[] = ltrim($mode);
			}
		}

		// MATERIALS TYPE
		if( !empty($value->materials)){
			$materials =  $value->materials;
			$materials_array =  explode(",",$materials);
			if( is_array($materials_array) ){
				foreach( $materials_array as $indie_value){
					$material_type_key_filter[] = ltrim($indie_value);
				}
			}
		}else{
			$materials =  "";
		}
		// MATERIAL THICKNESS
		if( !empty($value->material_thickness)){
			$material_thickness =  $value->material_thickness;
			$material_thickness_array =  explode(",",$material_thickness);
			if( is_array($material_thickness_array) ){
				foreach( $material_thickness_array as $indie_value){
					$material_thickness_key_filter[] = ltrim($indie_value);
				}
			}			
		}else{
			$material_thickness =  "";
		}	

		// MOTION TYPE
		if( !empty($value->motion_type)){
			$motion_type =  $value->motion_type;
			$motion_type_array =  explode(",",$motion_type);
			if( is_array($motion_type_array) ){
				foreach( $motion_type_array as $indie_value){
					$motion_type_key_filter[] = ltrim($indie_value);
				}
			}			
		}else{
			$motion_type =  "";
		}	
		
		// MAX WORK AREA
		if( !empty($value->max_work_area)){
			$max_work_area =  $value->max_work_area;
			$max_work_area_array =  explode(",",$max_work_area);
			if( is_array($max_work_area_array) ){
				foreach( $max_work_area_array as $indie_value){
					$max_work_area_key_filter[] = ltrim($indie_value);
				}
			}			
		}else{
			$max_work_area =  "";
		}			
		
		// PRECISION
		if( !empty($value->precision)){
			$precision =  $value->precision;
			$precision_array =  explode(",",$precision);
			if( is_array($precision_array) ){
				foreach( $precision_array as $indie_value){
					$precision_key_filter[] = ltrim($indie_value);
				}
			}			
		}else{
			$precision =  "";
		}		
		
		// End section where filter arrays/lists are created
		
		switch( $category ){
			case "components":
				$products_columns_array = array("Product Name","Application","Technology","Wavelength","Power","Mode","Pulse Width");
				$products_items_columns = array(
					"product_name"=>$product_name,
					"application"=>$application,
					"technology"=>$technology,
					"wavelength"=>$wavelength,
					"power"=>$power,
					"mode"=>$mode,
					"pulse_width"=>$pulse_width
				);
			break;
			case "lasers":
				$products_columns_array = array("Product Name","Technology","Wavelength","Power","Mode","Pulse Width");
				$products_items_columns = array(
					"product_name"=>$product_name,
					"technology"=>$technology,
					"wavelength"=>$wavelength,
					"power"=>$power,
					"mode"=>$mode,
					"pulse_width"=>$pulse_width
				);
			break;
			case "tools_systems":
				$products_columns_array = array("Product Name","Application","Material Type","Material Thickness","Motion Type","Max. Work Area","Precision");
				$products_items_columns = array(
					"product_name"=>$product_name,
					"application"=>$application,
					"materials"=>$materials,
					"material_thickness"=>$material_thickness,
					"motion_type"=>$motion_type,
					"max_work_area"=>$max_work_area,
					"precision"=>$precision
				);
			break;
			
		}
		
		//$products_items_array[] = $products_items_columns;
		$products_items_array[] = array("url"=>$url,"columns"=>$products_items_columns);
	}
	$applications_array = array_unique($applications_array);
	sort($applications_array);
	
	$technology_array = array_unique($technology_array);
	sort($technology_array);

	$wavelength_array = array_unique($wavelength_array);
	sort($wavelength_array);	
	
	$pulse_width_array = array_unique($pulse_width_array);
	sort($pulse_width_array);	
	
	$mode_array = array_unique($mode_array);
	sort($mode_array);	

	$power_array = array_unique($power_array);
	sort($power_array);

	$material_thickness_key_filter = array_unique($material_thickness_key_filter);
	sort($material_thickness_key_filter);
	
	$material_type_key_filter = array_unique($material_type_key_filter);
	sort($material_type_key_filter);	
	
	$motion_type_key_filter = array_unique($motion_type_key_filter);
	sort($motion_type_key_filter);
	
	$max_work_area_key_filter = array_unique($max_work_area_key_filter);
	sort($max_work_area_key_filter);
	
	$precision_key_filter = array_unique($precision_key_filter); 
	sort($precision_key_filter);
	
	// 04.10.2018 Added key "html_row"
	$products_array = array(
		"name"=>$category_header,
		"html_row"=>"",
		"columns"=>$products_columns_array,
		"items"=>$products_items_array,
		"application_key_filter"=>$applications_array,
		"technology_key_filter"=>$technology_array,
		"wavelength_key_filter"=>$wavelength_array,
		"pulse_width_key_filter"=>$pulse_width_array,
		"mode_key_filter"=>$mode_array,
		"power_key_filter" => $power_array,
		"material_thickness_key_filter"=>$material_thickness_key_filter,
		"materials_key_filter" => $material_type_key_filter,
		"motion_type_key_filter" => $motion_type_key_filter,
		"max_work_area_key_filter" => $max_work_area_key_filter,
		"precision_key_filter" => $precision_key_filter
		);	
	//$categories = array("categories"=>array($products_array));

	return $products_array;	
}

function build_nav_lmc( $products, $subcategory ){
	
	$energy_sensors_items = array();

	// iterate through all the Energy Products and make multidimentional array
	foreach( $products as $product){
		
		switch($subcategory){		
			case "Energy Sensors":
				// Ensure that NULL values are addressed
				if( !empty($product->url) ){
					$url =  $product->url;
				}else{
					$url =  "";
				}	

				if( !empty($product->min_energy) ){
					$min_energy =  $product->min_energy;
				}else{
					$min_energy =  "";
				}
				if( !empty($product->max_energy) ){
					$max_energy =  $product->max_energy;
				}else{
					$max_energy =  "";
				}
				
				if( !empty($product->repetition_rate_max) ){
					$repetition_rate_max =  $product->repetition_rate_max;
				}else{
					$repetition_rate_max =  "";
				}
				if( !empty($product->aperture_size) ){
					$aperture_size =  $product->aperture_size;
				}else{
					$aperture_size =  "";
				}	
				if( !empty($product->wavelength) ){
					$wavelength =  $product->wavelength;
				}else{
					$wavelength =  "";
				}
				if( !empty($product->pulse_width) ){
					$pulse_width =  $product->pulse_width;
				}else{
					$pulse_width =  "";
				}				
				$energy_sensors_items[] = array(
					"url"=>$url, 
					"columns"=>array("energy_sensors"=>$product->Name,
							"wavelength"=>$wavelength,
							"aperture_size"=>$aperture_size,
							"min_energy"=>$min_energy,
							"max_energy"=>$max_energy,
							"wavelength"=>$wavelength,
							"repetition_rate"=>$repetition_rate_max,							
							"pulse_width"=>$pulse_width
							)
				);	

				
				break;
			case "Power Sensors":
				// Ensure that NULL values are addressed
				if( !empty($product->url) ){
					$url =  $product->url;
				}else{
					$url =  "";
				}					
				
				if( !empty($product->aperture_size) ){
					$aperture_size =  $product->aperture_size;
				}else{
					$aperture_size =  "";
				}	
				if( !empty($product->wavelength) ){
					$wavelength =  $product->wavelength;
				}else{
					$wavelength =  "";
				}
				if( !empty($product->pulse_width) ){
					$pulse_width =  $product->pulse_width;
				}else{
					$pulse_width =  "";
				}	
				if( !empty($product->power_min) ){
					$power_min =  $product->power_min;
				}else{
					$power_min =  "";
				}	
				if( !empty($product->power_max) ){
					$power_max =  $product->power_max;
				}else{
					$power_max =  "";
				}
				if( !empty($product->cooling_width) ){
					$cooling_width =  $product->cooling_width;
				}else{
					$cooling_width =  "";
				}				
				$energy_sensors_items[] = array(
					"url"=>$url, 
					"columns"=>array("energy_sensors"=>$product->Name,
							"wavelength"=>$wavelength,
							"aperture_size"=>$aperture_size,
							"min_power"=>$power_min,
							"max_energy"=>$power_max,
							"wavelength"=>$wavelength,
							"cooling_width"=>$cooling_width
							)
				);	
					
			break;
		
		case "Power & Energy Meters":
				// Ensure that NULL values are addressed
				if( !empty($product->url) ){
					$url =  $product->url;
				}else{
					$url =  "";
				}					
				
				if( !empty($product->repetition_rate_max) ){
					$repetition_rate_max =  $product->repetition_rate_max;
				}else{
					$repetition_rate_max =  "";
				}	
				if( !empty($product->pc_interface) ){
					$pc_interface =  $product->pc_interface;
				}else{
					$pc_interface =  "";
				}	
				if( !empty($product->measurement_type) ){
					$measurement_type =  $product->measurement_type;
				}else{
					$measurement_type =  "";
				}	
				if( !empty($product->uncertainty) ){
					$uncertainty =  $product->uncertainty;
				}else{
					$uncertainty =  "";
				}				
				$energy_sensors_items[] = array(
					"url"=>$url, 
					"columns"=>array("energy_sensors"=>$product->Name,
							"repetition_rate_max"=>$repetition_rate_max,
							"pc_interface"=>$pc_interface,
							"measurement_type"=>$measurement_type,
							"uncertainty"=>$uncertainty
							)
				);	
					
			break;	
			
		case "Beam Diagnostics":
				// Ensure that NULL values are addressed
				if( !empty($product->url) ){
					$url =  $product->url;
				}else{
					$url =  "";
				}		
				if( !empty($product->wavelength) ){
					$wavelength =  $product->wavelength;
				}else{
					$wavelength =  "";
				}				
				if( !empty($product->beam_diameter) ){
					$beam_diameter =  $product->beam_diameter;
				}else{
					$beam_diameter =  "";
				}		
				if( !empty($product->active_area) ){
					$active_area =  $product->active_area;
				}else{
					$active_area =  "";
				}					
				if( !empty($product->pixel_size) ){
					$pixel_size =  $product->pixel_size;
				}else{
					$pixel_size =  "";
				}		
				if( !empty($product->laser_type) ){
					$laser_type =  $product->laser_type;
				}else{
					$laser_type =  "";
				}						
							
				$energy_sensors_items[] = array(
					"url"=>$url, 
					"columns"=>array("energy_sensors"=>$product->Name,
							"wavelength"=>$wavelength,
							"beam_diameter"=>$beam_diameter,
							"active_area"=>$active_area,
							"pixel_size"=>$pixel_size,
							"laser_type"=>$laser_type
							)
				);	
					
			break;			
			
		}
	}
		
		switch($subcategory){
			case "Energy Sensors":
				$sub_category_image = "/assets/site_images/energy-sensors.jpg";
				$sub_category_columns = array("Energy Sensors",
					"Wavelength",
					"Aperture Size",
					"Min. Energy",
					"Max. Energy",
					"Repetition Rate",
					"Laser Pulse Width"
				);
				break;
			case "Power Sensors":
				$sub_category_image = "/assets/site_images/power-sensors.jpg";
				$sub_category_columns = array("Power Sensors",
					"Wavelength",
					"Aperture Size",
					"Min. Power",
					"Max. Power",
					"Cooling Method"
				);	
				break;
			case "Power & Energy Meters":
				$sub_category_image = "/assets/site_images/power-energy-meters.jpg";
				$sub_category_columns = array("Power & Energy Meters",
					"Repetition Rate",
					"Computer Interface",
					"Measurement Type",
					"Calibration Uncertainty"
				);	
				break;
			case "Beam Diagnostics":
				$sub_category_image = "/assets/site_images/power-energy-meters.jpg";
				$sub_category_columns = array($subcategory,
					"Wavelength",
					"Beam Diameter",
					"Active Area",
					"Pixel Size",
					"Laser Type"
				);				
				break;
		}
		
		$lmc_subcategories = array("name"=>$subcategory,"image"=>$sub_category_image,"columns"=>$sub_category_columns,"items"=>$energy_sensors_items);
		
	return $lmc_subcategories;	
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
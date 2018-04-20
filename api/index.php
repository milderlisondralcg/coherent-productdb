<?php
include("config/config.php");
include("config/database.php");
include("libraries/functions.php");
include("models/products.php");

// instantiate database and product object
$database = new Database();
$db_conn = $database->get_connection();

$products_obj = new Products($db_conn);
$products_list = $products_obj->get_products();

$action = $_GET["action"];
$id = $_GET["id"];
if( isset($_GET["output"]) ){
	$output = "explode";
}
$output = "json";

$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
//var_dump(parse_url($url));


switch( $action ){
	case "products-nav-explode":
		$filename = "product-nav.json";
		$nav = build_nav_json();
		$handle = fopen($filename, 'w') or die('Cannot open file:  '.$filename);	
		print_r($nav);
		$string_to_write = json_encode($nav);
		fwrite($handle, $string_to_write);
		fclose($handle);		
		break;
	case "products-nav":
		$nav = build_nav_json();
		print json_encode($nav);
		break;
	case "products":
		$products_list = $products_obj->get_products();
		if( $output == "explode"){
			print_r($products_list);
		}else{
			print json_encode($products_list);
		}
		break;
	case "lmc":
		$lmc_list_energy = $products_obj->get_lmc_nav_products('Energy'); // LMC
		$lmc_list_power = $products_obj->get_lmc_nav_products('Power'); // LMC
		$lmc_list_meter = $products_obj->get_lmc_nav_products('Meters'); // LMC
		$energy_subcategory = build_nav_lmc($lmc_list_energy, "Energy Sensors");
		$power_subcategory = build_nav_lmc($lmc_list_power, "Power Sensors");
		$meter_subcategory = build_nav_lmc($lmc_list_meter, "Power & Energy Meters");
		$sub_categories = array($energy_subcategory,$power_subcategory);

		print json_encode($sub_categories);
		//$lmc_list_total = array("name"=>"Laser Measurement","sub_categories"=>build_nav_lmc($lmc_list_power));
/* 		if( $_GET['type'] == "energy" ){
			//print_r($lmc_list_energy);
			print_r(build_nav_lmc($lmc_list_energy));
		}else{
			//print_r($lmc_list_power);
			print_r(build_nav_lmc($lmc_list_power));
		} */
		
		break;
	case "get-nav":
	
		$lasers_list = $products_obj->get_products_by_category("lasers"); // Lasers
		$components_list = $products_obj->get_products_by_category("components"); // Components
		$tools_systems_list = $products_obj->get_products_by_category("tools_systems"); // Tools and Systems
		
		
		// LMC Subcategories
		$lmc_list_energy = $products_obj->get_lmc_nav_products('Energy'); // LMC
		$lmc_list_power = $products_obj->get_lmc_nav_products('Power'); // LMC
		$lmc_list_meter = $products_obj->get_lmc_nav_products('Power & Energy Meters'); // LMC
		$lmc_list_beam = $products_obj->get_lmc_nav_beam_products(); // LMC
	
		$energy_subcategory = build_nav_lmc($lmc_list_energy, "Energy Sensors"); // LMC
		$power_subcategory = build_nav_lmc($lmc_list_power, "Power Sensors"); // LMC
		$meters_subcategory = build_nav_lmc($lmc_list_meter, "Power & Energy Meters"); // LMC
		$beam_subcategory = build_nav_lmc($lmc_list_beam, "Beam Diagnostics"); // LMC
		
		// END LMC Subcategories
		
		
		//$lmc_list_total = array("name"=>"Laser Measurement","sub_categories"=>array(build_nav_lmc($lmc_list_energy),build_nav_lmc($lmc_list_power)));

		$subcategories = array($energy_subcategory,$power_subcategory, $meters_subcategory,$beam_subcategory);
		
		$lmc_html_row1 = array("image"=>"/assets/site_images/laser_measurement_homepage.png",
					"title"=>"Laser Measurement Homepage",
					"text"=>"Coherent's Laser Measurement offering is more than just meters and sensors. Find the perfect product, explore our loyalty programs, and much more.",
					"link_text"=>"Go to Laser Measurement home",
					"link_url"=>"https://www.coherent.com/measurement-control/"
					);
					
		$lmc_html_row2 = array("image"=>"/assets/site_images/support_download_center.png",
					"title"=>"Support and Download Center",
					"text"=>"Your single source for technical information, product manuals, white papers, software downloads, Repair and RMA info, and FAQs.",
					"link_text"=>"Open the Support and Download Center",
					"link_url"=>"https://www.coherent.com/support"
					);					
		$lmc_html_row3 = array("image"=>"/assets/site_images/support_download_center.png",
					"title"=>"Support and Download Center",
					"text"=>"Your single source for technical information, product manuals, white papers, software downloads, Repair and RMA info, and FAQs.",
					"link_text"=>"Open the Support and Download Center",
					"link_url"=>"https://www.coherent.com/support"
					);					
					
		$lmc_list_total = array("name"=>"Laser Measurement","html_row"=>array($lmc_html_row1,$lmc_html_row2, $lmc_html_row3),"sub_categories"=>$subcategories);


			$full_list = array("categories"=>array(
			build_nav($lasers_list, "lasers"),
			build_nav($components_list, "components"),
			build_nav($tools_systems_list, "tools_systems"),
			$lmc_list_total
			));

			
		$filename = "product-nav.json";
		$handle = fopen($filename, 'w') or die('Cannot open file:  '.$filename);
		$string_to_write = json_encode($full_list);
		fwrite($handle, $string_to_write);
		fclose($handle);		
		
		break;
	case "get-products-by-category":
		$category = "lasers";
		$cat = "lasers";
		if( isset($_REQUEST["category"]) ){
			$cat = trim($_REQUEST["category"]);
		}
		$products_list = $products_obj->get_products_by_category($cat);
		if( $cat != "lmc"){
			$response = build_nav($products_list, $cat);
		}else{
			$response = build_nav_lmc($products_list);
		}
		//$response = build_nav($products_list);
		switch( $cat ){
			case "lasers":
				$filename = "product-nav-lasers.json";
				break;
			case "components":
				$filename = "product-nav-components.json";
				break;
			case "lmc":
				$filename = "product-nav-lmc.json";
				break;
			case "tools_systems":
				$filename = "product-nav-tools-systems.json";
				break;				
		}
		$handle = fopen($filename, 'w') or die('Cannot open file:  '.$filename);
		$string_to_write = json_encode($response);
		fwrite($handle, $string_to_write);
		fclose($handle);
		
		print json_encode($response);
		break;	
	case "milder";
		print "milder";
		break;
	case "":
		$categories = $products_obj->get_categories();
		print json_encode($categories);
		break;
}
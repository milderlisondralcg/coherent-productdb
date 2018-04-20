<?php

class Products{
 
    // database connection and table name
    private $conn;
	private $general = "pd_products_general";
	private $products_categories = "pd_products_categories";
	private $applications = "pd_applications";
	private $attributes = "pd_products_attributes";
	private $products_families = "pd_products_families";
	
	private $view_products = "view_products_by_categories";
	private $view_products_applications = "view_applications_by_product";
	private $view_products_by_families = "view_products_by_families";
 
    // object properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;

	
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	public function get_products(){
		
		$sql= "SELECT `ID`,`Name`,`Acquired_Site` FROM `" .  $this->general . "`";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		//$results =  $stmt->fetchAll();
		$results = array();
		while ($row = $stmt->fetchObject()) {
			$product_id = $row->ID;
			$results[$product_id] = $row;
		}
		return $results;
	}
	
	public function get_products_by_category( $category = "lasers"){

		switch( $category ){
			case "lasers":
				$category_id = 33;
				break;
			case "components":
				$category_id = 23;
				break;
			case "lmc":
				$category_id = 43;
				break;
			case "tools_systems":
				$category_id = 53;
				break;
		}

		//$sql= "SELECT `t1`.`ID`, `t1`.`Name` FROM `" .  $this->general . "` t1 LEFT JOIN `" . $this->products_categories . "` t2 ON `t1`.`ID` = `t2`.`Product_ID` WHERE `t2`.`Category_ID` = '".$cat."'";
		$stmt = $this->conn->prepare("SELECT * FROM `".$this->view_products."` WHERE Category_ID = :category_id AND `Show_On_Nav` = 1");
		$stmt->bindValue(':category_id', $category_id);
		$stmt->execute();
		//$stmt->debugDumpParams();
		while ($row = $stmt->fetchObject()) {
			
			$product_id = $row->ID;				
			$attribs = $this->get_product_attributes( $product_id );			
			$row->wavelength = $attribs['WAVELENGTH'];
			$row->power = $attribs['POWER'];
			$row->pulse_width = $attribs['PULSE_WIDTH'];
			$row->mode = $attribs['OPERATIONMODE'];
			$row->url = $attribs['URL'];
			$row->technology = $attribs['TECHNOLOGY'];
			$row->materials = $attribs['MATERIALS'];
			$row->material_thickness = $attribs['MATERIAL_THICKNESS'];
			$row->motion_type = $attribs['MOTION_TYPE'];
			$row->max_work_area = $attribs['MAX_WORK_AREA'];
			$row->precision = $attribs['PRECISION'];	
			$applications = $this->get_applications_by_product( $product_id ); 			
			$row->application = $applications;
			$results[$product_id] = $row;
			
		}
		return $results;
	}
	
	/**
	* get_lmc_nav_products
	* @param string $subcategory
	*/
	public function get_lmc_nav_products( $subcategory = "Energy"){
		
		if( $subcategory == "Energy" || $subcategory == "Power"){
			$stmt = $this->conn->prepare("SELECT * FROM `".$this->view_products."` WHERE `Category_ID` = '43' AND `Show_On_Nav` = 1 AND `Name` LIKE '".$subcategory."%'");
		}else{
			$stmt = $this->conn->prepare("SELECT * FROM `".$this->view_products."` WHERE `Show_On_Nav` = 1  AND (`Name` LIKE '%labmax%'  OR `Name` LIKE '%FieldMax%' OR `Name` LIKE '%FieldMate%'  OR `Name` LIKE '%LaserCheck%' )");
		}
		
		$stmt->bindValue(':cat', $cat, PDO::PARAM_INT);
		$stmt->execute();
		//$stmt->debugDumpParams();
		while ($row = $stmt->fetchObject()) {
			$product_id = $row->ID;
			
			$attribs = $this->get_product_attributes_lmc( $product_id );
			$row->detector_diameter = $attribs['DETECTOR_DIAMETER'];
			$row->min_energy = $attribs['MIN_ENERGY'];
			$row->max_energy = $attribs['MAX_ENERGY'];
			$row->wavelength = $attribs['WAVELENGTH'];
			$row->min_wavelength = $attribs['WAVELENGTH_MIN'];
			$row->max_wavelength = $attribs['WAVELENGTH_MAX'];
			$row->repetition_rate_max = $attribs['REPETITION_RATE_MAX'];
			$row->aperture_size = $attribs['ACTIVE_AREA'];
			$row->pulse_width = $attribs['PULSE_WIDTH_MAX'];
			$row->power_min = $attribs['POWER_MIN'];
			$row->power_max = $attribs['POWER_MAX'];
			$row->cooling_width = $attribs['COOLING_WIDTH'];
			$row->pc_interface = $attribs['PC_INTERFACE'];
			$row->measurement_type = $attribs['MEASUREMENT_TYPE'];
			$row->uncertainty = $attribs['UNCERTAINTY'];
			$row->url = $attribs['URL'];
			$row->product_id = $product_id;
			
			$applications = $this->get_applications_by_product( $product_id ); 
			$row->application = $applications;
			$results[$product_id] = $row;			
		}
		return $results;
	}

	/**
	* get_lmc_nav_beam_products
	*
	*/
	public function get_lmc_nav_beam_products(){
		
		//$stmt = $this->conn->prepare("SELECT * FROM `".$this->products_families."` WHERE `Family_ID` = '13113' AND `Show_On_Nav` = 1 AND `Name` LIKE '".$subcategory."%'");
		$stmt = $this->conn->prepare("SELECT * FROM `".$this->view_products_by_families."` WHERE `Family_ID` = '13113' AND `Show_On_Nav` = 1");
		
		$stmt->bindValue(':cat', $cat, PDO::PARAM_INT);
		$stmt->execute();
		//$stmt->debugDumpParams();
		while ($row = $stmt->fetchObject()) {
			$product_id = $row->ID;
			
			$attribs = $this->get_product_attributes_lmc( $product_id );
			$row->wavelength = $attribs['WAVELENGTH'];
			$row->beam_diameter = $attribs['BEAM_DIAMETER'];
			$row->active_area = $attribs['ACTIVE_AREA'];
			$row->pixel_size = $attribs['PIXEL_SIZE'];
			$row->laser_type = $attribs['PULSE_CW'];
			$row->url = $attribs['URL'];
			$row->product_id = $product_id;
			
			$applications = $this->get_applications_by_product( $product_id ); 
			$row->application = $applications;
			$results[$product_id] = $row;			
		}
		
		return $results;
	}	
	
	/**
	* @param int $id
	* @return array $results
	*/
	public function get_product_attributes( $id ){		
		
		// prepare sql and bind parameters
		$stmt = $this->conn->prepare("SELECT * FROM `".$this->attributes."` 
		WHERE `Product_ID`  = :id 
		AND 
		(Product_Attribute = 'URL' 
		OR Product_Attribute = 'WAVELENGTH' 
		OR Product_Attribute = 'OPERATIONMODE' 
		OR Product_Attribute = 'TECHNOLOGY' 
		OR Product_Attribute = 'POWER' 
		OR Product_Attribute = 'PULSE_WIDTH' 
		OR Product_Attribute = 'MATERIALS' 
		OR Product_Attribute = 'MATERIAL_THICKNESS' OR Product_Attribute = 'MOTION_TYPE' OR Product_Attribute = 'MAX_WORK_AREA' OR Product_Attribute = 'PRECISION')");
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();	
		while ($row = $stmt->fetchObject()) {
			$product_attribute = $row->Product_Attribute;
			$product_attribute_value = $row->Product_Attribute_Value;
			$results[$product_attribute] = $product_attribute_value;
		}

		return $results;
	}
	
	/**
	* get_product_attributes_lmc
	* @param int $id
	* @return array $results
	*/
	public function get_product_attributes_lmc( $id ){		
		// prepare sql and bind parameters
		$stmt = $this->conn->prepare(
		"SELECT * FROM `".$this->attributes."` 
		WHERE `Product_ID`  = :id 
		AND (Product_Attribute = 'URL' 
		OR Product_Attribute = 'WAVELENGTH_MIN' 
		OR Product_Attribute = 'WAVELENGTH_MAX' 
		OR Product_Attribute = 'DETECTOR_DIAMETER' 
		OR Product_Attribute = 'MIN_ENERGY' 
		OR Product_Attribute = 'MAX_ENERGY' 
		OR Product_Attribute = 'REPETITION_RATE_MAX' 
		OR Product_Attribute = 'BEAM_DIAMETER' 
		OR Product_Attribute = 'ACTIVE_AREA' 
		OR Product_Attribute = 'PIXEL_SIZE' 
		OR Product_Attribute = 'PULSE_CW' 
		OR Product_Attribute = 'WAVELENGTH' 
		OR Product_Attribute = 'PULSE_WIDTH'
		OR Product_Attribute = 'POWER_MIN'
		OR Product_Attribute = 'POWER_MAX' 
		OR Product_Attribute = 'COOLING_METHOD' 
		OR Product_Attribute = 'PC_INTERFACE' OR Product_Attribute = 'MEASUREMENT_TYPE' OR Product_Attribute = 'UNCERTAINTY')");
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		//$stmt->debugDumpParams();
		$row = $stmt->fetchObject();
		while ($row = $stmt->fetchObject()) {
			$product_attribute = $row->Product_Attribute;
			$product_attribute_value = $row->Product_Attribute_Value;
			$results[$product_attribute] = $product_attribute_value;
			$results['Product_ID'] = $id;
		}
		return $results;
	}	
	
	
	/*
	* @param int $id
	* @return array $results
	* Return Applications associated to given product id
	*/
	private function get_applications_by_product( $id ){

		$stmt = $this->conn->prepare("SELECT * FROM `".$this->view_products_applications."` WHERE `Product_ID`  = :id");
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		while ($row = $stmt->fetchObject()) {
			$results[] = $row->Title;
		}

		return $results;		
	}
	
	public function get_applications(){
		$sql= "SELECT * FROM `" .  $this->applications;
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$results =  $stmt->fetchAll();		
		return $results;		
	}
}
<?php

class Products{
 
    // database connection and table name
    private $conn;
	private $general = "pd_products_general";
	private $products_categories = "pd_products_categories";
	private $applications = "pd_applications";
	private $attributes = "pd_products_attributes";
	
	private $view_products = "view_products_by_categories";
	private $view_products_applications = "view_applications_by_product";
 
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
			$row->mode = $attribs['MODE'];
			$row->url = $attribs['URL'];	
			$applications = $this->get_applications_by_product( $product_id ); 			
			$row->application = $applications;
			$results[$product_id] = $row;
			
		}
		
		return $results;
	}
	
	
	public function get_lmc_nav_products( $subcategory = "Energy"){

		$stmt = $this->conn->prepare("SELECT * FROM `".$this->view_products."` WHERE `Category_ID` = '43' AND `Show_On_Nav` = 1 AND `Name` LIKE '".$subcategory."%'");
		$stmt->bindValue(':cat', $cat, PDO::PARAM_INT);
		$stmt->execute();
		//$stmt->debugDumpParams();
		while ($row = $stmt->fetchObject()) {
			$product_id = $row->ID;
			
			$attribs = $this->get_product_attributes_lmc( $product_id );
			$row->detector_diameter = $attribs['DETECTOR_DIAMETER'];
			$row->min_energy = $attribs['MIN_ENERGY'];
			$row->max_energy = $attribs['MAX_ENERGY'];
			$row->min_wavelength = $attribs['WAVELENGTH_MIN'];
			$row->max_wavelength = $attribs['WAVELENGTH_MAX'];
			$row->max_repetition_rate = $attribs['REPETITION_RATE_MAX'];
			$row->url = $attribs['URL'];
			
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
		$stmt = $this->conn->prepare("SELECT * FROM `".$this->attributes."` WHERE Product_Attribute = 'WAVELENGTH' AND Product_Attribute = 'MODE' AND Product_Attribute = 'URL' AND `Product_ID`  = :id");
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
		$stmt = $this->conn->prepare("SELECT * FROM `".$this->attributes."` WHERE Product_ID = :id");
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		//$stmt->debugDumpParams();
		$row = $stmt->fetchObject();
		while ($row = $stmt->fetchObject()) {
			$product_attribute = $row->Product_Attribute;
			$product_attribute_value = $row->Product_Attribute_Value;
			//$results[] = array($product_attribute=>$product_attribute_value);
			$results[$product_attribute] = $product_attribute_value;
		}
		
		//print_r($results);
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
			//$product_id = $row->Product_ID;
			//$product_attribute = $row->Product_Application_ID;
			//$product_attribute_value = $row->Product_Application_ID;
			$results[] = array("title"=>$row->Title,"url"=>"http://www.coherent.com/");
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
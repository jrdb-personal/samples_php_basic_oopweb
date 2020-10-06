<?php
	class Connection {
		public $host;
		public $dbname;
		public $user;
		public $password;
		public $charset;
		public $connection;

		public function __construct(){
			$this->host = '127.0.0.1';
			$this->dbname = 'training_phpmysql';
			$this->user = 'admin';
			$this->password = 'P@ssw0rd@05';
			$this->charset = 'utf8mb4';
		}

		public function openConnection(){
			$dsn = "mysql:host=".$this->host.";dbname=".$this->dbname.";charset=".$this->charset."";
			$options = [
			    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			    PDO::ATTR_EMULATE_PREPARES   => false,
			];
			try {
			     $this->connection = new PDO($dsn, $this->user, $this->password, $options);
			     return $this->connection;
			} 
			catch (\PDOException $e) {
			     throw new \PDOException($e->getMessage(), (int)$e->getCode());
			}
		}

		public function closeConnection(){
		}
	}



	class QueryBuilder{

		public function buildQueryCreate($table, $columns){
			$query = "INSERT INTO ".$table."(";
			for($ctr=0; $ctr < count($columns); $ctr++){
				$query .=$columns[$ctr].", ";
			}
			$query = rtrim($query, ", ");
			$query .= ") values(";
			for($ctr=0; $ctr < count($columns); $ctr++){
				$query .="?, ";
			}
			$query = rtrim($query, ", ");
			$query .=")";
			return $query;
		}

		public function buildQueryRead($table, $columns, $where = ""){
			$query = "SELECT "; 
			for($ctr=0; $ctr < count($columns); $ctr++){
				$query .=$columns[$ctr].", ";
			}
			$query = rtrim($query, ", ");
			$query .= " FROM ".$table." ";

			if($where != ""){
				$query .= "WHERE ";
				for($ctr=0; $ctr < count($where); $ctr++){
					$query .=$where[$ctr]." ";
				}
			}
			return $query;
		}

		public function buildQueryReadAll($table, $columns){
			$query = "SELECT "; 
			for($ctr=0; $ctr < count($columns); $ctr++){
				$query .=$columns[$ctr].", ";
			}
			$query = rtrim($query, ", ");
			$query .= " FROM ".$table." ";
			return $query;
		}



		public function buildQueryUpdate($table, $columns, $idfield){
			$query = "UPDATE ".$table." SET ";
			for($x=0; $x < count($columns); $x++){
				$query .=$columns[$x]." = ?,";
			}
			$query = rtrim($query, ",");
			$query .= " WHERE ".$idfield. " = ?";
			return $query;
		}

		public function buildQueryDelete($table, $idfield){
			 $query = "DELETE FROM ". $table. " WHERE ". $idfield. " ?";
			 return $query;
		}


	}



	class User{
		public $UserID;
		public $UserEmail;
		public $UserPassword;
		public $CreatedDate;

		public function setUserID($id){
			$this->UserID = $id;
		}

		public function setUserEmail($email){
			$this->UserEmail = $email;
		}

		public function setUserPassword($password){
			$this->UserPassword = $password;
		}

		public function getUserID(){
			return $this->UserID;
		}

		public function getUserEmail(){
			return $this->UserEmail;
		}

		public function getUserPassword(){
			return $this->UserPassword;
		}
		
		public function registerProcess($connection, $query, $data){
			$stmt = $connection->prepare($query);
			return $stmt->execute($data);
		}

		public function signInProcess($connection, $query, $data){
			$stmt = $connection->prepare($query);
			$stmt->execute($data);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}

		public function getCurrentUser($connection, $query, $data){
			$stmt = $connection->prepare($query);
			$stmt->execute($data);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
	}


	class Profile{

		public $ProfileFirstName;
		public $ProfileLastName;
		public $ProfileBirthdate;
		public $ProfileGender;
		public $ProfileDeliveryAddress;
		public $ProfileBillingAddress;

		public function setProfileFirstName($firstname){
			$this->ProfileFirstName = $firstname;
		}
		
		public function setProfileLastName($lastname){
			$this->ProfileLastName = $lastname;
		}

		public function setProfileBirthdate($birthdate){
			$this->ProfileBirthdate = $birthdate;
		}

		public function setProfileGender($gender){
			$this->ProfileGender = $birthdate;
		}

		public function setDeliveryAddress($deliveryaddress){
			$this->ProfileDeliveryAddress = $deliveryaddress;
		}

		public function setBillingAddress($billingaddress){
			$this->ProfileBillingAddress = $billingaddress;
		}

		public function setProfileMembers($firstname, $lastname, $birthdate, $gender, $deliveryaddress, $billingaddress, $userid){
			$this->ProfileFirstName = $firstname;
			$this->ProfileLastName = $lastname;
			$this->ProfileBirthdate = $brithdate;
			$this->ProfileGender = $gender;
			$this->ProfileDeliveryAddress = $deliveryaddress;
			$this->ProfileBillingAddress = $billingaddress;
			$this->UserID = $userid;
		}

		public function getProfileFirstName(){
			return $this->ProfileFirstName;
		}

		public function getProfileLastName(){
			return $this->ProfileLastName;
		}

		public function getProfileBirthdate(){
			return $this->ProfileBirthdate;
		}

		public function getProfileGender(){
			return $this->ProfileGender;
		}

		public function getProfileDeliveryAddress(){
			return $this->ProfileDeliveryAddress;
		}

		public function getProfileBillingAddress(){
			return $this->getProfileBillingAddress;
		}

		public function getCurrentProfile($connection, $query, $data){
			$stmt = $connection->prepare($query);
			$stmt->execute($data);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}

	}

	class Item{
		public $ItemID;
		public $ItemName;
		public $ItemType;
		public $ItemDesc;
		public $ItemPrice;
		public $ItemQty;
		public $ItemStatus;
		public $ItemImg;

		public function __construct(){
			//$this->ItemID = $id;
			//$this->ItemStatus = $status;
		}

		public function setItemID($id){
			$this->ItemID = $id;
		}

		public function setItemName($name){
			$this->ItemName = $name;
		}

		public function setItemType($type){
			$this->ItemType = $type;
		}

		public function setItemDesc($desc){
			$this->ItemDesc = $desc;
		}

		public function setItemPrice($price){
			$this->ItemPrice = $price;
		}

		public function setItemQty($qty){
			$this->ItemQty = $qty;
		}

		public function setItemStatus($status){
			$this->ItemStatus = $status;
		}

		public function setItemImg($img){
			$this->ItemImg = $img;
		}

		public function getItemID(){
			return $this->ItemID;
		}

		public function getItemName(){
			return $this->ItemName;
		}

		public function getItemType(){
			return $this->ItemType;
		}

		public function getItemDesc(){
			return $this->ItemDescription;
		}

		public function getItemPrice(){
			return $this->ItemPrice;
		}

		public function getItemQty(){
			return $this->ItemQty;
		}

		public function getItemStatus(){
			return $this->ItemStatus;
		}

		public function getItemImg(){
			return $this->ItemImg;
		}

	}


?>
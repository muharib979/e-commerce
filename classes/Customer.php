<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');

?>


<?php
class Customer{
	private $db;
	private $fm;

	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
		
	}
	public function customerRegistration($data){
		$name = $this->fm->validation($data['name']);
		$address   = $this->fm->validation($data['address']);
		$city = $this->fm->validation($data['city']);
		$country    = $this->fm->validation($data['country']);
		$zip   = $this->fm->validation($data['zip']);
		$phone    = $this->fm->validation($data['phone']);
		$email   = $this->fm->validation($data['email']);
		$pass   = $this->fm->validation(md5($data['pass']));


		$name = mysqli_real_escape_string($this->db->link, $data['name']);
		$address       = mysqli_real_escape_string($this->db->link, $data['address']);
		$city     = mysqli_real_escape_string($this->db->link, $data['city']);
		$country        = mysqli_real_escape_string($this->db->link, $data['country']);
		$zip       = mysqli_real_escape_string($this->db->link, $data['zip']);
		$phone        = mysqli_real_escape_string($this->db->link, $data['phone']);
		$email       = mysqli_real_escape_string($this->db->link, $data['email']);
		$pass        = mysqli_real_escape_string($this->db->link, md5($data['pass']));

		 if($name == "" || $address == "" || $city == "" || $country == "" || $zip == "" || $phone == "" || $email == "" || $pass == "" ){
	    $msg = "<span class='error'> Field must not be empty !</span>";
		return $msg;
		}

		$mailquery = "SELECT * FROM tbl_customer WHERE email = '$email' LIMIT 1";
		$mailchk  = $this->db->select($mailquery);	
		if ($mailchk != false) {
			$msg = "<span class='error'> Email already Exist !</span>";
		return $msg;
		}else{
			$query = "INSERT INTO tbl_customer(name,address,city,country,zip, phone,email,pass) 
	        VALUES('$name','$address','$city','$country','$zip','$phone','$email','$pass')";
	        $inserted_rows =$this->db->insert($query);
	        if ($inserted_rows) {
	        $msg = "<span class='success'>Customer data Inserted Successfully</span>";
			return $msg;
	        }else {
	         $msg = "<span class='error'>Customer data Not Inserted !</span>";
			return $msg;
	        }
		}
	}
	public function customerLogin($data){
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
	    $pass  = mysqli_real_escape_string($this->db->link, md5($data['pass']));
		if (empty($email) || empty($pass)) {
			$msg = "<span class='error'> Field must not be empty !</span>";
		return $msg;
		}

		$query = "SELECT * FROM tbl_customer WHERE email = '$email' And pass= '$pass'";
		$result  = $this->db->select($query);
		if ($result !=false) {
			$value =$result->fetch_assoc();
			Session::set("cuslogin",true);
			Session::set("cmrId",$value['id']);
			Session::set("cmrName",$value['name']);
			header("Location:cart.php");
		}else{
			$msg = "<span class='error'>Email or Password Not matched !</span>";
			return $msg;
		}

	}
	public function getCustomerData($id){
		$query = "SELECT * FROM tbl_customer WHERE id ='$id'";
		$result = $this->db->select($query);
		return $result;
	}
	public function customerUpdate($data,$cmrId){
		$name      = $this->fm->validation($data['name']);
		$address   = $this->fm->validation($data['address']);
		$city      = $this->fm->validation($data['city']);
		$country   = $this->fm->validation($data['country']);
		$zip       = $this->fm->validation($data['zip']);
		$phone     = $this->fm->validation($data['phone']);
		$email     = $this->fm->validation($data['email']);
	


		$name      = mysqli_real_escape_string($this->db->link, $data['name']);
		$address   = mysqli_real_escape_string($this->db->link, $data['address']);
		$city      = mysqli_real_escape_string($this->db->link, $data['city']);
		$country   = mysqli_real_escape_string($this->db->link, $data['country']);
		$zip       = mysqli_real_escape_string($this->db->link, $data['zip']);
		$phone     = mysqli_real_escape_string($this->db->link, $data['phone']);
		$email     = mysqli_real_escape_string($this->db->link, $data['email']);


		if($name == "" || $address == "" || $city == "" || $country == "" || $zip == "" || $phone == "" || $email == "" ){
	    $msg = "<span class='error'> Field must not be empty !</span>";
		return $msg;
		}else{
			$query = "UPDATE tbl_customer
					SET
					name    = '$name',
					address = '$address',
					city    = '$city',
					country = '$country',
					zip     = '$zip',
					phone   = '$phone',
					email   = '$email'
					WHERE id='$cmrId'";
				$updated_row = $this->db->update($query);
				if ($updated_row ) {
					$msg = "<span class='success'>Customer Data Successfully.</span>";
				    return $msg;
				}else{	
			        $msg = "<span class='error'>Customer Not Updated !</span>";
				     return $msg;
			}
	  }
   }
}
?>
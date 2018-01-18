<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');

?>

<?php
class Product{
	private $db;
	private $fm;

	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
		
	}
	public function productInsert($data, $file){
		$productName = $this->fm->validation($data['productName']);
		$catId   = $this->fm->validation($data['catId']);
		$brandId = $this->fm->validation($data['brandId']);
		$body    = $this->fm->validation($data['body']);
		$price   = $this->fm->validation($data['price']);
		$type    = $this->fm->validation($data['type']);

		$productName = mysqli_real_escape_string($this->db->link, $data['productName']);
		$catId       = mysqli_real_escape_string($this->db->link, $data['catId']);
		$brandId     = mysqli_real_escape_string($this->db->link, $data['brandId']);
		$body        = mysqli_real_escape_string($this->db->link, $data['body']);
		$price       = mysqli_real_escape_string($this->db->link, $data['price']);
		$type        = mysqli_real_escape_string($this->db->link, $data['type']);

		$permited  = array('jpg', 'jpeg', 'png', 'gif');
	    $file_name = $file['image']['name'];
	    $file_size = $file['image']['size'];
	    $file_temp = $file['image']['tmp_name'];

	    $div = explode('.', $file_name);
	    $file_ext = strtolower(end($div));
	    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
	    $uploaded_image = "upload/".$unique_image;

	    if($productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $type == "" || $file_name == "" ){
	    $msg = "<span class='error'> Field must not be empty !</span>";
			return $msg;
	    }elseif ($file_size >1048567) {
	     echo "<span class='error'>Image Size should be less then 1MB!
	     </span>";
	    } elseif (in_array($file_ext, $permited) === false) {
	     echo "<span class='error'>You can upload only:-"
	     .implode(', ', $permited)."</span>";
	    } else{
	        move_uploaded_file($file_temp, $uploaded_image);
	        $query = "INSERT INTO tbl_product(productName,catId,brandId,image,body, price,type) 
	        VALUES('$productName','$catId','$brandId','$uploaded_image','$body','$price',$type)";
	        $inserted_rows =$this->db->insert($query);
	        if ($inserted_rows) {
	        $msg = "<span class='success'>Product Inserted Successfully</span>";
			return $msg;
	        }else {
	         $msg = "<span class='error'>Product Not Inserted !</span>";
			return $msg;
	        }
    }


	}
	public function getAllProduct(){
		$query = "SELECT tbl_product.*,tbl_category.catName,tbl_brand.brandName
				FROM tbl_product
				INNER JOIN tbl_category
				ON tbl_product.catId = tbl_category.catId
				INNER JOIN tbl_brand
				ON tbl_product.brandId = tbl_brand.brandId
				ORDER BY tbl_product.productId DESC";

				$result = $this->db->select($query);
				return $result;
	
	}
	public function getProById($id){
		$query = "SELECT * FROM tbl_product WHERE productId ='$id'";
		$result = $this->db->select($query);
		return $result;
	}

	public function productUpdate($data, $file,$id){
		$productName = $this->fm->validation($data['productName']);
		$catId   = $this->fm->validation($data['catId']);
		$brandId = $this->fm->validation($data['brandId']);
		$body    = $this->fm->validation($data['body']);
		$price   = $this->fm->validation($data['price']);
		$type    = $this->fm->validation($data['type']);

		$productName = mysqli_real_escape_string($this->db->link, $data['productName']);
		$catId       = mysqli_real_escape_string($this->db->link, $data['catId']);
		$brandId     = mysqli_real_escape_string($this->db->link, $data['brandId']);
		$body        = mysqli_real_escape_string($this->db->link, $data['body']);
		$price       = mysqli_real_escape_string($this->db->link, $data['price']);
		$type        = mysqli_real_escape_string($this->db->link, $data['type']);


		$permited  = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
        $uploaded_image = "upload/".$unique_image;

		if($productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $type == "" ){
		$msg = "<span class='error'>Field must not be empty!</span>";
			return $msg;
		}else{
		if (!empty($file_name)) {

		
		if ($file_size >1048567) {
		 $msg = "<span class='error'>Image Size should be less then 1MB!
		 </span>";
		 return $msg;
		} elseif (in_array($file_ext, $permited) === false) {
		 echo "<span class='error'>You can upload only:-"
		 .implode(', ', $permited)."</span>";
		} else{
        move_uploaded_file($file_temp, $uploaded_image);

        $query="UPDATE tbl_product
                SET
                productName    ='$productName',
                catId  ='$catId',
                brandId   ='$brandId',
                body   ='$body',
                image  ='$uploaded_image',
                price ='$price',
                type   ='$type'
                WHERE productId='$id'";


        $updated_row = $this->db->update($query);
        if ($updated_row) {
         $msg = "<span class='success'>Product Updated Successfully</span>";
			return $msg;
        }else {
         $msg = "<span class='error'>Product Not Updated !</span>";
			return $msg;
        }
    }

}else{
            $query="UPDATE tbl_product
                SET
                productName    ='$productName',
                catId  ='$catId',
                brandId   ='$brandId',
                body ='$body',
                price   ='$price',
                type   ='$type'
                WHERE productId='$id'";


        $updated_row = $this->db->update($query);
        if ($updated_row) {
        $msg = "<span class='success'>Product Updated Successfully</span>";
			return $msg;
        }else {
        $msg = "<span class='error'>Product Not Updated !</span>";
			return $msg;
        }

    }
}
	}
	public function delProById($id){
		$query = "SELECT * FROM tbl_product WHERE productId ='$id'";
		$getdata = $this->db->select($query);
		if ($getdata) {
		while ($delImg = $getdata->fetch_assoc()) {
			$dellink = $delImg['image'];
			unlink($dellink);
		}
	}
		$delquery = "DELETE FROM tbl_product WHERE productId = '$id'";
		$deldata = $this->db->delete($delquery);
		if ($deldata ) {
			$msg = "<span class='success'>Product Deleted Successfully.</span>";
				    return $msg;
		}else{	
	        $msg = "<span class='error'>Product Not Deleted!</span>";
		     return $msg;
			}
	}
	public function getFeaturedProduct(){
		$query = "SELECT * FROM tbl_product WHERE type='0' ORDER BY productId DESC LIMIT 4";
		$result = $this->db->select($query);
		return $result;
	}
	public function getNewProduct(){
		$query = "SELECT * FROM tbl_product  ORDER BY productId DESC LIMIT 4";
		$result = $this->db->select($query);
		return $result;
	}
    public function getAcerProduct(){
    	$query = "SELECT * FROM tbl_product WHERE brandId='3'  ORDER BY productId DESC LIMIT 4";
		$result = $this->db->select($query);
		return $result;
    }
    public function getSamsungProduct(){
    	$query = "SELECT * FROM tbl_product WHERE brandId='2'  ORDER BY productId DESC LIMIT 4";
		$result = $this->db->select($query);
		return $result;
    }
    public function getIphoneProduct(){
    	$query = "SELECT * FROM tbl_product WHERE brandId='1'  ORDER BY productId DESC LIMIT 4";
		$result = $this->db->select($query);
		return $result;
    }
     public function getCanonProduct(){
    	$query = "SELECT * FROM tbl_product WHERE brandId='4'  ORDER BY productId DESC LIMIT 4";
		$result = $this->db->select($query);
		return $result;
    }
	public function getSingleProduct($id){ 
		$query = "SELECT p.*,c.catName,b.brandName
				FROM tbl_product as p, tbl_category as c,  tbl_brand as b
				WHERE p.catId =c.catId AND p.brandId = b.brandId AND productId='$id'";
				$result = $this->db->select($query);
				return $result;
	}
	public function latestFromIphone(){
		$query = "SELECT * FROM tbl_product WHERE brandId = '1' ORDER BY productId DESC LIMIT 1";
		$result = $this->db->select($query);
		return $result;
	}
	public function latestFromSumsang(){
		$query = "SELECT * FROM tbl_product WHERE brandId = '2' ORDER BY productId DESC LIMIT 1";
		$result = $this->db->select($query);
		return $result;
	}
	public function latestFromAcer(){
		$query = "SELECT * FROM tbl_product WHERE brandId = '3' ORDER BY productId DESC LIMIT 1";
		$result = $this->db->select($query);
		return $result;
	}
	public function latestFromCanon(){
		$query = "SELECT * FROM tbl_product WHERE brandId = '4' ORDER BY productId DESC LIMIT 1";
		$result = $this->db->select($query);
		return $result;
	}

	public function productByCat($id){
		$catId = mysqli_real_escape_string($this->db->link, $id);
		$query = "SELECT * FROM tbl_product WHERE catId ='$catId'";
		$result = $this->db->select($query);
		return $result;
	}
	public function insertCompareData($cmrId, $cmprid){
		$cmrId     = mysqli_real_escape_string($this->db->link, $cmrId);
		$productId = mysqli_real_escape_string($this->db->link, $cmprid);

		$cquery = "SELECT * FROM tbl_compare WHERE productId ='$productId' And cmrId = '$cmrId'";
		$check = $this->db->select($cquery);
		if ($check) {
			 $msg = "<span class='error'>Already Added!</span>";
				     return $msg;
		}

		$query = "SELECT * FROM tbl_product WHERE productId ='$productId'";
        $result =$this->db->select($query)->fetch_assoc();
         if($result){
	    	$productId =$result['productId'];
	    	$productName =$result['productName'];
	    	$price =$result['price'];
	    	$image =$result['image'];
	    	$query = "INSERT INTO tbl_compare(cmrId,productId,productName,price,image) 
	        VALUES('$cmrId','$productId','$productName','$price','$image')";
	        $inserted_rows =$this->db->insert($query);
	        if ($inserted_rows ) {
					$msg = "<span class='success'>Added !Check compare Page.</span>";
				    return $msg;
				}else{	
			        $msg = "<span class='error'>Not Added!</span>";
				     return $msg;
			}
	        

	    }
		
	}
	public function getCartProduct($cmrId){
		$query = "SELECT * FROM tbl_compare WHERE cmrId ='$cmrId' ORDER BY id DESC";
		$result = $this->db->select($query);
		return $result;
	}
	public function delCustomerData($cmrId){
		$query = "DELETE FROM tbl_compare WHERE cmrId = '$cmrId'";
		$deldata = $this->db->delete($query);
	}
	public function saveWishListData($cmrId,$id){
			$cquery = "SELECT * FROM tbl_wlist WHERE productId ='$id' And cmrId = '$cmrId'";
		    $check = $this->db->select($cquery);
		    if ($check) {
			 $msg = "<span class='error'>Already Added!</span>";
				     return $msg;
		    }

			$query = "SELECT * FROM tbl_product WHERE productId ='$id'";
	        $result =$this->db->select($query)->fetch_assoc();
	         if($result){
		    	$productId =$result['productId'];
		    	$productName =$result['productName'];
		    	$price =$result['price'];
		    	$image =$result['image'];
		    	$query = "INSERT INTO tbl_wlist(cmrId,productId,productName,price,image) 
		        VALUES('$cmrId','$productId','$productName','$price','$image')";
		        $inserted_rows =$this->db->insert($query);
		        if ($inserted_rows ) {
						$msg = "<span class='success'>Added !Check WishList Page.</span>";
					    return $msg;
					}else{	
				        $msg = "<span class='error'>Not Added!</span>";
					     return $msg;
				}
		        

	    }
	}
	public function getWlistData($cmrId){
		$query = "SELECT * FROM tbl_wlist WHERE cmrId ='$cmrId' ORDER BY id DESC";
		$result = $this->db->select($query);
		return $result;
	}
	public function delWlistData($cmrId,$productId){
		$query = "DELETE FROM tbl_wlist WHERE cmrId = '$cmrId' AND productId = '$productId'";
		$deldata = $this->db->delete($query);
	}
	public function getSearchProduct($search){
		$query = "SELECT * FROM tbl_product  WHERE productName LIKE '%$search%' OR body LIKE '%$search%'";
		$result = $this->db->select($query);
		return $result;
	}
	
}
?>
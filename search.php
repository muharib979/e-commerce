
<?php include 'inc/header.php' ;?>

<?php
$search = mysqli_real_escape_string($db->link, $_GET['search']);
	if(!isset($search) || $search ==NULL){
		header("Location:404.php");
	}else{
		$search = $search;
	}
?>
<?php
/*
	if(!isset($_GET['search']) || $_GET['search'] ==NULL){
		header("Location:404.php");
	}else{
		$search = $_GET['search'];
	}

*/
?>



	
	     <div class="main">
            <div class="content">
    	        <div class="section group">
	
	          
	             <?php 
			      	$getSearch = $pd->getSearchProduct($search);
			      	if ($getSearch) {
			      		while ($result = $getSearch->fetch_assoc()) {
	
	            ?>

				<div class="grid_1_of_4 images_1_of_4">
					 <a href="details.php?proid=<?php echo $result['productId'];?>"><img src="admin/<?php echo $result['image']; ?>" alt="" /></a>
					 <h2><a href="details.php?proid=<?php echo $result['productId'];?>"><?php echo $result['productName']; ?></a></h2>
					 <p><?php echo $fm->textShorten($result['body'],60); ?></p>
					 <p><span class="price">$<?php echo $result['price']; ?></span></p>
				     <div class="button"><span><a href="details.php?proid=<?php echo $result['productId'];?>" class="details">Details</a></span></div>
				</div>
			<?php } } else { ?>
				<p>Your Search Query Not found !!</p>
				<?php } ?>
				</div>
				</div>
</div>
<?php include 'inc/footer.php' ;?>
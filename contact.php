<?php include 'inc/header.php'; ?>

 <div class="main">
    <div class="content">
    	<div class="support">
  			<div class="support_desc">
  				<h3>Live Support</h3>
  				<p><span>24 hours | 7 days a week | 365 days a year &nbsp;&nbsp; Live Technical Support</span></p>
  				<p> It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
  			</div>
  				<img src="web/images/contact.png" alt="" />
  			<div class="clear"></div>
  		</div>
  		<?php 
	if ($_SERVER['REQUEST_METHOD'] =='POST') {
		$name = $fm->validation($_POST['name']);
		$email = $fm->validation($_POST['email']);
		$mobile = $fm->validation($_POST['mobile']);
		$subject = $fm->validation($_POST['sub']);
		

		$name = mysqli_real_escape_string($db->link, $name);
		$email = mysqli_real_escape_string($db->link, $email);
		$mobile = mysqli_real_escape_string($db->link, $mobile);
		$subject = mysqli_real_escape_string($db->link, $subject);

		$errorn = "";
		$errore = "";
		$errorm = "";
		$errors = "";
		if (empty($name)){
			$errorn = " Name must not be empty !";
		}
		if (empty($email)){
			$errore = "Email must not be empty !";
		}
		if (empty($mobile)){
			$errorm = "Mobile no. must not be empty !";
		}
		if (empty($subject)){
			$errors = "subject must not be empty !";
		}

		/*$error = "";
		if (empty($fname)) {
			$error = "First name must not be empty !";
		}elseif (empty($lname)) {
			$error = "Last name must not be empty !";
		}elseif (empty($email)) {
			$error = "Email field must not be empty !";
		}elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
			$error = "Invalid Email Address !";
		}elseif (empty($body)) {
			$error = "Message field must not be empty !";
		}*/else{
			 $query = "INSERT INTO tbl_contact(name,email,mobile,subject) 
		        VALUES('$name','$email','$mobile','$subject')";
		        $inserted_rows = $db->insert($query);
		        if ($inserted_rows) {
		         $msg = " Message Send Successfully.";
		        }else {
		         $msg = " Message Not Send!.";
		        }
		}
	}
?>
    	<div class="section group">
				<div class="col span_2_of_3">
				  <div class="contact-form">

				  	<h2>Contact Us</h2>
				  	<?php
					
					if (isset($msg)) {
						echo "<span style='color:green'>$msg</span>";
					}
				?>
					    <form action="" method="post">
					    	<div>
						    	<span><label>NAME</label></span>
						    	<span>
						    	<?php
								if (isset($errorn)) {
									echo "<span style='color:red'>$errorn</span>";
								}
								?><input type="text" name="name"></span>
						    </div>
						    <div>
						    	<span><label>E-MAIL</label></span>
						    	<span>
						    	<?php
								if (isset($errore)) {
									echo "<span style='color:red'>$errore</span>";
								}
								?><input type="text" name="email"></span>
						    </div>
						    <div>
						     	<span><label>MOBILE.NO</label></span>
						    	<span>
									    	<?php
								if (isset($errorm)) {
									echo "<span style='color:red'>$errorm</span>";
								}
								?><input type="text" name="mobile"></span>
						    </div>
						    <div>
						    	<span><label>SUBJECT</label></span>
							  <span>
							  <?php
								if (isset($errors)) {
									echo "<span style='color:red'>$errors</span>";
								}
								?><textarea name="sub"></textarea></span>
						    </div>
						   <div>
						   		<span><input type="submit" name ="submit" value="SUBMIT"></span>
						  </div>
					    </form>
				  </div>
  				</div>
				<div class="col span_1_of_3">
      			<div class="company_address">
				     	<h2>Company Information :</h2>
						    	<p>online Storebd,</p>
						   		<p>78/8/1,easr rampura,Dhaka</p>
						   		<p>bangladesh</p>
				   		<p>Phone:(00) 0167xxxxxx</p>
				   		<p>Fax: (000) 000 00 00 0</p>
				 	 	<p>Email: <span>amran979@gmail.com</span></p>
				   		<p>Follow on: <span>Facebook</span>, <span>Twitter</span></p>
				   </div>
				 </div>
			  </div>    	
    </div>
 </div>
<?php include 'inc/footer.php'; ?>
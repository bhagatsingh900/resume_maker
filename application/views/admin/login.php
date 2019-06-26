 
<style> 
/*
https://giffiles.alphacoders.com/997/99712.gif
http://hdwallpapersbackgrounds.us/backgrounds-image/hd-wallpapers-2s-1920x1080/backgrounds-hd-desktop-660jdwsu-1s-1920x1080.jpg*/
	
	body#LoginForm{ font-weight: bold;
    font-family: cursive;background-image:url("https://risesmart.com.au/wp-content/uploads/2017/08/risesmart-professional-branding-banner.jpg"); background-repeat:no-repeat; background-position:center; background-size:cover; padding:10px;}

.form-heading { color: #000;
    font-size: 35px;
    text-align: center;
    margin-top: 20px;}
.panel h2{ color:#444444; font-size:18px; margin:0 0 8px 0;}
.panel p {color: #000;
    font-size: 16px;
    margin-bottom: 20px;
    line-height: 24px;
    letter-spacing: 1px;
}
.login-form .form-control {
  background: #f7f7f7 none repeat scroll 0 0;
  border-radius: 4px;
  font-size: 14px;
  height: 50px;
  line-height: 50px;
}
.error_msg{
	font-weight:bolder;
	color:red;
}
.main-div {
    background: #dcbe36eb none repeat scroll 0 0;
    border-radius: 2px;
    margin: 40px auto 30px;
    max-width: 45%;
    padding: 50px 70px 50px 71px;
    font-weight: bolder;
    border-radius: 10px;
    box-shadow: 0px 0px 11px 6px #00000036;
}

.login-form .form-group {
  margin-bottom:10px;
}
.login-form{ text-align:center;}
.forgot a {
  color: #0e4973;
  font-size: 14px;
  text-decoration: underline;
}
.login-form  .btn.btn-primary {
    background: #ffffff none repeat scroll 0 0;
    color: #000000;
    font-size: 24px;
    width: 100%;
    height: 50px;
    padding: 0;
}
.forgot {
  text-align: left; margin-bottom:30px;
}
.botto-text {
    color: #d1b338;
    font-size: 20px;
    margin: auto;
}
.login-form .btn.btn-primary.reset {
  background: #ff9900 none repeat scroll 0 0;
}
.back { text-align: left; margin-top:10px;}
.back a {color: #444444; font-size: 13px;text-decoration: none;}

</style>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<html>
  <head>
      <title>Resume Maker</title>

  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
  </head>
<body id="LoginForm">
<div class="container" style="text-align: center;">
	<img  src="">
<h1 class="form-heading"><b>Resume Builder</b></h1>
<div class="login-form">
	<div class="main-div">
		<div class="panel">
		   <p>Please enter your Username and Password</p>
	   </div>
		<?php if(!empty($msg)){ echo "<span class='error_msg'> ".$msg."</span>"; }
	 
		 if($this->session->flashdata('msg')){
			echo '<div class="alert alert-danger alert-block">
					<button type="button" class="close" data-dismiss="alert">x</button>
						<strong>'.$this->session->flashdata('msg').'</strong>
				</div>';
				 }
				?>
		<form id="Login" action="<?=base_url().'checkLogin'?>" method="post">
			<div class="form-group">
				<input required type="email" class="form-control" name="email" id="inputEmail" placeholder="Email Address">
			</div>
	
			<div class="form-group">
				<input required type="password" class="form-control" name="password" id="inputPassword" placeholder="Password">
			</div>
			<div class="forgot">
			<!--	<a href="<?=base_url("forget_password/")?>">Forgot password?</a>-->
			</div>
			<button type="submit" class="btn btn-primary">Login</button>
		</form>
		</div>

			</div>
		</div>
	</div>


</body>
</html>

<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Choice Broking - LMS</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
    
<link href="<?php echo base_url('resources/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('resources/css/bootstrap-responsive.min.css')?>" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url('resources/css/font-awesome.css')?>" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    
<link href="<?php echo base_url('resources/css/style.css?v=0.1')?>" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('resources/css/pages/signin.css')?>" rel="stylesheet" type="text/css">

</head>

<body>
	
	<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			
			
			<a class="brand" href="<?php echo site_url('login')?>">
				Choice Broking				
			</a>		
			
			
	
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->



<div class="account-container">
	
	<div class="content clearfix">
    
    	<div id="error"><?php echo $this->session->flashdata('error')?></div>
		
		<form action="<?php echo site_url('login/authenticate')?>" method="post">
			
            <center><img src="<?=base_url('resources/img/logo.png?v=0.1')?>" width="90%" /></center>
        
			<div class="login-fields">
				<br/><br/>
				<p>Please provide your login details</p>
				
				<div class="field">
					<label for="username">Username</label>
					<input type="text" id="username" name="username" value="" placeholder="Username" class="login username-field" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
				</div> <!-- /password -->
                
                <div class="field">
					<label for="role">Role:</label>
					<select name="role" id="role" class="login role-field">
						<option value="Admin">I am Admin</option>
                        <option value="Manager">I am Manager</option>
                        <option value="Executive">I am Executive</option>
                        <option value="Influencer">I am Influencer</option>
                        <option value="Head">I am Head of Department</option>
                    </select>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<!--<span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field">Keep me signed in</label>
				</span>-->
									
				<button class="button btn btn-primary btn-large">Sign In</button>
				
			</div> <!-- .actions -->
			
			
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->


<script src="<?php echo base_url('resources/js/jquery-1.7.2.min.js')?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap.js')?>"></script>

<script src="<?php echo base_url('resources/js/signin.js')?>"></script>

</body>

</html>

<script type="text/javascript">
$(document).ready(function(){
	$('#username').focus();
	$('#error').hide();
	<?php if($this->session->flashdata('error')) { ?>
		$('#error').fadeIn('slow').delay(4000).slideUp('fast');
	<?php } ?>
});
</script>
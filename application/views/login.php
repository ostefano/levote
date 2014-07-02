<!DOCTYPE html>
<html lang="en">
	<head>
		<title>:: Kaspersky Academy - Vote ::</title>
		<?php echo $head ?>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-4 col-md-offset-4">
						<h1 class="text-center login-title">&nbsp;</h1>
						<div class="account-wall">
								<img class="profile-img" src="<?php echo base_url()?>media/imgs/logo_transparent.png" width="180" />
								<?php echo form_open('login/attempt', array('role' => 'form', 'class' => 'form-signin'));?> 
									<input name="username" type="text" class="form-control" placeholder="Email" required autofocus>
									<input name="password" type="password" class="form-control" placeholder="Password" required>
									<button class="btn btn-lg btn-primary btn-block" type="submit">
											Sign in</button>
									<label class="checkbox pull-left">
											<input type="checkbox" value="remember-me">
											Remember me
									</label>
									<a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
								<?php echo form_close(); ?>
						</div>
						<!-- <a href="#" class="text-center new-account">Create an account </a>-->
				</div>
			</div>
		</div>
	</body>
</html>

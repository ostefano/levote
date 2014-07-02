<!DOCTYPE html>
<html lang="en">
	<head>
		<title>:: Kaspersky Academy - Vote ::</title>
		<?=$head ?>
	</head>
	<body>
		<div id="head_row">	
			<?=$head_row ?>
		</div>
		<div class="container" style="clear:both; width: 500px; margin-left: 20px"> 
			<?=$this->load->view('body/nav_buttons','', true) ?>
			<h3>
				Add new Program Committe
			</h3>
			<form role="form">
				<div class="form-group">
					<label for="exampleInputEmail1">Username</label>
					<input class="form-control" readonly="readonly" type="textfield" style="width: 200px" placeholder="<?=$username?>" />
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Password</label>
					<input class="form-control" readonly="readonly" type="textfield" style="width: 200px" placeholder="<?=$password?>" />
				</div>
			 <button type="submit" class="btn btn-success" onClick="window.print()">Print</button>
			</form>
		</div>
	</body>
</html>
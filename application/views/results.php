<!DOCTYPE html>
<html lang="en">
	<head>
		<title>:: Kaspersky Academy - Vote ::</title>
		<?=$head?>
	</head>

	<body>
		<div id="head_row">	
			<?=$head_row?>
		</div>

		<div class="container" style="clear:both; width: 500px; margin-left: 20px"> 
			<?=$this->load->view('body/nav_buttons','', true)?>
			
			<h3>Poster Session Results</h3>
			<table class="table">
				<thead>
					<tr>
						<th>#</th><th>Name</th><th>University</th><th>Country</th><th>Points</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$first_passed = false;
					foreach ($results_poster as $row) {
						if(!$first_passed) {
							$class = 'class="danger"';
							$first_passed = true;
						} else {
							$class = '';
						}
						?>
						<tr <?=$class?> >
							<td><?=$row['index']?></td>
							<td><?=$row['name']?></td>
							<td><?=$row['uni']?></td>
							<td><?=$row['country']?></td>
							<td><?=$row['points']?></td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>

			<h3>Elevator Pitch Results</h3>
			<table class="table">
				<thead>
					<tr>
						<th>#</th><th>Name</th><th>University</th><th>Country</th><th>Points</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$first_passed = false;
					foreach ($results_elev_pitch as $row) {
						if(!$first_passed) {
							$class = 'class="danger"';
							$first_passed = true;
						} else {
							$class = '';
						}
						?>
						<tr <?=$class?> >
							<td><?=$row['index']?></td>
							<td><?=$row['name']?></td>
							<td><?=$row['uni']?></td>
							<td><?=$row['country']?></td>
							<td><?=$row['points']?></td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>

			<h3>Video Challenge Results</h3>
			<table class="table">
				<thead>
					<tr>
						<th>#</th><th>Name</th><th>University</th><th>Country</th><th>Points</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$first_passed = false;
					foreach ($results_video as $row) {
						if(!$first_passed) {
							$class = 'class="danger"';
							$first_passed = true;
						} else {
							$class = '';
						}
						?>
						<tr <?=$class?> >
							<td><?=$row['index']?></td>
							<td><?=$row['name']?></td>
							<td><?=$row['uni']?></td>
							<td><?=$row['country']?></td>
							<td><?=$row['points']?></td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>

		</div>
	</body>
</html>

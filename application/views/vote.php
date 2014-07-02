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
			<h3>Welcome Program Commitee!</h3>
			<h4>Please give a vote to the students</h4>
			<table class="table" >
				<thead>
					<tr>
						<th>Partecipant</th>
						<th>Your votes</th>
						<th style="width: 20px; text-align: center">Action</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$active = 0;
					foreach ($students_list  as $row) {
						if($active % 2) {
							$class = 'class="active"';
						} else {
							$class = '';
						}
						?>
						<tr <?=$class?> > 
							<td style="vertical-align: middle;">  
								<strong><?= $row['name'] ?> </strong>
								<br />
								<?= $row['uni'] ?>
								<br />
								<?= $row['country'] ?>
							</td>
							<td style="vertical-align: middle;"> 
								Poster Session: 	<?= $row['grade_poster'] ?>
								<br />
								Elevator Pitch: 	<?= $row['grade_elevator'] ?>
								<br />
								Video Challenge: 	<?= $row['grade_video'] ?>
								<br />
							</td>
							
							<td style="vertical-align: middle;">
								<button class="btn btn-primary btn-sm" 
									vote_action = "btn_open_modal"
									vote_student_id = "<?= $row['id'] ?>"
									vote_student_name = "<?= $row['name'] ?>"
									vote_student_photo = "<?= base_url().'/media/photos/'.$row['photo'] ?>"
									vote_elev_pitch = "<?= $row['grade_elevator'] ?>"
									vote_poster = "<?= $row['grade_poster'] ?>"
									vote_video = "<?= $row['grade_video'] ?>">
									Vote!
								</button>
							</td> 
						</tr>
						<?php
					}
				?>
				</tbody>
			</table>
		</div>

		<div class="modal fade" id="modal_enter_scores" tabindex="-1" role="dialog" aria-labelledby="modal_student_name" aria-hidden="true">
			<div class="modal-dialog" style="width: 350px">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="modal_student_name"></h4>
					 	<p style="text-align:center; margin-top:10px; margin-bottom:0px; padding:0px;">
							<img id="modal_student_picture" height="150px" style="border: 1px solid black" src="#">
						</p>
					</div>
					<div class="modal-body">
						<p style="text-align:center;">
							Just choose the score from the dropdown list for each category and click 'Save'!
						</p>
						<hr/>
						<table style="width: 100%; margin: auto">
							<tr >
								<td>
									Poster Session
								</td>
								<td>
									<select id = "modal_select_poster" class="form-control">
										<option>0</option>
										<option>0.5</option>
										<option>1</option>
										<option>1.5</option>
										<option>2</option>
										<option>2.5</option>
										<option>3</option>
										<option>3.5</option>
										<option>4</option>
										<option>4.5</option>
										<option>5</option>
										<option>5.5</option>
										<option>6</option>
										<option>6.5</option>
										<option>7</option>
										<option>7.5</option>
										<option>8</option>
										<option>8.5</option>
										<option>9</option>
										<option>9.5</option>
										<option>10</option>
									</select>
								</td>
							</tr>

							<tr>
								<td>
									Elevator Pitch
								</td>
								<td>
									<select id = "modal_select_elev" class="form-control">
										<option>0</option>
										<option>0.5</option>
										<option>1</option>
										<option>1.5</option>
										<option>2</option>
										<option>2.5</option>
										<option>3</option>
										<option>3.5</option>
										<option>4</option>
										<option>4.5</option>
										<option>5</option>
										<option>5.5</option>
										<option>6</option>
										<option>6.5</option>
										<option>7</option>
										<option>7.5</option>
										<option>8</option>
										<option>8.5</option>
										<option>9</option>
										<option>9.5</option>
										<option>10</option>
									</select>
								</td>
							</tr>
		
							<tr>
								<td>
									Video Challenge
								</td>
								<td>
									<select id = "modal_select_video" class="form-control">
										<option>0</option>
										<option>0.5</option>
										<option>1</option>
										<option>1.5</option>
										<option>2</option>
										<option>2.5</option>
										<option>3</option>
										<option>3.5</option>
										<option>4</option>
										<option>4.5</option>
										<option>5</option>
										<option>5.5</option>
										<option>6</option>
										<option>6.5</option>
										<option>7</option>
										<option>7.5</option>
										<option>8</option>
										<option>8.5</option>
										<option>9</option>
										<option>9.5</option>
										<option>10</option>
									</select>
								</td>
							</tr>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-success" data-dismiss="modal" id="modal_save_state" vote_student_id="0">Save</button>
					</div>
				</div>
			</div>
		</div>
	</body>

	<script type='text/javascript'>
		$(document).ready(function() { 
				
			$("button[vote_action='btn_open_modal']").on('click', function (e) {
				e.preventDefault();
				
				var student_id = $(this).attr("vote_student_id");
				var student_name = $(this).attr("vote_student_name");
				var vote_elevator = $(this).attr("vote_elev_pitch");
				var vote_poster = $(this).attr("vote_poster");
				var vote_video = $(this).attr("vote_video");
				var student_photo = $(this).attr("vote_student_photo");

				// Update name
				$('#modal_student_name').html(student_name);
				$('#modal_student_picture').attr('src',student_photo);
				$("#modal_select_elev").val(vote_elevator);
				$("#modal_select_poster").val(vote_poster);
				$("#modal_select_video").val(vote_video);

				// Set the student ID to the save button and show it!
				$('#modal_save_state').attr('vote_student_id', student_id);
				$('#modal_enter_scores').modal();
			});

			$('#modal_save_state').on('click', function (e) {
				// We don't want to hide the modal
				var val_elev = $("#modal_select_elev").val();
				var val_poster = $("#modal_select_poster").val();
				var val_video = $("#modal_select_video").val();
				var student_id = $(this).attr("vote_student_id");
				var request_url = CI.site_url + "vote/get_vote/" + student_id;

				$.ajax({
					url: request_url,
					type: 'POST',
					data: { 
							"grade_poster": val_poster,
							"grade_video" : val_video,
							"grade_elev_pitch": val_elev 
					},
					statusCode: {
						404: function() {
							alert("Error saving your options to the server. Please notify Stefano or Dan");
							console.log("Server returned 404");
						},
						403: function() {
							alert("Error saving your options to the server. Please notify Stefano or Dan");
							console.log("Server returned 404");
						},
						200: function() {
							console.log("All went fine, reloading");
							location.reload();
						}
					}
				});				
			});				 
		});
	</script>
</html>

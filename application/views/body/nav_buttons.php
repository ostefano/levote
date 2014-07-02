<?php
	$current_controller = $this->router->fetch_class();
	function getc($section, $c) {
		if (strcmp($c, $section) == 0) {
			return "class='active'";
		} else {
			return "";
		}
	}
?>
	
<ul class="nav nav-pills">
	<li <?=getc("vote", $current_controller)?>>
		<a href="<?=site_url()?>/vote">Vote</a>
	</li>

	<li <?=getc("results", $current_controller)?>>
		<a href="<?=site_url()?>/results">Results</a>
	</li>
	<?php
	if ($this->sec->user_is_admin()) {
		?><li <?=getc("add_pc", $current_controller)?>><?php
		echo '<a data-href="'.site_url().'/add_pc" data-toggle="modal" data-target="#confirm-delete" href="#" data-body="Confirm adding a new PC member?" data-ok="Generate">Generate Account</a></li>';
		echo '<li><a data-href="'.site_url().'/reset_pc" data-toggle="modal" data-target="#confirm-delete" href="#" data-body="Confirm resetting the PC?" data-ok="Reset">Reset PC</a></li>';
	}
	?>
	<li>
		<a href="<?=site_url()?>/login/logout">Logout</a>
	</li>
</ul>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 350px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Warning!</h4>
			</div>
			<div class="modal-body" id="confirm-delete-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a id="modal-ok-button" href="#" class="btn btn-danger danger"></a>
			</div>
		</div>
	</div>
</div>

<script type='text/javascript'>
	$(document).ready(function() { 
    $('#confirm-delete').on('show.bs.modal', function(e) {
      $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
      $(this).find('#confirm-delete-body').html($(e.relatedTarget).data('body'));
      $(this).find('#modal-ok-button').html($(e.relatedTarget).data('ok'));
    });
  });
</script>
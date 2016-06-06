<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
?>
<div class="table">
	<h3><?php echo _('Type Information'); ?> <?php echo buttoner(); ?></h3>
	<?php
		echo form_open_multipart("", array('class' => 'form-stacked'));
		echo $table;
		echo form_close();
	?>
</div>
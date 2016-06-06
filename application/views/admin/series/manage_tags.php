<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
?>
<?php
$this->buttoner[] = array(
	'text' => _('Delete Tag'),
	'href' => site_url('/admin/series/delete/tag/'.$tag->id),
	'plug' => _('Do you really want to delete this tag?'),
	'class' => "btn-danger"
);
?>
<div class="table">
	<h3><?php echo _('Tag Information'); ?> <?php echo buttoner(); ?></h3>
	<?php
		echo form_open_multipart("", array('class' => 'form-stacked'));
		echo $table;
		echo form_close();
	?>
</div>
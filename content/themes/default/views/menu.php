<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
?>

<div class="list">
	<div class="title">
		<a href="<?php echo site_url($link) ?>"><?php echo $title; ?></a>
		<?php 
		echo form_open("search_".$param."/");
		echo form_input(array('name' => 'search', 'placeholder' => _('To search, type and hit enter'), 'id' => 'searchbox', 'class' => 'fright'));
		echo form_close();
		?>
	</div>
	<?php
	$old = '';
	foreach ( $comics as $key => $comic ) {
		$current = $comic->$param_stub;
		if ($current !== $old)
			echo '<div class="element"><div class="title"><a href="' . base_url () . $param . '/'. $comic->$param_stub .'">' . $comic->$param . '</a></div></div>';
		$old = $current;
	}
	echo prevnext($link.'/', $comics);
	?>
</div>
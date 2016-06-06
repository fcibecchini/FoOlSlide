<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="table" style="padding-bottom: 15px">
	<div class="cont">
<?php
	if (isset($form_title)) echo '<h3 style="float: left;">' . $form_title . '</h3>';
?>
<span style="float: right;">
      <div class="smartsearch">
           <?php
            echo form_open();
            echo form_input(array('name'=>'search', 'placeholder' => _('To search, write and hit enter'), 'class' => 'form-control'));
            echo form_close();
            ?>
       </div>
</span>
     </div>
	<div style="padding-right: 10px">
	<?php
		echo buttoner();
		echo $table;
	?>
	</div>
<?php
	if(isset($users)) {
		if ($users->paged->total_pages > 1) {
?>
		<ul class="pagination" style="margin-bottom: -5px">
			<?php
				if ($users->paged->has_previous)
					echo '<li class="prev"><a href="' . site_url('admin/members/members/'.$users->paged->previous_page) . '">&larr; ' . _('Prev') . '</a></li>';
				else
					echo '<li class="prev disabled"><a href="#">&larr; ' . _('Prev') . '</a></li>';
	
				$page = 1;
				while ($page <= $users->paged->total_pages)
				{
					if ($users->paged->current_page == $page)
						echo '<li class="active"><a href="#">' . $page . '</a></li>';
					else
						echo '<li><a href="' . site_url('admin/members/members/'.$page) .'">' . $page . '</a></li>';
					$page++;
				}
	
				if ($users->paged->has_next)
					echo '<li class="next"><a href="' . site_url('admin/members/members/'.$users->paged->next_page) . '">' . _('Next') . ' &rarr;</a></li>';
				else
					echo '<li class="next disabled"><a href="#">' . _('Next') . ' &rarr;</a></li>';
			?>
		</ul>
<?php
		}
	}
?>
</div>
<?php
	$this->Paginator->options(array(
		'url'=>$this->request->query,
		'convertKeys' => array('name', 'tags', 'time_from','time_to')));
?>

<div class="posts">
	<h2><?php echo __('Posts Search Results');?></h2>

	<?php echo $this->Element('posts'); ?>

	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>


	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>


<div class="categories index">
	<h2><?php echo __('Categories');?></h2>
	<table cellpadding="0" cellspacing="0">
	<?php foreach ($categories as $id=>$name): ?>
	<tr>
		<td><?php echo $id; ?>&nbsp;</td>
		<td><?php echo $name; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('↑'), array('action' => 'moveup', $id)); ?>
			<?php echo $this->Html->link(__('↓'), array('action' => 'movedown', $id)); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $id)); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $id), null, __('Are you sure you want to delete # %s?', $id)); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Category'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
	</ul>
</div>

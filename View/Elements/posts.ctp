<table cellpadding="0" cellspacing="0">
<tr>
		<th><?php echo $this->Paginator->sort('id');?></th>
		<th><?php echo $this->Paginator->sort('subject');?></th>
		<th><?php echo $this->Paginator->sort('body');?></th>
		<th><?php echo $this->Paginator->sort('created');?></th>
		<th><?php echo $this->Paginator->sort('modified');?></th>
		<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php foreach ($posts as $post): ?>
<tr>
	<td><?php echo h($post['Post']['id']); ?>&nbsp;</td>
	<td><?php echo h($post['Post']['subject']); ?>&nbsp;</td>
	<td><?php echo h($post['Post']['body']); ?>&nbsp;</td>
	<td><?php echo $this->Time->format('Y-m-d',$post['Post']['created']); ?>&nbsp;</td>
	<td><?php echo $this->Time->format('Y-m-d',$post['Post']['modified']); ?>&nbsp;</td>
	<td class="actions">
		<?php echo $this->Html->link(__('View'), array('action' => 'view', $post['Post']['id'])); ?>
	</td>
</tr>
<?php endforeach; ?>
</table>
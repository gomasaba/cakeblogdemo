<div class="posts">
<h2><?php  echo __('Post');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($post['Post']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $post['User']['name']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subject'); ?></dt>
		<dd>
			<?php echo h($post['Post']['subject']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Body'); ?></dt>
		<dd>
			<?php echo h($post['Post']['body']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo $this->Time->format('Y-m-d',$post['Post']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo $this->Time->format('Y-m-d',$post['Post']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<h2><?php  echo __('Category');?></h2>
<?php
	$category = Set::extract('Category',$post);
	echo $this->Html->tag('ul');
	foreach($category as $row){
		echo $this->Html->tag('li',$row['name']);
	}
	echo $this->Html->tag('/ul');
?>
<h2><?php  echo __('Tag');?></h2>
<?php
	$category = Set::extract('Tag',$post);
	echo $this->Html->tag('ul');
	foreach($category as $row){
		echo $this->Html->tag('li',$row['name']);
	}
	echo $this->Html->tag('/ul');
?>

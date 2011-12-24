<?php
echo $this->Form->create(false,array(
					'url'=>array('controller'=>'posts','action'=>'search'),
					'type'=>'get'));
?>
	<div style="width:500px;border:1px solid #CCC;padding:8px;float:left;">
	<table>
	<?php
	echo $this->Html->tableCells(array(
					array(
						array('ブログ記事',array('class'=>'head')),
						array(
						$this->Form->input('subject',array(
									'label'=>false,
									'class'=>'span7',
									'error'=>false,
									'empty'=>true,
						)),
							array('class'=>'clearfix')
						),
					),
		));
	echo $this->Html->tableCells(array(
					array(
						array('タグ',array('class'=>'head')),
						array(
						$this->Form->input('tags',array(
									'label'=>false,
									'class'=>'span7',
									'error'=>false,
									'empty'=>true,
						)),
							array('class'=>'clearfix')
						),
					),
		));
	//作成年月日
	echo $this->Html->tableCells(array(
				array(
					array('作成年月日',array('class'=>'head')),
					array(
						$this->Form->input('time_from',array(
							'label'=>false,'empty'=>true,
							'type'=>'date',
							'dateFormat'=>'YMD',
							'timeFormat'=>24,
							'monthNames'=>false,
							'maxYear'=>date('Y')
						)).
						$this->Form->input('time_to',array(
							'label'=>false,'empty'=>true,
							'type'=>'date',
							'dateFormat'=>'YMD',
							'timeFormat'=>24,
							'monthNames'=>false,
							'maxYear'=>date('Y')
						)),
						array('class'=>'clearfix')
					),
				),
	));
	?>
	</table>
	<?php echo $this->Form->submit('検索',array('class'=>'btn primary offset4','div'=>false))?>
	<?php echo $this->Form->end();?>
	</div>


	<div style="margin-left:20px;width:500px;border:1px solid #CCC;padding:8px;float:left;">
	<h2><?php echo __('Category');?></h2>
	<?php
		$out = array();
		foreach($category as $id=>$name){
			$out[] = $this->Html->link($name,array('controller'=>'categories','action'=>'view',$id));
		}
		echo $this->Html->nestedList($out);
	?>
	<h2><?php echo __('Tag');?></h2>
	<?php
		$out = array();
		foreach($tag as $id=>$name){
			$out[] = $this->Html->link($name,array('controller'=>'tags','action'=>'view',$id));
		}
		echo $this->Html->nestedList($out);
	?>
	</div>

	<div style="clear:both;"></div>

<div class="posts">
	<h2><?php echo __('Posts');?></h2>
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

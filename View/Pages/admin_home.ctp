<h2>ブログ管理画面</h2>
<p style="text-align:right;">
<?php echo $this->Html->link('ログアウト',array('controller'=>'users','action'=>'logout','admin'=>true));?>
</p>
<h3>ブログ記事</h3>
<?php
echo $this->Html->nestedList(array(
				$this->Html->link('一覧',array('controller'=>'posts','action'=>'index','admin'=>true)),
				$this->Html->link('新規',array('controller'=>'posts','action'=>'add','admin'=>true)),
));
?>

<h3>タグ</h3>
<?php
echo $this->Html->nestedList(array(
				$this->Html->link('一覧',array('controller'=>'tags','action'=>'index','admin'=>true)),
				$this->Html->link('新規',array('controller'=>'tags','action'=>'add','admin'=>true)),
));
?>

<h3>カテゴリー</h3>
<?php
echo $this->Html->nestedList(array(
				$this->Html->link('一覧',array('controller'=>'categories','action'=>'index','admin'=>true)),
				$this->Html->link('新規',array('controller'=>'categories','action'=>'add','admin'=>true)),
));
?>

<h3>ユーザー</h3>
<?php
echo $this->Html->nestedList(array(
				$this->Html->link('一覧',array('controller'=>'users','action'=>'index','admin'=>true)),
				$this->Html->link('新規',array('controller'=>'users','action'=>'add','admin'=>true)),
));
?>
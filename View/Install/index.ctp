  <!-- Main hero unit for a primary marketing message or call to action -->
  <div class="hero-unit">
	  <h2>セットアップ</h2>
	  <p>初期データをインサートします。インストール完了後はファイルを削除するか、コメントアウトしてください
	  <pre>
	  	public function beforeFilter() {
			<strike>$this->Auth->allow('*');</strike>
			parent::beforeFilter();
		}
	  </pre>
	  </p>

  </div>

  <!-- Example row of columns -->
  <div class="row offset6">
	  <?php echo $this->Html->link('実行！',array('action'=>'run'),array('class'=>'btn primary large'));?>
  </div>
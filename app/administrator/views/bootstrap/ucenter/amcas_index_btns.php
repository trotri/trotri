<form class="form-inline">
<?php foreach ($this->apps as $appId => $prompt) : ?>
<?php
$createIcon = $this->getHtml()->tag(
	'span',
	array(
		'data-original-title' => $this->MOD_UCENTER_URLS_AMCAS_MODCREATE,
		'onclick' => 'return Trotri.href(\'' . $this->getUrlManager()->getUrl('create', '', '', array('amca_pid' => $appId)) . '\')',
		'class' => 'glyphicon glyphicon-plus-sign',
		'data-toggle' => 'tooltip',
		'data-placement' => 'left'
	),
	''
);

echo $this->getHtml()->a(
	$createIcon . $prompt,
	$this->getUrlManager()->getUrl('index', '', '', array('amca_pid' => $appId)),
	array(
		'class' => 'btn btn-' . (($this->app_id == $appId) ? 'primary' : 'default')
	)
);
?>
&nbsp;
<?php endforeach; ?>
</form>
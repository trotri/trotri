<?php
$this->widget(
	'components\adverts\Advert',
	array(
		'type_key' => 'notice'
	)
);
?>

<?php
$this->widget(
	'components\adverts\Adverts',
	array(
		'type_key' => 'friendlinks'
	)
);
?>

<?php echo $this->getHtml()->jsFile($this->js_url . '/mods/posts.js?v=' . $this->version); ?>
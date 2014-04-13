<?php
$formBuilder = $this->createWidget('views\bootstrap\widgets\FormBuilder',
	array(
		'name' => 'permissionmodify',
		'action' => $this->getUrlManager()->getUrl($this->action, '', '', array('id' => $this->id)),
		'errors' => $this->errors,
		'elements' => $this->elements,
		'columns' => array(
			'_button_save_',
			'_button_save2close_',
			'_button_cancel_',
		)
	)
);

$html = $formBuilder->getHtml();
$eleName = 'amcas';
?>

<!-- FormBuilder -->
<?php echo $formBuilder->openForm(); ?>

<ul class="nav nav-tabs">
<?php
$attributes = array('class' => 'active');
foreach ($this->amcas as $appName => $rows) :
	echo $html->openTag('li', $attributes);
	echo $html->a($rows['prompt'], '#'.$appName, array('data-toggle' => 'tab'));
	$attributes = array();
endforeach;
?>
</ul><!-- /.nav nav-tabs -->

<div class="form-group">
  <div class="col-lg-1"></div>
  <div class="col-lg-11"><?php echo $formBuilder->getButtons(); ?></div>
</div><!-- /.form-group -->

<div class="tab-content">

<!-- app -->
<?php
$attributes = array('class' => 'tab-pane fade active in');
foreach ($this->amcas as $appName => $app) :
	echo $html->openTag('div', array('id' => $appName) + $attributes), "\n";
	$attributes = array('class' => 'tab-pane fade');
?>

<!-- mod -->
<?php
foreach ($app['rows'] as $modName => $mod) :
	echo $formBuilder->createElement('views\bootstrap\components\form\ICheckboxElement', array(
		'label' => $mod['prompt'] . ' [' . $modName . '] : ',
		'name' => '__mod__',
		'options' => array(
			$eleName . '[' . $appName . '][' . $modName . ']' => $this->CFG_SYSTEM_GLOBAL_CHECKED_ALL
		),
	))->fetch();
	if (!isset($mod['rows'])) : continue; endif;
?>

<!-- ctrl -->
<?php
foreach ($mod['rows'] as $ctrlName => $ctrl) :
	$name = $eleName . '[' . $appName . '][' . $modName . '][' . $ctrlName . '][]';
	echo $formBuilder->createElement('views\bootstrap\components\form\ICheckboxElement', array(
		'label' => $ctrl['prompt'],
		'name' => $name,
		'options' => $ctrl['powers'],
		'value' => $ctrl['checked']
	))->fetch();
endforeach;
?>
<!-- /ctrl -->

<?php endforeach; ?>
<!-- /mod -->

<?php
	echo "\n", $html->closeTag('div');
endforeach;
?>
<!-- /app -->

</div><!-- /.tab-content -->

<div class="form-group">
  <div class="col-lg-1"></div>
  <div class="col-lg-11"><?php echo $formBuilder->getButtons(); ?></div>
</div><!-- /.form-group -->

<?php echo $formBuilder->closeForm(); ?>

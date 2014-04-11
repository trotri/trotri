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
	$modName = strtolower($modName);
	echo $html->openTag('div', array('class' => 'form-group')), "\n";
	echo $html->tag('label', array('class' => 'control-label'), $mod['prompt']), "\n";
	echo $html->tag('div', array('class' => 'col-lg-4'), ''), "\n";
	echo $html->closeTag('div'), "\n";
	if (!isset($mod['rows'])) : continue; endif;
?>

<!-- ctrl -->
<?php
foreach ($mod['rows'] as $ctrlName => $ctrl) :
	
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

<?php
$elements = $this->element_collections;
$formBuilder = $this->createWidget('ui\bootstrap\widgets\FormBuilder',
	array(
		'name' => 'amcasmodify',
		'action' => $this->getUrlManager()->getUrl($this->action),
		'errors' => $this->errors,
		'elementCollections' => $elements,
		'elements' => array(
			'button_save' => $elements->uiComponents->getButtonSave(),
			'button_save2close' => $elements->uiComponents->getButtonSaveClose(),
			'button_cancel' => $elements->uiComponents->getButtonCancel()
		)
	)
);

$formBuilder->clearTabs()->setTabs($this->tabs);
$tabs = $formBuilder->getTabs();
$eleName = 'amcas';
?>

<!-- FormBuilder -->
<?php
$html = $formBuilder->getHtml();
$aTagAttributes = array('data-toggle' => 'tab');
$activeAttributes = array('class' => 'active');
?>
<?php echo $formBuilder->openForm(); ?>

<ul class="nav nav-tabs">
<?php foreach ($tabs as $tid => $tab) : ?>
<?php $aTag = $html->a($tab['prompt'], '#' . $tid, $aTagAttributes); ?>
<?php echo $html->tag('li', ($tab['active'] ? $activeAttributes : array()), $aTag), "\n"; ?>
<?php endforeach; ?>
</ul><!-- /.nav nav-tabs -->

<div class="form-group">
  <div class="col-lg-1"></div>
  <div class="col-lg-11"><?php echo $formBuilder->getButtons(); ?></div>
</div><!-- /.form-group -->

<div class="tab-content">

<!-- app -->
<?php foreach ($tabs as $tid => $tab) : ?>
<?php $attributes = array('id' => $tid, 'class' => 'tab-pane fade' . ($tab['active'] ? ' active in' : '')); ?>
<?php echo $html->openTag('div', $attributes), "\n"; ?>
<?php if (!isset($this->amcas[$tid]) || !isset($this->amcas[$tid]['rows'])) : continue; endif; ?>

<!-- mod -->
<?php foreach ($this->amcas[$tid]['rows'] as $modName => $mod) : ?>
<?php echo $html->openTag('div', array('class' => 'form-group')), "\n"; ?>
<?php echo $html->tag('label', array('class' => 'control-label'), $mod['prompt']), "\n"; ?>
<?php echo $html->tag('div', array('class' => 'col-lg-4'), ''), "\n"; ?>
<?php echo $html->closeTag('div'), "\n"; ?>
<?php if (!isset($mod['rows'])) : continue; endif; ?>

<!-- ctrl -->
<?php foreach ($mod['rows'] as $ctrlName => $ctrl) : ?>
<?php $options = array(); ?>
<?php $options[$ctrlName] = $ctrl['prompt']; ?>

<?php if (!isset($ctrl['rows'])) : continue; endif; ?>
<!-- act -->
<?php foreach ($ctrl['rows'] as $actName => $act) : ?>
<?php $options[$actName] = $act['prompt']; ?>
<?php endforeach; ?>
<!-- /act -->

<?php
$element = $formBuilder->createElement('modules\\ucenter\\form\\ICheckboxElement', array(
	'name' => $eleName . '[' . $tid . '][' . $modName . '][' . $ctrlName . '][]',
	'options' => $options
));
echo $element->fetch(), "\n";
?>

<?php endforeach; ?>
<!-- /ctrl -->
<?php endforeach; ?>
<!-- /mod -->

<?php echo "\n", $html->closeTag('div'); ?>
<?php endforeach; ?>
<!-- /app -->

</div><!-- /.tab-content -->

<div class="form-group">
  <div class="col-lg-1"></div>
  <div class="col-lg-11"><?php echo $formBuilder->getButtons(); ?></div>
</div><!-- /.form-group -->

<?php echo $formBuilder->closeForm(); ?>
<!-- /FormBuilder -->

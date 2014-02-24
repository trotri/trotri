<?php
$elements = $this->element_collections;
$formBuilder = $this->createWidget('ui\bootstrap\widgets\FormBuilder',
	array(
		'name' => 'amcasmodify',
		'action' => $this->getUrlManager()->getUrl($this->action, '', '', array('id' => $this->id)),
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
$extendParentPermissionIcon = $html->tag('span', array(
	'class' => 'glyphicon glyphicon-share-alt',
	'data-original-title' => $this->CFG_SYSTEM_URLS_UCENTER_EXTEND_PARENT_PERMISSION_LABEL,
	'title' => $this->CFG_SYSTEM_URLS_UCENTER_EXTEND_PARENT_PERMISSION_LABEL
), '');
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

<?php $this->widget('ui\bootstrap\widgets\Breadcrumbs', $this->breadcrumbs); ?>

<div class="form-group">
  <div class="col-lg-1"></div>
  <div class="col-lg-11"><?php echo $formBuilder->getButtons(); ?></div>
</div><!-- /.form-group -->

<div class="tab-content">

<!-- app -->
<?php
foreach ($tabs as $tid => $tab) :
	$attributes = array('id' => $tid, 'class' => 'tab-pane fade' . ($tab['active'] ? ' active in' : ''));
	$appName = strtolower($tid);
	echo $html->openTag('div', $attributes), "\n";
	if (!isset($this->amcas[$appName]) || !isset($this->amcas[$appName]['rows'])) : continue; endif;
?>

<!-- mod -->
<?php
foreach ($this->amcas[$appName]['rows'] as $modName => $mod) :
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
	$ctrlName = strtolower(substr($ctrlName, 0, -10));
	$checkboxName = $eleName . '[' . $appName . '][' . $modName . '][' . $ctrlName . '][]';
	echo $formBuilder->createElement('modules\\ucenter\\form\\GroupsAmcasCbElement', array(
		'name' => '__ctrl__',
		'options' => array($checkboxName => $ctrl['prompt'])
	))->fetch();

	if (!isset($ctrl['rows'])) : continue; endif;

	$options = array();
	foreach ($ctrl['rows'] as $actName => $act) :
		$actName = strtolower(substr($actName, 0, -6));
		$options[$actName] = $act['prompt'];
		if (isset($this->parent_permissions[$appName][$modName][$ctrlName])
			&& in_array($actName, $this->parent_permissions[$appName][$modName][$ctrlName])) :
			$options[$actName] .= '&nbsp;' . $extendParentPermissionIcon;
		endif;
	endforeach;

	$element = $formBuilder->createElement('modules\\ucenter\\form\\GroupsAmcasCbElement', array(
		'name' => $checkboxName,
		'options' => $options,
		'value' => isset($this->permissions[$appName][$modName][$ctrlName]) ? $this->permissions[$appName][$modName][$ctrlName] : array()
	));
	echo $element->fetch();
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
<!-- /FormBuilder -->

<?php echo $this->getHtml()->jsFile($this->base_url . '/static/administrator/js/ucenter.js'); ?>

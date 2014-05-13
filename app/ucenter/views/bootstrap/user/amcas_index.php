<?php
use views\bootstrap\components\ComponentsConstant;
use views\bootstrap\components\ComponentsBuilder;

class TableRender extends views\bootstrap\components\TableRender
{
	public function getAmcaNameLink($data)
	{
		return $this->elements_object->getAmcaNameLink($data);
	}

	public function getAmcaPname($data)
	{
		return $this->elements_object->getAmcaPnameTblColumn($data);
	}

	public function getCategoryLang($data)
	{
		return $this->elements_object->getCategoryLangTblColumn($data);
	}

	public function getOperate($data)
	{
		if (!$this->srv->isMod($data['category'])) {
			return '';
		}

		$params = array(
			'id' => $data['amca_id']
		);

		$modifyIcon = ComponentsBuilder::getGlyphicon(array(
			'type' => ComponentsConstant::GLYPHICON_MODIFY,
			'url' => $this->urlManager->getUrl('modify', $this->controller, $this->module, $params),
			'jsfunc' => ComponentsConstant::JSFUNC_HREF,
			'title' => $this->view->CFG_SYSTEM_GLOBAL_MODIFY,
		));

		$removeIcon = ComponentsBuilder::getGlyphicon(array(
			'type' => ComponentsConstant::GLYPHICON_REMOVE,
			'url' => $this->urlManager->getUrl('remove', $this->controller, $this->module, $params),
			'jsfunc' => ComponentsConstant::JSFUNC_HREF,
			'title' => $this->view->CFG_SYSTEM_GLOBAL_REMOVE,
		));

		$synchIcon = ComponentsBuilder::getGlyphicon(array(
			'type' => ComponentsConstant::GLYPHICON_TOOL,
			'url' => $this->urlManager->getUrl('synch', $this->controller, $this->module, $params),
			'jsfunc' => ComponentsConstant::JSFUNC_HREF,
			'title' => $this->view->MOD_USER_URLS_AMCAS_CTRLSYNCH,
		));

		$output = $modifyIcon . $removeIcon . $synchIcon;
		return $output;
	}
}

$tblRender = new TableRender($this->elements);
?>

<?php $this->display('user/amcas_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'data' => $this->data,
		'table_render' => $tblRender,
		'elements' => array(
			'amca_name' => array(
				'callback' => 'getAmcaNameLink'
			),
			'amca_pname' => array(
				'callback' => 'getAmcaPname'
			),
			'category_lang' => array(
				'callback' => 'getCategoryLang'
			),
		),
		'columns' => array(
			'amca_name',
			'amca_pid',
			'amca_pname',
			'prompt',
			'sort',
			'category',
			'category_lang',
			'amca_id',
			'_operate_',
		),
	)
);
?>

<?php $this->display('user/amcas_index_btns'); ?>
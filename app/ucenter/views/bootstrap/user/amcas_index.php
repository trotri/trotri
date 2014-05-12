<?php
use views\bootstrap\components\ComponentsConstant;
use views\bootstrap\components\ComponentsBuilder;

class TableRender extends views\bootstrap\components\TableRender
{
	public function getAmcaNameLink($data)
	{
		$params = array(
			'id' => $data['amca_id'],
		);

		$url = $this->urlManager->getUrl('view', $this->controller, $this->module, $params);
		$output = $this->html->a($data['amca_name'], $url);
		return $output;
	}

	public function getAmcaPname($data)
	{
		return $this->srv->getAmcaNameByAmcaId($data['amca_pid']);
	}

	public function getCategoryLang($data)
	{
		return $this->srv->getCategoryLangByCategory($data['category']);
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

$tblRender = new TableRender($this);
?>

<?php $this->display('user/amcas_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'data' => $this->data,
		'elements' => array(
			'amca_id' => array(
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_ID_LABEL
			),
			'amca_name' => array(
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_NAME_LABEL,
				'callback' => array($tblRender, 'getAmcaNameLink')
			),
			'amca_pid' => array(
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_PID_LABEL
			),
			'amca_pname' => array(
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_PNAME_LABEL,
				'callback' => array($tblRender, 'getAmcaPname')
			),
			'prompt' => array(
				'label' => $this->MOD_USER_USER_AMCAS_PROMPT_LABEL
			),
			'sort' => array(
				'label' => $this->MOD_USER_USER_AMCAS_SORT_LABEL
			),
			'category' => array(
				'label' => $this->MOD_USER_USER_AMCAS_CATEGORY_LABEL
			),
			'category_lang' => array(
				'label' => $this->MOD_USER_USER_AMCAS_CATEGORY_LABEL,
				'callback' => array($tblRender, 'getCategoryLang')
			),
			'_operate_' => array(
				'label' => $this->CFG_SYSTEM_GLOBAL_OPERATE,
				'callback' => array($tblRender, 'getOperate')
			),
		),
		'columns' => array(
			'amca_name',
			// 'amca_pid',
			// 'amca_pname',
			'prompt',
			'sort',
			// 'category',
			'category_lang',
			'amca_id',
			'_operate_',
		),
	)
);
?>

<?php $this->display('user/amcas_index_btns'); ?>
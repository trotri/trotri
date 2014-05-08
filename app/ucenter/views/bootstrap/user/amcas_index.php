<?php
use views\bootstrap\components\ComponentsConstant;
use views\bootstrap\components\ComponentsBuilder;

class TableRender
{
	public
		$view,
		$urlManager,
		$html,
		$module,
		$controller;

	public function __construct($view)
	{
		$this->view = $view;
		$this->urlManager = $this->view->getUrlManager();
		$this->html = $this->view->getHtml();
		$this->module = $this->view->module;
		$this->controller = $this->view->controller;
	}

	public function getAmcaNameLink($data)
	{
		$params = array(
			'id' => $data['amca_id'],
		);

		$url = $this->urlManager->getUrl('view', $this->controller, $this->module, $params);
		$output = $this->html->a($data['amca_name'], $url);
		return $output;
	}
}

$tableRender = new TableRender($this);
?>

<?php $this->display('user/amcas_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'data' => $this->data,
		'elements' => array(
			'amca_id' => array(
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_ID_LABEL,
			),
			'amca_name' => array(
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_NAME_LABEL,
				'callback' => array($tableRender, 'getAmcaNameLink')
			),
			'amca_pid' => array(
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_PID_LABEL,
			),
			'amca_pname' => array(
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_PNAME_LABEL,
				'callback' => array($this->mod, 'getAmcaPnameTblColumn')
			),
			'prompt' => array(
				'label' => $this->MOD_USER_USER_AMCAS_PROMPT_LABEL,
			),
			'sort' => array(
				'label' => $this->MOD_USER_USER_AMCAS_SORT_LABEL,
			),
			'category' => array(
				'label' => $this->MOD_USER_USER_AMCAS_CATEGORY_LABEL,
				'callback' => array($this->mod, 'getCategoryTblColumn')
			),
			'_operate_' => array(
				'label' => $this->CFG_SYSTEM_GLOBAL_OPERATE,
				'callback' => 'getOperate'
			),
		),
		'columns' => array(
			'amca_name',
			'prompt',
			'sort',
			'category',
			'amca_id',
			'_operate_',
		),
	)
);
?>

<?php $this->display('user/amcas_index_btns'); ?>
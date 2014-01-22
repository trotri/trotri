<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\model;

use tfc\util\FileManager;
use library\BuilderFactory;
use library\ErrorNo;

/**
 * Gc class file
 * 生成代码类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Gc.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.model
 * @since 1.0
 */
class Gc
{
	/**
	 * @var string @author注释：作者名
	 */
	public $authorName = '宋欢';

	/**
	 * @var string @author注释：邮箱
	 */
	public $authorMail = 'trotri@yeah.net';

	/**
	 * @var instance of tfc\util\FileManager
	 */
	protected $_fileManager = null;

	/**
	 * @var integer 生成代码ID
	 */
	protected $_builderId = 0;

	/**
	 * @var array 寄存生成代码表数据
	 */
	protected $_builders = array();

	/**
	 * @var array 寄存表单字段组表数据
	 */
	protected $_groups = array();

	/**
	 * @var array 寄存表单字段表数据
	 */
	protected $_fields = array();

	/**
	 * @var array 寄存所有的目录
	 */
	protected $_dirs = array();

	/**
	 * 构造方法：初始化数据
	 * @param integer $builderId
	 */
	public function __construct($builderId)
	{
		header('Content-Type: text/html; charset=utf-8');

		$this->_builderId = (int) $builderId;
		if ($this->_builderId <= 0) {
			$this->errExit(__LINE__, 'builder_id is not a integer.');
		}

		$this->initBuilders();
		$this->initGroups();
		$this->initFields();

		$this->_fileManager = new FileManager();
		$this->initDir();

		echo '<pre>';
		print_r($this->_builders);
		print_r($this->_groups);
		print_r($this->_fields);
		print_r($this->_dirs);
		echo '</pre>';
	}

	/**
	 * 生成代码
	 * @return void
	 */
	public function build()
	{
		$this->buildLang();
		$this->buildViews();
		$this->buildController();
		$this->buildDb();
		$this->buildElements();
		$this->buildModel();
		$this->buildUi();
	}

	/**
	 * 创建Controller
	 * @return void
	 */
	public function buildController()
	{
		$modName = $this->_builders['mod_name'];
		$facName = $this->_builders['uc_fac_name'];
		$clsName = $this->_builders['uc_cls_name'];
		$ctrlName = $this->_builders['uc_ctrl_name'] . 'Controller';
		$actIndexName = $this->_builders['act_index_name'];
		$actCreateName = $this->_builders['act_create_name'];
		$actModifyName = $this->_builders['act_modify_name'];
		$actRemoveName = $this->_builders['act_remove_name'];
		$actViewName = $this->_builders['act_view_name'];

		$filePath = $this->_dirs['ctrl'] . DS . $ctrlName . '.php';
		$stream = $this->fopen($filePath);
		$this->writeComment($stream);

		fwrite($stream, "namespace modules\\{$modName}\\controller;\n\n");
		fwrite($stream, "use library\\BaseController;\n");
		fwrite($stream, "use tfc\\ap\\Ap;\n");
		fwrite($stream, "use tfc\\mvc\\Mvc;\n");
		fwrite($stream, "use library\\ErrorNo;\n");
		fwrite($stream, "use library\\Url;\n");
		fwrite($stream, "use library\\{$facName};\n\n");
		fwrite($stream, "/**\n");
		fwrite($stream, " * {$ctrlName} class file\n");
		fwrite($stream, " * 控制器类\n");
		fwrite($stream, " * @author {$this->authorName} <{$this->authorMail}>\n");
		fwrite($stream, " * @version \$Id: {$ctrlName}.php 1 " . date('Y-m-d H:i:s') . "Z huan.song \$\n");
		fwrite($stream, " * @package modules.{$modName}.controller\n");
		fwrite($stream, " * @since 1.0\n");
		fwrite($stream, " */\n");
		fwrite($stream, "class {$ctrlName} extends BaseController\n");
		fwrite($stream, "{\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 查询数据列表\n");
		fwrite($stream, "\t * @return void\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function {$actIndexName}Action()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$ret = array();\n\n");
		fwrite($stream, "\t\t\$req = Ap::getRequest();\n");
		fwrite($stream, "\t\t\$viw = Mvc::getView();\n");
		fwrite($stream, "\t\t\$mod = {$facName}::getModel('{$clsName}');\n");
		fwrite($stream, "\t\t\$ele = {$facName}::getElements('{$clsName}');\n\n");
		fwrite($stream, "\t\t\$pageNo = Url::getCurrPage();\n");
		fwrite($stream, "\t\t\$order = '';\n");
		fwrite($stream, "\t\t\$params = array();\n");
		fwrite($stream, "\t\t\$ret = \$mod->search(\$params, \$order, \$pageNo);\n");
		fwrite($stream, "\t\tUrl::setHttpReturn(\$ret['params']['attributes'], \$ret['params']['curr_page']);\n\n");
		fwrite($stream, "\t\t\$viw->assign('element_collections', \$ele);\n");
		fwrite($stream, "\t\t\$viw->assign('http_return', Url::getHttpReturn());\n");
		fwrite($stream, "\t\t\$this->render(\$ret);\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 新增数据\n");
		fwrite($stream, "\t * @return void\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function {$actCreateName}Action()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$ret = array();\n\n");
		fwrite($stream, "\t\t\$req = Ap::getRequest();\n");
		fwrite($stream, "\t\t\$viw = Mvc::getView();\n");
		fwrite($stream, "\t\t\$mod = {$facName}::getModel('{$clsName}');\n");
		fwrite($stream, "\t\t\$ele = {$facName}::getElements('{$clsName}');\n\n");
		fwrite($stream, "\t\tif (\$this->isPost()) {\n");
		fwrite($stream, "\t\t\t\$ret = \$mod->create(\$req->getPost());\n");
		fwrite($stream, "\t\t\tif (\$ret['err_no'] === ErrorNo::SUCCESS_NUM) {\n");
		fwrite($stream, "\t\t\t\tif (\$this->isSubmitTypeSave()) {\n");
		fwrite($stream, "\t\t\t\t\tUrl::forward('{$actModifyName}', Mvc::\$controller, Mvc::\$module, \$ret);\n");
		fwrite($stream, "\t\t\t\t}\n");
		fwrite($stream, "\t\t\t\telseif (\$this->isSubmitTypeSaveNew()) {\n");
		fwrite($stream, "\t\t\t\t\tUrl::forward('{$actCreateName}', Mvc::\$controller, Mvc::\$module, \$ret);\n");
		fwrite($stream, "\t\t\t\t}\n");
		fwrite($stream, "\t\t\t\telseif (\$this->isSubmitTypeSaveClose()) {\n");
		fwrite($stream, "\t\t\t\t\tUrl::forward('{$actIndexName}', Mvc::\$controller, Mvc::\$module, \$ret);\n");
		fwrite($stream, "\t\t\t\t}\n");
		fwrite($stream, "\t\t\t}\n");
		fwrite($stream, "\t\t}\n\n");
		fwrite($stream, "\t\t\$viw->assign('element_collections', \$ele);\n");
		fwrite($stream, "\t\t\$this->render(\$ret);\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 编辑数据\n");
		fwrite($stream, "\t * @return void\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function {$actModifyName}Action()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$ret = array();\n\n");
		fwrite($stream, "\t\t\$req = Ap::getRequest();\n");
		fwrite($stream, "\t\t\$viw = Mvc::getView();\n");
		fwrite($stream, "\t\t\$mod = {$facName}::getModel('{$clsName}');\n");
		fwrite($stream, "\t\t\$ele = {$facName}::getElements('{$clsName}');\n\n");
		fwrite($stream, "\t\t\$httpReturn = Url::getHttpReturn();\n");
		fwrite($stream, "\t\tif (\$httpReturn === '') {\n");
		fwrite($stream, "\t\t\t\$httpReturn = Url::getUrl('{$actIndexName}', Mvc::\$controller, Mvc::\$module, array());\n");
		fwrite($stream, "\t\t}\n\n");
		fwrite($stream, "\t\t\$id = \$req->getInteger('id');\n");

		fwrite($stream, "\t\tif (\$this->isPost()) {\n");
		fwrite($stream, "\t\t\t\$ret = \$mod->modifyByPk(\$id, \$req->getPost());\n");
		fwrite($stream, "\t\t\tif (\$ret['err_no'] === ErrorNo::SUCCESS_NUM) {\n");
		fwrite($stream, "\t\t\t\tif (\$this->isSubmitTypeSave()) {\n");
		fwrite($stream, "\t\t\t\t\t\$ret['http_return'] = \$httpReturn;\n");
		fwrite($stream, "\t\t\t\t\tUrl::forward('{$actModifyName}', Mvc::\$controller, Mvc::\$module, \$ret);\n");
		fwrite($stream, "\t\t\t\t}\n");
		fwrite($stream, "\t\t\t\telseif (\$this->isSubmitTypeSaveNew()) {\n");
		fwrite($stream, "\t\t\t\t\tUrl::forward('{$actCreateName}', Mvc::\$controller, Mvc::\$module, \$ret);\n");
		fwrite($stream, "\t\t\t\t}\n");
		fwrite($stream, "\t\t\t\telseif (\$this->isSubmitTypeSaveClose()) {\n");
		fwrite($stream, "\t\t\t\t\t\$url = Url::applyParams(\$httpReturn, \$ret);\n");
		fwrite($stream, "\t\t\t\t\tUrl::redirect(\$url);\n");
		fwrite($stream, "\t\t\t\t}\n");
		fwrite($stream, "\t\t\t}\n\n");
		fwrite($stream, "\t\t\t\$ret['data'] = \$req->getPost();\n");
		fwrite($stream, "\t\t}\n");
		fwrite($stream, "\t\telse {\n");
		fwrite($stream, "\t\t\t\$ret = \$mod->findByPk(\$id);\n");
		fwrite($stream, "\t\t}\n\n");
		fwrite($stream, "\t\t\$viw->assign('element_collections', \$ele);\n");
		fwrite($stream, "\t\t\$viw->assign('id', \$id);\n");
		fwrite($stream, "\t\t\$this->render(\$ret);\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 删除数据\n");
		fwrite($stream, "\t * @return void\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function {$actRemoveName}Action()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$ret = array();\n\n");
		fwrite($stream, "\t\t\$req = Ap::getRequest();\n");
		fwrite($stream, "\t\t\$mod = {$facName}::getModel('{$clsName}');\n\n");
		fwrite($stream, "\t\t\$id = \$req->getInteger('id');\n");
		fwrite($stream, "\t\t\$ret = \$mod->deleteByPk(\$id);\n");
		fwrite($stream, "\t\tUrl::httpReturn(\$ret);\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 编辑单个字段\n");
		fwrite($stream, "\t * @return void\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function single{$actModifyName}Action()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$ret = array();\n\n");
		fwrite($stream, "\t\t\$req = Ap::getRequest();\n");
		fwrite($stream, "\t\t\$mod = {$facName}::getModel('{$clsName}');\n\n");
		fwrite($stream, "\t\t\$id = \$req->getInteger('id');\n");
		fwrite($stream, "\t\t\$columnName = \$req->getTrim('column_name', '');\n");
		fwrite($stream, "\t\t\$value = \$req->getParam('value', '');\n");
		fwrite($stream, "\t\t\$ret = \$mod->updateByPk(\$id, array(\$columnName => \$value));\n");
		fwrite($stream, "\t\tUrl::httpReturn(\$ret);\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 查询数据详情\n");
		fwrite($stream, "\t * @return void\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function {$actViewName}Action()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "}\n");
		fclose($stream);
	}

	/**
	 * 创建Db
	 * @return void
	 */
	public function buildDb()
	{
		$modName = $this->_builders['mod_name'];
		$clsName = $this->_builders['uc_cls_name'];
		$tblName = $this->_builders['tbl_name'];
		$filePath = $this->_dirs['db'] . DS . $clsName . '.php';
		$stream = $this->fopen($filePath);
		$this->writeComment($stream);

		fwrite($stream, "namespace modules\\{$modName}\\db;\n\n");
		fwrite($stream, "use library\\Db;\n\n");
		fwrite($stream, "/**\n");
		fwrite($stream, " * {$clsName} class file\n");
		fwrite($stream, " * 数据库操作层类\n");
		fwrite($stream, " * @author {$this->authorName} <{$this->authorMail}>\n");
		fwrite($stream, " * @version \$Id: {$clsName}.php 1 " . date('Y-m-d H:i:s') . "Z huan.song \$\n");
		fwrite($stream, " * @package modules.{$modName}.db\n");
		fwrite($stream, " * @since 1.0\n");
		fwrite($stream, " */\n");

		fwrite($stream, "class {$clsName} extends Db\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 构造方法：初始化表名\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function __construct()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\tparent::__construct('{$tblName}');\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "}\n");
		fclose($stream);
	}

	/**
	 * 创建Elements
	 * @return void
	 */
	public function buildElements()
	{
		$modName = $this->_builders['mod_name'];
		$facName = $this->_builders['uc_fac_name'];
		$clsName = $this->_builders['uc_cls_name'];
		$filePath = $this->_dirs['ele'] . DS . $clsName . '.php';
		$stream = $this->fopen($filePath);
		$this->writeComment($stream);

		fwrite($stream, "namespace modules\\{$modName}\\elements;\n\n");
		fwrite($stream, "use tfc\\saf\\Text;\n");
		fwrite($stream, "use ui\\ElementCollections;\n");
		fwrite($stream, "use library\\{$facName};\n\n");
		fwrite($stream, "/**\n");
		fwrite($stream, " * {$clsName} class file\n");
		fwrite($stream, " * 字段信息配置类，包括表格、表单、验证规则、选项\n");
		fwrite($stream, " * @author {$this->authorName} <{$this->authorMail}>\n");
		fwrite($stream, " * @version \$Id: {$clsName}.php 1 " . date('Y-m-d H:i:s') . "Z huan.song \$\n");
		fwrite($stream, " * @package modules.{$modName}.elements\n");
		fwrite($stream, " * @since 1.0\n");
		fwrite($stream, " */\n");

		fwrite($stream, "class {$clsName} extends ElementCollections\n");
		fwrite($stream, "{\n");

		foreach ($this->_fields as $fields) {
			if (isset($fields['enums'])) {
				foreach ($fields['enums'] as $key => $value) {
					fwrite($stream, "\t/**\n");
					fwrite($stream, "\t * @var string {$fields['field_name']}：{$value}\n");
					fwrite($stream, "\t */\n");
					fwrite($stream, "\tconst {$key} = '{$value}';\n\n");
				}
			}
		}

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * @var ui\\bootstrap\\Components 页面小组件类\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic \$uiComponents = null;\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 构造方法：初始化页面小组件类\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function __construct()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$this->uiComponents = {$facName}::getUi('{$clsName}');\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see ui.ElementCollections::getViewTabsRender()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function getViewTabsRender()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$output = array(\n");
		foreach ($this->_groups as $groups) {
			if ($groups['group_name'] != 'main') {
				fwrite($stream, "\t\t\t'{$groups['group_name']}' => array(\n");
				fwrite($stream, "\t\t\t\t'tid' => '{$groups['group_name']}',\n");
				fwrite($stream, "\t\t\t\t'prompt' => Text::_('{$groups['lang_key']}')\n");
				fwrite($stream, "\t\t\t),\n");
			}
		}
		fwrite($stream, "\t\t);\n\n");
		fwrite($stream, "\t\treturn \$output;\n");
		fwrite($stream, "\t}\n\n");

		foreach ($this->_fields as $fields) {
			fwrite($stream, "\t/**\n");
			fwrite($stream, "\t * 获取“{$fields['column_comment']}”配置\n");
			fwrite($stream, "\t * @param integer \$type\n");
			fwrite($stream, "\t * @return array\n");
			fwrite($stream, "\t */\n");
			fwrite($stream, "\tpublic function get{$fields['func_name']}(\$type)\n");
			fwrite($stream, "\t{\n");
			fwrite($stream, "\t\t\$output = array();\n");
			if (isset($fields['enums'])) {
				fwrite($stream, "\t\t\$options = array(\n");
				foreach ($fields['enums'] as $key => $value) {
					fwrite($stream, "\t\t\tself::{$key} => self::{$key},\n");
				}
				fwrite($stream, "\t\t);\n\n");
			}

			fwrite($stream, "\t\t\$name = '{$fields['field_name']}';\n\n");

			fwrite($stream, "\t\tif (\$type === self::TYPE_TABLE) {\n");
			fwrite($stream, "\t\t\t\$output = array(\n");
			fwrite($stream, "\t\t\t\t'label' => Text::_('{$fields['lang_label']}'),\n");
			fwrite($stream, "\t\t\t);\n");
			fwrite($stream, "\t\t}\n");

			fwrite($stream, "\t\telseif (\$type === self::TYPE_FORM) {\n");
			fwrite($stream, "\t\t\t\$output = array(\n");
			fwrite($stream, "\t\t\t\t'__tid__' => '{$fields['groups']['group_name']}',\n");
			fwrite($stream, "\t\t\t\t'type' => '{$fields['types']['form_type']}',\n");
			fwrite($stream, "\t\t\t\t'label' => Text::_('{$fields['lang_label']}'),\n");
			fwrite($stream, "\t\t\t\t'hint' => Text::_('{$fields['lang_hint']}'),\n");
			if ($fields['form_required'] == 'y') {
				fwrite($stream, "\t\t\t\t'required' => true,\n");
			}
			if ($fields['form_modifiable'] == 'y') {
				fwrite($stream, "\t\t\t\t'disabled' => true,\n");
			}
			if (isset($fields['enums'])) {
				fwrite($stream, "\t\t\t\t'options' => \$options,\n");
				fwrite($stream, "\t\t\t\t'value' => self::" . array_shift(array_keys($fields['enums'])) . ",\n");
			}
			fwrite($stream, "\t\t\t);\n");
			fwrite($stream, "\t\t}\n");

			fwrite($stream, "\t\telseif (\$type === self::TYPE_FILTER) {\n");
			fwrite($stream, "\t\t\t\$output = array(\n");
			foreach ($fields['validators'] as $validators) {
				$options = $validators['options'];
				switch ($validators['option_category']) {
					case 'integer' :
						$options = (int) $options;
						break;
					case 'boolean' :
						$options = 'true';
						break;
					case 'array' :
						$options = 'array()';
						break;
					case 'string' :
					default :
						$options = "'" . (string) $options . "'";
						break;
				}

				if (isset($fields['enums'])) {
					$options = 'array_keys($options)';
				}
				fwrite($stream, "\t\t\t\t'{$validators['validator_name']}' => array({$options}, Text::_('{$validators['lang_key']}')),\n");
			}
			fwrite($stream, "\t\t\t);\n");
			fwrite($stream, "\t\t}\n");

			if (isset($fields['enums'])) {
				fwrite($stream, "\t\telseif (\$type === self::TYPE_OPTIONS) {\n");
				fwrite($stream, "\t\t\t\$output = \$options;\n");
				fwrite($stream, "\t\t}\n");
			}

			if ($fields['form_search_show'] === 'y') {
				fwrite($stream, "\t\telseif (\$type === self::TYPE_SEARCH) {\n");
				fwrite($stream, "\t\t\t\$output = array(\n");
				if ($fields['types']['category'] === 'option') {
					fwrite($stream, "\t\t\t\t'type' => 'select',\n");
				}
				else {
					fwrite($stream, "\t\t\t\t'type' => 'text',\n");
				}
				fwrite($stream, "\t\t\t\t'placeholder' => Text::_('{$fields['lang_label']}'),\n");
				fwrite($stream, "\t\t\t);\n");
				fwrite($stream, "\t\t}\n");
			}

			fwrite($stream, "\n\t\treturn \$output;\n");
			fwrite($stream, "\t}\n\n");
		}

		fwrite($stream, "}\n");
		fclose($stream);
	}

	/**
	 * 创建Model
	 * @return void
	 */
	public function buildModel()
	{
		$modName = $this->_builders['mod_name'];
		$facName = $this->_builders['uc_fac_name'];
		$clsName = $this->_builders['uc_cls_name'];
		$filePath = $this->_dirs['mod'] . DS . $clsName . '.php';
		$stream = $this->fopen($filePath);
		$this->writeComment($stream);

		fwrite($stream, "namespace modules\\{$modName}\\model;\n\n");
		fwrite($stream, "use tfc\\ap\\Ap;\n");
		fwrite($stream, "use tfc\\ap\\Registry;\n");
		fwrite($stream, "use koala\\Model;\n");
		fwrite($stream, "use library\\ErrorNo;\n");
		fwrite($stream, "use library\\{$facName};\n\n");
		fwrite($stream, "/**\n");
		fwrite($stream, " * {$clsName} class file\n");
		fwrite($stream, " * 业务处理层类\n");
		fwrite($stream, " * @author {$this->authorName} <{$this->authorMail}>\n");
		fwrite($stream, " * @version \$Id: {$clsName}.php 1 " . date('Y-m-d H:i:s') . "Z huan.song \$\n");
		fwrite($stream, " * @package modules.{$modName}.model\n");
		fwrite($stream, " * @since 1.0\n");
		fwrite($stream, " */\n");
		fwrite($stream, "class {$clsName} extends Model\n");
		fwrite($stream, "{\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 构造方法：初始化当前业务类对应的数据库操作类\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function __construct()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$db = {$facName}::getDb('{$clsName}');\n");
		fwrite($stream, "\t\tparent::__construct(\$db);\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 查询数据\n");
		fwrite($stream, "\t * @param array \$params\n");
		fwrite($stream, "\t * @param string \$order\n");
		fwrite($stream, "\t * @param integer \$pageNo\n");
		fwrite($stream, "\t * @return array\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function search(array \$params = array(), \$order = '', \$pageNo = 0)\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$attributes = array();\n");
		fwrite($stream, "\t\t//--待开发--\n");
		fwrite($stream, "\t\t\$ret = \$this->findIndexByAttributes(\$attributes, \$order, \$pageNo);\n");
		fwrite($stream, "\t\treturn \$ret;\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 新增一条记录\n");
		fwrite($stream, "\t * @param array \$params\n");
		fwrite($stream, "\t * @return array\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function create(array \$params = array())\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t//--待开发--\n");
		fwrite($stream, "\t\treturn \$this->insert(\$params);\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 通过主键，编辑一条记录\n");
		fwrite($stream, "\t * @param integer \$value\n");
		fwrite($stream, "\t * @param array \$params\n");
		fwrite($stream, "\t * @return array\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function modifyByPk(\$value, array \$params)\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t//--待开发--\n");
		fwrite($stream, "\t\treturn \$this->updateByPk(\$value, \$params);\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see koala.Model::getInsertRules()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function getInsertRules()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$elements = {$facName}::getElements('{$clsName}');\n");
		fwrite($stream, "\t\t\$type = \$elements::TYPE_FILTER;\n");
		fwrite($stream, "\t\t\$output = array(\n");
		foreach ($this->_fields as $fields) {
			fwrite($stream, "\t\t\t'{$fields['field_name']}' => \$elements->get{$fields['func_name']}(\$type),\n");
		}
		fwrite($stream, "\t\t);\n\n");
		fwrite($stream, "\t\treturn \$output;\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see koala.Model::getUpdateRules()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function getUpdateRules()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$elements = {$facName}::getElements('{$clsName}');\n");
		fwrite($stream, "\t\t\$type = \$elements::TYPE_FILTER;\n");
		fwrite($stream, "\t\t\$output = array(\n");
		foreach ($this->_fields as $fields) {
			fwrite($stream, "\t\t\t'{$fields['field_name']}' => \$elements->get{$fields['func_name']}(\$type),\n");
		}
		fwrite($stream, "\t\t);\n\n");
		fwrite($stream, "\t\treturn \$output;\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "}\n");
		fclose($stream);
	}

	/**
	 * 创建Ui
	 * @return void
	 */
	public function buildUi()
	{
		$modName = $this->_builders['mod_name'];
		$facName = $this->_builders['uc_fac_name'];
		$clsName = $this->_builders['uc_cls_name'];
		$actIndexName = $this->_builders['act_index_name'];
		$actCreateName = $this->_builders['act_create_name'];
		$actModifyName = $this->_builders['act_modify_name'];
		$actRemoveName = $this->_builders['act_remove_name'];
		$actViewName = $this->_builders['act_view_name'];
		$actTrashName = 'trash';
		$indexRowBtns = explode(',', $this->_builders['index_row_btns']);
		$filePath = $this->_dirs['ui'] . DS . $clsName . '.php';
		$stream = $this->fopen($filePath);
		$this->writeComment($stream);

		fwrite($stream, "namespace modules\\{$modName}\\ui\\bootstrap;\n\n");
		fwrite($stream, "use ui\\bootstrap\\Components;\n");
		fwrite($stream, "use tfc\\ap\\Ap;\n");
		fwrite($stream, "use tfc\\mvc\\Mvc;\n");
		fwrite($stream, "use tfc\\saf\\Text;\n");
		fwrite($stream, "use library\\Url;\n");
		fwrite($stream, "use library\\{$facName};\n\n");

		fwrite($stream, "/**\n");
		fwrite($stream, " * {$clsName} class file\n");
		fwrite($stream, " * 页面小组件类，基于Bootstrap-v3前端开发框架\n");
		fwrite($stream, " * @author {$this->authorName} <{$this->authorMail}>\n");
		fwrite($stream, " * @version \$Id: {$clsName}.php 1 " . date('Y-m-d H:i:s') . "Z huan.song \$\n");
		fwrite($stream, " * @package modules.{$modName}.ui.bootstrap\n");
		fwrite($stream, " * @since 1.0\n");
		fwrite($stream, " */\n");
		fwrite($stream, "class {$clsName}\n");
		fwrite($stream, "{\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 获取表单的“保存”按钮\n");
		fwrite($stream, "\t * @return array\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function getButtonSave()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\treturn Components::getButtonSave();\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 获取表单的“保存并关闭”按钮\n");
		fwrite($stream, "\t * @return array\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function getButtonSaveClose()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\treturn Components::getButtonSaveClose();\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 获取表单的“保存并新建”按钮\n");
		fwrite($stream, "\t * @return array\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function getButtonSaveNew()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\treturn Components::getButtonSaveNew();\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 获取表单的“取消”按钮\n");
		fwrite($stream, "\t * @return array\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function getButtonCancel()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$url = '--待开发--';\n");
		fwrite($stream, "\t\treturn Components::getButtonCancel(\$url);\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 获取操作图标按钮\n");
		fwrite($stream, "\t * @param array \$data\n");
		fwrite($stream, "\t * @return string\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function getOperate(\$data)\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$params = array('--待开发--');\n\n");

		$iconBtns = array();
		foreach ($indexRowBtns as $value) {
			if ($value === 'pencil') {
				$modifyUrl = '$modifyUrl = Url::getUrl(\'' . $actModifyName . '\', Mvc::$controller, Mvc::$module, $params);';
				$modifyIcon = '$modifyIcon = Components::getGlyphicon(Components::GLYPHICON_PENCIL, $modifyUrl, Components::JSFUNC_HREF, Text::_(\'CFG_SYSTEM_GLOBAL_MODIFY\'));';
				fwrite($stream, "\t\t$modifyUrl\n");
				fwrite($stream, "\t\t$modifyIcon\n\n");
				$iconBtns[] = '$modifyIcon';
			}
			elseif ($value === 'trash') {
				$trashUrl = '$trashUrl = Url::getUrl(\'' . $actTrashName . '\', Mvc::$controller, Mvc::$module, $params);';
				$trashIcon = '$trashIcon = Components::getGlyphicon(Components::GLYPHICON_TRASH, $trashUrl, Components::JSFUNC_DIALOGTRASH, Text::_(\'CFG_SYSTEM_GLOBAL_TRASH\'));';
				fwrite($stream, "\t\t$trashUrl\n");
				fwrite($stream, "\t\t$trashIcon\n\n");
				$iconBtns[] = '$trashIcon';
			}
			elseif ($value === 'remove') {
				$removeUrl = '$removeUrl = Url::getUrl(\'' . $actRemoveName . '\', Mvc::$controller, Mvc::$module, $params);';
				$removeIcon = '$removeIcon = Components::getGlyphicon(Components::GLYPHICON_REMOVE_SIGN, $removeUrl, Components::JSFUNC_DIALOGREMOVE, Text::_(\'CFG_SYSTEM_GLOBAL_REMOVE\'));';
				fwrite($stream, "\t\t$removeUrl\n");
				fwrite($stream, "\t\t$removeIcon\n\n");
				$iconBtns[] = '$removeIcon';
			}
		}

		if ($iconBtns !== array()) {
			fwrite($stream, "\t\t\$ret = " . implode(' . ', $iconBtns) . ";\n");
		}
		else {
			fwrite($stream, "\t\t\$ret = '';\n");
		}

		fwrite($stream, "\t\treturn \$ret;\n");
		fwrite($stream, "\t}\n");

		fwrite($stream, "}\n");
		fclose($stream);
	}

	/**
	 * 创建Views
	 * @return void
	 */
	public function buildViews()
	{
		$tmpListIndexShows = array();
		$tmpFormCreateShows = array();
		$tmpFormModifyShows = array();
		foreach ($this->_fields as $value) {
			if ($value['index_show'] == 'y') {
				$tmpListIndexShows[$value['index_sort']][] = $value['field_name'];
			}

			if ($value['form_create_show'] == 'y') {
				$tmpFormCreateShows[$value['form_create_sort']][] = $value['field_name'];
			}

			if ($value['form_modify_show'] == 'y') {
				$tmpFormModifyShows[$value['form_modify_sort']][] = $value['field_name'];
			}
		}

		ksort($tmpListIndexShows);
		ksort($tmpFormCreateShows);
		ksort($tmpFormModifyShows);

		$listIndexShows = array();
		$formCreateShows = array();
		$formModifyShows = array();
		foreach ($tmpListIndexShows as $columnNames) {
			foreach ($columnNames as $columnName) {
				$listIndexShows[] = $columnName;
			}
		}

		foreach ($tmpFormCreateShows as $columnNames) {
			foreach ($columnNames as $columnName) {
				$formCreateShows[] = $columnName;
			}
		}

		foreach ($tmpFormModifyShows as $columnNames) {
			foreach ($columnNames as $columnName) {
				$formModifyShows[] = $columnName;
			}
		}

		$appName = $this->_builders['app_name'];
		$modName = $this->_builders['mod_name'];
		$ctrlName = $this->_builders['ctrl_name'];
		$actIndexName = $this->_builders['act_index_name'];
		$actCreateName = $this->_builders['act_create_name'];
		$actModifyName = $this->_builders['act_modify_name'];
		$viewDir = $this->_dirs['view'];

		// Index Btn页面
		$indexBtnsFileName = $ctrlName . '_' . $actIndexName . '_btns';
		$filePath = $viewDir . DS . $indexBtnsFileName . '.php';
		$stream = $this->fopen($filePath);
		fclose($stream);

		// Index页面
		$filePath = $viewDir . DS . $ctrlName . '_' . $actIndexName . '.php';
		$stream = $this->fopen($filePath);
		fwrite($stream, "<?php \$this->display('{$modName}/{$indexBtnsFileName}'); ?>\n\n");
		fwrite($stream, "<?php\n");
		fwrite($stream, "\$elements = \$this->element_collections;\n");
		fwrite($stream, "\$this->widget(\n");
		fwrite($stream, "\t'ui\\bootstrap\\widgets\\TableBuilder',\n");
		fwrite($stream, "\tarray(\n");
		fwrite($stream, "\t\t'elementCollections' => \$elements,\n");
		fwrite($stream, "\t\t'data' => \$this->data,\n");
		fwrite($stream, "\t\t'columns' => array(\n");
		foreach ($listIndexShows as $columnName) {
			fwrite($stream, "\t\t\t'{$columnName}',\n");
		}
		fwrite($stream, "\t\t\t'operate' => array(\n");
		fwrite($stream, "\t\t\t\t'label' => \$this->CFG_SYSTEM_GLOBAL_OPERATE,\n");
		fwrite($stream, "\t\t\t\t'callback' => array(\$elements->uiComponents, 'getOperate')\n");
		fwrite($stream, "\t\t\t),\n");
		fwrite($stream, "\t\t)\n");
		fwrite($stream, "\t)\n");
		fwrite($stream, ");\n");
		fwrite($stream, "?>\n\n");
		fwrite($stream, "<?php \$this->display('{$modName}/{$indexBtnsFileName}'); ?>\n\n");
		fwrite($stream, "<?php\n");
		fwrite($stream, "\$this->widget(\n");
		fwrite($stream, "\t'ui\\bootstrap\\widgets\\PaginatorBuilder',\n");
		fwrite($stream, "\t\$this->paginator\n");
		fwrite($stream, ");\n");
		fwrite($stream, "?>\n\n");
		fwrite($stream, "<?php echo \$this->getHtml()->jsFile(\$this->base_url . '/static/{$appName}/js/{$modName}.js'); ?>\n");
		fclose($stream);

		// Create页面
		$filePath = $viewDir . DS . $ctrlName . '_' . $actCreateName . '.php';
		$stream = $this->fopen($filePath);
		fwrite($stream, "<?php\n");
		fwrite($stream, "\$elements = \$this->element_collections;\n");
		fwrite($stream, "\$this->widget('ui\\bootstrap\\widgets\\FormBuilder',\n");
		fwrite($stream, "\tarray(\n");
		fwrite($stream, "\t\t'name' => 'create',\n");
		fwrite($stream, "\t\t'action' => \$this->getUrlManager()->getUrl(\$this->action),\n");
		fwrite($stream, "\t\t'errors' => \$this->errors,\n");
		fwrite($stream, "\t\t'elementCollections' => \$elements,\n");
		fwrite($stream, "\t\t'elements' => array(\n");
		foreach ($formCreateShows as $columnName) {
			fwrite($stream, "\t\t\t'{$columnName}',\n");
		}
		fwrite($stream, "\t\t\t'button_save' => \$elements->uiComponents->getButtonSave(),\n");
		fwrite($stream, "\t\t\t'button_save2close' => \$elements->uiComponents->getButtonSaveClose(),\n");
		fwrite($stream, "\t\t\t'button_save2new' => \$elements->uiComponents->getButtonSaveNew(),\n");
		fwrite($stream, "\t\t\t'button_cancel' => \$elements->uiComponents->getButtonCancel()\n");
		fwrite($stream, "\t\t)\n");
		fwrite($stream, "\t)\n");
		fwrite($stream, ");\n");
		fclose($stream);

		// Modify页面
		$filePath = $viewDir . DS . $ctrlName . '_' . $actModifyName . '.php';
		$stream = $this->fopen($filePath);
		fwrite($stream, "<?php\n");
		fwrite($stream, "\$elements = \$this->element_collections;\n");
		fwrite($stream, "\$this->widget('ui\\bootstrap\\widgets\\FormBuilder',\n");
		fwrite($stream, "\tarray(\n");
		fwrite($stream, "\t\t'name' => 'modify',\n");
		fwrite($stream, "\t\t'action' => \$this->getUrlManager()->getUrl(\$this->action, '', '', array('id' => \$this->id)),\n");
		fwrite($stream, "\t\t'errors' => \$this->errors,\n");
		fwrite($stream, "\t\t'values' => \$this->data,\n");
		fwrite($stream, "\t\t'elementCollections' => \$elements,\n");
		fwrite($stream, "\t\t'elements' => array(\n");
		foreach ($formModifyShows as $columnName) {
			fwrite($stream, "\t\t\t'{$columnName}',\n");
		}
		fwrite($stream, "\t\t\t'button_save' => \$elements->uiComponents->getButtonSave(),\n");
		fwrite($stream, "\t\t\t'button_save2close' => \$elements->uiComponents->getButtonSaveClose(),\n");
		fwrite($stream, "\t\t\t'button_save2new' => \$elements->uiComponents->getButtonSaveNew(),\n");
		fwrite($stream, "\t\t\t'button_cancel' => \$elements->uiComponents->getButtonCancel()\n");
		fwrite($stream, "\t\t)\n");
		fwrite($stream, "\t)\n");
		fwrite($stream, ");\n");
		fclose($stream);

		// Sidebar页面
		$filePath = $viewDir . DS . $ctrlName . '_sidebar.php';
		$stream = $this->fopen($filePath);
		fwrite($stream, "<!-- SideBar -->\n");
		fwrite($stream, "<div class=\"col-xs-6 col-sm-2 sidebar-offcanvas\" id=\"sidebar\">\n");
		fwrite($stream, "<?php\n");
		fwrite($stream, "\$config = array();\n");
		fwrite($stream, "\$this->widget('components\\SideBar', array('config' => \$config));\n");
		fwrite($stream, "?>\n");
		fwrite($stream, "</div><!-- /.col-xs-6 col-sm-2 -->\n");
		fwrite($stream, "<!-- /SideBar -->\n");
		fclose($stream);
	}

	/**
	 * 创建语言包
	 * @return void
	 */
	public function buildLang()
	{
		$appName = $this->_builders['app_name'];
		$modName = $this->_builders['mod_name'];
		$tblName = $this->_builders['tbl_name'];
		$builderName = $this->_builders['builder_name'];

		$fileName = 'zh-CN.mod_' . $modName . '.ini';
		$filePath = $this->_dirs['lang'] . DS . $fileName;
		$stream = $this->fopen($filePath);

		fwrite($stream, "; \$Id: {$fileName} 1 2013-05-18 14:58:59Z Create By Code Builder \$\n");
		fwrite($stream, ";\n");
		fwrite($stream, "; @package     {$appName}\n");
		fwrite($stream, "; @description [Description] [Name of language]([Country code])\n");
		fwrite($stream, "; @version     1.0\n");
		fwrite($stream, "; @date        " . date('Y-m-d') . "\n");
		fwrite($stream, "; @author      {$this->authorName} <{$this->authorMail}>\n");
		fwrite($stream, "; @copyright   Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.\n");
		fwrite($stream, "; @license     http://www.apache.org/licenses/LICENSE-2.0\n");
		fwrite($stream, "; @note        Client Site\n");
		fwrite($stream, "; @note        All ini files need to be saved as UTF-8 - No BOM\n\n");

		fwrite($stream, "; {$tblName} {$builderName}\n");
		foreach ($this->_groups as $value) {
			if ($value['group_name'] != 'main') {
				fwrite($stream, "{$value['lang_key']}=\"{$value['prompt']}\"\n");
			}
		}

		foreach ($this->_fields as $fv) {
			fwrite($stream, "{$fv['lang_label']}=\"{$fv['html_label']}\"\n");
			fwrite($stream, "{$fv['lang_hint']}=\"{$fv['form_prompt']}\"\n");
			foreach ($fv['validators'] as $vv) {
				fwrite($stream, "{$vv['lang_key']}=\"{$vv['message']}\"\n");
			}

			if (isset($fv['lang_enums'])) {
				foreach ($fv['lang_enums'] as $ev) {
					fwrite($stream, "{$ev}=\"\"\n");
				}
			}
		}

		fclose($stream);
	}

	/**
	 * 初始化目录
	 * @return void
	 */
	public function initDir()
	{
		$appName = $this->_builders['app_name'];
		$modName = $this->_builders['mod_name'];

		$appDir = DIR_DATA_RUNTIME . DS . 'builder' . DS . $appName;
		$this->mkDir($appDir);

		// 语言包存放目录
		$langDir = $appDir  . DS . 'languages';   $this->mkDir($langDir);
		$enDir   = $langDir . DS . 'en-GB';       $this->mkDir($enDir);
		$zhDir   = $langDir . DS . 'zh-CN';       $this->mkDir($zhDir);
		$this->_dirs['lang'] = $zhDir;

		// 模板存放目录
		$viewDir  = $appDir . DS . 'views';       $this->mkDir($viewDir);
		$viewDir .= DS . 'bootstrap';             $this->mkDir($viewDir);
		$viewDir .= DS . $modName;                $this->mkDir($viewDir);
		$this->_dirs['view'] = $viewDir;

		// 项目存放目录
		$modsDir  = $appDir . DS . 'modules';     $this->mkDir($modsDir);
		$modsDir .= DS . $modName;                $this->mkDir($modsDir);
		$ctrlDir  = $modsDir . DS . 'controller'; $this->mkDir($ctrlDir);
		$dbDir    = $modsDir . DS . 'db';         $this->mkDir($dbDir);
		$eleDir   = $modsDir . DS . 'elements';   $this->mkDir($eleDir);
		$modDir   = $modsDir . DS . 'model';      $this->mkDir($modDir);
		$uiDir    = $modsDir . DS . 'ui';         $this->mkDir($uiDir);
		$uiDir   .= DS . 'bootstrap';             $this->mkDir($uiDir);

		$this->_dirs['ctrl'] = $ctrlDir;
		$this->_dirs['db']   = $dbDir;
		$this->_dirs['ele']  = $eleDir;
		$this->_dirs['mod']  = $modDir;
		$this->_dirs['ui']   = $uiDir;
	}

	/**
	 * 初始化生成代码表数据
	 * @return void
	 */
	public function initBuilders()
	{
		$ret = BuilderFactory::getModel('Builders')->findByPk($this->_builderId);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->errExit(__LINE__, $ret['err_msg']);
		}

		$builders = $ret['data'];
		$builders['tbl_name'] = strtolower(trim($builders['tbl_name']));
		$builders['app_name'] = strtolower(trim($builders['app_name']));
		$builders['mod_name'] = strtolower(trim($builders['mod_name']));
		$builders['ctrl_name'] = strtolower(trim($builders['ctrl_name']));
		$builders['cls_name'] = strtolower(trim($builders['cls_name']));
		$builders['uc_ctrl_name'] = ucfirst($builders['ctrl_name']);
		$builders['uc_cls_name'] = ucfirst($builders['cls_name']);
		$builders['uc_fac_name'] = ucfirst($builders['mod_name']) . 'Factory';
		$builders['act_index_name'] = strtolower(trim($builders['act_index_name']));
		$builders['act_view_name'] = strtolower(trim($builders['act_view_name']));
		$builders['act_create_name'] = strtolower(trim($builders['act_create_name']));
		$builders['act_modify_name'] = strtolower(trim($builders['act_modify_name']));
		$builders['act_remove_name'] = strtolower(trim($builders['act_remove_name']));
		$builders['lang_prev'] = strtoupper('MOD_' . $builders['mod_name'] . '_' . $builders['tbl_name']);

		$this->_builders = $builders;
	}

	/**
	 * 初始化表单字段组表数据
	 * @return void
	 */
	public function initGroups()
	{
		$ret = BuilderFactory::getModel('Groups')->findAllByAttributes(array('builder_id' => 0), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->errExit(__LINE__, $ret['err_msg']);
		}

		$groups = $ret['data'];

		$ret = BuilderFactory::getModel('Groups')->findAllByAttributes(array('builder_id' => $this->_builderId), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->errExit(__LINE__, $ret['err_msg']);
		}

		$groups = array_merge($groups, $ret['data']);
		foreach ($groups as $key => $value) {
			$groups[$key]['lang_key'] = $this->_builders['lang_prev'] . '_VIEWTAB_' . strtoupper($value['group_name']) . '_PROMPT';
		}

		$this->_groups = $groups;
	}

	/**
	 * 初始化表单字段表数据
	 * @return void
	 */
	public function initFields()
	{
		$ret = BuilderFactory::getModel('Fields')->findAllByAttributes(array('builder_id' => $this->_builderId), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->errExit(__LINE__, $ret['err_msg']);
		}

		$fields = $ret['data'];
		foreach ($fields as $fk => $fv) {
			$langPrev = $this->_builders['lang_prev'] . '_' . strtoupper($fv['field_name']);
			$fields[$fk]['lang_label'] = $langPrev . '_LABEL';
			$fields[$fk]['lang_hint'] = $langPrev . '_HINT';
			$fields[$fk]['groups'] = $this->getGroupsByGroupId($fv['group_id']);
			$fields[$fk]['func_name'] = $this->column2Name($fv['field_name']);

			$validators = $this->getValidatorsByFieldId($fv['field_id']);
			foreach ($validators as $vk => $vv) {
				$validators[$vk]['lang_key'] = $langPrev . '_' . strtoupper($vv['validator_name']);
			}
			$fields[$fk]['validators'] = $validators;

			$fields[$fk]['types'] = $this->getTypesByTypeId($fv['type_id']);
			if ($fields[$fk]['types']['field_type'] === 'ENUM') {
				$langEnums = array();
				$enums = array();
				foreach (explode('|', $fv['column_length']) as $ev) {
					$ek = strtoupper($fv['field_name'] . '_' . $ev);
					$enums[$ek] = $ev;
					$langEnums[] = $langPrev . '_' . strtoupper($ev) . '_LABEL';
				}

				$fields[$fk]['enums'] = $enums;
				$fields[$fk]['lang_enums'] = $langEnums;
			}
		}

		$this->_fields = $fields;
	}

	/**
	 * 通过类型ID获取表单字段类型
	 * @param integer $typeId
	 * @return array
	 */
	public function getTypesByTypeId($typeId)
	{
		$ret = BuilderFactory::getModel('Types')->findByPk($typeId);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->errExit(__LINE__, $ret['err_msg']);
		}

		return $ret['data'];
	}

	/**
	 * 通过字段组ID获取表单字段组
	 * @param integer $groupId
	 * @return array
	 */
	public function getGroupsByGroupId($groupId)
	{
		$ret = BuilderFactory::getModel('Groups')->findByPk($groupId);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->errExit(__LINE__, $ret['err_msg']);
		}

		return $ret['data'];
	}

	/**
	 * 通过字段组ID获取表单字段组
	 * @param integer $fieldId
	 * @return array
	 */
	public function getValidatorsByFieldId($fieldId)
	{
		$ret = BuilderFactory::getModel('Validators')->findAllByAttributes(array('field_id' => $fieldId), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->errExit(__LINE__, $ret['err_msg']);
		}

		return $ret['data'];
	}

	/**
	 * 将字段名格式转换为函数名格式
	 * @param string $name
	 * @return string
	 */
	public function column2Name($name)
	{
		return str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower($name))));
	}

	/**
	 * 写注释
	 * @param resource $stream
	 * @return void
	 */
	public function writeComment($stream)
	{
		fwrite($stream, "<?php\n");
		fwrite($stream, "/**\n");
		fwrite($stream, " * Trotri\n");
		fwrite($stream, " *\n");
		fwrite($stream, " * @author    Huan Song <trotri@yeah.net>\n");
		fwrite($stream, " * @link      http://github.com/trotri/trotri for the canonical source repository\n");
		fwrite($stream, " * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.\n");
		fwrite($stream, " * @license   http://www.apache.org/licenses/LICENSE-2.0\n");
		fwrite($stream, " */\n\n");
	}

	/**
	 * 打开文件
	 * @param string $filePath
	 * @return resource
	 */
	public function fopen($filePath)
	{
		if (!($stream = @fopen($filePath, 'w', false))) {
			$this->errExit(__LINE__, sprintf(
				'File "%s" cannot be opened with mode "w"', $filePath
			));
		}

		return $stream;
	}

	/**
	 * 新建目录，如果目录存在，则改变目录权限
	 * @param string $directory
	 * @param integer $mode 文件权限，8进制
	 * @return void
	 */
	public function mkDir($directory, $mode = 0664)
	{
		if (!$this->_fileManager->mkDir($directory, $mode, true)) {
			$this->errExit(__LINE__, sprintf(
				'Dir "%s" cannot be create with mode "%04o"', $directory, $mode
			));
		}

		$dest = $directory . DS . 'index.html';
		if (!$this->_fileManager->isFile($dest)) {
			$source = DIR_DATA_RUNTIME . DS . 'index.html';
			$this->_fileManager->copy($source, $dest);
		}
	}

	/**
	 * 打印错误并退出
	 * @param string $errMsg
	 * @return void
	 */
	public function errExit($line, $errMsg)
	{
		echo '<font color="red">Line: ', $line, '. Msg: ', $errMsg, '</font>';
		exit;
	}
}

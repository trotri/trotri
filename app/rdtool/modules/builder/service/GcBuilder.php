<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\service;

use tfc\saf\Log;

/**
 * GcBuilder class file
 * 代码生成器
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: GcBuilder.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.service
 * @since 1.0
 */
class GcBuilder
{
	public
		$schema = null,
		$fileManager = null;

	/**
	 * 构造方法：初始化Builders、Types、Groups、Fields、Validators数据寄存器和文件管理器
	 * @param integer $builderId
	 */
	public function __construct($builderId)
	{
		// 初始化工作开始
		Log::echoTrace('Initialization Begin ...');

		$this->schema = new GcSchema($builderId);
		$this->fileManager = new GcFileManager(
			$this->schema->authorName,
			$this->schema->authorMail,
			$this->schema->srvName,
			$this->schema->appName,
			$this->schema->modName,
			$this->schema->ctrlName
		);

		// 初始化工作结束
		Log::echoTrace('Initialization End');
	}

	/**
	 * 生成代码
	 * @return void
	 */
	public function run()
	{
		Log::echoTrace('Generate Begin, Table Name "' . $this->schema->tblName . '"');

		if ($this->schema->srvType === 'dynamic') {
			$this->gcDynamicDb();
			$this->gcDynamicService();
		}

		$this->gcData();
		$this->gcFp();
		$this->gcSlang();

		$this->gcLang();
		$this->gcModel();
		$this->gcCtrl();
		$this->gcActs();
		$this->gcViews();

		Log::echoTrace('Generate End, Table Name "' . $this->schema->tblName . '"');
	}

	/**
	 * 创建View层文件
	 * @return void
	 */
	public function gcViews()
	{
		$schema->fkColumn = 'builder_id';
		$schema->hasTrash = true;
		$schema->hasSort = true;
		$schema->actTrashName = 'trash';
		$schema->actTrashIndexName = 'trashindex';


		$fileManager = $this->fileManager;
		$schema = $this->schema;

		Log::echoTrace('Generate Views Begin ...');

		$tmpListIndexShows = array();
		$tmpFormCreateShows = array();
		$tmpFormModifyShows = array();
		foreach ($schema->fields as $rows) {
			if ($rows['index_show']) {
				$tmpListIndexShows[$rows['index_sort']][] = $rows['field_name'];
			}

			if ($rows['form_create_show']) {
				$tmpFormCreateShows[$rows['form_create_sort']][] = $rows['field_name'];
			}

			if ($rows['form_modify_show']) {
				$tmpFormModifyShows[$rows['form_modify_sort']][] = $rows['field_name'];
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

		

		Log::echoTrace('Generate Views End');

		echo '<pre>';

		print_r($listIndexShows);
		print_r($formCreateShows);
		print_r($formModifyShows);

		print_r($fileManager);
		print_r($schema);

		echo '</pre>';
	}

	/**
	 * 创建Actions层类
	 * @return void
	 */
	public function gcActs()
	{
		$fileManager = $this->fileManager;
		$schema = $this->schema;

		Log::echoTrace('Generate Actions Begin ...');

		// 创建 Index Action
		$clsName = ucfirst($schema->actIndexName);
		$filePath = $fileManager->action . DS . $clsName . '.php';
		$stream = $fileManager->fopen($filePath);
		$fileManager->writeCopyrightComment($stream);
		fwrite($stream, "namespace modules\\{$schema->modName}\\action\\{$schema->ctrlName};\n\n");
		fwrite($stream, "use library\\actions;\n");
		fwrite($stream, "use tfc\\ap\\Ap;\n\n");

		$fileManager->writeClassComment($stream, $clsName, '查询数据列表', "modules.{$schema->modName}.action.{$schema->ctrlName}");
		fwrite($stream, "class {$clsName} extends actions\\Index\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see tfc\\mvc\\interfaces.Action::run()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function run()\n");
		fwrite($stream, "\t{\n");
		if ($schema->fkColumn) {
			$funcName = $this->column2Name($schema->fkColumn);
			$varName = '$' . strtolower(substr($funcName, 0, 1)) . substr($funcName, 1);

			fwrite($stream, "\t\t{$varName} = Ap::getRequest()->getInteger('{$schema->fkColumn}');\n");
			fwrite($stream, "\t\tif ({$varName} <= 0) {\n");
			fwrite($stream, "\t\t\t\$this->err404();\n");
			fwrite($stream, "\t\t}\n\n");
			fwrite($stream, "\t\t\$this->assign('{$schema->fkColumn}', {$varName});\n\n");
		}
		if ($schema->hasTrash) {
			fwrite($stream, "\t\tAp::getRequest()->setParam('trash', 'n');\n");
		}
		if ($schema->hasSort) {
			fwrite($stream, "\t\tAp::getRequest()->setParam('order', 'sort');\n");
		}
		fwrite($stream, "\t\t\$this->execute('{$schema->ucClsName}');\n");
		fwrite($stream, "\t}\n");
		fwrite($stream, "}\n");
		fclose($stream);
		Log::echoTrace('Generate App Act ' .$clsName . ' Successfully');

		if ($schema->hasTrash) {
			// 创建 TrashIndex Action
			$clsName = ucfirst($schema->actTrashIndexName);
			$filePath = $fileManager->action . DS . $clsName . '.php';
			$stream = $fileManager->fopen($filePath);
			$fileManager->writeCopyrightComment($stream);
			fwrite($stream, "namespace modules\\{$schema->modName}\\action\\{$schema->ctrlName};\n\n");
			fwrite($stream, "use library\\actions;\n");
			fwrite($stream, "use tfc\\ap\\Ap;\n\n");

			$fileManager->writeClassComment($stream, $clsName, '查询回收站数据列表', "modules.{$schema->modName}.action.{$schema->ctrlName}");
			fwrite($stream, "class {$clsName} extends actions\\Index\n");
			fwrite($stream, "{\n");
			fwrite($stream, "\t/**\n");
			fwrite($stream, "\t * (non-PHPdoc)\n");
			fwrite($stream, "\t * @see tfc\\mvc\\interfaces.Action::run()\n");
			fwrite($stream, "\t */\n");
			fwrite($stream, "\tpublic function run()\n");
			fwrite($stream, "\t{\n");
			if ($schema->fkColumn) {
				$funcName = $this->column2Name($schema->fkColumn);
				$varName = '$' . strtolower(substr($funcName, 0, 1)) . substr($funcName, 1);

				fwrite($stream, "\t\t{$varName} = Ap::getRequest()->getInteger('{$schema->fkColumn}');\n");
				fwrite($stream, "\t\tif ({$varName} <= 0) {\n");
				fwrite($stream, "\t\t\t\$this->err404();\n");
				fwrite($stream, "\t\t}\n\n");
				fwrite($stream, "\t\t\$this->assign('{$schema->fkColumn}', {$varName});\n\n");
			}
			fwrite($stream, "\t\tAp::getRequest()->setParam('trash', 'y');\n");
			if ($schema->hasSort) {
				fwrite($stream, "\t\tAp::getRequest()->setParam('order', 'sort');\n");
			}
			fwrite($stream, "\t\t\$this->execute('{$schema->ucClsName}');\n");
			fwrite($stream, "\t}\n");
			fwrite($stream, "}\n");
			fclose($stream);
			Log::echoTrace('Generate App Act ' .$clsName . ' Successfully');
		}

		// 创建 View Action
		$clsName = ucfirst($schema->actViewName);
		$filePath = $fileManager->action . DS . $clsName . '.php';
		$stream = $fileManager->fopen($filePath);
		$fileManager->writeCopyrightComment($stream);
		fwrite($stream, "namespace modules\\{$schema->modName}\\action\\{$schema->ctrlName};\n\n");
		fwrite($stream, "use library\\actions;\n");
		fwrite($stream, "use tfc\\ap\\Ap;\n");
		if ($schema->fkColumn) {
			fwrite($stream, "use libapp\\Model;\n");
		}
		fwrite($stream, "\n");

		$fileManager->writeClassComment($stream, $clsName, '查询数据详情', "modules.{$schema->modName}.action.{$schema->ctrlName}");
		fwrite($stream, "class {$clsName} extends actions\\View\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see tfc\\mvc\\interfaces.Action::run()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function run()\n");
		fwrite($stream, "\t{\n");
		if ($schema->fkColumn) {
			$funcName = $this->column2Name($schema->fkColumn);
			$varName = '$' . strtolower(substr($funcName, 0, 1)) . substr($funcName, 1);

			fwrite($stream, "\t\t\$mod = Model::getInstance('{$schema->ucClsName}');\n");
			fwrite($stream, "\t\t{$varName} = \$mod->get{$funcName}();\n");
			fwrite($stream, "\t\tif ({$varName} <= 0) {\n");
			fwrite($stream, "\t\t\t\$this->err404();\n");
			fwrite($stream, "\t\t}\n\n");
			fwrite($stream, "\t\t\$this->assign('{$schema->fkColumn}', {$varName});\n");
		}
		fwrite($stream, "\t\t\$this->execute('{$schema->ucClsName}');\n");
		fwrite($stream, "\t}\n");
		fwrite($stream, "}\n");
		fclose($stream);
		Log::echoTrace('Generate App Act ' .$clsName . ' Successfully');

		// 创建 Create Action
		$clsName = ucfirst($schema->actCreateName);
		$filePath = $fileManager->action . DS . $clsName . '.php';
		$stream = $fileManager->fopen($filePath);
		$fileManager->writeCopyrightComment($stream);
		fwrite($stream, "namespace modules\\{$schema->modName}\\action\\{$schema->ctrlName};\n\n");
		fwrite($stream, "use library\\actions;\n");
		fwrite($stream, "use tfc\\ap\\Ap;\n");
		if ($schema->fkColumn) {
			fwrite($stream, "use libapp\\Model;\n");
		}
		fwrite($stream, "\n");

		$fileManager->writeClassComment($stream, $clsName, '新增数据', "modules.{$schema->modName}.action.{$schema->ctrlName}");
		fwrite($stream, "class {$clsName} extends actions\\Create\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see tfc\\mvc\\interfaces.Action::run()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function run()\n");
		fwrite($stream, "\t{\n");
		if ($schema->fkColumn) {
			$funcName = $this->column2Name($schema->fkColumn);
			$varName = '$' . strtolower(substr($funcName, 0, 1)) . substr($funcName, 1);

			fwrite($stream, "\t\t\$mod = Model::getInstance('{$schema->ucClsName}');\n");
			fwrite($stream, "\t\t{$varName} = \$mod->get{$funcName}();\n");
			fwrite($stream, "\t\tif ({$varName} <= 0) {\n");
			fwrite($stream, "\t\t\t\$this->err404();\n");
			fwrite($stream, "\t\t}\n\n");
			fwrite($stream, "\t\t\$this->assign('{$schema->fkColumn}', {$varName});\n");
		}
		fwrite($stream, "\t\t\$this->execute('{$schema->ucClsName}');\n");
		fwrite($stream, "\t}\n");
		fwrite($stream, "}\n");
		fclose($stream);
		Log::echoTrace('Generate App Act ' .$clsName . ' Successfully');

		// 创建 Modify Action
		$clsName = ucfirst($schema->actModifyName);
		$filePath = $fileManager->action . DS . $clsName . '.php';
		$stream = $fileManager->fopen($filePath);
		$fileManager->writeCopyrightComment($stream);
		fwrite($stream, "namespace modules\\{$schema->modName}\\action\\{$schema->ctrlName};\n\n");
		fwrite($stream, "use library\\actions;\n\n");

		$fileManager->writeClassComment($stream, $clsName, '编辑数据', "modules.{$schema->modName}.action.{$schema->ctrlName}");
		fwrite($stream, "class {$clsName} extends actions\\Modify\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see tfc\\mvc\\interfaces.Action::run()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function run()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$this->execute('{$schema->ucClsName}');\n");
		fwrite($stream, "\t}\n");
		fwrite($stream, "}\n");
		fclose($stream);
		Log::echoTrace('Generate App Act ' .$clsName . ' Successfully');

		// 创建 Remove Action
		$clsName = ucfirst($schema->actRemoveName);
		$filePath = $fileManager->action . DS . $clsName . '.php';
		$stream = $fileManager->fopen($filePath);
		$fileManager->writeCopyrightComment($stream);
		fwrite($stream, "namespace modules\\{$schema->modName}\\action\\{$schema->ctrlName};\n\n");
		fwrite($stream, "use library\\actions;\n\n");

		$fileManager->writeClassComment($stream, $clsName, '删除数据', "modules.{$schema->modName}.action.{$schema->ctrlName}");
		fwrite($stream, "class {$clsName} extends actions\\Remove\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see tfc\\mvc\\interfaces.Action::run()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function run()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$this->execute('{$schema->ucClsName}');\n");
		fwrite($stream, "\t}\n");
		fwrite($stream, "}\n");
		fclose($stream);
		Log::echoTrace('Generate App Act ' .$clsName . ' Successfully');

		// 创建 SingleModify Action
		$clsName = 'Single' . ucfirst($schema->actModifyName);
		$filePath = $fileManager->action . DS . $clsName . '.php';
		$stream = $fileManager->fopen($filePath);
		$fileManager->writeCopyrightComment($stream);
		fwrite($stream, "namespace modules\\{$schema->modName}\\action\\{$schema->ctrlName};\n\n");
		fwrite($stream, "use library\\actions;\n\n");

		$fileManager->writeClassComment($stream, $clsName, '编辑单个字段', "modules.{$schema->modName}.action.{$schema->ctrlName}");
		fwrite($stream, "class {$clsName} extends actions\\SingleModify\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see tfc\\mvc\\interfaces.Action::run()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function run()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$this->execute('{$schema->ucClsName}');\n");
		fwrite($stream, "\t}\n");
		fwrite($stream, "}\n");
		fclose($stream);
		Log::echoTrace('Generate App Act ' .$clsName . ' Successfully');

		if ($schema->hasTrash) {
			// 创建 Trash Action
			$clsName = ucfirst($schema->actTrashName);
			$filePath = $fileManager->action . DS . $clsName . '.php';
			$stream = $fileManager->fopen($filePath);
			$fileManager->writeCopyrightComment($stream);
			fwrite($stream, "namespace modules\\{$schema->modName}\\action\\{$schema->ctrlName};\n\n");
			fwrite($stream, "use library\\actions;\n\n");

			$fileManager->writeClassComment($stream, $clsName, '移至回收站和从回收站还原', "modules.{$schema->modName}.action.{$schema->ctrlName}");
			fwrite($stream, "class {$clsName} extends actions\\Trash\n");
			fwrite($stream, "{\n");
			fwrite($stream, "\t/**\n");
			fwrite($stream, "\t * (non-PHPdoc)\n");
			fwrite($stream, "\t * @see tfc\\mvc\\interfaces.Action::run()\n");
			fwrite($stream, "\t */\n");
			fwrite($stream, "\tpublic function run()\n");
			fwrite($stream, "\t{\n");
			fwrite($stream, "\t\t\$this->execute('{$schema->ucClsName}');\n");
			fwrite($stream, "\t}\n");
			fwrite($stream, "}\n");
			fclose($stream);
			Log::echoTrace('Generate App Act ' .$clsName . ' Successfully');
		}

		Log::echoTrace('Generate Actions End');
	}

	/**
	 * 创建ctrl
	 * @return void
	 */
	public function gcCtrl()
	{
		$fileManager = $this->fileManager;
		$schema = $this->schema;
		$clsName = $schema->ucCtrlName . 'Controller';

		Log::echoTrace('Generate Controller Begin ...');

		$filePath = $fileManager->controller . DS . $clsName . '.php';
		$stream = $fileManager->fopen($filePath);
		$fileManager->writeCopyrightComment($stream);

		fwrite($stream, "namespace modules\\{$schema->modName}\\controller;\n\n");
		fwrite($stream, "use libapp\\BaseController;\n\n");

		$fileManager->writeClassComment($stream, $clsName, $schema->builderName, "modules.{$schema->modName}.controller");
		fwrite($stream, "class {$clsName} extends BaseController\n");
		fwrite($stream, "{\n");
		fwrite($stream, "}\n");
		fclose($stream);
		Log::echoTrace('Generate Controller End');
	}

	/**
	 * 创建model
	 * @return void
	 */
	public function gcModel()
	{
		$fileManager = $this->fileManager;
		$schema = $this->schema;

		Log::echoTrace('Generate Model Begin ...');

		$filePath = $fileManager->model . DS . $schema->ucClsName . '.php';
		$stream = $fileManager->fopen($filePath);
		$fileManager->writeCopyrightComment($stream);

		fwrite($stream, "namespace modules\\{$schema->modName}\\model;\n\n");
		fwrite($stream, "use library\\BaseModel;\n");
		if ($schema->fkColumn) {
			fwrite($stream, "use tfc\\ap\\Ap;\n");
		}
		fwrite($stream, "use tfc\\saf\\Text;\n");
		fwrite($stream, "use {$schema->srvName}\\services\\Data{$schema->ucClsName};\n\n");

		$fileManager->writeClassComment($stream, $schema->ucClsName, $schema->builderName, "modules.{$schema->modName}.model");

		fwrite($stream, "class {$schema->ucClsName} extends BaseModel\n");
		fwrite($stream, "{\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see libapp.Elements::getViewTabsRender()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function getViewTabsRender()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$output = array(\n");
		foreach ($schema->groups as $rows) {
			if ($rows['group_name'] != 'main') {
				fwrite($stream, "\t\t\t'{$rows['group_name']}' => array(\n");
				fwrite($stream, "\t\t\t\t'tid' => '{$rows['group_name']}',\n");
				fwrite($stream, "\t\t\t\t'prompt' => Text::_('{$rows['lang_key']}')\n");
				fwrite($stream, "\t\t\t),\n");
			}
		}
		fwrite($stream, "\t\t);\n\n");
		fwrite($stream, "\t\treturn \$output;\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see libapp.Elements::getElementsRender()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function getElementsRender()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$output = array(\n");
		foreach ($schema->fields as $rows) {
			$type = ($schema->fkColumn === $rows['field_name']) ? 'hidden' : $rows['form_type'];

			fwrite($stream, "\t\t\t'{$rows['field_name']}' => array(\n");
			fwrite($stream, "\t\t\t\t'__tid__' => '{$rows['__tid__']}',\n");
			fwrite($stream, "\t\t\t\t'type' => '{$type}',\n");
			fwrite($stream, "\t\t\t\t'label' => Text::_('{$rows['lang_label']}'),\n");
			fwrite($stream, "\t\t\t\t'hint' => Text::_('{$rows['lang_hint']}'),\n");
			if ($rows['form_required']) {
				fwrite($stream, "\t\t\t\t'required' => true,\n");
			}
			if ($rows['form_modifiable']) {
				fwrite($stream, "\t\t\t\t'disabled' => true,\n");
			}
			if (isset($rows['enums'])) {
				$enum = array_shift($rows['enums']);
				fwrite($stream, "\t\t\t\t'options' => Data{$schema->ucClsName}::get{$rows['func_name']}Enum(),\n");
				fwrite($stream, "\t\t\t\t'value' => Data{$schema->ucClsName}::{$enum['const_key']},\n");
			}
			fwrite($stream, "\t\t\t),\n");
		}
		fwrite($stream, "\t\t);\n\n");
		fwrite($stream, "\t\treturn \$output;\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 获取列表页“{$schema->fields[1]['html_label']}”的A标签\n");
		fwrite($stream, "\t * @param array \$data\n");
		fwrite($stream, "\t * @return string\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function get{$schema->fields[1]['func_name']}Link(\$data)\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$params = array(\n");
		fwrite($stream, "\t\t\t'id' => \$data['{$schema->pkColumn}'],\n");
		fwrite($stream, "\t\t);\n\n");
		fwrite($stream, "\t\t\$url = \$this->urlManager->getUrl(\$this->actNameView, \$this->controller, \$this->module, \$params);\n");
		fwrite($stream, "\t\t\$output = \$this->html->a(\$data['{$schema->fields[1]['field_name']}'], \$url);\n");
		fwrite($stream, "\t\treturn \$output;\n");
		fwrite($stream, "\t}\n\n");

		if ($schema->fkColumn) {
			$funcName = $this->column2Name($schema->fkColumn);
			$varName = '$' . strtolower(substr($funcName, 0, 1)) . substr($funcName, 1);

			fwrite($stream, "\t/**\n");
			fwrite($stream, "\t * 获取{$schema->fkColumn}值\n");
			fwrite($stream, "\t * @return integer\n");
			fwrite($stream, "\t */\n");
			fwrite($stream, "\tpublic function get{$funcName}()\n");
			fwrite($stream, "\t{\n");
			fwrite($stream, "\t\t{$varName} = Ap::getRequest()->getInteger('{$schema->fkColumn}');\n");
			fwrite($stream, "\t\tif ({$varName} <= 0) {\n");
			fwrite($stream, "\t\t\t\$id = Ap::getRequest()->getInteger('id');\n");
			fwrite($stream, "\t\t\t{$varName} = \$this->getService()->getByPk('{$schema->fkColumn}', \$id);\n");
			fwrite($stream, "\t\t}\n\n");
			fwrite($stream, "\t\treturn {$varName};\n");
			fwrite($stream, "\t}\n\n");
		}

		fwrite($stream, "}\n");
		fclose($stream);
		Log::echoTrace('Generate Model End');
	}

	/**
	 * 创建app languages
	 * @return void
	 */
	public function gcLang()
	{
		$fileManager = $this->fileManager;
		$schema = $this->schema;
		$upCtrlName = strtoupper($schema->ctrlName);
		$upModName = strtoupper($schema->modName);

		Log::echoTrace('Generate APP Languages Begin ...');

		$fileName = 'zh-CN.mod_' . $schema->modName . '.ini';
		$filePath = $fileManager->CNLangs . DS . $fileName;
		$stream = $fileManager->fopen($filePath);
		$fileManager->writeLangComment($stream, $fileName, $schema->appName);

		fwrite($stream, "; SideBar Url\n");
		fwrite($stream, "MOD_{$upModName}_URLS_{$upCtrlName}_INDEX=\"{$schema->builderName}管理\"\n");
		fwrite($stream, "MOD_{$upModName}_URLS_{$upCtrlName}_CREATE=\"新增{$schema->builderName}\"\n\n");

		fwrite($stream, "; {$schema->tblName} {$schema->builderName}\n");
		foreach ($schema->groups as $rows) {
			if ($rows['group_name'] != 'main') {
				fwrite($stream, "{$rows['lang_key']}=\"{$rows['prompt']}\"\n");
			}
		}

		foreach ($schema->fields as $rows) {
			fwrite($stream, "{$rows['lang_label']}=\"{$rows['html_label']}\"\n");
			fwrite($stream, "{$rows['lang_hint']}=\"{$rows['form_prompt']}\"\n");
		}

		fclose($stream);
		Log::echoTrace('Generate APP Languages End');
	}

	/**
	 * 创建srv languages
	 * @return void
	 */
	public function gcSlang()
	{
		$fileManager = $this->fileManager;
		$schema = $this->schema;

		Log::echoTrace('Generate SRV Languages Begin ...');

		$fileName = 'zh-CN.srv_enum.ini';
		$filePath = $fileManager->sCNLangs . DS . $fileName;
		$stream = $fileManager->fopen($filePath);
		$fileManager->writeLangComment($stream, $fileName, $schema->srvName);
		fwrite($stream, "; Global\n");
		fwrite($stream, "SRV_ENUM_GLOBAL_YES=\"是\"\n");
		fwrite($stream, "SRV_ENUM_GLOBAL_NO=\"否\"\n\n");

		fwrite($stream, "; {$schema->tblName} {$schema->builderName}\n");
		foreach ($schema->fields as $rows) {
			if (isset($rows['enums'])) {
				foreach ($rows['enums'] as $enums) {
					if ($enums['lang_key'] !== 'CFG_SYSTEM_GLOBAL_YES' && $enums['lang_key'] !== 'CFG_SYSTEM_GLOBAL_NO') {
						fwrite($stream, "{$enums['lang_key']}=\"{$enums['value']}\"\n");
					}
				}
			}
		}
		fclose($stream);

		$fileName = 'zh-CN.srv_filter.ini';
		$filePath = $fileManager->sCNLangs . DS . $fileName;
		$stream = $fileManager->fopen($filePath);
		$fileManager->writeLangComment($stream, $fileName, $schema->srvName);
		fwrite($stream, "; {$schema->tblName} {$schema->builderName}\n");
		foreach ($schema->fields as $rows) {
			if (isset($rows['validators'])) {
				foreach ($rows['validators'] as $validators) {
					fwrite($stream, "{$validators['lang_key']}=\"{$validators['message']}\"\n");
				}
			}
		}
		fclose($stream);

		Log::echoTrace('Generate SRV Languages End');
	}

	/**
	 * 创建FormProcessor类
	 * @return void
	 */
	public function gcFp()
	{
		$fileManager = $this->fileManager;
		$schema = $this->schema;
		$clsName = 'Fp' . $schema->ucClsName;

		$fieldNames = $validatorNames = '';
		foreach ($schema->fields as $rows) {
			if (!$rows['column_auto_increment']) {
				$fieldNames .= ', \'' . $rows['field_name'] . '\'';
			}

			if ($rows['validators']) {
				$validatorNames .= ', \'' . $rows['field_name'] . '\'';
			}
		}

		Log::echoTrace('Generate FormProcessor Begin ...');

		$filePath = $fileManager->services . DS . $clsName . '.php';
		$stream = $fileManager->fopen($filePath);
		$fileManager->writeCopyrightComment($stream);

		fwrite($stream, "namespace {$schema->srvName}\\services;\n\n");
		fwrite($stream, "use libsrv\\FormProcessor;\n");
		fwrite($stream, "use tfc\\validator;\n");
		fwrite($stream, "use {$schema->srvName}\\library\\Lang;\n\n");

		$fileManager->writeClassComment($stream, $clsName, '业务层：表单数据处理类', "{$schema->srvName}.services");

		fwrite($stream, "class {$clsName} extends FormProcessor\n");
		fwrite($stream, "{\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see libsrv.FormProcessor::_process()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tprotected function _process(array \$params = array())\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\tif (\$this->isInsert()) {\n");
		fwrite($stream, "\t\t\tif (!\$this->required(\$params{$fieldNames})) {\n");
		fwrite($stream, "\t\t\t\treturn false;\n");
		fwrite($stream, "\t\t\t}\n");
		fwrite($stream, "\t\t}\n\n");
		fwrite($stream, "\t\t\$this->isValids(\$params{$validatorNames});\n");
		fwrite($stream, "\t\treturn !\$this->hasError();\n");
		fwrite($stream, "\t}\n\n");

		foreach ($schema->fields as $rows) {
			if (!isset($rows['validators']) || !is_array($rows['validators']) || $rows['validators'] === array()) {
				continue;
			}

			fwrite($stream, "\t/**\n");
			fwrite($stream, "\t * 获取“{$rows['html_label']}”验证规则\n");
			fwrite($stream, "\t * @param mixed \$value\n");
			fwrite($stream, "\t * @return array\n");
			fwrite($stream, "\t */\n");
			fwrite($stream, "\tpublic function get{$rows['func_name']}Rule(\$value)\n");
			fwrite($stream, "\t{\n");
			if (isset($rows['enums'])) {
				fwrite($stream, "\t\t\$enum = Data{$schema->ucClsName}::get{$rows['func_name']}Enum();\n");
			}

			fwrite($stream, "\t\treturn array(\n");
			foreach ($rows['validators'] as $validators) {
				$validatorName = $validators['validator_name'];
				if (isset($rows['enums']) && $validatorName === 'InArray') {
					$options = "array_keys(\$enum)";
					$message = "sprintf(Lang::_('{$validators['lang_key']}'), implode(', ', \$enum))";
					fwrite($stream, "\t\t\t'{$validatorName}' => new validator\\InArrayValidator(\$value, {$options}, {$message}),\n");
				}
				else {
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
					fwrite($stream, "\t\t\t'{$validatorName}' => new validator\\{$validatorName}Validator(\$value, {$options}, Lang::_('{$validators['lang_key']}')),\n");
				}
			}

			fwrite($stream, "\t\t);\n");
			fwrite($stream, "\t}\n\n");
		}

		fwrite($stream, "}\n");

		fclose($stream);
		Log::echoTrace('Generate FormProcessor End');
	}

	/**
	 * 创建Data类
	 * @return void
	 */
	public function gcData()
	{
		$fileManager = $this->fileManager;
		$schema = $this->schema;
		$clsName = 'Data' . $schema->ucClsName;

		Log::echoTrace('Generate Data Begin ...');

		$filePath = $fileManager->services . DS . $clsName . '.php';
		$stream = $fileManager->fopen($filePath);
		$fileManager->writeCopyrightComment($stream);

		fwrite($stream, "namespace {$schema->srvName}\\services;\n\n");
		fwrite($stream, "use {$schema->srvName}\\library\\Lang;\n\n");

		$fileManager->writeClassComment($stream, $clsName, '业务层：数据管理类，寄存常量、选项', "{$schema->srvName}.services");

		fwrite($stream, "class {$clsName}\n");
		fwrite($stream, "{\n");

		foreach ($schema->fields as $rows) {
			if (isset($rows['enums'])) {
				foreach ($rows['enums'] as $enums) {
					fwrite($stream, "\t/**\n");
					fwrite($stream, "\t * @var string {$rows['html_label']}：{$enums['value']}\n");
					fwrite($stream, "\t */\n");
					fwrite($stream, "\tconst {$enums['const_key']} = '{$enums['value']}';\n\n");
				}
			}
		}

		foreach ($schema->fields as $rows) {
			if (isset($rows['enums'])) {
				fwrite($stream, "\t/**\n");
				fwrite($stream, "\t * 获取“{$rows['html_label']}”所有选项\n");
				fwrite($stream, "\t * @return array\n");
				fwrite($stream, "\t */\n");
				fwrite($stream, "\tpublic static function get{$rows['func_name']}Enum()\n");
				fwrite($stream, "\t{\n");
				fwrite($stream, "\t\tstatic \$enum = null;\n\n");
				fwrite($stream, "\t\tif (\$enum === null) {\n");
				fwrite($stream, "\t\t\t\$enum = array(\n");
				foreach ($rows['enums'] as $enums) {
					fwrite($stream, "\t\t\t\tself::{$enums['const_key']} => Lang::_('{$enums['lang_key']}'),\n");
				}

				fwrite($stream, "\t\t\t);\n");
				fwrite($stream, "\t\t}\n\n");
				fwrite($stream, "\t\treturn \$enum;\n");
				fwrite($stream, "\t}\n\n");
			}
		}

		fwrite($stream, "}\n");

		fclose($stream);
		Log::echoTrace('Generate Data End');
	}

	/**
	 * 创建DynamicService类
	 * @return void
	 */
	public function gcDynamicService()
	{
		$fileManager = $this->fileManager;
		$schema = $this->schema;

		Log::echoTrace('Generate Service Begin ...');

		$filePath = $fileManager->services . DS . $schema->ucClsName . '.php';
		$stream = $fileManager->fopen($filePath);
		$fileManager->writeCopyrightComment($stream);

		fwrite($stream, "namespace {$schema->srvName}\\services;\n\n");
		fwrite($stream, "use libsrv\\DynamicService;\n\n");

		$fileManager->writeClassComment($stream, $schema->ucClsName, '业务层：模型类', "{$schema->srvName}.services");

		fwrite($stream, "class {$schema->ucClsName} extends DynamicService\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * @var string 表名\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tprotected \$_tableName = '{$schema->tblName}';\n");
		fwrite($stream, "}\n");

		fclose($stream);
		Log::echoTrace('Generate Service End');
	}

	/**
	 * 创建DynamicDB类
	 * @return void
	 */
	public function gcDynamicDb()
	{
		$fileManager = $this->fileManager;
		$schema = $this->schema;

		Log::echoTrace('Generate Db Begin ...');

		$filePath = $fileManager->db . DS . $schema->ucClsName . '.php';
		$stream = $fileManager->fopen($filePath);
		$fileManager->writeCopyrightComment($stream);

		fwrite($stream, "namespace {$schema->srvName}\\db;\n\n");
		fwrite($stream, "use tdo\\DynamicDb;\n");
		fwrite($stream, "use {$schema->srvName}\\library\\Constant;\n\n");

		$fileManager->writeClassComment($stream, $schema->ucClsName, '业务层：数据库操作类', "{$schema->srvName}.db");

		fwrite($stream, "class {$schema->ucClsName} extends DynamicDb\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * @var string 数据库配置名\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tprotected \$_clusterName = Constant::DB_CLUSTER;\n");
		fwrite($stream, "}\n");

		fclose($stream);
		Log::echoTrace('Generate Db End');
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
}

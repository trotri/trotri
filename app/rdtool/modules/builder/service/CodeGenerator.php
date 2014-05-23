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

use tfc\mvc\Mvc;
use tfc\util\FileManager;
use tfc\saf\Log;
use libsrv\SModFactory;

/**
 * CodeGenerator class file
 * 通过Builders数据生成代码
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: CodeGenerator.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.model
 * @since 1.0
 */
class CodeGenerator
{
	/**
	 * 生成代码
	 * @return void
	 */
	public function run()
	{
		Log::echoTrace('Generate Begin, Table Name "' . $this->_builders['tbl_name'] . '"');

		$this->gcSLangs();
		$this->gcSDb();
		$this->gcSData();
		$this->gcSModel();
		$this->gcLangs();
		$this->gcModel();
		$this->gcCtrl();
		$this->gcActs();
		$this->gcViews();

		Log::echoTrace('Generate End, Table Name "' . $this->_builders['tbl_name'] . '"');
	}

	/**
	 * 创建View层文件
	 * @return void
	 */
	public function gcViews()
	{
		Log::echoTrace('Generate App Views Begin ...');

		$tmpListIndexShows = array();
		$tmpFormCreateShows = array();
		$tmpFormModifyShows = array();
		foreach ($this->_fields as $rows) {
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

		$modName = $this->_builders['mod_name'];
		$ctrlName = $this->_builders['ctrl_name'];

		// 创建 Index View
		$tmpFileName = $ctrlName . '_' . $this->_builders['act_index_name'];
		$filePath = $this->_dirs['view'] . DS . $tmpFileName . '.php';
		$stream = $this->fopen($filePath);

		fwrite($stream, "<?php \$this->display('{$modName}/{$tmpFileName}_btns'); ?>\n\n");
		fwrite($stream, "<?php\n");
		fwrite($stream, "\$this->widget(\n");
		fwrite($stream, "\t'views\\bootstrap\\widgets\\TableBuilder',\n");
		fwrite($stream, "\tarray(\n");
		fwrite($stream, "\t\t'elements' => \$this->elements,\n");
		fwrite($stream, "\t\t'data' => \$this->data,\n");
		fwrite($stream, "\t\t'columns' => array(\n");
		foreach ($listIndexShows as $columnName) {
			fwrite($stream, "\t\t\t'{$columnName}',\n");
		}
		fwrite($stream, "\t\t\t'_operate_',\n");
		fwrite($stream, "\t\t),\n");
		fwrite($stream, "\t\t'checkedToggle' => '" . $this->_pkColumn . "',\n");
		fwrite($stream, "\t)\n");
		fwrite($stream, ");\n");
		fwrite($stream, "?>\n\n");
		fwrite($stream, "<?php \$this->display('{$modName}/{$tmpFileName}_btns'); ?>\n\n");
		fwrite($stream, "<?php\n");
		fwrite($stream, "\$this->widget(\n");
		fwrite($stream, "\t'views\\bootstrap\\widgets\\PaginatorBuilder',\n");
		fwrite($stream, "\t\$this->paginator\n");
		fwrite($stream, ");\n");
		fwrite($stream, "?>");

		fclose($stream);
		Log::echoTrace('Generate App View ' .$tmpFileName . ' Successfully');

		// 创建 Index View Btns
		$tmpFileName = $ctrlName . '_' . $this->_builders['act_index_name'] . '_btns';
		$filePath = $this->_dirs['view'] . DS . $tmpFileName . '.php';
		$stream = $this->fopen($filePath);
		fclose($stream);
		Log::echoTrace('Generate App View ' .$tmpFileName . ' Successfully');

		// 创建 Sidebar View
		$tmpFileName = $ctrlName . '_sidebar';
		$filePath = $this->_dirs['view'] . DS . $tmpFileName . '.php';
		$stream = $this->fopen($filePath);
		fwrite($stream, "<!-- SideBar -->\n");
		fwrite($stream, "<div class=\"col-xs-6 col-sm-2 sidebar-offcanvas\" id=\"sidebar\">\n");
		fwrite($stream, "<?php\n");
		fwrite($stream, "\$config = array(\n");
		fwrite($stream, ");\n");
		fwrite($stream, "\$this->widget('views\\bootstrap\\components\\bar\\SideBar', array('config' => \$config));\n");
		fwrite($stream, "?>\n");
		fwrite($stream, "</div><!-- /.col-xs-6 col-sm-2 -->\n");
		fwrite($stream, "<!-- /SideBar -->\n\n");
		fwrite($stream, "<?php echo \$this->getHtml()->jsFile(\$this->js_url . '/mods/{$modName}.js?v=' . \$this->version); ?>\n");

		fclose($stream);
		Log::echoTrace('Generate App View ' .$tmpFileName . ' Successfully');

		if ($this->_hasTrash) {
			// 创建 TrashIndex View
			$tmpFileName = $ctrlName . '_' . $this->_builders['act_trashindex_name'];
			$filePath = $this->_dirs['view'] . DS . $tmpFileName . '.php';
			$stream = $this->fopen($filePath);

			fwrite($stream, "<?php \$this->display('{$modName}/{$tmpFileName}_btns'); ?>\n\n");
			fwrite($stream, "<?php\n");
			fwrite($stream, "\$this->widget(\n");
			fwrite($stream, "\t'views\\bootstrap\\widgets\\TableBuilder',\n");
			fwrite($stream, "\tarray(\n");
			fwrite($stream, "\t\t'elements' => \$this->elements,\n");
			fwrite($stream, "\t\t'data' => \$this->data,\n");
			fwrite($stream, "\t\t'columns' => array(\n");
			foreach ($listIndexShows as $columnName) {
				fwrite($stream, "\t\t\t'{$columnName}',\n");
			}
			fwrite($stream, "\t\t\t'_operate_',\n");
			fwrite($stream, "\t\t),\n");
			fwrite($stream, "\t\t'checkedToggle' => '" . $this->_pkColumn . "',\n");
			fwrite($stream, "\t)\n");
			fwrite($stream, ");\n");
			fwrite($stream, "?>\n\n");
			fwrite($stream, "<?php \$this->display('{$modName}/{$tmpFileName}_btns'); ?>\n\n");
			fwrite($stream, "<?php\n");
			fwrite($stream, "\$this->widget(\n");
			fwrite($stream, "\t'views\\bootstrap\\widgets\\PaginatorBuilder',\n");
			fwrite($stream, "\t\$this->paginator\n");
			fwrite($stream, ");\n");
			fwrite($stream, "?>");

			fclose($stream);
			Log::echoTrace('Generate App View ' .$tmpFileName . ' Successfully');

			// 创建 TrashIndex View Btns
			$tmpFileName = $ctrlName . '_' . $this->_builders['act_trashindex_name'] . '_btns';
			$filePath = $this->_dirs['view'] . DS . $tmpFileName . '.php';
			$stream = $this->fopen($filePath);

			fclose($stream);
			Log::echoTrace('Generate App View ' .$tmpFileName . ' Successfully');
		}

		// 创建 View View
		$tmpFileName = $ctrlName . '_' . $this->_builders['act_view_name'];
		$filePath = $this->_dirs['view'] . DS . $tmpFileName . '.php';
		$stream = $this->fopen($filePath);

		fwrite($stream, "<?php\n");
		fwrite($stream, "\$this->widget('views\\bootstrap\\widgets\\ViewBuilder',\n");
		fwrite($stream, "\tarray(\n");
		fwrite($stream, "\t\t'name' => 'view',\n");
		fwrite($stream, "\t\t'tabs' => \$this->tabs,\n");
		fwrite($stream, "\t\t'values' => \$this->data,\n");
		fwrite($stream, "\t\t'elements' => \$this->elements,\n");
		fwrite($stream, "\t\t'columns' => array(\n");
		foreach ($this->_fields as $rows) {
			fwrite($stream, "\t\t\t'{$rows['field_name']}',\n");
		}
		fwrite($stream, "\t\t\t'_button_history_back_',\n");
		fwrite($stream, "\t\t)\n");
		fwrite($stream, "\t)\n");
		fwrite($stream, ");\n");

		fclose($stream);
		Log::echoTrace('Generate App View ' .$tmpFileName . ' Successfully');

		// 创建 Create View
		$tmpFileName = $ctrlName . '_' . $this->_builders['act_create_name'];
		$filePath = $this->_dirs['view'] . DS . $tmpFileName . '.php';
		$stream = $this->fopen($filePath);

		fwrite($stream, "<?php\n");
		fwrite($stream, "\$this->widget('views\\bootstrap\\widgets\\FormBuilder',\n");
		fwrite($stream, "\tarray(\n");
		fwrite($stream, "\t\t'name' => 'create',\n");
		fwrite($stream, "\t\t'action' => \$this->getUrlManager()->getUrl(\$this->action),\n");
		fwrite($stream, "\t\t'tabs' => \$this->tabs,\n");
		fwrite($stream, "\t\t'errors' => \$this->errors,\n");
		fwrite($stream, "\t\t'elements' => \$this->elements,\n");
		fwrite($stream, "\t\t'columns' => array(\n");
		foreach ($formCreateShows as $columnName) {
			fwrite($stream, "\t\t\t'{$columnName}',\n");
		}
		fwrite($stream, "\t\t\t'_button_save_',\n");
		fwrite($stream, "\t\t\t'_button_save2close_',\n");
		fwrite($stream, "\t\t\t'_button_save2new_',\n");
		fwrite($stream, "\t\t\t'_button_cancel_',\n");
		fwrite($stream, "\t\t)\n");
		fwrite($stream, "\t)\n");
		fwrite($stream, ");\n");

		fclose($stream);
		Log::echoTrace('Generate App View ' .$tmpFileName . ' Successfully');

		// 创建 Modify View
		$tmpFileName = $ctrlName . '_' . $this->_builders['act_modify_name'];
		$filePath = $this->_dirs['view'] . DS . $tmpFileName . '.php';
		$stream = $this->fopen($filePath);

		fwrite($stream, "<?php\n");
		fwrite($stream, "\$this->widget('views\\bootstrap\\widgets\\FormBuilder',\n");
		fwrite($stream, "\tarray(\n");
		fwrite($stream, "\t\t'name' => 'modify',\n");
		fwrite($stream, "\t\t'action' => \$this->getUrlManager()->getUrl(\$this->action, '', '', array('id' => \$this->id)),\n");
		fwrite($stream, "\t\t'tabs' => \$this->tabs,\n");
		fwrite($stream, "\t\t'values' => \$this->data,\n");
		fwrite($stream, "\t\t'errors' => \$this->errors,\n");
		fwrite($stream, "\t\t'elements' => \$this->elements,\n");
		fwrite($stream, "\t\t'columns' => array(\n");
		foreach ($formModifyShows as $columnName) {
			fwrite($stream, "\t\t\t'{$columnName}',\n");
		}
		fwrite($stream, "\t\t\t'_button_save_',\n");
		fwrite($stream, "\t\t\t'_button_save2close_',\n");
		fwrite($stream, "\t\t\t'_button_save2new_',\n");
		fwrite($stream, "\t\t\t'_button_cancel_',\n");
		fwrite($stream, "\t\t)\n");
		fwrite($stream, "\t)\n");
		fwrite($stream, ");\n");

		fclose($stream);
		Log::echoTrace('Generate App View ' .$tmpFileName . ' Successfully');

		Log::echoTrace('Generate App Views End');
	}

	/**
	 * 创建Actions层类
	 * @return void
	 */
	public function gcActs()
	{
		Log::echoTrace('Generate App Acts Begin ...');

		$modName = $this->_builders['mod_name'];
		$clsName = $this->_builders['uc_cls_name'];
		$fkColumnName = isset($this->_builders['fk_column']) ? $this->_builders['fk_column'] : '';
		$fkColumnFunc = $this->column2Name($fkColumnName);
		$fkColumnVar = strtolower(substr($fkColumnFunc, 0, 1)) . substr($fkColumnFunc, 1);

		// 创建 Index Action
		$tmpClsName = $clsName . 'Index';
		$filePath = $this->_dirs['act']['show'] . DS . $tmpClsName . '.php';
		$stream = $this->fopen($filePath);
		$this->writeCopyrightComment($stream);
		fwrite($stream, "namespace modules\\{$modName}\\action\\show;\n\n");
		if ($this->_hasTrash || $this->_hasSort || $fkColumnName) {
			fwrite($stream, "use tfc\\ap\\Ap;\n");
		}
		fwrite($stream, "use library\\action\\IndexAction;\n\n");
		$this->writeClassComment($stream, $tmpClsName, '查询数据列表', "modules.{$modName}.action.show");
		fwrite($stream, "class {$tmpClsName} extends IndexAction\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see tfc\\mvc\\interfaces.Action::run()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function run()\n");
		fwrite($stream, "\t{\n");
		if ($fkColumnName) {
			fwrite($stream, "\t\t\${$fkColumnVar} = Ap::getRequest()->getInteger('{$fkColumnName}');\n");
			fwrite($stream, "\t\tif (\${$fkColumnVar} <= 0) {\n");
			fwrite($stream, "\t\t\t\$this->err404();\n");
			fwrite($stream, "\t\t}\n\n");
			fwrite($stream, "\t\t\$this->assign('{$fkColumnName}', \${$fkColumnVar});\n\n");
		}
		if ($this->_hasTrash) { fwrite($stream, "\t\tAp::getRequest()->setParam('trash', 'n');\n"); }
		if ($this->_hasSort) { fwrite($stream, "\t\tAp::getRequest()->setParam('order', 'sort');\n"); }
		fwrite($stream, "\t\t\$this->execute('{$clsName}');\n");
		fwrite($stream, "\t}\n");
		fwrite($stream, "}\n");
		fclose($stream);
		Log::echoTrace('Generate App Act ' .$tmpClsName . ' Successfully');

		if ($this->_hasTrash) {
			// 创建 TrashIndex Action
			$tmpClsName = $clsName . 'TrashIndex';
			$filePath = $this->_dirs['act']['show'] . DS . $tmpClsName . '.php';
			$stream = $this->fopen($filePath);
			$this->writeCopyrightComment($stream);
			fwrite($stream, "namespace modules\\{$modName}\\action\\show;\n\n");
			fwrite($stream, "use tfc\\ap\\Ap;\n");
			fwrite($stream, "use library\\action\\IndexAction;\n\n");
			$this->writeClassComment($stream, $tmpClsName, '查询回收站数据列表', "modules.{$modName}.action.show");
			fwrite($stream, "class {$tmpClsName} extends IndexAction\n");
			fwrite($stream, "{\n");
			fwrite($stream, "\t/**\n");
			fwrite($stream, "\t * (non-PHPdoc)\n");
			fwrite($stream, "\t * @see tfc\\mvc\\interfaces.Action::run()\n");
			fwrite($stream, "\t */\n");
			fwrite($stream, "\tpublic function run()\n");
			fwrite($stream, "\t{\n");
			if ($fkColumnName) {
				fwrite($stream, "\t\t\${$fkColumnVar} = Ap::getRequest()->getInteger('{$fkColumnName}');\n");
				fwrite($stream, "\t\tif (\${$fkColumnVar} <= 0) {\n");
				fwrite($stream, "\t\t\t\$this->err404();\n");
				fwrite($stream, "\t\t}\n\n");
				fwrite($stream, "\t\t\$this->assign('{$fkColumnName}', \${$fkColumnVar});\n\n");
			}
			fwrite($stream, "\t\tAp::getRequest()->setParam('trash', 'y');\n");
			if ($this->_hasSort) { fwrite($stream, "\t\tAp::getRequest()->setParam('order', 'sort');\n"); }
			fwrite($stream, "\t\t\$this->execute('{$clsName}');\n");
			fwrite($stream, "\t}\n");
			fwrite($stream, "}\n");
			fclose($stream);
			Log::echoTrace('Generate App Act ' .$tmpClsName . ' Successfully');
		}

		// 创建 View Action
		$tmpClsName = $clsName . 'View';
		$filePath = $this->_dirs['act']['show'] . DS . $tmpClsName . '.php';
		$stream = $this->fopen($filePath);
		$this->writeCopyrightComment($stream);
		fwrite($stream, "namespace modules\\{$modName}\\action\\show;\n\n");
		fwrite($stream, "use library\\action\\ViewAction;\n");
		if ($fkColumnName) { fwrite($stream, "use library\\Model;\n"); }
		fwrite($stream, "\n");
		$this->writeClassComment($stream, $tmpClsName, '查询数据详情', "modules.{$modName}.action.show");
		fwrite($stream, "class {$tmpClsName} extends ViewAction\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see tfc\\mvc\\interfaces.Action::run()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function run()\n");
		fwrite($stream, "\t{\n");
		if ($fkColumnName) {
			fwrite($stream, "\t\t\$mod = Model::getInstance('{$clsName}');\n");
			fwrite($stream, "\t\t\${$fkColumnVar} = \$mod->get{$fkColumnFunc}();\n");
			fwrite($stream, "\t\tif (\${$fkColumnVar} <= 0) {\n");
			fwrite($stream, "\t\t\t\$this->err404();\n");
			fwrite($stream, "\t\t}\n\n");
			fwrite($stream, "\t\t\$this->assign('{$fkColumnName}', \${$fkColumnVar});\n");
		}
		fwrite($stream, "\t\t\$this->execute('{$clsName}');\n");
		fwrite($stream, "\t}\n");
		fwrite($stream, "}\n");
		fclose($stream);
		Log::echoTrace('Generate App Act ' .$tmpClsName . ' Successfully');

		// 创建 Create Action
		$tmpClsName = $clsName . 'Create';
		$filePath = $this->_dirs['act']['submit'] . DS . $tmpClsName . '.php';
		$stream = $this->fopen($filePath);
		$this->writeCopyrightComment($stream);
		fwrite($stream, "namespace modules\\{$modName}\\action\\submit;\n\n");
		fwrite($stream, "use library\\action\\CreateAction;\n");
		if ($fkColumnName) { fwrite($stream, "use library\\Model;\n"); }
		fwrite($stream, "\n");
		$this->writeClassComment($stream, $tmpClsName, '新增数据', "modules.{$modName}.action.submit");
		fwrite($stream, "class {$tmpClsName} extends CreateAction\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see tfc\\mvc\\interfaces.Action::run()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function run()\n");
		fwrite($stream, "\t{\n");
		if ($fkColumnName) {
			fwrite($stream, "\t\t\$mod = Model::getInstance('{$clsName}');\n");
			fwrite($stream, "\t\t\${$fkColumnVar} = \$mod->get{$fkColumnFunc}();\n");
			fwrite($stream, "\t\tif (\${$fkColumnVar} <= 0) {\n");
			fwrite($stream, "\t\t\t\$this->err404();\n");
			fwrite($stream, "\t\t}\n\n");
			fwrite($stream, "\t\t\$this->assign('{$fkColumnName}', \${$fkColumnVar});\n");
		}
		fwrite($stream, "\t\t\$this->execute('{$clsName}');\n");
		fwrite($stream, "\t}\n");
		fwrite($stream, "}\n");
		fclose($stream);
		Log::echoTrace('Generate App Act ' .$tmpClsName . ' Successfully');

		// 创建 Modify Action
		$tmpClsName = $clsName . 'Modify';
		$filePath = $this->_dirs['act']['submit'] . DS . $tmpClsName . '.php';
		$stream = $this->fopen($filePath);
		$this->writeCopyrightComment($stream);
		fwrite($stream, "namespace modules\\{$modName}\\action\\submit;\n\n");
		fwrite($stream, "use library\\action\\ModifyAction;\n");
		if ($fkColumnName) { fwrite($stream, "use library\\Model;\n"); }
		fwrite($stream, "\n");
		$this->writeClassComment($stream, $tmpClsName, '编辑数据', "modules.{$modName}.action.submit");
		fwrite($stream, "class {$tmpClsName} extends ModifyAction\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see tfc\\mvc\\interfaces.Action::run()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function run()\n");
		fwrite($stream, "\t{\n");
		if ($fkColumnName) {
			fwrite($stream, "\t\t\$mod = Model::getInstance('{$clsName}');\n");
			fwrite($stream, "\t\t\${$fkColumnVar} = \$mod->get{$fkColumnFunc}();\n");
			fwrite($stream, "\t\tif (\${$fkColumnVar} <= 0) {\n");
			fwrite($stream, "\t\t\t\$this->err404();\n");
			fwrite($stream, "\t\t}\n\n");
			fwrite($stream, "\t\t\$this->assign('{$fkColumnName}', \${$fkColumnVar});\n");
		}
		fwrite($stream, "\t\t\$this->execute('{$clsName}');\n");
		fwrite($stream, "\t}\n");
		fwrite($stream, "}\n");
		fclose($stream);
		Log::echoTrace('Generate App Act ' .$tmpClsName . ' Successfully');

		// 创建 Remove Action
		$tmpClsName = $clsName . 'Remove';
		$filePath = $this->_dirs['act']['submit'] . DS . $tmpClsName . '.php';
		$stream = $this->fopen($filePath);
		$this->writeCopyrightComment($stream);
		fwrite($stream, "namespace modules\\{$modName}\\action\\submit;\n\n");
		fwrite($stream, "use library\\action\\base\\RemoveAction;\n\n");
		$this->writeClassComment($stream, $tmpClsName, '删除数据', "modules.{$modName}.action.submit");
		fwrite($stream, "class {$tmpClsName} extends RemoveAction\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see tfc\\mvc\\interfaces.Action::run()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function run()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$this->execute('{$clsName}');\n");
		fwrite($stream, "\t}\n");
		fwrite($stream, "}\n");
		fclose($stream);
		Log::echoTrace('Generate App Act ' .$tmpClsName . ' Successfully');

		// 创建 SingleModify Action
		$tmpClsName = $clsName . 'SingleModify';
		$filePath = $this->_dirs['act']['submit'] . DS . $tmpClsName . '.php';
		$stream = $this->fopen($filePath);
		$this->writeCopyrightComment($stream);
		fwrite($stream, "namespace modules\\{$modName}\\action\\submit;\n\n");
		fwrite($stream, "use library\\action\\SingleModifyAction;\n\n");
		$this->writeClassComment($stream, $tmpClsName, '编辑单个字段', "modules.{$modName}.action.submit");
		fwrite($stream, "class {$tmpClsName} extends SingleModifyAction\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see tfc\\mvc\\interfaces.Action::run()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function run()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$this->execute('{$clsName}');\n");
		fwrite($stream, "\t}\n");
		fwrite($stream, "}\n");
		fclose($stream);
		Log::echoTrace('Generate App Act ' .$tmpClsName . ' Successfully');

		if ($this->_hasTrash) {
			// 创建 Trash Action
			$tmpClsName = $clsName . 'Trash';
			$filePath = $this->_dirs['act']['submit'] . DS . $tmpClsName . '.php';
			$stream = $this->fopen($filePath);
			$this->writeCopyrightComment($stream);
			fwrite($stream, "namespace modules\\{$modName}\\action\\submit;\n\n");
			fwrite($stream, "use library\\action\\base\\TrashAction;\n\n");
			$this->writeClassComment($stream, $tmpClsName, '移至回收站和从回收站还原', "modules.{$modName}.action.submit");
			fwrite($stream, "class {$tmpClsName} extends TrashAction\n");
			fwrite($stream, "{\n");
			fwrite($stream, "\t/**\n");
			fwrite($stream, "\t * (non-PHPdoc)\n");
			fwrite($stream, "\t * @see tfc\\mvc\\interfaces.Action::run()\n");
			fwrite($stream, "\t */\n");
			fwrite($stream, "\tpublic function run()\n");
			fwrite($stream, "\t{\n");
			fwrite($stream, "\t\t\$this->execute('{$clsName}');\n");
			fwrite($stream, "\t}\n");
			fwrite($stream, "}\n");
			fclose($stream);
			Log::echoTrace('Generate App Act ' .$tmpClsName . ' Successfully');
		}

		Log::echoTrace('Generate App Acts End');
	}

	/**
	 * 创建Ctrl层类
	 * @return void
	 */
	public function gcCtrl()
	{
		Log::echoTrace('Generate App Ctrl Begin ...');

		$modName = $this->_builders['mod_name'];
		$clsName = $this->_builders['uc_cls_name'];
		$ctrlName = $this->_builders['uc_ctrl_name'] . 'Controller';
		$builderName = $this->_builders['builder_name'];

		$filePath = $this->_dirs['ctrl'] . DS . $ctrlName . '.php';
		$stream = $this->fopen($filePath);
		$this->writeCopyrightComment($stream);

		fwrite($stream, "namespace modules\\{$modName}\\controller;\n\n");
		fwrite($stream, "use library\\BaseController;\n\n");
		$this->writeClassComment($stream, $ctrlName, $builderName, "modules.{$modName}.controller");

		fwrite($stream, "class {$ctrlName} extends BaseController\n");
		fwrite($stream, "{\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see tfc\\mvc.Controller::actions()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function actions()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\treturn array(\n");

		$acts = array(
			'Index' => array(
				'name' => $this->_builders['act_index_name'],
				'type' => 'show',
			),
			'TrashIndex' => array(
				'name' => $this->_builders['act_trashindex_name'],
				'type' => 'show',
			),
			'View' => array(
				'name' => $this->_builders['act_view_name'],
				'type' => 'show',
			),
			'Create' => array(
				'name' => $this->_builders['act_create_name'],
				'type' => 'submit',
			),
			'Modify' => array(
				'name' => $this->_builders['act_modify_name'],
				'type' => 'submit',
			),
			'Remove' => array(
				'name' => $this->_builders['act_remove_name'],
				'type' => 'submit',
			),
			'SingleModify' => array(
				'name' => $this->_builders['act_single_modify'],
				'type' => 'submit',
			),
			'Trash' => array(
				'name' => $this->_builders['act_trash_name'],
				'type' => 'submit',
			),
		);

		$maxLen = 0;
		foreach ($acts as $rows) {
			if (($len = strlen('\'' . $rows['name'] . '\'')) > $maxLen) {
				$maxLen = $len;
			}
		}

		foreach ($acts as $sysActName => $rows) {
			if ($rows['name'] === '') {
				continue;
			}

			$actName = str_pad('\'' . $rows['name'] . '\'', $maxLen);
			fwrite($stream, "\t\t\t{$actName} => 'modules\\\\{$modName}\\\\action\\\\{$rows['type']}\\\\{$clsName}{$sysActName}',\n");
		}

		fwrite($stream, "\t\t);\n");
		fwrite($stream, "\t}\n");

		fwrite($stream, "}\n");
		fclose($stream);
		Log::echoTrace('Generate App Ctrl End');
	}

	/**
	 * 创建Model层类
	 * @return void
	 */
	public function gcModel()
	{
		Log::echoTrace('Generate App Model Begin ...');

		$modName = $this->_builders['mod_name'];
		$clsName = $this->_builders['uc_cls_name'];
		$builderName = $this->_builders['builder_name'];

		$filePath = $this->_dirs['mod'] . DS . $clsName . '.php';
		$stream = $this->fopen($filePath);
		$this->writeCopyrightComment($stream);

		fwrite($stream, "namespace modules\\{$modName}\\model;\n\n");
		$fkColumnName = isset($this->_builders['fk_column']) ? $this->_builders['fk_column'] : '';
		$fkColumnFunc = $this->column2Name($fkColumnName);
		$fkColumnVar = strtolower(substr($fkColumnFunc, 0, 1)) . substr($fkColumnFunc, 1);
		if ($fkColumnName) { fwrite($stream, "use tfc\\ap\\Ap;\n"); }
		fwrite($stream, "use tfc\\mvc\\Mvc;\n");
		fwrite($stream, "use tfc\\saf\\Text;\n");
		fwrite($stream, "use library\\Model;\n");
		fwrite($stream, "use library\\ErrorNo;\n");
		fwrite($stream, "use library\\PageHelper;\n\n");
		$this->writeClassComment($stream, $clsName, $builderName, "modules.{$modName}.model");

		fwrite($stream, "class {$clsName} extends Model\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * @var string 查询列表数据Action名\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tconst ACT_INDEX = '{$this->_builders['act_index_name']}';\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * @var string 数据详情Action名\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tconst ACT_VIEW = '{$this->_builders['act_view_name']}';\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * @var string 新增数据Action名\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tconst ACT_CREATE = '{$this->_builders['act_create_name']}';\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * @var string 编辑数据Action名\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tconst ACT_MODIFY = '{$this->_builders['act_modify_name']}';\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * @var string 删除数据Action名\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tconst ACT_REMOVE = '{$this->_builders['act_remove_name']}';\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * @var string 移至回收站Action名\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tconst ACT_TRASH = 'trash';\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see library.Model::getLastIndexUrl()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function getLastIndexUrl()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\tif ((\$lastIndexUrl = parent::getLastIndexUrl()) !== '') {\n");
		fwrite($stream, "\t\t\treturn \$lastIndexUrl;\n");
		fwrite($stream, "\t\t}\n\n");

		if ($this->_hasTrash) {
			if ($fkColumnName) {
				fwrite($stream, "\t\t\$params = array('trash' => 'n', '{$fkColumnName}' => \$this->get{$fkColumnFunc}());\n");
			}
			else {
				fwrite($stream, "\t\t\$params = array('trash' => 'n');\n");
			}
		}
		else {
			if ($fkColumnName) {
				fwrite($stream, "\t\t\$params = array('{$fkColumnName}' => \$this->get{$fkColumnFunc}());\n");
			}
			else {
				fwrite($stream, "\t\t\$params = array();\n");
			}
		}
		fwrite($stream, "\t\treturn \$this->getUrl(self::ACT_INDEX, Mvc::\$controller, Mvc::\$module, \$params);\n");
		fwrite($stream, "\t}\n\n");

		if ($fkColumnName) {
			fwrite($stream, "\t/**\n");
			fwrite($stream, "\t * 获取{$fkColumnName}值\n");
			fwrite($stream, "\t * @return integer\n");
			fwrite($stream, "\t */\n");
			fwrite($stream, "\tpublic function get{$fkColumnFunc}()\n");
			fwrite($stream, "\t{\n");
			fwrite($stream, "\t\t\${$fkColumnVar} = Ap::getRequest()->getInteger('{$fkColumnName}');\n");
			fwrite($stream, "\t\tif (\${$fkColumnVar} <= 0) {\n");
			fwrite($stream, "\t\t\t\$id = Ap::getRequest()->getInteger('id');\n");
			fwrite($stream, "\t\t\t\${$fkColumnVar} = \$this->getColById('{$fkColumnName}', \$id);\n");
			fwrite($stream, "\t\t}\n\n");
			fwrite($stream, "\t\treturn \${$fkColumnVar};\n");
			fwrite($stream, "\t}\n\n");
		}

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see library.Model::getViewTabsRender()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function getViewTabsRender()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$output = array(\n");
		foreach ($this->_groups as $rows) {
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
		fwrite($stream, "\t * @see library.Model::getElementsRender()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function getElementsRender()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$data = \$this->getData();\n");
		fwrite($stream, "\t\t\$output = array(\n");
		foreach ($this->_fields as $rows) {
			$type = ($fkColumnName === $rows['field_name']) ? 'hidden' : $rows['form_type'];

			fwrite($stream, "\t\t\t'{$rows['field_name']}' => array(\n");
			fwrite($stream, "\t\t\t\t'__tid__' => '{$rows['__tid__']}',\n");
			fwrite($stream, "\t\t\t\t'type' => '{$type}',\n");
			fwrite($stream, "\t\t\t\t'label' => Text::_('{$rows['lang_label']}'),\n");
			fwrite($stream, "\t\t\t\t'hint' => Text::_('{$rows['lang_hint']}'),\n");
			if ($fkColumnName === $rows['field_name']) {
				fwrite($stream, "\t\t\t\t'value' => \$this->get{$fkColumnFunc}(),\n");
			}
			else {
				if ($rows['form_required']) {
					fwrite($stream, "\t\t\t\t'required' => true,\n");
				}
				if ($rows['form_modifiable']) {
					fwrite($stream, "\t\t\t\t'disabled' => true,\n");
				}
			}
			if (isset($rows['enums'])) {
				$enum = array_shift($rows['enums']);
				fwrite($stream, "\t\t\t\t'options' => \$data->getEnum('{$rows['field_name']}'),\n");
				fwrite($stream, "\t\t\t\t'value' => \$data::{$enum['const_key']},\n");
			}
			fwrite($stream, "\t\t\t\t'search' => array(\n");
			fwrite($stream, "\t\t\t\t\t'type' => '" . (isset($rows['enums']) ? 'select' : 'text') . "',\n");
			fwrite($stream, "\t\t\t\t),\n");
			fwrite($stream, "\t\t\t),\n");
		}
		fwrite($stream, "\t\t\t'_button_save_' => PageHelper::getComponentsBuilder()->getButtonSave(),\n");
		fwrite($stream, "\t\t\t'_button_save2close_' => PageHelper::getComponentsBuilder()->getButtonSaveClose(),\n");
		fwrite($stream, "\t\t\t'_button_save2new_' => PageHelper::getComponentsBuilder()->getButtonSaveNew(),\n");
		fwrite($stream, "\t\t\t'_button_cancel_' => PageHelper::getComponentsBuilder()->getButtonCancel(array('url' => \$this->getLastIndexUrl())),\n");
		fwrite($stream, "\t\t\t'_button_history_back_' => PageHelper::getComponentsBuilder()->getButtonHistoryBack(array('url' => \$this->getLastIndexUrl())),\n");
		fwrite($stream, "\t\t\t'_operate_' => array(\n");
		fwrite($stream, "\t\t\t\t'label' => Text::_('CFG_SYSTEM_GLOBAL_OPERATE'),\n");
		fwrite($stream, "\t\t\t\t'table' => array(\n");
		fwrite($stream, "\t\t\t\t\t'callback' => array(\$this, 'getOperate')\n");
		fwrite($stream, "\t\t\t\t)\n");
		fwrite($stream, "\t\t\t),\n");
		fwrite($stream, "\t\t);\n\n");
		fwrite($stream, "\t\treturn \$output;\n");
		fwrite($stream, "\t}\n\n");

		if ($fkColumnName) {
			fwrite($stream, "\t/**\n");
			fwrite($stream, "\t * (non-PHPdoc)\n");
			fwrite($stream, "\t * @see library.Model::create()\n");
			fwrite($stream, "\t */\n");
			fwrite($stream, "\tpublic function create(array \$params = array())\n");
			fwrite($stream, "\t{\n");
			fwrite($stream, "\t\t\$ret = parent::create(\$params);\n");
			fwrite($stream, "\t\tif (\$ret['err_no'] === ErrorNo::SUCCESS_NUM) {\n");
			fwrite($stream, "\t\t\t\$ret['{$fkColumnName}'] = \$this->getColById('$fkColumnName', \$ret['id']);\n");
			fwrite($stream, "\t\t}\n\n");
			fwrite($stream, "\t\treturn \$ret;\n");
			fwrite($stream, "\t}\n\n");
		}

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 获取操作图标按钮\n");
		fwrite($stream, "\t * @param array \$data\n");
		fwrite($stream, "\t * @return string\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function getOperate(\$data)\n");
		fwrite($stream, "\t{\n");
		if ($fkColumnName) {
			fwrite($stream, "\t\t\$params = array(\n");
			fwrite($stream, "\t\t\t'id' => \$data['" . $this->_pkColumn . "'],\n");
			fwrite($stream, "\t\t\t'{$fkColumnName}' => \$data['" . $fkColumnName . "']\n\t\t);\n");
		}
		else {
			fwrite($stream, "\t\t\$params = array('id' => \$data['" . $this->_pkColumn . "']);\n");
		}
		fwrite($stream, "\t\t\$componentsBuilder = PageHelper::getComponentsBuilder();\n\n");
		$output = '\'\'';
		if (in_array('pencil', $this->_builders['index_row_btns'])) {
			fwrite($stream, "\t\t\$modifyIcon = \$componentsBuilder->getGlyphicon(array(\n");
			fwrite($stream, "\t\t\t'type' => \$componentsBuilder->getGlyphiconModify(),\n");
			fwrite($stream, "\t\t\t'url' => \$this->getUrl(self::ACT_MODIFY, Mvc::\$controller, Mvc::\$module, \$params),\n");
			fwrite($stream, "\t\t\t'jsfunc' => \$componentsBuilder->getJsFuncHref(),\n");
			fwrite($stream, "\t\t\t'title' => Text::_('CFG_SYSTEM_GLOBAL_MODIFY'),\n");
			fwrite($stream, "\t\t));\n\n");
			$output .= ' . $modifyIcon';
		}

		if (in_array('remove', $this->_builders['index_row_btns'])) {
			fwrite($stream, "\t\t\$removeIcon = \$componentsBuilder->getGlyphicon(array(\n");
			fwrite($stream, "\t\t\t'type' => \$componentsBuilder->getGlyphiconRemove(),\n");
			fwrite($stream, "\t\t\t'url' => \$this->getUrl(self::ACT_REMOVE, Mvc::\$controller, Mvc::\$module, \$params),\n");
			fwrite($stream, "\t\t\t'jsfunc' => \$componentsBuilder->getJsFuncDialogRemove(),\n");
			fwrite($stream, "\t\t\t'title' => Text::_('CFG_SYSTEM_GLOBAL_REMOVE'),\n");
			fwrite($stream, "\t\t));\n\n");
			$output .= ' . $removeIcon';
		}

		if (in_array('trash', $this->_builders['index_row_btns'])) {
			fwrite($stream, "\t\t\$trashIcon = \$componentsBuilder->getGlyphicon(array(\n");
			fwrite($stream, "\t\t\t'type' => \$componentsBuilder->getGlyphiconTrash(),\n");
			fwrite($stream, "\t\t\t'url' => \$this->getUrl(self::ACT_TRASH, Mvc::\$controller, Mvc::\$module, \$params),\n");
			fwrite($stream, "\t\t\t'jsfunc' => \$componentsBuilder->getJsFuncDialogTrash(),\n");
			fwrite($stream, "\t\t\t'title' => Text::_('CFG_SYSTEM_GLOBAL_TRASH'),\n");
			fwrite($stream, "\t\t));\n\n");
			$output .= ' . $trashIcon';

			fwrite($stream, "\t\t\$params['is_restore'] = '1';\n");
			fwrite($stream, "\t\t\$restoreIcon = \$componentsBuilder->getGlyphicon(array(\n");
			fwrite($stream, "\t\t\t'type' => \$componentsBuilder->getGlyphiconRestore(),\n");
			fwrite($stream, "\t\t\t'url' => \$this->getUrl(self::ACT_TRASH, Mvc::\$controller, Mvc::\$module, \$params),\n");
			fwrite($stream, "\t\t\t'jsfunc' => \$componentsBuilder->getJsFuncHref(),\n");
			fwrite($stream, "\t\t\t'title' => Text::_('CFG_SYSTEM_GLOBAL_RESTORE'),\n");
			fwrite($stream, "\t\t));\n\n");
			$output .= ' . $restoreIcon';
		}

		fwrite($stream, "\t\t\$output = {$output};\n");
		fwrite($stream, "\t\treturn \$output;\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "}\n");
		fclose($stream);
		Log::echoTrace('Generate App Model End');
	}

	/**
	 * 创建app层语言包
	 * @return void
	 */
	public function gcLangs()
	{
		Log::echoTrace('Generate App Languages Begin ...');

		$appName = $this->_builders['app_name'];
		$modName = $this->_builders['mod_name'];
		$tblName = $this->_builders['tbl_name'];
		$builderName = $this->_builders['builder_name'];
		$upCtrlName = strtoupper($this->_builders['ctrl_name']);
		$upModName = strtoupper($modName);

		$fileName = 'zh-CN.mod_' . $modName . '.ini';
		$filePath = $this->_dirs['lang'] . DS . $fileName;

		$stream = $this->fopen($filePath);
		$this->writeLangComment($stream, $fileName, $appName);

		fwrite($stream, "; {$tblName} {$builderName}\n");
		fwrite($stream, "MOD_{$upModName}_URLS_{$upCtrlName}_INDEX=\"{$builderName}管理\"\n");
		fwrite($stream, "MOD_{$upModName}_URLS_{$upCtrlName}_CREATE=\"新增{$builderName}\"\n");
		foreach ($this->_groups as $rows) {
			if ($rows['group_name'] != 'main') {
				fwrite($stream, "{$rows['lang_key']}=\"{$rows['prompt']}\"\n");
			}
		}

		foreach ($this->_fields as $rows) {
			fwrite($stream, "{$rows['lang_label']}=\"{$rows['html_label']}\"\n");
			fwrite($stream, "{$rows['lang_hint']}=\"{$rows['form_prompt']}\"\n");
		}

		fclose($stream);
		Log::echoTrace('Generate App Languages End');
	}

	/**
	 * 创建Services层Model类
	 * @return void
	 */
	public function gcSModel()
	{
		Log::echoTrace('Generate Services Model Begin ...');
		$modName = $this->_builders['mod_name'];
		$clsName = 'Mod' . $this->_builders['uc_cls_name'];

		$filePath = $this->_dirs['smod'] . DS . $clsName . '.php';
		$stream = $this->fopen($filePath);
		$this->writeCopyrightComment($stream);

		fwrite($stream, "namespace smods\\{$modName};\n\n");
		fwrite($stream, "use tfc\\util\\Language;\n");
		fwrite($stream, "use slib\\BaseModel;\n");
		fwrite($stream, "use slib\\Data;\n");
		fwrite($stream, "use slib\\ErrorNo;\n\n");
		$this->writeClassComment($stream, $clsName, '业务层：模型类', "smods.{$modName}");

		fwrite($stream, "class {$clsName} extends BaseModel\n");
		fwrite($stream, "{\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 构造方法：初始化数据库操作类和语言国际化管理类\n");
		fwrite($stream, "\t * @param tfc\\util\\Language \$language\n");
		fwrite($stream, "\t * @param integer \$tableNum 分表数字，如果 >= 0 表示分表操作\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function __construct(Language \$language, \$tableNum = -1)\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$db = new Db{$this->_builders['uc_cls_name']}(\$tableNum);\n");
		fwrite($stream, "\t\tparent::__construct(\$db, \$language);\n");
		fwrite($stream, "\t}\n\n");

		$order = $this->_hasSort ? 'sort' : '';
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 查询数据\n");
		fwrite($stream, "\t * @param array \$params\n");
		fwrite($stream, "\t * @param string \$order\n");
		fwrite($stream, "\t * @param integer \$limit\n");
		fwrite($stream, "\t * @param integer \$offset\n");
		fwrite($stream, "\t * @return array\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function search(array \$params = array(), \$order = '{$order}', \$limit = 0, \$offset = 0)\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$rules = array(\n");
		foreach ($this->_fields as $rows) {
			if ($rows['form_search_show']) {
				if ($rows['field_type'] === 'INT') {
					fwrite($stream, "\t\t\t'{$rows['field_name']}' => 'intval',\n");
				}
				else {
					fwrite($stream, "\t\t\t'{$rows['field_name']}' => 'trim',\n");
				}
			}
		}
		fwrite($stream, "\t\t);\n\n");
		fwrite($stream, "\t\t\$this->_filterCleanEmpty(\$params, \$rules);\n\n");
		fwrite($stream, "\t\treturn \$this->findAllByAttributes(\$params, \$order, \$limit, \$offset);\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 新增一条记录\n");
		fwrite($stream, "\t * @param array \$params\n");
		fwrite($stream, "\t * @return array\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function create(array \$params = array())\n");
		fwrite($stream, "\t{\n");
		if ($this->_hasTrash) {
			fwrite($stream, "\t\tif (isset(\$params['trash'])) { unset(\$params['trash']); }\n");
		}
		fwrite($stream, "\t\treturn \$this->autoInsert(\$params);\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 通过主键，编辑一条记录\n");
		fwrite($stream, "\t * @param integer \$value\n");
		fwrite($stream, "\t * @param array \$params\n");
		fwrite($stream, "\t * @return array\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function modifyByPk(\$value, array \$params)\n");
		fwrite($stream, "\t{\n");
		if ($this->_hasTrash) {
			fwrite($stream, "\t\tif (isset(\$params['trash'])) { unset(\$params['trash']); }\n");
		}
		fwrite($stream, "\t\treturn \$this->autoUpdateByPk(\$value, \$params);\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see slib.BaseModel::validate()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function validate(array \$attributes = array(), \$required = false, \$opType = '')\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$data = Data::getInstance(\$this->_className, \$this->_moduleName, \$this->getLanguage());\n");
		fwrite($stream, "\t\t\$rules = \$data->getRules(array(\n");
		foreach ($this->_fields as $rows) {
			if ($rows['column_auto_increment']) {
				continue;
			}

			if (isset($rows['validators']) && $rows['validators'] !== array()) {
				fwrite($stream, "\t\t\t'{$rows['field_name']}',\n");
			}
		}
		fwrite($stream, "\t\t));\n\n");
		fwrite($stream, "\t\treturn \$this->filterRun(\$rules, \$attributes, \$required);\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see slib.BaseModel::_cleanPreValidator()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tprotected function _cleanPreValidator(array \$attributes = array(), \$opType = '')\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$rules = array(\n");
		foreach ($this->_fields as $rows) {
			if ($rows['column_auto_increment']) {
				continue;
			}

			if ($rows['field_type'] === 'INT') {
				fwrite($stream, "\t\t\t'{$rows['field_name']}' => 'intval',\n");
			}
			elseif ($rows['form_type'] === 'checkbox') {
				fwrite($stream, "\t\t\t'{$rows['field_name']}' => array(\$this, 'trims'),\n");
			}
			else {
				fwrite($stream, "\t\t\t'{$rows['field_name']}' => 'trim',\n");
			}
		}
		fwrite($stream, "\t\t);\n\n");
		fwrite($stream, "\t\treturn \$this->_clean(\$rules, \$attributes);\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * (non-PHPdoc)\n");
		fwrite($stream, "\t * @see slib.BaseModel::_cleanPostValidator()\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tprotected function _cleanPostValidator(array \$attributes = array(), \$opType = '')\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\t\$rules = array(\n");
		foreach ($this->_fields as $rows) {
			if ($rows['form_type'] === 'checkbox') {
				fwrite($stream, "\t\t\t'{$rows['field_name']}' => array(\$this, 'join'),\n");
			}
		}
		fwrite($stream, "\t\t);\n\n");
		fwrite($stream, "\t\treturn \$this->_clean(\$rules, \$attributes);\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "}\n");
		fclose($stream);
		Log::echoTrace('Generate Services Model End');
	}

	/**
	 * 创建Services层Data类
	 * @return void
	 */
	public function gcSData()
	{
		Log::echoTrace('Generate Services Data Begin ...');
		$modName = $this->_builders['mod_name'];
		$clsName = 'Data' . $this->_builders['uc_cls_name'];

		$filePath = $this->_dirs['smod'] . DS . $clsName . '.php';
		$stream = $this->fopen($filePath);
		$this->writeCopyrightComment($stream);

		fwrite($stream, "namespace smods\\{$modName};\n\n");
		fwrite($stream, "use slib\\BaseData;\n\n");
		$this->writeClassComment($stream, $clsName, '业务层：数据管理类，寄存常量、选项、验证规则', "smods.{$modName}");

		fwrite($stream, "class {$clsName} extends BaseData\n");
		fwrite($stream, "{\n");
		foreach ($this->_fields as $rows) {
			if (isset($rows['enums'])) {
				foreach ($rows['enums'] as $enums) {
					fwrite($stream, "\t/**\n");
					fwrite($stream, "\t * @var string {$rows['html_label']}：{$enums['value']}\n");
					fwrite($stream, "\t */\n");
					fwrite($stream, "\tconst {$enums['const_key']} = '{$enums['value']}';\n\n");
				}
			}
		}

		foreach ($this->_fields as $rows) {
			if (isset($rows['enums'])) {
				fwrite($stream, "\t/**\n");
				fwrite($stream, "\t * 获取“{$rows['html_label']}”所有选项\n");
				fwrite($stream, "\t * @return array\n");
				fwrite($stream, "\t */\n");
				fwrite($stream, "\tpublic function get{$rows['func_name']}Enum()\n");
				fwrite($stream, "\t{\n");
				fwrite($stream, "\t\treturn array(\n");
				foreach ($rows['enums'] as $enums) {
					fwrite($stream, "\t\t\tself::{$enums['const_key']} => \$this->_('{$enums['lang_key']}'),\n");
				}

				fwrite($stream, "\t\t);\n");
				fwrite($stream, "\t}\n\n");
			}
		}

		foreach ($this->_fields as $rows) {
			if (isset($rows['validators']) && $rows['validators'] !== array()) {
				fwrite($stream, "\t/**\n");
				fwrite($stream, "\t * 获取“{$rows['html_label']}”验证规则\n");
				fwrite($stream, "\t * @return array\n");
				fwrite($stream, "\t */\n");
				fwrite($stream, "\tpublic function get{$rows['func_name']}Rule()\n");
				fwrite($stream, "\t{\n");
				if (isset($rows['enums'])) {
					fwrite($stream, "\t\t\$enum = \$this->get{$rows['func_name']}Enum();\n");
				}

				fwrite($stream, "\t\treturn array(\n");
				foreach ($rows['validators'] as $validators) {
					$validatorName = $validators['validator_name'];
					if (isset($rows['enums']) && $validatorName === 'InArray') {
						$options = "array_keys(\$enum)";
						$message = "sprintf(\$this->_('{$validators['lang_key']}'), implode(', ', \$enum))";
						fwrite($stream, "\t\t\t'{$validatorName}' => array(\n\t\t\t\t$options, \n\t\t\t\t{$message}\n\t\t\t),\n");
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
						fwrite($stream, "\t\t\t'{$validatorName}' => array({$options}, \$this->_('{$validators['lang_key']}')),\n");
					}
				}

				fwrite($stream, "\t\t);\n");
				fwrite($stream, "\t}\n\n");
			}
		}
		fwrite($stream, "}\n");

		fclose($stream);
		Log::echoTrace('Generate Services Data End');
	}

	/**
	 * 创建Services层DB类
	 * @return void
	 */
	public function gcSDb()
	{
		Log::echoTrace('Generate Services Db Begin ...');
		$modName = $this->_builders['mod_name'];
		$clsName = 'Db' . $this->_builders['uc_cls_name'];
		$tblName = $this->_builders['tbl_name'];

		$filePath = $this->_dirs['smod'] . DS . $clsName . '.php';
		$stream = $this->fopen($filePath);
		$this->writeCopyrightComment($stream);

		fwrite($stream, "namespace smods\\{$modName};\n\n");
		fwrite($stream, "use slib\\BaseDb;\n\n");
		$this->writeClassComment($stream, $clsName, '业务层：数据库操作类', "smods.{$modName}");

		fwrite($stream, "class {$clsName} extends BaseDb\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 构造方法：初始化表名\n");
		fwrite($stream, "\t * @param integer \$tableNum\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function __construct(\$tableNum = -1)\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\tparent::__construct('{$tblName}', \$tableNum);\n");
		fwrite($stream, "\t}\n\n");
		fwrite($stream, "}\n");

		fclose($stream);
		Log::echoTrace('Generate Services Db End');
	}

	/**
	 * 创建Services层语言包
	 * @return void
	 */
	public function gcSLangs()
	{
		Log::echoTrace('Generate Services Languages Begin ...');

		$modName = $this->_builders['mod_name'];
		$tblName = $this->_builders['tbl_name'];
		$builderName = $this->_builders['builder_name'];

		$fileName = 'zh-CN.mod_' . $modName . '.ini';
		$filePath = $this->_dirs['slang'] . DS . $fileName;

		$stream = $this->fopen($filePath);
		$this->writeLangComment($stream, $fileName, 'services');

		fwrite($stream, "; {$tblName} {$builderName}\n");
		foreach ($this->_fields as $rows) {
			if (isset($rows['enums'])) {
				foreach ($rows['enums'] as $enums) {
					if ($enums['lang_key'] !== 'CFG_SYSTEM_GLOBAL_YES' && $enums['lang_key'] !== 'CFG_SYSTEM_GLOBAL_NO') {
						fwrite($stream, "{$enums['lang_key']}=\"{$enums['value']}\"\n");
					}
				}
			}
		}

		foreach ($this->_fields as $rows) {
			if (isset($rows['validators'])) {
				foreach ($rows['validators'] as $validators) {
					fwrite($stream, "{$validators['lang_key']}=\"{$validators['message']}\"\n");
				}
			}
		}

		fclose($stream);
		Log::echoTrace('Generate Services Languages End');
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

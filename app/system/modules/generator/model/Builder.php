<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\generator\model;

use tfc\util\FileManager;
use library\ErrorNo;
use library\GeneratorFactory;

/**
 * Builder class file
 * 生成代码
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Builder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.model
 * @since 1.0
 */
class Builder
{
	/**
	 * @var instance of tfc\util\FileManager
	 */
	protected $_fileManager = null;

	/**
	 * @var array 生成代码数据
	 */
	protected $_generators = array();

	/**
	 * @var array 表单字段组数据
	 */
	protected $_groups = array();

	/**
	 * @var array 表单字段数据
	 */
	protected $_fields = array();

	/**
	 * @var string Modules目录
	 */
	protected $_modDir = '';

	/**
	 * @var string Views目录
	 */
	protected $_viewDir = '';

	/**
	 * @var string 语言包目录
	 */
	protected $_langDir = '';

	/**
	 * 构造方法：初始化文件管理类、数据、目录
	 * @param integer $generatorId
	 */
	public function __construct($generatorId)
	{
		$this->_fileManager = new FileManager();

		$generators = $this->getGenerators($generatorId);
		$groups = $this->getGroups($generatorId);
		$fields = $this->getFields($generatorId);

		$rootDir = DIR_DATA_RUNTIME . DS . 'builder' . DS . $generators['app_name'];
		$this->mkDir($rootDir);

		$modDir = $this->getModDir($rootDir, $generators['mod_name']);
		$viewDir = $this->getViewDir($rootDir, $generators['mod_name']);
		$langDir = $this->getLangDir($rootDir, $generators['mod_name']);

		$this->_generators = $generators;
		$this->_groups = $groups;
		$this->_fields = $fields;
		$this->_modDir = $modDir;
		$this->_viewDir = $viewDir;
		$this->_langDir = $langDir;
	}

	/**
	 * 生成代码
	 * @param integer $generatorId
	 * @return void
	 */
	public function create()
	{
		$pre = strtoupper('MOD_' . $this->_generators['mod_name'] . '_' . $this->_generators['tbl_name']);

		foreach ($this->_groups as $gk => $groups) {
			$this->_groups[$gk]['lang_key'] = $pre . '_VIEWTAB_' . strtoupper($groups['group_name']) . '_PROMPT';
		}

		foreach ($this->_fields as $fk => $fields) {
			$string = $pre . '_' . strtoupper($fields['field_name']);
			$this->_fields[$fk]['lang_label'] = $string . '_LABEL';
			$this->_fields[$fk]['lang_hint'] = $string . '_HINT';
			foreach ($fields['validators'] as $vk => $validators) {
				$this->_fields[$fk]['validators'][$vk]['lang_key'] = $string . '_' . strtoupper($validators['validator_name']);
			}

			if ($fields['types']['field_type'] === 'ENUM') {
				$enums = array();
				foreach (explode('|', $fields['column_length']) as $value) {
					$key = strtoupper($fields['field_name'] . '_' . $value);
					$enums[$key] = $value;
				}

				$this->_fields[$fk]['enums'] = $enums;
			}
		}

		header('Content-Type: text/html; charset=utf-8');
		echo '<pre>';
		print_r($this->_generators);
		print_r($this->_groups);
		print_r($this->_fields);
		echo '</pre>';

		$this->touchLang();
		$this->touchElement();
		$this->touchDb();
		$this->touchUi();
	}

	/**
	 * 创建Db
	 * @return void
	 */
	public function touchDb()
	{
		$filePath = $this->_modDir . DS . 'db' . DS . $this->_generators['class_name'] . '.php';
		$stream = $this->fopen($filePath);
		$this->writeComment($stream);

		$package = "modules\\{$this->_generators['mod_name']}\\db";
		fwrite($stream, "namespace {$package};\n\n");
		fwrite($stream, "use library\\Db;\n\n");

		fwrite($stream, "/**\n");
		fwrite($stream, " * {$this->_generators['class_name']} class file\n");
		fwrite($stream, " * 数据库操作层类\n");
		fwrite($stream, " * @author 宋欢 <trotri@yeah.net>\n");
		fwrite($stream, " * @version \$Id: {$this->_generators['class_name']}.php 1 " . date('Y-m-d H:i:s') . "Z huan.song \$\n");
		fwrite($stream, " * @package {$package}\n");
		fwrite($stream, " * @since 1.0\n");
		fwrite($stream, " */\n");

		fwrite($stream, "class {$this->_generators['class_name']} extends Db\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * 构造方法：初始化表名\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tpublic function __construct()\n");
		fwrite($stream, "\t{\n");
		fwrite($stream, "\t\tparent::__construct('{$this->_generators['tbl_name']}');\n");
		fwrite($stream, "\t}\n\n");

		fwrite($stream, "}\n");
		fclose($stream);
	}

	/**
	 * 创建Ui
	 * @return void
	 */
	public function touchUi()
	{
		$filePath = $this->_modDir . DS . 'ui' . DS . 'bootstrap' . DS . $this->_generators['class_name'] . '.php';
		$stream = $this->fopen($filePath);
		$this->writeComment($stream);

		$package = "modules\\{$this->_generators['mod_name']}\\ui\\bootstrap";
		fwrite($stream, "namespace {$package};\n\n");
		fwrite($stream, "use ui\\bootstrap\\Components;\n");
		fwrite($stream, "use tfc\\ap\\Ap;\n");
		fwrite($stream, "use tfc\\mvc\\Mvc;\n");
		fwrite($stream, "use tfc\\saf\\Text;\n");
		fwrite($stream, "use library\\Url;\n");
		fwrite($stream, "use library\\{$this->_generators['factory_name']};\n\n");

		fwrite($stream, "/**\n");
		fwrite($stream, " * {$this->_generators['class_name']} class file\n");
		fwrite($stream, " * 页面小组件类，基于Bootstrap-v3前端开发框架\n");
		fwrite($stream, " * @author 宋欢 <trotri@yeah.net>\n");
		fwrite($stream, " * @version \$Id: {$this->_generators['class_name']}.php 1 " . date('Y-m-d H:i:s') . "Z huan.song \$\n");
		fwrite($stream, " * @package {$package}\n");
		fwrite($stream, " * @since 1.0\n");
		fwrite($stream, " */\n");
		fwrite($stream, "class {$this->_generators['class_name']}\n");
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

		$indexRowBtns = array();

		$createName = $this->_generators['act_create_name'];
		$modifyName = $this->_generators['act_modify_name'];
		$removeName = $this->_generators['act_remove_name'];
		$trashName = 'trash';

		foreach ($this->_generators['index_row_btns'] as $value) {
			if ($value === 'pencil') {
				$modifyUrl = '$modifyUrl = Url::getUrl(\'' . $modifyName . '\', Mvc::$controller, Mvc::$module, $params);';
				$modifyIcon = '$modifyIcon = Components::getGlyphicon(Components::GLYPHICON_PENCIL, $modifyUrl, Components::JSFUNC_HREF, Text::_(\'CFG_SYSTEM_GLOBAL_MODIFY\'));';
				fwrite($stream, "\t\t$modifyUrl\n");
				fwrite($stream, "\t\t$modifyIcon\n\n");

				$indexRowBtns[] = '$modifyIcon';
			}
			elseif ($value === 'trash') {
				$trashUrl = '$trashUrl = Url::getUrl(\'' . $trashName . '\', Mvc::$controller, Mvc::$module, $params);';
				$trashIcon = '$trashIcon = Components::getGlyphicon(Components::GLYPHICON_TRASH, $trashUrl, Components::JSFUNC_DIALOGTRASH, Text::_(\'CFG_SYSTEM_GLOBAL_TRASH\'));';
				fwrite($stream, "\t\t$trashUrl\n");
				fwrite($stream, "\t\t$trashIcon\n\n");

				$indexRowBtns[] = '$trashIcon';
			}
			elseif ($value === 'remove') {
				$removeUrl = '$removeUrl = Url::getUrl(\'' . $removeName . '\', Mvc::$controller, Mvc::$module, $params);';
				$removeIcon = '$removeIcon = Components::getGlyphicon(Components::GLYPHICON_REMOVE_SIGN, $removeUrl, Components::JSFUNC_DIALOGREMOVE, Text::_(\'CFG_SYSTEM_GLOBAL_REMOVE\'));';
				fwrite($stream, "\t\t$removeUrl\n");
				fwrite($stream, "\t\t$removeIcon\n\n");

				$indexRowBtns[] = '$removeIcon';
			}
		}

		if ($indexRowBtns !== array()) {
			fwrite($stream, "\t\t\$ret = " . implode(' . ', $indexRowBtns) . ";\n");
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
	 * 创建Element
	 * @return void
	 */
	public function touchElement()
	{
		$filePath = $this->_modDir . DS . 'elements' . DS . $this->_generators['class_name'] . '.php';
		$stream = $this->fopen($filePath);
		$this->writeComment($stream);

		$package = "modules\\{$this->_generators['mod_name']}\\elements";
		fwrite($stream, "namespace {$package};\n\n");
		fwrite($stream, "use tfc\\saf\\Text;\n");
		fwrite($stream, "use ui\\ElementCollections;\n");
		fwrite($stream, "use library\\{$this->_generators['factory_name']};\n\n");

		fwrite($stream, "/**\n");
		fwrite($stream, " * {$this->_generators['class_name']} class file\n");
		fwrite($stream, " * 字段信息配置类，包括表格、表单、验证规则、选项\n");
		fwrite($stream, " * @author 宋欢 <trotri@yeah.net>\n");
		fwrite($stream, " * @version \$Id: {$this->_generators['class_name']}.php 1 " . date('Y-m-d H:i:s') . "Z huan.song \$\n");
		fwrite($stream, " * @package {$package}\n");
		fwrite($stream, " * @since 1.0\n");
		fwrite($stream, " */\n");

		fwrite($stream, "class {$this->_generators['class_name']} extends ElementCollections\n");
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
		fwrite($stream, "\t\t\$this->uiComponents = {$this->_generators['factory_name']}::getUi('{$this->_generators['class_name']}');\n");
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
			fwrite($stream, "\tpublic function get" . $this->column2Name($fields['field_name']) . "(\$type)\n");
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
						$options = $options ? 'true' : 'false';
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
	 * 将字段转换为函数名
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
	 * 创建语言包
	 * @return void
	 */
	public function touchLang()
	{
		$filePath = $this->_langDir . DS . 'zh-CN.mod_' . $this->_generators['mod_name'] . '.ini';
		$stream = $this->fopen($filePath);

		fwrite($stream, "; \$Id: zh-CN.mod_{$this->_generators['mod_name']}.ini 1 2013-05-18 14:58:59Z Create By Code Builder \$\n");
		fwrite($stream, ";\n");
		fwrite($stream, "; @package     {$this->_generators['app_name']}\n");
		fwrite($stream, "; @description [Description] [Name of language]([Country code])\n");
		fwrite($stream, "; @version     1.0\n");
		fwrite($stream, "; @date        " . date('Y-m-d') . "\n");
		fwrite($stream, "; @author      宋欢 <trotri@yeah.net>\n");
		fwrite($stream, "; @copyright   Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.\n");
		fwrite($stream, "; @license     http://www.apache.org/licenses/LICENSE-2.0\n");
		fwrite($stream, "; @note        Client Site\n");
		fwrite($stream, "; @note        All ini files need to be saved as UTF-8 - No BOM\n\n");

		fwrite($stream, "; {$this->_generators['tbl_name']} {$this->_generators['generator_name']}\n");
		foreach ($this->_groups as $groups) {
			if ($groups['group_name'] != 'main') {
				fwrite($stream, "{$groups['lang_key']}=\"{$groups['prompt']}\"\n");
			}
		}

		foreach ($this->_fields as $fields) {
			fwrite($stream, "{$fields['lang_label']}=\"{$fields['html_label']}\"\n");
			fwrite($stream, "{$fields['lang_hint']}=\"{$fields['form_prompt']}\"\n");
			foreach ($fields['validators'] as $validators) {
				fwrite($stream, "{$validators['lang_key']}=\"{$validators['message']}\"\n");
			}
		}

		fclose($stream);
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
	 * 获取并初始化语言包相关的目录
	 * @param string $rootDir
	 * @param string $modName
	 * @return string
	 */
	public function getLangDir($rootDir, $modName)
	{
		$langDir = $rootDir . DS . 'languages';
		$this->mkDir($langDir);

		$enDir = $langDir . DS . 'en-GB';
		$this->mkDir($enDir);

		$zhDir = $langDir . DS . 'zh-CN';
		$this->mkDir($zhDir);

		return $zhDir;
	}

	/**
	 * 获取并初始化Modules相关的目录
	 * @param string $rootDir
	 * @param string $modName
	 * @return string
	 */
	public function getModDir($rootDir, $modName)
	{
		$modDir = $rootDir . DS . 'modules';
		$this->mkDir($modDir);

		$modDir .= DS . $modName;
		$this->mkDir($modDir);

		$ctrlDir = $modDir . DS . 'controller';
		$this->mkDir($ctrlDir);

		$dbDir = $modDir . DS . 'db';
		$this->mkDir($dbDir);

		$eleDir = $modDir . DS . 'elements';
		$this->mkDir($eleDir);

		$modelDir = $modDir . DS . 'model';
		$this->mkDir($modelDir);

		$uiDir = $modDir . DS . 'ui';
		$this->mkDir($uiDir);

		$uiDir .= DS . 'bootstrap';
		$this->mkDir($uiDir);
		
		return $modDir;
	}

	/**
	 * 获取并初始化View相关的目录
	 * @param string $rootDir
	 * @param string $modName
	 * @return string
	 */
	public function getViewDir($rootDir, $modName)
	{
		$viewDir = $rootDir . DS . 'views';
		$this->mkDir($viewDir);

		$viewDir .= DS . 'bootstrap';
		$this->mkDir($viewDir);

		$viewDir .= DS . $modName;
		$this->mkDir($viewDir);

		return $viewDir;
	}

	/**
     * 新建目录，如果目录存在，则改变文件权限
     * @param string $directory
     * @param integer $mode 文件权限，8进制
     * @return void
     */
	public function mkDir($directory, $mode = 0664)
	{
		if (!$this->_fileManager->mkDir($directory, $mode, true)) {
			$this->errExit(__LINE__, 'mkdir "' . $directory . '" failed');
		}

		$dest = $directory . DS . 'index.html';
		if (!$this->_fileManager->isFile($dest)) {
			$source = DIR_DATA_RUNTIME . DS . 'index.html';
			$this->_fileManager->copy($source, $dest);
		}
	}

	/**
	 * 获取表单字段数据
	 * @param integer $generatorId
	 * @return array
	 */
	public function getFields($generatorId)
	{
		$ret = GeneratorFactory::getModel('Fields')->findAllByAttributes(array('generator_id' => $generatorId), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->errExit(__LINE__, $ret['err_msg']);
		}
		$fields = $ret['data'];

		foreach ($fields as $key => $row) {
			$ret = GeneratorFactory::getModel('Validators')->findAllByAttributes(array('field_id' => $row['field_id']), 'sort');
			if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
				$this->errExit(__LINE__, $ret['err_msg']);
			}
			$fields[$key]['validators'] = $ret['data'];

			$ret = GeneratorFactory::getModel('Types')->findByPk($row['type_id']);
			if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
				$this->errExit(__LINE__, $ret['err_msg']);
			}
			$fields[$key]['types'] = $ret['data'];

			$ret = GeneratorFactory::getModel('Groups')->findByPk($row['group_id']);
			if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
				$this->errExit(__LINE__, $ret['err_msg']);
			}
			$fields[$key]['groups'] = $ret['data'];
		}

		return $fields;
	}

	/**
	 * 获取表单字段组数据
	 * @param integer $generatorId
	 * @return array
	 */
	public function getGroups($generatorId)
	{
		$ret = GeneratorFactory::getModel('Groups')->findAllByAttributes(array('generator_id' => 0), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->errExit(__LINE__, $ret['err_msg']);
		}
		$default = $ret['data'];

		$ret = GeneratorFactory::getModel('Groups')->findAllByAttributes(array('generator_id' => $generatorId), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->errExit(__LINE__, $ret['err_msg']);
		}
		$groups = $ret['data'];

		$ret = array_merge($default, $groups);
		return $ret;
	}

	/**
	 * 获取生成代码数据
	 * @param integer $generatorId
	 * @return array
	 */
	public function getGenerators($generatorId)
	{
		$generatorId = (int) $generatorId;
		$ret = GeneratorFactory::getModel('Generators')->findByPk($generatorId);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->errExit(__LINE__, $ret['err_msg']);
		}

		$ret = $ret['data'];
		$ret['tbl_name'] = strtolower($ret['tbl_name']);
		$ret['app_name'] = strtolower($ret['app_name']);
		$ret['mod_name'] = strtolower($ret['mod_name']);
		$ret['ctrl_name'] = strtolower($ret['ctrl_name']);
		$ret['class_name'] = ucfirst($ret['ctrl_name']);
		$ret['factory_name'] = ucfirst($ret['mod_name']) . 'Factory';

		return $ret;
	}

	/**
	 * 打印错误并退出
	 * @param string $errMsg
	 * @return void
	 */
	public function errExit($line, $errMsg)
	{
		echo '<font color="red">', $line, ' : ', $errMsg, '</font>';
		exit;
	}
}

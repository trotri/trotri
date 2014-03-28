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

use tfc\mvc\Mvc;
use tfc\saf\Log;
use tfc\util\FileManager;
use library\Model;
use library\ErrorNo;

/**
 * CodeGenerator class file
 * 通过Builders数据生成代码
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: CodeGenerator.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.model
 * @since 1.0
 */
class CodeGenerator extends Model
{
	/**
	 * @var instance of tfc\util\FileManager
	 */
	protected $_fileManager = null;

	/**
	 * @var array 寄存生成代码数据
	 */
	protected $_builders = array();

	/**
	 * @var array 寄存表单字段类型
	 */
	protected $_types = array();

	/**
	 * @var array 寄存表单字段组数据
	 */
	protected $_groups = array();

	/**
	 * @var array 寄存表单字段数据
	 */
	protected $_fields = array();

	/**
	 * @var array 寄存所有的目录
	 */
	protected $_dirs = array();

	/**
	 * 构造方法：初始化MySQL表结构分析类
	 */
	public function __construct($builderId)
	{
		if (($builderId = (int) $builderId) <= 0) {
			Log::errExit(__LINE__, 'builder_id must be a integer.');
		}

		// 初始化工作开始
		Log::echoTrace('Initialization Begin ...');

		// 初始化生成代码数据
		Log::echoTrace('Query from tr_builders Begin ...');
		$ret = Model::getInstance('Builders')->findByPk($builderId);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			Log::errExit(__LINE__, 'Query from tr_builders Failed!');
		}
		$this->_builders = $this->formatBuilders($ret['data']);
		Log::echoTrace('Query from tr_builders Successfully ...');

		// 初始化表单字段类型
		Log::echoTrace('Query from tr_builder_types Begin ...');
		$ret = Model::getInstance('Types')->search(
			array(),
			'sort',
			0,
			1000
		);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			Log::errExit(__LINE__, 'Query from tr_builder_types Failed!');
		}
		$this->_types = $this->formatTypes($ret['data']);
		Log::echoTrace('Query from tr_builder_types Successfully ...');

		// 表单字段组数据
		Log::echoTrace('Query from tr_builder_field_groups Begin ...');
		$ret = Model::getInstance('Groups')->search(
			array('builder_id' => 0),
			'sort',
			0,
			1000
		);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			Log::errExit(__LINE__, 'Query from tr_builder_field_groups Failed!');
		}
		$default = $ret['data'];

		$ret = Model::getInstance('Groups')->search(
			array('builder_id' => $this->_builders['builder_id']),
			'sort',
			0,
			1000
		);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			Log::errExit(__LINE__, 'Query from tr_builder_field_groups Failed!');
		}
		$groups = array_merge($default, $ret['data']);
		$this->_groups = $this->formatGroups($groups);
		Log::echoTrace('Query from tr_builder_field_groups Successfully ...');

		// 初始化表单字段数据
		Log::echoTrace('Query from tr_builder_fields Begin ...');
		$ret = Model::getInstance('Fields')->search(
			array('builder_id' => $this->_builders['builder_id']),
			'sort',
			0,
			1000
		);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			Log::errExit(__LINE__, 'Query from tr_builder_fields Failed!');
		}

		foreach ($ret['data'] as $rows) {
			$this->_fields[] = $this->formatFields($rows);
		}
		Log::echoTrace('Query from tr_builder_fields Successfully ...');

		// 初始化表单字段验证
		Log::echoTrace('Query from tr_builder_field_validators Begin ...');
		$mod = Model::getInstance('Validators');
		foreach ($this->_fields as &$rows) {
			$ret = $mod->search(
				array('field_id' => $rows['field_id']),
				'sort',
				0,
				1000
			);
			if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
				Log::errExit(__LINE__, 'Query from tr_builder_field_validators Failed!');
			}

			$rows['validators'] = $this->formatValidators($ret['data'], $rows['field_name']);
		}
		Log::echoTrace('Query from tr_builder_field_validators Successfully ...');

		// 初始化目录地址
		Log::echoTrace('Create Directories Begin ...');
		$this->_fileManager = new FileManager();
		$this->initDirs();
		Log::echoTrace('Create Directories Successfully ...');

		// 初始化工作结束
		Log::echoTrace('Initialization End');
	}

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
		Log::echoTrace('Generate End, Table Name "' . $this->_builders['tbl_name'] . '"');
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
		$tblName = $this->_builders['tbl_name'];

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

		\tfc\saf\debug_dump($this->_fields);
		
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
	 * 写类注释
	 * @param resource $stream
	 * @return void
	 */
	public function writeClassComment($stream, $clsName, $description, $package)
	{
		fwrite($stream, "/**\n");
		fwrite($stream, " * {$clsName} class file\n");
		fwrite($stream, " * {$description}\n");
		fwrite($stream, " * @author {$this->_builders['author_name']} <{$this->_builders['author_mail']}>\n");
		fwrite($stream, " * @version \$Id: {$clsName}.php 1 " . date('Y-m-d H:i:s') . "Z Code Generator \$\n");
		fwrite($stream, " * @package {$package}\n");
		fwrite($stream, " * @since 1.0\n");
		fwrite($stream, " */\n");
	}

	/**
	 * 写语言包注释
	 * @param resource $stream
	 * @return void
	 */
	public function writeLangComment($stream, $fileName, $package)
	{
		fwrite($stream, "; \$Id: {$fileName} 1 " . date('Y-m-d H:i:s') . "Z Create By Code Generator \$\n");
		fwrite($stream, ";\n");
		fwrite($stream, "; @package     {$package}\n");
		fwrite($stream, "; @description [Description] [Name of language]([Country code])\n");
		fwrite($stream, "; @version     1.0\n");
		fwrite($stream, "; @date        " . date('Y-m-d') . "\n");
		fwrite($stream, "; @author      {$this->_builders['author_name']} <{$this->_builders['author_mail']}>\n");
		fwrite($stream, "; @copyright   Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.\n");
		fwrite($stream, "; @license     http://www.apache.org/licenses/LICENSE-2.0\n");
		fwrite($stream, "; @note        Client Site\n");
		fwrite($stream, "; @note        All ini files need to be saved as UTF-8 - No BOM\n\n");
	}

	/**
	 * 写版权注释
	 * @param resource $stream
	 * @return void
	 */
	public function writeCopyrightComment($stream)
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
	 * 初始化目录
	 * @return void
	 */
	public function initDirs()
	{
		$appName = $this->_builders['app_name'];
		$modName = $this->_builders['mod_name'];

		$appDir = DIR_DATA_RUNTIME . DS . 'code_generator' . DS . $appName;
		$this->mkDir($appDir);

		$servicesDir = DIR_DATA_RUNTIME . DS . 'code_generator' . DS . 'services';
		$this->mkDir($servicesDir);

		$slangsDir    = $servicesDir . DS . 'slangs';     $this->mkDir($slangsDir);
		$slangEnDir   = $slangsDir   . DS . 'en-GB';      $this->mkDir($slangEnDir);
		$slangZhDir   = $slangsDir   . DS . 'zh-CN';      $this->mkDir($slangZhDir);
		$smodsDir     = $servicesDir . DS . 'smods';      $this->mkDir($smodsDir);
		$smodDir      = $smodsDir    . DS . $modName;     $this->mkDir($smodDir);
		$langsDir     = $appDir      . DS . 'languages';  $this->mkDir($langsDir);
		$langEnDir    = $langsDir    . DS . 'en-GB';      $this->mkDir($langEnDir);
		$langZhDir    = $langsDir    . DS . 'zh-CN';      $this->mkDir($langZhDir);
		$viewsDir     = $appDir      . DS . 'views';      $this->mkDir($viewsDir);
		$viewDir      = $viewsDir    . DS . Mvc::getView()->skinName; $this->mkDir($viewDir);
		$viewDir     .=                DS . $modName;     $this->mkDir($viewDir);
		$modsDir      = $appDir      . DS . 'modules';    $this->mkDir($modsDir);
		$modDir       = $modsDir     . DS . $modName;     $this->mkDir($modDir);
		$actDir       = $modDir      . DS . 'action';     $this->mkDir($actDir);
		$actDataDir   = $actDir      . DS . 'data';       $this->mkDir($actDataDir);
		$actShowDir   = $actDir      . DS . 'show';       $this->mkDir($actShowDir);
		$actSubmitDir = $actDir      . DS . 'submit';     $this->mkDir($actSubmitDir);
		$ctrlDir      = $modDir      . DS . 'controller'; $this->mkDir($ctrlDir);
		$modelDir     = $modDir      . DS . 'model';      $this->mkDir($modelDir);

		$this->_dirs = array(
			'slang' => $slangZhDir,
			'smod' => $smodDir,
			'lang' => $langZhDir,
			'act' => array(
				'data' => $actDataDir,
				'show' => $actShowDir,
				'submit' => $actSubmitDir
			),
			'ctrl' => $ctrlDir,
			'mod' => $modelDir
		);
	}

	/**
	 * 格式化生成代码数据
	 * @param array $data
	 * @return array
	 */
	public function formatBuilders(array $data)
	{
		$ret = array();

		$ret['builder_id'] = (int) $data['builder_id'];
		$ret['builder_name'] = trim($data['builder_name']);
		$ret['tbl_name'] = strtolower(trim($data['tbl_name']));
		$ret['tbl_profile'] = $data['tbl_profile'];
		$ret['tbl_engine'] = $data['tbl_engine'];
		$ret['tbl_charset'] = $data['tbl_charset'];
		$ret['tbl_comment'] = $data['tbl_comment'];
		$ret['app_name'] = strtolower(trim($data['app_name']));
		$ret['mod_name'] = strtolower(trim($data['mod_name']));
		$ret['ctrl_name'] = strtolower(trim($data['ctrl_name']));
		$ret['cls_name'] = strtolower(trim($data['cls_name']));
		$ret['act_index_name'] = strtolower(trim($data['act_index_name']));
		$ret['act_view_name'] = strtolower(trim($data['act_view_name']));
		$ret['act_create_name'] = strtolower(trim($data['act_create_name']));
		$ret['act_modify_name'] = strtolower(trim($data['act_modify_name']));
		$ret['act_remove_name'] = strtolower(trim($data['act_remove_name']));
		$ret['index_row_btns'] = $data['index_row_btns'];
		$ret['description'] = $data['description'];
		$ret['author_name'] = trim($data['author_name']);
		$ret['author_mail'] = trim($data['author_mail']);

		$ret['uc_ctrl_name'] = ucfirst($ret['ctrl_name']);
		$ret['uc_cls_name'] = ucfirst($ret['cls_name']);
		$ret['lang_prev'] = strtoupper('MOD_' . $ret['mod_name'] . '_' . $ret['tbl_name']);

		return $ret;
	}

	/**
	 * 格式化表单字段类型
	 * @param array $data
	 * @return array
	 */
	public function formatTypes(array $data)
	{
		$ret = array();

		foreach ($data as $rows) {
			$typeId = (int) $rows['type_id'];
			$ret[$typeId] = array(
				'type_id' => $typeId,
				'type_name' => trim($rows['type_name']),
				'form_type' => strtolower(trim($rows['form_type'])),
				'field_type' => strtoupper(trim($rows['field_type'])),
				'category' => strtolower(trim($rows['category'])),
			);
		}

		return $ret;
	}

	/**
	 * 格式化表单字段组
	 * @param array $data
	 * @return array
	 */
	public function formatGroups(array $data)
	{
		$ret = array();

		foreach ($data as $rows) {
			$groupId = (int) $rows['group_id'];
			$groupName = trim($rows['group_name']);
			$ret[$groupId] = array(
				'group_id' => $groupId,
				'group_name' => $groupName,
				'prompt' => trim($rows['prompt']),
				'is_default' => ((int) $rows['builder_id'] > 0) ? false : true,
				'lang_key' => $this->_builders['lang_prev'] . '_VIEWTAB_' . strtoupper($groupName) . '_PROMPT'
			);
		}

		return $ret;
	}

	/**
	 * 格式化表单字段
	 * @param array $data
	 * @return array
	 */
	public function formatFields(array $data)
	{
		$ret = array();

		$groupId = (int) $data['group_id'];
		$typeId = (int) $data['type_id'];
		$ret['field_id'] = (int) $data['field_id'];
		$ret['field_name'] = strtolower(trim($data['field_name']));
		$ret['column_length'] = trim($data['column_length']);
		$ret['column_auto_increment'] = ($data['column_auto_increment'] === 'y' ? true : false);
		$ret['column_unsigned'] = ($data['column_unsigned'] === 'y' ? true : false);
		$ret['column_comment'] = trim($data['column_comment']);
		$ret['builder_id'] = (int) $data['builder_id'];
		$ret['group_id'] = $groupId;
		$ret['type_id'] = $typeId;
		$ret['sort'] = (int) $data['sort'];
		$ret['html_label'] = trim($data['html_label']);
		$ret['form_prompt'] = trim($data['form_prompt']);
		$ret['form_required'] = ($data['form_required'] === 'y' ? true : false);
		$ret['form_modifiable'] = ($data['form_modifiable'] === 'y' ? true : false);
		$ret['index_show'] = ($data['index_show'] === 'y' ? true : false);
		$ret['index_sort'] = (int) $data['index_sort'];
		$ret['form_create_show'] = ($data['form_create_show'] === 'y' ? true : false);
		$ret['form_create_sort'] = (int) $data['form_create_sort'];
		$ret['form_modify_show'] = ($data['form_modify_show'] === 'y' ? true : false);
		$ret['form_modify_sort'] = (int) $data['form_modify_sort'];
		$ret['form_search_show'] = ($data['form_search_show'] === 'y' ? true : false);
		$ret['form_search_sort'] = (int) $data['form_search_sort'];
		$ret['func_name'] = $this->column2Name($ret['field_name']);
		$ret['up_field_name'] = strtoupper($ret['field_name']);

		$langPrev = $this->_builders['lang_prev'] . '_' . $ret['up_field_name'];
		$ret['lang_label'] = $langPrev . '_LABEL';
		$ret['lang_hint'] = $langPrev . '_HINT';

		if (!isset($this->_groups[$groupId])) {
			Log::errExit(__LINE__, 'Fields group_id "' . $groupId . '" Not Exists!');
		}
		$ret['__tid__'] = $this->_groups[$groupId]['group_name'];

		if (!isset($this->_types[$typeId])) {
			Log::errExit(__LINE__, 'Fields type_id "' . $typeId . '" Not Exists!');
		}
		$ret['form_type'] = $this->_types[$typeId]['form_type'];
		$ret['type_category'] = $this->_types[$typeId]['category'];

		$fieldType = $this->_types[$typeId]['field_type'];
		if ($fieldType === 'ENUM') {
			$enums = array();
			foreach (explode('|', $ret['column_length']) as $value) {
				$constKey = $ret['up_field_name'] . '_' . strtoupper($value);
				switch ($value) {
					case 'y' :
						$langKey = 'CFG_SYSTEM_GLOBAL_YES';
						break;
					case 'n' :
						$langKey = 'CFG_SYSTEM_GLOBAL_NO';
						break;
					default :
						$langKey = $this->_builders['lang_prev'] . '_ENUM_' . $constKey;
				}

				$enums[] = array(
					'const_key' => $constKey,
					'lang_key' => $langKey,
					'value' => $value
				);
			}

			$ret['enums'] = $enums;
		}

		return $ret;
	}

	/**
	 * 格式化表单字段验证
	 * @param array $data
	 * @return array
	 */
	public function formatValidators(array $data, $fieldName)
	{
		$ret = array();

		$fieldName = strtoupper($fieldName);
		foreach ($data as $rows) {
			$validatorId = (int) $rows['validator_id'];
			$validatorName = trim($rows['validator_name']);
			$ret[$validatorId] = array(
				'validator_id' => $validatorId,
				'validator_name' => $validatorName,
				'options' => $rows['options'],
				'option_category' => strtolower(trim($rows['option_category'])),
				'message' => trim($rows['message']),
				'when' => strtolower(trim($rows['when'])),
				'lang_key' => $this->_builders['lang_prev'] . '_' . $fieldName . '_' . strtoupper($validatorName)
			);
		}

		return $ret;
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
	 * 新建目录，如果目录存在，则改变目录权限
	 * @param string $directory
	 * @param integer $mode 文件权限，8进制
	 * @return void
	 */
	public function mkDir($directory, $mode = 0664)
	{
		if (!$this->_fileManager->mkDir($directory, $mode, true)) {
			Log::errExit(__LINE__, sprintf(
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
	 * 打开文件
	 * @param string $filePath
	 * @return resource
	 */
	public function fopen($filePath)
	{
		if (!($stream = @fopen($filePath, 'w', false))) {
			Log::errExit(__LINE__, sprintf(
				'File "%s" cannot be opened with mode "w"', $filePath
			));
		}

		return $stream;
	}
}

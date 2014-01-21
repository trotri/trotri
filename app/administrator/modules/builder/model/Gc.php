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
	}

	/**
	 * 创建语言包
	 * @return void
	 */
	public function buildLang()
	{
		$fileName = 'zh-CN.mod_' . $this->_builders['mod_name'] . '.ini';
		$filePath = $this->_dirs['lang'] . DS . $fileName;
		$stream = $this->fopen($filePath);

		fwrite($stream, "; \$Id: {$fileName} 1 2013-05-18 14:58:59Z Create By Code Builder \$\n");
		fwrite($stream, ";\n");
		fwrite($stream, "; @package     {$this->_builders['app_name']}\n");
		fwrite($stream, "; @description [Description] [Name of language]([Country code])\n");
		fwrite($stream, "; @version     1.0\n");
		fwrite($stream, "; @date        " . date('Y-m-d') . "\n");
		fwrite($stream, "; @author      宋欢 <trotri@yeah.net>\n");
		fwrite($stream, "; @copyright   Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.\n");
		fwrite($stream, "; @license     http://www.apache.org/licenses/LICENSE-2.0\n");
		fwrite($stream, "; @note        Client Site\n");
		fwrite($stream, "; @note        All ini files need to be saved as UTF-8 - No BOM\n\n");

		fwrite($stream, "; {$this->_builders['tbl_name']} {$this->_builders['builder_name']}\n");
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
		$appDir = DIR_DATA_RUNTIME . DS . 'builder' . DS . $this->_builders['app_name'];
		$this->mkDir($appDir);

		// 语言包存放目录
		$langDir = $appDir  . DS . 'languages'; $this->mkDir($langDir);
		$enDir   = $langDir . DS . 'en-GB';     $this->mkDir($enDir);
		$zhDir   = $langDir . DS . 'zh-CN';     $this->mkDir($zhDir);
		$this->_dirs['lang'] = $zhDir;

		// 模板存放目录
		$viewDir  = $appDir . DS . 'views';            $this->mkDir($viewDir);
		$viewDir .= DS . 'bootstrap';                  $this->mkDir($viewDir);
		$viewDir .= DS . $this->_builders['mod_name']; $this->mkDir($viewDir);
		$this->_dirs['view'] = $viewDir;

		// 项目存放目录
		$modsDir  = $appDir . DS . 'modules';          $this->mkDir($modsDir);
		$modsDir .= DS . $this->_builders['mod_name']; $this->mkDir($modsDir);
		$ctrlDir  = $modsDir . DS . 'controller';      $this->mkDir($ctrlDir);
		$dbDir    = $modsDir . DS . 'db';              $this->mkDir($dbDir);
		$eleDir   = $modsDir . DS . 'elements';        $this->mkDir($eleDir);
		$modDir   = $modsDir . DS . 'model';           $this->mkDir($modDir);
		$uiDir    = $modsDir . DS . 'ui';              $this->mkDir($uiDir);
		$uiDir   .= DS . 'bootstrap';                  $this->mkDir($uiDir);

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

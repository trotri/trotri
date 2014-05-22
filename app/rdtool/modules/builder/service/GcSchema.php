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
use libsrv\SModFactory;

/**
 * GcSchema class file
 * 通过Builders数据生成代码
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: GcSchema.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.service
 * @since 1.0
 */
class GcSchema
{
	const SRV_NAME = 'builder';

	public
		$builderId     = 0,
		$builderName   = '',
		$tblName       = '',
		$tblProfile    = '',
		$tblEngine     = '',
		$tblCharset    = '',
		$tblComment    = '',
		$srvType       = '',
		$srvName       = '',
		$appName       = '',
		$modName       = '',
		$clsName       = '',
		$ctrlName      = '',
		$fkColumn      = '',
		$actIndexName  = '',
		$actViewName   = '',
		$actCreateName = '',
		$actModifyName = '',
		$actRemoveName = '',
		$indexRowBtns  = array(),
		$description   = '',
		$authorName    = '',
		$authorMail    = '';

	public
		$ucCtrlName        = '',
		$ucClsName         = '',
		$actSingleModify   = 'singlemodify',
		$actTrashindexName = '',
		$actTrashName      = '',
		$hasTrash          = false,
		$hasSort           = false;

	public
		$types  = array(),  // 表单字段类型
		$groups = array(),  // 表单字段组数据
		$fields = array();  // 表单字段数据

	/**
	 * 构造方法：初始化所有的全局变量
	 * @param integer $builderId
	 */
	public function __construct($builderId)
	{
		if (($this->builderId = (int) $builderId) <= 0) {
			Log::errExit(__LINE__, 'builder_id must be a integer.');
		}

		// 初始化工作开始
		Log::echoTrace('Initialization Begin ...');
		$this->_initBuilders()->_initTypes()->_initGroups()->_initFields()->_initValidators()->_initDirs();
	
		$this->_builders['act_single_modify'] = 'singlemodify';
		$this->_builders['act_trashindex_name'] = $this->_hasTrash ? 'trash' . $this->_builders['act_index_name'] : '';
		$this->_builders['act_trash_name'] = $this->_hasTrash ? 'trash' : '';
	
		// 初始化工作结束
		Log::echoTrace('Initialization End');
	}

	/**
	 * 初始化生成代码数据
	 * @return instance of modules\builder\service\GcSchema
	 */
	protected function _initBuilders()
	{
		$object = SModFactory::getInstance('Builders', self::SRV_NAME);
		$tableName = $object->getTableName();

		Log::echoTrace('Query from ' . $tableName . ' Begin ...');

		$data = $object->findByPk($this->builderId);
		if (!$data) {
			Log::errExit(__LINE__, 'Query from ' . $tableName . ' Failed!');
		}

		$this->builderId     = (int) $data['builder_id'];
		$this->builderName   = trim($data['builder_name']);
		$this->tblName       = strtolower(trim($data['tbl_name']));
		$this->tblProfile    = trim($data['tbl_profile']);
		$this->tblEngine     = trim($data['tbl_engine']);
		$this->tblCharset    = trim($data['tbl_charset']);
		$this->tblComment    = trim($data['tbl_comment']);
		$this->srvType       = strtolower(trim($data['srv_type']));
		$this->srvName       = strtolower(trim($data['srv_name']));
		$this->appName       = strtolower(trim($data['app_name']));
		$this->modName       = strtolower(trim($data['mod_name']));
		$this->clsName       = strtolower(trim($data['cls_name']));
		$this->ctrlName      = strtolower(trim($data['ctrl_name']));
		$this->fkColumn      = strtolower(trim($data['fk_column']));
		$this->actIndexName  = strtolower(trim($data['act_index_name']));
		$this->actViewName   = strtolower(trim($data['act_view_name']));
		$this->actCreateName = strtolower(trim($data['act_create_name']));
		$this->actModifyName = strtolower(trim($data['act_modify_name']));
		$this->actRemoveName = strtolower(trim($data['act_remove_name']));
		$this->indexRowBtns  = (array) $data['index_row_btns'];
		$this->description   = $data['description'];
		$this->authorName    = trim($data['author_name']);
		$this->authorMail    = trim($data['author_mail']);
		$this->ucClsName     = ucfirst($this->clsName);
		$this->ucCtrlName    = ucfirst($this->ctrlName);

		Log::echoTrace('Query from ' . $tableName . ' Successfully');
		return $this;
	}

	/**
	 * 初始化表单字段类型
	 * @return instance of modules\builder\service\GcSchema
	 */
	protected function _initTypes()
	{
		$object = SModFactory::getInstance('Types', self::SRV_NAME);
		$tableName = $object->getTableName();

		Log::echoTrace('Query from ' . $tableName . ' Begin ...');

		$data = $object->findAllByAttributes(array(), 'sort', 0, 1000);
		if (!$data) {
			Log::errExit(__LINE__, 'Query from ' . $tableName . ' Failed!');
		}

		foreach ($data as $rows) {
			$typeId = (int) $rows['type_id'];
			$this->types[$typeId] = array(
				'type_id'    => $typeId,
				'type_name'  => trim($rows['type_name']),
				'form_type'  => strtolower(trim($rows['form_type'])),
				'field_type' => strtoupper(trim($rows['field_type'])),
				'category'   => strtolower(trim($rows['category'])),
			);
		}

		Log::echoTrace('Query from ' . $tableName . ' Successfully');
		return $this;
	}

	/**
	 * 初始化表单字段组数据
	 * @return instance of modules\builder\service\GcSchema
	 */
	protected function _initGroups()
	{
		$object = SModFactory::getInstance('Groups', self::SRV_NAME);
		$tableName = $object->getTableName();

		Log::echoTrace('Query from ' . $tableName . ' Begin ...');

		$defaults = $object->findAllByAttributes(array('builder_id' => 0), 'sort', 0, 1000);
		$data = $object->findAllByAttributes(array('builder_id' => $this->builderId), 'sort', 0, 1000);
		if ($defaults === false || $data === false) {
			Log::errExit(__LINE__, 'Query from ' . $tableName . ' Failed!');
		}

		$data = array_merge($defaults, $data);
		foreach ($data as $rows) {
			$groupId = (int) $rows['group_id'];
			$this->groups[$groupId] = array(
				'group_id'   => $groupId,
				'group_name' => trim($rows['group_name']),
				'prompt'     => trim($rows['prompt']),
				'is_default' => ((int) $rows['builder_id'] > 0) ? false : true
			);
		}

		Log::echoTrace('Query from ' . $tableName . ' Successfully');
		return $this;
	}

	/**
	 * 初始化表单字段数据
	 * @return instance of modules\builder\service\GcSchema
	 */
	protected function _initFields()
	{
		$object = SModFactory::getInstance('Fields', self::SRV_NAME);
		$tableName = $object->getTableName();

		Log::echoTrace('Query from ' . $tableName . ' Begin ...');

		$data = $object->findAllByAttributes(array('builder_id' => $this->builderId), 'sort', 0, 1000);
		if ($data === false) {
			Log::errExit(__LINE__, 'Query from ' . $tableName . ' Failed!');
		}

		Log::echoTrace('Query from ' . $tableName . ' Successfully');
		return $this;
	}
}

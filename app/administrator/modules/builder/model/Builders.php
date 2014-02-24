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

use library\Model;
use library\BuilderFactory;
use library\ErrorNo;
use modules\builder\data\BuildersData;

/**
 * Builders class file
 * Builders业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Builders.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.model
 * @since 1.0
 */
class Builders extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = BuilderFactory::getDb('Builders');
		parent::__construct($db);
	}

	/**
	 * 查询数据
	 * @param array $params
	 * @param string $order
	 * @return array
	 */
	public function search(array $params = array(), $order = '')
	{
		$rules = array(
			'trash' => 'trim',
			'builder_name' => 'trim',
			'builder_id' => 'intval',
			'tbl_name' => 'trim',
			'tbl_profile' => 'trim',
			'tbl_engine' => 'trim',
			'tbl_charset' => 'trim',
			'app_name' => 'trim'
		);

		$attributes = $this->filterCleanEmpty($rules, $params);
		$ret = $this->findAllByAttributes($attributes, $order);
		return $ret;
	}

	/**
	 * 通过builder_id获取builder_name值
	 * @param integer $value
	 * @return string
	 */
	public function getBuilderNameByBuilderId($value)
	{
		$value = (int) $value;
		$ret = $this->getByPk('builder_name', $value);
		$builderName = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? '' : $ret['builder_name'];
		return $builderName;
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @return array
	 */
	public function create(array $params = array())
	{
		$params['dt_created'] = date('Y-m-d H:i:s');
		if (!isset($params['index_row_btns']) || !is_array($params['index_row_btns'])) {
			$params['index_row_btns'] = array();
		}

		return $this->insert($params);
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $value
	 * @param array $params
	 * @return array
	 */
	public function modifyByPk($value, array $params)
	{
		$params['dt_modified'] = date('Y-m-d H:i:s');
		return $this->updateByPk($value, $params);
	}

	/**
	 * (non-PHPdoc)
	 * @see library.Model::validate()
	 */
	public function validate(array $attributes = array(), $required = false, $opType = '')
	{
		$rules = array(
			'builder_name' => BuildersData::getBuilderNameRules(),
			'tbl_name' => BuildersData::getTblNameRules(),
			'tbl_profile' => BuildersData::getTblProfileRules(),
			'tbl_engine' => BuildersData::getTblEngineRules(),
			'tbl_charset' => BuildersData::getTblCharsetRules(),
			'tbl_comment' => BuildersData::getTblCommentRules(),
			'app_name' => BuildersData::getAppNameRules(),
			'mod_name' => BuildersData::getModNameRules(),
			'ctrl_name' => BuildersData::getCtrlNameRules(),
			'cls_name' => BuildersData::getClsNameRules(),
			'act_index_name' => BuildersData::getActIndexNameRules(),
			'act_view_name' => BuildersData::getActViewNameRules(),
			'act_create_name' => BuildersData::getActCreateNameRules(),
			'act_modify_name' => BuildersData::getActModifyNameRules(),
			'act_remove_name' => BuildersData::getActRemoveNameRules(),
			'index_row_btns' => BuildersData::getIndexRowBtnsRules(),
			'trash' => BuildersData::getTrashRules(),
		);

		return $this->runfilterValidate($rules, $attributes, $required);
	}

	/**
	 * (non-PHPdoc)
	 * @see library.Model::cleanBeforeValidator()
	 */
	public function cleanBeforeValidator(array $attributes = array(), $opType = '')
	{
		$rules = array(
			'builder_name' => 'trim',
			'tbl_name' => 'trim',
			'tbl_comment' => array($this, 'cleanXss'),
			'app_name' => 'trim',
			'mod_name' => 'trim',
			'ctrl_name' => 'trim',
			'cls_name' => 'trim',
			'description' => array($this, 'cleanXss'),
			'act_index_name' => 'trim',
			'act_view_name' => 'trim',
			'act_create_name' => 'trim',
			'act_modify_name' => 'trim',
			'act_remove_name' => 'trim',
			'tbl_profile' => 'trim',
			'tbl_engine' => 'trim',
			'tbl_charset' => 'trim',
			'trash' => 'trim',
			'index_row_btns' => array($this, 'trims')
		);

		$ret = $this->getFilter()->clean($rules, $attributes);
		return $ret;
	}

	/**
	 * (non-PHPdoc)
	 * @see library.Model::cleanAfterValidator()
	 */
	public function cleanAfterValidator(array $attributes = array(), $opType = '')
	{
		$rules = array(
			'index_row_btns' => array($this, 'join')
		);

		$ret = $this->getFilter()->clean($rules, $attributes);
		return $ret;
	}
}

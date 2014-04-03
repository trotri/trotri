<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace smods\builder;

use tfc\util\Language;
use slib\BaseModel;
use slib\Data;
use slib\ErrorNo;

/**
 * ModBuilders class file
 * 业务层：模型类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ModBuilders.php 1 2014-04-03 16:16:03Z Code Generator $
 * @package smods.builder
 * @since 1.0
 */
class ModBuilders extends BaseModel
{
	/**
	 * 构造方法：初始化数据库操作类和语言国际化管理类
	 * @param tfc\util\Language $language
	 * @param integer $tableNum 分表数字，如果 >= 0 表示分表操作
	 */
	public function __construct(Language $language, $tableNum = -1)
	{
		$db = new DbBuilders($tableNum);
		parent::__construct($db, $language);
	}

	/**
	 * 查询数据
	 * @param array $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function search(array $params = array(), $order = '', $limit = 0, $offset = 0)
	{
		$rules = array(
			'builder_id' => 'intval',
			'builder_name' => 'trim',
			'tbl_name' => 'trim',
			'tbl_profile' => 'trim',
			'tbl_engine' => 'trim',
			'tbl_charset' => 'trim',
			'app_name' => 'trim',
			'trash' => 'trim',
			'author_name' => 'trim',
			'author_mail' => 'trim',
		);

		$this->_filterCleanEmpty($params, $rules);
		return $this->findAllByAttributes($params, $order, $limit, $offset);
	}

	/**
	 * 获取所有的表名
	 * @return array
	 */
	public function getTblNames()
	{
		$ret = $this->findColumnsByAttributes(array('tbl_name'), array('trash' => 'n'), '', 0, 0, '');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$data = array();
		foreach ($ret['data'] as $rows) {
			$data[] = $rows['tbl_name'];
		}

		$ret['data'] = $data;
		return $ret;
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::findByPk()
	 */
	public function findByPk($value)
	{
		$ret = parent::findByPk($value);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$ret['data']['index_row_btns'] = explode(',', $ret['data']['index_row_btns']);
		return $ret;
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

		if (isset($params['trash'])) { unset($params['trash']); }
		return $this->autoInsert($params);
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

		if (isset($params['trash'])) { unset($params['trash']); }
		return $this->autoUpdateByPk($value, $params);
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::validate()
	 */
	public function validate(array $attributes = array(), $required = false, $opType = '')
	{
		$data = Data::getInstance($this->_className, $this->_moduleName, $this->getLanguage());
		$rules = $data->getRules(array(
			'builder_name',
			'tbl_name',
			'tbl_profile',
			'tbl_engine',
			'tbl_charset',
			'tbl_comment',
			'app_name',
			'mod_name',
			'ctrl_name',
			'cls_name',
			'fk_column',
			'act_index_name',
			'act_view_name',
			'act_create_name',
			'act_modify_name',
			'act_remove_name',
			'index_row_btns',
			'author_name',
			'author_mail',
		));

		if (!isset($attributes['fk_column']) || $attributes['fk_column'] === '') {
			unset($rules['fk_column']);
		}

		return $this->filterRun($rules, $attributes, $required);
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::_cleanPreValidator()
	 */
	protected function _cleanPreValidator(array $attributes = array(), $opType = '')
	{
		$rules = array(
			'builder_name' => 'trim',
			'tbl_name' => 'trim',
			'tbl_profile' => 'trim',
			'tbl_engine' => 'trim',
			'tbl_charset' => 'trim',
			'tbl_comment' => 'trim',
			'app_name' => 'trim',
			'mod_name' => 'trim',
			'ctrl_name' => 'trim',
			'cls_name' => 'trim',
			'fk_column' => 'trim',
			'act_index_name' => 'trim',
			'act_view_name' => 'trim',
			'act_create_name' => 'trim',
			'act_modify_name' => 'trim',
			'act_remove_name' => 'trim',
			'index_row_btns' => array($this, 'trims'),
			'author_name' => 'trim',
			'author_mail' => 'trim',
			'dt_created' => 'trim',
			'dt_modified' => 'trim',
		);

		return $this->_clean($rules, $attributes);
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::_cleanPostValidator()
	 */
	protected function _cleanPostValidator(array $attributes = array(), $opType = '')
	{
		$rules = array(
			'index_row_btns' => array($this, 'join')
		);

		return $this->_clean($rules, $attributes);
	}

}

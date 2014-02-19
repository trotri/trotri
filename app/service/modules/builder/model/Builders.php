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
	 * 检索多条记录
	 * @param array $params
	 * @param string $order
	 * @param integer $pageNo
	 * @return array
	 */
	public function search(array $params = array(), $order = '', $pageNo = 0)
	{
		
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @return array
	 */
	public function create(array $params = array())
	{
		
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $value
	 * @param array $params
	 * @return array
	 */
	public function modifyByPk($value, array $params = array())
	{
		
	}

	/**
	 * (non-PHPdoc)
	 * @see library.Model::cleanBeforeValidator()
	 */
	public function cleanBeforeValidator(array $attributes = array())
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
		);

		return $this->getFilter()->clean($rules, $attributes);
	}

	/**
	 * (non-PHPdoc)
	 * @see library.Model::cleanAfterValidator()
	 */
	public function cleanAfterValidator(array $attributes = array())
	{
		$rules = array(
			'index_row_btns' => array($this, 'joinIndexRowBtns')
		);

		return $this->getFilter()->clean($rules, $attributes);
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getInsertRules()
	 */
	public function getInsertRules()
	{
		$elements = BuilderFactory::getElements('Builders');
		$type = $elements::TYPE_FILTER;
		$output = array(
			'builder_name' => $elements->getBuilderName($type),
			'tbl_name' => $elements->getTblName($type),
			'tbl_profile' => $elements->getTblProfile($type),
			'tbl_engine' => $elements->getTblEngine($type),
			'tbl_charset' => $elements->getTblCharset($type),
			'tbl_comment' => $elements->getTblComment($type),
			'app_name' => $elements->getAppName($type),
			'mod_name' => $elements->getModName($type),
			'ctrl_name' => $elements->getCtrlName($type),
			'cls_name' => $elements->getClsName($type),
			'act_index_name' => $elements->getActIndexName($type),
			'act_view_name' => $elements->getActViewName($type),
			'act_create_name' => $elements->getActCreateName($type),
			'act_modify_name' => $elements->getActModifyName($type),
			'act_remove_name' => $elements->getActRemoveName($type),
			'index_row_btns' => $elements->getIndexRowBtns($type),
			'trash' => $elements->getTrash($type),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getUpdateRules()
	 */
	public function getUpdateRules()
	{
		$elements = BuilderFactory::getElements('Builders');
		$type = $elements::TYPE_FILTER;
		$output = array(
			'builder_name' => $elements->getBuilderName($type),
			'tbl_name' => $elements->getTblName($type),
			'tbl_profile' => $elements->getTblProfile($type),
			'tbl_engine' => $elements->getTblEngine($type),
			'tbl_charset' => $elements->getTblCharset($type),
			'tbl_comment' => $elements->getTblComment($type),
			'app_name' => $elements->getAppName($type),
			'mod_name' => $elements->getModName($type),
			'ctrl_name' => $elements->getCtrlName($type),
			'cls_name' => $elements->getClsName($type),
			'act_index_name' => $elements->getActIndexName($type),
			'act_view_name' => $elements->getActViewName($type),
			'act_create_name' => $elements->getActCreateName($type),
			'act_modify_name' => $elements->getActModifyName($type),
			'act_remove_name' => $elements->getActRemoveName($type),
			'index_row_btns' => $elements->getIndexRowBtns($type),
			'trash' => $elements->getTrash($type),
		);

		return $output;
	}

	/**
	 * 将列表每行操作按钮用英文逗号连接
	 * @param array $value
	 * @return string
	 */
	public function joinIndexRowBtns($value)
	{
		if (is_array($value)) {
			$value = implode(',', $value);
		}

		return $value;
	}
}

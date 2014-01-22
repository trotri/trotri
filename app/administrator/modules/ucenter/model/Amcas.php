<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\ucenter\model;

use tfc\ap\Ap;
use tfc\ap\Registry;
use koala\Model;
use library\ErrorNo;
use library\UcenterFactory;

/**
 * Amcas class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Amcas.php 1 2014-01-22 16:43:52Z huan.song $
 * @package modules.ucenter.model
 * @since 1.0
 */
class Amcas extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = UcenterFactory::getDb('Amcas');
		parent::__construct($db);
	}

	/**
	 * 查询数据
	 * @param array $params
	 * @param string $order
	 * @param integer $pageNo
	 * @return array
	 */
	public function search(array $params = array(), $order = '', $pageNo = 0)
	{
		$attributes = array();
		//--待开发--
		$ret = $this->findIndexByAttributes($attributes, $order, $pageNo);
		return $ret;
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @return array
	 */
	public function create(array $params = array())
	{
		//--待开发--
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
		//--待开发--
		return $this->updateByPk($value, $params);
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getInsertRules()
	 */
	public function getInsertRules()
	{
		$elements = UcenterFactory::getElements('Amcas');
		$type = $elements::TYPE_FILTER;
		$output = array(
			'amca_id' => $elements->getAmcaId($type),
			'amca_pid' => $elements->getAmcaPid($type),
			'amca_name' => $elements->getAmcaName($type),
			'sort' => $elements->getSort($type),
			'category' => $elements->getCategory($type),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getUpdateRules()
	 */
	public function getUpdateRules()
	{
		$elements = UcenterFactory::getElements('Amcas');
		$type = $elements::TYPE_FILTER;
		$output = array(
			'amca_id' => $elements->getAmcaId($type),
			'amca_pid' => $elements->getAmcaPid($type),
			'amca_name' => $elements->getAmcaName($type),
			'sort' => $elements->getSort($type),
			'category' => $elements->getCategory($type),
		);

		return $output;
	}

}

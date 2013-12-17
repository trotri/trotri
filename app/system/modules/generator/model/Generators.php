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

use tfc\ap\Registry;
use tfc\util\String;
use koala\Model;
use library\ErrorNo;
use library\GeneratorFactory;

/**
 * Generators class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Generators.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.model
 * @since 1.0
 */
class Generators extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = GeneratorFactory::getDb('Generators');
		parent::__construct($db);
	}

	/**
	 * 查询数据
	 * @param integer $pageNo
	 * @param array $params
	 * @return array
	 */
	public function search($pageNo, array $params)
	{
		$pageNo = max(1, (int) $pageNo);

		$trash = isset($params['trash']) ? trim($params['trash']) : '';
		$generatorName = isset($params['generator_name']) ? trim($params['generator_name']) : '';
		$generatorId = isset($params['generator_id']) ? (int) $params['generator_id'] : 0;
		$tblName = isset($params['tbl_name']) ? trim($params['tbl_name']) : '';
		$tblProfile = isset($params['tbl_profile']) ? trim($params['tbl_profile']) : '';
		$tblEngine = isset($params['tbl_engine']) ? trim($params['tbl_engine']) : '';
		$tblCharset = isset($params['tbl_charset']) ? trim($params['tbl_charset']) : '';
		$appName = isset($params['app_name']) ? trim($params['app_name']) : '';

		if ($trash !== '') {
			$attributes['trash'] = $trash;
		}

		if ($generatorName !== '') {
			$attributes['generator_name'] = $generatorName;
		}

		if ($generatorId > 0) {
			$attributes['generator_id'] = $generatorId;
		}

		if ($tblName !== '') {
			$attributes['tbl_name'] = $tblName;
		}

		if ($tblProfile !== '') {
			$attributes['tbl_profile'] = $tblProfile;
		}

		if ($tblEngine !== '') {
			$attributes['tbl_engine'] = $tblEngine;
		}

		if ($tblCharset !== '') {
			$attributes['tbl_charset'] = $tblCharset;
		}

		if ($appName !== '') {
			$attributes['app_name'] = $appName;
		}

		$ret = $this->findIndexByAttributes($attributes, '', $pageNo);
		return $ret;
	}

	/**
	 * 通过generator_id获取generator_name值
	 * @param integer $value
	 * @return string
	 */
	public function getGeneratorNameByGeneratorId($value)
	{
		$value = (int) $value;
		$name = 'Generators::generator_name_' . $value;
		if (!Registry::has($name)) {
			$ret = $this->getByPk('generator_name', $value);
			$generatorName = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? '' : $ret['generator_name'];
			Registry::set($name, $generatorName);
		}

		return Registry::get($name);
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @return array
	 */
	public function create(array $params)
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
	 * @see koala.Model::getInsertRules()
	 */
	public function getInsertRules()
	{
		$elements = GeneratorFactory::getElements('Generators');
		$type = $elements::TYPE_FILTER;

		$output = array(
			'generator_name' => $elements->getGeneratorName($type),
			'tbl_name' => $elements->getTblName($type),
			'tbl_engine' => $elements->getTblEngine($type),
			'tbl_charset' => $elements->getTblCharset($type),
			'tbl_comment' => $elements->getTblComment($type),
			'app_name' => $elements->getAppName($type),
			'mod_name' => $elements->getModName($type),
			'ctrl_name' => $elements->getCtrlName($type),
			'index_row_btns' => $elements->getIndexRowBtns($type),
			'trash' => $elements->getTrash($type),
			'act_index_name' => $elements->getActIndexName($type),
			'act_view_name' => $elements->getActViewName($type),
			'act_create_name' => $elements->getActCreateName($type),
			'act_modify_name' => $elements->getActModifyName($type),
			'act_remove_name' => $elements->getActRemoveName($type),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getUpdateRules()
	 */
	public function getUpdateRules()
	{
		$elements = GeneratorFactory::getElements('Generators');
		$type = $elements::TYPE_FILTER;

		$output = array(
			'generator_name' => $elements->getGeneratorName($type),
			'tbl_name' => $elements->getTblName($type),
			'tbl_engine' => $elements->getTblEngine($type),
			'tbl_charset' => $elements->getTblCharset($type),
			'tbl_comment' => $elements->getTblComment($type),
			'app_name' => $elements->getAppName($type),
			'mod_name' => $elements->getModName($type),
			'ctrl_name' => $elements->getCtrlName($type),
			'index_row_btns' => $elements->getIndexRowBtns($type),
			'trash' => $elements->getTrash($type),
			'act_index_name' => $elements->getActIndexName($type),
			'act_view_name' => $elements->getActViewName($type),
			'act_create_name' => $elements->getActCreateName($type),
			'act_modify_name' => $elements->getActModifyName($type),
			'act_remove_name' => $elements->getActRemoveName($type),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getCleanRulesBeforeValidator()
	 */
	public function getCleanRulesBeforeValidator()
	{
		$output = array(
			'generator_name' => 'trim',
			'tbl_name' => 'trim',
			'tbl_comment' => array($this, 'cleanTblComment'),
			'app_name' => 'trim',
			'mod_name' => 'trim',
			'ctrl_name' => 'trim',
			'description' => array($this, 'cleanDescription'),
			'act_index_name' => 'trim',
			'act_view_name' => 'trim',
			'act_create_name' => 'trim',
			'act_modify_name' => 'trim',
			'act_remove_name' => 'trim',
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getCleanRulesAfterValidator()
	 */
	public function getCleanRulesAfterValidator()
	{
		$output = array(
			'index_row_btns' => array($this, 'joinIndexRowBtns')
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

	/**
	 * 清理表描述，除去左右空格，并且escapeXss
	 * @param string $value
	 * @return string
	 */
	public function cleanTblComment($value)
	{
		$ret = String::escapeXss(trim($value));
		return $ret;
	}

	/**
	 * 清理表描述，除去左右空格，并且escapeXss
	 * @param string $value
	 * @return string
	 */
	public function cleanDescription($value)
	{
		$ret = String::escapeXss(trim($value));
		return $ret;
	}
}

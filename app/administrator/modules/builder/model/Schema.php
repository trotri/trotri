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

use tfc\ap\Singleton;
use tfc\mvc\Mvc;
use tfc\saf\DbProxy;
use tfc\saf\Text;
use tdo\Metadata;
use slib\Constant;
use library\PageHelper;
use library\Model;
use library\ErrorNo;

/**
 * Schema class file
 * 数据库表管理
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Schema.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.model
 * @since 1.0
 */
class Schema extends Model
{
	/**
	 * @var instance of tdo\Metadata
	 */
	protected $_metadata = null;

	/**
	 * 构造方法：初始化MySQL表结构分析类
	 */
	public function __construct()
	{
		$this->_metadata = new Metadata($this->getDbProxy());
	}

	/**
	 * (non-PHPdoc)
	 * @see library.Model::search()
	 */
	public function search(array $params = array())
	{
		$stblName = isset($params['stbl_name']) ? trim($params['stbl_name']) : '';
		$alreadyGb = isset($params['already_gb']) ? trim($params['already_gb']) : '';
		if ($stblName === '') {
			$stblName = null;
		}

		$tableNames = $this->_metadata->getTableNames($stblName);
		$alreadyTblNames = Model::getInstance('Builders')->getTblNames();

		$tblPrefix = $this->getDbProxy()->getTblprefix();
		$tblPreLen = strlen($tblPrefix);

		$data = array();
		$p = 0;
		foreach ($tableNames as $tableName) {
			$sTableName = substr($tableName, $tblPreLen);
			$data[$p++] = array(
				'stbl_name' => $sTableName,
				'tbl_name' => $tableName,
				'already_gb' => in_array($sTableName, $alreadyTblNames) ? 'y' : 'n'
			);
		}

		$enum = $this->getAlreadyGbEnum();
		if (isset($enum[$alreadyGb])) {
			foreach ($data as $key => $rows) {
				if ($rows['already_gb'] !== $alreadyGb) {
					unset($data[$key]);
				}
			}
		}

		$ret = array(
			'err_no' => ErrorNo::SUCCESS_NUM,
			'data' => $data,
			'paginator' => array(
				'attributes' => array(
					'stbl_name' => $stblName,
					'already_gb' => $alreadyGb
				)
			)
		);

		return $ret;
	}

	/**
	 * 通过表Metadata生成Builders数据
	 * @param string $tblName
	 * @return array
	 */
	public function gb($tblName)
	{
		header('Content-Type: text/html; charset=utf-8');

		$tableNames = $this->_metadata->getTableNames($tblName);
		if (!in_array($tblName, $tableNames)) {
			echo '<font color="red">Table Name Not Exists!</font><br/>';
			exit;
		}

		echo '<font color="blue">', 'Begin Generate, Table Name: ', $tblName, '</font><br/>';
		$tableSchema = $this->_metadata->getTableSchema($tblName);
		$comments = $this->_metadata->getComments($tableSchema->name);

		sleep(2);
		echo '<font color="blue">Import to tr_builders Begin ...</font><br/>';
		$modBuilders = Model::getInstance('Builders');
		$dataBuilders = $modBuilders->getData();
		$params = array(
			'builder_name' => isset($comments['__table__']) ? $comments['__table__'] : $tableSchema->name,
			'tbl_name' => $tableSchema->name,
			'tbl_profile' => $dataBuilders::TBL_PROFILE_N,
			'tbl_engine' => $dataBuilders::TBL_ENGINE_INNODB,
			'tbl_charset' => $dataBuilders::TBL_CHARSET_UTF8,
			'tbl_comment' => isset($comments['__table__']) ? $comments['__table__'] : '',
			'app_name' => 'undefined',
			'mod_name' => 'undefined',
			'ctrl_name' => substr(strstr($tableSchema->name, '_'), 1),
			'cls_name' => substr(strstr($tableSchema->name, '_'), 1),
			'act_index_name' => 'index',
			'act_view_name' => 'view',
			'act_create_name' => 'create',
			'act_modify_name' => 'modify',
			'act_remove_name' => 'remove',
			'index_row_btns' => array(
				$dataBuilders::INDEX_ROW_BTNS_PENCIL,
				$dataBuilders::INDEX_ROW_BTNS_REMOVE,
			),
			'description' => ''
		);

		$ret = $modBuilders->create($params);
		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			echo '<font color="blue">Import to tr_builders Successfully ...</font><br/>';
		}
		else {
			echo '<font color="red">Import to tr_builders Failed!</font><br/>';
			exit;
		}

		sleep(2);
		echo '<font color="blue">Import to tr_builder_fields Begin ...</font><br/>';
		$modFields = Model::getInstance('Fields');
		$dataFields = $modFields->getData();
		$builderId = $ret['id'];
		$sort = 0;

		echo '<pre>';
		foreach ($tableSchema->columns as $columnSchema) {
			$sort++;
			if ($columnSchema->type === 'integer') {
				$columnLength = $columnSchema->size;
			}
			elseif (stripos($columnSchema->dbType, 'enum') !== false) {
				$columnLength = str_replace(array('\'', ','), array('', '|'), substr(substr($columnSchema->dbType, 5), 0, -1));
			}
			else {
				$columnLength = '';
			}

			$params = array(
				'field_name' => $columnSchema->name,
				'column_length' => $columnLength,
				'column_auto_increment' => $columnSchema->isAutoIncrement ? $dataFields::COLUMN_AUTO_INCREMENT_Y : $dataFields::COLUMN_AUTO_INCREMENT_N,
				'column_unsigned' => (stripos($columnSchema->dbType, 'unsigned') !== false) ? $dataFields::COLUMN_UNSIGNED_Y : $dataFields::COLUMN_UNSIGNED_N,
				'column_comment' => isset($comments[$columnSchema->name]) ? $comments[$columnSchema->name] : '',
				'builder_id' => $builderId,
				'group_id' => 0,
				'type_id' => 1,
				'sort' => $sort,
				'html_label' => isset($comments[$columnSchema->name]) ? $comments[$columnSchema->name] : $columnSchema->name,
				'form_prompt' => '',
				'form_required' => $dataFields::FORM_REQUIRED_N,
				'form_modifiable' => $dataFields::FORM_MODIFIABLE_Y,
				'index_show' => $dataFields::INDEX_SHOW_Y,
				'index_sort' => $sort,
				'form_create_show' => $dataFields::FORM_CREATE_SHOW_Y,
				'form_create_sort' => $sort,
				'form_modify_show' => $dataFields::FORM_MODIFY_SHOW_Y,
				'form_modify_sort' => $sort,
				'form_search_show' => $dataFields::FORM_SEARCH_SHOW_Y,
				'form_search_sort' => $sort,
			);

			print_r($params);
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see library.Model::getElementsRender()
	 */
	public function getElementsRender()
	{
		$ret = array(
			'stbl_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_SCHEMA_STBL_NAME_LABEL'),
			),
			'tbl_name' => array(
				'label' => Text::_('MOD_BUILDER_BUILDER_SCHEMA_TBL_NAME_LABEL'),
			),
			'already_gb' => array(
				'label' => Text::_('MOD_BUILDER_BUILDER_SCHEMA_ALREADY_GB_LABEL'),
				'table' => array(
					'callback' => array($this, 'getAlreadyGbTblColumn')
				),
				'options' => $this->getAlreadyGbEnum(),
				'search' => array(
					'type' => 'select'
				),
			),
			'_operate_' => array(
				'label' => Text::_('CFG_SYSTEM_GLOBAL_OPERATE'),
				'table' => array(
					'callback' => array($this, 'getOperate')
				)
			)
		);

		return $ret;
	}

	/**
	 * 获取操作图标按钮
	 * @param array $data
	 * @return string
	 */
	public function getOperate($data)
	{
		$params = array('tbl_name' => $data['tbl_name']);
		$componentsBuilder = PageHelper::getComponentsBuilder();

		// 已经通过表Metadata生成Builders数据
		$buildIcon = $componentsBuilder->getGlyphicon(array(
			'type' => $componentsBuilder->getGlyphiconTool(),
			'url' => $this->getUrl('gb', Mvc::$controller, Mvc::$module, $params),
			'jsfunc' => $componentsBuilder->getJsFuncHref(),
			'title' => Text::_('MOD_BUILDER_URLS_SCHEMA_BUILDER_GENERATE')
		));

		$ret = $buildIcon;
		return $ret;
	}

	/**
	 * 获取“是否已经通过表Metadata生成Builders数据”所有选项
	 * @return array
	 */
	public function getAlreadyGbEnum()
	{
		return array(
			'y' => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			'n' => Text::_('CFG_SYSTEM_GLOBAL_NO')
		);
	}

	/**
	 * 获取列表页“是否已经通过表Metadata生成Builders数据”选项
	 * @param array $data
	 * @return string
	 */
	public function getAlreadyGbTblColumn($data)
	{
		return ($data['already_gb'] === 'y') ? Text::_('CFG_SYSTEM_GLOBAL_YES') : Text::_('CFG_SYSTEM_GLOBAL_NO');
	}

	/**
	 * 获取DbProxy
	 * @return tfc\saf\DbProxy
	 */
	public function getDbProxy()
	{
		$clusterName = Constant::DB_CLUSTER;
		$className = 'tfc\\saf\\DbProxy::' . $clusterName;
		if (($dbProxy = Singleton::get($className)) === null) {
			$dbProxy = new DbProxy($clusterName);
			Singleton::set($className, $dbProxy);
		}

		return $dbProxy;
	}
}

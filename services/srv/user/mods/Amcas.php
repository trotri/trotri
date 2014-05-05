<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace srv\user\mods;

use tfc\saf\ErrorNo;
use srv\library\Model;
use srv\library\Text;
use srv\user\db\Amcas AS DbAmcas;

/**
 * ModAmcas class file
 * 业务层：模型类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ModAmcas.php 1 2014-04-06 14:43:06Z huan.song $
 * @package srv.user.mods
 * @since 1.0
 */
class Amcas extends Model
{
	/**
	 * @var instance of srv\user\db\Amcas
	 */
	protected $_dbAmcas = null;

	/**
	 * 构造方法：初始化数据库操作类
	 */
	public function __construct()
	{
		$this->_dbAmcas = new DbAmcas();
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $amcaId
	 * @return array
	 */
	public function findByAmcaId($amcaId)
	{
		return $this->callFetchMethod($this->_dbAmcas, 'findByAmcaId', array($amcaId));
	}

	/**
	 * 获取所有的应用提示
	 * @return array
	 */
	public function findAppPrompts()
	{
		return $this->callFetchMethod($this->_dbAmcas, 'findAppPrompts');
	}

	/**
	 * 通过父ID，获取所有的子事件
	 * @param integer $amcaPid
	 * @return array
	 */
	public function findAllByAmcaPid($amcaPid)
	{
		return $this->callFetchMethod($this->_dbAmcas, 'findAllByAmcaPid', array($amcaPid));
	}

	/**
	 * 获取模块和控制器类型数据
	 * @param integer $appId
	 * @param string $padStr
	 * @return array
	 */
	public function findModCtrls($appId, $padStr = ' ---- ')
	{
		$data = array();

		$mods = $this->_dbAmcas->findAllByAmcaPid($appId);
		if ($mods && is_array($mods)) {
			foreach ($mods as $modRows) {
				$data[] = $modRows;

				$ctrls = $this->_dbAmcas->findAllByAmcaPid($modRows['amca_id']);
				if ($ctrls && is_array($ctrls)) {
					foreach ($ctrls as $ctrlRows) {
						$ctrlRows['amca_name'] = $padStr . $ctrlRows['amca_name'];
						$data[] = $ctrlRows;
					}
				}
			}
		}

		$errNo = ErrorNo::SUCCESS_NUM;

		if (empty($data)) {
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_SELECT_EMPTY');
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'data' => array()
			);
		}

		$errMsg = Text::_('ERROR_MSG_SUCCESS_SELECT');
		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'data' => $data
		);
	}

	/**
	 * 递归模式获取所有数据
	 * @return array
	 */
	public function findAllByRecur()
	{
		$data = array();

		$apps = $this->_dbAmcas->findAllByAmcaPid(0);
		if ($apps && is_array($apps)) {
			foreach ($apps as $appRow) {
				$appRow['rows'] = array();

				$mods = $this->_dbAmcas->findAllByAmcaPid($appRow['amca_id']);
				if ($mods && is_array($mods)) {
					foreach ($mods as $modRow) {
						$modRow['rows'] = array();

						$ctrls = $this->_dbAmcas->findAllByAmcaPid($modRow['amca_id']);
						if ($ctrls && is_array($ctrls)) {
							foreach ($ctrls as $ctrlRow) {
								$ctrlRow['rows'] = array();

								$acts = $this->_dbAmcas->findAllByAmcaPid($ctrlRow['amca_id']);
								if ($acts && is_array($acts)) {
									foreach ($acts as $actRow) {
										$ctrlRow['rows'][$actRow['amca_name']] = $actRow;
									}
								}

								$modRow['rows'][$ctrlRow['amca_name']] = $ctrlRow;
							}
						}

						$appRow['rows'][$modRow['amca_name']] = $modRow;
					}
				}

				$data[$appRow['amca_name']] = $appRow;
			}
		}

		$errNo = ErrorNo::SUCCESS_NUM;

		if (empty($data)) {
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_SELECT_EMPTY');
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'data' => array()
			);
		}

		$errMsg = Text::_('ERROR_MSG_SUCCESS_SELECT');
		return array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'data' => $data
		);
	}

	/**
	 * 通过事件ID，获取事件名
	 * @param integer $amcaId
	 * @return string
	 */
	public function getAmcaNameByAmcaId($amcaId)
	{
		$ret = $this->findByAmcaId($amcaId);
		return isset($ret['data']['amca_name']) ? $ret['data']['amca_name'] : '';
	}

	/**
	 * 通过父ID和事件名统计记录数
	 * @param integer $amcaPid
	 * @param string $amcaName
	 * @return integer
	 */
	public function countByPidAndName($amcaPid, $amcaName)
	{
		return $this->_dbAmcas->countByPidAndName($amcaPid, $amcaName);
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @param boolean $ignore
	 * @return array
	 */
	public function create(array $params = array(), $ignore = false)
	{
		$fpAmcas = new FpAmcas($this, FpAmcas::OP_TYPE_INSERT);
		return $this->callCreateMethod($this->_dbAmcas, 'create', $params, $fpAmcas, $ignore);
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $amcaId
	 * @param array $params
	 * @return array
	 */
	public function modify($amcaId, array $params = array())
	{
		$fpAmcas = new FpAmcas($this, FpAmcas::OP_TYPE_UPDATE);
		return $this->callModifyMethod($this->_dbAmcas, 'modify', $amcaId, $params, $fpAmcas);
	}

	/**
	 * 通过主键，删除一条记录
	 * @param integer $amcaId
	 * @return array
	 */
	public function remove($amcaId)
	{
		return $this->callRemoveMethod($this->_dbAmcas, 'remove', array($amcaId));
	}

}

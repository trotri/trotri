<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright (c) 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace slib;

/**
 * Service class file
 * 业务层入口类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Service.php 1 2013-03-29 16:48:06Z huan.song $
 * @package slib
 * @since 1.0
 */
class Service
{
	/**
	 * @var string 缺省的编码
	 */
	const DEFAULT_ENCODING = 'UTF-8';

	/**
	 * @var string 缺省的语言种类
	 */
	const DEFAULT_LANGUAGE_TYPE = 'zh-CN';

	/**
	 * @var array 支持的编码
	 */
	protected $_encodings = array('UTF-8', 'GBK');

	/**
	 * @var array 支持的语言种类
	 */
	protected $_languageTypes = array('zh-CN', 'en-GB');

	/**
	 * @var string 当前的编码
	 */
	protected $_encoding = self::DEFAULT_ENCODING;

	/**
	 * @var string 当前的语言种类
	 */
	protected $_languageType = self::DEFAULT_LANGUAGE_TYPE;

	/**
	 * @var array 寄存所有调用过的模型实例
	 */
	protected $_modules = array();

	/**
	 * 获取模型实例
	 * @param string $languageType
	 * @param string $tableName
	 * @return instance of slib\BaseModel
	 */
	public function getModule($modName, $languageType, $tableName = '')
	{
		
	}

	/**
	 * 获取所有调用过的模型实例
	 * @return array
	 */
	public function getModules()
	{
		return $this->_modules;
	}

	
	
	
	
	
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Action::_init()
	 */
	protected function _init()
	{
		$this->_initDataType();
		$this->_initEncoding();
		$this->_initLanguageType();
	}
	
	/**
	 * 通过输出数据类型，输出数据
	 * @param mixed $data
	 * @return void
	 * @see getViewData
	 */
	public function display($data)
	{
		// 规范输出格式
		$data = $this->getViewData($data);
		if ($data['err_no'] !== ErrorNo::SUCCESS_NUM) {
			Log::warning($data['err_msg'], $data['err_no'], __METHOD__);
		}
	
		// 数据转Json类型后输出，如果项目不是UTF-8格式，需要先将输出数据转成UTF-8格式
		if ($this->_od === 'JSON') {
			if (Ap::getEncoding() !== 'UTF-8') {
				$data = Encoder::getInstance()->convert($data, Ap::getEncoding(), 'UTF-8');
			}
	
			echo json_encode($data);
			exit;
		}
	
		// 数据序列化后输出
		if ($this->_od === 'SERIAL') {
			echo serialize($data);
			exit;
		}
	
		$data = array(
				'err_no' => ErrorNo::ERROR_REQUEST,
				'err_msg' => Text::_('ERROR_MSG_ERROR_REQUEST_OD_ERR'),
		);
		Log::warning($data['err_msg'], $data['err_no'], __METHOD__);
		echo json_encode($data);
		exit;
	}
	
	/**
	 * 获取输出数据，规范化输出数据的格式
	 * 默认添加的输出内容：log_id (integer)
	 * <pre>
	 * 一.参数是字符串：
	 * $data = 'trotri';
	 * 返回值：
	 * $ret = array (
	 *     'err_no' => 0,
	 *     'err_msg' => '',
	 *     'data' => 'trotri',
	 *     'log_id' => 2000010
	 * );
	 *
	 * 二.参数是数组，但是没有指定err_no和err_msg：
	 * $data = array (
	 *     'user_id' => 1,
	 *     'user_name' => 'trotri'
	 * );
	 * 或
	 * $data = array (
	 *     'extra' => '', // 这个值将被丢弃
	 *     'data' => array (
	 *         'user_id' => 1,
	 *         'user_name' => 'trotri'
	 *     )
	 * );
	 * 返回值：
	 * $ret = array (
	 *     'err_no' => 0,
	 *     'err_msg' => '',
	 *     'data' => array (
	 *         'user_id' => 1,
	 *         'user_name' => 'trotri',
	 *     ),
	 *     'log_id' => 2000010
	 * );
	 *
	 * 三.参数是数组，并且已经指定err_no和err_msg：
	 * $data = array (
	 *     'err_no' => 1001,
	 *     'err_msg' => 'Login Failed',
	 *     'user_id' => 1,
	 *     'user_name' => 'trotri'
	 * );
	 * 或
	 * $data = array (
	 *     'err_no' => 1001,
	 *     'err_msg' => 'Login Failed',
	 *     'extra' => '', // 这个值将被丢弃
	 *     'data' => array (
	 *         'user_id' => 1,
	 *         'user_name' => 'trotri'
	 *     )
	 * );
	 * 返回值：
	 * $ret = array (
	 *     'err_no' => 1001,
	 *     'err_msg' => 'Login Failed',
	 *     'data' => array (
	 *         'user_id' => 1,
	 *         'user_name' => 'trotri'
	 *     ),
	 *     'log_id' => 2000010
	 * );
	 * </pre>
	 * @param mixed $data
	 * @return array
	 */
	public function getViewData($data)
	{
		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = '';
		if (is_array($data)) {
			if (isset($data['err_no'])) {
				$errNo = (int) $data['err_no'];
				unset($data['err_no']);
			}
	
			if (isset($data['err_msg'])) {
				$errMsg = $data['err_msg'];
				unset($data['err_msg']);
			}
	
			if (isset($data['data'])) {
				$data = $data['data'];
			}
		}
	
		$ret = array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'data' => $data,
				'log_id' => Log::getId()
		);
	
		return $ret;
	}
	
	/**
	 * 初始化项目输出数据类型
	 * @return void
	 */
	protected function _initDataType()
	{
		// 从RGP中获取‘od’的值（output data type），并验证是否合法
		$dataType = Ap::getRequest()->getTrim('od');
		if ($dataType !== '') {
			$dataType = strtoupper($dataType);
			if (in_array($dataType, $this->_dataTypes)) {
				$this->_dataType = $dataType;
			}
			else {
				$data = array(
						'err_no' => ErrorNo::ERROR_REQUEST,
						'err_msg' => Text::_('ERROR_MSG_ERROR_REQUEST_OD_ERR'),
				);
				$this->display($data);
			}
		}
	}
	
	/**
	 * 初始化项目编码和输入内容编码
	 * @return void
	 */
	protected function _initEncoding()
	{
		// 从配置中获取编码，并验证是否合法
		$encoding = strtoupper(trim(Cfg::getApp('charset')));
		if (in_array($encoding, $this->_encodings)) {
			Ap::setEncoding($encoding);
		}
		else {
			$data = array(
					'err_no' => ErrorNo::ERROR_SYSTEM_RUN_ERR,
					'err_msg' => Text::_('ERROR_MSG_ERROR_CFG_CHARSET_ERR'),
			);
			$this->display($data);
		}
	
		// 从RGP中获取‘ie’的值（input encode），并验证是否合法
		$encoding = Ap::getRequest()->getTrim('ie');
		if ($encoding !== '') {
			$encoding = strtoupper($encoding);
			if (in_array($encoding, $this->_encodings)) {
				$this->_encoding = $encoding;
			}
			else {
				$data = array(
						'err_no' => ErrorNo::ERROR_REQUEST,
						'err_msg' => Text::_('ERROR_MSG_ERROR_REQUEST_IE_ERR'),
				);
				$this->display($data);
			}
		}
		else {
			$this->_encoding = Ap::getEncoding();
		}
	
		// 转换输入内容编码
		if (Ap::getEncoding() !== $this->_encoding) {
			$encoder = Encoder::getInstance();
			$_GET = $encoder->convert($_GET, $this->_encoding);
			$_POST = $encoder->convert($_POST, $this->_encoding);
			$_COOKIE = $encoder->convert($_COOKIE, $this->_encoding);
		}
	}
	
	/**
	 * 初始化输出的语言种类
	 * @return void
	 */
	protected function _initLanguageType()
	{
		// 从配置中获取输出的语种，并验证是否合法
		$languageType = trim(Cfg::getApp('language'));
		if (in_array($languageType, $this->_languageTypes)) {
			Ap::setLanguageType($languageType);
		}
		else {
			$data = array(
					'err_no' => ErrorNo::ERROR_SYSTEM_RUN_ERR,
					'err_msg' => Text::_('ERROR_MSG_ERROR_CFG_LANGUAGE_ERR'),
			);
			$this->display($data);
		}
	
		// 从RGP中获取‘ol’的值（output language type），并验证是否合法
		$languageType = Ap::getRequest()->getTrim('ol');
		if ($languageType !== '') {
			if (in_array($languageType, $this->_languageTypes)) {
				$this->_languageType = $languageType;
				// 以RGP中指定的输出语种为主
				Ap::setLanguageType($languageType);
			}
			else {
				$data = array(
						'err_no' => ErrorNo::ERROR_REQUEST,
						'err_msg' => Text::_('ERROR_MSG_ERROR_REQUEST_OL_ERR'),
				);
				$this->display($data);
			}
		}
	}
}

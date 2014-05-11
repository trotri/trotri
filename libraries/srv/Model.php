<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace srv;

use tfc\ap\ErrorException;

/**
 * Model abstract class file
 * 业务层：模型基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Model.php 1 2013-05-18 14:58:59Z huan.song $
 * @package srv
 * @since 1.0
 */
abstract class Model
{
	/**
	 * @var srv\FormProcessor 表单数据处理类
	 */
	protected $_formProcessor = null;

	/**
	 * 获取表单数据处理类
	 * @return instance of srv\FormProcessor
	 */
	public function getFormProcessor()
	{
		if ($this->_formProcessor === null) {
			throw new ErrorException('Model FormProcessor class is null.');
		}

		if (!$this->_formProcessor instanceof FormProcessor) {
			throw new ErrorException('Model FormProcessor class is not instanceof srv\FormProcessor.');
		}

		return $this->_formProcessor;
	}

	/**
	 * 获取所有的错误信息
	 * @param boolean $justOne
	 * @return array
	 */
	public function getErrors($justOne = true)
	{
		return $this->_formProcessor->getErrors($justOne);
	}
}

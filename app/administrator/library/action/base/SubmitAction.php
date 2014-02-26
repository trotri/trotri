<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace library\action;

use tfc\ap\Ap;
use ui\bootstrap\Components;

/**
 * SubmitAction abstract class file
 * SubmitAction基类，用于提交表单
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SubmitAction.php 1 2013-04-05 01:08:06Z huan.song $
 * @package library.action
 * @since 1.0
 */
abstract class SubmitAction extends ShowAction
{
	/**
	 * 获取当前表单提交方式
	 * @return string
	 */
	public function getSubmitType()
	{
		$submitType = Ap::getRequest()->getTrim('submit_type');
		if (in_array($submitType, Components::$submitTypes)) {
			return $submitType;
		}

		return Components::SUBMIT_TYPE_DEFAULT;
	}

	/**
	 * 返回表单提交后跳转方式：是否是保存并跳转到编辑页
	 * @return boolean
	 */
	public function isSubmitTypeSave()
	{
		return $this->getSubmitType() === Components::SUBMIT_TYPE_SAVE;
	}

	/**
	 * 返回表单提交后跳转方式：是否是保存并跳转到列表页
	 * @return boolean
	 */
	public function isSubmitTypeSaveClose()
	{
		return $this->getSubmitType() === Components::SUBMIT_TYPE_SAVE_CLOSE;
	}

	/**
	 * 返回表单提交后跳转方式：是否是保存并跳转到新增页
	 * @return boolean
	 */
	public function isSubmitTypeSaveNew()
	{
		return $this->getSubmitType() === Components::SUBMIT_TYPE_SAVE_NEW;
	}

	/**
	 * 判断是否是提交新增或编辑表单
	 * @return boolean
	 */
	public function isPost()
	{
		return Ap::getRequest()->getParam('do') == 'post';
	}
}

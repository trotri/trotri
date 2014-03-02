<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace views\bootstrap\components;

use views\ComponentsBuilder;

/**
 * Builder class file
 * 创建页面小组件类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Builder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package views.bootstrap.components
 * @since 1.0
 */
class Builder implements ComponentsBuilder
{
	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getButtonSave()
	 */
	public function getButtonSave(array $params = array())
	{
		$return = self::getHttpReturn();
		$return = String::urlencode($return);
		$output = array(
				'type'      => 'button',
				'label'     => self::_('UI_BOOTSTRAP_SAVE'),
				'glyphicon' => self::GLYPHICON_SAVE,
				'class'     => 'btn btn-primary',
				'onclick'   => 'return Core.formSubmit(this, \'' . self::SUBMIT_TYPE_SAVE . '\', \'' . $return . '\');'
		);
		
		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getButtonSaveClose()
	 */
	public function getButtonSaveClose(array $params = array())
	{
		
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getButtonSaveNew()
	 */
	public function getButtonSaveNew(array $params = array())
	{
		
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getButtonCancel()
	 */
	public function getButtonCancel(array $params = array())
	{
		
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getSwitch()
	 */
	public function getSwitch(array $params = array())
	{
		
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getGlyphicon()
	 */
	public function getGlyphicon(array $params = array())
	{
		
	}
}

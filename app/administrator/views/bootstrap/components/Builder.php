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

use tfc\mvc\Mvc;
use tfc\util\String;
use tfc\saf\Text;
use library;
use library\PageHelper;
use views\ComponentsBuilder;

/**
 * Builder class file
 * 创建页面小组件类，用于创建按钮、图标等，基于Bootstrap-v3前端开发框架
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
		$lastIndexUrl = PageHelper::getLastIndexUrl();
		$lastIndexUrl = String::urlencode($lastIndexUrl);
		$output = array(
			'type'      => 'button',
			'label'     => Text::_('CFG_SYSTEM_GLOBAL_SAVE'),
			'glyphicon' => Constant::GLYPHICON_SAVE,
			'class'     => 'btn btn-primary',
			'onclick'   => 'return ' . Constant::JSFUNC_FORMSUBMIT . '(this, \'' . library\Constant::SUBMIT_TYPE_SAVE . '\', \'' . $lastIndexUrl . '\');'
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getButtonSaveClose()
	 */
	public function getButtonSaveClose(array $params = array())
	{
		$lastIndexUrl = PageHelper::getLastIndexUrl();
		$lastIndexUrl = String::urlencode($lastIndexUrl);
		$output = array(
			'type'      => 'button',
			'label'     => Text::_('CFG_SYSTEM_GLOBAL_SAVE2CLOSE'),
			'glyphicon' => Constant::GLYPHICON_RESTORE,
			'class'     => 'btn btn-default',
			'onclick'   => 'return ' . Constant::JSFUNC_FORMSUBMIT . '(this, \'' . library\Constant::SUBMIT_TYPE_SAVE_CLOSE . '\', \'' . $lastIndexUrl . '\');'
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getButtonSaveNew()
	 */
	public function getButtonSaveNew(array $params = array())
	{
		$lastIndexUrl = PageHelper::getLastIndexUrl();
		$lastIndexUrl = String::urlencode($lastIndexUrl);
		$output = array(
			'type'      => 'button',
			'label'     => Text::_('CFG_SYSTEM_GLOBAL_SAVE2NEW'),
			'glyphicon' => Constant::GLYPHICON_CREATE,
			'class'     => 'btn btn-default',
			'onclick'   => 'return ' . Constant::JSFUNC_FORMSUBMIT . '(this, \'' . library\Constant::SUBMIT_TYPE_SAVE_NEW . '\', \'' . $lastIndexUrl . '\');'
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getButtonCancel()
	 */
	public function getButtonCancel(array $params = array())
	{
		$url = isset($params['url']) ? $params['url'] : '';
		if ($url === '') {
			$url = PageHelper::getLastIndexUrl();
		}

		$output = array(
			'type'      => 'button',
			'label'     => Text::_('CFG_SYSTEM_GLOBAL_CANCEL'),
			'glyphicon' => Constant::GLYPHICON_REMOVE,
			'class'     => 'btn btn-danger',
			'onclick'   => 'return ' . Constant::JSFUNC_HREF . '(\'' . $url . '\');'
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getSwitch()
	 */
	public function getSwitch(array $params = array())
	{
		$on    = isset($params['on'])    ? $params['on']       : 'y';
		$off   = isset($params['off'])   ? $params['off']      : 'n';
		$id    = isset($params['id'])    ? (int) $params['id'] : 0;
		$name  = isset($params['name'])  ? $params['name']     : '';
		$value = isset($params['value']) ? $params['value']    : $off;
		$href  = isset($params['href'])  ? $params['href']     : '';

		$attributes = array(
			'id'             => 'label_switch_' . $name . '_' . $id,
			'name'           => 'label_switch',
			'class'          => 'make-switch switch-small',
			'data-on-label'  => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			'data-off-label' => Text::_('CFG_SYSTEM_GLOBAL_NO'),
		);

		if ($href !== '') {
			$attributes['href'] = PageHelper::applyLastIndexUrl($href);
		}

		return Mvc::getView()->getHtml()->tag('div', $attributes, Mvc::getView()->getHtml()->checkbox($name, $value, ($value === 'y')));
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getGlyphicon()
	 */
	public function getGlyphicon(array $params = array())
	{
		$type      = isset($params['type'])      ? $params['type']      : '';
		$url       = isset($params['url'])       ? $params['url']       : '';
		$jsfunc    = isset($params['jsfunc'])    ? $params['jsfunc']    : '';
		$title     = isset($params['title'])     ? $params['title']     : '';
		$placement = isset($params['placement']) ? $params['placement'] : 'left';

		$url = PageHelper::applyLastIndexUrl($url);
		$click = $jsfunc . '(\'' . $url . '\')';
		$attributes = array(
			'class'               => 'glyphicon glyphicon-' . $type,
			'data-toggle'         => 'tooltip',
			'data-placement'      => $placement,
			'data-original-title' => $title,
			'onclick'             => 'return ' . $click . ';'
		);

		return Mvc::getView()->getHtml()->tag('span', $attributes, '');
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getGlyphiconIndex()
	 */
	public function getGlyphiconIndex()
	{
		return Constant::GLYPHICON_INDEX;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getGlyphiconSave()
	 */
	public function getGlyphiconSave()
	{
		return Constant::GLYPHICON_SAVE;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getGlyphiconCreate()
	 */
	public function getGlyphiconCreate()
	{
		return Constant::GLYPHICON_CREATE;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getGlyphiconModify()
	 */
	public function getGlyphiconModify()
	{
		return Constant::GLYPHICON_MODIFY;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getGlyphiconTrash()
	 */
	public function getGlyphiconTrash()
	{
		return Constant::GLYPHICON_TRASH;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getGlyphiconRestore()
	 */
	public function getGlyphiconRestore()
	{
		return Constant::GLYPHICON_RESTORE;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getGlyphiconRemove()
	 */
	public function getGlyphiconRemove()
	{
		return Constant::GLYPHICON_REMOVE;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getGlyphiconForbidden()
	 */
	public function getGlyphiconForbidden()
	{
		return Constant::GLYPHICON_FORBIDDEN;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getGlyphiconUnforbidden()
	 */
	public function getGlyphiconUnforbidden()
	{
		return Constant::GLYPHICON_UNFORBIDDEN;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getGlyphiconTool()
	 */
	public function getGlyphiconTool()
	{
		return Constant::GLYPHICON_TOOL;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getJsFuncHref()
	 */
	public function getJsFuncHref()
	{
		return Constant::JSFUNC_HREF;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getJsFuncFormSubmit()
	 */
	public function getJsFuncFormSubmit()
	{
		return Constant::JSFUNC_FORMSUBMIT;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getJsFuncDialogRemove()
	 */
	public function getJsFuncDialogRemove()
	{
		return Constant::JSFUNC_DIALOGREMOVE;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getJsFuncDialogTrash()
	 */
	public function getJsFuncDialogTrash()
	{
		return Constant::JSFUNC_DIALOGTRASH;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getJsFuncDialogBatchRemove()
	 */
	public function getJsFuncDialogBatchRemove()
	{
		return Constant::JSFUNC_DIALOGBATCHREMOVE;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getJsFuncDialogBatchTrash()
	 */
	public function getJsFuncDialogBatchTrash()
	{
		return Constant::JSFUNC_DIALOGBATCHTRASH;
	}

	/**
	 * (non-PHPdoc)
	 * @see views.ComponentsBuilder::getJsFuncDialogAjaxView()
	 */
	public function getJsFuncDialogAjaxView()
	{
		return Constant::JSFUNC_DIALOGAJAXVIEW;
	}
}

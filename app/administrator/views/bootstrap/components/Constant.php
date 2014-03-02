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

/**
 * Constant class file
 * 常用常量类
 * 1.Glyphicons 图标类，基于Bootstrap-v3前端开发框架。Glyphicons Halflings 一般不允许免费使用，但是他们的作者允许Bootstrap免费使用。
 * 2.JS函数
 * 3.表单提交后跳转方式
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Constant.php 1 2013-05-18 14:58:59Z huan.song $
 * @package views.bootstrap.components
 * @since 1.0
 */
class Constant
{
	/**
	 * @var string Glyphicons图标：列表
	 */
	const GLYPHICON_INDEX = 'list';

	/**
	 * @var string Glyphicons图标：保存
	 */
	const GLYPHICON_SAVE = 'save';

	/**
	 * @var string Glyphicons图标：新增
	 */
	const GLYPHICON_CREATE = 'plus-sign';

	/**
	 * @var string Glyphicons图标：编辑
	 */
	const GLYPHICON_MODIFY = 'pencil';

	/**
	 * @var string Glyphicons图标：移至回收站
	 */
	const GLYPHICON_TRASH = 'trash';

	/**
	 * @var string Glyphicons图标：恢复
	 */
	const GLYPHICON_RESTORE = 'ok-sign';

	/**
	 * @var string Glyphicons图标：彻底删除
	 */
	const GLYPHICON_REMOVE = 'remove-sign';

	/**
	 * @var string Glyphicons图标：禁用
	 */
	const GLYPHICON_FORBIDDEN = 'lock';

	/**
	 * @var string Glyphicons图标：解除禁用
	 */
	const GLYPHICON_UNFORBIDDEN = 'open';

	/**
	 * @var string Glyphicons图标：工具
	 */
	const GLYPHICON_TOOL = 'wrench';

	/**
	 * @var string JS函数：链接
	 */
	const JSFUNC_HREF = 'Trotri.href';

	/**
	 * @var string JS函数：删除对话框
	 */
	const JSFUNC_DIALOGREMOVE = 'Core.dialogRemove';

	/**
	 * @var string JS函数：放入回收站对话框
	 */
	const JSFUNC_DIALOGTRASH = 'Core.dialogTrash';

	/**
	 * @var string JS函数：批量删除对话框
	 */
	const JSFUNC_DIALOGBATCHREMOVE = 'Core.dialogBatchRemove';

	/**
	 * @var string JS函数：批量放入回收站对话框
	 */
	const JSFUNC_DIALOGBATCHTRASH = 'Core.dialogBatchTrash';

	/**
	 * @var string JS函数：Ajax方式展示数据对话框
	 */
	const JSFUNC_DIALOGAJAXVIEW = 'Core.dialogAjaxView';

	/**
	 * @var string 表单提交后跳转方式：保存并跳转到编辑页
	 */
	const SUBMIT_TYPE_SAVE = 'save';

	/**
	 * @var string 表单提交后跳转方式：保存并跳转到列表页
	 */
	const SUBMIT_TYPE_SAVE_CLOSE = 'save_close';

	/**
	 * @var string 表单提交后跳转方式：保存并跳转到新增页
	 */
	const SUBMIT_TYPE_SAVE_NEW = 'save_new';

	/**
	 * @var string 表单提交后默认的跳转方式
	 */
	const SUBMIT_TYPE_DEFAULT = self::SUBMIT_TYPE_SAVE;
}

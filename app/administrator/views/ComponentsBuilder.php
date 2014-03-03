<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace views;

/**
 * ComponentsBuilder interface file
 * 创建页面小组件接口，用于创建按钮、图标等
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ComponentsBuilder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package views
 * @since 1.0
 */
interface ComponentsBuilder
{
	/**
	 * 获取表单的“保存”按钮信息
	 * @param array $params
	 * @return array
	 */
	public function getButtonSave(array $params = array());

	/**
	 * 获取表单的“保存并关闭”按钮信息
	 * @param array $params
	 * @return array
	 */
	public function getButtonSaveClose(array $params = array());

	/**
	 * 获取表单的“保存并新建”按钮信息
	 * @param array $params
	 * @return array
	 */
	public function getButtonSaveNew(array $params = array());

	/**
	 * 获取表单的“取消”按钮信息，如果存在“最后一次访问的列表页链接”，则跳转到“最后一次访问的列表页”，否则跳转到缺省页面
	 * @param array $params
	 * @return array
	 */
	public function getButtonCancel(array $params = array());

	/**
	 * 获取美化版“是|否”选择项表单元素
	 * @param array $params
	 * @return string
	 */
	public function getSwitch(array $params = array());

	/**
	 * 获取Glyphicons图标按钮和工具提示
	 * @param array $params
	 * @return string
	 */
	public function getGlyphicon(array $params = array());

	/**
	 * 获取Glyphicons图标：列表
	 * @return string
	 */
	public function getGlyphiconIndex();

	/**
	 * 获取Glyphicons图标：保存
	 * @return string
	 */
	public function getGlyphiconSave();

	/**
	 * 获取Glyphicons图标：新增
	 * @return string
	 */
	public function getGlyphiconCreate();

	/**
	 * 获取Glyphicons图标：编辑
	 * @return string
	 */
	public function getGlyphiconModify();

	/**
	 * 获取Glyphicons图标：移至回收站
	 * @return string
	 */
	public function getGlyphiconTrash();

	/**
	 * 获取Glyphicons图标：恢复
	 * @return string
	 */
	public function getGlyphiconRestore();

	/**
	 * 获取Glyphicons图标：彻底删除
	 * @return string
	 */
	public function getGlyphiconRemove();

	/**
	 * 获取Glyphicons图标：禁用
	 * @return string
	 */
	public function getGlyphiconForbidden();

	/**
	 * 获取Glyphicons图标：解除禁用
	 * @return string
	 */
	public function getGlyphiconUnforbidden();

	/**
	 * 获取Glyphicons图标：工具
	 * @return string
	 */
	public function getGlyphiconTool();

	/**
	 * 获取JS函数名：链接
	 * @return string
	 */
	public function getJsFuncHref();

	/**
	 * 获取JS函数名：提交表单
	 * @return string
	 */
	public function getJsFuncFormSubmit();

	/**
	 * 获取JS函数名：删除对话框
	 * @return string
	 */
	public function getJsFuncDialogRemove();

	/**
	 * 获取JS函数名：放入回收站对话框
	 * @return string
	 */
	public function getJsFuncDialogTrash();

	/**
	 * 获取JS函数名：批量删除对话框
	 * @return string
	 */
	public function getJsFuncDialogBatchRemove();

	/**
	 * 获取JS函数名：批量放入回收站对话框
	 * @return string
	 */
	public function getJsFuncDialogBatchTrash();

	/**
	 * 获取JS函数名：Ajax方式展示数据对话框
	 * @return string
	 */
	public function getJsFuncDialogAjaxView();
}

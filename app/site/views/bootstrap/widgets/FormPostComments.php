<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace views\bootstrap\widgets;

use tfc\mvc\form;
use tfc\saf\Text;
use posts\services\DataPosts;

/**
 * FormPostComments class file
 * 文档评论表单
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FormPostComments.php 1 2013-05-18 14:58:59Z huan.song $
 * @package views.bootstrap.widgets
 * @since 1.0
 */
class FormPostComments extends form\FormBuilder
{
	/**
	 * @var string 样式名
	 */
	public $className = 'form-control';

	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\form\FormBuilder::_init()
	 */
	protected function _init()
	{
		// 初始化表单Action
		if (isset($this->_tplVars['action'])) {
			$this->action = $this->_tplVars['action'];
			unset($this->_tplVars['action']);
		}

		$this->post_id = isset($this->post_id) ? (int) $this->post_id : 0;

		$this->_tplVars['elements'] = array(
			'author_name' => array(
				'__object__' => 'tfc\\mvc\\form\\InputElement',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POST_COMMENTS_AUTHOR_NAME_LABEL'),
				'required' => true,
				'class' => $this->className,
			),
			'author_mail' => array(
				'__object__' => 'tfc\\mvc\\form\\InputElement',
				'type' => 'email',
				'label' => Text::_('MOD_POSTS_POST_COMMENTS_AUTHOR_MAIL_LABEL'),
				'required' => true,
				'class' => $this->className,
			),
			'content' => array(
				'__object__' => 'tfc\\mvc\\form\\InputElement',
				'type' => 'textarea',
				'label' => Text::_('MOD_POSTS_POST_COMMENTS_CONTENT_LABEL'),
				'required' => true,
				'class' => $this->className,
				'rows' => 10,
			),
			'post_id' => array(
				'__object__' => 'tfc\\mvc\\form\\InputElement',
				'type' => 'hidden',
				'value' => $this->post_id,
			),
			'comment_pid' => array(
				'__object__' => 'tfc\\mvc\\form\\InputElement',
				'type' => 'hidden',
				'value' => 0,
			),
			'_button_save_' => array(
				'__object__' => 'tfc\\mvc\\form\\ButtonElement',
				'type' => 'button',
				'value' => Text::_('CFG_SYSTEM_GLOBAL_SUBMIT'),
				'class' => 'btn btn-default'
			),
		);

		parent::_init();
	}

	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\form\FormBuilder::run()
	 */
	public function run()
	{
		if ($this->post_id <= 0) {
			return ;
		}

		$commentStatus = isset($this->comment_status) ? trim($this->comment_status) : '';
		if ($commentStatus !== DataPosts::COMMENT_STATUS_PUBLISH && $commentStatus !== DataPosts::COMMENT_STATUS_DRAFT) {
			return ;
		}

		$title = Text::_('MOD_POSTS_POST_COMMENTS_PUBLISH_LABEL');
		$hint = '&nbsp;&nbsp;' . Text::_('MOD_POSTS_POST_COMMENTS_AUTHOR_MAIL_HINT') . '&nbsp;&nbsp;' . Text::_('MOD_POSTS_POST_COMMENTS_PUBLISH_HINT');

		$this->assign('isPublish', ($commentStatus === DataPosts::COMMENT_STATUS_PUBLISH ? 'true' : 'false'));
		$this->assign('title', $title);
		$this->assign('hint', $hint);
		$this->assign('just_now', Text::_('MOD_POSTS_POST_COMMENTS_DT_CREATE_JUST_NOW'));
		$this->assign('response', Text::_('MOD_POSTS_POST_COMMENTS_RESPONSE'));
		$this->assign('auditing', Text::_('MOD_POSTS_POST_COMMENTS_AUDITING'));
		parent::run();

		$this->assign('id', $this->getId());
		$this->display($this->getJsName());
	}

	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\form\FormBuilder::getInputs()
	 */
	public function getInputs()
	{
		$output = '';
		$inputElements = $this->getInputElements();
		foreach ($inputElements as $inputElement) {
			$output .= $this->getHtml()->tag('div', array('class' => 'form-group'), $inputElement->fetch());
		}

		return $output;
	}
}

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

use tfc\mvc\Widget;
use tfc\saf\Text;
use posts\services\DataPosts;

/**
 * ListPostComments class file
 * 文档评论列表
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ListPostComments.php 1 2013-05-18 14:58:59Z huan.song $
 * @package views.bootstrap.widgets
 * @since 1.0
 */
class ListPostComments extends Widget
{
	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\Widget::run()
	 */
	public function run()
	{
		if (($postId = (int) $this->post_id) <= 0) {
			return ;
		}

		$commentStatus = isset($this->comment_status) ? trim($this->comment_status) : '';
		if ($commentStatus === DataPosts::COMMENT_STATUS_FORBIDDEN) {
			return ;
		}

		$id = 'post_comments_box';
		$url = $this->getView()->getUrlManager()->getUrl('commentindex', 'data', 'posts');

		$this->assign('response', Text::_('MOD_POSTS_POST_COMMENTS_RESPONSE'));
		$this->assign('postid', $postId);
		$this->assign('id', $id);
		$this->assign('url', $url);
		$this->display();
		$this->display($this->getJsName());
	}
}

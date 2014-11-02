<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace components\posts;

use libapp\Component;
use tfc\saf\Text;
use library\UrlHelper;
use components\posts\helpers\Constant;
use components\posts\helpers\Posts;
use components\posts\helpers\Categories;

/**
 * ListBox class file
 * 文档列表盒子
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ListBox.php 1 2013-04-20 17:11:06Z huan.song $
 * @package components.posts
 * @since 1.0
 */
class ListBox extends Component
{
	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\Widget::run()
	 */
	public function run()
	{
		$findType = trim($this->find_type);
		$limit = (int) $this->limit;
		$offset = (int) $this->offset;
		$title = trim($this->title);

		if ($findType === '') {
			return ;
		}

		$id = 0;
		if (($p = strpos($findType, '-')) !== false) {
			$id = (int) substr($findType, $p + 1);
			$findType = substr($findType, 0, $p);
		}

		$findType = strtolower($findType);
		if (!in_array($findType, Constant::$findTypes)) {
			return ;
		}

		$title = '';
		$url = '';
		if ($findType === Constant::FIND_TYPE_CATID) {
			if ($id <= 0) {
				return ;
			}

			$row = Categories::findByPk($id);
			if (!$row || !is_array($row) || !isset($row['category_name'])) {
				return ;
			}

			$title = $row['category_name'];
			$url = UrlHelper::getInstance()->getPostIndex($row);
		}
		else {
			switch (true) {
				case $findType === Constant::FIND_TYPE_HEAD:
					$title = Text::_('MOD_POSTS_POSTS_HEAD');
					break;
				case $findType === Constant::FIND_TYPE_RECOMMEND:
					$title = Text::_('MOD_POSTS_POSTS_RECOMMEND');
					break;
				default:
					break;
			}
		}

		$rows = array();
		switch (true) {
			case $findType === Constant::FIND_TYPE_CATID:
				$rows = Posts::getRowsByCatId($id, $limit, $offset);
				break;
			case $findType === Constant::FIND_TYPE_HEAD:
				$rows = Posts::getHeads($limit, $offset);
				break;
			case $findType === Constant::FIND_TYPE_RECOMMEND:
				$rows = Posts::getRecommends($limit, $offset);
				break;
			default:
				break;
		}

		$isShow = false;
		if ($title !== '' && $rows && is_array($rows)) {
			$isShow = true;
		}

		$this->assign('is_show', $isShow);
		$this->assign('title', $title);
		$this->assign('url', $url);
		$this->assign('rows', $rows);
		$this->display();
	}
}

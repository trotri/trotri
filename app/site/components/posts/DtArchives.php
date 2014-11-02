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

/**
 * DtArchives class file
 * 时间索引
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DtArchives.php 1 2013-04-20 17:11:06Z huan.song $
 * @package components.posts
 * @since 1.0
 */
class DtArchives extends Component
{
	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\Widget::run()
	 */
	public function run()
	{
		$outputs = array();

		$end = mktime();
		$begin = $end - 9 * MONTH_IN_SECONDS;

		for (; $begin <= $end; $begin += MONTH_IN_SECONDS) {
			$outputs[] = date('Y-m', $begin);
		}

		$this->assign('title', Text::_('MOD_POSTS_POSTS_ARCHIVES'));
		$this->assign('archives', $outputs);
		$this->display();
	}
}

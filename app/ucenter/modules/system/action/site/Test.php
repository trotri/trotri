<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\system\action\site;

use library\actions;
use tfc\ap\HttpCookie;
use modules\user\service\Amcas;

/**
 * Test class file
 * 测试
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Test.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.system.action.site
 * @since 1.0
 */
class Test extends actions\Show
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$srv = new Amcas();

		/*
		$urls['a1-b1-c1'] = 'a1';
		$urls['a2-b2-c2'] = 'a2';
		$urls['a3-b3-c3'] = 'a3';
		$urls['a4-b4-c4'] = 'a4';
		$urls['a5-b5-c5'] = 'a5';

		$value = str_replace('=', '', base64_encode(serialize($urls)));
		HttpCookie::add('last_list_url', $value);
		*/

		$srv->setLLU();
		$urls = $srv->getLLUs();

		echo '<pre>';
		print_r($urls);
		exit();
	}
}

<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\system\action\show;

use library\BaseAction;
use tid\Authentication;

/**
 * SiteTest class file
 * 系统管理-Test
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SiteTest.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.system.action.show
 * @since 1.0
 */
class SiteTest extends BaseAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$authentication = new Authentication('authentication', 'aaa');

		/*
		var_dump($authentication->getCookieClusterName());
		var_dump($authentication->getCookieName());
		*/

		/*
		$ret = $authentication->getCookie();
		var_dump($ret);
		echo '<br/>';
		*/

		/*
		$ret = $authentication->hasIdentity();
		var_dump($ret);
		echo '<br/>';
		*/

		/*
		$ret = $authentication->getIdentity();
		var_dump($ret);
		echo '<br/>';
		*/

		/*
		$ret = $authentication->clearIdentity();
		var_dump($ret);
		echo '<br/>';
		*/

		/*
		$userId = 1000000000;
		$userName = '  songhuansonghuansonghuan   ';
		$password = '  abc123abc123abc123abc123abc123abc123abc123abc123    ';
		$expiry = 0;
		$ret = $authentication->setIdentity($userId, $userName, $password, $expiry);
		var_dump($ret);
		echo '<br/>';
		*/

		
		echo '<pre>';
		$ret = $authentication->getIdentity();
		var_dump($ret);
		echo '<br/>';
		
		$ret = $authentication->getIdentity();
		var_dump($ret);
		echo '<br/>';
		
		$ret = $authentication->getIdentity();
		var_dump($ret);
		echo '<br/>';
		
		$ret = $authentication->getIdentity();
		var_dump($ret);
		echo '<br/>';
		

		/*
		$userId = '2a';
		$userName = 'ssssssssssssssssssssssssssssssss';
		$password = "a*&()b";
		$expiry = "0";
		$ret = $authentication->setIdentity($userId, $userName, $password, $expiry);
		var_dump($ret);
		echo '<br/>';
		*/
		
		
	}
}

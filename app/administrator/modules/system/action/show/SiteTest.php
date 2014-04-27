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
use tfc\saf\Cookie;
use tfc\util\Mcrypt;

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
		$cookie = new Cookie('cookie');

		/*
		$encodeValue = $cookie->getEncodeValue();
		var_dump($encodeValue);

		$cookie->setEncodeValue(false);

		$encodeValue = $cookie->getEncodeValue();
		var_dump($encodeValue);

		$encodeValue = $cookie->setEncodeValue(true)->getEncodeValue();
		var_dump($encodeValue);
		*/

		// var_dump($cookie->getClusterName());

		/*
		$keyName = $cookie->getKeyName();
		echo 'keyName: ';
		var_dump($keyName);
		echo '<br/>';

		$path = $cookie->getPath();
		echo 'path: ';
		var_dump($path);
		echo '<br/>';

		$domain = $cookie->getDomain();
		echo 'domain: ';
		var_dump($domain);
		echo '<br/>';

		$secure = $cookie->getSecure();
		echo 'secure: ';
		var_dump($secure);
		echo '<br/>';

		$httponly = $cookie->getHttponly();
		echo 'httponly: ';
		var_dump($httponly);
		echo '<br/>';
		*/

		/*
		$mef = $cookie->getMef();
		var_dump($mef);
		*/

		$cookie->setEncodeValue(true);

		/*
		$name = 'user';
		$value = '123456';
		$ret = $cookie->add($name, $value, mktime() + 15);
		var_dump($ret);
		*/
		
		$name = 'user';
		$ret = $cookie->get($name);
		var_dump($ret);
		

		/*
		$name = 'admin';
		$value = 'abc123';
		$ret = $cookie->add($name, $value);
		var_dump($ret);
		*/

		/*
		$name = 'admin';
		$ret = $cookie->get($name);
		var_dump($ret);

		$mcrypt = new Mcrypt('IjfY309L6D0fF7leUr3HJ983', 'kup30Lp9Ll20kIrTy4Lp35ek', 4);
		$ret = $mcrypt->decode($ret);

		var_dump($ret);
		*/
		
		

		/*
		$name = 'admin';
		$ret = $cookie->remove($name);
		var_dump($ret);
		*/
	}
}

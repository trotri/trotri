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
		$cryptKey = 'rty';
		$signKey = '123re45';

		$mcrypt = new Mcrypt($cryptKey, $signKey, 4);
		$plaintext = 'a|b|c|0|1|d';

		$ciphertext = $mcrypt->encode($plaintext, 10);

		echo 'plaintext: ', $plaintext, '<br/>';
		echo 'ciphertext: ', $ciphertext, '  ', strlen($ciphertext), '<br/>';
		echo '___:', $mcrypt->decode('906fMAYBqXVQu6cH7bc3ebdtmSdIQYU7TYRDnf8gAGOZXQej7/cR8A'), '<br/>';
	}
}

<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

/**
 * 为true时表示测试环境，会打印Debug日志
 */
define('DEBUG', true);

/**
 * 设置时区
 */
date_default_timezone_set('PRC');

/**
 * 定义项目名
 */
define('APP_NAME', 'service');

/**
 * 为true时表示测试环境，会打印Debug日志，页面上展示调试信息
 */
defined('DEBUG') || define('DEBUG', false);

require '../libraries/tfc/saf/Loader.php';

$bootstrap = new Bootstrap();
$bootstrap->run();

tfc\mvc\Mvc::run();

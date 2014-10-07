<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace posts\plugins\linker;

use tfc\ap\Event;

/**
 * PlgLinker class file
 * 获取文档内容的URL并添加A标签，测试插件-非正式代码
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: PlgLinker.php 1 2014-09-28 23:41:06Z huan.song $
 * @package posts.plugins.linker
 * @since 1.0
 */
class PlgLinker extends Event
{
	/**
     * @var string 正则：验证URL
     */
    const REGEX_URL = '(
        (http|https|ftp|ftps)://                # protocol
        (
        ([a-z0-9-]+\.)+[a-z]{2,6}               # a domain name
        |                                       #  or
        \d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}      # a IP address
        )
        (:[0-9]+)?                              # a port (optional)
        (/?|/\S+)                               # a /, nothing or a / with something
    )';

	/**
	 * 提交编辑前执行
	 * @param string $context
	 * @param array $row
	 * @return void
	 */
	public function onBeforeFind($context, &$row)
	{
		$content = isset($row['content']) ? $row['content'] : '';
		if ($content === '') {
			return ;
		}

		preg_match_all('~' . self::REGEX_URL . '~ix', $content, $matches);
		if ($matches && is_array($matches) && isset($matches[0]) && is_array($matches[0])) {
			foreach ($matches[0] as $url) {
				if ($url !== '') {
					if (!preg_match('~href\s*=\s*"\s*' . $url . '\s*"~ix', $content)) {
						$content = str_replace($url, '<a href="' . $url . '" target="_blank" name="linker-add">' . $url . '</a>', $content);
					}
				}
			}

			$row['content'] = $content;
		}
	}

}

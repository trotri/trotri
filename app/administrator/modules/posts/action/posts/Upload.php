<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\posts\action\posts;

use library\DataAction;
use tfc\ap\Ap;
use tid\Role;
use files\services\Upload AS FileUpload;

/**
 * Upload class file
 * Ajax上传单张图片
 * CKEditor上传自动提交参数CKEditor=%s&CKEditorFuncNum=%d&langCode=zh-cn
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Create.php 1 2014-09-16 19:32:26Z Code Generator $
 * @package modules.posts.action.posts
 * @since 1.0
 */
class Upload extends DataAction
{
	/**
	 * @var integer 允许的权限
	 */
	protected $_power = Role::INSERT;

	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\interfaces\Action::run()
	 */
	public function run()
	{
		$req = Ap::getRequest();
		$from = $req->getParam('from');

		$fileUpload = new FileUpload();
		$data = $fileUpload->posts($_FILES['upload'], $this->isLittlePicture($from));

		if ($this->isCkeditor($from)) {
			$callback = $req->getParam('CKEditorFuncNum', 1);
			$url = isset($data['url']) ? $data['url'] : '';

			echo '<script type="text/javascript">';
			echo 'window.parent.CKEDITOR.tools.callFunction(' . $callback . ', \'' . $url . "', '');";
			echo '</script>';
			exit();
		}

		$this->display($data);
	}

	/**
	 * 验证是否是上传缩略图
	 * @param string $from
	 * @return boolean
	 */
	public function isLittlePicture($from)
	{
		return ($from === 'little_picture') ? true : false;
	}

	/**
	 * 验证是否是Ckeditor上传
	 * @param string $from
	 * @return boolean
	 */
	public function isCkeditor($from)
	{
		return ($from === 'ckeditor') ? true : false;
	}

}

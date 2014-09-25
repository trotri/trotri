<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace files\services;

use tfc\util\Image;
use tfc\saf\Cfg;
use files\library\Constant;
use files\library\UploadProxy;
use system\services\Options;
use system\services\DataOptions;

/**
 * Upload class file
 * 业务层：业务处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Upload.php 1 2014-09-16 19:26:44Z Code Generator $
 * @package files.services
 * @since 1.0
 */
class Upload
{
	/**
	 * 上传图片：文档管理
	 * @param array $files
	 * @param boolean $littlePicture
	 * @return array
	 */
	public function posts(array $files, $littlePicture = false)
	{
		$clusterName = Constant::POSTS_CLUSTER;

		$uploadProxy = new UploadProxy($clusterName);
		$ret = $uploadProxy->save($files);
		if ($ret['err_no'] !== UploadProxy::SUCCESS_UPLOAD_NUM) {
			return $ret;
		}

		$fileName = $ret['file_name'];
		$fileName = $this->water($fileName);
		if ($littlePicture) {
			$fileName = $this->thumbnail($fileName);
		}

		$ret['file_name'] = $fileName;
		$ret['url'] = $uploadProxy->getUrl($fileName);
		return $ret;
	}

	/**
	 * 生成缩略图
	 * @param string $fileName
	 * @return string
	 */
	public function thumbnail($fileName)
	{
		$thumbWidth = Options::getThumbWidth();
		$thumbHeight = Options::getThumbHeight();
		if ($thumbWidth > 0 && $thumbHeight > 0) {
			$toPath = dirname($fileName) . DS . 'thumb_' . basename($fileName);
			if (Image::thumbnail($fileName, $thumbWidth, $thumbHeight, $toPath)) {
				return $toPath;
			}
		}

		return $fileName;
	}

	/**
	 * 生成文字水印
	 * @param string $fileName
	 * @return string
	 */
	public function water($fileName)
	{
		$type = Options::getWaterMarkType();
		if ($type !== DataOptions::WATER_MARK_TYPE_IMGDIR && $type !== DataOptions::WATER_MARK_TYPE_TEXT) {
			return $fileName;
		}

		$position = Options::getWaterMarkPosition();
		if ($position < 1 || $position > 9) {
			return $fileName;
		}

		$offset = 1;

		if ($type === DataOptions::WATER_MARK_TYPE_TEXT) {
			$text = Options::getWaterMarkText();
			if ($text !== '') {
				$fontFile = Cfg::getApp('fontfile');
				Image::textWater($fileName, $text, $fontFile, $fileName, $position, $offset);
			}
		}
		elseif ($type === DataOptions::WATER_MARK_TYPE_IMGDIR) {
			$water = Options::getWaterMarkImgdir();
			if ($water !== '') {
				$pct = max(Options::getWaterMarkPct(), 0);
				Image::imageWater($fileName, $water, $fileName, $position, $offset, $pct);
			}
		}

		return $fileName;
	}

}

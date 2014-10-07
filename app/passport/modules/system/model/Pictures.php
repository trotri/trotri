<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\system\model;

use library\BaseModel;
use tfc\ap\Ap;
use tfc\saf\Cfg;
use tfc\saf\Text;
use tfc\util\FileManager;

/**
 * Pictures class file
 * 图片管理
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Pictures.php 1 2014-09-29 23:33:28Z Code Generator $
 * @package modules.system.model
 * @since 1.0
 */
class Pictures extends BaseModel
{
	/**
	 * @var string 上传图片保存目录
	 */
	protected $_directory = null;

	/**
	 * @var instance of tfc\util\FileManager
	 */
	protected $_fileManager = null;

	/**
	 * (non-PHPdoc)
	 * @see \library\BaseModel::_init()
	 */
	protected function _init()
	{
		parent::_init();

		$this->_fileManager = new FileManager();
		$this->_directory = DIR_DATA_UPLOAD . DS . 'imgs';

		$this->_fileManager->mkDir($this->_directory);
		$this->_fileManager->mkDir($this->_directory . DS . date('Ym'));
	}

	/**
	 * (non-PHPdoc)
	 * @see \libapp\Elements::getViewTabsRender()
	 */
	public function getViewTabsRender()
	{
		$output = array(
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see \libapp\Elements::getElementsRender()
	 */
	public function getElementsRender()
	{
		$output = array(
			'directory' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_SYSTEM_SYSTEM_PICTURES_DIRECTORY_LABEL'),
				'hint' => Text::_('MOD_SYSTEM_SYSTEM_PICTURES_DIRECTORY_HINT'),
			),
			'file_count' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_SYSTEM_SYSTEM_PICTURES_FILE_COUNT_LABEL'),
				'hint' => Text::_('MOD_SYSTEM_SYSTEM_PICTURES_FILE_COUNT_HINT'),
			),
			'picture_preview' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_SYSTEM_SYSTEM_PICTURES_PICTURE_PREVIEW_LABEL'),
				'hint' => Text::_('MOD_SYSTEM_SYSTEM_PICTURES_PICTURE_PREVIEW_HINT'),
			),
			'picture_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_SYSTEM_SYSTEM_PICTURES_PICTURE_NAME_LABEL'),
				'hint' => Text::_('MOD_SYSTEM_SYSTEM_PICTURES_PICTURE_NAME_HINT'),
			),
			'file_path' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_SYSTEM_SYSTEM_PICTURES_FILE_PATH_LABEL'),
				'hint' => Text::_('MOD_SYSTEM_SYSTEM_PICTURES_FILE_PATH_HINT'),
			),
			'file_size' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_SYSTEM_SYSTEM_PICTURES_FILE_SIZE_LABEL'),
				'hint' => Text::_('MOD_SYSTEM_SYSTEM_PICTURES_FILE_SIZE_HINT'),
			),
			'width_height' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_SYSTEM_SYSTEM_PICTURES_WIDTH_HEIGHT_LABEL'),
				'hint' => Text::_('MOD_SYSTEM_SYSTEM_PICTURES_WIDTH_HEIGHT_HINT'),
			),
			'dt_created' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_SYSTEM_SYSTEM_PICTURES_DT_CREATED_LABEL'),
				'hint' => Text::_('MOD_SYSTEM_SYSTEM_PICTURES_DT_CREATED_HINT'),
			),
		);

		return $output;
	}

	/**
	 * 获取所有的图片目录
	 * @param integer $ymDir
	 * @return array
	 */
	public function getDirs($ymDir = 0)
	{
		$data = array();

		$directory = $this->_directory;
		if ($ymDir > 0) {
			$directory .= DS . $ymDir;
		}
		else {
			$ymDir = '';
		}

		$dirs = $this->_fileManager->scanDir($directory);
		$dirs = array_reverse($dirs);
		foreach ($dirs as $filePath) {
			$dirName = pathinfo($filePath, PATHINFO_BASENAME);
			$fileCount = count($this->_fileManager->scanDir($filePath));

			$data[] = array(
				'directory' => $ymDir . $dirName,
				'file_count' => $fileCount
			);
		}

		return $data;
	}

	/**
	 * 获取所有的图片文件
	 * @param integer $ymdDir
	 * @return array
	 */
	public function getFiles($ymdDir = 0)
	{
		$data = array();

		if ($ymdDir < 999999) {
			return $data;
		}

		$req = Ap::getRequest();
		$baseUrl = $req->baseUrl;
		$picServer = Cfg::getApp('picture_server');

		$ymdDir = substr($ymdDir, 0, 6) . DS . substr($ymdDir, 6);
		$fileNames = $this->_fileManager->scanDir($this->_directory . DS . $ymdDir);
		$fileNames = array_reverse($fileNames);
		foreach ($fileNames as $fileName) {
			if (!is_file($fileName)) {
				continue;
			}

			$imgStat = $this->imgStat($fileName);

			$directory   = isset($imgStat['directory']) ? $imgStat['directory'] : '';
			$pictureName = isset($imgStat['basename'])  ? $imgStat['basename']  : '';
			$width       = isset($imgStat['width'])     ? $imgStat['width']     : 0;
			$height      = isset($imgStat['height'])    ? $imgStat['height']    : 0;
			$fileSize    = isset($imgStat['filesize'])  ? $imgStat['filesize'] / 1024  : 0;
			$dtCreated   = isset($imgStat['ctime'])     ? date('Y-m-d H:i:s', $imgStat['ctime']) : '';

			$filePath    = $picServer . str_replace('/webroot', '', $baseUrl) . str_replace(array(DIR_ROOT, '\\'), array('', '/'), $fileName);
			$fileSize    = round($fileSize, 2) . 'KB';

			$data[] = array(
				'directory'    => $directory,
				'picture_name' => $pictureName,
				'file_path'    => $filePath,
				'file_size'    => $fileSize,
				'width_height' => $width . '*' . $height,
				'dt_created'   => $dtCreated
			);
		}

		return $data;
	}

	/**
	 * 获取图片详情
	 * @param string $fileName
	 * @return array
	 */
	public function imgStat($fileName)
	{
		$ret = array();

		if (is_file($fileName)) {
			$row1 = pathinfo($fileName);
			$row2 = stat($fileName);
			$row3 = getimagesize($fileName);

			$ret = array(
				'directory' => $row1['dirname'],   // 目录名
				'basename'  => $row1['basename'],  // 文件名+扩展名
				'filename'  => $row1['filename'],  // 文件名
				'extension' => $row1['extension'], // 扩展名
				'filesize'  => $row2['size'],      // 文件大小
				'atime'     => $row2['atime'],     // 上次访问时间
				'mtime'     => $row2['mtime'],     // 上次修改时间
				'ctime'     => $row2['ctime'],     // 上次改变时间
				'width'     => $row3[0],
				'height'    => $row3[1],
				'mime'      => $row3['mime']
			);
		}

		return $ret;
	}

}

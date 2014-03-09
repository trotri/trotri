<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace views\bootstrap\widgets;

/**
 * ViewBuilder class file
 * 视图展示类，基于Bootstrap-v3前端开发框架
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ViewBuilder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package views.bootstrap.widgets
 * @since 1.0
 */
class ViewBuilder extends FormBuilder
{
	/**
	 * (non-PHPdoc)
	 * @see views\bootstrap\widgets.FormBuilder::_init()
	 */
	protected function _init()
	{
		if (isset($this->_tplVars['elements']) && is_array($this->_tplVars['elements'])) {
			$data = array();
			if (isset($this->_tplVars['values']) && is_array($this->_tplVars['values'])) {
				$data = &$this->_tplVars['values'];
			}

			foreach ($this->_tplVars['elements'] as $columnName => &$element) {
				if (isset($element['type']) && strcasecmp($element['type'], 'button') === 0) {
					continue;
				}

				if (isset($element['__object__']) && strcasecmp($element['__object__'], 'ButtonElement') === 0) {
					continue;
				}

				if (isset($element['hint'])) {
					unset($element['hint']);
				}

				$element['required'] = false;
				$element['readonly'] = true;

				if (isset($element['type']) && strcasecmp($element['type'], 'textarea') === 0) {
					continue;
				}

				if (isset($element['__object__']) && strcasecmp($element['__object__'], 'TextareaElement') === 0) {
					continue;
				}

				$element['type'] = 'text';
				$element['__object__'] = 'InputElement';
				if (!isset($data[$columnName])) {
					continue;
				}

				$enumKey = $data[$columnName];
				if (isset($element['options']) && is_array($element['options'])) {
					$enums = $element['options'];
					if (is_array($enumKey)) {
						$enumValues = array();
						foreach ($enumKey as $key) {
							if (isset($enums[$key])) {
								$enumValues[] = $enums[$key];
							}
						}

						$data[$columnName] = implode(', ', $enumValues);
					}
					elseif (isset($enums[$enumKey])) {
						$data[$columnName] = $enums[$enumKey];
					}
				}
			}
		}

		parent::_init();
	}

	/**
	 * (non-PHPdoc)
	 * @see views\bootstrap\widgets.FormBuilder::run()
	 */
	public function run()
	{
		$this->assign('tabs', $this->getTabs());
		parent::run();
	}
}

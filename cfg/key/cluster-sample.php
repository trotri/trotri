<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

return array (
  'auth_administrator' => array (
    'crypt' => '加密密钥',
    'sign' => '签名密钥',
    'expiry' => '加密串有效期，单位：秒',
    'rnd_len' => '随机密钥长度，取值 0-32，数字越大，加密串越长、随机性越大。'
  ),
  'cookie' => array (
    'crypt' => '加密密钥',
    'sign' => '签名密钥',
    'expiry' => '加密串有效期，单位：秒',
    'rnd_len' => '随机密钥长度，取值 0-32，数字越大，加密串越长、随机性越大。'
  )
);

/**
 * 示例：
 * return array (
 *   'auth_administrator' => array (
 *     'crypt' => 'iTrJ8bvSNwpk5Sr9fY3D5c5GhvWFPraW',
 *     'sign' => '9TbFCc83f32jPaBjIm7Qz7geY9EsSRar',
 *     'expiry' => MONTH_IN_SECONDS,
 *     'rnd_len' => 16
 *   ),
 *   'cookie' => array (
 *     'crypt' => '5rfXDIaFhC9LqBhz',
 *     'sign' => 'E7cX4zV7pcffHfZF',
 *     'expiry' => DAY_IN_SECONDS,
 *     'rnd_len' => 8
 *   )
 * );
 */

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
  'auth_programmer' => array (
    'crypt' => 'yEcTvpnuAfcBSSurQifC8LsKecYm9nXf',
    'sign' => 'ZNYstLLG4HJXzISWj4b9XrVRASDMhanA',
    'expiry' => MONTH_IN_SECONDS,
    'rnd_len' => 16
  ),
  'auth_passport' => array (
    'crypt' => 'UViRN53uj7yZ5IAfdIGiq5bvRuCH9njd',
    'sign' => 'xwFVMiM98nzW6PwW9jxCmT2mLTv5IJES',
    'expiry' => MONTH_IN_SECONDS,
    'rnd_len' => 20
  ),
  'auth_administrator' => array (
    'crypt' => 'iTrJ8bvSNwpk5Sr9fY3D5c5GhvWFPraW',
    'sign' => '9TbFCc83f32jPaBjIm7Qz7geY9EsSRar',
    'expiry' => MONTH_IN_SECONDS,
    'rnd_len' => 12
  ),
  'cookie' => array (
    'crypt' => '5rfXDIaFhC9LqBhz',
    'sign' => 'E7cX4zV7pcffHfZF',
    'expiry' => DAY_IN_SECONDS,
    'rnd_len' => 8
  )
);

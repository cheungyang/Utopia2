#!/usr/bin/env php
<?php
/* PHPUnit
 *
 * Copyright (c) 2002-2009, Sebastian Bergmann <sb@sebastian-bergmann.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 * 
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Sebastian Bergmann nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRIC
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * $Id: phpunit.php 4572 2009-01-28 07:37:41Z sb $
 */

$filename = realpath(dirname(__FILE__).'/../../../libs/main/Config/SettingFactory.php');
if ($filename === false)
{
	throw new Exception('failed getting SettingFactory', ERROR_FILE_NOT_FOUND);
}
require_once($filename);
$settings = SettingFactory::getSettings(array('env'=>'alpha', 'property'=>'MALLOCWORKS'));


//if (strpos('@php_bin@', '@php_bin') === 0) {
//    set_include_path(dirname(__FILE__) . PATH_SEPARATOR . get_include_path());
//}

require_once DIR_LIB_ROOT. 'vendor/PHPUnit/PHPUnit/Util/Filter.php';
PHPUnit_Util_Filter::addFileToFilter(__FILE__, 'PHPUNIT');

require DIR_LIB_ROOT. 'vendor/PHPUnit/PHPUnit/TextUI/Command.php';
define('PHPUnit_MAIN_METHOD', 'PHPUnit_TextUI_Command::main');
PHPUnit_TextUI_Command::main();
?>

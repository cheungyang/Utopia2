<?php
//define('DIR_UTOPIA_BASE'			, 'd:/xampp/htdocs/utopia/');
//define('DIR_UTOPIA_BASE'			, '/home/ycheung/source/utopia/'); 
define('DIR_UTOPIA_BASE'			, '/home/utopia/source/');

//define('WEB_UTOPIA_BASE'			, 'http://localhost/utopia/');
define('WEB_UTOPIA_BASE'			, 'http://localhost/source/');

//---------------------------------------------------------------------------

define('DIR_LIB_ROOT'				, DIR_UTOPIA_BASE. 'libs/'); 
define('DIR_CONF_ROOT'				, DIR_UTOPIA_BASE. 'conf/');
define('DIR_APP_ROOT'				, DIR_UTOPIA_BASE. 'apps/');
define('DIR_MODULE_ROOT'			, DIR_UTOPIA_BASE. 'modules/');
define('DIR_CACHE_ROOT'				, DIR_UTOPIA_BASE. 'cache/');
define('DIR_WEB_ROOT'				, DIR_UTOPIA_BASE. 'web/');

define('WEB_CSS_ROOT'				, WEB_UTOPIA_BASE. 'css/');
define('WEB_FILES_ROOT'				, WEB_UTOPIA_BASE. 'files/');
define('WEB_JS_ROOT'				, WEB_UTOPIA_BASE. 'js/');

define('FAIL'						, 0);
define('SUCCESS'					, 1);

define('NAME_ENTITY'				, 'ENTITY');
define('NAME_CULTS'					, 'ZH, EN, CH, NONE' ); //space is needed to be parsed by yml
define('NAME_DEFAULT_CULT'			, 'NONE' );
define('NAME_RELATIONSHIPS'			, 'MAP, OWN, REQUEST, INVITE, CONNECT' );
define('NAME_DEFAULT_REL'			, 'OWN' );
define('NAME_PROPERTIES'			, 'MALLOCWORKS, WILGRIST' );

define('ERROR_REQUIRED_MISSING'		, 3000);
define('ERROR_NOT_IMPLEMENTED'		, 3001);
define('ERROR_CLASS_NOT_EXIST'		, 3002);
define('ERROR_EMPTY_RESULT'			, 3003);
define('ERROR_VAR_NOT_FOUND'		, 3004);
define('ERROR_CONFIG_RETURN_FALSE'	, 3005);
define('ERROR_MULTIPLE_RESULTS'		, 3006);
define('ERROR_NOT_VERSIONABLE'		, 3007);
define('ERROR_NOT_CHAINABLE'		, 3008);
define('ERROR_NOT_TRANSLATEABLE'	, 3009);
define('ERROR_RETURN_PROBLEM'		, 3010);
define('ERROR_RECORD_EXISTS'		, 3011);
define('ERROR_TYPE_MISMATCH'		, 3012);
define('ERROR_VALIDATION'			, 3013);
define('ERROR_INSUFFICIENT_PARAMS'	, 3014);
define('ERROR_FILE_NOT_FOUND'		, 3015);
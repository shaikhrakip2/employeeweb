<?php

define('BASE_PATH', 'http://localhost/radiant/');
define('DOC_PATH', dirname(__DIR__) . '/');

define('ONLINESTATUS', false);

if (!ONLINESTATUS) {
	define('PREFIX1', BASE_PATH . 'public/');
	define('UPLOADFILES', 'public/uploads/');
	define('ASSETS', BASE_PATH . 'public/assets/');
} else {
	define('PREFIX1', BASE_PATH);
	define('UPLOADFILES', 'uploads/');
	define('ASSETS', BASE_PATH . 'assets/');
}

define('DASHBOARD', BASE_PATH . 'dashboard');

//Design Source File Paths
define('CSS', PREFIX1 . 'css/');
define('JS', PREFIX1 . 'js/');
define('IMAGES', PREFIX1 . 'images/');
define('VENDOR', BASE_PATH . 'vendor/');


//Define Constant for Room Inquiry
define('BANNER_TYPE', array('1' => 'Banner', '2' => 'Promotions Banner'));
define('CURRENCY_SYMBOL', '₹');

define('CARD_COLOR',array(
	'1'=> 'rgba(201, 71, 57, 0.5)',
	'2'=> 'rgba(212, 129, 63, 0.5)',
	'3'=> 'rgba(88, 62, 114, 0.5)',
	'4'=> 'rgba(85, 161, 133, 0.7)',
));

define('CARD_COLOR_TEXT',array(
	'1'=> '#FDECEA',
	'2'=> '#FEEBDC',
	'3'=> '#F6EEFF',
	'4'=> '#EFFFF9',
));

define('CARD_COLOR_FOOTER',array(
	'1'=> '#C94739',
	'2'=> '#D4813F',
	'3'=> '#583E72',
	'4'=> '#55A185',
));

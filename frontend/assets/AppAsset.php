<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
		'css/style.css',
		'css/fasthover.css',
		'css/flexslider.css',
		'css/jquery.countdown.css',
		'css/popuo-box.css',
		'css/font-awesome.min.css',
		'css/prettyPhoto.css',
		'css/price-range.css',
		'css/animate.css',
		'css/main.css',
		'css/responsive.css',
	];
	
    public $js = [
		'js/easyResponsiveTabs.js',
		'js/imagezoom.js',
		'js/jquery.magnific-popup.js',
		'js/jquery.wmuSlider.js',
		'js/bootstrap-3.1.1.min.js',
		'js/minicart.js',
		'js/jquery.js',
		'js/jquery.flexisel.js',
		'js/jquery.flexslider.js',
		'js/jquery.scrollUp.min.js',
		'js/price-range.js',
		'js/jquery.prettyPhoto.js',
		'js/main.js',
		'js/jquery.countdown.js',
	    'js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
	];
	public $jsOptions = array(
		'position' => \yii\web\View::POS_HEAD
	);
}

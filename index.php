<?php
/*
Plugin Name: Banner
Plugin URI: http://amfearliath.tk/osclass-banner
Description: Show banners on frontpage 
Version: 1.0.0
Author: Liath
Author URI: http://amfearliath.tk
Short Name: banner
Plugin update URI: banner
*/

require_once('classes/class.banner.php');

$banner = new banner;

function _admin_page_header() {   
    echo '<h1>'.__('Banner Managment', 'banner').'</h1>';    
}

/*
    FUNCTIONS
*/
function _install() {
    banner::_install();
}

function _uninstall() {
    banner::_uninstall();
}

function _style() {
    $banner = new banner;
    osc_enqueue_style('banner-styles', osc_plugin_url('banner/assets/css/banner.css').'banner.css');
    osc_enqueue_style('banner-iview', osc_plugin_url('banner/assets/css/iview.css').'iview.css');
    osc_enqueue_style('banner-bannerstyle', osc_plugin_url('banner/assets/css/responsive/style.css').'style.css');
    echo '
    <style>
    .banner_container .horizontal .iviewSlider {
        width: '.(!empty($banner->newInstance()->_get('slideWidthHorizontal')) ? $banner->newInstance()->_get('slideWidthHorizontal') : '1170').'px;
        height: '.(!empty($banner->newInstance()->_get('slideHeightHorizontal')) ? $banner->newInstance()->_get('slideHeightHorizontal') : '160').'px;
    }
    .banner_container .vertical .iviewSlider {
        width: '.(!empty($banner->newInstance()->_get('slideWidthVertical')) ? $banner->newInstance()->_get('slideWidthVertical') : '200').'px;
        height: '.(!empty($banner->newInstance()->_get('slideHeightVertical')) ? $banner->newInstance()->_get('slideHeightVertical') : '760').'px;
    }
    </style>';
}

function _style_admin() {
    $params = Params::getParamsAsArray();    
    if (isset($params['file'])) {
        $plugin = explode("/", $params['file']);
        if ($plugin[0] == 'banner') {
    
            osc_enqueue_style('banner-styles_admin', osc_plugin_url('banner/assets/css/admin.css').'admin.css');
            osc_register_script('banner-admin', osc_plugin_url('banner/assets/js/admin.js') . 'admin.js', array('jquery'));
            osc_enqueue_script('banner-admin');
    
            osc_enqueue_style('banner-styles_bootstrap', osc_plugin_url('banner/assets/css/bootstrap.min.css').'bootstrap.min.css');
            osc_enqueue_style('banner-styles_fontawesome', osc_plugin_url('banner/assets/css/font-awesome.min.css').'font-awesome.min.css');
            
            osc_register_script('banner-bootstrap', osc_plugin_url('banner/assets/js/bootstrap.min.js') . 'bootstrap.min.js', array('jquery'));
            osc_enqueue_script('banner-bootstrap');
            
            osc_add_hook('admin_page_header','_admin_page_header');
            osc_remove_hook('admin_page_header', 'customPageHeader');    
        }    
    }    
}

function _configuration() {
    osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/admin/config.php');
}

if (osc_version() < 311) {
    echo '<script type="text/javascript" src="'.osc_plugin_url('banner/assets/js/banner.js').'banner.js"></script>';
    echo '<script type="text/javascript" src="'.osc_plugin_url('banner/assets/js/iview.js').'iview.js"></script>';
    echo '<script type="text/javascript" src="'.osc_plugin_url('banner/assets/js/jquery.easing.js').'jquery.easing.js"></script>';
    echo '<script type="text/javascript" src="'.osc_plugin_url('banner/assets/js/raphael-min.js').'raphael-min.js"></script>';
    
    osc_add_hook('admin_menu', '_admin_menu');
} else {
    osc_register_script('banner-script', osc_plugin_url('banner/assets/js/banner.js') . 'banner.js', array('jquery'));
    osc_enqueue_script('banner-script');
    osc_register_script('banner-iview', osc_plugin_url('banner/assets/js/iview.js') . 'iview.js', array('jquery'));
    osc_enqueue_script('banner-iview');
    osc_register_script('banner-easing', osc_plugin_url('banner/assets/js/jquery.easing.js') . 'jquery.easing.js', array('jquery'));
    osc_enqueue_script('banner-easing');
    osc_register_script('banner-raphael', osc_plugin_url('banner/assets/js/raphael-min.js') . 'raphael-min.js', array('jquery'));
    osc_enqueue_script('banner-raphael');
    
    osc_add_hook('admin_menu_init', '_admin_menu_init');
}

function _admin_menu_init() {
    banner::_admin_menu_draw();
}

function _admin_menu() {
    banner::_admin_menu();
}
    
osc_register_plugin(osc_plugin_path(__FILE__), '_install');

function _init() {
    if (!osc_is_moderator()) {
        banner::_admin_menu_draw();    
    }
}

/*
    HOOKS
*/

//Plugin un/installation and configuration
osc_add_hook('header', '_style');
osc_add_hook('admin_header', '_style_admin');
osc_add_hook('add_admin_toolbar_menus', 'banner', 1);
osc_add_hook('init_admin', '_init');
    
osc_add_hook(osc_plugin_path(__FILE__) . '_configure', '_configuration');
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', '_uninstall');

//Add Seller details on account page
osc_add_hook('account_menu','_account_menu');

//Add Order button on item page
osc_add_hook('banner_button', '_order_button');

function loadBanner($pos) {             
    $banner = new banner;
    echo $banner->loadHooks($pos);    
}
       
foreach ($banner->bannerPositions() as $k => $v) {
    if ($v != 'all') {
        osc_add_hook('banner_'.$v, 'loadBanner');
    }
}
?>

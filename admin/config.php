<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/oc-load.php');

$banner = new banner;
$file = 'config_banners';

if (Params::getParam('include')) {
    $file = Params::getParam('include');
} elseif (Params::getParam('banner_save')) {
    $banner->_saveSlide(Params::getParamsAsArray());       
} elseif (Params::getParam('banner_edit')) {
    $banner->_updateSlide(Params::getParamsAsArray());       
} elseif (Params::getParam('slide')) {
    $slides = Params::getParam('slide');
    if (is_array($slides)) {
        $position = Params::getParam('position');
        foreach($slides as $k => $v) {
            $banner->dao->update($banner->_table_banner, array('i_priority' => $k+1, 's_position' => $position), array('pk_i_id' => $v));    
        }            
    }       
} elseif (Params::getParam('editSlide')) {
    $edit = $banner->_getSlide(Params::getParam('editSlide'));       
} elseif (Params::getParam('deleteSlide')) {
    $banner->_deleteSlide(Params::getParam('deleteSlide'));       
} elseif (Params::getParam('settings_save')) {
    $file = 'config_settings';
    $banner->_saveSettings(Params::getParamsAsArray());       
} elseif (Params::getParam('position_save')) {
    $file = 'config_positions';
    $banner->_savePositions(Params::getParamsAsArray());       
} elseif (Params::getParam('editPosition')) {
    $file = 'config_positions';
    $edit = $banner->_getPositions(Params::getParam("editPosition"));       
} elseif (Params::getParam('deletePosition')) {
    $file = 'config_positions';
    $banner->_deletePosition(Params::getParam('deletePosition'));       
}

$link = osc_admin_render_plugin_url(dirname(osc_plugin_folder(__FILE__)).'/admin/config.php?include=');
?>
<style>
#header {
    border-radius: 0;
}
#content-head {
    border-bottom: solid 1px #ddd;
    background-color: #f3f3f3;
    padding: 24px 30px;
    height: 80px;
}
.circle {
    padding-top: 0 !important;
    margin-top: 0 !important;
}
</style>
<div class="banners">
    <div class="col-xs-3">
        <div class="inner-box">
            <h4 class="menu-title">Settings</h4>
            <ul class="menu-list">
                <li<?php if ($file == 'config_banners') echo ' class="active"'; ?>>
                    <a href="<?php echo $link.'config_banners'; ?>" data-file="<?php echo dirname(osc_plugin_url(__FILE__)).'/admin/config_banners.php'; ?>"><i class="fa fa-database"></i> Banner</a>
                </li>
                <li<?php if ($file == 'config_positions') echo ' class="active"'; ?>>
                    <a href="<?php echo $link.'config_positions'; ?>" data-file="<?php echo dirname(osc_plugin_url(__FILE__)).'/admin/config_positions.php'; ?>"><i class="fa fa-random"></i> Positionen</a>
                </li>
                <li<?php if ($file == 'config_settings') echo ' class="active"'; ?>>
                    <a href="<?php echo $link.'config_settings'; ?>" data-file="<?php echo dirname(osc_plugin_url(__FILE__)).'/admin/config_settings.php'; ?>"><i class="fa fa-cog"></i> Einstellungen</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-xs-9">
        <div class="inner-box">
            <div id="ps_settings_content">
                <?php require_once(dirname(__FILE__).'/'.$file.'.php'); ?>
            </div>
        </div>
    </div>
</div>
<?php
    
$banner = new banner; $easings = '';    
$captioneasing = $banner->newInstance()->_get('captionEasing');
$slideeasing = $banner->newInstance()->_get('easing');
$slidefx = $banner->newInstance()->_get('fx');
    
foreach($banner->easing() as $k) {
    $selected = '';    
    if (!empty($slideeasing) && $k == $slideeasing) { $selected = ' selected="selected"'; }
    $slideeasings .= '<option value="'.$k.'"'.$selected.'>'.$k.'</option>';
}
foreach($banner->slideEffects() as $k) {
    $selected = '';    
    if (!empty($slidefx) && $k == $slidefx) { $selected = ' selected="selected"'; }
    $slidesfx .= '<option value="'.$k.'"'.$selected.'>'.$k.'</option>';
}
foreach($banner->easing() as $k) {
    $selected = '';    
    if (!empty($captioneasing) && $k == $captioneasing) { $selected = ' selected="selected"'; }
    $captioneasings .= '<option value="'.$k.'"'.$selected.'>'.$k.'</option>';
}    
?>
<div id="banners">
    <div class="widget-title">
        <h3><?php echo __('Settings', 'banner'); ?></h3>
        <div class="clearfix"></div>
        <small><?php echo __('Here you can setup the standard settings for the slider. Some of this settings can be overwritten in the single slides.', 'banner'); ?></small>
    </div>
    <div id="banner_settings">
        <form name="saveSettings" action="<?php echo osc_admin_render_plugin_url().'banner/admin/config.php'; ?>" method="post">
            <input type="hidden" name="settings_save" value="true" />
            
            <div class="form-group col-md-6 no-padding">
                <h4 style="margin-left: 15px;"><i class="fa fa-exclamation-circle info" title="Define here the dimensions of the slides"></i> Horizontal Dimensions</h4>
                <div class="form-group col-md-6">
                    <label for="slideWidthHorizontal">Width <i class="fa fa-question-circle help" title="Define the width that should the slides have"></i></label>
                    <input type="text" class="form-control" name="slideWidthHorizontal" value="<?php echo (!empty($banner->newInstance()->_get('slideWidthHorizontal')) ? $banner->newInstance()->_get('slideWidthHorizontal') : ''); ?>" placeholder="1170" />
                </div>
                
                <div class="form-group col-md-6">
                    <label for="slideHeightHorizontal">Height <i class="fa fa-question-circle help" title="Define the height that should the slides have"></i></label>
                    <input type="text" class="form-control" name="slideHeightHorizontal" value="<?php echo (!empty($banner->newInstance()->_get('slideHeightHorizontal')) ? $banner->newInstance()->_get('slideHeightHorizontal') : ''); ?>" placeholder="150" />
                </div>
            </div>
            
            <div class="form-group col-md-6 no-padding">
                <h4 style="margin-left: 15px;"><i class="fa fa-exclamation-circle info" title="Define here the dimensions of the slides"></i> Vertical Dimensions</h4>
                <div class="form-group col-md-6">
                    <label for="slideWidthVertical">Width <i class="fa fa-question-circle help" title="Define the width that should the slides have"></i></label>
                    <input type="text" class="form-control" name="slideWidthVertical" value="<?php echo (!empty($banner->newInstance()->_get('slideWidthVertical')) ? $banner->newInstance()->_get('slideWidthVertical') : ''); ?>" placeholder="200" />
                </div>
                
                <div class="form-group col-md-6">
                    <label for="slideHeightVertical">Height <i class="fa fa-question-circle help" title="Define the height that should the slides have"></i></label>
                    <input type="text" class="form-control" name="slideHeightVertical" value="<?php echo (!empty($banner->newInstance()->_get('slideHeightVertical')) ? $banner->newInstance()->_get('slideHeightVertical') : ''); ?>" placeholder="750" />
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="form-group col-md-6 no-padding">
                <h4 style="margin-left: 15px;"><i class="fa fa-exclamation-circle info" title="Define here the standard animations for the slides"></i> Standard Animations</h4>
                <div class="form-group col-md-6">
                    <label for="fx">Slide FX <i class="fa fa-question-circle help" title="Define the standard animation"></i></label>
                    <select name="fx" class="form-control">
                        <?php echo $slidesfx; ?>
                    </select>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="easing">Slide easing <i class="fa fa-question-circle help" title="Define the standard easing"></i></label>
                    <select name="easing" class="form-control">
                        <?php echo $slideeasings; ?>
                    </select>
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="form-group col-md-12 no-padding">
                <h4 style="margin-left: 15px;"><i class="fa fa-exclamation-circle info" title="This settings can be override in the slide settings"></i> Standard Settings</h4>
                <div class="form-group col-md-3">
                    <label for="captionSpeed">Caption speed (in ms)<i class="fa fa-question-circle help" title="Define the transition speed of the captions"></i></label>
                    <input type="text" class="form-control" name="captionSpeed" value="<?php echo (!empty($banner->newInstance()->_get('captionSpeed')) ? $banner->newInstance()->_get('captionSpeed') : ''); ?>" placeholder="700" />
                </div>
                
                <div class="form-group col-md-3">
                    <label for="captionOpacity">Caption opacity <i class="fa fa-question-circle help" title="Define opacity of the caption background"></i></label>
                    <input type="text" class="form-control" name="captionOpacity" value="<?php echo (!empty($banner->newInstance()->_get('captionOpacity')) ? $banner->newInstance()->_get('captionOpacity') : ''); ?>" placeholder="0.6" />
                </div>
                
                <div class="form-group col-md-6">
                    <label for="captionEasing">Caption easing <i class="fa fa-question-circle help" title="Define the easing with that the caption appear"></i></label>
                    <select name="captionEasing" class="form-control">
                        <?php echo $captioneasings; ?>
                    </select>
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="form-group col-md-12 no-padding">
                <div class="form-group col-md-3">
                    <label for="animationSpeed">Animation speed (in ms)<i class="fa fa-question-circle help" title="Define the animation speed of the slides"></i></label>
                    <input type="text" class="form-control" name="animationSpeed" value="<?php echo (!empty($banner->newInstance()->_get('animationSpeed')) ? $banner->newInstance()->_get('animationSpeed') : ''); ?>" placeholder="700" />
                </div>
                
                <div class="form-group col-md-3">
                    <label for="pauseTime">Pause time (in ms)<i class="fa fa-question-circle help" title="Define the time, how long the slides will appear"></i></label>
                    <input type="text" class="form-control" name="pauseTime" value="<?php echo (!empty($banner->newInstance()->_get('pauseTime')) ? $banner->newInstance()->_get('pauseTime') : ''); ?>" placeholder="8000" />
                </div>
                
                <div class="form-group col-md-3">
                    <label for="autoAdvance">Auto advance <i class="fa fa-question-circle help" title="Should the slides start automatically"></i></label>
                    <select name="autoAdvance" class="form-control">
                        <option value="true"<?php echo ($banner->newInstance()->_get('pauseTime') == 'true' ? ' selected="selected"' : ''); ?>>Yes</option>
                        <option value="false"<?php echo ($banner->newInstance()->_get('pauseTime') == 'false' ? ' selected="selected"' : ''); ?>>No</option>
                    </select>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="pauseOnHover">Pause on Hover <i class="fa fa-question-circle help" title="Should the animations stop on hover"></i></label>
                    <select name="pauseOnHover" class="form-control">
                        <option value="true"<?php echo ($banner->newInstance()->_get('pauseOnHover') == 'true' ? ' selected="selected"' : ''); ?>>Yes</option>
                        <option value="false"<?php echo ($banner->newInstance()->_get('pauseOnHover') == 'false' ? ' selected="selected"' : ''); ?>>No</option>
                    </select>
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="form-group col-md-12 no-padding">
                <div class="form-group col-md-3">
                    <label for="controlNav">Pagination<i class="fa fa-question-circle help" title="Should the pagination be shown"></i></label>
                    <select name="controlNav" class="form-control">
                        <option value="true"<?php echo ($banner->newInstance()->_get('controlNav') == 'true' ? ' selected="selected"' : ''); ?>>Yes</option>
                        <option value="false"<?php echo ($banner->newInstance()->_get('controlNav') == 'false' ? ' selected="selected"' : ''); ?>>No</option>
                    </select>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="controlNavNextPrev">Navigation<i class="fa fa-question-circle help" title="Should the navigation buttons be shown"></i></label>
                    <select name="controlNavNextPrev" class="form-control">
                        <option value="true"<?php echo ($banner->newInstance()->_get('controlNavNextPrev') == 'true' ? ' selected="selected"' : ''); ?>>Yes</option>
                        <option value="false"<?php echo ($banner->newInstance()->_get('controlNavNextPrev') == 'false' ? ' selected="selected"' : ''); ?>>No</option>
                    </select>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="keyboardNav">Keyboard navigation <i class="fa fa-question-circle help" title="Activate the keyboard navigation"></i></label>
                    <select name="keyboardNav" class="form-control">
                        <option value="true"<?php echo ($banner->newInstance()->_get('keyboardNav') == 'true' ? ' selected="selected"' : ''); ?>>Yes</option>
                        <option value="false"<?php echo ($banner->newInstance()->_get('keyboardNav') == 'false' ? ' selected="selected"' : ''); ?>>No</option>
                    </select>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="touchNav">Touch navigation <i class="fa fa-question-circle help" title="Activate the touch navigation"></i></label>
                    <select name="touchNav" class="form-control">
                        <option value="true"<?php echo ($banner->newInstance()->_get('touchNav') == 'true' ? ' selected="selected"' : ''); ?>>Yes</option>
                        <option value="false"<?php echo ($banner->newInstance()->_get('touchNav') == 'false' ? ' selected="selected"' : ''); ?>>No</option>
                    </select>
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="form-group col-md-12 no-padding">
                
                <div class="form-group col-md-3">
                    <label for="controlNavThumbs">Thumb navigation <i class="fa fa-question-circle help" title="Should the navigation thumbnails be shown"></i></label>
                    <select name="controlNavThumbs" class="form-control">
                        <option value="true"<?php echo ($banner->newInstance()->_get('controlNavThumbs') == 'true' ? ' selected="selected"' : ''); ?>>Yes</option>
                        <option value="false"<?php echo ($banner->newInstance()->_get('controlNavThumbs') == 'false' ? ' selected="selected"' : ''); ?>>No</option>
                    </select>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="controlNavTooltip">Tooltip preview <i class="fa fa-question-circle help" title="Should the tooltip image previes be shown"></i></label>
                    <select name="controlNavTooltip" class="form-control">
                        <option value="true"<?php echo ($banner->newInstance()->_get('controlNavTooltip') == 'true' ? ' selected="selected"' : ''); ?>>Yes</option>
                        <option value="false"<?php echo ($banner->newInstance()->_get('controlNavTooltip') == 'false' ? ' selected="selected"' : ''); ?>>No</option>
                    </select>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="tooltipX">Tooltip X-Pos<i class="fa fa-question-circle help" title="X-Position of tooltip"></i></label>
                    <input type="text" class="form-control" name="tooltipX" value="<?php echo (!empty($banner->newInstance()->_get('tooltipX')) ? $banner->newInstance()->_get('tooltipX') : ''); ?>" placeholder="5" />
                </div>
                
                <div class="form-group col-md-3">
                    <label for="tooltipY">Tooltip Y-Pos<i class="fa fa-question-circle help" title="Y-Position of tooltip"></i></label>
                    <input type="text" class="form-control" name="tooltipY" value="<?php echo (!empty($banner->newInstance()->_get('tooltipY')) ? $banner->newInstance()->_get('tooltipY') : ''); ?>" placeholder="5" />
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="form-group col-md-12 no-padding">
                <h4 style="margin-left: 15px;"><i class="fa fa-exclamation-circle info" title="This settings defines how the timer appears on the slides"></i> Timer</h4>
                <div class="form-group col-md-3">
                    <label for="timer">Timer<i class="fa fa-question-circle help" title="Should the pagination be shown"></i></label>
                    <select name="timer" class="form-control">
                        <option value="none"<?php echo ($banner->newInstance()->_get('timer') == 'none' ? ' selected="selected"' : ''); ?>>None</option>
                        <option value="Bar"<?php echo ($banner->newInstance()->_get('timer') == 'Bar' ? ' selected="selected"' : ''); ?>>Bar</option>
                        <option value="360Bar"<?php echo ($banner->newInstance()->_get('timer') == '360Bar' ? ' selected="selected"' : ''); ?>>360Bar</option>
                        <option value="Pie"<?php echo ($banner->newInstance()->_get('timer') == 'Pie' ? ' selected="selected"' : ''); ?>>Pie</option>
                    </select>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="timerBg">Timer background<i class="fa fa-question-circle help" title="Background of the timer"></i></label>
                    <input type="text" class="form-control" name="timerBg" value="<?php echo (!empty($banner->newInstance()->_get('timerBg')) ? $banner->newInstance()->_get('timerBg') : ''); ?>" placeholder="#000" />
                </div>
                
                <div class="form-group col-md-3">
                    <label for="timerColor">Timer color <i class="fa fa-question-circle help" title="Color of the timer"></i></label>
                    <input type="text" class="form-control" name="timerColor" value="<?php echo (!empty($banner->newInstance()->_get('timerColor')) ? $banner->newInstance()->_get('timerColor') : ''); ?>" placeholder="#fff" />
                </div>
                
                <div class="form-group col-md-3">
                    <label for="timerOpacity">Timer opacity <i class="fa fa-question-circle help" title="Opacity of the timer"></i></label>
                    <input type="text" class="form-control" name="timerOpacity" value="<?php echo (!empty($banner->newInstance()->_get('timerOpacity')) ? $banner->newInstance()->_get('timerOpacity') : ''); ?>" placeholder="0.5" />
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="form-group col-md-12 no-padding">
                <div class="form-group col-md-3">
                    <label for="timerDiameter">Timer diameter<i class="fa fa-question-circle help" title="Should the pagination be shown"></i></label>
                    <input type="text" class="form-control" name="timerDiameter" value="<?php echo (!empty($banner->newInstance()->_get('timerDiameter')) ? $banner->newInstance()->_get('timerDiameter') : ''); ?>" placeholder="30" />
                </div>
                
                <div class="form-group col-md-3">
                    <label for="timerPadding">Timer padding<i class="fa fa-question-circle help" title="Padding of the timer"></i></label>
                    <input type="text" class="form-control" name="timerPadding" value="<?php echo (!empty($banner->newInstance()->_get('timerPadding')) ? $banner->newInstance()->_get('timerPadding') : ''); ?>" placeholder="4" />
                </div>
                
                <div class="form-group col-md-3">
                    <label for="timerStroke">Timer stroke <i class="fa fa-question-circle help" title="Timer stroke width"></i></label>
                    <input type="text" class="form-control" name="timerStroke" value="<?php echo (!empty($banner->newInstance()->_get('timerStroke')) ? $banner->newInstance()->_get('timerStroke') : ''); ?>" placeholder="3" />
                </div>
                
                <div class="form-group col-md-3">
                    <label for="timerBarStroke">Timer bar stroke <i class="fa fa-question-circle help" title="Timer bar stroke width"></i></label>
                    <input type="text" class="form-control" name="timerBarStroke" value="<?php echo (!empty($banner->newInstance()->_get('timerBarStroke')) ? $banner->newInstance()->_get('timerBarStroke') : ''); ?>" placeholder="1" />
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="form-group col-md-12 no-padding">
                <div class="form-group col-md-3">
                    <label for="timerBarStrokeColor">Timer bar stroke color<i class="fa fa-question-circle help" title="Timer bar stroke color"></i></label>
                    <input type="text" class="form-control" name="timerBarStrokeColor" value="<?php echo (!empty($banner->newInstance()->_get('timerBarStrokeColor')) ? $banner->newInstance()->_get('timerBarStrokeColor') : ''); ?>" placeholder="#eee" />
                </div>
                
                <div class="form-group col-md-3">
                    <label for="timerBarStrokeStyle">Timer border<i class="fa fa-question-circle help" title="Padding of the timer"></i></label>
                    <select name="timerBarStrokeStyle" class="form-control">
                        <option value="solid"<?php echo ($banner->newInstance()->_get('timerBarStrokeStyle') == 'solid' ? ' selected="selected"' : ''); ?>>solid</option>
                        <option value="dashed"<?php echo ($banner->newInstance()->_get('timerBarStrokeStyle') == 'dashed' ? ' selected="selected"' : ''); ?>>dashed</option>
                        <option value="dotted"<?php echo ($banner->newInstance()->_get('timerBarStrokeStyle') == 'dotted' ? ' selected="selected"' : ''); ?>>dotted</option>
                        <option value="double"<?php echo ($banner->newInstance()->_get('timerBarStrokeStyle') == 'double' ? ' selected="selected"' : ''); ?>>double</option>
                        <option value="groove"<?php echo ($banner->newInstance()->_get('timerBarStrokeStyle') == 'groove' ? ' selected="selected"' : ''); ?>>groove</option>
                        <option value="outset"<?php echo ($banner->newInstance()->_get('timerBarStrokeStyle') == 'outset' ? ' selected="selected"' : ''); ?>>outset</option>
                        <option value="ridge"<?php echo ($banner->newInstance()->_get('timerBarStrokeStyle') == 'ridge' ? ' selected="selected"' : ''); ?>>ridge</option>
                    </select>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="timerX">Timer X position <i class="fa fa-question-circle help" title="X-Position where the timer should appear"></i></label>
                    <input type="text" class="form-control" name="timerX" value="<?php echo (!empty($banner->newInstance()->_get('timerX')) ? $banner->newInstance()->_get('timerX') : ''); ?>" placeholder="10" />
                </div>
                
                <div class="form-group col-md-3">
                    <label for="timerY">Timer Y position <i class="fa fa-question-circle help" title="Y-Position where the timer should appear"></i></label>
                    <input type="text" class="form-control" name="timerY" value="<?php echo (!empty($banner->newInstance()->_get('timerY')) ? $banner->newInstance()->_get('timerY') : ''); ?>" placeholder="10" />
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <button type="submit" class="btn btn-info" style="float: right;">Save</button>
            
            <div class="clearfix"></div>
            
        </form>
    </div>
</div>
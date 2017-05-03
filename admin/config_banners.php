<?php
$banner = new banner; $pos = ''; $sli = ''; $cap = ''; $slides = ''; $settings = NULL;

if (isset($edit) && is_array($edit)) {
    $settings = unserialize($edit['s_settings']);
    $edit_id = '<input type="hidden" name="banner_edit" value="'.$edit['pk_i_id'].'" />';
}

foreach($banner->bannerPositions() as $k => $v) {
    
    $slide = $banner->_slides($v); $selected = '';
    if (isset($edit) && $v == $edit['s_position']) { $selected = ' selected="selected"'; }
    $pos .= '<option value="'.$v.'"'.$selected.'>'.$k.'</option>';
    
    if (!empty($slide)) {
        $slides .= '
            <div class="sliderTab">
                <a class="openTab" data-id="'.$v.'">
                    <h3>'.$k.'</h3>
                    <i class="fa fa-chevron-down"></i>
                </a>
                <div class="clearfix"></div>
                <ul id="tab_'.$v.'">
                    <li class="tableHeader">
                        <ul>
                            <li class="slideMove"></li>
                            <li class="slidePosition">Position</li>
                            <li class="slideID">ID</li>
                            <li class="slidePriority">Priority</li>
                            <li class="slideImage">Image</li>
                            <li class="slideTools"></li>
                        </ul>
                    </li>
                    <li class="tableContent" id="sortable" data-position="'.$v.'">';
            
        foreach($slide as $sk => $sv) {
            $data = unserialize($sv['s_settings']);
            $posi = $sk+1;    
            $slides .= '
                        <ul id="slide-'.$sv['pk_i_id'].'" data-id="'.$sv['pk_i_id'].'" data-position="'.$sv['s_position'].'">
                            <li class="slideMove"><i class="fa fa-arrows"></i></li>
                            <li class="slidePosition">'.$sv['s_position'].'</li>
                            <li class="slideID">'.$sv['pk_i_id'].'</li>
                            <li class="slidePriority">'.$posi.'</li>
                            <li class="slideImage"><img src="'.osc_base_url().'oc-content/banners/thumb_'.$data['image'].'" style="height: 50px;" /></li>
                            <li class="slideTools">
                                <i class="fa fa-edit btn-info edit-slide" data-id="'.$sv['pk_i_id'].'"></i>
                                <i class="fa fa-times btn-danger delete-slide" data-id="'.$sv['pk_i_id'].'"></i>
                            </li>
                        </ul>';
        }
        $slides .= '
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>';
    }
}
foreach($banner->slideEffects() as $k) {
    $selected = '';
    if (isset($settings) && $k == $settings['slideEffect']) { $selected = ' selected="selected"'; }
    $sli .= '<option value="'.$k.'"'.$selected.'>'.$k.'</option>';
}
foreach($banner->captionEffects() as $k) {
    $selected = '';
    if (isset($settings) && $k == $settings['captionEffect']) { $selected = ' selected="selected"'; }
    $cap .= '<option value="'.$k.'"'.$selected.'>'.$k.'</option>';
}
   
?>
<div id="banners">
    <div class="widget-title">
        <h3><?php echo __('Banner', 'banner'); ?></h3>
        <button class="btn btn-info add"><i class="fa fa-plus"></i></button>
        <div class="clearfix"></div>
    </div>
    <div id="banner_add" style="display: none;">
        <form name="saveSlide" action="<?php echo osc_admin_render_plugin_url().'banner/admin/config.php'; ?>" method="post" enctype="multipart/form-data">
            
            <?php echo (isset($edit_id) ? $edit_id : '<input type="hidden" name="banner_save" value="true" />'); ?>
            
            <h4 style="margin-left: 15px;">Slides</h4>
            
            <div class="form-group col-md-3">
                <label for="os_categorie">Select Position <i class="fa fa-question-circle help" title="Define on which position this banner should appear"></i></label>
                <select name="bannerPosition" class="form-control">
                    <?php echo $pos; ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="priority">Enter priority (1-10) <i class="fa fa-question-circle help" title="1 = high, 10 = low"></i></label>            
                <input type="text" class="form-control" name="priority" value="<?php echo (isset($settings['priority']) ? $settings['priority'] : ''); ?>" placeholder="5" />
            </div>
            <div class="form-group col-md-3">
                <label for="slideEffect">Select slide effect <i class="fa fa-question-circle help" title="Select the effect with which the images slide"></i></label>            
                <select name="slideEffect" class="form-control">
                    <?php echo $sli; ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="slidePause">Slide pause (ms)<i class="fa fa-question-circle help" title="How long should the slide appear (in miliseconds)"></i></label>            
                <input type="text" class="form-control" name="slidePause" value="<?php echo (isset($settings['slidePause']) ? $settings['slidePause'] : ''); ?>" placeholder="8000" />
            </div>
            
            <div class="clearfix"></div>
            
            <h4 style="margin-left: 15px;">Captions</h4>
            
            <div class="form-group col-md-3">
                <label for="captionEffect">Select caption effect <i class="fa fa-question-circle help" title="Select the effect with which the caption appear"></i></label>            
                <select name="captionEffect" class="form-control">
                    <?php echo $cap; ?>
                </select>
            </div>
            
            <div class="form-group col-md-3">
                <label for="captionSpeed">Caption speed <i class="fa fa-question-circle help" title="Enter speed time with this the caption appears"></i></label>            
                <input type="text" name="captionSpeed" class="form-control" value="<?php echo (isset($settings['captionSpeed']) ? $settings['captionSpeed'] : ''); ?>" placeholder="1200" />
            </div>
            
            <div class="form-group col-md-3">
                <div class="form-group col-md-6" style="padding-left: 0;">
                    <label for="captionXPos">X-Pos <i class="fa fa-question-circle help" title="Select the x-position where the caption should appear"></i></label>            
                    <input type="text" name="captionXPos" class="form-control" value="<?php echo (isset($settings['captionXPos']) ? $settings['captionXPos'] : ''); ?>" placeholder="30" />
                </div>
                
                <div class="form-group col-md-6" style="padding-right: 0;">
                    <label for="captionYPos">Y-Pos <i class="fa fa-question-circle help" title="Select the y-position where the caption should appear"></i></label>            
                    <input type="text" name="captionYPos" class="form-control" value="<?php echo (isset($settings['captionYPos']) ? $settings['captionYPos'] : ''); ?>" placeholder="30" />
                </div>
            </div>
            
            <div class="form-group col-md-3">
                <div class="form-group col-md-6" style="padding-left: 0;">
                    <label for="captionWidth">Width <i class="fa fa-question-circle help" title="Select the width of the caption (leave blank for autosize)"></i></label>            
                    <input type="text" name="captionWidth" class="form-control" value="<?php echo (isset($settings['captionWidth']) ? $settings['captionWidth'] : ''); ?>" placeholder="auto" />
                </div>
                
                <div class="form-group col-md-6" style="padding-right: 0;">
                    <label for="captionHeight">Height <i class="fa fa-question-circle help" title="Select the height of the caption (leave blank for autosize)"></i></label>            
                    <input type="text" name="captionHeight" class="form-control" value="<?php echo (isset($settings['captionHeight']) ? $settings['captionHeight'] : ''); ?>" placeholder="auto" />
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="form-group col-md-12">
                <label for="slideCaption">Enter caption text <i class="fa fa-question-circle help" title="Enter the Text for the caption"></i></label>            
                <textarea name="slideCaption" class="form-control" style="width: 100%; height: 150px !important;"><?php echo (isset($settings['slideCaption']) ? $settings['slideCaption'] : ''); ?></textarea>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="form-group col-md-5">
                <label for="slideLink">Link <i class="fa fa-question-circle help" title="Enter the URL to link the slide"></i></label>
                <input type="text" name="slideLink" class="form-control" value="<?php echo (isset($settings['slideLink']) ? $settings['slideLink'] : ''); ?>" placeholder="URL to link slider" />
            </div>
            
            <div class="file-input form-group col-md-5">
                <label style="width: 100%;">Select File <?php if (isset($edit)) { echo '<i class="fa fa-question-circle help" title="Ignore if you want to keep your previous image"></i>'; } ?></label>
                <input id="fakeFile" value="" disabled="disabled" class="form-control" placeholder="<?php echo (isset($settings['image']) ? '../banners/'.$settings['image'] : 'No file choosen'); ?>" />
                <label id="fakeLabel" for="file" class="btn btn-info">
                    <i class="fa fa-upload"></i> Choose File
                    <input id="file" style="display: none;" type="file" name="banner">
                </label>
                <script>
                $("#file").on("change", function(){
                    var path = $(this).val();
                    $("#fakeFile").val(path.replace(/^.*\\/, "..\\"));    
                });
                </script>
            </div>
            
            <div class="form-group col-md-2 text-right">
                <label style="width: 100%;">&nbsp;</label>
                <button type="submit" class="btn btn-info">Save</button>
            </div>
            
            <div class="clearfix"></div>
        </form>
    </div>
    <div class="table-contains-actions">
        <?php echo $slides; ?>
    </div>
    
    <div id="sortStatus" style="display: none;"></div>
    
</div>
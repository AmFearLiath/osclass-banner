<?php
$banner = new banner;

$positions = '';

foreach($banner->_getPositions() as $k => $v) {
    $positions .= '    
        <ul id="position-'.$v['pk_i_id'].'">
            <li class="positionTitle">'.$v['s_title'].'</li>
            <li class="positionName">'.$v['s_name'].'</li>
            <li class="positionType">'.$v['s_type'].'</li>
            <li class="positionTools">
                '.($v['s_name'] != 'all' ? '
                <button class="btn btn-success show-code" data-id="pos_'.$v['pk_i_id'].'"><i class="fa fa-code"></i></button>
                <button class="btn btn-info edit-position" data-id="'.$v['s_name'].'"><i class="fa fa-edit"></i></button>
                <button class="btn btn-danger delete-position" data-id="'.$v['pk_i_id'].'"><i class="fa fa-times"></i></button>
                ' : '').'
            </li>
            '.($v['s_name'] != 'all' ? '<li class="positionCode" id="pos_'.$v['pk_i_id'].'"><pre style="width: 100%; margin: 0 0 10px 0;">&lt;?php osc_run_hook(\'banner_'.$v['s_name'].'\', \''.$v['s_name'].'\'); ?&gt;</pre></li>' : '').'
            
        </ul>';
}    
?>
<div id="positions">
    <div class="widget-title">
        <h3><?php echo __('Positions', 'banner'); ?></h3>
        <button class="btn btn-info add"><i class="fa fa-plus"></i></button>
        <div class="clearfix"></div>
        <small><?php echo __('Here you can easily create unlimited hooks and place them in your theme.<br />To create a new hook simply enter the title and the name, select the type and let the templatecode be displayed, then insert this code in your theme at the desired position.', 'banner'); ?></small>
    </div>
    <div id="position_add" style="display: none;">
        <form name="savePosition" action="<?php echo osc_admin_render_plugin_url().'banner/admin/config.php'; ?>" method="post">
            
            <input type="hidden" name="position_save" value="<?php echo (isset($edit['s_name']) ? $edit['s_name'] : 'true'); ?>" />
            
            <div class="form-group col-md-4">
                <label for="positionTitle">Position title <i class="fa fa-question-circle help" title="Enter the title of the new position"></i></label>
                <input type="text" name="positionTitle" class="form-control" value="<?php echo (isset($edit['s_title']) ? $edit['s_title'] : ''); ?>" placeholder="Your position title" />
            </div>
            
            <div class="form-group col-md-3">
                <label for="positionName">Position name <i class="fa fa-question-circle help" title="Enter the internal name of the position (allowed: only letters, numbers and _ or -)"></i></label>
                <input type="text" name="positionName" class="form-control" value="<?php echo (isset($edit['s_name']) ? $edit['s_name'] : ''); ?>" placeholder="position_name" />
            </div>
            
            <div class="form-group col-md-3">
                <label for="positionType">Position type <i class="fa fa-question-circle help" title="Select the type of the new position"></i></label>
                <select name="positionType" class="form-control">
                    <option value="horizontal"<?php echo (isset($edit['s_type']) && $edit['s_type'] == 'horizontal' ? ' selected="selected"' : ''); ?>>Horizontal</option>
                    <option value="vertical"<?php echo (isset($edit['s_type']) && $edit['s_type'] == 'vertical' ? ' selected="selected"' : ''); ?>>Vertical</option>
                </select>
            </div>
            
            <div class="form-group col-md-2">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-info">Save</button>
            </div>
            
            <div class="clearfix"></div>
        </form>
    </div>
    <div class="table-contains-actions">
        <ul>
            <li class="tableHeader">
                <ul>
                    <li class="positionTitle">Title</li>
                    <li class="positionName">Name</li>
                    <li class="positionType">Type</li>
                    <li class="positionCode">Code to insert</li>
                </ul>
            </li>
            <li class="tableData">
                <?php echo $positions; ?>
            </li>
        </ul>
    </div>    
</div>
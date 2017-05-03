<?php
class banner extends DAO {
    
    private static $instance ;
    
    public static function newInstance() {
        if( !self::$instance instanceof self ) {
            self::$instance = new self ;
        }
        return self::$instance ;
    }
    
    function __construct() {
        $this->_table_banner = '`'.DB_TABLE_PREFIX.'t_banner`';
        $this->_table_banner_positions = '`'.DB_TABLE_PREFIX.'t_banner_positions`';
        $this->_table_preferences = '`'.DB_TABLE_PREFIX.'t_preference`';
        
        parent::__construct();
    }
    
    public static function _install($opts = '') {
        
        $file = osc_plugin_resource('banner/assets/banner.sql');
        $sql = file_get_contents($file);
        
        if (self::newInstance()->dao->importSQL($sql)) {
            throw new Exception( "Error importSQL::banner<br>".$file ) ;
        }
        
        if ($opts == '') { $opts = self::_opt(); }        
        foreach ($opts AS $k => $v) {
            if (!osc_set_preference($k, $v[0], $v[1], $v[2])) {
                return false;    
            }
        }
        
        return true;            
    }
    
    public static function _uninstall() {
        $pref = self::_sect();                
        Preference::newInstance()->delete(array("s_section" => $pref));    
        self::newInstance()->dao->query(sprintf('DROP TABLE %s', self::newInstance()->_table_banner));    
    }
    
    public static function _opt() {        
        $pref = self::_sect();        
        $opts = array(
            //'on_showcheck' => array('0', $pref, 'BOOLEAN')
        );        
        return $opts;
    }

    public static function _get($opt) {        
        $pref = self::_sect();
        return osc_get_preference($opt, $pref);
    }
    
    public static function _sect() {
        return 'plugin_banner';
    }
    
    public static function _admin_menu_draw() {
         AdminToolbar::newInstance()->add_submenu( array(
             'id'        => 'bt_tools_menu',
             'subid'     => 'banner',
             'title'     => 'Banner Management',
             'href'      => osc_admin_render_plugin_url(dirname(osc_plugin_folder(__FILE__)).'/admin/config.php'),
             'meta'      => array('class' => 'banner'),
             'target'    => '_self'
         ));    
    }
    
    function _slides($pos = false) {
        $this->dao->select('*');
        $this->dao->from($this->_table_banner);
        if ($pos) $this->dao->where('s_position', $pos);
        $this->dao->orderBy('s_position', 'ASC');
        $this->dao->orderBy('i_priority', 'ASC');
        $result = $this->dao->get();
        if (!$result) { return false; }
        
        return $result->result();
    }
    
    function _getSlide($id = false) {
        $this->dao->select('*');
        $this->dao->from($this->_table_banner);
        $this->dao->where('pk_i_id', $id);
        $result = $this->dao->get();
        if (!$result) { return false; }
        
        return $result->row();
    }
    
    function _settings($id = false) {
        $this->dao->select('s_settings');
        $this->dao->from($this->_table_banner);
        if ($id) $this->dao->where('pk_i_id', $id);

        $result = $this->dao->get();
        if (!$result) { return false; }
        
        $row = $result->row();
        return unserialize($row['s_settings']);
    }
    
    function _position($where = false) {
        $this->dao->select('i_position');
        $this->dao->from($this->_table_banner);
        if ($where) $this->dao->where($where);

        $result = $this->dao->get();
        if (!$result) { return false; }
        
        $row = $result->row();
        return $row['i_position'];
    }
    
    function _getPositions($pos = false) {
        $this->dao->select('*');
        $this->dao->from($this->_table_banner_positions);
        
        if ($pos) { $this->dao->where('s_name', $pos); }
        
        $this->dao->orderBy('s_type', 'ASC');
        $this->dao->orderBy('s_name', 'ASC');
        
        $result = $this->dao->get();
        if (!$result) { return false; }
        
        if ($pos) { return $result->row(); } 
        else { return $result->result(); }
        
    }
    
    function _savePositions($data) {
        $set = array(
            's_title' => $data['positionTitle'],
            's_name' => $data['positionName'],
            's_type' => $data['positionType'],
        );
        if (isset($data['position_save']) && $this->_getPositions($data['position_save'])) {
            $this->dao->update($this->_table_banner_positions, $set, array('s_name' => $data['position_save']));        
        } else {
            $this->dao->insert($this->_table_banner_positions, $set);    
        }
    }
    
    function _deletePosition($pos) {
        if (!$this->dao->delete($this->_table_banner_positions, 'pk_i_id = '.$pos)) {
            return false;    
        }        
        return true;        
    }
    
    function _priority($pos) {
        $this->dao->select('count(*) as count');
        $this->dao->from($this->_table_banner);
        $this->dao->where('s_position', $pos);

        $result = $this->dao->get();
        if (!$result) { return false; }
        
        $row = $result->row();
        return $row['count']+1;
    }
    
    function bannerPositions() {
        $positions = $this->_getPositions();
        $return = array();
        
        foreach($positions as $k => $v) {
            $add = array($v['s_title'] => $v['s_name']);
            $return = array_merge($return, $add);
        }
        return $return;
    }
    
    function loadHooks($pos) {
        $slide = '';
        $slides = $this->_slides($pos);
        $slideall = $this->_slides('all');
        
        $dir = $this->_getPositions($pos);
        
        if ($slides || $slideall) {
            $slide .='
                <div class="container banner_container">
                <div class="iview '.$dir['s_type'].'" id="'.$pos.'">';
            foreach($slideall as $k => $v) {
                
                $check = $this->_getPositions($v['s_position']);
                if ($check['s_type'] == $dir['s_type']) {
                    $settings = unserialize($v['s_settings']);
                    
                    if ($settings['slideLink'] != '') {
                        $slide .= '<a href="'.$settings['slideLink'].'" target="_blank" ';
                    } else {
                        $slide .= '<div ';
                    }
                    
                    $slide .='
                        data-iview:transition="'.$settings['slideEffect'].'" data-iview:pausetime="'.$settings['slidePause'].'" data-iview:image="'.osc_base_url().'oc-content/banners/'.$settings['image'].'">
                            '.(!empty($settings['slideCaption']) ? '
                            <div class="iview-caption caption1" data-x="'.(!empty($settings['captionXPos']) ? $settings['captionXPos'] : '30').'" data-y="'.(!empty($settings['captionYPos']) ? $settings['captionYPos'] : '30').'" data-transition="'.$settings['captionEffect'].'" data-speed="'.$settings['captionSpeed'].'" '.($settings['captionWidth'] != '' ? 'data-width="'.$settings['captionWidth'].'"' : '').' '.($settings['captionHeight'] != '' ? 'data-height="'.$settings['captionHeight'].'"' : '').'>'.$settings['slideCaption'].'</div>
                            ' : '');
                    
                    if ($settings['slideLink'] != '') {
                        $slide .= '</a>';
                    } else {
                        $slide .= '</div>';
                    }
                }
            }
            foreach($slides as $k => $v) {
                $settings = unserialize($v['s_settings']);
                
                if ($settings['slideLink'] != '') {
                    $slide .= '<a href="'.$settings['slideLink'].'" target="_blank" ';
                } else {
                    $slide .= '<div ';
                }
                
                $slide .='
                    data-iview:transition="'.$settings['slideEffect'].'" data-iview:pausetime="'.$settings['slidePause'].'" data-iview:image="'.osc_base_url().'oc-content/banners/'.$settings['image'].'">
                        '.(!empty($settings['slideCaption']) ? '
                        <div class="iview-caption caption1" data-x="'.(!empty($settings['captionXPos']) ? $settings['captionXPos'] : '30').'" data-y="'.(!empty($settings['captionYPos']) ? $settings['captionYPos'] : '30').'" data-transition="'.$settings['captionEffect'].'" data-speed="'.$settings['captionSpeed'].'" '.($settings['captionWidth'] != '' ? 'data-width="'.$settings['captionWidth'].'"' : '').' '.($settings['captionHeight'] != '' ? 'data-height="'.$settings['captionHeight'].'"' : '').'>'.$settings['slideCaption'].'</div>
                        ' : '');
                
                if ($settings['slideLink'] != '') {
                    $slide .= '</a>';
                } else {
                    $slide .= '</div>';
                }
            }
            $slide .='                    
                </div>
                </div> 
                <script>
                    $(\'#'.$pos.'\').iView({
                        '.$this->_readSettings().'
                    });
                </script>';
        }
        return $slide;
    }
    
    function slideEffects() {
        return array(
            'random', 'fade',
            'block-random', 'block-fade', 'block-fade-reverse', 'block-expand', 'block-expand-reverse', 'block-expand-random', 'block-drop-random',
            'strip-down-right', 'strip-down-left', 'strip-up-right', 'strip-up-left', 'strip-up-down', 'strip-up-down-left', 'strip-left-right', 'strip-left-right-down', 'strip-left-fade', 'strip-right-fade', 'strip-top-fade', 'strip-bottom-fade',
            'slide-in-right', 'slide-in-left', 'slide-in-up', 'slide-in-down',
            'left-curtain', 'right-curtain', 'top-curtain', 'bottom-curtain',
            'zigzag-top', 'zigzag-bottom', 'zigzag-grow-top', 'zigzag-grow-bottom', 'zigzag-drop-top', 'zigzag-drop-bottom'           
        );
    }
    
    function captionEffects() {
        return array('fade', 'expanddown', 'expandup', 'expandright', 'expandleft', 'wipedown', 'wipeup', 'wiperight', 'wipeleft');
    }
    
    function easing() {
        return array(
            'linear', 'easeInSine', 'easeOutSine', 'easeInOutSine', 'easeInQuad', 'easeOutQuad', 'easeInOutQuad', 
            'easeInCubic', 'easeOutCubic', 'easeInOutCubic', 'easeInQuart', 'easeOutQuart', 'easeInOutQuart', 
            'easeInQuint', 'easeOutQuint', 'easeInOutQuint', 'easeInExpo', 'easeOutExpo', 'easeInOutExpo', 
            'easeInCirc', 'easeOutCirc', 'easeInOutCirc', 'easeInBack', 'easeOutBack', 'easeInOutBack', 
            'easeInElastic', 'easeOutElastic', 'easeInOutElastic', 'easeInBounce', 'easeOutBounce', 'easeInOutBounce');
    }
    
    function _thumbnails($file, $dest, $desired_width) {

        $source_image = imagecreatefromjpeg($file);

        $width = imagesx($source_image);
        $height = imagesy($source_image);

        $desired_height = floor($height * ($desired_width / $width));

        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        if (imagejpeg($virtual_image, $dest)) {
            return true;    
        } else {
            return false;
        }   
    }
    
    function _readSettings() {
        $this->dao->select('*');
        $this->dao->from($this->_table_preferences);
        $this->dao->where('s_section', self::_sect());

        $result = $this->dao->get();
        if (!$result) { return false; }
        
        $set = '';
        
        foreach($result->result() as $k => $v) {
            $forbidden = array('slideWidthHorizontal', 'slideHeightHorizontal', 'slideWidthVertical', 'slideHeightVertical');
            
            if (!empty($v['s_value']) && !in_array($v['s_name'], $forbidden)) {
                if (is_numeric($v['s_value'])) {
                    $set .= $v['s_name'].': '.$v['s_value'].','.PHP_EOL;    
                } else {
                    $set .= $v['s_name'].': \''.$v['s_value'].'\','.PHP_EOL;    
                }
            }            
        }
        
        return $set;
    }
    
    function _saveSettings($data) {
        $pref = self::_sect();
        $forbidden = array('CSRFName', 'CSRFToken', 'page', 'file', 'action', 'settings_save');
        foreach($data as $k => $v) {
            if (!in_array($k, $forbidden)) {
                if (!empty($v)) {
                    osc_set_preference($k, $v, $pref, 'STRING');
                }
            }
        }
    }
    
    function _saveSlide($data) { 
        $file = $this->_upload();
        
        if ($file) {
            $priority = $this->_priority($data['bannerPosition']);
            $save = array(
                'bannerPosition' => $data['bannerPosition'],
                'priority' => $data['priority'], 
                'slideEffect' => $data['slideEffect'],
                'slideCaption' => $data['slideCaption'], 
                'slidePause' => $data['slidePause'], 
                'slideLink' => $data['slideLink'], 
                'captionEffect' => $data['captionEffect'],
                'captionSpeed' => $data['captionSpeed'],
                'captionXPos' => $data['captionXPos'],
                'captionYPos' => $data['captionYPos'],
                'captionWidth' => $data['captionWidth'],
                'captionHeight' => $data['captionHeight'],
                'image' => $file
            );
        
            if (!$this->dao->insert($this->_table_banner, array('s_position' => $data['bannerPosition'], 'i_priority' => $priority, 's_settings' => serialize($save)))) {
                return false;
            }
        } else {
            return false;
        }
        
        return true;
    }
    
    function _updateSlide($data) {
        
        $slide = $this->_getSlide($data['banner_edit']);
        $settings = unserialize($slide['s_settings']);
        
        if (isset($_FILES['banner']['name']) && $_FILES['banner']['name'] != '') {
            unlink(osc_content_path().'banners/'.$settings['image']);
            unlink(osc_content_path().'banners/thumb_'.$settings['image']);
            $file = $this->_upload();
            $image_array = array('image' => $file);
        } else {
            $image_array = array('image' => $settings['image']);    
        }
        
        $save = array(
            'bannerPosition' => $data['bannerPosition'],
            'priority' => $data['priority'], 
            'slideEffect' => $data['slideEffect'],
            'slideCaption' => $data['slideCaption'], 
            'slidePause' => $data['slidePause'], 
            'slideLink' => $data['slideLink'], 
            'captionEffect' => $data['captionEffect'],
            'captionSpeed' => $data['captionSpeed'],
            'captionXPos' => $data['captionXPos'],
            'captionYPos' => $data['captionYPos'],
            'captionWidth' => $data['captionWidth'],
            'captionHeight' => $data['captionHeight']
        );
        
        $save = array_merge($save, $image_array);
    
        if (!$this->dao->update($this->_table_banner, array('s_position' => $data['bannerPosition'], 's_settings' => serialize($save)), array('pk_i_id' => $data['banner_edit']))) {
            return false;
        }
        
        return true;
    }
    
    function _deleteSlide($id) {
        
        $slide = $this->_getSlide($id);
        $settings = unserialize($slide['s_settings']);

        unlink(osc_content_path().'banners/'.$settings['image']);
        unlink(osc_content_path().'banners/thumb_'.$settings['image']);
        
        $this->dao->delete($this->_table_banner, 'pk_i_id = '.$id);
        return true;    
    }
    
    function _upload(){

        $maxwidth = '1170';
        $maxheight = '200';
        $allowed_filetypes = array('.jpeg', '.jpg','.gif','.bmp','.png', '.JPEG', '.JPG', '.GIF', '.BMP', '.PNG');
        $max_filesize = 2097152;
        $id = uniqid('banner_');
        
        $upload_path = osc_content_path().'banners/';

        if (!file_exists($upload_path)) {
            mkdir($upload_path, 0777);
        } 
            
        $filename = $_FILES['banner']['name']; $tmp = $_FILES['banner']['tmp_name'];
        $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1);
        $fileinfo = getimagesize($_FILES['banner']['tmp_name']);
        
        if (!in_array($ext,$allowed_filetypes)) {
            die(__("The file you attempted to upload is not allowed.", 'banner'));
        } if (filesize($tmp) > $max_filesize) {
            die(__("The file you attempted to upload is too large.", 'banner'));
        } if ($fileinfo[0] > $maxwidth) {
            die(__("The imagewidth you attempted to upload is too large.", 'banner'));
        } if ($fileinfo[1] > $maxheight) {
            die(__("The imageheight you attempted to upload is too large.", 'banner'));
        } if (!is_writable($upload_path)) {
            die(sprintf(__("You cannot upload to the specified directory: %s, please CHMOD it to 777.", 'banner'), $upload_path));
        }
        
        if (move_uploaded_file($tmp,$upload_path . $id.$ext)) {
            $this->_thumbnails($upload_path . $id.$ext, $upload_path . 'thumb_'.$id.$ext, 300);
        } else {
            die(__("There was an error during the file upload, please try again", 'banner'));
        }
        
        return $id.$ext;
    }
    
    function r($var){
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }    
}
?>
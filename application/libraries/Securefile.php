<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Securefile class
 * Membantu upload dan ambil file dari posisi bukan public_html, dengan harapan penyimpanan file lebih secure
 *
 * @author      Haniefhan
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @since       2015
 */

class Securefile {
    public $file_folder_path = '';
    public $allowed_file_type = '*';
    public $max_width = 800;

    public function __construct() {
        $this->ci =& get_instance();
        if($this->file_folder_path == '') $this->file_folder_path = $this->ci->config->item('file_folder_path');
    }

    public function check_file_exist($file_path = '', $with_path = false){
        if($with_path == false) $file_path = $this->file_folder_path.$file_path;
        else if($with_path == true) $file_path = $file_path;
        if(file_exists($file_path)) return true;
        else return false;
    }

    /**
     * [folder_management description]
     * @param  string $folder [description]
     * @param  string $type   per_month_per_year or blank
     * @return [type]         [description]
     */
    public function folder_management($folder = '', $type = ''){
        $destination = '';

        if($type == 'per_month_per_year'){
            $year = date('Y');
            $month = date('m');

            if(substr($folder, -1, 1) != '/') $folder .= '/';
            $folder .= $year.'/'.$month;
        }

        if($folder != ''){
            $last_folder = '';
            $fs = explode('/', $folder);
            foreach ($fs as $f) {
                if(!file_exists($this->file_folder_path.$last_folder.$f)) mkdir($this->file_folder_path.$last_folder.$f);
                $destination .= $f.'/';
                $last_folder .= $f.'/';
            }
        }

        return $destination;
    }

    public function is_allowed($filename = ''){
        if($this->allowed_file_type == '*'){
            return true;
        }else{
            return in_array($this->get_extension($filename), explode('|', $this->allowed_file_type));
        }
    }

    public function get_extension($filename = ''){
        $x = explode('.', $filename);

        if (count($x) === 1) return '';

        $ext = strtolower(end($x));
        return $ext;
    }

    public function is_has_filetype($filename = ''){
        $x = explode('.', $filename);
        if (count($x) === 1) return false;
        else return true;
    }

    public function save_file($file = array(), $filename = '', $folder = ''){
        $destination = $this->folder_management($folder, '');

        if($filename != ''){
            $destination .= $filename;

            if($this->is_has_filetype($filename) == false){
                // $fn = basename($file['name']);
                $ext = $this->get_extension($file['name']);
                // $destination .= '.'.$ext;
                $filename .= '.'.$ext;
            }            
        }
        else $destination .= $file['name'];

        if($filename == ''){
            $filename = $file['name'];
        }

        if($this->is_allowed($filename)){
            $ext = $this->get_extension($file['name']);
            if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg'){
                $max_width = $this->max_width; // px
                list($width, $height, $type, $attr) = getimagesize($file['tmp_name']);

                if($width > $max_width){
                    $ratio  = $max_width / $width;
                    $new_width  = $max_width;
                    $new_height = $height * $ratio;

                    $src = imagecreatefromstring(file_get_contents($file['tmp_name']));
                    $dst = imagecreatetruecolor($new_width, $new_height);

                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    imagedestroy($src);
                    if($ext == 'png') $st = imagepng($dst, $this->file_folder_path.$destination);
                    else if($ext == 'jpg' or $ext == 'jpeg') $st = imagejpeg($dst, $this->file_folder_path.$destination);
                    imagedestroy($dst);
                }else{
                   $st = move_uploaded_file($file['tmp_name'], $this->file_folder_path.$destination); 
                }
            }else{
                $st = move_uploaded_file($file['tmp_name'], $this->file_folder_path.$destination); 
            }

            if($st){
                return $destination;
            }
        }else{
            return false;
        }
    }

    private function _get_content_type($filepath = ''){
        $type = '';
        $filename = basename($filepath);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if($ext == 'txt') $type = 'text/plain';

        elseif($ext == 'jpg') $type = 'image/jpeg';
        elseif($ext == 'jpeg') $type = 'image/pjpeg';
        elseif($ext == 'png') $type = 'image/png';
        elseif($ext == 'gif') $type = 'image/gif';

        elseif($ext == 'pdf') $type = 'application/pdf';
        elseif($ext == 'sql') $type = 'application/octet-stream';
        elseif($ext == 'zip') $type = 'application/zip';
        elseif($ext == 'doc') $type = 'application/msword';
        elseif($ext == 'docx') $type = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        elseif($ext == 'xls') $type = 'application/excel';
        elseif($ext == 'xlsx') $type = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        elseif($ext == 'rtf') $type = 'application/rtf';

        return $type;
    }

    /**
     * [open_file description]
     * @param  string  $filepath      [description]
     * @param  boolean $base64_encode [description]
     * @param  boolean $inline        true : open the file, often use to open PDF in new tab
     * @return [type]                 [description]
     */
    public function open_file($filepath = '', $base64_encode = true, $inline = false){
        $path = $this->file_folder_path.$filepath;
        if(!is_file($path) or !file_exists($path)){
            // $path = $this->file_folder_path.'no-image-available.jpg';
            return '';
        }

        $data = file_get_contents($path);
        
        if($base64_encode == true){
            $base64 = 'data:' . $this->_get_content_type($filepath) . ';base64,' . base64_encode($data);
            return $base64;
        }

        if($inline == true){
            $filename = basename($path);
            header('Content-Type: '.$this->_get_content_type($path));
            header('Content-Disposition: inline; filename='.$filename);
            header('Content-Length: ' . filesize($path));
            ob_clean();
            flush();
            readfile($path);
        }else{
            return $data;
        }
    }

    public function delete_file($filepath = ''){
        $path = $this->file_folder_path.$filepath;
        return unlink($path);
    }

    public function get_file_list($filepath = '', $create_folder = true){
        $error = '';
        if(!file_exists($filepath) && $create_folder == true){
            if(!mkdir($filepath)){
                $error = 'tidak bisa membuat folder backup';
            }
        }

        $return = array();
        $return['error'] = $error;
        $return['data'] = array();
        if(file_exists($filepath)){
            $folder = @opendir($filepath);
            while($file = readdir($folder)){
                if($file != '.' && $file != '..') $return['data'][] = $file;
            }
        }

        return $return;
    }

    /*public function open_file($file_path = '', $inline = true, $with_path = false){
        if($with_path == false) $file_path = $this->file_folder_path.$file_path;
        else if($with_path == true) $file_path = $file_path;

        $filename = $this->_get_filename($file_path);
        if($inline == true){
            // header('Content-Description: File Transfer');
            // header('Content-Type: application/octet-stream');
            header('Content-Type: '.$this->_get_content_type($file_path));
            header('Content-Disposition: inline; filename='.$filename);
            // header('Content-Transfer-Encoding: binary');
            // header('Expires: 0');
            // header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            // header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            ob_clean();
            flush();
            readfile($file_path);
        }else{
            return $file_path;
        }
    }

    public function open_image_base64($file_path = ''){
        $file_path = $this->file_folder_path.$file_path;
        $type = pathinfo($file_path, PATHINFO_EXTENSION);
        $return = '';
        if(file_exists($file_path) && is_file($file_path)){
            $data = file_get_contents($file_path);
            $return = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return $return;
    }

    public function open_pdf_base64($file_path = ''){
        $file_path = $this->file_folder_path.$file_path;
        $type = pathinfo($file_path, PATHINFO_EXTENSION);
        $return = '';
        if(file_exists($file_path) && is_file($file_path)){
            $data = file_get_contents($file_path);
            $return = 'data:application/pdf;base64,' . base64_encode($data);
        }
        return $return;
    }

    private function _get_content_type($filename = ''){
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if($ext == 'pdf') return 'application/pdf';
        if($ext == 'jpg') return 'image/jpeg';
        else return '';
    }

    private function _get_filename($file_path = ''){
        return basename($file_path);
    }*/

}
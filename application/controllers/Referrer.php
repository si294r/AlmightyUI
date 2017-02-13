<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Referrer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['signin'])) {
            redirect('signin');
        }
    }

    public function index($channel = "") {
        $this->load->model('referrer_model', 'referrer');
        if (isset($_FILES['new_image'])) {
            $new_file = "/var/www/temp_image/".$_FILES['new_image']['name'];
            if (move_uploaded_file($_FILES['new_image']['tmp_name'], $new_file)) {
                $this->referrer->upload($new_file);
//                echo "File is valid, and was successfully uploaded.\n";
            }
//            print_r($_FILES['new_image']);
        }
        if (isset($_POST['image'])) {
            $this->referrer->save();
//            redirect('referrer');
        }
        $data['list_image_referrer'] = $this->referrer->list_image();
        $data['row_referrer'] = $this->referrer->get();
        $this->load->view('referrer_view', $data);
    }

}

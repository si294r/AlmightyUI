<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require '/var/www/vendor/autoload.php';
require '/var/www/local-ssh2.php';

class Referrer_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }    
    
    public function list_image() {
        $config = $GLOBALS['local-ssh2'];

        $connection = ssh2_connect($config['host'], $config['port']);
        ssh2_auth_password($connection, $config['username'], $config['password']);

        $stream = ssh2_exec($connection, "aws s3 ls s3://alegrium-www/almighty/images/shorten/");

        stream_set_blocking($stream, true);

        $out = stream_get_contents($stream);

        fclose($stream);
        
        $arr = explode("\n", $out);
        $result = [];
        foreach ($arr as $k=>$v) {
            if ($v != "") {
                $file = substr($v, 31);
                if (trim($file) != "") {
                    $result[] = trim($file);
                }
            }
        }
//        print_r($result);
        return $result;
    }
    
    public function upload($new_file) {
        $config = $GLOBALS['local-ssh2'];

        $connection = ssh2_connect($config['host'], $config['port']);
        ssh2_auth_password($connection, $config['username'], $config['password']);

        $stream = ssh2_exec($connection, "aws s3 cp \"$new_file\" s3://alegrium-www/almighty/images/shorten/");

        stream_set_blocking($stream, true);

        $out = stream_get_contents($stream);

        fclose($stream);
    }
    
    public function get() {
        $query = $this->db->query("select * from share_almighty_ios limit 1");
        return $query->row_array();
    }

    public function save() {
        if (isset($_FILES['new_image']['name'])) {
            $this->db->query(
                        "update share_almighty_ios set image=?, title=?, description=?",
                        array($_FILES['new_image']['name'], $_POST['title'], $_POST['description'])
                    );
        } else {
            $this->db->query(
                        "update share_almighty_ios set image=?, title=?, description=?",
                        array($_POST['image'], $_POST['title'], $_POST['description'])
                    );
        }
    }
}

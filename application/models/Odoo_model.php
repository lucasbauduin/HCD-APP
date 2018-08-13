<?php
/**
 * Created by PhpStorm.
 * User: mdelvoye
 * Date: 28/11/2017
 * Time: 15:53
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include APPPATH.'third_party/ripcord/ripcord.php';


class Odoo_model extends CI_Model
{
    public $user_id;
    public $db;
    public $url;
    public $login;
    public $password;
    public $ep_common = "/xmlrpc/2/common";
    public $ep_object = "/xmlrpc/2/object";
    public $resp_error_code = 404;
    public $resp_success_code = 200;
    public $ripcord;
    public $model;


    public function __construct()
    {
        parent::__construct();
        $this->load->config('odoo');
        $this->db = $this->config->item('db');
        $this->url = $this->config->item('url');
        $this->login = $this->config->item('login');
        $this->password = $this->config->item('password');

        $this->ripcord = new Ripcord();

        $this->user_id = $this->ripcord->client($this->url . $this->ep_common)->authenticate($this->db, $this->login, $this->password, array());

        if (!is_int($this->user_id)){
            show_error("Unable to connect to the database", 404, "Database unreachable");
        }
        $this->model = $this->ripcord->client($this->url . $this->ep_object);

    }
    public function get_all_interventions() {
        return $orders = $this->model->execute_kw($this->db, $this->user_id, $this->password,
            'ms.intervention', 'web_api_get_all_position',
            array(
                array(date("Y-m-d"))
            ));
    }
    public function get_intervention_by_id($id){
        return $orders = $this->model->execute_kw($this->db, $this->user_id, $this->password,
            'ms.intervention', 'web_api_get_position',
            array(
                array($id)
            ));
    }
}
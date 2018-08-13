<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
        public function __construct() {
            parent::__construct();
            $this->load->helper('url_helper');
            $this->load->model('odoo_model');
        }
	public function index()
	{
                $data = array();
                 if(isset($_GET['id'])) {
                    $id = isset($_GET['id']) ? strip_tags(addslashes($_GET['id'])) : "";
                    $data['uneIntervention'] = $this->odoo_model->get_intervention_by_id($id);
                    $data['allInterventions'] = $this->odoo_model->get_all_interventions();
                    echo '<pre>' . var_export($data, true) . '</pre>';
                    $this->load->view('header');
                    $this->load->view('map', $data);
                }
                else {
                    //show_error("Unable to retrieve intervention, ID field not filled", 404, "No intervention ID");
                    $data['uneIntervention'] = array('longitude' => '3.146656', 'latitude' => '50.642192');
                    $data['allInterventions'] = array();
                    $this->load->view('header');
                    $this->load->view('map', $data);
                }
	}
}

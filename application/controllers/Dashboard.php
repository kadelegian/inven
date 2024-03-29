<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
    }
    function index()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } else {
            $this->load->model('Maintenance_model');
            $this->load->model('Barang_inventory_model');
            $this->Maintenance_model->order = 'desc';
            $list_perawatan = $this->Maintenance_model->get_limit_data(30, 0);
            $data_perawatan = $this->Barang_inventory_model->get_maintenance_schedule();
            $data = [
                'data_maintenance' => $data_perawatan,
                'list_maintenance' => $list_perawatan
            ];
            $this->template->load('template', 'dashboard', $data);
        }
    }
}

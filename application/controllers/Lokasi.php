<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lokasi extends CI_Controller
{
    
        
    function __construct()
    {
        parent::__construct();
        $this->load->model('Lokasi_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'lokasi/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'lokasi/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'lokasi/index.html';
            $config['first_url'] = base_url() . 'lokasi/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Lokasi_model->total_rows($q);
        $lokasi = $this->Lokasi_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'lokasi_data' => $lokasi,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','lokasi_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Lokasi_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'ruang' => $row->ruang,
		'nomor_lantai' => $row->nomor_lantai,
		'prefix' => $row->prefix,
	    );
            $this->template->load('template','lokasi_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('lokasi'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('lokasi/create_action'),
	    'id' => set_value('id'),
	    'ruang' => set_value('ruang'),
	    'nomor_lantai' => set_value('nomor_lantai'),
	    'prefix' => set_value('prefix'),
	);
        $this->template->load('template','lokasi_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'ruang' => $this->input->post('ruang',TRUE),
		'nomor_lantai' => $this->input->post('nomor_lantai',TRUE),
		'prefix' => $this->input->post('prefix',TRUE),
	    );

            $this->Lokasi_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('lokasi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Lokasi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('lokasi/update_action'),
		'id' => set_value('id', $row->id),
		'ruang' => set_value('ruang', $row->ruang),
		'nomor_lantai' => set_value('nomor_lantai', $row->nomor_lantai),
		'prefix' => set_value('prefix', $row->prefix),
	    );
            $this->template->load('template','lokasi_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('lokasi'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'ruang' => $this->input->post('ruang',TRUE),
		'nomor_lantai' => $this->input->post('nomor_lantai',TRUE),
		'prefix' => $this->input->post('prefix',TRUE),
	    );

            $this->Lokasi_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('lokasi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Lokasi_model->get_by_id($id);

        if ($row) {
            $this->Lokasi_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('lokasi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('lokasi'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('ruang', 'ruang', 'trim|required');
	$this->form_validation->set_rules('nomor_lantai', 'nomor lantai', 'trim|required');
	$this->form_validation->set_rules('prefix', 'prefix', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Lokasi.php */
/* Location: ./application/controllers/Lokasi.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2024-02-16 12:45:13 */
/* http://harviacode.com */
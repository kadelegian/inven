<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Maintenance extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } else {

            $this->load->model('Maintenance_model');
            $this->load->library('form_validation');
        }
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'maintenance/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'maintenance/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'maintenance/index.html';
            $config['first_url'] = base_url() . 'maintenance/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Maintenance_model->total_rows($q);
        $maintenance = $this->Maintenance_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'maintenance_data' => $maintenance,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template', 'maintenance_list', $data);
    }

    public function read($id)
    {
        $row = $this->Maintenance_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'id_barang' => $row->id_barang,
                'tanggal' => $row->tanggal,
                'keterangan' => $row->keterangan,
                'next_due_date' => $row->next_due_date,
            );
            $this->template->load('template', 'maintenance_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('maintenance'));
        }
    }

    public function create($id_barang = 0)
    {
        if ($id_barang > 0) {
            $this->load->model('Barang_inventory_model');
            $data_barang = $this->Barang_inventory_model->get_detail_barang($id_barang);
            $js = array('jquery.datetimepicker.full.min.js', 'dtpicker_format.js');
            $css = array('jquery.datetimepicker.min.css');
            $data = array(
                'button' => 'Create',
                'action' => site_url('maintenance/create_action'),
                'id' => set_value('id'),
                'id_barang' => $id_barang,
                'nama_barang' => $data_barang->nama_barang,
                'tanggal' => date('Y-m-d'),
                'keterangan' => set_value('keterangan'),
                'next_due_date' => set_value('next_due_date'),
                'id_barang' => $data_barang->id,
                'nomor' => $data_barang->nomor,
                'jenis' => $data_barang->jenis_inventory,
                'lokasi' => $data_barang->ruang . ', Lantai ' . $data_barang->nomor_lantai,
                'add_js' => $js,
                'add_css' => $css,
            );
            $this->template->load('template', 'maintenance_form', $data);
        } else {
            redirect(site_url());
        }
    }

    public function create_action()
    {
        $this->_rules();
        $id_barang = $this->input->post('id_barang', TRUE);
        $due_date = $this->input->post('next_due_date', true);
        $tanggal = $this->input->post('tanggal', true);
        $done = false;
        if ($tanggal <> '') {
            $tanggal = date_create_from_format('d/m/Y', $tanggal);
        }
        if ($due_date <> '') {
            $due_date = date_create_from_format('d/m/Y', $due_date);
            $due_date = date_format($due_date, 'Y-m-d');
        } else {
            $done = true;
        }
        if ($this->form_validation->run() == FALSE) {
            $this->create($id_barang);
        } else {
            $data = array(
                'id_barang' => $id_barang,
                'tanggal' => date_format($tanggal, 'Y-m-d'),
                'keterangan' => $this->input->post('keterangan', TRUE),
                'next_due_date' => $due_date,
                'done' => $done,
            );

            $this->Maintenance_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('barang_inventory/read/' . $id_barang));
        }
    }

    public function update($id)
    {
        $row = $this->Maintenance_model->get_by_id($id);

        if ($row) {
            $js = array('jquery.datetimepicker.full.min.js', 'dtpicker_format.js');
            $css = array('jquery.datetimepicker.min.css');
            $data = array(
                'button' => 'Update',
                'action' => site_url('maintenance/update_action'),
                'id' => $row->id,
                'id_barang' => $row->id_barang,
                'nama_barang' => $row->nama_barang,
                'tanggal' => $row->tanggal,
                'keterangan' => $row->keterangan,
                'next_due_date' => $row->next_due_date,
                'nomor' => $row->nomor,
                'jenis' => $row->jenis,
                'lokasi' => $row->ruang . ', Lantai ' . $row->nomor_lantai,
                'add_js' => $js,
                'add_css' => $css,
            );

            $this->template->load('template', 'maintenance_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('maintenance'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'id_barang' => $this->input->post('id_barang', TRUE),
                'tanggal' => $this->input->post('tanggal', TRUE),
                'keterangan' => $this->input->post('keterangan', TRUE),
                'next_due_date' => $this->input->post('next_due_date', TRUE),
            );

            $this->Maintenance_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('maintenance'));
        }
    }

    public function delete($id)
    {
        $row = $this->Maintenance_model->get_by_id($id);

        if ($row) {
            $this->Maintenance_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('maintenance'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('maintenance'));
        }
    }
    public function selesai($id)
    {
        $row = $this->Maintenance_model->get_by_id($id);
        if ($row) {
            $data = array('done' => 1);
            $this->Maintenance_model->update($id, $data);
        }
        redirect(site_url());
    }
    public function _rules()
    {
        $this->form_validation->set_rules('id_barang', 'id barang', 'trim|required');
        $this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "maintenance.xls";
        $judul = "maintenance";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
        xlsWriteLabel($tablehead, $kolomhead++, "Id Barang");
        xlsWriteLabel($tablehead, $kolomhead++, "Tanggal");
        xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");
        xlsWriteLabel($tablehead, $kolomhead++, "Next Due Date");

        foreach ($this->Maintenance_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteNumber($tablebody, $kolombody++, $data->id_barang);
            xlsWriteLabel($tablebody, $kolombody++, $data->tanggal);
            xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);
            xlsWriteLabel($tablebody, $kolombody++, $data->next_due_date);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }
}

/* End of file Maintenance.php */
/* Location: ./application/controllers/Maintenance.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2024-02-24 08:31:44 */
/* http://harviacode.com */

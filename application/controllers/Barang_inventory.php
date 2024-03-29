<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Barang_inventory extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_inventory_model');
        $this->load->library('form_validation');
        $tujuan = $this->uri->segment(2, '');
        if ($tujuan != 'read') {
            if (!$this->ion_auth->logged_in()) {
                // redirect them to the login page
                redirect('auth/login', 'refresh');
            }
        }
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'barang_inventory/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'barang_inventory/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'barang_inventory/index.html';
            $config['first_url'] = base_url() . 'barang_inventory/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Barang_inventory_model->total_rows($q);
        $barang_inventory = $this->Barang_inventory_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'barang_inventory_data' => $barang_inventory,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template', 'barang_inventory_list', $data);
    }

    public function read($id)
    {
        $row = $this->Barang_inventory_model->get_detail_barang($id);
        if ($row) {
            $this->load->library('ciqrcode');
            $params['data'] = site_url('barang_inventory/read/' . $id);
            $params['level'] = 'H';
            $params['size'] = 50;
            $tempdir = FCPATH . 'assets/img/qr/';
            if (!file_exists($tempdir)) {
                mkdir($tempdir);
            }
            $params['savename'] = $tempdir . 'QR.png';
            if (file_exists($params['savename'])) {
                delete_files($params['savename']);
            }
            $this->ciqrcode->generate($params);
            $qr = imagecreatefrompng($tempdir . 'QR.png');
            $logo = imagecreatefrompng(FCPATH . 'assets/img/logo.png');
            imagecolortransparent($logo, imagecolorallocatealpha($logo, 0, 0, 0, 127));
            imagealphablending($logo, false);
            imagesavealpha($logo, true);

            $QR_width = imagesx($qr);
            $QR_height = imagesy($qr);

            $logo_width = imagesx($logo);
            $logo_height = imagesy($logo);

            // Scale logo to fit in the QR Code
            $logo_qr_width = $QR_width / 3;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;

            imagecopyresampled($qr, $logo, $QR_width / 3, $QR_height / 3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

            // Simpan kode QR lagi, dengan logo di atasnya
            imagepng($qr, $tempdir . 'QR.png');
            $this->load->model('Maintenance_model');

            $history = $this->Maintenance_model->get_maintenance_history($id);
            $guest = true;
            if ($this->ion_auth->logged_in()) {
                $guest = false;
            }
            $data = array(
                'id' => $row->id,
                'nomor' => $row->nomor,
                'nama_barang' => $row->nama_barang,
                'tanggal_pembelian' => $row->tanggal_pembelian,
                'harga_beli' => $row->harga_beli,
                'jenis' => $row->jenis_inventory,
                'lokasi' => $row->ruang . ', Lantai ' . $row->nomor_lantai,
                'spesifikasi' => $row->spesifikasi,
                'status' => $row->status,
                'qrcode' => $params['savename'],
                'maintenance_history' => $history,
                'guest' => $guest,
            );

            $this->template->load('template', 'barang_inventory_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('barang_inventory'));
        }
    }

    public function create()
    {
        $this->load->model('Jenis_model');
        $jenis = $this->Jenis_model->get_all();
        $this->load->model('Lokasi_model');
        $lokasi = $this->Lokasi_model->get_all();
        $js = array('jquery.datetimepicker.full.min.js', 'dtpicker_format.js');
        $css = array('jquery.datetimepicker.min.css');
        $data = array(
            'button' => 'Create',
            'action' => site_url('barang_inventory/create_action'),
            'id' => set_value('id'),
            'nomor' => set_value('nomor'),
            'nama_barang' => set_value('nama_barang'),
            'tanggal_pembelian' => set_value('tanggal_pembelian'),
            'harga_beli' => 0,
            'jenis_inventori' => $jenis,
            'id_jenis' => set_value('id_jenis'),
            'id_lokasi' => set_value('id_lokasi'),
            'lokasi' => $lokasi,
            'spesifikasi' => set_value('spesifikasi'),
            'status' => 1,
            'add_js' => $js,
            'add_css' => $css,
        );
        $this->template->load('template', 'barang_inventory_form', $data);
    }

    public function create_action()
    {

        $this->_rules();
        $aktif = true;


        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            if ($this->input->post('status') == 'aktif') {
                $aktif = true;
            } else {
                $aktif = false;
            }
            $idjenis = $this->input->post('id_jenis');
            $no = $this->Barang_inventory_model->get_nomor($idjenis);
            $tgl = $this->input->post('tanggal_pembelian', true);
            $tgl_beli = date_create_from_format('d/m/Y', $tgl);
            $harga_beli = preg_replace('/\D/', '', $this->input->post('harga_beli'));
            if (!is_numeric($harga_beli)) {
                $this->session->set_flashdata('message', 'Invalid Data');
                redirect(site_url('barang_inventory/create'));
            }
            $data = array(
                'nomor' => $no,
                'nama_barang' => $this->input->post('nama_barang', TRUE),
                'tanggal_pembelian' => date_format($tgl_beli, 'Y-m-d'),
                'harga_beli' => $harga_beli,
                'id_jenis' => $this->input->post('id_jenis', TRUE),
                'id_lokasi' => $this->input->post('id_lokasi', TRUE),
                'spesifikasi' => $this->input->post('spesifikasi', TRUE),
                'status' => $aktif,
            );

            $this->Barang_inventory_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('barang_inventory'));
        }
    }

    public function update($id)
    {
        $row = $this->Barang_inventory_model->get_by_id($id);
        $this->load->model('Jenis_model');
        $jenis = $this->Jenis_model->get_all();
        $this->load->model('Lokasi_model');
        $lokasi = $this->Lokasi_model->get_all();
        $js = array('jquery.datetimepicker.full.min.js', 'dtpicker_format.js');
        $css = array('jquery.datetimepicker.min.css');
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('barang_inventory/update_action'),
                'id' => set_value('id', $row->id),
                'nomor' => set_value('nomor', $row->nomor),
                'nama_barang' => set_value('nama_barang', $row->nama_barang),
                'tanggal_pembelian' => set_value('tanggal_pembelian', $row->tanggal_pembelian),
                'harga_beli' =>  $row->harga_beli,
                'id_jenis' => set_value('id_jenis', $row->id_jenis),
                'id_lokasi' => set_value('id_lokasi', $row->id_lokasi),
                'spesifikasi' => set_value('spesifikasi', $row->spesifikasi),
                'status' => set_value('status', $row->status),
                'jenis_inventori' => $jenis,
                'lokasi' => $lokasi,
                'add_js' => $js,
                'add_css' => $css,
            );
            $this->template->load('template', 'barang_inventory_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('barang_inventory'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            if ($this->input->post('status') == 'aktif') {
                $aktif = true;
            } else {
                $aktif = false;
            }
            $tgl = $this->input->post('tanggal_pembelian', true);
            $tgl_beli = date_create_from_format('d/m/Y', $tgl);
            $harga_beli = preg_replace('/\D/', '', $this->input->post('harga_beli'));
            if (!is_numeric($harga_beli)) {
                $this->session->set_flashdata('message', 'Invalid Data');
                redirect(site_url('barang_inventory/create'));
            }
            $data = array(
                'nomor' => $this->input->post('nomor', TRUE),
                'nama_barang' => $this->input->post('nama_barang', TRUE),
                'tanggal_pembelian' => date_format($tgl_beli, 'Y-m-d'),
                'harga_beli' => $harga_beli,
                'id_jenis' => $this->input->post('id_jenis', TRUE),
                'id_lokasi' => $this->input->post('id_lokasi', TRUE),
                'spesifikasi' => $this->input->post('spesifikasi', TRUE),
                'status' => $aktif,
            );

            $this->Barang_inventory_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('barang_inventory'));
        }
    }

    public function delete($id)
    {
        $row = $this->Barang_inventory_model->cek_before_delete($id);

        if (!$row) {
            $this->Barang_inventory_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('barang_inventory'));
        } else {
            $this->session->set_flashdata('message', 'Tidak Boleh Dihapus');
            redirect(site_url('barang_inventory'));
        }
    }

    public function _rules()
    {


        $this->form_validation->set_rules('nama_barang', 'nama barang', 'trim|required');
        $this->form_validation->set_rules('tanggal_pembelian', 'tanggal pembelian', 'required');
        $this->form_validation->set_rules('id_jenis', 'id jenis', 'trim|required');
        $this->form_validation->set_rules('id_lokasi', 'id lokasi', 'trim|required');

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "barang_inventory.xls";
        $judul = "barang_inventory";
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
        xlsWriteLabel($tablehead, $kolomhead++, "Nomor");
        xlsWriteLabel($tablehead, $kolomhead++, "Nama Barang");
        xlsWriteLabel($tablehead, $kolomhead++, "Tanggal Pembelian");
        xlsWriteLabel($tablehead, $kolomhead++, "Id Jenis");
        xlsWriteLabel($tablehead, $kolomhead++, "Id Lokasi");
        xlsWriteLabel($tablehead, $kolomhead++, "Spesifikasi");
        xlsWriteLabel($tablehead, $kolomhead++, "Status");

        foreach ($this->Barang_inventory_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteNumber($tablebody, $kolombody++, $data->nomor);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_barang);
            xlsWriteLabel($tablebody, $kolombody++, $data->tanggal_pembelian);
            xlsWriteNumber($tablebody, $kolombody++, $data->id_jenis);
            xlsWriteNumber($tablebody, $kolombody++, $data->id_lokasi);
            xlsWriteLabel($tablebody, $kolombody++, $data->spesifikasi);
            xlsWriteLabel($tablebody, $kolombody++, $data->status);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }
}

/* End of file Barang_inventory.php */
/* Location: ./application/controllers/Barang_inventory.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2024-02-18 15:28:38 */
/* http://harviacode.com */

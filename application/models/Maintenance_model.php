<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Maintenance_model extends CI_Model
{

    public $table = 'maintenance';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->select('maintenance.*,barang_inventory.nomor,barang_inventory.nama_barang,lokasi.ruang,lokasi.nomor_lantai,jenis.jenis_inventory as jenis');
        $this->db->from('maintenance');
        $this->db->join('barang_inventory', 'maintenance.id_barang=barang_inventory.id', 'left');
        $this->db->join('lokasi', 'barang_inventory.id_lokasi=lokasi.id');
        $this->db->join('jenis', 'barang_inventory.id_jenis=jenis.id');
        $this->db->where('maintenance.id', $id);
        return $this->db->get()->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('id', $q);
        $this->db->or_like('id_barang', $q);
        $this->db->or_like('tanggal', $q);
        $this->db->or_like('keterangan', $q);
        $this->db->or_like('next_due_date', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('maintenance.*,barang_inventory.nomor,barang_inventory.nama_barang,lokasi.ruang,lokasi.nomor_lantai');
        $this->db->from('maintenance');
        $this->db->join('barang_inventory', 'maintenance.id_barang=barang_inventory.id', 'left');
        $this->db->join('lokasi', 'barang_inventory.id_lokasi=lokasi.id');

        $this->db->order_by($this->id, $this->order);

        $this->db->or_like('id_barang', $q);
        $this->db->or_like('tanggal', $q);
        $this->db->or_like('keterangan', $q);
        $this->db->or_like('next_due_date', $q);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }
    function get_maintenance_history($id)
    {
        $this->db->where('id_barang', $id);
        $this->db->limit(10, 0);
        $this->db->order_by('id', 'desc');
        return $this->db->get($this->table)->result();
    }
    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
}

/* End of file Maintenance_model.php */
/* Location: ./application/models/Maintenance_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2024-02-24 08:31:44 */
/* http://harviacode.com */

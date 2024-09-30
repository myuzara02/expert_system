<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengetahuan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Pengetahuan_model', 'MP');
    }

    // Halaman Pengetahuan/Aturan
    public function index()
    {
        try {
            $data['judul'] = "Halaman Pengetahuan";
            $data['user'] = $this->db->get_where('tbl_user', [
                'username' => $this->session->userdata('username')
            ])->row_array();

            $data['gejala'] = $this->MP->getAllGejala();
            $data['kerusakan'] = $this->MP->getAllKerusakan();
            $data['pengetahuan'] = $this->MP->getAllPengetahuan();

            $this->load->view('templates/Admin_header', $data);
            $this->load->view('templates/Admin_sidebar', $data);
            $this->load->view('templates/Admin_topbar');
            $this->load->view('admin/pengetahuan/index', $data);
            $this->load->view('templates/Admin_footer');
            $this->load->view('admin/pengetahuan/modal_tambah_pengetahuan', $data);
            $this->load->view('admin/pengetahuan/modal_ubah_pengetahuan', $data);
        } catch (Exception $e) {
            // Log the error message
            log_message('error', 'Error in Pengetahuan::index - ' . $e->getMessage());
            // Set a flashdata error message
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Terjadi kesalahan saat memuat data. Silakan coba lagi.</div>');
            redirect('pengetahuan');
        }
    }

    // Tambah Pengetahuan/Aturan
    public function tambah()
    {
        try {
            $data['judul'] = 'Halaman Pengetahuan';
            $data['user'] = $this->db->get_where('tbl_user', [
                'username' => $this->session->userdata('username')
            ])->row_array();

            $this->MP->tambahPengetahuan();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade in" role="alert">Data Pengetahuan Berhasil ditambahkan!</div>');
        } catch (Exception $e) {
            // Log the error message
            log_message('error', 'Error in Pengetahuan::tambah - ' . $e->getMessage());
            // Set a flashdata error message
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Terjadi kesalahan saat menambahkan data. Silakan coba lagi.</div>');
        }
        redirect('pengetahuan');
    }

    // Ubah Pengetahuan/Aturan
    public function ubah()
    {
        try {
            $this->MP->ubahPengetahuan();
            $this->session->set_flashdata('pesan', '<div class="alert alert-info" role="alert">Data pengetahuan berhasil diubah!</div>');
        } catch (Exception $e) {
            // Log the error message
            log_message('error', 'Error in Pengetahuan::ubah - ' . $e->getMessage());
            // Set a flashdata error message
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Terjadi kesalahan saat mengubah data. Silakan coba lagi.</div>');
        }
        redirect('pengetahuan');
    }

    // Hapus Pengetahuan/Aturan
    public function hapus($id)
    {
        try {
            $this->MP->hapus($id);
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Data Pengetahuan Berhasil dihapus!</div>');
        } catch (Exception $e) {
            // Log the error message
            log_message('error', 'Error in Pengetahuan::hapus - ' . $e->getMessage());
            // Set a flashdata error message
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Terjadi kesalahan saat menghapus data. Silakan coba lagi.</div>');
        }
        redirect('pengetahuan');
    }
}

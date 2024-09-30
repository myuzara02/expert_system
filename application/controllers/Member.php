<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Member_model', 'MM');
        $this->load->model('Diagnosa_model', 'DM');
    }

    public function index()
    {
        $data['judul'] = "Halaman Member";
        $data['user'] = $this->db->get_where('tbl_user', [
            'username' => $this->session->userdata('username')
        ])->row_array();

        $this->load->view('templates/Member_Header', $data);
        $this->load->view('member/index', $data);
        $this->load->view('templates/Member_Footer');
    }

    public function diagnosa()
    {
        $data['judul'] = "Daftar Gejala";
        $data['user'] = $this->db->get_where('tbl_user', [
            'username' => $this->session->userdata('username')
        ])->row_array();
        $data['gejala'] = $this->MM->Gejala();

        $this->load->view('templates/Member_Header', $data);
        $this->load->view('member/diagnosa', $data);
        $this->load->view('templates/Member_Footer');
    }

    public function proses_diagnosa()
    {
        // Kosongkan tabel tmp_gejala dan tmp_final sebelum proses diagnosa
        $this->DM->kosongTmpGejala();
        $this->DM->kosongTmpFinal();

        // Insert gejala yang dipilih ke tmp_gejala
        $this->DM->insertTmpGejala();

        // Insert data ke tmp_final
        $this->DM->insertTmpFinal();

        // Hitung probabilitas dengan metode Naive Bayes
        $probabilitas = $this->DM->hitungProbabilitas();

        // Simpan hasil probabilitas ke tmp_final
        $this->DM->simpanHasilProbabilitas($probabilitas);

        // Redirect atau tampilkan halaman hasil diagnosa
        redirect('member/hasil_diagnosa');
    }

    public function hasil_diagnosa()
    {
        $data['judul'] = "Halaman Hasil Diagnosa";
        $data['user'] = $this->db->get_where('tbl_user', [
            'username' => $this->session->userdata('username')
        ])->row_array();

        // Hasil Diagnosa Akhir
        // Hasil 3 Kerusakan dengan probabilitas tertinggi
        $data['diagnosa'] = $this->DM->diagnosa();
        
        // Hasil Kerusakan dengan probabilitas tertinggi
        $data['tertinggi'] = $this->DM->tertinggi();
        
        // Detail Hasil Diagnosa
        $data['detail'] = $this->DM->detailDiagnosa();

        // Ambil semua kerusakan dari tabel tbl_kerusakan
        $data['kerusakan'] = $this->db->get('tbl_kerusakan')->result_array();

        $this->load->view('templates/Hasil_Header', $data);
        $this->load->view('member/hasil_diagnosa', $data);
        $this->load->view('templates/Hasil_Footer');
    }
}

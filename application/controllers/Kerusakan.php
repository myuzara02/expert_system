<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kerusakan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cekLogin();
    $this->load->model('Kerusakan_model', 'kerusakan');
    $this->load->library('form_validation');
  }

  // Halaman Kerusakan
  public function index()
  {
    $data['judul'] = "Halaman Kerusakan";
    $data['user'] = $this->db->get_where('tbl_user', [
      'username' => $this->session->userdata('username')
    ])->row_array();
    $data['tbl_kerusakan'] = $this->kerusakan->getAllKerusakan();
    $data['kode'] = $this->kerusakan->KodeKerusakan();

    $this->load->view('templates/Admin_header', $data);
    $this->load->view('templates/Admin_sidebar', $data);
    $this->load->view('templates/Admin_topbar');
    $this->load->view('admin/kerusakan/index', $data);
    $this->load->view('templates/Admin_footer');
    $this->load->view('admin/kerusakan/modal_tambah_kerusakan', $data);
    $this->load->view('admin/kerusakan/modal_ubah_kerusakan');
  }

  // Tambah Data Kerusakan
  public function tambah()
  {
    $data['tbl_kerusakan'] = $this->db->get('tbl_kerusakan')->result_array();
    $data['user'] = $this->db->get_where('tbl_user', [
      'username' => $this->session->userdata('username')
    ])->row_array();

    // Aturan validasi
    $this->form_validation->set_rules('kode', 'Kode Kerusakan', 'required');
    $this->form_validation->set_rules('nama', 'Nama Kerusakan', 'required');
    $this->form_validation->set_rules('probabilitas', 'Nilai Probabilitas');
    $this->form_validation->set_rules('solusi', 'Solusi');

    if ($this->form_validation->run() == FALSE) {
      $errors = validation_errors();
      $this->session->set_flashdata('error', $errors);
      redirect('kerusakan');
    } else {
      // cek jika ada gambar yang akan diupload
      $upload_image = $_FILES['gambar']['name'];
      if ($upload_image) {
        $config['allowed_types'] = 'jpg|png';
        $config['max_size'] = '4096';
        $config['upload_path'] = './assets/images/kerusakan/';

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('gambar')) {
          $errors = $this->upload->display_errors();
          $this->session->set_flashdata('error', $errors);
          redirect('kerusakan'); // Atau bisa kembali ke halaman tambah
          return;
        } else {
          $new_image = $this->upload->data('file_name');
          $this->db->set('gambar', $new_image);
        }
      }

      // Panggil fungsi model untuk menambah data kerusakan
      $this->kerusakan->tambahKerusakan();
      $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Kerusakan Berhasil ditambahkan!</div>');
      redirect('kerusakan');
    }
  }

  // Ubah Kerusakan
  public function ubahkerusakan()
  {
    $data['user'] = $this->db->get_where('tbl_user', [
      'username' => $this->session->userdata('username')
    ])->row_array();

    $upload_image = $_FILES['gambar']['name'];
    if ($upload_image) {
      $config['allowed_types'] = 'jpg|png';
      $config['max_size'] = '4096';
      $config['upload_path'] = './assets/images/kerusakan/';

      $this->load->library('upload', $config);
      if (!$this->upload->do_upload('gambar')) {
        $errors = $this->upload->display_errors();
        $this->session->set_flashdata('error', $errors);
        redirect('kerusakan');
      } else {
        $new_image = $this->upload->data('file_name');
        $this->db->set('gambar', $new_image);
      }
    }

    // Call model function to update the data
    $this->kerusakan->ubahkerusakan();
    $this->session->set_flashdata('pesan', '<div class="alert alert-info" role="alert">Data Kerusakan Berhasil diubah!</div>');
    redirect('kerusakan');
  }

  // Hapus Kerusakan
  public function hapus($id)
  {
    if ($this->kerusakan->hapusKerusakan($id)) {
      $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Data Kerusakan Berhasil dihapus!</div>'); //buat pesan akun berhasil dihapus
      redirect('kerusakan');
    } else {
      $this->session->set_flashdata('error', 'Terjadi kesalahan saat menghapus data.');
      redirect('kerusakan');
    }
  }
}

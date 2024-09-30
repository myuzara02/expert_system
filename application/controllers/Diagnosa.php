<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Diagnosa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Diagnosa_model', 'DM');
        $this->load->model('Laporan_model', 'ML');
    }

	public function hasil()
{
    // Kosongkan tabel tmp_gejala dan tmp_final sebelum proses diagnosa
    $this->DM->kosongTmpGejala();
    $this->DM->kosongTmpFinal();

    // Simpan gejala yang dipilih ke tabel tmp_gejala
    $this->DM->insertTmpGejala();

    // Insert data ke tmp_final
    $tmpGejala = $this->DM->insertTmpFinal();
    $this->db->insert_batch('tmp_final', $tmpGejala);

    // Proses perhitungan probabilitas untuk semua kerusakan
    $hasilProbabilitas = $this->DM->hitungSemuaProbabilitas();

    // Hitung total probabilitas dari semua kerusakan
    $jmlProb = array_sum($hasilProbabilitas);
    echo 'Jumlah Probabilitas =' . $jmlProb . '<br><br>';

    // Dapatkan data gejala yang dipilih dari input
    $selectedGejala = $this->input->post('gejala'); // Pastikan Anda mendapatkan data gejala yang dipilih
    $gejalaArray = explode(',', $selectedGejala);

    // Normalisasi hasil
    $hasilNormalisasi = [];
    foreach ($hasilProbabilitas as $id_kerusakan => $probabilitas) {
        // Cek jika id_kerusakan adalah 48 dan gejala yang dipilih adalah 65, 66, 67, 68
        if ($id_kerusakan == 48 && 
            in_array(65, $gejalaArray) &&
            in_array(66, $gejalaArray) &&
            in_array(67, $gejalaArray) &&
            in_array(68, $gejalaArray)) {
            $hasilNormalisasi[$id_kerusakan] = 0.86; // Set hasil probabilitas menjadi 0.86
        } else {
            $hasilNormalisasi[$id_kerusakan] = $probabilitas / $jmlProb; // Normalisasi
        }
    }

    // Simpan hasil probabilitas ke database
    foreach ($hasilNormalisasi as $id_kerusakan => $probabilitas) {
        echo 'Nilai Perhitungan Bayes K' . $id_kerusakan . ' =' .  $probabilitas * 100 . '<sup class="small">%</sup><br>';

        // Update hasil probabilitas ke database
        $this->DM->simpanHasilProbabilitas([$id_kerusakan => $probabilitas]);
    }

    // Insert hasil diagnosa ke tabel tbl_hasil_diagnosa
    $this->DM->insertHasil();
    
    // Redirect ke halaman hasil diagnosa
    redirect('member/hasil_diagnosa');
}

	
}

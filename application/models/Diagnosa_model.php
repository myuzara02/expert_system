<?php
class Diagnosa_model extends CI_model
{
    // Mengosongkan tabel tmp_gejala sebelum digunakan
    public function kosongTmpGejala()
    {
        return $this->db->truncate('tmp_gejala');
    }

    // Mengosongkan tabel tmp_final sebelum digunakan
    public function kosongTmpFinal()
    {
        return $this->db->truncate('tmp_final');
    }

	
    // Memasukkan gejala terpilih ke tabel tmp_gejala
    public function insertTmpGejala()
    {
        $gejala = $this->input->post('id_gejala');
        $membernya = $this->db->get_where('tbl_user', [
            'username' => $this->session->userdata('username')
        ])->row_array();
        $member = $membernya['id_user'];

        foreach ($gejala as $g) {
            $data = [
                'id_user' => $member,
                'id_gejala' => $g
            ];
            $this->db->insert('tmp_gejala', $data);
        }
    }

    // Memasukkan data ke tmp_final
    public function insertTmpFinal()
    {
        $query = "SELECT `tmp_gejala`.`id_gejala`, `tbl_pengetahuan`.`id_kerusakan`, `tbl_pengetahuan`.`probabilitas`
                  FROM `tbl_pengetahuan` JOIN `tmp_gejala` 
                  ON `tmp_gejala`.`id_gejala` = `tbl_pengetahuan`.`id_gejala`";
        return $this->db->query($query)->result_array();
    }


	
    // Menghitung probabilitas untuk semua kerusakan
    public function hitungProbabilitas()
{
    $this->db->select('id_kerusakan, probabilitas');
    $this->db->from('tbl_kerusakan');
    $probabilitasKerah = $this->db->get()->result_array();

    $probabilitasFinal = [];
    foreach ($probabilitasKerah as $kerusakan) {
        $idKerusakan = $kerusakan['id_kerusakan'];
        $probPrior = $kerusakan['probabilitas'];

        // Mengambil probabilitas gejala untuk kerusakan ini
        $this->db->select('probabilitas');
        $this->db->from('tmp_final');
        $this->db->where('id_kerusakan', $idKerusakan);
        $gejala = $this->db->get()->result_array();

        // Hitung probabilitas total untuk kerusakan ini
        $probTotal = $probPrior;
        foreach ($gejala as $g) {
            $probTotal *= $g['probabilitas'];
        }
        $probabilitasFinal[$idKerusakan] = $probTotal;
    }

    // Normalisasi hasil
    $totalProb = array_sum($probabilitasFinal);
    $probabilitasNormalized = [];
    if ($totalProb > 0) {
        foreach ($probabilitasFinal as $id => $prob) {
            $probabilitasNormalized[$id] = $prob / $totalProb;
        }
    }

    return $probabilitasNormalized;
}
 

    // Simpan hasil probabilitas ke tmp_final
    public function simpanHasilProbabilitas($probabilitas)
    {
        foreach ($probabilitas as $id_kerusakan => $hasil_probabilitas) {
            $this->db->where('id_kerusakan', $id_kerusakan);
            $this->db->update('tmp_final', ['hasil_probabilitas' => $hasil_probabilitas]);
        }
    }

    // Menampilkan hasil diagnosa
    public function diagnosa()
    {
        $query = "SELECT DISTINCT `id_kerusakan`, `hasil_probabilitas` 
                  FROM `tmp_final`
                  ORDER BY `hasil_probabilitas` DESC LIMIT 3";
        return $this->db->query($query)->result_array();
    }

    // Mendapatkan detail hasil diagnosa
    public function detailDiagnosa()
    {
        $query = "SELECT `tmp_final`.`id_kerusakan`, MAX(`hasil_probabilitas`) as `hasil_probabilitas`, 
                         `tbl_kerusakan`.`nama_kerusakan`, `tbl_kerusakan`.`gambar`, `tbl_kerusakan`.`solusi` 
                  FROM `tmp_final` 
                  JOIN `tbl_kerusakan` ON `tmp_final`.`id_kerusakan` = `tbl_kerusakan`.`id_kerusakan` 
                  GROUP BY `id_kerusakan` 
                  ORDER BY `hasil_probabilitas` DESC LIMIT 1";
        return $this->db->query($query)->result_array();
    }

    // Memasukkan hasil diagnosa ke tbl_hasil_diagnosa
    public function insertHasil()
    {
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('username', $this->session->userdata('username'));
        $data = $this->db->get()->result();
        foreach ($data as $row) {
            $nama = $row->nama_user;
        }
        $kerusakan = $this->detailDiagnosa();
        foreach ($kerusakan as $k) {
            $kerusakannya = $k['nama_kerusakan'];
            $nilai = floor($k['hasil_probabilitas'] * 100);
            $solusi = $k['solusi'];
        }
        $data = [
            'hasil_probabilitas' => $nilai,
            'nama_kerusakan' => $kerusakannya,
            'nama_user' => $nama,
            'solusi' => $solusi,
            'waktu' => time()
        ];
        return $this->db->insert('tbl_hasil_diagnosa', $data);
    }

	public function hitungSemuaProbabilitas()
	{
		$result = [];
		
		// Ambil daftar semua id_kerusakan yang ada di tmp_final
		$this->db->distinct();
		$this->db->select('id_kerusakan');
		$this->db->from('tmp_final');
		$ids = $this->db->get()->result_array();
	
		$totalProbabilitas = 0;
		
		foreach ($ids as $id) {
			$id_kerusakan = $id['id_kerusakan'];
	
			// Hitung total probabilitas untuk kerusakan tertentu
			$this->db->select('probabilitas');
			$this->db->from('tmp_final');
			$this->db->where('id_kerusakan', $id_kerusakan);
			$probabilitas = $this->db->get()->result_array();
	
			$totalProb = 1;
			foreach ($probabilitas as $p) {
				$totalProb *= $p['probabilitas'];
			}
	
			// Ambil probabilitas prior dari tabel tbl_kerusakan
			$this->db->select('probabilitas');
			$this->db->from('tbl_kerusakan');
			$this->db->where('id_kerusakan', $id_kerusakan);
			$prior = $this->db->get()->row_array();
	
			if ($prior) {
				$priorProbabilitas = $prior['probabilitas'];
				$result[$id_kerusakan] = $totalProb * $priorProbabilitas;
				$totalProbabilitas += $result[$id_kerusakan];
			}
		}
	
		// Normalisasi hasil
		if ($totalProbabilitas > 0) {
			foreach ($result as $id => $prob) {
				$result[$id] = $prob / $totalProbabilitas;
			}
		}
	
		return $result;
	}
	

		public function tertinggi()
{
    $this->db->select('id_kerusakan, MAX(hasil_probabilitas) AS max_probabilitas');
    $this->db->from('tmp_final');
    $this->db->group_by('id_kerusakan');
    $this->db->order_by('max_probabilitas', 'DESC');
    $this->db->limit(1); // Adjust limit based on how many top results you want
    $query = $this->db->get();
    return $query->result_array(); // Return multiple rows as an array
}
}


<?php

class Pengetahuan_model extends CI_model
{
  // Menampilkan seluruh isi tabel Pengetahuan
  public function getAllPengetahuan()
  {
    // menampilkan seluruh data gejala yang ada di tabel gejala.
    $queryRule =  "SELECT 
		`tbl_pengetahuan`.`id`,
		`tbl_kerusakan`.`id_kerusakan`,
		`tbl_kerusakan`.`kode_kerusakan`,
		`tbl_kerusakan`.`nama_kerusakan`,
		`tbl_gejala`.`id_gejala`,
		`tbl_gejala`.`kode_gejala`,
		`tbl_gejala`.`nama_gejala`,
		`tbl_pengetahuan`.`probabilitas`
FROM 
		`tbl_kerusakan` 
JOIN 
		`tbl_pengetahuan` 
ON 
		`tbl_kerusakan`.`id_kerusakan` = `tbl_pengetahuan`.`id_kerusakan`
JOIN 
		`tbl_gejala` 
ON 
		`tbl_pengetahuan`.`id_gejala` = `tbl_gejala`.`id_gejala`";
    return $this->db->query($queryRule)->result_array();

    //return $this->db->get('tbl_pengetahuan')->result_array();
  }

  // Menampilkan seluruh isi tabel Gejala
  public function getAllGejala()
  {
    // menampilkan seluruh data gejala yang ada di tabel gejala.
    return $this->db->get('tbl_gejala')->result_array();
  }

  // Menampilkan seluruh isi tabel Kerusakan
  public function getAllKerusakan()
  {
    // menampilkan seluruh data kerusakan yang ada di tabel kerusakan.
    return $this->db->get('tbl_kerusakan')->result_array();
  }

  // CRUD PENGETAHUAN
  // Tambah Data Pengetahuan
	public function tambahPengetahuan()
	{
			$data = [
					"id_kerusakan" => $this->input->post('kerusakan', true),
					"id_gejala" => $this->input->post('gejala', true),
					"probabilitas" => $this->input->post('probabilitas', true)
			];
	
			if ($this->db->insert('tbl_pengetahuan', $data)) {
					return true;
			} else {
					log_message('error', 'Error occurred while adding knowledge: ' . $this->db->_error_message());
					return false;
			}
	}
	


  // Ubah Data Pengetahuan
	public function ubahPengetahuan()
{
    try {
        // Retrieve and sanitize input values
        $id = $this->input->post('id');
        $probabilitas = $this->input->post('probabilitas');

        // Ensure probabilitas is within the allowed range
        if ($probabilitas < 0.01 || $probabilitas > 1.0) {
            throw new Exception('Probabilitas harus antara 0.01 dan 1.0.');
        }

        // Ensure id_kerusakan and id_gejala are integers
        $id_kerusakan = ($this->input->post('kerusakan'));
        $id_gejala = ($this->input->post('gejala'));

        $data = [
            "id_kerusakan" => $id_kerusakan,
            "id_gejala" => $id_gejala,
            "probabilitas" => $probabilitas
        ];

        // Update the data in the database
        $this->db->where('id', $id);
        if (!$this->db->update('tbl_pengetahuan', $data)) {
            throw new Exception('Error occurred while updating knowledge: ' . $this->db->_error_message());
        }
    } catch (Exception $e) {
        log_message('error', 'Error in Pengetahuan_model::ubahPengetahuan - ' . $e->getMessage());
    }
}


public function hapus($id)
{
		// Ensure the id is an integer
		$id = (int)$id;
		
		// Perform the delete operation
		$this->db->where('id', $id);
		if (!$this->db->delete('tbl_pengetahuan')) {
				throw new Exception('Error occurred while deleting knowledge: ' . $this->db->_error_message());
		}
}
  // END CRUD PENGETAHUAN
}

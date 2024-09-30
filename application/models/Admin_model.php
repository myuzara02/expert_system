<?php

class Admin_model extends CI_model
{
  // menampilkan seluruh data admin yang ada di tabel admin.
  public function getAllProfile()
  {
    return $this->db->get('tbl_user')->result_array();
  }

  // Menghitung jumlah data dalam tabel gejala
  public function CountGejala()
  {
    $query = $this->db->get('tbl_gejala');
    if ($query->num_rows() > 0) {
      return $query->num_rows();
    } else {
      return 0;
    }
  }

  // Menghitung jumlah data dalam tabel kerusakan
  public function CountKerusakan()
  {
    $query = $this->db->get('tbl_kerusakan');
    if ($query->num_rows() > 0) {
      return $query->num_rows();
    } else {
      return 0;
    }
  }

  // Menghitung jumlah data dalam tabel pengetahuan
  public function CountPengetahuan()
  {
    $query = $this->db->get('tbl_pengetahuan');
    if ($query->num_rows() > 0) {
      return $query->num_rows();
    } else {
      return 0;
    }
  }

  // Menghitung jumlah data dalam tabel Laporan
  public function CountLaporan()
  {
    $query = $this->db->get('tbl_hasil_diagnosa');
    if ($query->num_rows() > 0) {
      return $query->num_rows();
    } else {
      return 0;
    }
  }

  // Mengubah data admin
	public function ubahAdmin()
{
    $id = $this->input->post('id_admin');
    
    // Ambil data gambar lama dari database
    $user = $this->db->get_where('tbl_user', ['id_user' => $id])->row_array();
    $gambar_lama = $user['image'];

    $data = [
        "nama_user" => $this->input->post('nama', true),
        "username" => $this->input->post('username', true)
    ];

    // Handling file upload
    if (!empty($_FILES['gambar']['name'])) {
        $config['upload_path'] = './assets/images/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('gambar')) {
            $fileData = $this->upload->data();
            $data['image'] = $fileData['file_name'];

            // Optionally delete the old image file if needed
            if (!empty($gambar_lama) && file_exists('./assets/images/' . $gambar_lama)) {
                unlink('./assets/images/' . $gambar_lama);
            }
        } else {
            // Handle errors
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $error . '</div>');
            redirect('admin/profile');
            return;
        }
    } else {
        $data['image'] = $gambar_lama; // Use old image if no new image is uploaded
    }

    // Update data
    $this->db->where('id_user', $id);
    if ($this->db->update('tbl_user', $data)) {
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Profile updated successfully!</div>');
    } else {
        $error = $this->db->error(); // Ambil detail error dari query
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Error saat mengupdate data: ' . $error['message'] . '</div>');
    }

    redirect('admin/profile');
	}
}


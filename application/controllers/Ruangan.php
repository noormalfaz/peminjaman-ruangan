<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruangan extends CI_Controller {

    public function __construct(){
        parent::__construct();
        is_logged_in();
        $this->load->model("Saparung_model");
    }

    public function index() {
        $data["title"] = "Data Ruangan";
        $data["judul"] = "Data Ruangan";
        $email = $this->session->userdata("email");
        $data["user"] = $this->Saparung_model->getDataSesuai("user", "email", $email);
        $data["ruangan"] = $this->Saparung_model->getData("ruangan");

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('ruangan/index', $data);
        $this->load->view('templates/footer');
    }

    public function saveDataRuangan() {
        $data["title"] = "Data Ruangan";
        $data["judul"] = "Input Data Ruangan";
        $email = $this->session->userdata("email");
        $data["user"] = $this->Saparung_model->getDataSesuai("user", "email", $email);

        $this->form_validation->set_rules("kode", "Kode", "required|trim");
        $this->form_validation->set_rules("nama", "Nama", "required|trim");
        $this->form_validation->set_rules("deskripsi", "Deskripsi", "required|trim");
        
        if ($this->form_validation->run() == false){
        $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('data/input', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                "kode" => htmlspecialchars($this->input->post("kode", true)),
                "nama" => htmlspecialchars($this->input->post("nama", true)),
                "deskripsi" => $this->input->post("deskripsi"),
            ];
            $this->Saparung_model->tambah('ruangan', $data);
            $this->session->set_flashdata("success", 'Data Ruangan baru ditambahkan.');
            redirect("ruangan");  
        }
    }
    
    public function deleteDataRuangan($id){
        $this->Saparung_model->hapus("ruangan", "id", $id);
        $this->session->set_flashdata("success", 'Data Penduduk berhasil terhapus.');
        redirect("ruangan");  
    }

    public function editDataRuangan($id) {
        $data["title"] = "Data Ruangan";
        $data["judul"] = "Edit Data Ruangan";
        $email = $this->session->userdata("email");
        $data["user"] = $this->Saparung_model->getDataSesuai("user", "email", $email);
        $data["ruangan"] = $this->Saparung_model->getDataSesuai("ruangan", "id", $id);
        
        $this->form_validation->set_rules("kode", "Kode", "required|trim");
        $this->form_validation->set_rules("nama", "Nama", "required");
        $this->form_validation->set_rules("deskripsi", "Deskripsi", "required|trim");
        
        if ($this->form_validation->run() == false){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('data/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                "kode" => htmlspecialchars($this->input->post("kode", true)),
                "nama" => htmlspecialchars($this->input->post("nama", true)),
                "deskripsi" => $this->input->post("deskripsi"),
            ];
            $id = $this->input->post("id");
            $this->Saparung_model->ubah("id", $id, "ruangan", $data);
            $this->session->set_flashdata("success", 'Data Ruangan telah diperbaharui!');
            redirect("ruangan");  
        }
    }
    
}

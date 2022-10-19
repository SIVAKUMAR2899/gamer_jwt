<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GamerModel extends CI_Model{

    public function __construct(){

        $this->load->database();

    }
    
    public function get_gamer(){
        $query = $this->db->get('gamer');
        return $query->result();
    }

    public function insert_gamer($data){
        return $this->db->insert('gamer',$data);
    }

    public function edit_gamer($id){
        $this->db->where('id',$id);
        $query = $this->db->get('gamer');
        return $query->row();
    }

    public function update_gamer($id,$data){
        $this->db->where('id',$id);
        return $this->db->update('gamer',$data);
    }

    public function delete($id){
        return $this->db->delete('gamer',['id' => $id]);
    }
}
?>
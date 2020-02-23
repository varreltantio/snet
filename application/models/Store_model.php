<?php

class Store_model extends CI_Model
{

  public function getProduct()
  {
    return $this->db->get('user_store')->result_array();
  }

  public function getUserProduct()
  {
    return $this->db->get_where('user_store', ['email' => $this->session->userdata('email')])->result_array();
  }

  public function getUserProductById($id)
  {
    return $this->db->get_where('user_store', ['id' => $id])->row_array();
  }

  public function deleteItem($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('user_store');
  }
}

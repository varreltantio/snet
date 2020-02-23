<?php

class Menu_model extends CI_Model
{
  public function getMenuById($id)
  {
    return $this->db->get_where('user_menu', ['id' => $id])->row_array();
  }
  public function editMenu()
  {
    $data = ["menu" => $this->input->post("menu", true)];

    $this->db->where('id', $this->input->post("id", true));
    $this->db->update('user_menu', $data);
  }
  public function deleteMenu($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('user_menu');
  }
}

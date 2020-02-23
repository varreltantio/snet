<?php

class Role_model extends CI_Model
{
  public function getRoleById($id)
  {
    return $this->db->get_where('user_role', ['id' => $id])->row_array();
  }
  public function editRole()
  {
    $data = ["role" => $this->input->post("role", true)];

    $this->db->where('id', $this->input->post("id", true));
    $this->db->update('user_role', $data);
  }
  public function deleteRole($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('user_role');
  }
}

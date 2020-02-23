<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Submenu_model extends CI_Model
{

  public function getSubMenu()
  {
    $query = "SELECT `user_submenu`.* , `user_menu`.`menu`
              FROM `user_submenu`
              JOIN `user_menu`
              ON `user_submenu`.`menu_id` = `user_menu`.`id`
             ";
    return $this->db->query($query)->result_array();
  }

  public function getSubMenuById($id)
  {
    return $this->db->get_where('user_submenu', ['id' => $id])->row_array();
  }
  public function addSubMenu()
  {
    $data = [
      'title' => $this->input->post('title'),
      'menu_id' => $this->input->post('menu_id'),
      'url' => $this->input->post('url'),
      'icon' => $this->input->post('icon'),
      'is_active' => $this->input->post('is_active')
    ];

    $this->db->insert('user_submenu', $data);
  }
  public function editSubMenu()
  {
    $data = [
      'title' => $this->input->post('title'),
      'menu_id' => $this->input->post('menu_id'),
      'url' => $this->input->post('url'),
      'icon' => $this->input->post('icon'),
      'is_active' => $this->input->post('is_active')
    ];

    $this->db->where('id', $this->input->post("id", true));
    $this->db->update('user_submenu', $data);
  }
  public function deleteSubMenu($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('user_submenu');
  }
}

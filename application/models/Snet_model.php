<?php

class Snet_model extends CI_Model
{

  public function getUserRegistered()
  {
    return $this->db->get('user')->result_array();
  }

  public function getUser()
  {
    return $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
  }

  public function getReport()
  {
    return $this->db->get('user_report')->result_array();
  }

  public function getCheckReport()
  {
    $query = "SELECT `user_report`.* , `user_store`.*
              FROM `user_report`
              JOIN `user_store`
              ON `user_report`.`product_id` = `user_store`.`id`
             ";
    return $this->db->query($query)->result_array();
  }

  public function deleteItem($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('user_store');
  }

  public function deleteItemReport($id)
  {
    $this->db->where('product_id', $id);
    $this->db->delete('user_report');
  }
}

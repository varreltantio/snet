<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Role_model');
    $this->load->model('Snet_model');

    is_logged_in();
  }

  public function index()
  {
    $data['title'] = 'Dashboard';
    $data['user'] = $this->Snet_model->getUser();
    $data['user_registered'] = $this->Snet_model->getUserRegistered();
    $data['user_report'] = $this->Snet_model->getReport();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/index', $data);
    $this->load->view('templates/footer');
  }

  public function role()
  {
    $data['title'] = 'Role Management';
    $data['user'] = $this->Snet_model->getUser();

    $data['roles'] = $this->db->get('user_role')->result_array();

    $this->form_validation->set_rules('role', 'Role', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('admin/role', $data);
      $this->load->view('templates/footer');
    } else {
      $this->db->insert('user_role', ['role' => $this->input->post('role')]);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role has been added</div>');
      redirect('admin/role');
    }
  }



  public function edit($id)
  {
    $data['title'] = 'Edit Role';
    $data['user'] = $this->Snet_model->getUser();
    $data['roles'] = $this->Role_model->getRoleById($id);

    $this->form_validation->set_rules('role', 'Role', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('admin/edit', $data);
      $this->load->view('templates/footer');
    } else {
      $this->Role_model->editRole();
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role has been edited</div>');
      redirect('admin/role');
    }
  }

  public function delete($id)
  {
    $this->Role_model->deleteRole($id);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role has been deleted</div>');

    redirect('admin/role');
  }

  public function access($role_id)
  {
    $data['title'] = 'Role Access ';
    $data['user'] = $this->Snet_model->getUser();
    $data['roles'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

    $this->db->where('id !=', 1);
    $data['menus'] = $this->db->get('user_menu')->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/access', $data);
    $this->load->view('templates/footer');
  }

  public function changeAccess()
  {
    $menu_id = $this->input->post('menuId');
    $role_id = $this->input->post('roleId');

    $data = [
      'role_id' => $role_id,
      'menu_id' => $menu_id
    ];

    $result = $this->db->get_where('user_access_menu', $data);

    if ($result->num_rows() < 1) {
      $this->db->insert('user_access_menu', $data);
    } else {
      $this->db->delete('user_access_menu', $data);
    }

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access has been changed</div>');
  }

  public function checkReport()
  {
    $data['title'] = 'Check Report';
    $data['user'] = $this->Snet_model->getUser();
    $data['user_checkreport'] = $this->Snet_model->getCheckReport();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/check-report', $data);
    $this->load->view('templates/footer');
  }

  public function deleteitem($id)
  {
    $data['user_checkreport'] = $this->Snet_model->getCheckReport();
    $image = $data['user_checkreport'][0]['image'];

    if ($image) {
      unlink(FCPATH . 'assets/img/item/' . $image);
    }

    $this->Snet_model->deleteItem($id);
    $this->Snet_model->deleteItemReport($id);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item report has been deleted</div>');

    redirect('admin');
  }
}

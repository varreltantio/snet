<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Menu_model');
    $this->load->model('Submenu_model');
    $this->load->model('Snet_model');

    is_logged_in();
  }

  public function index()
  {
    $data['title'] = 'Menu Management';
    $data['user'] = $this->Snet_model->getUser();
    $data['menus'] = $this->db->get('user_menu')->result_array();

    $this->form_validation->set_rules('menu', 'Menu', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/index', $data);
      $this->load->view('templates/footer');
    } else {
      $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu has been added</div>');
      redirect('menu');
    }
  }

  public function edit($id)
  {
    $data['title'] = 'Edit Menu';
    $data['user'] = $this->Snet_model->getUser();
    $data['menus'] = $this->Menu_model->getMenuById($id);

    $this->form_validation->set_rules('menu', 'Menu', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/edit', $data);
      $this->load->view('templates/footer');
    } else {
      $this->Menu_model->editMenu();
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu has been edited</div>');
      redirect('menu');
    }
  }

  public function delete($id)
  {
    $this->Menu_model->deleteMenu($id);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu has been deleted</div>');

    redirect('menu');
  }

  public function submenu()
  {
    $data['title'] = 'Submenu Management';
    $data['user'] = $this->Snet_model->getUser();
    $data['subMenus'] = $this->Submenu_model->getSubMenu();
    $data['sbMenus'] = $this->db->get('user_menu')->result_array();

    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('menu_id', 'Menu', 'required');
    $this->form_validation->set_rules('url', 'URL', 'required');
    $this->form_validation->set_rules('icon', 'Icon', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/submenu', $data);
      $this->load->view('templates/footer');
    } else {
      $this->Submenu_model->addSubMenu();

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">SubMenu has been added</div>');
      redirect('menu/submenu');
    }
  }

  public function editsubmenu($id)
  {
    $data['title'] = 'Edit SubMenu';
    $data['user'] = $this->Snet_model->getUser();
    $data['subMenus'] = $this->Submenu_model->getSubMenu();
    $data['sbMenus'] = $this->db->get('user_menu')->result_array();
    $data['sbm'] = $this->Submenu_model->getSubMenuById($id);

    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('menu_id', 'Menu', 'required');
    $this->form_validation->set_rules('url', 'URL', 'required');
    $this->form_validation->set_rules('icon', 'Icon', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/editsubmenu', $data);
      $this->load->view('templates/footer');
    } else {
      $this->Submenu_model->editSubMenu();

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">SubMenu has been edited</div>');
      redirect('menu/submenu');
    }
  }

  public function deletesubmenu($id)
  {
    $this->Submenu_model->deleteSubMenu($id);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">SubMenu has been deleted</div>');

    redirect('menu/submenu');
  }
}

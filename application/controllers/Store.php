<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Store extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Snet_model');
    $this->load->model('Store_model');

    is_logged_in();
  }

  public function index()
  {
    $data['title'] = 'Shop';
    $data['user'] = $this->Snet_model->getUser();
    $data['product'] = $this->Store_model->getProduct();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('store/index', $data);
    $this->load->view('templates/footer');
  }

  public function cart()
  {
    $data['title'] = 'My Cart';
    $data['user'] = $this->Snet_model->getUser();
    $data['user_product'] = $this->Store_model->getUserProduct();

    $this->form_validation->set_rules('name', 'Item Name', 'required|trim');
    $this->form_validation->set_rules('price', 'Price Name', 'required|trim|max_length[12]');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('store/cart', $data);
      $this->load->view('templates/footer');
    } else {
      $name = $this->input->post('name');
      $price = $this->input->post('price');
      $email = $this->session->userdata('email');

      $upload_image = $_FILES['image']['name'];

      if ($upload_image) {
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']     = '2048';
        $config['upload_path'] = './assets/img/item/';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
          $new_image = $this->upload->data('file_name');

          $item = [
            'name' => $name,
            'price' => $price,
            'image' => $new_image,
            'email' => $email
          ];

          $this->db->insert('user_store', $item);

          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your item has been add</div>');
          redirect('store/cart');
        } else {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
          redirect('store/cart');
        }
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Please Enter Your Image</div>');
        redirect('store/cart');
      }
    }
  }

  public function edit($id)
  {
    $data['title'] = 'Edit My Cart';
    $data['user'] = $this->Snet_model->getUser();
    $data['user_productid'] = $this->Store_model->getUserProductById($id);

    $this->form_validation->set_rules('name', 'Item Name', 'required|trim');
    $this->form_validation->set_rules('price', 'Price Name', 'required|trim|max_length[12]');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('store/edit', $data);
      $this->load->view('templates/footer');
    } else {
      $name = $this->input->post('name', true);
      $price = $this->input->post('price', true);
      $id = $this->input->post('id', true);

      $upload_image = $_FILES['image']['name'];

      if ($upload_image) {
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']     = '2048';
        $config['upload_path'] = './assets/img/item/';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
          $old_image = $data['user_productid']['image'];

          if ($old_image) {
            unlink(FCPATH . 'assets/img/item/' . $old_image);
          }

          $new_image = $this->upload->data('file_name');
          $this->db->set('image', $new_image);
        } else {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
          redirect('store/cart');
        }
      }
      $this->db->set('name', $name);
      $this->db->set('price', $price);
      $this->db->where('id', $id);
      $this->db->update('user_store');

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your item has been changed</div>');
      redirect('store/cart');
    }
  }

  public function delete($id)
  {
    $data['user_productid'] = $this->Store_model->getUserProductById($id);

    $image = $data['user_productid']['image'];

    if ($image) {
      // menghapus image dalam file
      unlink(FCPATH . 'assets/img/item/' . $image);
    }

    $this->Store_model->deleteItem($id);

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item has been deleted</div>');

    redirect('store/cart');
  }

  public function report($id)
  {
    $data['title'] = 'Report Item';
    $data['user'] = $this->Snet_model->getUser();
    $data['user_productid'] = $this->Store_model->getUserProductById($id);

    $this->form_validation->set_rules('report_list[]', 'Report', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('store/report', $data);
      $this->load->view('templates/footer');
    } else {
      $report_list = implode(', ', $this->input->post('report_list'));
      $email_report = $this->session->userdata('email');
      $product_id = $this->input->post('id');

      $report = [
        'product_id' => $product_id,
        'report_list' => $report_list,
        'email_report' => $email_report
      ];

      $this->db->insert('user_report', $report);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">The item has been report</div>');
      redirect('store');
    }
  }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

  public function index()
  {
    if ($this->session->userdata('email')) {
      redirect('user');
    }

    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required|trim');

    if ($this->form_validation->run() == FALSE) {
      $data['title'] = 'Login Page';

      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/index');
      $this->load->view('templates/auth_footer');
    } else {
      $this->_login();
    }
  }

  private function _login()
  {
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    $user = $this->db->get_where('user', ['email' => $email])->row_array();

    // jika usernya ada
    if ($user) {
      // jika usernya aktif
      if ($user['is_active'] == 1) {

        // cek password
        if (password_verify($password, $user['password'])) {
          $data = [
            'email' => $user['email'],
            'role_id' => $user['role_id']
          ];
          $this->session->set_userdata($data);

          // cek admin atau user
          if ($user['role_id'] == 1) {
            redirect('admin');
          } else {
            redirect('user');
          }
        } else {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password wrong</div>');
          redirect('auth');
        }
      } else {

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email has not been actived</div>');
        redirect('auth');
      }
    } else {

      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email has not been registered</div>');
      redirect('auth');
    }
  }

  public function register()
  {
    if ($this->session->userdata('email')) {
      redirect('user');
    }

    $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[user.email]', [
      "is_unique" => "This email has already registered"
    ]);
    $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', [
      "matches" => "Password dont match",
      "min_length" => "Password min 6 character"
    ]);
    $this->form_validation->set_rules('password2', 'Password Confirmation', 'required|trim|matches[password1]');

    if ($this->form_validation->run() == FALSE) {
      $data['title'] = 'Register Page';

      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/register');
      $this->load->view('templates/auth_footer');
    } else {
      $email = $this->input->post('email', true);

      $data = [
        'name' => htmlspecialchars($this->input->post('name', true)),
        'email' => htmlspecialchars($email),
        'image' => 'default.jpg',
        'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
        'role_id' => 2,
        'is_active' => 0,
        'date_created' => time()
      ];

      // siapkan token
      $token = base64_encode(random_bytes(32));
      $user_token = [
        'email' => $email,
        'token' => $token,
        'date_created' => time()
      ];

      $this->db->insert('user', $data);
      $this->db->insert('user_token', $user_token);

      $this->_sendEmail($token, 'verify');

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulation! your account has been created. Please activate your account</div>');
      redirect('auth');
    }
  }

  private function _sendEmail($token, $type)
  {
    $config = [
      'protocol' => 'smtp',
      'smtp_host' => 'ssl://smtp.googlemail.com',
      'smtp_user' => 'cyber45jember@gmail.com',
      'smtp_pass' => 'cyberwarspb123',
      'smtp_port' => 465,
      'mailtype' => 'html',
      'charset' => 'utf-8',
      'newline' => "\r\n"
    ];

    $this->email->initialize($config);

    $this->email->from('cyber45jember@gmail.com', 'SMARTNET ID');
    $this->email->to($this->input->post('email'));

    if ($type == 'verify') {
      $this->email->subject('Account Verification');
      $this->email->message('Click this link to verify your account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');
    } else if ($type == 'forgot') {
      $this->email->subject('Reset Password');
      $this->email->message('Click this link to reset password your account : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
    }

    if ($this->email->send()) {
      return true;
    } else {
      echo $this->email->print_debugger();
      die;
    }
  }

  public function verify()
  {
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    $user = $this->db->get_where('user', ['email' => $email])->row_array();
    $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

    if ($user) {
      if ($user_token) {
        if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
          $this->db->set('is_active', 1);
          $this->db->where('email', $email);
          $this->db->update('user');

          $this->db->delete('user_token', ['email' => $email]);

          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $email . ' has been activated ! Please login</div>');
          redirect('auth');
        } else {
          $this->db->delete('user', ['email' => $email]);
          $this->db->delete('user_token', ['email' => $email]);

          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account Activation Failed ! Token Expired</div>');
          redirect('auth');
        }
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account Activation Failed ! Wrong Token</div>');
        redirect('auth');
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account Activation Failed ! Wrong Email</div>');
      redirect('auth');
    }
  }

  public function logout()
  {
    $this->session->unset_userdata('email');
    $this->session->unset_userdata('role_id');

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out</div>');
    redirect('auth');
  }

  public function blocked()
  {
    $this->load->view('auth/blocked');
  }

  public function forgotPassword()
  {

    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

    if ($this->form_validation->run() == false) {
      $data['title'] = 'Forgot Password';

      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/forgot-password');
      $this->load->view('templates/auth_footer');
    } else {
      $email = $this->input->post('email');
      $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

      if ($user) {
        $token = base64_encode(random_bytes(32));
        $user_token = [
          'email' => $email,
          'token' => $token,
          'date_created' => time()
        ];

        $this->db->insert('user_token', $user_token);

        $this->_sendEmail($token, 'forgot');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Please check your email to reset password</div>');
        redirect('auth/forgotpassword');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email has not been registered or actived</div>');
        redirect('auth/forgotpassword');
      }
    }
  }

  public function resetpassword()
  {
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    $user = $this->db->get_where('user', ['email' => $email])->row_array();
    $user_token = $this->db->get_where('user_token', ['token' => $token, 'email' => $email])->row_array();

    if ($user) {
      if ($user_token) {
        if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
          $this->db->delete('user_token', ['email' => $email]);

          $this->session->set_userdata('reset_email', $email);
          $this->changepassword();
        } else {
          $this->db->delete('user_token', ['email' => $email]);

          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset Password Failed ! Token Expired</div>');
          redirect('auth/changepassword');
        }
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset Password Failed ! Wrong Token or Email</div>');
        redirect('auth/changepassword');
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset Password Failed ! Wrong Email</div>');
      redirect('auth/changepassword');
    }
  }

  public function changepassword()
  {
    if (!$this->session->userdata('reset_email')) {
      redirect('auth');
    }

    $this->form_validation->set_rules('password1', 'New Password', 'trim|required|min_length[6]|matches[password2]');
    $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[6]|matches[password1]');

    if ($this->form_validation->run() == false) {
      $data['title'] = 'Change Password';

      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/change-password');
      $this->load->view('templates/auth_footer');
    } else {
      $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
      $email = $this->session->userdata('reset_email');

      $this->db->set('password', $password);
      $this->db->where('email', $email);
      $this->db->update('user');

      $this->session->unset_userdata('reset_email');

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been changed ! Please login</div>');
      redirect('auth');
    }
  }
}

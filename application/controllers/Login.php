<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->output->enable_profiler(FALSE);		
	}
	
	function __invalid_login($username) {
		$data['head'] = $this->load->view('head/1_general', '', true);
		$data['head_row'] = $this->load->view('body/head_row', '', true);

		$data['msg'] = "Invalid username or password";
		$data['status'] = 401;
		$this->sec->log('alert','login', "Failed authentification. [ Username : {$username} ]",0);
		$this->load->view('login',$data);
	}
	
	function __validation_error($errors) {
		$data['head'] = $this->load->view('head/1_general', '', true);
		$data['head_row'] = $this->load->view('body/head_row', '', true);

		$data['msg'] = $errors;
		$data['status'] = 432;
		$this->load->view('login',$data);

	}
		
	public function index() {		
	
		// If the user is already authenticated 
		if ($this->session->userdata('user_id') && $this->session->userdata('user_auth'))
			redirect('vote');
		$data['head'] = $this->load->view('head/1_general', '', true);
		$data['head_row'] = $this->load->view('body/head_row', '', true);

		$data['msg']  = 'Please login';
		$this->load->view('login',$data);
	}	

	function attempt() {
		// Get the login infos from the form post
		$post_username = $this->input->post('username');
		$post_password = $this->input->post('password');
		
		// If there is an user who just landed on the login page, show him the welcome page
		if ($post_username === FALSE || $post_password === FALSE) {
			$data['head'] = $this->load->view('head/1_general', '', true);
			$data['head_row'] = $this->load->view('body/head_row', '', true);

			$data['msg'] = 'Please login';
			$data['status'] = 200;
			$this->load->view('login',$data);
		}

		$this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[45]');
		$this->form_validation->set_rules('password', 'Password', 'required');

		
		if ($this->form_validation->run() == FALSE) {
			//Validating username ...
			$this->__validation_error(validation_errors());
		} else {
			// Getting the username whose username is the one submitted
			$this->db->where('username', $post_username);
			$query = $this->db->get('users');
			//Check if there is only one result to avoid SQL injections when they can select the whole table
			if ($query->num_rows() != 1 ) {
				$this->__invalid_login($post_username);
			} else {
				// We have only 1 record with the supplied username. Time to check the password
				$row = $query->row();
				// Check if the passwords match
				// We store them cleartext, so we just run a strcmp
				if (strcmp ($post_password, $row->password) != 0) {
					$this->__invalid_login($row->username);
				} else {
					// User is legit, log him in	
					$data = array ( 
							'username' => $row->username,
							'user_id' => $row->id,
							'user_auth' => $row->auth,
							'name' => $row->name,
						);				
					$this->session->set_userdata($data); // Initializing session for the user
					
					$this->sec->log('info','login','User ['.$row->username.'] logged in successfully');
					//echo json_encode(array("status" => 200));
					redirect('vote');
				}
			}
		}
	}
	
	function logout() {
		$this->sec->log('info','login','User logged out successfully');
		$this->session->sess_destroy();
		// Here we want to redirect the user to /
		redirect('/');	
	}	
	
}	


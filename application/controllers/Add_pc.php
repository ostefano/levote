<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_pc extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->sec->authorized($this->sec->admin_auth_level());	
	}

	public function index() {
		$view_data = array();

		$view_data['head'] = $this->load->view('head/1_general', '', true);
		$view_data['head_row'] = $this->load->view('body/head_row', '', true);

		// Reserve the next ID!
		// We initially insert only the auth level and remaining fileds will
		// be empty till we update them some lines below
		$data = array(
			'name' => 'N/A',
			'username' => 'N/A',
			'password' => 'N/A',
			'auth' => $this->sec->user_auth_level()
		);

		$this->db->insert('users', $data);
		// This is the new ID we have reserved!
		$id = $this->db->insert_id();

		// Let's store this ids for future useage
		$view_data['username'] = 'user'.$id;
		// Generate a password of length 6, using the 2nd array
		$view_data['password'] = $this->sec->generatePassword(6,2);

		$data = array(
			'auth' => $this->sec->user_auth_level(),
			'name' => $view_data['username'],
			'username' => $view_data['username'],
			'password' => $view_data['password']
		);

		// Adding the missing pieces
		$this->db->where('id', $id);
		$this->db->update('users', $data);


		// Let's show this result to the user		
		$this->load->view('add_pc',$view_data);
	}
}


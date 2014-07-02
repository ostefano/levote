<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reset_pc extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->sec->authorized($this->sec->admin_auth_level());	
	}

	public function index() {

		$query = $this->db->query('SELECT e.id from eval e, users u WHERE e.user_id = u.id AND u.auth <> 2');
		if ($query->num_rows() > 0) {
			
			$myids = array();
			foreach ($query->result() as $row) {
				$myids[] = $row->id;
			}
			//die(print_r($myids, TRUE));
			$this->db->where_in('id', $myids);
			$this->db->delete('eval');
		}

		$this->db->where("auth",2);
		$this->db->delete("users");

		redirect('vote');
	}
}

?>
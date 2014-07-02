<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vote extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->sec->authorized();
		$this->students_count = 0;
	}

	public function __get_vote_return_error() {
		$this->output->set_status_header('404');
		echo "";
		return;
	}

	// Vote can only be between 0.0 and 10.0
	// Requires: float argument
	public function __get_vote_constrain_vote(&$value) {
		// If our value is out of scope, change it.
		if ($value < 0.0 || $value > 10.0) {
			$value = 0.0;
		}
	}

	public function index() {

		$view_data['head'] = $this->load->view('head/1_general', '', true);
		$view_data['head_row'] = $this->load->view('body/head_row', '', true);

		$this->db->select('id, name, uni, country, photo');
		$query = $this->db->get('students');

		$students = array(); 
		foreach ($query->result_array() as $row) {
			
			// For each of these students, check if this user voted!
			$this->db->select('cat_elev, cat_poster, cat_video');
			$this->db->where('stud_id', $row['id']);
			$this->db->where('user_id', $this->sec->user_id());
			$single_line_query = $this->db->get('eval');

			// User did not enter any votes for this user yet!
			if ($single_line_query->num_rows() == 0) {
				$grade_poster 		= "0";
				$grade_video 			= "0";
				$grade_elev_pitch = "0";
			} else {
				// Fetch the line and get the first record
				$single_row = $single_line_query->result_array();
				$single_row = $single_row[0];

				$grade_poster 		= $single_row['cat_poster'];
				$grade_video 			= $single_row['cat_video'];
				$grade_elev_pitch = $single_row['cat_elev'];
			}

			$students[] = array (
				"id" 				=> $row['id'],
				"name"	 		=> $row['name'],
				"uni" 			=> $row['uni'],
				"country" 	=> $row['country'],
				"photo" 		=> $row['photo'],
				"grade_poster" 		=> $grade_poster,
				"grade_video" 		=> $grade_video,
				"grade_elevator" 	=> $grade_elev_pitch
			);
		}
		
		$view_data['students_list'] = $students;
		$this->load->view('vote', $view_data);
	}

	// This function gets the votes for a specifid student id
	// If the student id is -1 then return 403
	function get_vote($id = -1) {

		$query =  $this->db->get('students');
		$this->students_count = $query->num_rows();

		if (	$id < 1 || $id > $this->students_count ||
					$this->input->post('grade_poster') === NULL ||
					$this->input->post('grade_video') === NULL ||
					$this->input->post('grade_elev_pitch') === NULL ) {
			
			// This return is what stops the script to go further on
			$this->__get_vote_return_error();
			return; 
		}
 
		// Let's validate them now.
		$grade_poster 		= floatval($this->input->post('grade_poster'));
		$grade_video			= floatval($this->input->post('grade_video'));
		$grade_elev_pitch = floatval($this->input->post('grade_elev_pitch'));
		$this->__get_vote_constrain_vote($grade_poster);
		$this->__get_vote_constrain_vote($grade_video);
		$this->__get_vote_constrain_vote($grade_elev_pitch);

		// Check if the pair ('student_id', 'user_id') is in the DB!
		$this->db->select('id');
		$this->db->where('stud_id', $id);
		$this->db->where('user_id', $this->sec->user_id());
		$query = $this->db->get('eval');

		if ($query->num_rows() == 1) {
			// USER already inserted some vals so just update his votes
			$single_row = $query->result_array();
			$single_row = $single_row[0];
			$data = array(
				'cat_elev' => $grade_elev_pitch,
				'cat_poster' => $grade_poster,
				'cat_video' => $grade_video
			);
			$this->db->where('id', $single_row['id']);
			$this->db->update('eval', $data);

			$this->output->set_status_header('200');
			echo "";
		} else if ($query->num_rows() == 0) {
			// USER did not insert anything. Create record
			$data = array(
					'stud_id' 	=> $id,
					'user_id'	=> $this->sec->user_id(),
					'cat_elev' 	=> $grade_elev_pitch,
					'cat_poster'=> $grade_poster,
					'cat_video' => $grade_video
			);
			$this->db->insert('eval', $data);

			$this->output->set_status_header('200');
			echo "";
		} else {
			// There is a problem. log it and return error
			$this->sec->log('warning', 'vote-get_vote', 
				'Query returned 2 results for $stud_id: '.$id.' and $user_id');
			$this->__get_vote_return_error();
			return;
		}
	}
}


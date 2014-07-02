<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Results extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->sec->authorized();
		$this->students_count = 0;
	}

	private function __redindex_by_key($array) {
		$new = array();
		foreach ($array as $v) {
			$new[$v['id']] = $v;
			unset($new[$v['id']]['id']); 
			// No need to have redundant ID
		}
		return $new;
	}

	public function index() {
		
		$view_data['head'] = $this->load->view('head/1_general', '', true);
		$view_data['head_row'] = $this->load->view('body/head_row', '', true);

		// Get the list of all students
		$this->db->select('id, name, uni, country');
		$query = $this->db->get('students');
		$students = $query->result_array();
		$this->students_count = $query->num_rows();
		$students = $this->__redindex_by_key($students);

		// We assume that one user cannot vote for a student if he/she is 
		// not in the DB!
		// And that we have inserter all the students in the DB (8 of them)

		// Get all the casted votes now.
		// I can get all kind of interesting statistics: how many users voted 
		// for each person 

		// Creating the 3 arrays for each category
		$grades_poster 			= array();
		$grades_video  			= array();
		$grades_elev_pitch 	= array();
		for($i=1; $i <= $this->students_count; ++$i) {
			$grades_poster[$i] 			= 0;
			$grades_video[$i] 			= 0;
			$grades_elev_pitch[$i] 	= 0;
		}

		$query = $this->db->get('eval');
		foreach ($query->result_array() as $row) {
			$grades_poster[$row['stud_id']] 		+= floatval($row['cat_poster']);
			$grades_video[$row['stud_id']] 			+= floatval($row['cat_video']);
			$grades_elev_pitch[$row['stud_id']] += floatval($row['cat_elev']);
		}

		arsort($grades_video);
		arsort($grades_poster);
		arsort($grades_elev_pitch);

		$index = 1;
		foreach($grades_poster as $key => $value) {
			$row = array(
				"index" 	=> $index,
				"name"		=> $students[$key]['name'],
				"uni"			=> $students[$key]['uni'],
				"country"	=> $students[$key]['country'],
				"points"	=> $value
			);
			$view_data['results_poster'][] = $row;			
			++$index;
		}

		$index = 1;
		foreach($grades_video as $key => $value) {
			$row = array(
				"index" 	=> $index,
				"name"		=> $students[$key]['name'],
				"uni"			=> $students[$key]['uni'],
				"country"	=> $students[$key]['country'],
				"points"	=> $value
			);
			$view_data['results_video'][] = $row;			
			++$index;
		}

		$index = 1;
		foreach($grades_elev_pitch as $key => $value) {
			$row = array(
				"index" 	=> $index,
				"name"		=> $students[$key]['name'],
				"uni"			=> $students[$key]['uni'],
				"country"	=> $students[$key]['country'],
				"points"	=> $value
			);
			$view_data['results_elev_pitch'][] = $row;			
			++$index;
		}

		$this->load->view('results', $view_data);
	}
}


<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Types extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Common');
			if (!admin()) {
				redirect('app');
			}
	}
	public function index()
	{
		$data['types'] = $this->Common->get_details('pitches',array())->result();
		$this->load->view('admin/types/view',$data);
	}

}
?>

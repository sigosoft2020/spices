<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
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
		$data['reg'] = $this->Common->get_details('registration_fee',array('rf_id' => 1))->row();
		$this->load->view('admin/settings/view',$data);
	}
	public function change()
	{
		$fee = $this->security->xss_clean($this->input->post('fee'));
		$array = [
			'fee' => $fee
		];
		$this->Common->update('rf_id',1,'registration_fee',$array);

		$this->session->set_flashdata('alert_type', 'success');
		$this->session->set_flashdata('alert_title', 'Success');
		$this->session->set_flashdata('alert_message', 'Registration fee updated..!');

		redirect('admin/settings');
	}
}
?>

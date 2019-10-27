<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Common');
	}

	public function index()
	{
		redirect('app/login');
	}
	public function login()
	{
		if(isset($_COOKIE['admin_wooslot_id'])){
			$session = [
				'admin_id' => $_COOKIE['admin_wooslot_id'],
				'name' => $_COOKIE['admin_wooslot_name']
			];
			$this->session->set_userdata('admin',$session);
			redirect('admin/dashboard');
		}
		$this->load->view('login/admin/login');
	}
	public function adminLogin()
	{
		$username = $this->security->xss_clean($this->input->post('username'));
		$pass = $this->security->xss_clean($this->input->post('password'));
		$password = md5($pass);

		$details = [
			'username' => $username,
			'password' => $password
		];

		$check = $this->Common->get_details('admin',$details);
		if ( $check->num_rows() > 0 ) {
			$user = $check->row();
			$session = [
				'admin_id' => $user->id,
				'name' => $user->name
			];
			$this->session->set_userdata('admin',$session);

			$hour = time() + 3600 * 24 * 30;
		  setcookie('admin_wooslot_id', $user->id, $hour);
			setcookie('admin_wooslot_name', $user->name, $hour);


			redirect('admin/dashboard');
		}
		else {
			$this->session->set_flashdata('message','Login failed..!');
			redirect('app');
		}

	}
	public function logout()
	{
		setcookie('admin_wooslot_id');
		setcookie('admin_wooslot_name');

		$this->session->unset_userdata('admin');

		redirect('app');
	}
	public function test()
	{
		$var = $_COOKIE['admin_wooslot_id'];
		echo $var;
	}
}

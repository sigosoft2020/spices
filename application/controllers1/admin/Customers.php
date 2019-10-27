<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_customers','customer');
			if (!admin()) {
				redirect('app');
			}
	}
	public function index()
	{
		$this->load->view('admin/customers/view');
	}
	public function get()
	{
		$result = $this->customer->make_datatables();
		$data = array();
		foreach ($result as $res) {
			if ($res->status) {
				$status = "Active";
			}
			else {
				$status = "Blocked";
			}
			$sub_array = array();
			$sub_array[] = '<img src="' . base_url() . $res->image . '" width="100px" height="100px">';
			$sub_array[] = $res->username;
			$sub_array[] = $res->mobile;
			$sub_array[] = $res->email;
			$sub_array[] = $status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('admin/customers/edit/'.$res->user_id) . '"><i class="fa fa-pencil-square-o"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->customer->get_all_data(),
			"recordsFiltered" => $this->customer->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function add()
	{
		$this->load->view('admin/customers/add');
	}

	public function edit($user_id)
	{
		$check = $this->Common->get_details('users',array('user_id' => $user_id));
		if ($check->num_rows() > 0) {
			$data['user'] = $check->row();
			$this->load->view('admin/customers/edit',$data);
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to load customer..!');

			redirect('admin/customers');
		}
	}

	public function addCustomer()
	{
		$username = $this->security->xss_clean($this->input->post('username'));
		$email = $this->security->xss_clean($this->input->post('email'));
		$mobile = $this->security->xss_clean($this->input->post('mobile'));
		$password = $this->security->xss_clean($this->input->post('password'));

		$image = $this->input->post('image');
		if ($image != '') {
			$img = substr($image, strpos($image, ",") + 1);

			$url = FCPATH.'uploads/profile/';
			$rand = $username . date('Ymd').mt_rand(1001,9999);
			$userpath = $url.$rand.'.png';
			$path = "uploads/profile/".$rand.'.png';
			file_put_contents($userpath,base64_decode($img));
		}
		else {
			$path = "uploads/profile/user.png";
		}

		$array = [
			'username' => $username,
			'email' => $email,
			'mobile' => $mobile,
			'password' => md5($password),
			'auth' => $this->getKey(),
			'image' => $path
		];

		if ($this->Common->insert('users',$array)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'New customer added successfully..!');

			redirect('admin/customers');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add customer..!');

			redirect('admin/customers/add');
		}
	}

	public function editCustomer()
	{
		$username = $this->security->xss_clean($this->input->post('username'));
		$email = $this->security->xss_clean($this->input->post('email'));
		$mobile = $this->security->xss_clean($this->input->post('mobile'));
		$user_id = $this->security->xss_clean($this->input->post('user_id'));
		$status = $this->security->xss_clean($this->input->post('status'));

		$image = $this->input->post('image');
		if ($image != '') {

			$img = substr($image, strpos($image, ",") + 1);

			$url = FCPATH.'uploads/profile/';
			$rand = $username . date('Ymd').mt_rand(1001,9999);
			$userpath = $url.$rand.'.png';
			$path = "uploads/profile/".$rand.'.png';
			file_put_contents($userpath,base64_decode($img));

			// Remove file from the server

			$user = $this->Common->get_details('users',array('user_id' => $user_id))->row();
			$cr_image = "uploads/profile/user.png";
			if ($cr_image != $user->image) {
				$remove_path = FCPATH . $user->image;
				unlink($remove_path);
			}

			$array = [
				'username' => $username,
				'email' => $email,
				'mobile' => $mobile,
				'image' => $path,
				'status' => $status
			];

		}
		else {
			$array = [
				'username' => $username,
				'email' => $email,
				'mobile' => $mobile,
				'status' => $status
			];
		}

		if ($this->Common->update('user_id',$user_id,'users',$array)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Changes made successfully..!');

			redirect('admin/customers');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to update customer..!');

			redirect('admin/customers/edit/'.$user_id);
		}
	}

	public function validation()
	{
		$email = $this->security->xss_clean($this->input->post('email'));
		$mobile = $this->security->xss_clean($this->input->post('mobile'));

		$checkEmail = $this->Common->get_details('users',array('email' => $email))->num_rows();
		$checkMobile = $this->Common->get_details('users',array('mobile' => $mobile))->num_rows();
		$array = [
			'mobile' => false,
			'email' => false
		];
		if ($checkMobile > 0) {
			$array['mobile'] = true;
		}
		if ($checkEmail > 0) {
			$array['email'] = true;
		}
		print_r(json_encode($array));
	}
	public function validationEdit()
	{
		$user_id = $this->security->xss_clean($this->input->post('user_id'));
		$email = $this->security->xss_clean($this->input->post('email'));
		$mobile = $this->security->xss_clean($this->input->post('mobile'));

		$checkEmail = $this->Common->get_details('users',array('email' => $email , 'user_id!=' => $user_id))->num_rows();
		$checkMobile = $this->Common->get_details('users',array('mobile' => $mobile , 'user_id!=' => $user_id))->num_rows();
		$array = [
			'mobile' => false,
			'email' => false
		];
		if ($checkMobile > 0) {
			$array['mobile'] = true;
		}
		if ($checkEmail > 0) {
			$array['email'] = true;
		}
		print_r(json_encode($array));
	}

	function getKey() {
		while (true) {
			$key = $this->key();
			$cond = [
				'auth' => $key
			];

			$check = $this->Common->get_details('users',$cond);

			if ($check->num_rows() == 0) {
				break;
			}
		}
		return $key;
  }

	function key()
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 20; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
		return $randomString;
	}
}
?>

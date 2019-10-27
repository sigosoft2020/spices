<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_members','member');
			if (!admin()) {
				redirect('app');
			}
	}
	public function index()
	{
		$data['fee'] = $this->Common->get_details('registration_fee',array('rf_id' => 1))->row()->fee;
		$this->load->view('admin/members/view',$data);
	}
	public function get()
	{
		$result = $this->member->make_datatables();
		$data = array();
		foreach ($result as $res) {
			if ($res->status) {
				$status = "Active";
			}
			else {
				$status = "Blocked";
			}
			if ($res->image == '') {
				$image = base_url() . "uploads/profile/member.png";
			}
			else {
				$image = base_url() . $res->image;
			}
			if ($res->payment_status) {
				$payment = '<button class="btn btn-success btn-sm" onclick="getStatus(' . $res->member_id . ',`' . $res->username . '`)">Status</button>';
			}
			else {
				$payment = '<button class="btn btn-primary btn-sm" onclick="addPayment(' . $res->member_id . ',`' . $res->username . '`)">Add</button>';
			}
			$sub_array = array();
			$sub_array[] = '<img src="' . $image . '" width="100px" height="100px">';
			$sub_array[] = $res->username;
			$sub_array[] = $res->mobile;
			$sub_array[] = $res->email;
			$sub_array[] = $status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('admin/members/edit/'.$res->member_id) . '"><i class="fa fa-pencil-square-o"></i></a>';
			$sub_array[] = $payment;

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->member->get_all_data(),
			"recordsFiltered" => $this->member->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function add()
	{
		$this->load->view('admin/members/add');
	}

	public function edit($member_id)
	{
		$check = $this->Common->get_details('members',array('member_id' => $member_id));
		if ($check->num_rows() > 0) {
			$data['member'] = $check->row();
			$this->load->view('admin/members/edit',$data);
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to load member..!');

			redirect('admin/members');
		}
	}

	public function addmember()
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
			$memberpath = $url.$rand.'.png';
			$path = "uploads/profile/".$rand.'.png';
			file_put_contents($memberpath,base64_decode($img));
		}
		else {
			$path = "uploads/profile/member.png";
		}

		$array = [
			'username' => $username,
			'email' => $email,
			'mobile' => $mobile,
			'password' => md5($password),
			'auth' => $this->getKey(),
			'image' => $path
		];

		if ($this->Common->insert('members',$array)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'New member added successfully..!');

			redirect('admin/members');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add member..!');

			redirect('admin/members/add');
		}
	}

	public function editmember()
	{
		$username = $this->security->xss_clean($this->input->post('username'));
		$email = $this->security->xss_clean($this->input->post('email'));
		$mobile = $this->security->xss_clean($this->input->post('mobile'));
		$member_id = $this->security->xss_clean($this->input->post('member_id'));
		$status = $this->security->xss_clean($this->input->post('status'));

		$image = $this->input->post('image');
		if ($image != '') {

			$img = substr($image, strpos($image, ",") + 1);

			$url = FCPATH.'uploads/profile/';
			$rand = $username . date('Ymd').mt_rand(1001,9999);
			$memberpath = $url.$rand.'.png';
			$path = "uploads/profile/".$rand.'.png';
			file_put_contents($memberpath,base64_decode($img));

			// Remove file from the server

			$member = $this->Common->get_details('members',array('member_id' => $member_id))->row();
			$cr_image = "uploads/profile/member.png";
			if ($cr_image != $member->image) {
				$remove_path = FCPATH . $member->image;
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

		if ($this->Common->update('member_id',$member_id,'members',$array)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Changes made successfully..!');

			redirect('admin/members');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to update member..!');

			redirect('admin/members/edit/'.$member_id);
		}
	}

	public function validation()
	{
		$email = $this->security->xss_clean($this->input->post('email'));
		$mobile = $this->security->xss_clean($this->input->post('mobile'));

		$checkEmail = $this->Common->get_details('members',array('email' => $email))->num_rows();
		$checkMobile = $this->Common->get_details('members',array('mobile' => $mobile))->num_rows();
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
		$member_id = $this->security->xss_clean($this->input->post('member_id'));
		$email = $this->security->xss_clean($this->input->post('email'));
		$mobile = $this->security->xss_clean($this->input->post('mobile'));

		$checkEmail = $this->Common->get_details('members',array('email' => $email , 'member_id!=' => $member_id))->num_rows();
		$checkMobile = $this->Common->get_details('members',array('mobile' => $mobile , 'member_id!=' => $member_id))->num_rows();
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

			$check = $this->Common->get_details('members',$cond);

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
	public function addPayment()
	{
		$fee = $this->security->xss_clean($this->input->post('fee'));
		$member_id = $this->security->xss_clean($this->input->post('member_id'));
		$notes = $this->security->xss_clean($this->input->post('notes'));

		$array = [
			'payment' => $fee,
			'payment_id' => '',
			'date' => date('Y-m-d'),
			'time' => date('h:i A'),
			'member_id' => $member_id,
			'payment_by' => 'admin',
			'notes' => $notes
		];

		if ($this->Common->insert('payments',$array)) {
			$status = [
				'payment_status' => 1
			];
			$this->Common->update('member_id',$member_id,'members',$status);

			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Payment added successfully..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add payment..!');
		}
		redirect('admin/members');
	}

	public function getPaymentDetails()
	{
		$member_id = $this->security->xss_clean($this->input->post('member_id'));
		$array = $this->Common->get_details('payments',array('member_id' => $member_id))->row();

		print_r(json_encode($array));
	}
}
?>

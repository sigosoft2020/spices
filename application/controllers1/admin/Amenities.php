<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Amenities extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('M_amenities');
			$this->load->model('Common');
			if (!admin()) {
				redirect('app');
			}
	}
	public function index()
	{
		$this->load->view('admin/amenities/view');
	}
	public function get()
	{
		$result = $this->M_amenities->make_datatables();
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
			$sub_array[] = $res->amenity;
			$sub_array[] = $status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('admin/amenities/edit/'.$res->amenity_id) . '"><i class="fa fa-pencil-square-o"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->M_amenities->get_all_data(),
			"recordsFiltered" => $this->M_amenities->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function add()
	{
		$this->load->view('admin/amenities/add');
	}
	public function edit($amenity_id)
	{
		$check = $this->Common->get_details('amenities',array('amenity_id' => $amenity_id));
		if ($check->num_rows() > 0) {
			$data['amenity'] = $check->row();
			$this->load->view('admin/amenities/edit',$data);
		}
		else {
			redirect('amenities');
		}
	}
	public function addAmenity()
	{
		$amenity = $this->security->xss_clean($this->input->post('name'));
		$check = $this->Common->get_details('amenities',array('amenity' => $amenity))->num_rows();
		if ($check > 0) {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add amenity..!');

			redirect('admin/amenities/add');
		}
		else {
			// Adding base64 file to server
			$image = $this->input->post('image');
			$img = substr($image, strpos($image, ",") + 1);

			$url = FCPATH.'uploads/amenities/';
			$rand = $amenity.date('Ymd').mt_rand(1001,9999);
			$userpath = $url.$rand.'.png';
			$path = "uploads/amenities/".$rand.'.png';
			file_put_contents($userpath,base64_decode($img));

			$array = [
				'amenity' => $amenity,
				'image' => $path
			];
			if ($this->Common->insert('amenities',$array)) {
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'New amenity added..!');

				redirect('admin/amenities');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Amenity already exists..!');

				redirect('admin/amenities/add');
			}
		}
	}
	public function editAmenity()
	{
		$amenity_id = $this->input->post('amenity_id');
		$amenity = $this->security->xss_clean($this->input->post('name'));
		$check = $this->Common->get_details('amenities',array('amenity' => $amenity , 'amenity_id!=' => $amenity_id))->num_rows();
		if ($check > 0) {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add amenity..!');

			redirect('admin/amenities/edit/'.$amenity_id);
		}
		else {
			// Adding base64 file to server
			$image = $this->input->post('image');
			$status = $this->input->post('status');
			if ($image != '') {
				$img = substr($image, strpos($image, ",") + 1);

				$url = FCPATH.'uploads/amenities/';
				$rand = $amenity.date('Ymd').mt_rand(1001,9999);
				$userpath = $url.$rand.'.png';
				$path = "uploads/amenities/".$rand.'.png';
				file_put_contents($userpath,base64_decode($img));

				// Remove old image from the server
				$old = $this->Common->get_details('amenities',array('amenity_id' => $amenity_id))->row()->image;
				$remove_path = FCPATH . $old;
				unlink($remove_path);

				$array = [
					'amenity' => $amenity,
					'image' => $path,
					'status' => $status
				];
			}
			else {
				$array = [
					'amenity' => $amenity,
					'status' => $status
				];
			}

			if ($this->Common->update('amenity_id',$amenity_id,'amenities',$array)) {
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'Changes made successfully..!');

				redirect('admin/amenities');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to update amenity..!');

				redirect('admin/amenities/edit/'.$amenity_id);
			}
		}
	}
}
?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sliders extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('M_banners','slider');
			$this->load->model('Common');
			if (!admin()) {
				redirect('app');
			}
	}
	public function index()
	{
		$this->load->view('admin/sliders/view');
	}
	public function get()
	{
		$result = $this->slider->make_datatables();
		$data = array();
		foreach ($result as $res) {
			$sub_array = array();
			$sub_array[] = '<img src="' . base_url() . $res->image . '" height="100px">';
			$sub_array[] = $res->name;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;color:red" href="' . site_url('admin/sliders/delete/'.$res->slider_id) . '" onclick="return del()"><i class="fa fa-trash"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->slider->get_all_data(),
			"recordsFiltered" => $this->slider->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function add()
	{
		$this->load->view('admin/sliders/add');
	}
	public function edit($slider_id)
	{
		$check = $this->Common->get_details('sliders',array('slider_id' => $slider_id));
		if ($check->num_rows() > 0) {
			$data['sliders'] = $check->row();
			$this->load->view('admin/sliders/edit',$data);
		}
		else {
			redirect('amenities');
		}
	}
	public function addslider()
	{
		$slider = $this->security->xss_clean($this->input->post('name'));
		$image = $this->input->post('image');
		$img = substr($image, strpos($image, ",") + 1);

		$url = FCPATH.'uploads/sliders/';
		$rand = $slider.date('Ymd').mt_rand(1001,9999);
		$userpath = $url.$rand.'.png';
		$path = "uploads/sliders/".$rand.'.png';
		file_put_contents($userpath,base64_decode($img));

		$array = [
			'name' => $slider,
			'image' => $path
		];
		if ($this->Common->insert('sliders',$array)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'New slider added..!');

			redirect('admin/sliders');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add slider..!');

			redirect('admin/sliders/add');
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
	public function delete($slider_id)
	{
		$check = $this->Common->get_details('sliders',array('slider_id' => $slider_id));
		if ($check->num_rows() > 0) {
			$slider = $check->row();
			if ($this->Common->delete('sliders',array('slider_id' => $slider_id))) {
				$remove_path = FCPATH . $slider->image;
				unlink($remove_path);

				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'slider deleted successfully..!');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to remove slider..!');
			}
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to remove slider..!');
		}
		redirect('admin/sliders');
	}
}
?>

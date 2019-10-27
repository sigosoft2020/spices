<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {
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
		$data['images'] = $this->Common->get_details('gallery',array())->result();
		$this->load->view('admin/gallery/view',$data);
	}

	public function add()
	{
		$this->load->view('admin/gallery/add');
	}

	public function addImage()
	{
		$name = $this->security->xss_clean($this->input->post('name'));
		$image = $this->input->post('image');
		$img = substr($image, strpos($image, ",") + 1);

		$url = FCPATH.'uploads/gallery/';
		$rand = $name . date('Ymd') . mt_rand(1001,9999);
		$userpath = $url.$rand.'.png';
		$path = "uploads/gallery/".$rand.'.png';
		file_put_contents($userpath,base64_decode($img));

		$array = [
			'name' => $name,
			'image' => $path
		];
		if ($this->Common->insert('gallery',$array)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'New image added..!');

			redirect('admin/gallery');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add image..!');

			redirect('admin/gallery');
		}
	}

	public function delete()
	{
		$image_id = $this->input->post('image_id');
		$check = $this->Common->get_details('gallery',array('image_id' => $image_id));
		if ($check->num_rows() > 0) {
			$gallery = $check->row();
			if ($this->Common->delete('gallery',array('image_id' => $image_id))) {
				$remove_path = FCPATH . $gallery->image;
				unlink($remove_path);

				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'image deleted successfully..!');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to remove image..!');
			}
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to remove image..!');
		}
		redirect('admin/gallery');
	}
}
?>

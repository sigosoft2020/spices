<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Turfs extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('Turf','turf');
			$this->load->model('M_turf');
			$this->load->model('Turf_blocked','turfB');
			$this->load->model('Turf_pending','turfP');
			if (!admin()) {
				redirect('app');
			}
	}
	public function index()
	{
		$this->load->view('admin/turfs/view');
	}
	public function get()
	{
		$result = $this->turf->make_datatables();
		$data = array();
		foreach ($result as $res) {
			if ($res->status == "a") {
				$status = "Active";
			}
			else {
				$status = "Blocked";
			}
			$button = '<a class="btn btn-sm btn-outline-danger waves-light waves-effect w-md" href="' . site_url('admin/turfs/deactivate/'.$res->turf_id) . '" onclick="return block()"><i class="fa fa-ban m-r-5"></i><span> deactivate</span></a>';

			$sub_array = array();
			$sub_array[] = '<img src="' . base_url() . $res->cover_image . '" width="100px" height="100px">';
			$sub_array[] = $res->turf_name;
			$sub_array[] = $res->place;
			$sub_array[] = $status;
			$sub_array[] = $button;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('admin/turfs/details/'.$res->turf_id) . '"><i class="fa fa-info-circle"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->turf->get_all_data(),
			"recordsFiltered" => $this->turf->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function blocked()
	{
		$this->load->view('admin/turfs/blocked');
	}

	public function getBlocked()
	{
		$result = $this->turfB->make_datatables();
		$data = array();
		foreach ($result as $res) {
			if ($res->status == "a") {
				$status = "Active";
			}
			else {
				$status = "Blocked";
			}
			$button = '<a class="btn btn-sm btn-outline-success waves-light waves-effect w-md" href="' . site_url('admin/turfs/activate/'.$res->turf_id) . '" onclick="return activate()"><i class="fa fa-check m-r-5"></i><span>activate</span></a>';

			$sub_array = array();
			$sub_array[] = '<img src="' . base_url() . $res->cover_image . '" width="100px" height="100px">';
			$sub_array[] = $res->turf_name;
			$sub_array[] = $res->place;
			$sub_array[] = $status;
			$sub_array[] = $button;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('admin/turfs/details/'.$res->turf_id) . '"><i class="fa fa-info-circle"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->turfB->get_all_data(),
			"recordsFiltered" => $this->turfB->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function pending()
	{
		$this->load->view('admin/turfs/pending');
	}

	public function getPending()
	{
		$result = $this->turfP->make_datatables();
		$data = array();
		foreach ($result as $res) {
			$sub_array = array();
			$sub_array[] = '<img src="' . base_url() . $res->cover_image . '" width="100px" height="100px">';
			$sub_array[] = $res->turf_name;
			$sub_array[] = $res->place;
			$sub_array[] = "Registration of this turf is not yet completed , complete the registration by simply clicking the link <a href='#'>Click here</a>";

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->turfP->get_all_data(),
			"recordsFiltered" => $this->turfP->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function activate($turf_id)
	{
		$status = [
			'status' => 'a'
		];
		if ($this->Common->update('turf_id',$turf_id,'turfs',$status)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Turf activated..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to activate turf , Please try agein later..!');
		}

		redirect('admin/turfs');
	}

	public function deactivate($turf_id)
	{
		$status = [
			'status' => 'b'
		];
		if ($this->Common->update('turf_id',$turf_id,'turfs',$status)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Turf deactivated..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to activate turf , Please try agein later..!');
		}

		redirect('admin/turfs/blocked');
	}

	public function details($turf_id)
	{
		$turf = $this->Common->get_details('turfs',array('turf_id' => $turf_id));
		if ($turf->num_rows() > 0) {
			$data['turf'] = $turf->row();

			$data['amenities'] = $this->M_turf->getAmenities($turf_id);
			$data['images'] = $this->M_turf->getTurfImages($turf_id);
			$data['owner'] = $this->M_turf->getTurfOwner($turf->row()->owner_id);
			$data['pitches'] = $this->M_turf->getTurfPitch($turf_id);

			$this->load->view('admin/turfs/details',$data);
		}
		else {
			redirect('admin/turfs');
		}
	}

}
?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vouchers extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Common');
		$this->load->model('M_vouchers','voucher');
		if (!admin()) {
			redirect('app');
		}
	}
	public function index()
	{
		$this->load->view('admin/vouchers/view');
	}
	public function get()
	{
		$result = $this->voucher->make_datatables();
		$data = array();
		foreach ($result as $res) {
			if ($res->end_date_status == '1') {
				$end = $res->end_date;
			}
			else {
				$end = "Not set";
			}
			$sub_array = array();
			$sub_array[] = $res->code;
			$sub_array[] = $res->type;
			$sub_array[] = $res->offer;
			$sub_array[] = $res->count;
			$sub_array[] = $res->remains;
			$sub_array[] = $end;
			$sub_array[] = $res->status;
			$sub_array[] = '<button class="btn btn-link" style="font-size:24px;" onclick="edit_voucher(' . $res->voucher_id . ')"><i class="fa fa-pencil-square-o"></i></button>';
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;color:red" href="' . site_url('admin/vouchers/delete/'.$res->voucher_id) . '" onclick="return del()"><i class="fa fa-trash"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->voucher->get_all_data(),
			"recordsFiltered" => $this->voucher->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function add()
	{
		$data = [
			'code' => $this->input->post('code'),
			'type' => $this->input->post('type'),
			'offer' => $this->input->post('offer'),
			'end_date' => $this->input->post('end_date'),
			'count' => $this->input->post('count'),
			'remains' => $this->input->post('count')
		];
		$check = $this->input->post('end_date');
		if ($check == '') {
			$data['end_date_status'] = '0';
		}
		else {
			$data['end_date_status'] = '1';
			$data['end_date'] = $check;
		}

		if ($this->Common->insert('vouchers',$data)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Voucher added successfully..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add voucher..!');
		}
		redirect('admin/vouchers');
	}
	public function delete($voucher_id)
	{
		$array = [
			'voucher_id' => $voucher_id
		];
		$check = $this->Common->get_details('vouchers',$array)->num_rows();
		if ($check > 0) {
			if ($this->Common->delete('vouchers',$array)) {
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'Voucher deleted successfully..!');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to remove voucher..!');
			}
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Voucher does not exists..!');
		}
		redirect('admin/vouchers');
	}
	public function getVouchersById()
	{
		$id = $_POST['id'];
		$data = $this->Common->get_details('vouchers',array('voucher_id' => $id))->row();
		print_r(json_encode($data));
	}
	public function edit()
	{
		$data = $this->input->post();
		if(isset($_POST['remove']))
		{
			$data['end_date_status'] = '0';
			$data['end_date'] = '';
			unset($data['remove']);
		}
		else {
			if ($data['end_date']) {
				$data['end_date_status'] = '1';
			}
		}
		$voucher_id = $data['voucher_id'];
		unset($data['voucher_id']);
		if ($this->Common->update('voucher_id',$voucher_id,'vouchers',$data)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Voucher updated successfully..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to update voucher..!');
		}
		redirect('admin/vouchers');
	}
}

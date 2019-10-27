<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('M_expenses','expense');
			$this->load->model('M_expcategory','category');
			$this->load->model('Common');
			if (!admin()) {
				redirect('app');
			}
	}
	public function index()
	{
		$this->load->view('admin/expenses/view');
	}
	public function get()
	{
		$result = $this->expense->make_datatables();
		$data = array();
		foreach ($result as $res) {

			$sub_array = array();
			$sub_array[] = $res->expense;
			$sub_array[] = $res->notes;
			$sub_array[] = $res->date;
			$sub_array[] = $res->time;
			$sub_array[] = $res->cat_name;

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->expense->get_all_data(),
			"recordsFiltered" => $this->expense->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function add()
	{
		$data['categories'] = $this->Common->get_details('expense_categories',array('status' => 1))->result();
		$this->load->view('admin/expenses/add',$data);
	}

	public function addExpense()
	{
		$expense = $this->security->xss_clean($this->input->post('expense'));
		$notes = $this->security->xss_clean($this->input->post('notes'));
		$date = $this->security->xss_clean($this->input->post('date'));
		$time = $this->security->xss_clean($this->input->post('time'));

		$cat_id = $this->security->xss_clean($this->input->post('cat_id'));

		$cat_name = $this->Common->get_details('expense_categories',array('cat_id' => $cat_id))->row()->cat_name;

		$array = [
			'expense' => $expense,
			'notes' => $notes,
			'date' => $date,
			'time' => $time,
			'cat_id' => $cat_id,
			'cat_name' => $cat_name
		];

		if ($this->Common->insert('expenses',$array)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Expense added..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add expense..!');
		}

		redirect('admin/expenses');
	}

	public function category()
	{
		$this->load->view('admin/expense_categories/view');
	}
	public function getCategories()
	{
		$result = $this->category->make_datatables();
		$data = array();
		foreach ($result as $res) {
			if ($res->status) {
				$status = "Active";
			}
			else {
				$status = "Blocked";
			}
			$sub_array = array();
			$sub_array[] = $res->cat_name;
			$sub_array[] = $res->cat_description;
			$sub_array[] = $status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('admin/expenses/edit_category/'.$res->cat_id) . '"><i class="fa fa-pencil-square-o"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->category->get_all_data(),
			"recordsFiltered" => $this->category->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function add_category()
	{
		$this->load->view('admin/expense_categories/add');
	}

	public function edit_category($cat_id)
	{
		$check = $this->Common->get_details('expense_categories',array('cat_id' => $cat_id));
		if ($check->num_rows() > 0) {
			$data['cat'] = $check->row();
			$this->load->view('admin/expense_categories/edit',$data);
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'This category does not exists..!');
		}
	}

	public function addCategory()
	{
		$name = $this->security->xss_clean($this->input->post('cat_name'));
		$check = $this->Common->get_details('expense_categories',array('cat_name' => $name))->num_rows();
		if ($check > 0) {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Category name already exists..!');

			redirect('admin/expenses/add_category');
		}
		else {
			$description = $this->security->xss_clean($this->input->post('cat_description'));
			$insert = [
				'cat_name' => $name,
				'cat_description' => $description
			];
			if ($this->Common->insert('expense_categories',$insert)) {
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'New category added..!');

				redirect('admin/expenses/category');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to add category..!');

				redirect('admin/expenses/add_category');
			}
		}
	}

	public function editCategory()
	{
		$name = $this->security->xss_clean($this->input->post('cat_name'));
		$cat_id = $this->security->xss_clean($this->input->post('cat_id'));
		$check = $this->Common->get_details('expense_categories',array('cat_name' => $name , 'cat_id !=' => $cat_id))->num_rows();
		if ($check > 0) {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Category name already exists..!');

			redirect('admin/expenses/edit_category/'.$cat_id);
		}
		else {
			$description = $this->security->xss_clean($this->input->post('cat_description'));
			$status = $this->security->xss_clean($this->input->post('status'));

			$insert = [
				'cat_name' => $name,
				'cat_description' => $description,
				'status' => $status
			];
			if ($this->Common->update("cat_id",$cat_id,'expense_categories',$insert)) {
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'Changes made successfully..!');

				redirect('admin/expenses/category');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to update category..!');

				redirect('admin/expenses/edit_category/'.$cat_id);
			}
		}
	}
}
?>

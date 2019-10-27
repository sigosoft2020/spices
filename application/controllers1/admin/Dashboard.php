<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('M_dashboard','dash');
			if (!admin()) {
				redirect('app');
			}
	}
	public function index()
	{
		$data['pending'] = $this->dash->bookingsPending();
		$data['bookingThisMonth'] = $this->dash->bookingsThisMonth();
		$data['turfs'] = $this->dash->registeredTurfsCounts();
		$data['users'] = $this->dash->registeredCustomers();
		$data['expenseToday'] = $this->dash->todaysExpense();
		$data['expenseMonthly'] = $this->dash->ExpenseThisMonth();

		$data['customers'] = $this->dash->getUsers();
		$data['feedbacks'] = $this->dash->latestFeedbacks();
		$data['expenses'] = $this->dash->latestExpenses();

		$this->load->view('admin/dashboard/dashboard',$data);
	}
}
?>

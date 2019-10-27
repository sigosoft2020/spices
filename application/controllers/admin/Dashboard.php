<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('M_dashboard','dash');
			$this->load->model('M_polls','polls');
			if (!admin()) {
				redirect('app');
			}
	}
	public function index()
	{
		$data['eventUpcoming'] = $this->dash->getNumberOfUpcomingEvents();
		$data['eventCompleted'] = $this->dash->getNumberOfCompletedEvents();
		$data['activeMembers'] = $this->dash->getActiveMembers();
		$data['pollsUpcoming'] = $this->dash->getActivePolls();
		$data['pollsCompleted'] = $this->dash->getCompletedPolls();
		$data['members'] = $this->dash->getActiveMembers5();

		$polls = $this->dash->getCompletedPolls();

		foreach ($polls as $poll) {
			$total = $this->polls->getTotal($poll->poll_id);
			$options = $this->polls->getOptions($poll->poll_id);
			foreach ($options as $option) {
				$opt_total = $this->polls->getTotalOfOption($option->opt_id);
				if ($total == 0) {
					$option->percent = 0;
				}
				else {
					$percent = ( $opt_total * 100 ) / $total;
					if(gettype($percent) == 'integer')
					{
						$option->percent = $percent;
					}
					else {
						$option->percent = number_format((float)$percent, 2, '.', '');
					}
				}
			}
			$poll->options = $options;
		}

		$data['polls'] = $polls;


		$this->load->view('admin/dashboard/dashboard',$data);
	}
}
?>

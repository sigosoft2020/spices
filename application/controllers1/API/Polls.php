<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Polls extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('M_polls','polls');
			$this->load->model('Common');
	}
	public function upcoming()
	{
		$key = $this->security->xss_clean($this->input->post('auth'));
		if ($id = getUserId($key)) {
			$polls = $this->polls->upcoming();
			foreach ($polls as $poll) {
				$poll->polled_option = $this->polls->checkPoll($id,$poll->poll_id);
				$poll->options = $this->polls->getOptions($poll->poll_id);
			}
			$return = [
				'status' => true,
				'data' => $polls,
				'user' => true,
				'message' => ''
			];
		}
		else {
			$return = [
				'status' => false,
				'data' => array(),
				'user' => false,
				'message' => 'Authentication failed..!'
			];
		}

		print_r(json_encode($return));
	}
	public function completed()
	{
		$key = $this->security->xss_clean($this->input->post('auth'));
		if ($id = getUserId($key)) {
			$polls = $this->polls->completed();
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
			$return = [
				'status' => true,
				'data' => $polls,
				'message' => '',
				'user' => true
			];
	  }
		else {
			$return = [
				'status' => false,
				'data' => array(),
				'message' => 'Authentication failed..!',
				'user' => false
			];
		}
		print_r(json_encode($return));
	}

	public function addPoll()
	{
		$key = $this->security->xss_clean($this->input->post('auth'));
		if ($id = getUserId($key)) {
			$opt_id = $this->security->xss_clean($this->input->post('opt_id'));
			$poll_id = $this->security->xss_clean($this->input->post('poll_id'));

			$array = [
				'opt_id' => $opt_id,
				'poll_id' => $poll_id,
				'member_id' => $id
			];

			if ($this->Common->insert('results',$array)) {
				$return = [
					'status' => true,
					'data' => '',
					'message' => 'Your poll has been added..!',
					'user' => true
				];
			}
			else {
				$return = [
					'status' => false,
					'data' => '',
					'message' => 'Failed to add poll..!',
					'user' => true
				];
			}
		}
		else {
			$return = [
				'status' => false,
				'data' => '',
				'message' => 'Authentication failed..!',
				'user' => false
			];
		}
		print_r(json_encode($return));
	}

}
?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('M_chat','chat');
			$this->load->model('Common');
	}
	public function add()
	{
		$key = $this->security->xss_clean($this->input->post('auth'));
		if ($id = getUserId($key)) {
			$message = $this->security->xss_clean($this->input->post('message'));
			$date = date('Y-m-d H:i:s');
			if ($message == '') {
                $return = [
					'status' => false,
					'data' => array(),
					'message' => 'Message not sent',
					'user' => true
				];
			}
			else {
				$data = [
					'message' => $message,
					'date' => $date,
					'member_id' => $id
				];

				if ($this->chat->insert($data)) {

					$this->sendNotification($data);

					$return = [
						'status' => true,
						'data' => array(),
						'message' => 'Message sent',
						'user' => true
					];
				}
				else {
					$return = [
						'status' => false,
						'data' => array(),
						'message' => 'Message sending failed..!',
						'user' => true
					];
				}
			}
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

	public function sendNotification($array)
	{
		$SERVER_API_KEY = "AIzaSyCm131OryoKDslBi4hQgzyBEy-ljLxbHz0";
		$user = $this->chat->getUsername($array['member_id']);
		$array['username'] = $user->username;
		if($user->username == '')
		{
		    $array['image'] = '';
		}
		else
		{
		    $array['image'] = $user->username;
		}
		$to = "/topics" . "/FCM-ISS-chat2019";

		$header = [
			'Authorization: key='. $SERVER_API_KEY,
			'Content-Type: Application/json'
		];

		$notification = [
			'title' => 'New message',
			'body' => 'Testing notification',
			'content_available' => true
		];

		$data = [
			'title' => 'New message',
			'body' => 'Testing notification',
			'data' => [
				'message' => $array
			]
		];

		$payload = [
			'data' => $data,
			'notification' => $notification,
			'to' => $to,
			'priority' => 10
		];

		$url = 'https://fcm.googleapis.com/fcm/send';

		$curl = curl_init();

		curl_setopt_array($curl, array(
			 CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
			 CURLOPT_RETURNTRANSFER => true,
			 CURLOPT_CUSTOMREQUEST => "POST",
			 CURLOPT_POSTFIELDS => json_encode($payload),
			 CURLOPT_HTTPHEADER => $header,
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		return true;

	}

	public function getMessages()
	{
		$key = $this->security->xss_clean($this->input->post('auth'));
		if ($id = getUserId($key)) {
			$limit = $this->security->xss_clean($this->input->post('count'));
			$messages = $this->chat->getMessages($limit);
			foreach($messages as $message)
			{
			    if($message->image != '')
			    {
			        $message->image = base_url() . $message->image;
			    }
			}
			$return = [
				'status' => true,
				'data' => $messages,
				'message' => '',
				'user' => true
			];
		}
		else {
			$return = [
				'status' => false,
				'data' => array(),
				'message' => '',
				'user' => false
			];
		}
		print_r(json_encode($return));
	}

	public function delete()
	{
		$key = $this->security->xss_clean($this->input->post('auth'));
		if ($id = getUserId($key)) {
			$message_id = $this->security->xss_clean($this->input->post('message_id'));

			if ($this->Common->delete('messages',array('id' => $message_id))) {
				$return = [
					'status' => true,
					'data' => '',
					'message' => 'Message deleted',
					'user' => true
				];
			}
			else {
				$return = [
					'status' => false,
					'data' => '',
					'message' => 'Failed to delete message',
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
	
	public function test()
	{
	    $array = [
	        'member_id' => 1,
	        'message' => 'test',
	        'date' => date('Y-m-d H:i:s')
	    ];
		$SERVER_API_KEY = "AIzaSyCm131OryoKDslBi4hQgzyBEy-ljLxbHz0";
		$user = $this->chat->getUsername($array['member_id']);
		$array['username'] = $user->username;
		if($user->username == '')
		{
		    $array['image'] = '';
		}
		else
		{
		    $array['image'] = $user->username;
		}
		$to = "/topics" . "/FCM-ISS-chat2019";

		$header = [
			'Authorization: key='. $SERVER_API_KEY,
			'Content-Type: Application/json'
		];

		$notification = [
			'title' => 'New message',
			'body' => 'Testing notification',
			'content_available' => true
		];

		$data = [
			'title' => 'New message',
			'body' => 'Testing notification',
			'data' => [
				'message' => $array
			]
		];

		$payload = [
			'data' => $data,
			'notification' => $notification,
			'to' => $to,
			'priority' => 10
		];

		$url = 'https://fcm.googleapis.com/fcm/send';

		$curl = curl_init();

		curl_setopt_array($curl, array(
			 CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
			 CURLOPT_RETURNTRANSFER => true,
			 CURLOPT_CUSTOMREQUEST => "POST",
			 CURLOPT_POSTFIELDS => json_encode($payload),
			 CURLOPT_HTTPHEADER => $header,
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		print_r($response);

	}

}
?>

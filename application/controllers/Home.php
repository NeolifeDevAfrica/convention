<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if(!Login::check())
			return redirect('auth');
	}

	public function index()
	{
		$data['page']	= 'home/index';

		$this->load->view('index', $data);
	}

	public function search($query = '')
	{
		$tickets = DB::get('orders', ['order_id' => (int)(trim($query))]);

		if(!$tickets){

			$tickets = DB::get('orders', ['neolife_id' => trim($query)]);
		}

		if(!$tickets){

			echo json_encode(['status' => false, 'data' => 'Ticket Not found']);

			exit(0);
		}

		$data = [];

		foreach($tickets as $row){

			if((int)$row->return_id > 0)
				continue;

			$ticket = DB::firstOrNew('orders', ['order_id' => $row->return_id]);

			if((int)$ticket->id > 0)
				continue;

			$data[] = $row;
		}

		echo json_encode(['status' => true, 'data' => $data]);
	}

	public function update($id = 0)
	{
		if(!Login::check()){

			echo json_encode(['status' => false, 'data' => 'You are not Logged In. Reload this page.']);

			exit(0);
		}

		$ticket = DB::first('orders', ['id' => $id]);
		$user_id = $this->session->userdata('user_id');

		if(!$ticket){

			echo json_encode(['status' => false, 'data' => 'Ticket not found']);

			exit(0);
		}

		if($ticket->status == 0){

			DB::update('orders', ['id' => $ticket->id], ['status' => 1, 'marked_at' => date('Y-m-d H:i:s'), 'user_id' => $user_id ]);

		}else{

			DB::update('orders', ['id' => $ticket->id], ['status' => 0]);

		}

		echo json_encode(['status' => true, 'data' => 'Ticket marked succesfully']);
	}


	public function stats()
	{	
		"select date(marked_at) as date, max(item_code), sum(quantity) as count from orders where status = 1 group by date(marked_at), item_code order by max(date(marked_at)) desc, max(item_code) desc";

		$present 				= $this->db->query("select sum(quantity) as count from orders where status = 1")->row();
		$absent 				= $this->db->query("select sum(quantity) as count from orders where status = 0")->row();
		$present_teams 			= $this->db->query("select sum(quantity) as count, max(pt_name) as pt from orders where status = 1 group by pt_name order by sum(quantity) desc, max(pt_name) asc")->result();
		$absent_teams			= $this->db->query("select sum(quantity) as count, max(pt_name) as pt from orders where status = 0 group by pt_name order by sum(quantity) desc, max(pt_name) asc")->result();
		$present_details 		= $this->db->query("select date(marked_at) as date, max(item_code) as item_code, sum(quantity) as count from orders where status = 1 group by date(marked_at), item_code order by max(date(marked_at)) desc, max(item_code) desc")->result();
		$present_details_days 	= $this->db->query("select date(marked_at) as date, sum(quantity) as count from orders where status = 1 group by date(marked_at) order by date(max(marked_at)) desc")->result();
		$present_details_users 	= $this->db->query("select date(marked_at) as date, max(user_id) as user_id, sum(quantity) as count from orders where status = 1 group by date(marked_at), user_id order by max(date(marked_at)) desc, max(item_code) desc")->result();
		$absent_details 		= $this->db->query("select date(marked_at) as date, max(item_code) as item_code, sum(quantity) as count from orders where status = 0 group by date(marked_at), item_code order by max(date(marked_at)) desc, max(item_code) desc")->result();

		$data['page']					= 'home/stats';
		$data['present'] 				= $present->count ?? 0;
		$data['absent']					= $absent->count ?? 0;
		$data['present_teams']			= $present_teams;
		$data['absent_teams']			= $absent_teams;
		$data['present_details'] 		= $present_details;
		$data['present_details_days'] 	= $present_details_days;
		$data['present_details_users'] 	= $present_details_users;
		$data['absent_details'] 		= $absent_details;

		$this->load->view('index', $data);
	}

}
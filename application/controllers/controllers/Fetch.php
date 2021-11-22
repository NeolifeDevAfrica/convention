<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fetch extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if(!Login::check())
			return redirect('auth');

	}

	public function index($order_id = 0)
	{	
		if($order_id < 1){

			$order = $this->db->query('select max(order_id) as order_id from orders')->row();
			$order_id = $order->order_id;
		}

		redirect('fetch/api/'.$order_id);
	}

	public function api($order_id = 0)
	{

		try{

			$curl = curl_init();
			curl_setopt_array($curl, [

				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'https://api.neolifeafrica.info/convention/search-ng/'.$order_id
			]);

			$response = json_decode(curl_exec($curl));
			curl_close($curl);

			$data['page']		= 'fetch/index';

			if(!isset($response->status) || $response->status == false || !isset($response->data)){

				$data['error']	 = 'Invalid Response recieved.';
				$data['message'] = $response->data;

				return $this->load->view('index', $data);
			}

			$tickets = [];

			foreach($response->data as $row){

				if(DB::count('orders', ['order_id' => $row->order_id]) > 0)
					continue;

				$tickets[] = [

					'order_id'						=> $row->order_id,
					'neolife_id'					=> $row->neolife_id,
					'item_code'						=> $row->item_code,
					'customer_name'					=> $row->customer_name,
					'rank'							=> $row->rank,
					'quantity'						=> $row->quantity,
					'return_id'						=> $row->return_id,
					'team_name'						=> $row->team_name,
					'pt_name'						=> $row->pt_name,
					'july_ppv'						=> $row->july_ppv,
					'july_personal_sponsoring'		=> $row->july_personal_sponsoring,
					'august_ppv'					=> $row->august_ppv,
					'august_personal_sponsoring'	=> $row->august_personal_sponsoring
				];
			}

			if(count($tickets) > 0)
				$this->db->insert_batch('orders', $tickets);

			$data['tickets']	= $tickets;
			

		}catch(Exception $e){

			$data['error']		= $e->getMessage();
		}

		return $this->load->view('index', $data);
		
	}
}
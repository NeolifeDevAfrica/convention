<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Draws extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if(!Login::check())
            return redirect('auth');

    }

    public function index()
    {
        $data['page']   = 'draws/index';

        $this->load->view('draws/layout', $data);
    }

    public function form()
    {

        if($this->input->post()){

            $data['filters'] = $this->input->post();
            $data['page']   = 'draws/index';

        }else{

            $data['page']   = 'draws/form';
            $data['ranks']  = $this->db->query("select max(rank_description) as rank_description from orders group by rank_description order by max(rank_description) asc")->result();
        }
        
        $this->load->view('draws/layout', $data);
    }

    public function filter()
    {   
        $filters = json_decode(file_get_contents('php://input'), true);
        
        $item_codes         = $filters['item_codes'] ?? [];
        $ranks              = $filters['ranks'] ?? [];
        $july_ppv           = $filters['july_ppv'] ?? 0;
        $august_ppv         = $filters['august_ppv'] ?? 0;
        $july_sponsoring    = $filters['july_sponsoring'] ?? 0;
        $august_sponsoring  = $filters['august_sponsoring'] ?? 0;

        $this->db->where('date(marked_at)', date('Y-m-d'));

        if(count($item_codes) > 0)
            $this->db->where_in('item_code', $item_codes);

        if(count($ranks) > 0)
            $this->db->where_in('rank_description', $ranks);

        if($july_ppv > 0)
            $this->db->where('july_ppv >= ', $july_ppv);

        if($july_sponsoring > 0)
            $this->db->where('july_personal_sponsoring >= ', $july_sponsoring);

        if($august_ppv > 0)
            $this->db->where('august_ppv >= ', $august_ppv);

        if($august_sponsoring > 0)
            $this->db->where('august_personal_sponsoring >= ', $august_sponsoring);

        $tickets = $this->db->get('orders')->result();
        
        echo json_encode(['tickets' => $tickets, 'filters' => $filters]);

    }

    public function tickets($code = '416')
    {
        $tickets = DB::get('orders', ['status' => 1, 'item_code' => $code, 'date(updated_at)' => date('Y-m-d')]);

        $response = [];

        foreach($tickets as $row){

            $response[] = [

                'id'            => $row->id,
                'neolife_id'    => $row->neolife_id,
                'name'          => $row->customer_name,
                'code'          => $row->item_code,
                'order_id'      => $row->order_id
            ];
        }

        echo json_encode($response);
    }

    public function dd($data)
    {
        echo json_encode($data); die;
    }
}
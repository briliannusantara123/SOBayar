<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Xendit\Xendit;
class Webhook extends CI_Controller {
function __construct()
		{
			parent::__construct();
		
			$this->load->model('Item_model');
			$this->load->model('Daftarorder_model');
		}
	public function index()
	{
		// https://7068-2001-448a-304b-5703-c50f-38ce-4dd1-8e6d.ngrok-free.app/SOxendit/index.php/Cart/webhook/
		//http://dev.3guru.com:807/SOxendit/index.php/Cart/webhook/
		Xendit::setApiKey('xnd_development_MHFonfxW3xEdU1wQTfaMT8epmrJgdZqq0OSO47d91B1CO8LflPMc1cmF6KhphW');
		 $json = file_get_contents('php://input');
    	 $data = json_decode($json, true);
    	 $id = isset($data['id']) ? $data['id'] : null;
		 $getInvoice = \Xendit\Invoice::retrieve($id);
		 $getInvoiceString = json_encode($data);
		 $id_trans = isset($data['failure_redirect_url']) ? $data['failure_redirect_url'] : null;

		 $dataevent = [
			'id_trans' => $id_trans,
			'id_invoice' => $id,
			'description' => $getInvoiceString,
			'created_date' => date('Y-m-d'),
		];
		$result = $this->db->insert('sh_sopayment_log',$dataevent);
		echo json_encode(['data' => $dataevent]);
	}
	
	
}

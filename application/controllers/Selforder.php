<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Selforder extends CI_Controller {
public function __construct() {
			parent::__construct();
			
			$this->load->model('Item_model');
			$this->load->model('cekstatus_model');
			$this->load->helper('cookie');
			$session = $this->cekstatus_model->cek();
			if($this->session->userdata('username') == ""){
           		$nomeja = $this->session->userdata('nomeja');
  				redirect('index.php/login/logout/'.$nomeja);
        	}
        	// if ($session['status'] == 'Payment') {
	  		// 	$nomeja = $this->session->userdata('nomeja');
	  		// 	redirect('login/logout/'.$nomeja);
	  		// }else 
	  		if($session['status'] == 'Cleaning'){
	  			$nomeja = $this->session->userdata('nomeja');
	  			redirect('index.php/login/logout/'.$nomeja);
	  		}
	  		if($session['id_table'] != $this->session->userdata('nomeja')){
	  			$nomeja = $this->session->userdata('nomeja');
	  			redirect('index.php/login/log_out/'.$nomeja);
	  		}
		}
	public function index()
	{
		$nomeja = $this->session->userdata('nomeja');
		$this->session->set_flashdata('success','Payment Successful, Order Sent to Kitchen');
		redirect('index.php/selforder/home/'.$nomeja);
	}
	public function home($nomeja)
	{
		$id_customer = $this->session->userdata('id');
		$cs = $this->session->userdata('id');
		$data['no_meja'] = $nomeja;
		$data['cart_count'] = $this->Item_model->hitungcart($nomeja);
		$data['sca'] = $this->Item_model->sub_category_awal();
		$data['scm'] = $this->Item_model->sub_category_minuman_awal();
		$data['sub_category'] = "ayam";
		$data['sub_category_minuman'] = "Cold Drink";
		$cart_count = $this->Item_model->cart_count($id_customer,$nomeja)->num_rows();
		if($cart_count > 0){
			$cart = $this->Item_model->cart_count($id_customer,$nomeja)->row();//tambahan	
			$cart_total = $cart->total_qty;
		}else{
			$cart_total = 0;
		}
		$data['total_qty'] = $cart_total;
		// var_dump($test);exit();
		$this->load->view('self_index',$data);
	}
	public function viewpdf($bk=NULL)
	{
		if ($bk) {
			$cekbk = $bk;
		}else{
			$cekbk = '';
		}
		$id_customer = $this->session->userdata('id');
		$cabang = $this->db->order_by('id',"desc")
  			->limit(1)
  			->get('sh_m_cabang')
  			->row('id');
  		$notrans = $this->db->order_by('id',"desc")->where('id_customer',$id_customer)
  			->limit(1)
  			->get('sh_t_transactions')
  			->row('id');
  		// echo $cabang; echo "<br>";echo $notrans;exit();
		$uc = $this->session->userdata('username');
		$data['item'] = $this->Item_model->billsementara($id_customer)->result();
		$data['total'] = $this->Item_model->total($uc);
		$data['nomeja'] = $this->session->userdata('nomeja');
		$data['notrans'] = $notrans;
		$data['order_bill'] = $this->Item_model->order_bill_pdf($cabang,$notrans);
		$data['order_bill_line'] = $this->Item_model->order_bill_line_pdf($cabang,$notrans);
		$payment = $this->Item_model->get_payment($cabang,$notrans)->row();
		$data['datapayment'] = json_decode($payment->description, true);
		$data['cekbk'] = $cekbk;
		$this->load->view('Home/viewpdf',$data);
	}
	public function cetakpdf($bk=NULL)
	{
		if ($bk) {
			$cekbk = $bk;
		}else{
			$cekbk = '';
		}
		$id_customer = $this->session->userdata('id');
		$cabang = $this->db->order_by('id',"desc")
  			->limit(1)
  			->get('sh_m_cabang')
  			->row('id');
  		$notrans = $this->db->order_by('id',"desc")->where('id_customer',$id_customer)
  			->limit(1)
  			->get('sh_t_transactions')
  			->row('id');
  		// echo $cabang; echo "<br>";echo $notrans;exit();
		$uc = $this->session->userdata('username');
		$data['item'] = $this->Item_model->billsementara($id_customer)->result();
		$data['notrans'] = $notrans;
		$data['order_bill'] = $this->Item_model->order_bill_pdf($cabang,$notrans);
		$data['order_bill_line'] = $this->Item_model->order_bill_line_pdf($cabang,$notrans);
		$payment = $this->Item_model->get_payment($cabang,$notrans)->row();
		$data['datapayment'] = json_decode($payment->description, true);
		$data['cekbk'] = $cekbk;
		$html = $this->load->view('Home/cetakpdf',$data,true);
		$mpdf = new \Mpdf\Mpdf([
		    'format' => [80, 150], // Lebar x Tinggi dalam milimeter (misal: lebar x tinggi)
		    'margin_top' => 2,
		    'margin_right' => 2,
		    'margin_left' => 2,
		    'margin_bottom' => 2,
		]);

		$filename = 'InvoiceSH'.date('dmY').'.pdf';
		$mpdf->WriteHTML($html);
		$mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD); //INLINE


	}
		function cekinternet()
	{
		$this->load->view('cekinternet');
	}
}

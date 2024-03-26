<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orderpaket extends CI_Controller {
function __construct()
		{
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
		// $id_customer = $this->session->userdata('id');
		// $data['item'] = $this->Item_model->getDataOrder($id_customer)->result();
		$id_customer = $this->session->userdata('id');
		$nomeja = $this->session->userdata('nomeja');
		//$data['option'] = $this->Item_model->option();
		$data['sub'] = $this->Item_model->sub_category();
		$data['ic'] = $id_customer;
		$data['key'] = '';
		$data['cart_count'] = $this->Item_model->hitungcart($nomeja);
		$data['paket'] = $this->Item_model->getpaketso();
		$data['nomeja'] = $this->session->userdata('nomeja');
		$cart_count = $this->Item_model->cart_count($id_customer,$nomeja)->num_rows();
		if($cart_count > 0){
			$cart = $this->Item_model->cart_count($id_customer,$nomeja)->row();//tambahan	
			$cart_total = $cart->total_qty;
		}else{
			$cart_total = 0;
		}
		$data['total_qty'] = $cart_total;
		
		$this->load->view('orderpaket',$data);
	}
	public function getsub()
	{
		$item_code = $this->input->post('item_code');
		$getsub = $this->Item_model->sub_category_paket($item_code);
		echo json_encode($getsub);
	}
	public function menupaket($paket,$sub_category)
	{
		
		$id_customer = $this->session->userdata('id');
		$nomeja = $this->session->userdata('nomeja');
		$data['item'] = $this->Item_model->getDataPaket($paket,$sub_category);
		$data['sub'] = $this->Item_model->sub_category();
		//$data['option'] = $this->Item_model->option();
		$data['s'] = $sub_category;
		$data['ic'] = $id_customer;
		$data['cart_count'] = $this->Item_model->hitungcart($nomeja);
		$data['nomeja'] = $this->session->userdata('nomeja');
		$cart_count = $this->Item_model->cart_count($id_customer,$nomeja)->num_rows();
		if($cart_count > 0){
			$cart = $this->Item_model->cart_count($id_customer,$nomeja)->row();//tambahan	
			$cart_total = $cart->total_qty;
		}else{
			$cart_total = 0;
		}
		$data['total_qty'] = $cart_total;

			$this->load->view('menu/paket',$data);
		
	}
	public function orderqty()
	{
		$table = $this->session->userdata('nomeja');
		$uc = $this->session->userdata('username');
		$ic = $this->session->userdata('id');
		$post = $this->input->post();
		$trans = $this->db->get_Where('sh_t_transactions', array('id_customer'=> $ic))->row();
		if($post['tipe']=='plus' && $post['item_code'] != ''){
			$cek_count = $this->Item_model->get_cart_details($ic,$table,$post['itemcode'],$post['uoi'])->num_rows();
			if($cek_count > 0){
				$cek_cart = $this->Item_model->get_cart_details($ic,$table,$post['itemcode'],$post['uoi'])->row();
				if ($post['need_stock'] == 1) {
					if ($cek_cart->qty >= $post['stock']) {
						$aqty = $cek_cart->qty;
						$cek = True;
					}else{
						$aqty = $cek_cart->qty+1;
						$cek = False;
					}
				}else{
					$aqty = $cek_cart->qty+1;
					$cek = False;
				}
					
				$pesan = $post['extra_notes'];
				if($pesan != ''){
					$data = [
						'qty' => $aqty,
						
						
					];
				}else{
					$data = [
						'qty' => $aqty,
						
						
					];	
				}
				
				$this->Item_model->save('sh_cart_details',$data, ['item_code'=>$cek_cart->item_code,'user_order_id'=>$cek_cart->user_order_id,'left(entry_date,10)' => date('Y-m-d') ]);
				$cart_count = $this->Item_model->hitungcart($table);
				$carts = $this->Item_model->cart_count($ic,$table)->num_rows();
				if($carts > 0){
					$cart = $this->Item_model->cart_count($ic,$table)->row();	
					$total_qty = $cart->total_qty;
				}else{
					$total_qty = 0;
				}

				$notif = "Food Stocks Are Not Fulfilled";

				
				echo json_encode(array('status'=> True,'new_qty'=> $aqty,'pesan'=>$pesan,'cart_count'=>(int)$cart_count,'total_qty'=>(int)$total_qty,'notif' => $notif,'cek'=>$cek));
			}else{

				$pesan = $post['extra_notes'];
				
					$data = [
					'item_code' => $post['item_code'],
					'id_trans' => $trans->id,
					'id_customer' => $ic,
					'qty' => 1,
					'cabang' => $trans->cabang,
					'unit_price' => $post['hargapaket'],
					'description' => $post['paket'],
					'entry_by' => $this->session->userdata('username'),
					'id_table' => $table,
					'extra_notes' => $post['extra_notes'],
					'user_order_id' => $this->session->userdata('user_order_id'),
					'is_paket' => 1,
					];
					$query = $this->db->get_where('sh_cart', array('item_code' => $post['item_code'],'id_customer' => $ic,'id_table' => $table,'user_order_id' => $post['uoi'],'left(entry_date,10)' => date('Y-m-d')));
			        $hqty = $query->row();
			        if (!$hqty) {
			        	$cart_id = $this->Item_model->save('sh_cart',$data);
			        }else{
			        	$where = "left(entry_date,10) ='".date('Y-m-d H:i:s')."' and id_customer = '".$ic."' and item_code = '".$post['item_code']."' and user_order_id = '".$this->session->userdata('user_order_id')."'";
					  	$this->db->where($where);
		    			$cart_id = $this->db->update('sh_cart',$data);
			        }
			        
					$datadetails = [
					'paket_code' => $post['item_code'],
					'sub_category' => $post['subklik'], 
					'item_code' => $post['itemcode'],
					'qty' => 1,
					'description' => $post['description'],
					'extra_notes' => $post['extra_notes'],
					'user_order_id' => $this->session->userdata('user_order_id'),
					'id_table' => $table,
					'id_customer' => $ic,
					'id_trans' => $trans->id,
					];
					$this->Item_model->save('sh_cart_details',$datadetails);
					
					
				
				$cart_count = $this->Item_model->hitungcart($table);

				$carts = $this->Item_model->cart_count($ic,$table)->num_rows();
				if($carts > 0){
					$cart = $this->Item_model->cart_count($ic,$table)->row();	
					$total_qty = $cart->total_qty;
				}else{
					$total_qty = 0;
				}
				
				if($cart_id){
					echo json_encode(array('status'=> True,'new_qty'=> 1,'pesan'=>$pesan,'cart_count'=>(int)$cart_count,'total_qty'=>(int)$total_qty));	
				}
			}
		}else if($post['tipe']=='minus' && $post['itemcode'] != ''){
			$cek_count = $this->Item_model->get_cart_details($ic,$table,$post['itemcode'],$post['uoi'])->num_rows();
			if($cek_count > 0){
				$cek_cart = $this->Item_model->get_cart_details($ic,$table,$post['itemcode'],$post['uoi'])->row();
				$cc = $this->Item_model->get_cart($ic,$table,$post['item_code'],$post['uoi'])->row();
		        $this->db->select_sum('qty');  // Menghitung jumlah total kolom 'qty'
		        $query = $this->db->get('sh_cart_details');  // Ganti 'nama_tabel' dengan nama tabel Anda
		        $hqty = $query->row()->qty;
		        if ($hqty == 1) {
		        	$this->db->delete('sh_cart',['id'=>$cc->id]);
		        }
		       
				if($cek_cart->qty == 1){
					$this->db->delete('sh_cart_details',['item_code'=>$cek_cart->item_code]);
					$cart_count = $this->Item_model->hitungcart($table);
					$carts = $this->Item_model->cart_count($ic,$table)->num_rows();
					if($carts > 0){
						$cart = $this->Item_model->cart_count($ic,$table)->row();	
						$total_qty = $cart->total_qty;
					}else{
						$total_qty = 0;
					}
					echo json_encode(array('status'=> True,'new_qty'=> 0,'pesan'=>'','cart_count'=>(int)$cart_count,'total_qty'=>(int)$total_qty));
				}else{
					$pesan = $post['extra_notes'];
					$data = [
						'qty' => ($cek_cart->qty-1),
					];
					$this->Item_model->save('sh_cart_details',$data, ['item_code'=>$cek_cart->item_code]);
					$cart_count = $this->Item_model->hitungcart($table);
					$carts = $this->Item_model->cart_count($ic,$table)->num_rows();
					if($carts > 0){
						$cart = $this->Item_model->cart_count($ic,$table)->row();	
						$total_qty = $cart->total_qty;
					}else{
						$total_qty = 0;
					}
					echo json_encode(array('status'=> True,'new_qty'=> ($cek_cart->qty-1),'pesan'=>$pesan,'cart_count'=>(int)$cart_count,'total_qty'=>(int)$total_qty));
				}
			}
		}
	}
	public function orderqtyp() 
	{
		$table = $this->session->userdata('nomeja');
		$uc = $this->session->userdata('username');
		$ic = $this->session->userdata('id');
		$post = $this->input->post();
		$trans = $this->db->get_Where('sh_t_transactions', array('id_customer'=> $ic))->row();
		if($post['tipe']=='plus' && $post['item_code'] != ''){
			$cek_count = $this->Item_model->get_cart($ic,$table,$post['item_code'],$post['uoi'])->num_rows();
			if($cek_count > 0){
				$cek_cart = $this->Item_model->get_cart($ic,$table,$post['item_code'],$post['uoi'])->row();
				if ($post['need_stock'] == 1) {
					if ($cek_cart->qty >= $post['stock']) {
						$aqty = $cek_cart->qty;
						$cek = True;
					}else{
						$aqty = $cek_cart->qty+1;
						$cek = False;
					}
				}else{
					$aqty = $cek_cart->qty+1;
					$cek = False;
				}
					
				$pesan = $post['extra_notes'];
				if($pesan != ''){
					$data = [
						'qty' => $aqty,
						'extra_notes' => $post['extra_notes'],
						'user_order_id' => $this->session->userdata('user_order_id'),
					];
				}else{
					$data = [
						'qty' => $aqty,
						'user_order_id' => $this->session->userdata('user_order_id'),
					];	
				}
				
				$this->Item_model->save('sh_cart',$data, ['id'=>$cek_cart->id]);
				$cart_count = $this->Item_model->hitungcart($table);
				$carts = $this->Item_model->cart_count($ic,$table)->num_rows();
				if($carts > 0){
					$cart = $this->Item_model->cart_count($ic,$table)->row();	
					$total_qty = $cart->total_qty;
				}else{
					$total_qty = 0;
				}

				$notif = "Food Stocks Are Not Fulfilled";

				
				echo json_encode(array('status'=> True,'new_qty'=> $aqty,'pesan'=>$pesan,'cart_count'=>(int)$cart_count,'total_qty'=>(int)$total_qty,'notif' => $notif,'cek'=>$cek));
			}else{

				$pesan = $post['extra_notes'];
				$data = [
					'item_code' => $post['item_code'],
					'id_trans' => $trans->id,
					'id_customer' => $ic,
					'qty' => 1,
					'cabang' => $trans->cabang,
					'unit_price' => $post['unit_price'],
					'description' => $post['description'],
					'entry_by' => $this->session->userdata('username'),
					'id_table' => $table,
					'extra_notes' => $post['extra_notes'],
					'entry_date' => date('Y-m-d H:i:s'),
					'user_order_id' => $this->session->userdata('user_order_id'),
				];
				
				$cart_id = $this->Item_model->save('sh_cart',$data);
				$cart_count = $this->Item_model->hitungcart($table);

				$carts = $this->Item_model->cart_count($ic,$table)->num_rows();
				if($carts > 0){
					$cart = $this->Item_model->cart_count($ic,$table)->row();	
					$total_qty = $cart->total_qty;
				}else{
					$total_qty = 0;
				}
				$id_customer = $this->session->userdata('id');
				$id_trans = $this->db->get_Where('sh_t_transactions', array('id_customer'=> $id_customer))->row();
				$cabang = $this->db->order_by('id',"desc")
			  			->limit(1)
			  			->get('sh_m_cabang')
			  			->row('id');
			  	$ip_address = $this->input->ip_address();
			  	$cust = $this->session->userdata('username');
				$dataevent = [
					'event_type' => 'Update cart SO',
					'cabang' => $cabang,
					'id_trans' => $id_trans->id,
					'id_customer' => $this->session->userdata('id'),
					'event_date' => date('Y-m-d H:i:s'),
					'user_by' => $this->session->userdata('username'),
					'description' => 'Menambahkan item: '.$post['description'].' dengan qty: 1',
					'created_date' => date('Y-m-d'),
				];
				$result = $this->db->insert('sh_event_log',$dataevent);
				
				if($cart_id){
					echo json_encode(array('status'=> True,'new_qty'=> 1,'pesan'=>$pesan,'cart_count'=>(int)$cart_count,'total_qty'=>(int)$total_qty));	
				}
			}
		}else if($post['tipe']=='minus' && $post['item_code'] != ''){
			$cek_count = $this->Item_model->get_cart($ic,$table,$post['item_code'],$post['uoi'])->num_rows();
			if($cek_count > 0){
				$cek_cart = $this->Item_model->get_cart($ic,$table,$post['item_code'],$post['uoi'])->row();
				if($cek_cart->qty == 1){
					$this->db->delete('sh_cart',['id'=>$cek_cart->id]);
					$cart_count = $this->Item_model->hitungcart($table);
					$carts = $this->Item_model->cart_count($ic,$table)->num_rows();
					if($carts > 0){
						$cart = $this->Item_model->cart_count($ic,$table)->row();	
						$total_qty = $cart->total_qty;
					}else{
						$total_qty = 0;
					}
					$id_customer = $this->session->userdata('id');
					$id_trans = $this->db->get_Where('sh_t_transactions', array('id_customer'=> $id_customer))->row();
					$cabang = $this->db->order_by('id',"desc")
				  			->limit(1)
				  			->get('sh_m_cabang')
				  			->row('id');
				  	$ip_address = $this->input->ip_address();
				  	$cust = $this->session->userdata('username');
					$dataevent = [
						'event_type' => 'Update cart SO',
						'cabang' => $cabang,
						'id_trans' => $id_trans->id,
						'id_customer' => $this->session->userdata('id'),
						'event_date' => date('Y-m-d H:i:s'),
						'user_by' => $this->session->userdata('username'),
						'description' => 'Mengurangi 1 qty item: '.$post['description'],
						'created_date' => date('Y-m-d'),
					];
					$result = $this->db->insert('sh_event_log',$dataevent);
					echo json_encode(array('status'=> True,'new_qty'=> 0,'pesan'=>'','cart_count'=>(int)$cart_count,'total_qty'=>(int)$total_qty));
				}else{
					$pesan = $post['extra_notes'];
					$data = [
						'qty' => ($cek_cart->qty-1),
					];
					$this->Item_model->save('sh_cart',$data, ['id'=>$cek_cart->id]);
					$cart_count = $this->Item_model->hitungcart($table);
					$carts = $this->Item_model->cart_count($ic,$table)->num_rows();
					if($carts > 0){
						$cart = $this->Item_model->cart_count($ic,$table)->row();	
						$total_qty = $cart->total_qty;
					}else{
						$total_qty = 0;
					}
					
					echo json_encode(array('status'=> True,'new_qty'=> ($cek_cart->qty-1),'pesan'=>$pesan,'cart_count'=>(int)$cart_count,'total_qty'=>(int)$total_qty));
				}
			}
		}
	}

	
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Xendit\Xendit;

class Cart extends CI_Controller {
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
	public function testing()
	{
		$this->load->library('user_agent');

		if ($this->agent->is_mobile()) {
		    $device = $this->agent->mobile();
		   
		} else {
		    $device = "DEKSTOP";
		}
		$browser = $this->agent->browser();
		$version = $this->agent->version();
		$platform = $this->agent->platform();
		$robot = $this->agent->robot();
		$ip_address = $this->input->ip_address();
		echo "IP address pengguna adalah: " . $ip_address . "<br>";
		echo "Browser yang digunakan: " . $browser . "<br>";
		echo "Versi browser yang digunakan: " . $version . "<br>";
		echo "Platform yang digunakan: " . $platform . "<br>";
		echo "Device yang digunakan: " . $device . "<br>";
		echo "Apakah user agent adalah robot: " . ($robot ? 'Ya' : 'Tidak') . "<br>";
	}
	public function index()
	{
		$id_customer = $this->session->userdata('id');
		$data['item'] = $this->Item_model->getDataOrder($id_customer)->result();
		
		$this->load->view('ordersementara',$data);
	}
	public function home($nomeja=NULL,$cek=NULL,$sub=NULL,$no=NULL)
	{
		$id_customer = $this->session->userdata('id');
		$id_trans = $this->db->get_Where('sh_t_transactions', array('id_customer'=> $id_customer))->row('id');
		$dd = ['id_trans' => intval($id_trans)];
		$this->session->set_userdata($dd);
		$cc = $this->Item_model->cekcartbayar($id_customer)->result();
		if ($cc) {
			$data = ['status' => 'Billing'];
			$this->db->where('id_customer',$id_customer);
	    	$this->db->update('sh_rel_table',$data);
		}else{
			$data = ['status' => 'Order'];
			$this->db->where('id_customer',$id_customer);
	    	$this->db->update('sh_rel_table',$data);
		}
		
		// $data['total'] = $this->Item_model->totalSubOrder($uc);
		if ($cek == 'Orderpaket') {
			$data['item'] = $this->Item_model->cartpaket($id_customer)->result();
			$itm = $this->Item_model->cart($id_customer)->result();
			$resultArray = array();
			foreach ($itm as $it) {
			    $resultArray[] = $it->description.' Qty:'.$it->qty;
			}

			$resultString = implode(',', $resultArray);
			$data['it'] = $resultString;
			$data['itm'] = $this->Item_model->cart($id_customer)->result();
		}else{
			$data['item'] = $this->Item_model->cartpaket($id_customer)->result();
			$data['cekitm'] = $this->Item_model->cekcartpaket($id_customer)->result();
			$itm = $this->Item_model->cart($id_customer)->result();
			$resultArray = array();
			foreach ($itm as $it) {
			    $resultArray[] = $it->description.' Qty:'.$it->qty;
			}

			$resultString = implode(',', $resultArray);
			$data['it'] = $resultString;
		}
		$notrans = $this->db->order_by('id',"desc")->where('id_customer',$id_customer)
  			->limit(1)
  			->get('sh_t_transactions')
  			->row('id');
		$data['totalbayar'] = $this->Item_model->totalbayar($notrans);
		$data['nomeja'] = $nomeja;
		
		if ($cek == 'Makanan') {
			$log = 'index.php/ordermakanan/menu/Makanan/'.$sub.'#'.preg_replace('/%20/', '_', $sub);;
		}elseif ($cek == 'Minuman') {
			$log = 'index.php/orderminuman/menu/Minuman/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
		}elseif ($cek == 'CAKE%20DAN%20BAKERY') {
			$log = 'index.php/ordercakebakery/menu/CAKE%20DAN%20BAKERY/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
		}elseif ($cek == 'Orderpaket') {
			$log = 'index.php/orderpaket/';
		}else{
			$log = 'index.php/selforder/home/'.$nomeja;
		}


		$data['log'] = $log;
		$data['cek'] = $cek;
		$data['sub'] = $sub;
		$data['no'] = $no;
		$this->load->view('cart',$data);
	}
	public function detailmenupaket($nomeja,$paket,$cek=NULL,$sub=NULL,$no=NULL)
	{
		$id_customer = $this->session->userdata('id');
		// $data['total'] = $this->Item_model->totalSubOrder($uc);
		$data['item'] = $this->Item_model->getcartpaket($id_customer,urldecode($paket))->result();
		// var_dump($item);exit();
			$data['cekitm'] = $this->Item_model->cekcartpaket($id_customer)->result();
			$itm = $this->Item_model->cart($id_customer)->result();
			$resultArray = array();
			foreach ($itm as $it) {
			    $resultArray[] = $it->description.' Qty:'.$it->qty;
			}

			$resultString = implode(',', $resultArray);
			$data['it'] = $resultString;
		$data['nomeja'] = $nomeja;
		
		if ($cek == 'Makanan') {
			$log = 'index.php/Cart/home/'.$nomeja.'/Makanan/'.$sub.'#'.preg_replace('/%20/', '_', $sub);;
		}elseif ($cek == 'Minuman') {
			$log = 'index.php/Cart/home/'.$nomeja.'/Minuman/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
		}elseif ($cek == 'CAKE%20DAN%20BAKERY') {
			$log = 'index.php/Cart/home/'.$nomeja.'/CAKE%20DAN%20BAKERY/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
		}elseif ($cek == 'Orderpaket') {
			$log = 'index.php/Cart/home/'.$nomeja.'/Orderpaket';
		}else{
			$log = 'index.php/selforder/home/'.$nomeja;
		}

		$data['log'] = $log;
		$data['cek'] = $cek;
		$data['sub'] = $sub;
		$data['no'] = $no;
		$data['paket'] = urldecode($paket);
		$this->load->view('cartdetailpaket',$data);
	}
	public function ubahdetail($id,$nomeja,$cek,$sub)
	{
		// echo $sub;exit();
		$qty = $this->input->post('qty');
		$extra_notes = $this->input->post('extra_notes');
		$data = [
			'qty' => $qty,
			'extra_notes' => $extra_notes,
		];
		$this->db->where('id',$id);
		if ($qty != 0) {
			$this->db->update('sh_cart_details',$data);
			$this->session->set_flashdata('success','Menu Has Been Updated');
		}else{
			$this->db->delete('sh_cart_details');
			$this->session->set_flashdata('error','Menu Has Been Removed');
		}
    	
    	if ($cek == 'Makanan') {
			$log = 'index.php/Cart/home/'.$nomeja.'/Makanan/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
		}elseif ($cek == 'Minuman') {
			$log = 'index.php/Cart/home/'.$nomeja.'/Minuman/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
		}elseif ($cek == 'CAKE%20DAN%20BAKERY') {
			$log = 'index.php/Cart/home/'.$nomeja.'/CAKE%20DAN%20BAKERY/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
		}elseif ($cek == 'orderpaket') {
			$log = 'index.php/Cart/detailmenupaket/'.$nomeja.'/'.$sub.'/orderpaket/';
		}else{
			$log = 'index.php/Cart/home/'.$nomeja;
		}
		redirect(base_url().$log);
		
	}
	public function deletedetail($id,$nomeja,$sub,$cek,$paket)
	{
		$this->db->where('id',$id);
    	$this->db->delete('sh_cart_details');
    	$this->session->set_flashdata('success','Menu Has Been Removed');

    	if ($cek == 'Makanan') {
			$log = 'index.php/Cart/home/'.$nomeja.'/Makanan/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
		}elseif ($cek == 'Minuman') {
			$log = 'index.php/Cart/home/'.$nomeja.'/Minuman/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
		}elseif ($cek == 'CAKE%20DAN%20BAKERY') {
			$log = 'index.php/Cart/home/'.$nomeja.'/CAKE%20DAN%20BAKERY/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
			// $log = 'index.php/Cart/home/CAKE%20DAN%20BAKERY/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
		}elseif ($cek == 'orderpaket') {
			$log = 'index.php/Cart/detailmenupaket/'.$nomeja.'/'.$paket.'/orderpaket/';
		}else{
			$log = 'index.php/Cart/home/'.$nomeja;
		}
		redirect(base_url().$log);
	}
	public function create($nomeja,$cek,$sub)
	{
		$ic = $this->session->userdata('id');
		$qty = $this->input->post('qty');
		$ata = $this->input->post('cek');
		$qta = $this->input->post('qta');
		$nama = $this->input->post('nama');
		$pesan = $this->input->post('pesan');
		$pesandua = $this->input->post('pesandua');
		$pesantiga = $this->input->post('pesantiga');
		$harga = $this->input->post('harga');
		$item_code = $this->input->post('no');
		$table = $this->session->userdata('nomeja');
		$id_customer = $this->session->userdata('id');
		$id_trans = $this->db->get_Where('sh_t_transactions', array('id_customer'=> $id_customer))->row();
		$id_table = $this->db->get_Where('sh_rel_table', array('id_customer'=> $id_customer))->row();
		$st = $id_table->status;
		if ($st == "Dining" || $st == "Order") {
			$order_stat = 1;
		}elseif ($st == "Billing" || $st == "Payment") {
			$order_stat = 2;
		}

		$today = date('Y-m-d');
		$curTime = explode(':', date('H:i:s'));
		$cekWeekEnd = date('D', strtotime($today));
		$check_promo = $this->Item_model->get_promo($today)->num_rows();
		$get_promo = $this->Item_model->get_promo($today)->row_array();
		$discount = 0;
		if($check_promo > 0){
			$item_check = $this->Item_model->get_info_item($this->input->post('item_code'),$get_promo)->num_rows();
			if($item_check > 0){
				$item_data = $this->Item_model->get_info_item($this->input->post('item_code'),$get_promo)->row_array();
				if($get_promo["promo_type"] == 'Discount'){
					if($get_promo["promo_criteria"] == 'Weekday'){ //Weekday
						if($cekWeekEnd !== "Sat" || $cekWeekEnd !== "Sun" || $cekWeekEnd !== "Sab" || $cekWeekEnd !== "Min"){
							if($curTime[0] >= $get_promo["promo_from"] && $curTime[0] <= $get_promo["promo_to"]){
								$discount = $get_promo["promo_value"];		
							}else{
								$discount = 0;
							}
						}else{
							$discount = 0;
						}	
					}else if($get_promo["promo_criteria"] == 'Weekend'){ //Weekend
						if($cekWeekEnd === "Sat" || $cekWeekEnd === "Sun" || $cekWeekEnd === "Sab" || $cekWeekEnd === "Min"){
							if($curTime[0] >= $get_promo["promo_from"] && $curTime[0] <= $get_promo["promo_to"]){
								$discount = $get_promo["promo_value"];		
							}else{
								$discount = 0;
							}
						}else{
							$discount = 0;
						}	
					}else{ //Full Week
						if($curTime[0] >= $get_promo["promo_from"] && $curTime[0] <= $get_promo["promo_to"]){
							$discount = $get_promo["promo_value"];		
						}else{
							$discount = 0;
						}
					}
				}else{
					$discount = 0;	
				}
			}else{
				$discount = 0;
			}
		}
		$cabang = $this->db->order_by('id',"desc")
  			->limit(1)
  			->get('sh_m_cabang')
  			->row('id');
		$nomer = 1;
		for ($i = 0; $i < count($qty); $i++) {
			if ($qty[$i] != 0) {
				$n = $nomer++ . "<br>"; 
				$data[] = [
				'id_trans' => $id_trans->id,
				'id_customer' => $ic,
				'item_code' => $item_code[$i],
				'qty' => $qty[$i],
				'cabang' => $cabang,
				'unit_price' => $harga[$i],
				'description' => $nama[$i],
				'start_time_order' => date('H:i:s'),
				'entry_by' => $this->session->userdata('username'),
				'disc' => $discount,
				'is_cancel' => 0,
				'session_item' => 0,
				'selected_table_no' => $table,
				'seat_id' => 0,
				'sort_id' => $n,
				'as_take_away' => 0,
				'qty_take_away' => 0,
				'extra_notes' => $pesan[$i],
				'checker_printed' => 1,
				'created_date' => date('Y-m-d'),
				'order_type' => $order_stat,
			];
			 }
    
	}
	// var_dump($data);exit();
	$result = $this->db->insert_batch('sh_t_sub_transactions',$data);
			if ($result) {
				
    			$this->session->set_flashdata('success','Order Menu/Paket Berhasil Di Tambahkan');
				redirect('ordermakanan/subcreate/'.$nomeja.'/'.$cek.'/'.$sub);
				// $where = array('qty' => 0);
				// $this->Item_model->hapus_qty($where,'testing');
			}else{
				echo "gagal order";
			}

		
	}
	public function batal($nomeja,$cek,$sub)
	{
		$ic = $this->session->userdata('id');
		$this->db->where('id_customer',$ic);
    	$this->db->delete('sh_t_sub_transactions');
    	redirect('cart/home/'.$nomeja.'/'.$cek.'/'.$sub);
	}
	public function vo($table,$type,$cek=NULL,$sub=NULL)
	{
		$table = $this->session->userdata('nomeja');
		$sold = $this->input->post('sold');
		$qty = $this->input->post('qty');
		$ata = $this->input->post('cek');
		$qta = $this->input->post('qta');
		$nama = $this->input->post('nama');
		$pesan = $this->input->post('pesan');
		$pesandua = $this->input->post('pesandua');
		$pesantiga = $this->input->post('pesantiga');
		$harga = $this->input->post('harga');
		$item_code = $this->input->post('no');
		$need_stock = $this->input->post('need_stock');
		$is_paket = $this->input->post('is_paket');
		$id_customer = $this->session->userdata('id');
		$id_trans = $this->db->get_Where('sh_t_transactions', array('id_customer'=> $id_customer))->row();
		$id_table = $this->db->get_Where('sh_rel_table', array('id_customer'=> $id_customer))->row();
		$st = $id_table->status;

		$array_with_quotes = array_map(function($val) { return "'" . $val . "'"; }, $qty);
$q = implode('', $qty);
$itemc = implode(',', $item_code);
$cekdata = $this->Item_model->getDataC($item_code);

for ($i = 0; $i < count($cekdata); $i++) {
    if ($cekdata[$i]->is_paket == 1) {
        $cd = array(); // Inisialisasi array $cd di sini

        for ($j = 0; $j < count($nama); $j++) {
            $details[$j] = $this->Item_model->getcartpaket($id_customer, urldecode($nama[$j]))->result();
            for ($a = 0; $a < count($details[$j]); $a++) {
                $cd[$j][$a] = $this->Item_model->getDataCD(array($details[$j][$a]->item_code));
                // var_dump($details[$j][$a]->item_code);var_dump($details[$j][$a]->id_customer);var_dump($details[$j][$a]->id_table);var_dump($details[$j][$a]->user_order_id);
                // $qt[$j][$a] = $this->Item_model->getDataQD($details[$j][$a]->item_code,$details[$j][$a]->id_customer,$details[$j][$a]->id_table,$details[$j][$a]->user_order_id);
                
                // Lakukan operasi dengan data yang ada di $cd[$j][$a]
               	for ($b = 0; $b < count($cd[$j][$a]); $b++) {
               	  if ($sold == 1) {
               		$this->session->set_flashdata('error', $cekdata[$i]->description.' Has Been Sold Out');
                	redirect('cart/home/'.$table.'/'.$cek.'/'.$sub);
               	  }else{
                    if ($cd[$j][$a][$b]->need_stock == 1) {
                        if (intval($details[$j][$a]->qty) > $cd[$j][$a][$b]->stock) {
                            $status = "kurang";
                        } else {
                            $status = "cukup";
                        }
                        // var_dump($status);
                        if ($status == "kurang") {
                            $data = ['qty' => $cd[$j][$a][$b]->stock];
                            $this->db->where('id_customer', $id_customer);
                            $this->db->where('item_code', $cd[$j][$a][$b]->item_code);
                            $this->db->update('sh_cart_details', $data);
                            $this->session->set_flashdata('error', $cd[$j][$a][$b]->description . ' menu stock is not fulfilled');
                            redirect('cart/home/' . $this->session->userdata('nomeja'));
                        } else {
                            $this->order($table, $type, $cek, $sub);
                        }
                    } else {
                        $this->order($table, $type,$cek, $sub);
                    }
                   }
                }
            }
        }

        // var_dump($cd); // Outputkan semua data CD setelah loop selesai
        // exit(); // Keluar dari skrip (opsional)
    } else {
      if ($sold == 1) {
      	$this->session->set_flashdata('error', $cekdata[$i]->description.' Has Been Sold Out');
        redirect('cart/home/'.$table.'/'.$cek.'/'.$sub);
      }else{
      	$this->validasi_order($table, $type, $cek, $sub);
      }
        
    }
}




	}
	public function validasi_order($table,$cek=NULL,$sub=NULL)
	{
		$table = $this->session->userdata('nomeja');
		$qty = $this->input->post('qty');
		$ata = $this->input->post('cek');
		$qta = $this->input->post('qta');
		$nama = $this->input->post('nama');
		$pesan = $this->input->post('pesan');
		$pesandua = $this->input->post('pesandua');
		$pesantiga = $this->input->post('pesantiga');
		$harga = $this->input->post('harga');
		$item_code = $this->input->post('no');
		$need_stock = $this->input->post('need_stock');
		$is_paket = $this->input->post('is_paket');
		$id_customer = $this->session->userdata('id');
		$id_trans = $this->db->get_Where('sh_t_transactions', array('id_customer'=> $id_customer))->row();
		$id_table = $this->db->get_Where('sh_rel_table', array('id_customer'=> $id_customer))->row();
		$st = $id_table->status;

			$array_with_quotes = array_map(function($val) { return "'" . $val . "'"; }, $qty);
			$q = implode('', $qty);
			$itemc = implode(',', $item_code);
			
			 $cekdata = $this->Item_model->getDataC($item_code);
			for ($i=0;$i<count($cekdata);$i++) {
			  if ($cekdata[$i]->need_stock == 1) {
			  		if ($q[$i] > $cekdata[$i]->stock) {
						$status = "kurang";
					 }else{
					 	$status = "cukup";
					 } 

					 if ($status == "kurang") {
					 	$data = ['qty' => $cekdata[$i]->stock];
						$this->db->where('id_customer',$id_customer);
						$this->db->where('item_code',$cekdata[$i]->item_code);
	    				$this->db->update('sh_cart',$data);
					 	$this->session->set_flashdata('error', $cekdata[$i]->description.' menu stock is not fulfilled');
						 redirect('cart/home/'.$this->session->userdata('nomeja'));
					 	echo $cekdata[$i]->description." KURANG";
					 }else{
					 	$this->order($table,$cek,$sub);
					 }
			  	}else{
			  		$this->order($table,$cek,$sub);
			  	}	
				
				 echo "<br>";

				
			}
			// foreach($cekdata as $cd){
			// 	$test = $cd->no;
				
			// 	if ($q > $cd->stock) {
			// 		$data = ['qty' => $cd->stock];
			// 		$this->db->where('id_customer',$id_customer);
			// 		$this->db->where('item_code',$cd->no);
   //  				$this->db->update('sh_cart',$data);
   //  				$this->session->set_flashdata('error', $cd->description.' menu stock is not fulfilled');
			// 		 redirect('cart/home/'.$this->session->userdata('nomeja'));
			// 	}else{
			// 		echo "STOCK MENCUKUPI";
			// 		// $this->order($table);
			// 	}


			// 	// echo $cd->description;
				
			// }
	}
	public function order($table,$type,$cek=NULL,$sub=NULL)
	{
		$table = $this->session->userdata('nomeja');
		$qty = $this->input->post('qty');
		$ata = $this->input->post('cek');
		$qta = $this->input->post('qta');
		$nama = $this->input->post('nama');
		$pesandua = $this->input->post('pesandua');
		$pesantiga = $this->input->post('pesantiga');
		$harga = $this->input->post('harga');
		$item_code = $this->input->post('no');
		$need_stock = $this->input->post('need_stock');
		$id_customer = $this->session->userdata('id');
		$id_trans = $this->db->get_Where('sh_t_transactions', array('id_customer'=> $id_customer))->row();
		$id_table = $this->db->get_Where('sh_rel_table', array('id_customer'=> $id_customer))->row();
		$st = $id_table->status;

			$date = date('Y-m-d');
			$ctime = date('H:i:s');
			$this->db->from('sh_set_time_cekdata');
			$this->db->order_by('id', 'DESC'); // urutkan berdasarkan id secara descending
			$this->db->limit(1); // ambil hanya satu baris terakhir
			$query = $this->db->get();
			$no = $query->row('seconds');
			$seconds = " +".$no." seconds";
			// echo $seconds;exit(); 
			
			// echo $time;exit();
			$this->db->select('*');
			$where = "left(t.created_date,10) ='".$date."' and t.selected_table_no = '".$table."' and t.selforder = 1 and user_order_id = '".$this->session->userdata('user_order_id')."'";
			$this->db->where($where);
			$this->db->where_in('t.item_code',$item_code);
			$this->db->where_in('t.qty',$qty);
			$this->db->order_by('t.id','DESC');    
			$query = $this->db->get('sh_t_transaction_details t');  //cek dulu apakah ada sudah ada kode di tabel.   
			
			for ($i = 0; $i < count($qty); $i++) {
				$this->db->from('sh_t_transaction_details');
			$where = "left(created_date,10) ='".$date."' and selected_table_no = '".$table."' and selforder = 1 and user_order_id = '".$this->session->userdata('user_order_id')."'";
			$this->db->where($where);
			$this->db->where_in('item_code',$item_code[$i]);
			// $this->db->where_in('qty',$qty);
			$this->db->order_by('id','DESC'); 
			 $this->db->limit(1); // ambil hanya satu baris terakhir
			$query = $this->db->get();
			$q = $query->row();
			}


			

			if ($q) {
				$time = date('H:i:s', strtotime($q->start_time_order . $seconds));
				for ($i = 0; $i < count($qty); $i++) {
				if (date('H:i:s') < $q->timeout_order_so) {
					$ic = $this->session->userdata('id');
					$where = "left(entry_date,10) ='".$date."' and id_customer = '".$ic."' and id_trans  = '".$id_trans->id."' and user_order_id = '".$this->session->userdata('user_order_id')."'";
					$this->db->where($where);
					$this->db->where_in('item_code',$item_code);
	    			$this->db->delete('sh_cart');
	    			$cabang = $this->db->order_by('id',"desc")
		  			->limit(1)
		  			->get('sh_m_cabang')
		  			->row('id');
		  			$ip_address = $this->input->ip_address();
		  			$wheredetails ="left(entry_date,10) ='".$date."' and id_customer = '".$ic."' and id_trans  = '".$id_trans->id."' and user_order_id = '".$this->session->userdata('user_order_id')."'";
						$this->db->where($wheredetails);
						$this->db->delete('sh_cart_details');

	    			$nomer = 1;
					
						if ($qty[$i] != 0) {
							$n = $nomer++ . "<br>"; 
							$data[] = [
							'event_type' => 'Duplicate Order',
							'cabang' => $cabang,
							'id_trans' => $id_trans->id,
							'id_customer' => $this->session->userdata('id'),
							'event_date' => date('Y-m-d H:i:s'),
							'user_by' => $this->session->userdata('username'),
							'description' => $item_code[$i].' '.$nama[$i].' Qty :'.$qty[$i].' IP :'.$ip_address,
							'created_date' => date('Y-m-d'),
						];
						 }
					
					$result = $this->db->insert_batch('sh_event_log',$data);

					$this->session->set_flashdata('error','Duplicate Order, Please Check Bill Preview');
					redirect('index.php/selforder/home/'.$table);
				}else{
					$cd = $this->Item_model->getDataC($item_code);
					for ($i = 0; $i < count($cd); $i++) {
    				 if ($cd[$i]->is_paket == 1) {
    				 	$this->op($table,$cek,$sub);
    				 }else{
    				 	if ($type == "PN") {
    				 		$this->bayar($table,$cek,$sub);
    				 	}else{
    				 		// $this->order_post($table,$cek,$sub);
    				 		$this->bayarkasir($table,$cek,$sub);
    				 	}
    				 	
    				 }
    				}
				}
			}
			}else{
				$time = date('H:i:s', strtotime($ctime . $seconds));
				$cd = $this->Item_model->getDataC($item_code);
					for ($i = 0; $i < count($cd); $i++) {
    				 if ($cd[$i]->is_paket == 1) {
    				 	$this->op($table,$cek,$sub);
    				 }else{
    				 	if ($type == "PN") {
    				 		$this->bayar($table,$cek,$sub);
    				 	}else{
    				 		// $this->order_post($table,$cek,$sub);
    				 		$this->bayarkasir($table,$cek,$sub);
    				 	}
    				 }
    				}
			}
	}
	public function bayarkasir($table,$cek,$sub)
	{
		$amount = $this->input->post('totalbayar');
		$item_code = $this->input->post('no');
		$id_customer = $this->session->userdata('id');
		$id_trans = $this->db->get_Where('sh_t_transactions', array('id_customer'=> $id_customer))->row('id');
		$update_data = array();
		for ($i = 0; $i < count($item_code); $i++) {
			$update_data[] = array(
                'id_trans' => $id_trans,
                'bayar_kasir' => 1
            );
		}
        $update = $this->db->update_batch('sh_cart', $update_data, 'id_trans');
        if ($update) {
        	if ($cek == 'Makanan') {
				$log = 'index.php/Cart/home/'.$nomeja.'/Makanan/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
			}elseif ($cek == 'Minuman') {
				$log = 'index.php/Cart/home/'.$nomeja.'/Minuman/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
			}elseif ($cek == 'CAKE%20DAN%20BAKERY') {
				$log = 'index.php/Cart/home/'.$nomeja.'/CAKE%20DAN%20BAKERY/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
			}else{
				$log = 'index.php/Cart/home/'.$nomeja;
			}
			redirect(base_url().$log);
        }
	}
	public function bayar()
    {
    	$amount = $this->input->post('totalbayar');
        $id_customer = $this->session->userdata('id');
        $nomeja = $this->session->userdata('nomeja');
        $cabang = $this->db->order_by('id',"desc")
                    ->limit(1)
                    ->get('sh_m_cabang')
                    ->row('id');
        $notrans = $this->db->order_by('id',"desc")->where('id_customer',$id_customer)
                    ->limit(1)
                    ->get('sh_t_transactions')
                    ->row('id');
        $tgl = date('ymd');
        $kode = "SH".$cabang.$notrans.$tgl;
        $extId = $kode;
        $description = "Pembayaran SO";
        $table = $this->session->userdata('nomeja');
		$qty = $this->input->post('qty');
		$ata = $this->input->post('cek');
		$qta = $this->input->post('qta');
		$nama = $this->input->post('nama');
		$pesan = $this->input->post('pesan');
		$pesandua = $this->input->post('pesandua');
		$pesantiga = $this->input->post('pesantiga');
		$harga = $this->input->post('harga');
		$item_code = $this->input->post('no');
		$need_stock = $this->input->post('need_stock');
		$is_paket = $this->input->post('is_paket');
		$id_customer = $this->session->userdata('id');
		$id_trans = $this->db->get_Where('sh_t_transactions', array('id_customer'=> $id_customer))->row();
		$id_table = $this->db->get_Where('sh_rel_table', array('id_customer'=> $id_customer))->row();
		$st = $id_table->status;
        $dataArray = array(
		    'table' => $table,
		    'qty' => $qty,
		    'ata' => $ata,
		    'qta' => $qta,
		    'nama' => $nama,
		    'pesan' => $pesan,
		    'pesandua' => $pesandua,
		    'pesantiga' => $pesantiga,
		    'harga' => $harga,
		    'item_code' => $item_code,
		    'need_stock' => $need_stock,
		    'is_paket' => $is_paket,
		    'id_customer' => $id_customer,
		);
        $successUrl = base_url()."index.php/Cart/sukses/".$nomeja.'?'.http_build_query($dataArray);
        $sukses = base_url()."index.php/Cart/webhook";
        // Ganti dengan kunci API Xendit Anda
        Xendit::setApiKey('xnd_development_MHFonfxW3xEdU1wQTfaMT8epmrJgdZqq0OSO47d91B1CO8LflPMc1cmF6KhphW');

        $params = [
            "external_id" => $extId,
            "description" => $description,
            "amount" => $amount,
            "success_redirect_url"=> $successUrl,
            // redirect url if the payment is failed
            "failure_redirect_url"=> $id_trans->id,
        ];
        
        // $invoice = \Xendit\Invoice::create($params);
        // echo json_encode(['data' => $invoice['invoice_url']]);
        try {
	        $invoice = \Xendit\Invoice::create($params);
	        
	        // Ganti ini dengan pengiriman URL sebagai tanggapan
	        redirect($invoice['invoice_url']);
	    } catch (\Exception $e) {
	        // Tangani kesalahan jika terjadi
	        echo 'Error: ' . $e->getMessage();
	    }
    }
    public function sukses($nomeja,$cek=NULL,$sub=NULL,$no=NULL)
    {
    	$table = $this->session->userdata('nomeja');
    	$external_id = $this->input->get('external_id');
		$descriptionpay = $this->input->get('descriptionpay');
		$amount = $this->input->get('amount');
		$id_trans = $this->input->get('id_trans');
		$json_data = json_encode(array('external_id' => $external_id, 'description' => $descriptionpay,'amount' => $amount,'Status' => 'Sukses'));
		
		$qty = $this->input->get('qty');
		$ata = $this->input->get('cek');
		$qta = $this->input->get('qta');
		$nama = $this->input->get('nama');
		$pesan = $this->input->get('pesan');
		$pesandua = $this->input->get('pesandua');
		$pesantiga = $this->input->get('pesantiga');
		$harga = $this->input->get('harga');
		$item_code = $this->input->get('item_code');
		$need_stock = $this->input->get('need_stock');
		$is_paket = $this->input->get('is_paket');
		$id_customer = $this->session->userdata('id');
		$id_trans = $this->db->get_Where('sh_t_transactions', array('id_customer'=> $id_customer))->row();
		$id_table = $this->db->get_Where('sh_rel_table', array('id_customer'=> $id_customer))->row();
		$st = $id_table->status;
		$date = date('Y-m-d');
			$ctime = date('H:i:s');
			$this->db->from('sh_set_time_cekdata');
			$this->db->order_by('id', 'DESC'); // urutkan berdasarkan id secara descending
			$this->db->limit(1); // ambil hanya satu baris terakhir
			$query = $this->db->get();
			$no = $query->row('seconds');
			$seconds = " +".$no." seconds";
			
			$this->db->from('sh_t_transaction_details');
			$where = "left(created_date,10) ='".$date."' and selected_table_no = '".$table."' and selforder = 1 and user_order_id = '".$this->session->userdata('user_order_id')."'";
			$this->db->where($where);
			$this->db->where_in('item_code',$item_code);
			$this->db->where_in('qty',$qty);
			$this->db->order_by('id','DESC'); 
			$this->db->limit(1); // ambil hanya satu baris terakhir
			$query = $this->db->get();
			$q = $query->row();
			

			if ($q) {
				$time = date('H:i:s', strtotime($ctime . $seconds));
			}else{
				$time = date('H:i:s', strtotime($ctime . $seconds));
			}

							  		

		if ($st == "Dining" || $st == "Order") {
			$order_stat = 1;
		}elseif ($st == "Billing" || $st == "Payment" ) {
			$order_stat = 2;
		}
		$today = date('Y-m-d');
		$curTime = explode(':', date('H:i:s'));
		$cekWeekEnd = date('D', strtotime($today));
		$check_promo = $this->Item_model->get_promo($today)->num_rows();
		$get_promo = $this->Item_model->get_promo($today)->row_array();
		$discount = 0;
		if($check_promo > 0){
			$item_check = $this->Item_model->get_info_item($this->input->post('item_code'),$get_promo)->num_rows();
			if($item_check > 0){
				$item_data = $this->Item_model->get_info_item($this->input->post('item_code'),$get_promo)->row_array();
				if($get_promo["promo_type"] == 'Discount'){
					if($get_promo["promo_criteria"] == 'Weekday'){ //Weekday
						if($cekWeekEnd !== "Sat" || $cekWeekEnd !== "Sun" || $cekWeekEnd !== "Sab" || $cekWeekEnd !== "Min"){
							if($curTime[0] >= $get_promo["promo_from"] && $curTime[0] <= $get_promo["promo_to"]){
								$discount = $get_promo["promo_value"];		
							}else{
								$discount = 0;
							}
						}else{
							$discount = 0;
						}	
					}else if($get_promo["promo_criteria"] == 'Weekend'){ //Weekend
						if($cekWeekEnd === "Sat" || $cekWeekEnd === "Sun" || $cekWeekEnd === "Sab" || $cekWeekEnd === "Min"){
							if($curTime[0] >= $get_promo["promo_from"] && $curTime[0] <= $get_promo["promo_to"]){
								$discount = $get_promo["promo_value"];		
							}else{
								$discount = 0;
							}
						}else{
							$discount = 0;
						}	
					}else{ //Full Week
						if($curTime[0] >= $get_promo["promo_from"] && $curTime[0] <= $get_promo["promo_to"]){
							$discount = $get_promo["promo_value"];		
						}else{
							$discount = 0;
						}
					}
				}else{
					$discount = 0;	
				}
			}else{
				$discount = 0;
			}
		}
		$cabang = $this->db->order_by('id',"desc")
  			->limit(1)
  			->get('sh_m_cabang')
  			->row('id');
  		$t = $this->Item_model->cekdatatrans($id_customer)->row();
  		
  		if ($t) {
  		 $td = $this->Item_model->cekdatatransdetail($t->id)->row();
  		 // var_dump($td->cekdata);exit();
  		  $cd = $td->cekdata + 1;
  		}else{
  		  $cd = 1;
  		}
		$nomer = 1;
		for ($i = 0; $i < count($qty); $i++) {
			if ($qty[$i] != 0) {
				$n = $nomer++ . "<br>"; 
				$data[] = [
				'id_trans' => $id_trans->id,
				'item_code' => $item_code[$i],
				'qty' => $qty[$i],
				'cabang' => $cabang,
				'unit_price' => $harga[$i],
				'description' => $nama[$i],
				'start_time_order' => date('H:i:s'),
				'entry_by' => $this->session->userdata('username'),
				'disc' => $discount,
				'is_cancel' => 0,
				'session_item' => 0,
				'selected_table_no' => $table,
				'seat_id' => 0,
				'sort_id' => $n,
				'as_take_away' => 0,
				'qty_take_away' => 0,
				'extra_notes' => $pesan[$i],
				'checker_printed' => 1,
				'created_date' => date('Y-m-d H:i:s'),
				'order_type' => $order_stat,
				'selforder' => 1,
				'is_printed_so' => 0,
				'cekdata' => $cd,
				'user_order_id' => $this->session->userdata('user_order_id'),
				'timeout_order_so' => $time,
			];
			 }
			 // $cekdata = $this->Item_model->getDataC($item_code);

			 $cekdata[$i] = $this->db->where_in('no',$item_code[$i])
		  			->order_by('id',"desc")
		  			->get('sh_m_item')
		  			->row();
    		// var_dump($item_code[$i]);
    		$datacart = array();

			 if ($cekdata[$i]->need_stock == 1) {
					 	$total[$i] = $cekdata[$i]->stock - $qty[$i];
						echo $cekdata[$i]->stock - $qty[$i];
						if ($total[$i] == 0) {
							$datacart[] = [
		    					'no' => $item_code[$i],
		    					'stock' => $total[$i],
		    					'is_sold_out' => 1,
		    					'stock_update_date' => date('Y-m-d H:i:s'),
		    					'stock_update_by' => $this->session->userdata('username'),
		    				];
						}else{
							$datacart[] = [
		    					'no' => $item_code[$i],
		    					'stock' => $total[$i],
		    					'stock_update_date' => date('Y-m-d H:i:s'),
		    					'stock_update_by' => $this->session->userdata('username'),
		    				];
						}
						$this->db->update_batch('sh_m_item',$datacart,'no');
					 }

			 $stok[$i] = $this->db->where('no',$item_code[$i])
		  			->order_by('id',"desc")
		  			->get('sh_m_item')
		  			->row('stock');
		  		 	if ($need_stock[$i] != 0) {
						$n = $nomer++ . "<br>"; 
						$datastok[] = [
						'log_type' => 'Update Stock',
						'cabang' => $cabang,
						'item_code' => $item_code[$i],
						'stock_before' =>$stok[$i]+$qty[$i],
						'stock_after' =>$stok[$i]+$qty[$i]-$qty[$i], 
						'difference' =>$qty[$i],
						'stock_entry' => date('Y-m-d H:i:s'),
						'username' => $this->session->userdata('username'),
						'description' => 'Stock Used '.$qty[$i],
					];
					 }else{
					 	$n = $nomer++ . "<br>"; 
						$datastok[] = [
						'log_type' => 'Update Stock',
						'cabang' => $cabang,
						'item_code' => $item_code[$i],
						'stock_before' =>$stok[$i],
						'stock_after' =>$stok[$i], 
						'difference' =>$stok[$i],
						'stock_entry' => date('Y-m-d H:i:s'),
						'username' => $this->session->userdata('username'),
						'description' => 'Stock Used '.$qty[$i],
					];
					 }
		if ($qty[$i] == 0) {
			$status = 'gagal';
		}else{
			$status= 'berhasil';
		}
    
	}

	// var_dump($cekdata);exit();
		if ($status == "berhasil") {
			
			$rslt = $this->db->insert_batch('sh_stok_logs',$datastok);
			$result = $this->db->insert_batch('sh_t_transaction_details',$data);
			if ($result) {
				$ic = $this->session->userdata('id');
				 $data = ['status' => 'Payment'];
				$this->db->where('id_customer',$ic);
    			$this->db->update('sh_rel_table',$data);
    			$ic = $this->session->userdata('id');
				$where = "left(entry_date,10) ='".$date."' and id_customer = '".$ic."' and id_trans  = '".$id_trans->id."' and user_order_id = '".$this->session->userdata('user_order_id')."'";
				$this->db->where($where);
				$this->db->where_in('item_code',$item_code);
	    		$this->db->delete('sh_cart');
	    		$it = $this->session->userdata('id_table');$uoi = $this->session->userdata('user_order_id');
			$date = date('Y-m-d');
			$wheredetails ="id_customer ='".$ic."' and id_table ='".$it."' and user_order_id ='".$uoi."' and left(entry_date,10) ='".$date."'";
			$this->db->where($wheredetails);
			$this->db->delete('sh_cart_details');
	    		$cabang = $this->db->order_by('id',"desc")
	  			->limit(1)
	  			->get('sh_m_cabang')
	  			->row('id');
	  			
	    		$nomer = 1;
				
				
    			
					echo "<br>";

    		
    			$this->db->query("update sh_t_transactions set date_order_menu='".date('Y-m-d H:i:s')."',is_order_menu_active=1,start_time_order='".date('H:i:s')."',checker_printed = 1 where id = '".$id_trans->id."' and id_customer = '".$ic."'");
    			$this->session->set_flashdata('success','Payment Successful.Please Export the PDF to Continue the Ordering Process.');
				// redirect('index.php/selforder/home/'.$table);
				redirect('index.php/selforder/viewpdf/');
				// $where = array('qty' => 0);
				// $this->Item_model->hapus_qty($where,'testing');
			}else{
				echo "gagal order";
			}
		}else{
			$this->session->set_flashdata('error','stock is not fulfilled');
			if ($cek == 'Makanan') {
			$log = 'index.php/Cart/home/'.$table.'/Makanan/'.$sub.'#'.preg_replace('/%20/', '_', $sub);;
			}elseif ($cek == 'Minuman') {
				$log = 'index.php/Cart/home/'.$table.'/Minuman/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
			}else{
				$log = 'index.php/Cart/home/'.$table;
			}
			redirect(base_url().$log);
		}
 
        
    }
    public function cekas($value='')
    {
    	echo "BERHASIL";exit();
    }
	public function op($table,$cek=NULL,$sub=NULL)
	{
		$table = $this->session->userdata('nomeja');
		$qty = $this->input->post('qty');
		$ata = $this->input->post('cek');
		$qta = $this->input->post('qta');
		$nama = $this->input->post('nama');
		$pesan = $this->input->post('pesan');
		$pesandua = $this->input->post('pesandua');
		$pesantiga = $this->input->post('pesantiga');
		$harga = $this->input->post('harga');
		$item_code = $this->input->post('no');
		$need_stock = $this->input->post('need_stock');
		$is_paket = $this->input->post('is_paket');
		$id_customer = $this->session->userdata('id');
		$id_trans = $this->db->get_Where('sh_t_transactions', array('id_customer'=> $id_customer))->row();
		$id_table = $this->db->get_Where('sh_rel_table', array('id_customer'=> $id_customer))->row();
		$st = $id_table->status;
			$date = date('Y-m-d');
			$ctime = date('H:i:s');
			$this->db->from('sh_set_time_cekdata');
			$this->db->order_by('id', 'DESC'); // urutkan berdasarkan id secara descending
			$this->db->limit(1); // ambil hanya satu baris terakhir
			$query = $this->db->get();
			$no = $query->row('seconds');
			$seconds = " +".$no." seconds";
			
			$this->db->from('sh_t_transaction_details');
			$where = "left(created_date,10) ='".$date."' and selected_table_no = '".$table."' and selforder = 1 and user_order_id = '".$this->session->userdata('user_order_id')."'";
			$this->db->where($where);
			$this->db->where_in('item_code',$item_code);
			$this->db->where_in('qty',$qty);
			$this->db->order_by('id','DESC'); 
			$this->db->limit(1); // ambil hanya satu baris terakhir
			$query = $this->db->get();
			$q = $query->row();
			

			if ($q) {
				$time = date('H:i:s', strtotime($ctime . $seconds));
			}else{
				$time = date('H:i:s', strtotime($ctime . $seconds));
			}

							  		

		if ($st == "Dining" || $st == "Order") {
			$order_stat = 1;
		}elseif ($st == "Billing" || $st == "Payment") {
			$order_stat = 2;
		}
		$today = date('Y-m-d');
		$curTime = explode(':', date('H:i:s'));
		$cekWeekEnd = date('D', strtotime($today));
		$check_promo = $this->Item_model->get_promo($today)->num_rows();
		$get_promo = $this->Item_model->get_promo($today)->row_array();
		$discount = 0;
		if($check_promo > 0){
			$item_check = $this->Item_model->get_info_item($this->input->post('item_code'),$get_promo)->num_rows();
			if($item_check > 0){
				$item_data = $this->Item_model->get_info_item($this->input->post('item_code'),$get_promo)->row_array();
				if($get_promo["promo_type"] == 'Discount'){
					if($get_promo["promo_criteria"] == 'Weekday'){ //Weekday
						if($cekWeekEnd !== "Sat" || $cekWeekEnd !== "Sun" || $cekWeekEnd !== "Sab" || $cekWeekEnd !== "Min"){
							if($curTime[0] >= $get_promo["promo_from"] && $curTime[0] <= $get_promo["promo_to"]){
								$discount = $get_promo["promo_value"];		
							}else{
								$discount = 0;
							}
						}else{
							$discount = 0;
						}	
					}else if($get_promo["promo_criteria"] == 'Weekend'){ //Weekend
						if($cekWeekEnd === "Sat" || $cekWeekEnd === "Sun" || $cekWeekEnd === "Sab" || $cekWeekEnd === "Min"){
							if($curTime[0] >= $get_promo["promo_from"] && $curTime[0] <= $get_promo["promo_to"]){
								$discount = $get_promo["promo_value"];		
							}else{
								$discount = 0;
							}
						}else{
							$discount = 0;
						}	
					}else{ //Full Week
						if($curTime[0] >= $get_promo["promo_from"] && $curTime[0] <= $get_promo["promo_to"]){
							$discount = $get_promo["promo_value"];		
						}else{
							$discount = 0;
						}
					}
				}else{
					$discount = 0;	
				}
			}else{
				$discount = 0;
			}
		}
		$cabang = $this->db->order_by('id',"desc")
  			->limit(1)
  			->get('sh_m_cabang')
  			->row('id');
  		$t = $this->Item_model->cekdatatrans($id_customer)->row();

  		if ($t) {
  		 $td = $this->Item_model->cekdatatransdetail($t->id)->row();
  		  $cdt = $td->cekdata + 1;
  		}else{
  		  $cdt = 1;
  		}
		$nomer = 1;
		for ($i = 0; $i < count($qty); $i++) {
			if ($qty[$i] != 0) {
				$n = $nomer++ . "<br>"; 
				$data[] = [
				'id_trans' => $id_trans->id,
				'item_code' => $item_code[$i],
				'qty' => $qty[$i],
				'cabang' => $cabang,
				'unit_price' => $harga[$i],
				'description' => $nama[$i],
				'start_time_order' => date('H:i:s'),
				'entry_by' => $this->session->userdata('username'),
				'disc' => $discount,
				'is_cancel' => 0,
				'session_item' => 0,
				'selected_table_no' => $table,
				'seat_id' => 0,
				'sort_id' => $n,
				'as_take_away' => 0,
				'qty_take_away' => 0,
				'extra_notes' => $pesan[$i],
				'checker_printed' => 1,
				'created_date' => date('Y-m-d H:i:s'),
				'order_type' => $order_stat,
				'selforder' => 1,
				'is_printed_so' => 0,
				'cekdata' => $cdt,
				'user_order_id' => $this->session->userdata('user_order_id'),
				'timeout_order_so' => $time,
			   ];
			 }
		}
		$array_with_quotes = array_map(function($val) { return "'" . $val . "'"; }, $qty);
		$q = implode('', $qty);
		$itemc = implode(',', $item_code);
		$cekdata = $this->Item_model->getDataC($item_code);

        $cd = array(); // Inisialisasi array $cd di sini

        for ($j = 0; $j < count($nama); $j++) {
            $details[$j] = $this->Item_model->getcartpaket($id_customer, urldecode($nama[$j]))->result();
            for ($a = 0; $a < count($details[$j]); $a++) {
            	// $qt[$j][$a] = $this->Item_model->getDataQD($details[$j][$a]->item_code,$details[$j][$a]->id_customer,$details[$j][$a][$b]->id_table,$details[$j][$a]->user_order_id);
                $cd[$j][$a] = $this->Item_model->getDataCD(array($details[$j][$a]->item_code));
                // var_dump($details[$j][$a]->item_code);var_dump($details[$j][$a]->id_customer);var_dump($details[$j][$a]->id_table);var_dump($details[$j][$a]->user_order_id);
                
                // Lakukan operasi dengan data yang ada di $cd[$j][$a]
                for ($b = 0; $b < count($cd[$j][$a]); $b++) {
                	
                    if ($cd[$j][$a][$b]->need_stock == 1) {
                    	$total[$j][$a][$b] = $cd[$j][$a][$b]->stock - intval($details[$j][$a]->qty);
						echo $cd[$j][$a][$b]->stock - intval($details[$j][$a]->qty);
						echo "<br>";
						if ($total[$j][$a][$b] == 0) {
							$datacart[] = [
		    					'no' => $details[$j][$a]->item_code,
		    					'stock' => $total[$j][$a][$b],
		    					'is_sold_out' => 1,
		    					'stock_update_date' => date('Y-m-d H:i:s'),
		    					'stock_update_by' => $this->session->userdata('username'),
		    				];
						}else{
							$datacart[] = [
		    					'no' => $details[$j][$a]->item_code,
		    					'stock' => $total[$j][$a][$b],
		    					'stock_update_date' => date('Y-m-d H:i:s'),
		    					'stock_update_by' => $this->session->userdata('username'),
		    				];
						}
						$this->db->update_batch('sh_m_item',$datacart,'no');
						$n = $nomer++ . "<br>"; 
						$datastok[] = [
						'log_type' => 'Update Stock',
						'cabang' => $cabang,
						'item_code' => $details[$j][$a]->item_code,
						'stock_before' =>$cd[$j][$a][$b]->stock,
						'stock_after' =>$total[$j][$a][$b], 
						'difference' =>intval($details[$j][$a]->qty),
						'stock_entry' => date('Y-m-d H:i:s'),
						'username' => $this->session->userdata('username'),
						'description' => 'Stock Used '.intval($details[$j][$a]->qty),
						];

						// $getitem[$j][$a] = $this->Item_model->getitem($details[$j][$a]->item_code)->row();
						$qr = $this->db->query("SELECT id FROM sh_t_transaction_details ORDER BY id DESC LIMIT 1");
						$id_detail = $qr->row();
						$qry[$j][$a] = $this->db->query("SELECT min_qty,max_qty FROM sh_m_item_packages WHERE package_name = 'Sweet Symphony 2' and sub_category = '".$details[$j][$a]->sub_category."'")->row();
						$datalist[] = [
						'id_trans' => $id_trans->id,
						'id_detail' => $id_detail->id + 1,
						'sub_category' => $details[$j][$a]->sub_category,
						'min_qty' => $qry[$j][$a]->min_qty,
						'max_qty' => $qry[$j][$a]->max_qty,
						'item_code' => $details[$j][$a]->item_code,
						'qty' => intval($details[$j][$a]->qty),
						'unit_price' => 0,
						'description' => $details[$j][$a]->description,
						'start_time_order' => date('H:i:s'),
						'entry_by' => $this->session->userdata('username'),
						'disc' => $discount,
						'is_cancel' => 0,
						'session_item' => 0,
						'cabang' => $cabang,
						'selected_table_no' => $table,
						'seat_id' => 0,
						'sort_id' => $n,
						'as_take_away' => 0,
						'extra_notes' => $pesan[$i],
						'checker_printed' => 1,
						'created_date' => date('Y-m-d H:i:s'),
					   ];
						if (intval($details[$j][$a]->qty) == 0) {
							$status = 'gagal';
						}else{
							$status= 'berhasil';
						}

						
                    }else{
                    	$qr = $this->db->query("SELECT id FROM sh_t_transaction_details ORDER BY id DESC LIMIT 1");
						$id_detail = $qr->row();
						$qry[$j][$a] = $this->db->query("SELECT min_qty,max_qty FROM sh_m_item_packages WHERE package_name = 'Sweet Symphony 2' and sub_category = '".$details[$j][$a]->sub_category."'")->row();
						$datalist[] = [
						'id_trans' => $id_trans->id,
						'id_detail' => $id_detail->id + 1,
						'sub_category' => $details[$j][$a]->sub_category,
						'min_qty' => 0,
						'max_qty' => 0,
						'item_code' => $details[$j][$a]->item_code,
						'qty' => intval($details[$j][$a]->qty),
						'unit_price' => 0,
						'description' => $details[$j][$a]->description,
						'start_time_order' => date('H:i:s'),
						'entry_by' => $this->session->userdata('username'),
						'disc' => $discount,
						'is_cancel' => 0,
						'session_item' => 0,
						'cabang' => $cabang,
						'selected_table_no' => $table,
						'seat_id' => 0,
						'sort_id' => $n,
						'as_take_away' => 0,
						'extra_notes' => $pesan[$i],
						'checker_printed' => 1,
						'created_date' => date('Y-m-d H:i:s'),
					   ];
                    	$result = $this->db->insert_batch('sh_t_transaction_details',$data);
                    	if ($result) {
							$rs = $this->db->insert_batch('sh_t_transaction_details_list',$datalist);
							$ic = $this->session->userdata('id');
							 $data = ['status' => 'Dining'];
							$this->db->where('id_customer',$ic);
			    			$this->db->update('sh_rel_table',$data);
			    			$ic = $this->session->userdata('id');
							$where = "left(entry_date,10) ='".$date."' and id_customer = '".$ic."' and id_trans  = '".$id_trans->id."' and user_order_id = '".$this->session->userdata('user_order_id')."'";
							$this->db->where($where);
							$this->db->where_in('item_code',$item_code);
				    		$this->db->delete('sh_cart');
				    		$it = $this->session->userdata('id_table');$uoi = $this->session->userdata('user_order_id');
						$date = date('Y-m-d');
						$wheredetails ="left(entry_date,10) ='".$date."' and id_customer = '".$ic."' and id_trans  = '".$id_trans->id."' and user_order_id = '".$this->session->userdata('user_order_id')."'";
						$this->db->where($wheredetails);
						$this->db->delete('sh_cart_details');
				    		$cabang = $this->db->order_by('id',"desc")
				  			->limit(1)
				  			->get('sh_m_cabang')
				  			->row('id');
				  			
				    		$nomer = 1;
							
							
			    			
								echo "<br>";

			    		
			    			$this->db->query("update sh_t_transactions set date_order_menu='".date('Y-m-d H:i:s')."',is_order_menu_active=1,start_time_order='".date('H:i:s')."',checker_printed = 1 where id = '".$id_trans->id."' and id_customer = '".$ic."'");
			    			$this->session->set_flashdata('successcart','Menu Sent to Kitchen');
							redirect('index.php/selforder/home/'.$table);
							// $where = array('qty' => 0);
							// $this->Item_model->hapus_qty($where,'testing');
						}else{
							echo "gagal order";
						}

                    }
                }
            }
            if ($status == "berhasil") {
			
						$rslt = $this->db->insert_batch('sh_stok_logs',$datastok);
						$result = $this->db->insert_batch('sh_t_transaction_details',$data);
						if ($result) {
							$rs = $this->db->insert_batch('sh_t_transaction_details_list',$datalist);
							$ic = $this->session->userdata('id');
							 $data = ['status' => 'Dining'];
							$this->db->where('id_customer',$ic);
			    			$this->db->update('sh_rel_table',$data);
			    			$ic = $this->session->userdata('id');
							$where = "left(entry_date,10) ='".$date."' and id_customer = '".$ic."' and id_trans  = '".$id_trans->id."' and user_order_id = '".$this->session->userdata('user_order_id')."'";
							$this->db->where($where);
							$this->db->where_in('item_code',$item_code);
				    		$this->db->delete('sh_cart');
				    		$it = $this->session->userdata('id_table');$uoi = $this->session->userdata('user_order_id');
						$date = date('Y-m-d');
						$wheredetails ="left(entry_date,10) ='".$date."' and id_customer = '".$ic."' and id_trans  = '".$id_trans->id."' and user_order_id = '".$this->session->userdata('user_order_id')."'";
						$this->db->where($wheredetails);
						$this->db->delete('sh_cart_details');
				    		$cabang = $this->db->order_by('id',"desc")
				  			->limit(1)
				  			->get('sh_m_cabang')
				  			->row('id');
				  			
				    		$nomer = 1;
							
							
			    			
								echo "<br>";

			    		
			    			$this->db->query("update sh_t_transactions set date_order_menu='".date('Y-m-d H:i:s')."',is_order_menu_active=1,start_time_order='".date('H:i:s')."',checker_printed = 1 where id = '".$id_trans->id."' and id_customer = '".$ic."'");
			    			$this->session->set_flashdata('successcart','Menu Sent to Kitchen');
							redirect('index.php/selforder/home/'.$table);
							// $where = array('qty' => 0);
							// $this->Item_model->hapus_qty($where,'testing');
						}else{
							echo "gagal order";
						}
					}else{
						$this->session->set_flashdata('error','stock is not fulfilled');
						if ($cek == 'Makanan') {
						$log = 'index.php/Cart/home/'.$table.'/Makanan/'.$sub.'#'.preg_replace('/%20/', '_', $sub);;
						}elseif ($cek == 'Minuman') {
							$log = 'index.php/Cart/home/'.$table.'/Minuman/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
						}else{
							$log = 'index.php/Cart/home/'.$table;
						}
						redirect(base_url().$log);
					}
            
        }

        // var_dump($cd); // Outputkan semua data CD setelah loop selesai
        // exit(); // Keluar dari skrip (opsional)
	}
	public function order_post($table,$cek=NULL,$sub=NULL)
	{
		$amount = $this->input->post('totalbayar');
		echo $amount;exit();
		$table = $this->session->userdata('nomeja');
		$qty = $this->input->post('qty');
		$ata = $this->input->post('cek');
		$qta = $this->input->post('qta');
		$nama = $this->input->post('nama');
		$pesan = $this->input->post('pesan');
		$pesandua = $this->input->post('pesandua');
		$pesantiga = $this->input->post('pesantiga');
		$harga = $this->input->post('harga');
		$item_code = $this->input->post('no');
		$need_stock = $this->input->post('need_stock');
		$is_paket = $this->input->post('is_paket');
		$id_customer = $this->session->userdata('id');
		$id_trans = $this->db->get_Where('sh_t_transactions', array('id_customer'=> $id_customer))->row();
		$id_table = $this->db->get_Where('sh_rel_table', array('id_customer'=> $id_customer))->row();
		$st = $id_table->status;

			$date = date('Y-m-d');
			$ctime = date('H:i:s');
			$this->db->from('sh_set_time_cekdata');
			$this->db->order_by('id', 'DESC'); // urutkan berdasarkan id secara descending
			$this->db->limit(1); // ambil hanya satu baris terakhir
			$query = $this->db->get();
			$no = $query->row('seconds');
			$seconds = " +".$no." seconds";
			
			$this->db->from('sh_t_transaction_details');
			$where = "left(created_date,10) ='".$date."' and selected_table_no = '".$table."' and selforder = 1 and user_order_id = '".$this->session->userdata('user_order_id')."'";
			$this->db->where($where);
			$this->db->where_in('item_code',$item_code);
			$this->db->where_in('qty',$qty);
			$this->db->order_by('id','DESC'); 
			$this->db->limit(1); // ambil hanya satu baris terakhir
			$query = $this->db->get();
			$q = $query->row();
			

			if ($q) {
				$time = date('H:i:s', strtotime($ctime . $seconds));
			}else{
				$time = date('H:i:s', strtotime($ctime . $seconds));
			}

							  		

		if ($st == "Dining" || $st == "Order") {
			$order_stat = 1;
		}elseif ($st == "Billing" || $st == "Payment" ) {
			$order_stat = 2;
		}
		$today = date('Y-m-d');
		$curTime = explode(':', date('H:i:s'));
		$cekWeekEnd = date('D', strtotime($today));
		$check_promo = $this->Item_model->get_promo($today)->num_rows();
		$get_promo = $this->Item_model->get_promo($today)->row_array();
		$discount = 0;
		if($check_promo > 0){
			$item_check = $this->Item_model->get_info_item($this->input->post('item_code'),$get_promo)->num_rows();
			if($item_check > 0){
				$item_data = $this->Item_model->get_info_item($this->input->post('item_code'),$get_promo)->row_array();
				if($get_promo["promo_type"] == 'Discount'){
					if($get_promo["promo_criteria"] == 'Weekday'){ //Weekday
						if($cekWeekEnd !== "Sat" || $cekWeekEnd !== "Sun" || $cekWeekEnd !== "Sab" || $cekWeekEnd !== "Min"){
							if($curTime[0] >= $get_promo["promo_from"] && $curTime[0] <= $get_promo["promo_to"]){
								$discount = $get_promo["promo_value"];		
							}else{
								$discount = 0;
							}
						}else{
							$discount = 0;
						}	
					}else if($get_promo["promo_criteria"] == 'Weekend'){ //Weekend
						if($cekWeekEnd === "Sat" || $cekWeekEnd === "Sun" || $cekWeekEnd === "Sab" || $cekWeekEnd === "Min"){
							if($curTime[0] >= $get_promo["promo_from"] && $curTime[0] <= $get_promo["promo_to"]){
								$discount = $get_promo["promo_value"];		
							}else{
								$discount = 0;
							}
						}else{
							$discount = 0;
						}	
					}else{ //Full Week
						if($curTime[0] >= $get_promo["promo_from"] && $curTime[0] <= $get_promo["promo_to"]){
							$discount = $get_promo["promo_value"];		
						}else{
							$discount = 0;
						}
					}
				}else{
					$discount = 0;	
				}
			}else{
				$discount = 0;
			}
		}
		$cabang = $this->db->order_by('id',"desc")
  			->limit(1)
  			->get('sh_m_cabang')
  			->row('id');
  		$t = $this->Item_model->cekdatatrans($id_customer)->row();
  		
  		if ($t) {
  		 $td = $this->Item_model->cekdatatransdetail($t->id)->row();
  		 // var_dump($td->cekdata);exit();
  		  $cd = $td->cekdata + 1;
  		}else{
  		  $cd = 1;
  		}
		$nomer = 1;
		for ($i = 0; $i < count($qty); $i++) {
			if ($qty[$i] != 0) {
				$n = $nomer++ . "<br>"; 
				$data[] = [
				'id_trans' => $id_trans->id,
				'item_code' => $item_code[$i],
				'qty' => $qty[$i],
				'cabang' => $cabang,
				'unit_price' => $harga[$i],
				'description' => $nama[$i],
				'start_time_order' => date('H:i:s'),
				'entry_by' => $this->session->userdata('username'),
				'disc' => $discount,
				'is_cancel' => 0,
				'session_item' => 0,
				'selected_table_no' => $table,
				'seat_id' => 0,
				'sort_id' => $n,
				'as_take_away' => 0,
				'qty_take_away' => 0,
				'extra_notes' => $pesan[$i],
				'checker_printed' => 1,
				'created_date' => date('Y-m-d H:i:s'),
				'order_type' => $order_stat,
				'selforder' => 1,
				'is_printed_so' => 0,
				'cekdata' => $cd,
				'user_order_id' => $this->session->userdata('user_order_id'),
				'timeout_order_so' => $time,
			];
			 }
			 // $cekdata = $this->Item_model->getDataC($item_code);

			 $cekdata[$i] = $this->db->where_in('no',$item_code[$i])
		  			->order_by('id',"desc")
		  			->get('sh_m_item')
		  			->row();
    		// var_dump($item_code[$i]);
    		$datacart = array();

			 if ($cekdata[$i]->need_stock == 1) {
					 	$total[$i] = $cekdata[$i]->stock - $qty[$i];
						echo $cekdata[$i]->stock - $qty[$i];
						if ($total[$i] == 0) {
							$datacart[] = [
		    					'no' => $item_code[$i],
		    					'stock' => $total[$i],
		    					'is_sold_out' => 1,
		    					'stock_update_date' => date('Y-m-d H:i:s'),
		    					'stock_update_by' => $this->session->userdata('username'),
		    				];
						}else{
							$datacart[] = [
		    					'no' => $item_code[$i],
		    					'stock' => $total[$i],
		    					'stock_update_date' => date('Y-m-d H:i:s'),
		    					'stock_update_by' => $this->session->userdata('username'),
		    				];
						}
						$this->db->update_batch('sh_m_item',$datacart,'no');
					 }

			 $stok[$i] = $this->db->where('no',$item_code[$i])
		  			->order_by('id',"desc")
		  			->get('sh_m_item')
		  			->row('stock');
		  		 	if ($need_stock[$i] != 0) {
						$n = $nomer++ . "<br>"; 
						$datastok[] = [
						'log_type' => 'Update Stock',
						'cabang' => $cabang,
						'item_code' => $item_code[$i],
						'stock_before' =>$stok[$i]+$qty[$i],
						'stock_after' =>$stok[$i]+$qty[$i]-$qty[$i], 
						'difference' =>$qty[$i],
						'stock_entry' => date('Y-m-d H:i:s'),
						'username' => $this->session->userdata('username'),
						'description' => 'Stock Used '.$qty[$i],
					];
					 }else{
					 	$n = $nomer++ . "<br>"; 
						$datastok[] = [
						'log_type' => 'Update Stock',
						'cabang' => $cabang,
						'item_code' => $item_code[$i],
						'stock_before' =>$stok[$i],
						'stock_after' =>$stok[$i], 
						'difference' =>$stok[$i],
						'stock_entry' => date('Y-m-d H:i:s'),
						'username' => $this->session->userdata('username'),
						'description' => 'Stock Used '.$qty[$i],
					];
					 }
		if ($qty[$i] == 0) {
			$status = 'gagal';
		}else{
			$status= 'berhasil';
		}
    
	}

	// var_dump($cekdata);exit();
		if ($status == "berhasil") {
			
			$rslt = $this->db->insert_batch('sh_stok_logs',$datastok);
			$result = $this->db->insert_batch('sh_t_transaction_details',$data);
			if ($result) {
				$ic = $this->session->userdata('id');
				 $data = ['status' => 'Dining'];
				$this->db->where('id_customer',$ic);
    			$this->db->update('sh_rel_table',$data);
    			$ic = $this->session->userdata('id');
				$where = "left(entry_date,10) ='".$date."' and id_customer = '".$ic."' and id_trans  = '".$id_trans->id."' and user_order_id = '".$this->session->userdata('user_order_id')."'";
				$this->db->where($where);
				$this->db->where_in('item_code',$item_code);
	    		$this->db->delete('sh_cart');
	    		$it = $this->session->userdata('id_table');$uoi = $this->session->userdata('user_order_id');
			$date = date('Y-m-d');
			$wheredetails ="id_customer ='".$ic."' and id_table ='".$it."' and user_order_id ='".$uoi."' and left(entry_date,10) ='".$date."'";
			$this->db->where($wheredetails);
			$this->db->delete('sh_cart_details');
	    		$cabang = $this->db->order_by('id',"desc")
	  			->limit(1)
	  			->get('sh_m_cabang')
	  			->row('id');
	  			
	    		$nomer = 1;
				
				
    			
					echo "<br>";

    		
    			$this->db->query("update sh_t_transactions set date_order_menu='".date('Y-m-d H:i:s')."',is_order_menu_active=1,start_time_order='".date('H:i:s')."',checker_printed = 1 where id = '".$id_trans->id."' and id_customer = '".$ic."'");
    			$this->session->set_flashdata('successcart','Menu Sent to Kitchen');
				redirect('index.php/selforder/home/'.$table);
				// $where = array('qty' => 0);
				// $this->Item_model->hapus_qty($where,'testing');
			}else{
				echo "gagal order";
			}
		}else{
			$this->session->set_flashdata('error','stock is not fulfilled');
			if ($cek == 'Makanan') {
			$log = 'index.php/Cart/home/'.$table.'/Makanan/'.$sub.'#'.preg_replace('/%20/', '_', $sub);;
			}elseif ($cek == 'Minuman') {
				$log = 'index.php/Cart/home/'.$table.'/Minuman/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
			}else{
				$log = 'index.php/Cart/home/'.$table;
			}
			redirect(base_url().$log);
		}

	}
	public function delete($id,$nomeja,$cekpaket=null,$cek,$sub,$no)
	{
		if ($cekpaket == 'paket') {
			$ic = $this->session->userdata('id');$it = $this->session->userdata('id_table');$uoi = $this->session->userdata('user_order_id');
			$date = date('Y-m-d');
			$where ="id_customer ='".$ic."' and id_table ='".$nomeja."' and user_order_id ='".$uoi."' and left(entry_date,10) ='".$date."'";
			$this->db->where($where);
			$this->db->delete('sh_cart_details');
			$this->db->where('id',$id);
			$this->db->delete('sh_cart');
		}else{
			$this->db->where('id',$id);
			$this->db->delete('sh_cart');
		}
    	$this->session->set_flashdata('success','Menu Has Been Removed');

    	if ($cek == 'Makanan') {
			$log = 'index.php/Cart/home/'.$nomeja.'/Makanan/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
		}elseif ($cek == 'Minuman') {
			$log = 'index.php/Cart/home/'.$nomeja.'/Minuman/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
		}elseif ($cek == 'CAKE%20DAN%20BAKERY') {
			$log = 'index.php/Cart/home/'.$nomeja.'/CAKE%20DAN%20BAKERY/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
			// $log = 'index.php/Cart/home/CAKE%20DAN%20BAKERY/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
		}else{
			$log = 'index.php/Cart/home/'.$nomeja;
		}
		redirect(base_url().$log);
	}
	
	public function ubah($id,$nomeja,$cek,$sub)
	{
		// echo $id;exit();
		$qty = $this->input->post('qty');
		$extra_notes = $this->input->post('extra_notes');
		$data = [
			'qty' => $qty,
			'extra_notes' => $extra_notes,
		];
		$this->db->where('id',$id);
		if ($qty != 0) {
			$this->db->update('sh_cart',$data);
			$this->session->set_flashdata('success','Menu Has Been Updated');
		}else{
			$this->db->delete('sh_cart');
			$this->session->set_flashdata('error','Menu Has Been Removed');
		}
    	
    	if ($cek == 'Makanan') {
			$log = 'index.php/Cart/home/'.$nomeja.'/Makanan/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
		}elseif ($cek == 'Minuman') {
			$log = 'index.php/Cart/home/'.$nomeja.'/Minuman/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
		}elseif ($cek == 'CAKE%20DAN%20BAKERY') {
			$log = 'index.php/Cart/home/'.$nomeja.'/CAKE%20DAN%20BAKERY/'.$sub.'#'.preg_replace('/%20/', '_', $sub);
		}else{
			$log = 'index.php/Cart/home/'.$nomeja;
		}
		redirect(base_url().$log);
		
	}
	
	public function get_sold() {
        $data = $this->Item_model->get_sold();

        // Return data as JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function cekbayar() {
    	$id_customer = $this->session->userdata('id');
		$id_trans = $this->db->get_Where('sh_t_transactions', array('id_customer'=> $id_customer))->row('id');
		$data = $this->Item_model->cekbayar($id_trans);
		if (!$data) {
			// Return data as JSON
	        header('Content-Type: application/json');
	        echo json_encode($data);
		}
        
    }
    public function suksesbayar()
    {
    	$nomeja = $this->session->userdata('nomeja');
    	$today = date('Y-m-d');
		$curTime = explode(':', date('H:i:s'));
		$cekWeekEnd = date('D', strtotime($today));
		$check_promo = $this->Item_model->get_promo($today)->num_rows();
		$get_promo = $this->Item_model->get_promo($today)->row_array();
		$discount = 0;
		if($check_promo > 0){
			$item_check = $this->Item_model->get_info_item($this->input->post('item_code'),$get_promo)->num_rows();
			if($item_check > 0){
				$item_data = $this->Item_model->get_info_item($this->input->post('item_code'),$get_promo)->row_array();
				if($get_promo["promo_type"] == 'Discount'){
					if($get_promo["promo_criteria"] == 'Weekday'){ //Weekday
						if($cekWeekEnd !== "Sat" || $cekWeekEnd !== "Sun" || $cekWeekEnd !== "Sab" || $cekWeekEnd !== "Min"){
							if($curTime[0] >= $get_promo["promo_from"] && $curTime[0] <= $get_promo["promo_to"]){
								$discount = $get_promo["promo_value"];		
							}else{
								$discount = 0;
							}
						}else{
							$discount = 0;
						}	
					}else if($get_promo["promo_criteria"] == 'Weekend'){ //Weekend
						if($cekWeekEnd === "Sat" || $cekWeekEnd === "Sun" || $cekWeekEnd === "Sab" || $cekWeekEnd === "Min"){
							if($curTime[0] >= $get_promo["promo_from"] && $curTime[0] <= $get_promo["promo_to"]){
								$discount = $get_promo["promo_value"];		
							}else{
								$discount = 0;
							}
						}else{
							$discount = 0;
						}	
					}else{ //Full Week
						if($curTime[0] >= $get_promo["promo_from"] && $curTime[0] <= $get_promo["promo_to"]){
							$discount = $get_promo["promo_value"];		
						}else{
							$discount = 0;
						}
					}
				}else{
					$discount = 0;	
				}
			}else{
				$discount = 0;
			}
		}
    	// Ambil data dari tabel A
    	$id_customer = $this->session->userdata('id');
		$id_trans = $this->db->get_Where('sh_t_transactions', array('id_customer'=> $id_customer))->row('id');
		$query = $this->db->get_Where('sh_cart', array('id_trans'=> $id_trans,'bayar_kasir' => 1))->result();
		$id_table = $this->db->get_Where('sh_rel_table', array('id_customer'=> $id_customer))->row();
		$st = $id_table->status;
		if ($st == "Dining" || $st == "Order") {
			$order_stat = 1;
		}elseif ($st == "Billing" || $st == "Payment") {
			$order_stat = 2;
		}
		$t = $this->Item_model->cekdatatrans($id_customer)->row();
  		
  		if ($t) {
  		 $td = $this->Item_model->cekdatatransdetail($t->id)->row();
  		  $cd = $td->cekdata + 1;
  		}else{
  		  $cd = 1;
  		}
  		$date = date('Y-m-d');
  		$table = $this->session->userdata('nomeja');
  		$this->db->from('sh_t_transaction_details');
			$where = "left(created_date,10) ='".$date."' and selected_table_no = '".$table."' and selforder = 1 and user_order_id = '".$this->session->userdata('user_order_id')."'";
			$this->db->where($where);
			$this->db->order_by('id','DESC'); 
			$this->db->limit(1); // ambil hanya satu baris terakhir
			$queryq = $this->db->get();
			$q = $queryq->row();
  			$ctime = date('H:i:s');
			$this->db->from('sh_set_time_cekdata');
			$this->db->order_by('id', 'DESC'); // urutkan berdasarkan id secara descending
			$this->db->limit(1); // ambil hanya satu baris terakhir
			$queryc = $this->db->get();
			$no = $queryc->row('seconds');
			$seconds = " +".$no." seconds";
			if ($q) {
				$time = date('H:i:s', strtotime($ctime . $seconds));
			}else{
				$time = date('H:i:s', strtotime($ctime . $seconds));
			}
		$nomer = 1;
		foreach ($query as $row) {
			$n = $nomer++;
		    $data[] = [
				'id_trans' => $row->id_trans,
				'item_code' => $row->item_code,
				'qty' => $row->qty,
				'cabang' => $row->cabang,
				'unit_price' => $row->unit_price,
				'description' => $row->description,
				'start_time_order' => date('H:i:s'),
				'entry_by' => $this->session->userdata('username'),
				'disc' => $discount,
				'is_cancel' => 0,
				'session_item' => 0,
				'selected_table_no' => $row->id_table,
				'seat_id' => 0,
				'sort_id' => $n,
				'as_take_away' => 0,
				'qty_take_away' => 0,
				'extra_notes' => $row->extra_notes.','.$row->notesdua,
				'checker_printed' => 1,
				'created_date' => date('Y-m-d H:i:s'),
				'order_type' => $order_stat,
				'selforder' => 1,
				'is_printed_so' => 0,
				'cekdata' => $cd,
				'user_order_id' => $this->session->userdata('user_order_id'),
				'timeout_order_so' => $time,
			];
		    
		}
		$result = $this->db->insert_batch('sh_t_transaction_details',$data);
		if ($result) {
			$this->db->where('id_trans',$id_trans);
			$this->db->delete('sh_cart');
		}
		// $this->session->set_flashdata('successcart','Payment Successful, Order Sent to Kitchen');
		// redirect(base_url().'index.php/selforder/home/'.$nomeja);
		$this->session->set_flashdata('success','Payment Successful.Please Export the PDF to Continue the Ordering Process.');
		// redirect('index.php/selforder/home/'.$table);
		redirect('index.php/selforder/viewpdf/bk');
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tb_polyline extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('status_login_generator_map')){
            redirect(base_url('index.php/Login'));
        }
		$this->load->model('Tb_settings_model');
		$this->load->model('Tb_polyline_model');
		$this->load->model('Tb_data_polyline_model');
		$this->load->model('Tb_kategori_model');
	}
	public function index(){
		$data['tb_settings'] = $this->Tb_settings_model->get();
		$data['page_view'] = 'Tb_polyline_view';
		$data['tb_kategori'] = $this->Tb_kategori_model->show();
		$array_polyline = array();
		$polyline = $this->Tb_polyline_model->show();
		foreach ($polyline as $key => $value) {
			$array_polyline[$key] = new StdClass;
			$array_polyline[$key]->id = $value->id;
			$array_polyline[$key]->id_kategori = $value->id_kategori;
			$array_polyline[$key]->nama = $value->nama;
			$array_polyline[$key]->warna = $value->warna;
			$array_polyline[$key]->keterangan = $value->keterangan;
			$array_polyline[$key]->show_flags = ($value->show_flags > 0) ? 'checked="checked"':'';
			$data_polyline = $this->Tb_data_polyline_model->show_array($value->id);
			foreach ($data_polyline as $key2 => $value2) {
				$array_polyline[$key]->data_polyline[$key2] = new StdClass;
				$array_polyline[$key]->data_polyline[$key2]->lat = floatval($value2->latitude);
				$array_polyline[$key]->data_polyline[$key2]->lng = floatval($value2->longitude);
			}
		}
		$data['polyline'] = $array_polyline;
		$array_polyline_latlng = array();
		$polyline = $this->Tb_polyline_model->show(TRUE);
		foreach ($polyline as $key => $value) {
			$array_polyline_latlng[$key] = new StdClass;
			$array_polyline_latlng[$key]->id = $value->id;
			$array_polyline_latlng[$key]->id_kategori = $value->id_kategori;
			$array_polyline_latlng[$key]->nama = $value->nama;
			$array_polyline_latlng[$key]->warna = $value->warna;
			$array_polyline_latlng[$key]->keterangan = $value->keterangan;
			$data_polyline = $this->Tb_data_polyline_model->show_array($value->id);
			foreach ($data_polyline as $key2 => $value2) {
				$array_polyline_latlng[$key]->data_polyline[$key2] = new StdClass;
				$array_polyline_latlng[$key]->data_polyline[$key2]->lat = floatval($value2->latitude);
				$array_polyline_latlng[$key]->data_polyline[$key2]->lng = floatval($value2->longitude);
			}
		}
		$data['polyline_latlng'] = $array_polyline_latlng;
		$this->load->view('template', $data);
	}
	public function is_show(){
		$this->form_validation->set_rules('id', 'id', 'trim|required');
		if($this->form_validation->run() == TRUE) {
			$show_flags = ($this->input->post('isShow') !== NULL) ? 1 : 0;
			if($this->Tb_polyline_model->update(['show_flags'=>$show_flags], $this->input->post('id'))){
				$this->session->set_flashdata('success','Berhasil diubah!');
			} else {
				$this->session->set_flashdata('failed','Gagal diubah!');
			}
			redirect(base_url('index.php/Tb_polyline'));
		}
	}
	public function upload_csv()
	{
		$this->form_validation->set_rules('id_kategori', 'id_kategori', 'trim|required');
		$this->form_validation->set_rules('nama', 'nama', 'trim|required');
		$this->form_validation->set_rules('warna', 'warna', 'trim|required');
		$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');

		if ($this->form_validation->run() == TRUE) {

			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'csv';
			$config['max_size']  = 0;
			$config['file_name'] = 'temp.csv';
			$config['overwrite']  = TRUE;
			
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			if (!$this->upload->do_upload('file_csv')){
				$error = json_encode(array('error' => $this->upload->display_errors()));
				$this->session->set_flashdata('failed', $error);
			} else {
				$post = $this->input->post();
				if ($post) {
					$values = array(
						'id_kategori' => $post['id_kategori'],
						'nama' => $post['nama'],
						'warna' => $post['warna'],
						'keterangan' => $post['keterangan']
					);
					if($this->Tb_polyline_model->insert($values)){
						$where = array(
							'id_kategori' => $post['id_kategori'],
							'nama' => $post['nama'],
							'warna' => $post['warna'],
							'keterangan' => $post['keterangan']
						);
						if (!empty($this->Tb_polyline_model->get($where))) {
							$data_array_csv = array();
							$csv = $this->upload->data('full_path');
							$handle = fopen($csv, "r");
							$i=0;
							while (($row = fgetcsv($handle, 10000, $this->detectDelimiter($csv))) != FALSE) {
								if($i > 0){
									$array_latlng = json_decode($this->utm2ll($this->str2float($row[1]), $this->str2float($row[2]), 49, false), true);
									$values = array(
										'id_polyline' => $this->Tb_polyline_model->get($where)->id,
										'latitude' => $array_latlng['attr']['lat'],
										'longitude' => $array_latlng['attr']['lon']
									);
									if($this->Tb_data_polyline_model->insert($values)){
										$this->session->set_flashdata('success','Berhasil disimpan!');
									} else {
										$this->session->set_flashdata('failed','Gagal disimpan!');
									}
								}
								$i++;
							}
						}
					}
				}
			}
		} else {
			$this->session->set_flashdata('failed', 'Gagal Di Upload!');
		}
		redirect(base_url('index.php/Tb_polyline'));
	}
	public function insert(){
		$this->form_validation->set_rules('id_kategori', 'id_kategori', 'trim|required');
		$this->form_validation->set_rules('nama', 'nama', 'trim|required');
		$this->form_validation->set_rules('warna', 'warna', 'trim|required');
		$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
		$this->form_validation->set_rules('positions', 'Positions', 'required');
		if($this->form_validation->run() == TRUE) {
			$post = $this->input->post();
			if ($post) {
				$values = array(
					'id_kategori' => $post['id_kategori'],
					'nama' => $post['nama'],
					'warna' => $post['warna'],
					'keterangan' => $post['keterangan']
				);
				if($this->Tb_polyline_model->insert($values)){
					$where = array(
						'id_kategori' => $post['id_kategori'],
						'nama' => $post['nama'],
						'warna' => $post['warna'],
						'keterangan' => $post['keterangan']
					);
					if (!empty($this->Tb_polyline_model->get($where))) {
						$positions = json_decode($post['positions']);
						if (!empty($positions)) {
							if ($this->Tb_data_polyline_model->delete_array($this->Tb_polyline_model->get($where)->id) == TRUE or FALSE) {
								foreach ($positions as $key => $value) {
									$values2 = array(
										'id_polyline' => $this->Tb_polyline_model->get($where)->id,
										'latitude' => $positions[$key]->lat,
										'longitude' => $positions[$key]->lng
									);
									if($this->Tb_data_polyline_model->insert($values2)){
										$this->session->set_flashdata('success','Berhasil disimpan!');
									} else {
										$this->session->set_flashdata('failed','Gagal disimpan!');
									}
								}
							}
						}
					}
					$this->session->set_flashdata('success','Berhasil disimpan!');
				} else {
					$this->session->set_flashdata('failed','Gagal disimpan!');
				}
			}
		}
		redirect(base_url('index.php/Tb_polyline'));
	}
	public function insert_array(){
		$this->form_validation->set_rules('id_kategori', 'id_kategori', 'trim|required');
		$this->form_validation->set_rules('nama', 'nama', 'trim|required');
		$this->form_validation->set_rules('warna', 'warna', 'trim|required');
		$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
		$this->form_validation->set_rules('jenis_array', 'jenis_array', 'trim|required');
		$this->form_validation->set_rules('delimiter', 'Delimiter', 'required');
		$this->form_validation->set_rules('positions', 'Positions', 'required');
		if($this->form_validation->run() == TRUE) {
			$post = $this->input->post();
			if ($post) {
				$values = array(
					'id_kategori' => $post['id_kategori'],
					'nama' => $post['nama'],
					'warna' => $post['warna'],
					'keterangan' => $post['keterangan']
				);
				if($this->Tb_polyline_model->insert($values)){
					$where = array(
						'id_kategori' => $post['id_kategori'],
						'nama' => $post['nama'],
						'warna' => $post['warna'],
						'keterangan' => $post['keterangan']
					);
					$this->session->set_flashdata('success','Berhasil disimpan!');
					$positions = str_replace($post['delimiter'],";",$post['positions']);
					$positions = substr($positions,0,strlen($positions)-1);
					$data_positions = explode(";",$positions);
					if(!empty($data_positions)){
						foreach ($data_positions as $key => $value) {
							$pos_lat = 0;
							$pos_lng = 0;
							$latlng = explode(",",$value);
							if (!empty($latlng)) {
								if ($post['jenis_array'] == "latlng") {
									$pos_lat = $latlng[0];
									$pos_lng = $latlng[1];
								} else {
									$pos_lng = $latlng[0];
									$pos_lat = $latlng[1];
								}
							}
							$values2 = array(
								'id_polyline' => $this->Tb_polyline_model->get($where)->id,
								'latitude' => floatval($pos_lat),
								'longitude' => floatval($pos_lng)
							);
							if ($this->Tb_data_polyline_model->insert($values2)) {
								$this->session->set_flashdata('success','Berhasil disimpan!');
							} else {
								$this->session->set_flashdata('failed','Gagal disimpan!');
							}
						}
					}
				} else {
					$this->session->set_flashdata('failed','Gagal disimpan!');
				}
			}
		}
		redirect(base_url('index.php/Tb_polyline'));
	}
	public function update(){
		$this->form_validation->set_rules('id', 'id', 'trim|required');
		$this->form_validation->set_rules('id_kategori', 'id_kategori', 'trim|required');
		$this->form_validation->set_rules('nama', 'nama', 'trim|required');
		$this->form_validation->set_rules('warna', 'warna', 'trim|required');
		$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
		if($this->form_validation->run() == TRUE) {
			$post = $this->input->post();
			if($this->Tb_polyline_model->update($post, $this->input->post('id'))){
				$this->session->set_flashdata('success','Berhasil diubah!');
			} else {
				$this->session->set_flashdata('failed','Gagal diubah!');
			}
			redirect(base_url('index.php/Tb_polyline'));
		}
	}
	public function delete(){
		if($this->Tb_polyline_model->delete($this->input->post('id'))){
			if($this->Tb_data_polyline_model->delete_array($this->input->post('id')) == TRUE or FALSE){
				$this->session->set_flashdata('success','Berhasil dihapus!');
			}
		} else {
			$this->session->set_flashdata('failed','Gagal dihapus!');
		}
		redirect(base_url('index.php/Tb_polyline'));
	}
	// Delimiter Detector //
	function detectDelimiter($csvFile)
	{
    $delimiters = array(
        ';' => 0,
        ',' => 0,
        "\t" => 0,
        "|" => 0
    );
    $handle = fopen($csvFile, "r");
    $firstLine = fgets($handle);
    fclose($handle); 
    foreach ($delimiters as $delimiter => &$count) {
        $count = count(str_getcsv($firstLine, $delimiter));
    }
    return array_search(max($delimiters), $delimiters);
  }
  function str2float($str)
  {
  	return floatval(str_replace([','], '.', $str));
  }
	// Fungsi Convert Argis //
	function utm2ll($x,$y,$zone,$aboveEquator){
		if(!is_numeric($x) or !is_numeric($y) or !is_numeric($zone)){
			return json_encode(array('success'=>false,'msg'=>"Wrong input parameters"));
		}
		$southhemi = false;
		if($aboveEquator!=true){
			$southhemi = true;
		}
		$latlon = $this->UTMXYToLatLon($x, $y, $zone, $southhemi);
		return json_encode(array('success'=>true,'attr'=>array('lat'=>$this->radian2degree($latlon[0]),'lon'=>$this->radian2degree($latlon[1]))));
	}
	function ll2utm($lat,$lon){
		if(!is_numeric($lon)){
			return json_encode(array('success'=>false,'msg'=>"Wrong longitude value"));
		}
		if($lon<-180.0 or $lon>=180.0){
			return json_encode(array('success'=>false,'msg'=>"The longitude is out of range"));
		}
		if(!is_numeric($lat)){
			return json_encode(array('success'=>false,'msg'=>"Wrong latitude value"));
		}
		if($lat<-90.0 or $lat>90.0){
			return json_encode(array('success'=>false,'msg'=>"The longitude is out of range"));
		}
		$zone = floor(($lon + 180.0) / 6) + 1;
		//compute values
		$result = $this->LatLonToUTMXY($this->degree2radian($lat),$this->degree2radian($lon),$zone);
		$aboveEquator = false;
		if($lat >0){
			$aboveEquator = true;
		}
		return json_encode(array('success'=>true,'attr'=>array('x'=>$result[0],'y'=>$result[1],'zone'=>$zone,'aboveEquator'=>$aboveEquator)));
	}

	function radian2degree($rad){
		$pi = 3.14159265358979;	
        	return ($rad / $pi * 180.0);
	}

	function degree2radian($deg){
		$pi = 3.14159265358979;
		return ($deg/180.0*$pi);
	}

	function UTMCentralMeridian($zone){
		$cmeridian = $this->degree2radian(-183.0 + ($zone * 6.0));
		return $cmeridian;
	}
	function LatLonToUTMXY ($lat, $lon, $zone){
	        $xy = $this->MapLatLonToXY($lat, $lon, $this->UTMCentralMeridian($zone));
		/* Adjust easting and northing for UTM system. */
		$UTMScaleFactor = 0.9996;
	        $xy[0] = $xy[0] * $UTMScaleFactor + 500000.0;
	        $xy[1] = $xy[1] * $UTMScaleFactor;
	        if ($xy[1] < 0.0)
        	    $xy[1] = $xy[1] + 10000000.0;
	        return $xy;
	}
	function UTMXYToLatLon ($x, $y, $zone, $southhemi){
		$latlon = array();
		$UTMScaleFactor = 0.9996;
        	$x -= 500000.0;
	        $x /= $UTMScaleFactor;
        	/* If in southern hemisphere, adjust y accordingly. */
	        if ($southhemi)
        		$y -= 10000000.0;
        	$y /= $UTMScaleFactor;
	        $cmeridian = $this->UTMCentralMeridian($zone);
        	$latlon = $this->MapXYToLatLon($x, $y, $cmeridian);	
        	return $latlon;
	}
	function MapXYToLatLon ($x, $y, $lambda0){
		$philambda = array();
		$sm_b = 6356752.314;
		$sm_a = 6378137.0;
		$UTMScaleFactor = 0.9996;
		$sm_EccSquared = .00669437999013;
	        $phif = $this->FootpointLatitude($y);
	        $ep2 = (pow ($sm_a, 2.0) - pow ($sm_b, 2.0)) / pow ($sm_b, 2.0);
	        $cf = cos ($phif);
	        $nuf2 = $ep2 * pow ($cf, 2.0);
	        $Nf = pow ($sm_a, 2.0) / ($sm_b * sqrt (1 + $nuf2));
        	$Nfpow = $Nf;
	        $tf = tan ($phif);
	        $tf2 = $tf * $tf;
	        $tf4 = $tf2 * $tf2;
        	$x1frac = 1.0 / ($Nfpow * $cf);
	        $Nfpow *= $Nf;   
        	$x2frac = $tf / (2.0 * $Nfpow);
	        $Nfpow *= $Nf;   
        	$x3frac = 1.0 / (6.0 * $Nfpow * $cf);
	        $Nfpow *= $Nf;   
        	$x4frac = $tf / (24.0 * $Nfpow);
	        $Nfpow *= $Nf;   
        	$x5frac = 1.0 / (120.0 * $Nfpow * $cf);
	        $Nfpow *= $Nf;   
	        $x6frac = $tf / (720.0 * $Nfpow);
        	$Nfpow *= $Nf;   
	        $x7frac = 1.0 / (5040.0 * $Nfpow * $cf);
        	$Nfpow *= $Nf;   
	        $x8frac = $tf / (40320.0 * $Nfpow);
        	$x2poly = -1.0 - $nuf2;
	        $x3poly = -1.0 - 2 * $tf2 - $nuf2;
        	$x4poly = 5.0 + 3.0 * $tf2 + 6.0 * $nuf2 - 6.0 * $tf2 * $nuf2- 3.0 * ($nuf2 *$nuf2) - 9.0 * $tf2 * ($nuf2 * $nuf2);
	        $x5poly = 5.0 + 28.0 * $tf2 + 24.0 * $tf4 + 6.0 * $nuf2 + 8.0 * $tf2 * $nuf2;
	        $x6poly = -61.0 - 90.0 * $tf2 - 45.0 * $tf4 - 107.0 * $nuf2	+ 162.0 * $tf2 * $nuf2;
	        $x7poly = -61.0 - 662.0 * $tf2 - 1320.0 * $tf4 - 720.0 * ($tf4 * $tf2);
	        $x8poly = 1385.0 + 3633.0 * $tf2 + 4095.0 * $tf4 + 1575 * ($tf4 * $tf2);
        	$philambda[0] = $phif + $x2frac * $x2poly * ($x * $x)
        		+ $x4frac * $x4poly * pow ($x, 4.0)
	        	+ $x6frac * $x6poly * pow ($x, 6.0)
        		+ $x8frac * $x8poly * pow ($x, 8.0);
        	
	        $philambda[1] = $lambda0 + $x1frac * $x
        		+ $x3frac * $x3poly * pow ($x, 3.0)
        		+ $x5frac * $x5poly * pow ($x, 5.0)
	        	+ $x7frac * $x7poly * pow ($x, 7.0);
        	
        	return $philambda;
	}

	function FootpointLatitude ($y){
		$sm_b = 6356752.314;
		$sm_a = 6378137.0;
		$UTMScaleFactor = 0.9996;
		$sm_EccSquared = .00669437999013;
	        $n = ($sm_a - $sm_b) / ($sm_a + $sm_b);
        	$alpha_ = (($sm_a + $sm_b) / 2.0)* (1 + (pow ($n, 2.0) / 4) + (pow ($n, 4.0) / 64));
	        $y_ = $y / $alpha_;
        	$beta_ = (3.0 * $n / 2.0) + (-27.0 * pow ($n, 3.0) / 32.0)+ (269.0 * pow ($n, 5.0) / 512.0);
	        $gamma_ = (21.0 * pow ($n, 2.0) / 16.0)+ (-55.0 * pow ($n, 4.0) / 32.0);
	        $delta_ = (151.0 * pow ($n, 3.0) / 96.0)+ (-417.0 * pow ($n, 5.0) / 128.0);
        	$epsilon_ = (1097.0 * pow ($n, 4.0) / 512.0);
	        $result = $y_ + ($beta_ * sin (2.0 * $y_))
        	    + ($gamma_ * sin (4.0 * $y_))
	            + ($delta_ * sin (6.0 * $y_))
	            + ($epsilon_ * sin (8.0 * $y_));
        	return $result;
	}
	function MapLatLonToXY ($phi, $lambda, $lambda0){
		$xy=array();
		$sm_b = 6356752.314;
		$sm_a = 6378137.0;
		$UTMScaleFactor = 0.9996;
		$sm_EccSquared = .00669437999013;
		$ep2 = (pow ($sm_a, 2.0) - pow ($sm_b, 2.0)) / pow ($sm_b, 2.0);
		$nu2 = $ep2 * pow (cos ($phi), 2.0);
		$N = pow ($sm_a, 2.0) / ($sm_b * sqrt (1 + $nu2));
		$t = tan ($phi);
		$t2 = $t * $t;
		$tmp = ($t2 * $t2 * $t2) - pow ($t, 6.0);
		$l = $lambda - $lambda0;
		$l3coef = 1.0 - $t2 + $nu2;
		$l4coef = 5.0 - $t2 + 9 * $nu2 + 4.0 * ($nu2 * $nu2);
		$l5coef = 5.0 - 18.0 * $t2 + ($t2 * $t2) + 14.0 * $nu2- 58.0 * $t2 * $nu2;
		$l6coef = 61.0 - 58.0 * $t2 + ($t2 * $t2) + 270.0 * $nu2- 330.0 * $t2 * $nu2;
		$l7coef = 61.0 - 479.0 * $t2 + 179.0 * ($t2 * $t2) - ($t2 * $t2 * $t2);
		$l8coef = 1385.0 - 3111.0 * $t2 + 543.0 * ($t2 * $t2) - ($t2 * $t2 * $t2);
		$xy[0] = $N * cos ($phi) * $l
            	+ ($N / 6.0 * pow (cos ($phi), 3.0) * $l3coef * pow ($l, 3.0))
            	+ ($N / 120.0 * pow (cos ($phi), 5.0) * $l5coef * pow ($l, 5.0))
            	+ ($N / 5040.0 * pow (cos ($phi), 7.0) * $l7coef * pow ($l, 7.0));
		$xy[1] = $this->ArcLengthOfMeridian ($phi)
            	+ ($t / 2.0 * $N * pow (cos ($phi), 2.0) * pow ($l, 2.0))
            	+ ($t / 24.0 * $N * pow (cos ($phi), 4.0) * $l4coef * pow ($l, 4.0))
            	+ ($t / 720.0 * $N * pow (cos ($phi), 6.0) * $l6coef * pow ($l, 6.0))
            	+ ($t / 40320.0 * $N * pow (cos ($phi), 8.0) * $l8coef * pow ($l, 8.0));
		return $xy;
	}
	function ArcLengthOfMeridian($phi){
		$sm_b = 6356752.314;
		$sm_a = 6378137.0;
		$UTMScaleFactor = 0.9996;
		$sm_EccSquared = .00669437999013;
		$n = ($sm_a - $sm_b) / ($sm_a + $sm_b);
		$alpha = (($sm_a + $sm_b) / 2.0)
			* (1.0 + (pow ($n, 2.0) / 4.0) + (pow ($n, 4.0) / 64.0));
		$beta = (-3.0 * $n / 2.0) + (9.0 * pow ($n, 3.0) / 16.0)
	           + (-3.0 * pow ($n, 5.0) / 32.0);
		$gamma = (15.0 * pow ($n, 2.0) / 16.0)
	            + (-15.0 * pow ($n, 4.0) / 32.0);
		$delta = (-35.0 * pow ($n, 3.0) / 48.0)
	            + (105.0 * pow ($n, 5.0) / 256.0);
		$epsilon = (315.0 * pow ($n, 4.0) / 512.0);
		$result = $alpha* ($phi + ($beta * sin (2.0 * $phi))
	            + ($gamma * sin (4.0 * $phi))
        	    + ($delta * sin (6.0 * $phi))
		    + ($epsilon * sin (8.0 * $phi)));
		return $result;
	}
}
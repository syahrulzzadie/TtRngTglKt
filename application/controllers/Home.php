<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
	function __construct() {
        parent::__construct();
        if(!$this->session->userdata('status_login_generator_map')){
            redirect(base_url('index.php/Login'));
        }
        $this->load->model('Tb_settings_model');
        $this->load->model('Tb_markers_model');
		$this->load->model('Tb_polygon_model');
		$this->load->model('Tb_data_polygon_model');
		$this->load->model('Tb_polyline_model');
		$this->load->model('Tb_data_polyline_model');
    }
	public function index(){
		$data['tb_settings'] = $this->Tb_settings_model->get();
		
		$total_data = array();

		$total_data[0]['total'] = count($this->Tb_markers_model->show());
		$total_data[1]['total'] = count($this->Tb_polygon_model->show());
		$total_data[2]['total'] = count($this->Tb_polyline_model->show());

		$total_data[0]['data'] = "Data Markers";
		$total_data[1]['data'] = "Data Polygon";
		$total_data[2]['data'] = "Data Polyline";

		$array_markers = array();
		$array_polygon = array();
		$array_polyline = array();

		$markers = $this->Tb_markers_model->show();
		foreach ($markers as $key => $value) {
			$array_markers[$key] = new StdClass;
			$array_markers[$key]->keterangan = $value->keterangan;
			$array_markers[$key]->latitude = $value->latitude;
			$array_markers[$key]->longitude = $value->longitude;
		}
		$polygon = $this->Tb_polygon_model->show();
		foreach ($polygon as $key => $value) {
			$array_polygon[$key] = new StdClass;
			$array_polygon[$key]->nama = $value->nama;
			$array_polygon[$key]->warna = $value->warna;
			$array_polygon[$key]->keterangan = $value->keterangan;
			$data_polygon = $this->Tb_data_polygon_model->show_array($value->id);
			foreach ($data_polygon as $key2 => $value2) {
				$array_polygon[$key]->data_polygon[$key2] = new StdClass;
				$array_polygon[$key]->data_polygon[$key2]->lat = floatval($value2->latitude);
				$array_polygon[$key]->data_polygon[$key2]->lng = floatval($value2->longitude);
			}
		}
		$polyline = $this->Tb_polyline_model->show();
		foreach ($polyline as $key => $value) {
			$array_polyline[$key] = new StdClass;
			$array_polyline[$key]->nama = $value->nama;
			$array_polyline[$key]->warna = $value->warna;
			$array_polyline[$key]->keterangan = $value->keterangan;
			$data_polyline = $this->Tb_data_polyline_model->show_array($value->id);
			foreach ($data_polyline as $key2 => $value2) {
				$array_polyline[$key]->data_polyline[$key2] = new StdClass;
				$array_polyline[$key]->data_polyline[$key2]->lat = floatval($value2->latitude);
				$array_polyline[$key]->data_polyline[$key2]->lng = floatval($value2->longitude);
			}
		}

		$data['markers'] = $array_markers;
		$data['polygon'] = $array_polygon;
		$data['polyline'] = $array_polyline;

		$data['total_data'] = $total_data;
		$data['page_view'] = 'Home_view';
		$this->load->view('template', $data);
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('index.php/Login'));
	}
}
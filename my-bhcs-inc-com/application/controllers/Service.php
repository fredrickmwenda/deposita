<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'main_department_model',
			'service_model',
			'human_resources/employee_model',
			'setting_model'
		));

		if ($this->session->userdata('isLogIn') == false)
		redirect('login');

	}

	public function index(){
		$data['module'] = "Services";
		$data['title'] = "Service List";
		#-------------------------------#
		$data['disciplines'] = $this->service_model->read();
	//	$data['lang_dprt'] = $this->main_department_model->read_lang_department();
		$data['content'] = $this->load->view('department/service',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

 	public function create($id = null){
 		$data['module'] = "Services";
		$data['title'] = "Add Service";
		$this->form_validation->set_rules('name','Name','required|max_length[50]');
		#-------------------------------#
		$data['discpline'] = (object)$postData = [
			'name' => $this->input->post('name',true),
			'description' => $this->input->post('description',true),
			'status' => $this->input->post('status',true)
		];
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $main_dprt_id then insert data
			if (empty($id)) {

				if ($this->service_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message', "Service added successfully.");
				} else {
					#set exception message
					$this->session->set_flashdata('exception',display('please_try_again'));
				}
				redirect('/service');
			} else {
				$postData = [
					'id' => $id,
					'name' => $this->input->post('name',true),
					'description' => $this->input->post('description',true),
					'status' => $this->input->post('status',true)
				];
				if ($this->service_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', "Service updated successfully.");
				} else {
					#set exception message
					$this->session->set_flashdata('exception',display('please_try_again'));
				}
				redirect('service/edit/'.$id);
			}

		} else {
			$data['content'] = $this->load->view('department/service_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		}
	}

	public function read($id = null){
		$data['module'] = 'Service';
		$data['title'] = 'Service Information';
		#-------------------------------#
		$data['discipline'] = $this->service_model->read_by_id($id);
		$data['content'] = $this->load->view('department/service_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}


	public function edit($id = null){
		$data['module'] = 'Service';
		$data['title'] = 'Service Type';
		#-------------------------------#
		$data['discipline'] = $this->service_model->read_by_id($id);
		//$data['department'] = $this->main_department_model->read_by_id($id);
		$data['content'] = $this->load->view('department/service_form_edit',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function info($id = null){
		$data['module'] = 'License Type';
		$data['title'] = 'License Type Information';
		#-------------------------------#
		$data['department'] = $this->main_department_model->read_by_id($id);
		$data['content'] = $this->load->view('department/discipline_info',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function renew($id = null){
		$data['module'] = 'Employee License';
		$data['title'] = 'Renew License';
		#-------------------------------#
		$data['department'] = $this->main_department_model->read_by_id($id);
		$data['content'] = $this->load->view('department/license_renew',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}


	public function delete($id = null)
	{
		if ($this->service_model->delete($id)) {
			#set success message
			$this->session->set_flashdata('message', display('delete_successfully'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('service');
	}

}

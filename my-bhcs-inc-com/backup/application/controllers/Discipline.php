<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discipline extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'main_department_model',
			'discipline_model',
			'human_resources/employee_model',
			'setting_model'
		));

		if ($this->session->userdata('isLogIn') == false)
		redirect('login');

	}

	public function index(){
		$data['module'] = "Discipline";
		$data['title'] = "Discipline List";
		#-------------------------------#
		$data['disciplines'] = $this->discipline_model->read();
	//	$data['lang_dprt'] = $this->main_department_model->read_lang_department();
		$data['content'] = $this->load->view('department/discipline',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

 	public function create($id = null){
 		$data['module'] = "Disciplines";
		$data['title'] = "Add Discipline";
		$this->form_validation->set_rules('name','Name','required|max_length[50]');
		#-------------------------------#
		$data['discpline'] = (object)$postData = [
			'name' => $this->input->post('name',true),
			'description' => $this->input->post('description',true),
			'status' => $this->input->post('status',true)
		];

		$source = $this->input->post('source');
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $main_dprt_id then insert data
			if (empty($id)) {

				if ($this->discipline_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message', "Discipline added successfully.");
				} else {
					#set exception message
					$this->session->set_flashdata('exception',display('please_try_again'));
				}
				redirect($source);
			} else {
				$postData = [
					'id' => $id,
					'name' => $this->input->post('name',true),
					'description' => $this->input->post('description',true),
					'status' => $this->input->post('status',true)
				];
				if ($this->discipline_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', "Discipline updated successfully.");
				} else {
					#set exception message
					$this->session->set_flashdata('exception',display('please_try_again'));
				}
				redirect('discipline/edit/'.$id);
			}

		} else {
			$data['content'] = $this->load->view('department/discipline_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		}
	}

	public function read($id = null){
		$data['module'] = 'Discipline';
		$data['title'] = 'Discipline Information';
		#-------------------------------#
		$data['discipline'] = $this->discipline_model->read_by_id($id);
		$data['content'] = $this->load->view('department/discipline_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}


	public function edit($id = null){
		$data['module'] = 'Discipline';
		$data['title'] = 'Discipline Type';
		#-------------------------------#
		$data['discipline'] = $this->discipline_model->read_by_id($id);
		//$data['department'] = $this->main_department_model->read_by_id($id);
		$data['content'] = $this->load->view('department/discipline_form_edit',$data,true);
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
		if ($this->discipline_model->delete($id)) {
			#set success message
			$this->session->set_flashdata('message', 'Discipline deleted successfully.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('discipline');
	}

}

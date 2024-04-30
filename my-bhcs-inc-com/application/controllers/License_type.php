<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class License_type extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'main_department_model',
			'license_type_model',
			'human_resources/employee_model',
			'setting_model'
		));

		if ($this->session->userdata('isLogIn') == false)
		redirect('login');

	}

	public function index(){
		$data['module'] = "License Type";
		$data['title'] = "License Type List";
		#-------------------------------#
		$data['licenses'] = $this->license_type_model->read();
	//	$data['lang_dprt'] = $this->main_department_model->read_lang_department();
		$data['content'] = $this->load->view('department/license_type',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

 	public function create($id = null){
 		$data['module'] = "License Types";
		$data['title'] = "Add License Type";
		$this->form_validation->set_rules('name','Name','required|max_length[50]');
		#-------------------------------#
		$data['license_type'] = (object)$postData = [
			'name' => $this->input->post('name',true),
			'description' => $this->input->post('description',true),
			'status' => $this->input->post('status',true)
		];
		#-------------------------------#
		$source = $this->input->post('source');
		if ($this->form_validation->run() === true) {

			#if empty $main_dprt_id then insert data
			if (empty($id)) {

				if ($this->license_type_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message', "License Type added successfully.");
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
				if ($this->license_type_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', "License Type updated successfully.");
				} else {
					#set exception message
					$this->session->set_flashdata('exception',display('please_try_again'));
				}
				redirect('license_type'.$id);
			}

		} else {
			$data['content'] = $this->load->view('department/license_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		}
	}

	public function updatePassword(){
 		$data['module'] = "";
		$data['title'] = "Update Password";
		#-------------------------------#
		$this->form_validation->set_rules('password', "Password" ,'required|max_length[100]|min_length[6]');
		$this->form_validation->set_rules('confirm', 'Confirm Password', 'required|matches[password]');
		#-------------------------------#
		$data['department'] = (object)$postData = [
			'password' 	      => md5($this->input->post('password',true))
		];


		$postData['user_id'] = $this->session->userdata('user_id');
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $main_dprt_id then insert data
			if (!empty($postData['user_id'])) {
				if ($this->employee_model->update($postData)) {

					$data1['user_id'] = $this->session->userdata('user_id');
					$data1['password_status'] = 1;
					$this->employee_model->update($data1);
					#set success message
					$this->session->set_flashdata('message', 'Password updated successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception',display('please_try_again'));
				}
				redirect('main_department/updatePassword');
			}

		} else {
			$data['content'] = $this->load->view('human_resources/update_password',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		}
	}


	public function read($id = null){
		$data['module'] = 'License Type';
		$data['title'] = 'License Type Information';
		#-------------------------------#
		$data['license'] = $this->license_type_model->read_by_id($id);
		$data['content'] = $this->load->view('department/license_type_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}


	public function edit($id = null){
		$data['module'] = 'License Type';
		$data['title'] = 'Edit License Type';
		#-------------------------------#
			$data['license'] = $this->license_type_model->read_by_id($id);
		//$data['department'] = $this->main_department_model->read_by_id($id);
		$data['content'] = $this->load->view('department/license_type_form_edit',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function info($id = null){
		$data['module'] = 'License Type';
		$data['title'] = 'License Type Information';
		#-------------------------------#
		$data['department'] = $this->main_department_model->read_by_id($id);
		$data['content'] = $this->load->view('department/license_type_info',$data,true);
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
		if ($this->license_type_model->delete($id)) {
			#set success message
			$this->session->set_flashdata('message', display('delete_successfully'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('license_type');
	}

}

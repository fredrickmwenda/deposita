<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class License extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'main_department_model',
			'license_model',
			'license_type_model',
			'human_resources/employee_model',
			'setting_model'
		));

		if ($this->session->userdata('isLogIn') == false)
		redirect('login');

	}

	public function employee_licenses($id){
		$data['module'] = "Employee Licenses";
		$data['title'] = "Employee Licenses List";
		#-------------------------------#
		$data['licenses'] = $this->license_model->read_all_by_employee_id($id);
	//	$data['lang_dprt'] = $this->main_department_model->read_lang_department();
		$data['content'] = $this->load->view('department/license',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function get_employees_whose_licenses_due(){

			//1. Get all due licenses - from license table
			//1.1 Determine which employees they belong to - Join employee table 
			//1.2 and display employee name
			//2. Get all employees
			//3. Match
			//4. Add match to a new array

	}

 	public function create($id = null){
 		$data['module'] = "Licenses";
		$data['title'] = "Add License";
		$this->form_validation->set_rules('licType','License Type','required|max_length[50]');
		#-------------------------------#
		$data['license'] = (object)$postData = [
			'employeeId' => $this->input->post('employeeId',true),
			'licType' => $this->input->post('licType',true),
			'status' => $this->input->post('status',true),
			'licFrom' => $this->input->post('licFrom',true),
			'licDue'      => $this->input->post('licDue',true)
		];
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $main_dprt_id then insert data
			if (empty($id)) {

				if ($this->license_model->create($postData)) {

					#set success message
					$this->session->set_flashdata('message', "License added successfully.");
				} else {
					#set exception message
					$this->session->set_flashdata('exception',display('please_try_again'));
				}
					redirect('human_resources/employee/form/'. $this->input->post('employeeId',true));
			} else {
				$postData = [
					'id' => $id,
					'employeeId' => $this->input->post('employeeId',true),
					'licType' => $this->input->post('licType',true),
					'status' => $this->input->post('status',true),
					'licFrom' => $this->input->post('licFrom',true),
					'licDue'      => $this->input->post('licDue',true)
				];
				if ($this->license_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', "License updated successfully.");
				} else {
					#set exception message
					$this->session->set_flashdata('exception','Try');
				}
				redirect('human_resources/employee/form/'. $this->input->post('employeeId',true));
			}

		} else {
			$data['content'] = $this->load->view('department/license_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		}
	}

	public function read($id = null){
		$data['module'] = 'Employee License';
		$data['title'] = 'License Information';
		#-------------------------------#
		$data['licenses'] = $this->license_type_model->read();
		$data['license'] = $this->license_model->read_by_id($id);
		$data['content'] = $this->load->view('department/license_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function edit($id = null){
		$data['module'] = 'Employee License';
		$data['title'] = 'Edit License';
		#-------------------------------#
		$data['licenses'] = $this->license_type_model->read();
		$data['license'] = $this->license_model->read_by_id($id);
		$data['department'] = $this->main_department_model->read_by_id($id);
		$data['content'] = $this->load->view('department/license_form_edit',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function info($id = null, $source){
		$data['module'] = 'Employee License';
		$data['title'] = 'License Information';
		#-------------------------------#
		$data['profile'] = $this->license_model->read_by_id($id);
		$data['source'] = 'human_resources/employee/form/'.$source;
		$data['content'] = $this->load->view('department/license_info',$data,true);
		$this->load->view('layout/license_wrapper',$data);
	}

	public function renew($id = null){
		$data['module'] = 'Employee License';
		$data['title'] = 'Renew License';
		#-------------------------------#
		$data['department'] = $this->main_department_model->read_by_id($id);
		$data['content'] = $this->load->view('department/license_renew',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}


	public function delete($id = null, $employeeId, $src = null)
	{
		if ($this->license_model->delete($id)) {
			#set success message
			$this->session->set_flashdata('message', 'License successfully deleted.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}

		if (empty($src)) {
			redirect('human_resources/employee/form/'.$employeeId);
		} else {
			redirect('license/employee_licenses/'.$employeeId);
		}

	}

	public function add_lang($id = null){
		$data['module'] = display("departments");
		$data['title'] = display('add_main_department');
		#-------------------------------#
		$this->form_validation->set_rules('main_id', display('department_name') ,'required');
		$this->form_validation->set_rules('language', display('language') ,'required');
		$this->form_validation->set_rules('name', display('department_name') ,'required|max_length[100]');
		$this->form_validation->set_rules('description', display('description'),'trim');
		$this->form_validation->set_rules('status', display('status') ,'required');
		#-------------------------------#
		$data['department'] = (object)$postData = [
			'id' 	      => $this->input->post('id'),
			'main_id' 	  => $this->input->post('main_id',true),
			'language' 	  => $this->input->post('language',true),
			'name' 		  => $this->input->post('name',true),
			'description' => $this->input->post('description',true),
			'status'      => $this->input->post('status',true)
		];
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $main_dprt_id then insert data
			if (empty($postData['id'])) {
				//check language exists
				$pos_res = $this->db->select('*')
							->from('main_department_lang')
							->where('main_id',$postData['main_id'])
							->where('language', $postData['language'])
							->get()
							->num_rows();
				if($pos_res > 0){
					#set exception message
					$this->session->set_flashdata('exception', display('language').' '.display('already_exists'));
					redirect('main_department/add_lang/'.$postData['main_id']);
				}else{
					if ($this->main_department_model->create_lang($postData)) {
					#set success message
					$this->session->set_flashdata('message', display('save_successfully'));
					} else {
						#set exception message
						$this->session->set_flashdata('exception',display('please_try_again'));
					}
					redirect('main_department/add_lang/'.$postData['main_id']);
				}

			} else {
				if ($this->main_department_model->update_lang($postData)) {
					#set success message
					$this->session->set_flashdata('message', display('update_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception',display('please_try_again'));
				}
				redirect('main_department/edit_lang/'.$postData['id']);
			}

		} else {
			$data['languageList'] = $this->setting_model->languageList();
			$data['department'] = $this->main_department_model->read_by_id($id);
			$data['content'] = $this->load->view('department/main_department_language_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		}
	}

	public function edit_lang($id = null){
		$data['module'] = display("departments");
		$data['title'] = display('languages');
		#-------------------------------#
		$data['languageList'] = $this->setting_model->languageList();
		$data['department'] = $this->main_department_model->read_lang_by_id($id);
		$data['content'] = $this->load->view('department/main_department_lang_edit',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function delete_lang($id = null)
	{
		if ($this->main_department_model->delete_lang($id)) {
			#set success message
			$this->session->set_flashdata('message', display('delete_successfully'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('main_department');
	}

}

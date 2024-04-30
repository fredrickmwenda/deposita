<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'main_department_model',
			'categories_model',
			'human_resources/employee_model',
			'setting_model'
		));

		if ($this->session->userdata('isLogIn') == false)
		redirect('login');

	}

	public function index(){
		$data['module'] = "Categories";
		$data['title'] = "Categories List";
		#-------------------------------#
	  $data['categories'] = $this->categories_model->read();
	//	$data['lang_dprt'] = $this->main_department_model->read_lang_department();
		$data['content'] = $this->load->view('department/categories',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

 	public function create($id = null){
 		$data['module'] = "Categories";
		$data['title'] = "Add Category";
		#-------------------------------#
		$this->form_validation->set_rules('name', display('department_name') ,'required|max_length[100]');
		$this->form_validation->set_rules('description', display('description'),'trim');
		$this->form_validation->set_rules('status', display('status') ,'required');
		#-------------------------------#
		$data['department'] = (object)$postData = [
			'id' 	      => $id,
			'name' 		  => $this->input->post('name',true),
			'description' => $this->input->post('description',true),
			'status'      => $this->input->post('status',true)
		];
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $main_dprt_id then insert data
			if (empty($postData['id'])) {
				if ($this->categories_model->create($postData)) {

					#set success message
					$this->session->set_flashdata('message', 'Category added successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception',display('please_try_again'));
				}
				redirect('categories');
			} else {
				if ($this->categories_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'Category updated successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception',display('please_try_again'));
				}
				redirect('categories');
			}

		} else {
			$data['content'] = $this->load->view('department/categories_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		}
	}


	public function edit($id = null){
		$data['module'] = 'Category';
		$data['title'] = 'Edit Category ';
		#-------------------------------#
		$data['category'] = $this->categories_model->read_by_id($id);
		$data['content'] = $this->load->view('department/categories_form_edit',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function read($id = null){
		$data['module'] = 'Category';
		$data['title'] = 'Category Information';
		#-------------------------------#
		$data['category'] = $this->categories_model->read_by_id($id);
		$data['content'] = $this->load->view('department/categories_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}


	public function delete($id = null)
	{
		if ($this->categories_model->delete($id)) {
			#set success message
			$this->session->set_flashdata('message', 'Category successfully deleted.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('categories');
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

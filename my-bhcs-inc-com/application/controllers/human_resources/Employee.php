<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// load model
		$this->load->model(array(
			'human_resources/employee_model',
			'main_department_model',
			'discipline_model',
			'license_type_model',
			'permisson_model',
			'license_model',
			'setting_model'
		));

		if ($this->session->userdata('isLogIn') == false)
		redirect('login');
	}

	public function filter_employees()
	{
		// POST data
		$status = $this->input->post('status');
		// Get data
		$data = $this->employee_model->filter_employees($status);
		foreach ($data as $key => $dValue) {
			$dData[] = ['id' => $key+1,
								'name' => $dValue->firstname." ".$dValue->lastname,
								'cellphone' => $dValue->cellphone,
								'address' => $dValue->address,
								'sex' => $dValue->sex
								];
		}


		echo json_encode($dData);
	}

	public function filter_users()
	{
		// POST data
		$status = $this->input->post('status');
		// Get data

		$data = $this->employee_model->filter_users($status);
		$roles = $this->permisson_model->rolelist();
		$employeeLang = $this->employee_model->employees_lang();
		$user_role;

		foreach ($data as $key => $dValue) {

			foreach ($roles as $role) {

				if ($role->id == $dValue->user_role) {
					// code...
					$user_role=$role->type;
				}
			}

			$dData[] = ['id' => $key+1,
								'name' => $dValue->firstname." ".$dValue->lastname,
								'cellphone' => $dValue->cellphone,
								'email' => $dValue->email,
								'role' => $user_role
								];
		}

		echo json_encode($dData);
	}

	function search_employee_req()
 {
  $output = '';
  $query = '';
	$source = $this->input->post('source');
  if($this->input->post('query'))
  {

   $query = $this->input->post('query');

  }
  $data = $this->employee_model->search_employee_req($query);
	if ($query == '') {
  $numRows = 0;
} else {
	$numRows = $data->num_rows();
}

	if ($source == 1) {

	}

	switch ($source) {
		case 1:
		$output .= '
		<ul style="list-style-type:none;">
		';
		if($numRows > 0)
		{
		 foreach($data->result() as $row)
		 {
			$output .= '
				<li id = "'.$row->user_id.'" onmousedown = "selectProvider(this.id)" style = "margin-bottom: 5px; color: black; font-weight: 1em";>'.$row->firstname." ".$row->lastname.'</li>
			';
		 }
		}
		$output .= '
		</ul>';
			break;
		case 2:
		$output .= '
		<ul style="list-style-type:none;">
		';
		if($numRows > 0)
		{
		 foreach($data->result() as $row)
		 {
			$output .= '
				<li id = "'.$row->user_id.'" onmousedown = "selectProvider2(this.id)" style = "margin-bottom: 5px; color: black; font-weight: 1em";>'.$row->firstname." ".$row->lastname.'</li>
			';
		 }
		}
		$output .= '
		</ul>';
			break;
			case 3:
			$output .= '
			<ul style="list-style-type:none;">
			';
			if($numRows > 0)
			{
			 foreach($data->result() as $row)
			 {
				$output .= '
					<li id = "'.$row->user_id.'" onmousedown = "selectProvider3(this.id)" style = "margin-bottom: 5px; color: black; font-weight: 1em";>'.$row->firstname." ".$row->lastname.'</li>
				';
			 }
			}
			$output .= '
			</ul>';
				break;
		default:
			// code...
			break;
	}


  echo $output;

}


	public function index(){
		$data['module'] = 'Employee';
    $data['title'] = display("employees_list");
		#-------------------------------#
		$data['employees'] = $this->employee_model->employees_list();
		$data['employeeLang'] = $this->employee_model->employees_lang();
		$data['role_name'] = $this->employee_model->role_list();
		//$data['disciplines'] = $this->discipline_model->read();
		$data['content'] = $this->load->view('human_resources/view', $data, true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function all(){
		$data = $this->employee_model->employees_list();
		foreach ($data as $key => $dValue) {
			$dData[] = ['id' => $key+1,
								'name' => $dValue->firstname." ".$dValue->lastname,
								'cellphone' => $dValue->cellphone,
								'address' => $dValue->address,
								'sex' => $dValue->sex
								];
		}
		echo json_encode($dData);
	}

	public function all_users(){
		$data = $this->employee_model->users_list();
		$roles = $this->permisson_model->rolelist();
		$user_role;
		foreach ($data as $key => $dValue) {
			foreach ($roles as $role) {
				// code...
				if ($role->id == $dValue->user_role) {
					// code...
					$user_role=$role->type;
				}
			}

			$dData[] = ['id' => $key+1,
								'name' => $dValue->firstname." ".$dValue->lastname,
								'cellphone' => $dValue->cellphone,
								'email' => $dValue->email,
								'role' => $user_role
								];
		}
			echo json_encode($dData);

	}

	// search employee by id or name
	public function search(){
		$data['module'] = "Employee";
		$data['title'] = display('search');
		$searchText = $this->input->get('search_text', true);
		$data['patients'] = $this->employee_model->search_employee($searchText);
		$data['content'] = $this->load->view('human_resources/employee_search_result',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function users(){
		$data['module'] = 'Users';
		$data['title'] = "Users List";
		#-------------------------------#
		//Load user data
		$data['employees'] = $this->employee_model->users_list();
		$data['user_roles'] = $this->permisson_model->rolelist();
		$data['employeeLang'] = $this->employee_model->employees_lang();
		$data['role_name'] = $this->employee_model->role_list();

		$data['content'] = $this->load->view('human_resources/view-user', $data, true);
		$this->load->view('layout/main_wrapper',$data);
	}

    public function email_check($email, $user_id)
    {
    	$emailExists = $this->db->select('email')
    		->where('email',$email)
    		->where_not_in('user_id',$user_id)
    		->get('user')
    		->num_rows();

        if ($emailExists > 0) {
            $this->form_validation->set_message('email_check', 'The {field} field must contain a unique value.');
            return false;
        } else {
            return true;
        }
    }


		public function form_user($user_id = null, $read = null)
		{
			$this->form_validation->set_rules('firstname', display('first_name'),'required|max_length[50]');
			$this->form_validation->set_rules('lastname',display('last_name'),'required|max_length[50]');

			if (!empty($user_id)) {
			//	$this->form_validation->set_rules('email',display('email'), "required|max_length[50]|valid_email|callback_email_check[$user_id]");
			} else {
				$this->form_validation->set_rules('email',display('email'),'required|max_length[50]|valid_email|callback_email_check');
				//
			}
					if (empty($user_id)) {
		//	 $this->form_validation->set_rules('password',display('password'),'required|max_length[32]|md5');
					}
			$this->form_validation->set_rules('sex',display('sex'),'required|max_length[10]');
			//$this->form_validation->set_rules('status',display('status'),'required');
			#-------------------------------#
			//picture upload
			$picture = $this->fileupload->do_upload(
				'assets/images/human_resources/',
				'picture'
			);
			// if picture is uploaded then resize the picture
			if ($picture !== false && $picture != null) {
				$this->fileupload->do_resize(
					$picture, 293, 350
				);
			}
			//if picture is not uploaded
			if ($picture === false) {
				$this->session->set_flashdata('exception', display('invalid_picture'));
			}
			$user_role = $this->input->post('user_role');
			#-------------------------------#

			if (empty($this->input->post('user_id'))) {
				//when create a user
				$data['employee'] = (object)$postData = array(
					'user_id'      => $this->input->post('user_id'),
					'firstname'    => $this->input->post('firstname'),
					'lastname' 	   => $this->input->post('lastname'),
					'middlename' 	   => $this->input->post('middlename'),
					'email' 	   => $this->input->post('email'),
					'password_status' => $this->input->post('password_status'),
					'branch' => $this->input->post('branch'),
					'password' 	   => md5($this->input->post('password')),
				//	'comments' 	   => $this->input->post('comments',true),
					'picture'      => (!empty($picture)?$picture:$this->input->post('old_picture')),
					'user_role'    => $this->input->post('user_role'),
					'gen_role'    => $this->input->post('gen_role'),
					'sex'          => $this->input->post('sex'),
					'create_date'  => date('Y-m-d'),
					'created_by'   => $this->session->userdata('user_id'),
					'status'       => $this->input->post('status'),
				);
			} else {
				//when create a user
				$data['employee'] = (object)$postData = array(
					'user_id'      => $this->input->post('user_id'),
					'firstname'    => $this->input->post('firstname'),
					'lastname' 	   => $this->input->post('lastname'),
					'middlename' 	   => $this->input->post('middlename'),
					'email' 	   => $this->input->post('email'),
					//'password_status' => $this->input->post('password_status'),
					'branch' => $this->input->post('branch'),
					//'password' 	   => md5($this->input->post('password')),
				//	'comments' 	   => $this->input->post('comments',true),
					'picture'      => (!empty($picture)?$picture:$this->input->post('old_picture')),
					'user_role'    => $this->input->post('user_role'),
					'gen_role'    => $this->input->post('gen_role'),
					'sex'          => $this->input->post('sex'),
					'create_date'  => date('Y-m-d'),
					'created_by'   => $this->session->userdata('user_id'),
					'status'       => $this->input->post('status'),
				);
			}

					/*-----------CHECK ID -----------*/
					if (empty($user_id)) {

							/*-----------CREATE A NEW RECORD-----------*/
							if ($this->form_validation->run() === true) {
									if ($this->employee_model->create($postData)){

										$user_id = $this->db->insert_id();
										//create role assign
						$data['employee'] = (object)$roleassignData = array(
							'user_id'      => $user_id,
							'roleid'      =>$user_role,
							'createby'   => $this->session->userdata('user_id'),
							'createdate'  => date('Y-m-d'),

						);
										$this->employee_model->create_role($roleassignData);

										$langData = [
							'user_id'      => $user_id,

							'firstname'    => $this->input->post('firstname',true),
							'lastname' 	   => $this->input->post('lastname',true),
							'middlename' 	   => $this->input->post('middlename',true),

							'cellphone'        => $this->input->post('cellphone',true)

						];
						$this->employee_model->create_lang($langData);



											#set success message
											$this->session->set_flashdata('message', "User successfully added to the system.");
									} else {
											#set exception message
											$this->session->set_flashdata('exception',display('please_try_again'));
									}
									redirect('human_resources/employee/users');
							} else {
								//view section
									$data['title'] = "Add User";
									//$data['userRoles'] = $this->user_roles();
									$data['userRoles'] = $this->employee_model->user_roles();
									$data['branches'] = $this->main_department_model->read();
									$data["isAdmin"] =  $this->session->userdata('isAdmin');
									$data['content'] = $this->load->view('human_resources/form-user',$data,true);
									$this->load->view('layout/main_wrapper',$data);
							}

					}
					else {
							/*-----------UPDATE A RECORD-----------*/
							if ($this->form_validation->run() === true) {
								$langId = $this->employee_model->read_lang_by_employee_id($user_id)->id;

									if ($this->employee_model->update($postData)) {

										$langData = [
							'user_id'      => $user_id,
							'id' => $langId,
							'firstname'    => $this->input->post('firstname',true),
							'lastname' 	   => $this->input->post('lastname',true),
							'middlename' 	   => $this->input->post('middlename',true),

							'cellphone'        => $this->input->post('cellphone',true)

						];
						$this->employee_model->update_lang($langData);
											#set success message
											$this->session->set_flashdata('message', "Update successful.");
									} else {
											#set exception message
											$this->session->set_flashdata('exception',display('please_try_again'));
									}
									redirect('human_resources/employee/users');
							} else {
								//view section

								if ($read != null) {
									$data['module'] = "Users";
										$data['title'] = "User Information";
										$data['employee'] = $this->employee_model->read_by_id($user_id);
										$data['userRoles'] = $this->employee_model->user_roles();
										$data['branches'] = $this->main_department_model->read();
										$data['content'] = $this->load->view('human_resources/user_read',$data,true);
										$this->load->view('layout/main_wrapper',$data);
								} else {

									$data['module'] = "Users";
										$data['title'] = "Edit User";
										$data['branches'] = $this->main_department_model->read();
										$data['employee'] = $this->employee_model->read_by_id($user_id);

										$data['userRoles'] = $this->employee_model->user_roles();
										$data['content'] = $this->load->view('human_resources/user_edit',$data,true);
										$this->load->view('layout/main_wrapper',$data);

								}


							}
					}
					/*---------------------------------*/
		}

	public function form($user_id = null, $read = null)
	{
		$this->form_validation->set_rules('firstname', display('first_name'),'required|max_length[50]');
		$this->form_validation->set_rules('lastname',display('last_name'),'required|max_length[50]');

		if (!empty($user_id)) {
		//	$this->form_validation->set_rules('email',display('email'), "required|max_length[50]|valid_email|callback_email_check[$user_id]");
		} else {
		//	$this->form_validation->set_rules('email',display('email'),'required|max_length[50]|valid_email|callback_email_check');
			//
		}
        if (empty($user_id)) {
	//	 $this->form_validation->set_rules('password',display('password'),'required|max_length[32]|md5');
        }
		$this->form_validation->set_rules('sex',display('sex'),'required|max_length[10]');
		$this->form_validation->set_rules('status',display('status'),'required');
		#-------------------------------#
		//picture upload
		$picture = $this->fileupload->do_upload(
			'assets/images/human_resources/',
			'picture'
		);
		// if picture is uploaded then resize the picture
		if ($picture !== false && $picture != null) {
			$this->fileupload->do_resize(
				$picture, 293, 350
			);
		}
		//if picture is not uploaded
		if ($picture === false) {
			$this->session->set_flashdata('exception', display('invalid_picture'));
		}
		$user_role = $this->input->post('user_role');
		#-------------------------------#
		//when create a user
		$data['employee'] = (object)$postData = array(
			'user_id'      => $this->input->post('user_id'),
			'firstname'    => $this->input->post('firstname'),
			'lastname' 	   => $this->input->post('lastname'),
			'middlename' 	   => $this->input->post('middlename'),
			'hire_date' 	   => $this->input->post('hire_date'),
			'date_of_birth' 	   => $this->input->post('date_of_birth'),
			'picture'      => (!empty($picture)?$picture:$this->input->post('old_picture')),
			'user_role'    => 50,
			'gen_role'    => $this->input->post('gen_role'),
			'sex'          => $this->input->post('sex'),
			'branch'          => $this->input->post('branch'),
			'create_date'  => date('Y-m-d'),
			'created_by'   => $this->session->userdata('user_id'),
			'status'       => $this->input->post('status'),
			'comments'       => $this->input->post('comments')
		);

        /*-----------CHECK ID -----------*/
        if (empty($user_id)) {

            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) {
                if ($this->employee_model->create($postData)){
                	$user_id = $this->db->insert_id();
                	//create role assign
					$data['employee'] = (object)$roleassignData = array(
						'user_id'      => $user_id,
						'roleid'      =>50,
						'createby'   => $this->session->userdata('user_id'),
						'createdate'  => date('Y-m-d'),

					);
                	$this->employee_model->create_role($roleassignData);

                	$langData = [
						'user_id'      => $user_id,
						'language'     => $this->session->userdata('tableLang'),
						'firstname'    => $this->input->post('firstname',true),
						'middlename'    => $this->input->post('middlename',true),
						'lastname' 	   => $this->input->post('lastname',true),
						'discipline'    => $this->input->post('discipline',true),
						'emContact'    => $this->input->post('emContact',true),
						'emPhone'    => $this->input->post('emPhone',true),
						'designation'  => $this->input->post('designation',true),
						'address' 	   => $this->input->post('address',true),
						'cellphone'        => $this->input->post('cellphone',true),
						'homephone'       => $this->input->post('homephone', true),
						'city' 	   => $this->input->post('city',true),
						'state'        => $this->input->post('state',true),
						'zipcode'       => $this->input->post('zipcode', true),
						'career_title' => $this->input->post('career_title',true),
						'short_biography' => $this->input->post('short_biography',true),
						'specialist'   => $this->input->post('specialist', true),
						'degree'       => $this->input->post('degree',true)
					];

					$this->employee_model->create_lang($langData);

					/*-----------------------------*/
                    #set success message
                    $this->session->set_flashdata('message', "Employee successfully added to the system.");
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('human_resources/employee');
            } else {
            	//view section
							$data['title'] = display('add_employee');
                //$data['userRoles'] = $this->user_roles();
								  $data["isAdmin"] =  $this->session->userdata('isAdmin');
                $data['userRoles'] = $this->employee_model->user_roles();
								$data['branches'] = $this->main_department_model->read();
								$data['disciplines'] = $this->discipline_model->read();
                $data['content'] = $this->load->view('human_resources/form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            }

        }
        else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) {

							$langId = $this->employee_model->read_lang_by_employee_id($user_id)->id;

                if ($this->employee_model->update($postData)) {

									$langData = [
						'user_id'      => $user_id,
						'id' => $langId,
						'language'     => $this->session->userdata('tableLang'),
						'firstname'    => $this->input->post('firstname',true),
						'middlename'    => $this->input->post('middlename',true),
						'lastname' 	   => $this->input->post('lastname',true),
						'discipline'    => $this->input->post('discipline',true),
						'emContact'    => $this->input->post('emContact',true),
						'emPhone'    => $this->input->post('emPhone',true),
						'designation'  => $this->input->post('designation',true),
						'address' 	   => $this->input->post('address',true),
						'cellphone'        => $this->input->post('cellphone',true),
						'homephone'       => $this->input->post('homephone', true),
						'city' 	   => $this->input->post('city',true),
						'state'        => $this->input->post('state',true),
						'zipcode'       => $this->input->post('zipcode', true),
						'career_title' => $this->input->post('career_title',true),
						'short_biography' => $this->input->post('short_biography',true),
						'specialist'   => $this->input->post('specialist', true),
						'degree'       => $this->input->post('degree',true)
					];

					$this->employee_model->update_lang($langData);
                    #set success message
                    $this->session->set_flashdata('message', "Update successful.");
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('human_resources/employee/form/'.$postData['user_id']);
            } else {
            	//view section
								if($read == null){
										$data['module'] = display("employees");
		                $data['title'] = display('employee_edit');
										$data["isAdmin"] =  $this->session->userdata('isAdmin');
										$data['branches'] = $this->main_department_model->read();
		                $data['employee'] = $this->employee_model->read_by_id($user_id);
										$data['licenses'] = $this->license_model->read_by_employee_id($user_id);
										$data['licenseTypes'] = $this->license_type_model->read();
										$data['disciplines'] = $this->discipline_model->read();
		                $data['userRoles'] = $this->employee_model->user_roles();
		                $data['content'] = $this->load->view('human_resources/emp_edit',$data,true);
		                $this->load->view('layout/main_wrapper',$data);
								}

								else {
								  	$data['module'] = display("employees");
		                $data['title'] = 'Employee Information';
										$data['branches'] = $this->main_department_model->read();
		                $data['employee'] = $this->employee_model->read_by_id($user_id);
										$data['disciplines'] = $this->discipline_model->read();
										$data['licenses'] = $this->license_model->read_by_employee_id($user_id);
										$data['licenseTypes'] = $this->license_type_model->read();
		                $data['userRoles'] = $this->employee_model->user_roles();
		                $data['content'] = $this->load->view('human_resources/emp_read',$data,true);
		                $this->load->view('layout/main_wrapper',$data);
								}

            }
        }
        /*---------------------------------*/
	}

	public function add_language($user_id = null){
		$data['module'] = display("employees");
		$data['title'] = display('languages');
		#-------------------------------#
		$this->form_validation->set_rules('language', display('language') ,'required');
		$this->form_validation->set_rules('firstname', display('first_name') ,'required|max_length[50]');
		$this->form_validation->set_rules('lastname', display('last_name'),'required|max_length[50]');
		$this->form_validation->set_rules('designation', display('designation') ,'required|max_length[100]');
		$this->form_validation->set_rules('address', display('address'),'required|max_length[255]');
		$this->form_validation->set_rules('phone', display('phone'),'required|max_length[25]');
		$this->form_validation->set_rules('mobile', display('mobile'),'required|max_length[25]');
		$this->form_validation->set_rules('career_title', display('career_title'),'required|max_length[200]');
		$this->form_validation->set_rules('short_biography',display('short_biography'),'trim');
		$this->form_validation->set_rules('specialist', display('specialist'),'required|max_length[200]');
		#-------------------------------#

		$data['employee'] = (object)$postData = [
			'id'           => $this->input->post('id'),
			'user_id'      => $this->input->post('user_id',true),
			'language'     => $this->input->post('language',true),
			'firstname'    => $this->input->post('firstname',true),
			'lastname' 	   => $this->input->post('lastname',true),
			'designation'  => $this->input->post('designation',true),
			'address' 	   => $this->input->post('address',true),
			'phone'        => $this->input->post('phone',true),
			'mobile'       => $this->input->post('mobile', true),
			'career_title' => $this->input->post('career_title',true),
			'short_biography' => $this->input->post('short_biography',true),
			'specialist'   => $this->input->post('specialist', true),
			'degree'       => $this->input->post('degree',true)
		];
		#-------------------------------#

		if ($this->form_validation->run() === true) {

			#if empty $user_id then insert data
			if (empty($postData['id'])) {
				//check language exists
				$pos_res = $this->db->select('user_id, language')
							->from('user_lang')
							->where('user_id',$postData['user_id'])
							->where('language', $postData['language'])
							->get()
							->num_rows();
				if($pos_res > 0){
					#set exception message
					$this->session->set_flashdata('exception', display('language').' '.display('already_exists'));
					redirect('human_resources/employee/add_language/'.$postData['user_id']);
				}else{
					if ($this->employee_model->create_lang($postData)) {
					#set success message
					$this->session->set_flashdata('message',"Employee successfully added to the system.");
					} else {
						#set exception message
						$this->session->set_flashdata('exception', display('please_try_again'));
					}
					redirect('human_resources/employee/add_language/'.$postData['user_id']);
				}

			} else {
				if ($this->employee_model->update_lang($postData)) {

					#set success message
					$this->session->set_flashdata('message',"Update successful.");
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				}

				redirect('human_resources/employee/edit_lang/'.$postData['id']);
			}

		} else {
			$data['user'] = $this->employee_model->read_user_by_id($user_id);
			$data['languageList'] = $this->setting_model->languageList();
			$data['content'] = $this->load->view('human_resources/language_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		}
	}

	public function edit_lang($id = null){
		$data['module'] = display("employees");
		$data['title'] = display('employee_edit');
		$data['languageList'] = $this->setting_model->languageList();
        $data['employee'] = $this->employee_model->read_lang_by_id($id);
        $data['content'] = $this->load->view('human_resources/edit_language_form',$data,true);
        $this->load->view('layout/main_wrapper',$data);
	}

	public function profile($user_id = null){
		$data['module'] = display("employees");
		$data['title'] =  display('employee_information');
		#-------------------------------#
		$data['profile'] = $this->employee_model->read_by_id($user_id);
		$data['role_type'] = $this->employee_model->role_type($user_id);
		$data['content'] = $this->load->view('human_resources/profile',$data,true);
		$this->load->view('layout/profile_wrapper',$data);
	}
	public function user($user_id = null){
		$data['module'] = 'Users';
		$data['title'] =  'User Information';
		#-------------------------------#
		$data['profile'] = $this->employee_model->read_by_id($user_id);
		$data['role_type'] = $this->employee_model->role_type($user_id);
		$data['branches'] = $this->main_department_model->read();

		$data['content'] = $this->load->view('human_resources/user',$data,true);
		$this->load->view('layout/user_wrapper',$data);
	}

	public function delete($user_id = null, $user_role = null)
	{
		if ($this->employee_model->delete($user_id, $user_role)) {
			#set success message
			$this->session->set_flashdata('message', "Record deletion successful.");
		} else {
			#set exception message
			$this->session->set_flashdata('exception',display('please_try_again'));
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_lang($id = null)
	{
		if ($this->employee_model->delete_lang($id)) {
			#set success message
			$this->session->set_flashdata('message',"Record deletion successful.");
		} else {
			#set exception message
			$this->session->set_flashdata('exception',display('please_try_again'));
		}
		redirect($_SERVER['HTTP_REFERER']);
	}


	public function user_roles($user_role = null)
	{
		$user_list = array(
			'Admin'          => 1,
			'Doctor'         => 2,
			'Accountant'     => 3,
			'Laboratorist'   => 4,
			'Nurse'          => 5,
			'Pharmacist'     => 6,
			'Receptionist'   => 7,
			'Representative' => 8,
			'Case_manager'   => 9,
		);

		if (!empty($user_role)) {
			$user_role = ucfirst($user_role);
			if (array_key_exists($user_role, $user_list)) {
				return $user_list[$user_role];
			} else {
				return null;
			}
		} else {
			return array_flip($user_list);
		}

	}

	//change by user
	public function profile_edit()
	{
		$user_id       = $this->session->userdata('user_id');
		#-------------------------------#
		$this->form_validation->set_rules('firstname', display('first_name'),'required|max_length[50]');
		$this->form_validation->set_rules('lastname',display('last_name'),'required|max_length[50]');
		$this->form_validation->set_rules('email',display('email'), "required|max_length[50]|valid_email|callback_email_check[$user_id]");
		$this->form_validation->set_rules('password',display('password'),'required|max_length[32]|md5');
		$this->form_validation->set_rules('mobile',display('mobile'),'required|max_length[20]');
		$this->form_validation->set_rules('sex',display('sex'),'required|max_length[10]');
		$this->form_validation->set_rules('address',display('address'),'required|max_length[255]');
		$this->form_validation->set_rules('status',display('status'),'required');
		#-------------------------------#
		//picture upload
		$picture = $this->fileupload->do_upload(
			'assets/images/human_resources/',
			'picture'
		);
		// if picture is uploaded then resize the picture
		if ($picture !== false && $picture != null) {
			$this->fileupload->do_resize(
				$picture, 293, 350
			);
		}
		//if picture is not uploaded
		if ($picture === false) {
			$this->session->set_flashdata('exception', display('invalid_picture'));
		}
		#-------------------------------#
		$data['employee'] = (object)$postData = array(
			'user_id'      => $user_id,
			'firstname'    => $this->input->post('firstname'),
			'lastname' 	   => $this->input->post('lastname'),
			'email' 	   => $this->input->post('email'),
			'password' 	   => md5($this->input->post('password')),
			'mobile'       => $this->input->post('mobile'),
			'sex' 		   => $this->input->post('sex'),
			'address' 	   => $this->input->post('address'),
			'picture'      => (!empty($picture)?$picture:$this->input->post('old_picture')),
		);
		#-------------------------------#
        if ($this->form_validation->run() === true) {
            if ($this->employee_model->update($postData)) {
                #set success message
                $this->session->set_flashdata('message', "Update successful.");
            } else {
                #set exception message
                $this->session->set_flashdata('exception',display('please_try_again'));
            }
            redirect('dashboard/profile');
        } else {
        	//view section
        	$data['module'] = display("employees");
            $data['title'] = display('edit_profile');
            $data['employee'] = $this->employee_model->read_by_id($user_id);
            $data['userRoles'] = $this->user_roles();
            $data['content'] = $this->load->view('human_resources/profile_edit',$data,true);
            $this->load->view('layout/main_wrapper',$data);
        }
}
}

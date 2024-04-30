<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Episode extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'main_department_model',
			'service_provider_model',
			'episode_model',
			'service_model',
			'human_resources/employee_model',
			'patient_model',
			'human_resources/employee_model',
			'setting_model'
		));

		if ($this->session->userdata('isLogIn') == false)
		redirect('login');

	}

	public function patient_episodes($patientId){
		$data['module'] = "Patient Episodes";
		$data['title'] = "Patient Episode List";
		#-------------------------------#
		$data['episodes'] = $this->episode_model->read_all_by_patient_id($id);
	//	$data['lang_dprt'] = $this->main_department_model->read_lang_department();
		$data['content'] = $this->load->view('department/episode',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function services($episodeId, $patientId){
		$data['module'] = "Patient Services";
		$data['title'] = "Patient Services List";
		$patient = $this->patient_model->read_by_id($patientId);

		$data['patientName'] = $patient->firstname." ".$patient->lastname;

		#-------------------------------#
		$data['patientId'] = $patientId;
		$data['episodeServices'] = $this->service_provider_model->read_all_by_episode_id($episodeId);
		$data['content'] = $this->load->view('department/episode_services',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function read_services($episodeId, $patientId){
		$data['module'] = "Patient Services";
		$data['title'] = "Patient Services List";
		#-------------------------------#
		$data['patientId'] = $patientId;
		$patient = $this->patient_model->read_by_id($patientId);

		$data['patientName'] = $patient->firstname." ".$patient->lastname;
		$data['episodeServices'] = $this->service_provider_model->read_all_by_episode_id($episodeId);
		$data['content'] = $this->load->view('department/episode_services_read',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function index(){
		$data['module'] = "";
		$data['title'] = "Licenses List";
		#-------------------------------#
	//	$data['departments'] = $this->main_department_model->read();
	//	$data['lang_dprt'] = $this->main_department_model->read_lang_department();
		$data['content'] = $this->load->view('department/license',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

 	public function create(){
 		$data['module'] = "Episodes";
		$data['title'] = "Add Episode";
		#-------------------------------#
	//	$this->form_validation->set_rules('episodeTo', 'Episode to date' ,'required|max_length[100]');
		$this->form_validation->set_rules('episodeFrom', 'Episode from date', 'required');
		$this->form_validation->set_rules('serviceId1', 'Service Id' ,'required');
		$this->form_validation->set_rules('providerId1', 'Provider Id' ,'required');
		$this->form_validation->set_rules('patientId', 'Patient Id' ,'required');
		#-------------------------------#

		$date = new DateTime($this->input->post('episodeFrom',true));
		$date->add(new DateInterval('P59D'));
		$episodeTo = $date->format('Y-m-d');

		$fromDate = new DateTime($this->input->post('episodeFrom',true));

		$episodeFrom = $date->format('Y-m-d');

		$data['department'] = (object)$postData = [
			'id' 	     => $this->input->post('episodeId',true),
			'episodeTo' 		  => $episodeTo,
			'episodeFrom' => $episodeFrom,
			'patientId'      => $this->input->post('patientId',true)
		];
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $main_dprt_id then insert data
			if (empty($postData['id'])) {
				if ($this->episode_model->create($postData)) {
					$inserted_episode_id = $this->db->insert_id();
					$sData = [
							'episodeId' => $inserted_episode_id,
							'serviceId' => $this->input->post('serviceId1'),
							'providerId' => $this->input->post('providerId1'),
					];
					$this->service_provider_model->create($sData);

					if($this->input->post('providerId2') != 'w' && !empty($this->input->post('serviceId2'))){
						$sData2 = [
								'episodeId' => $inserted_episode_id,
								'serviceId' => $this->input->post('serviceId2'),
								'providerId' => $this->input->post('providerId2'),
						];
						$this->service_provider_model->create($sData2);
					}

					if($this->input->post('providerId3') != 'w' && !empty($this->input->post('serviceId3'))){
						$sData3 = [
								'episodeId' => $inserted_episode_id,
								'serviceId' => $this->input->post('serviceId3'),
								'providerId' => $this->input->post('providerId3'),
						];
						$this->service_provider_model->create($sData3);
					}

					#set success message
					$this->session->set_flashdata('message', 'Episode added Successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception',display('please_try_again'));
				}
				redirect('/patient/edit/'.$this->input->post('patientId'));
			} else {
				if ($this->episode_model->update($postData)) {
					#set success message

					$sData = [
							'id' => $this->input->post('serviceProviderId1'),
							'serviceId' => $this->input->post('serviceId1'),
							'providerId' => $this->input->post('providerId1'),
					];

					$this->service_provider_model->update($sData);

					//Update/ save patient service2

					if (empty($this->input->post('serviceProviderId2'))) {
							//Create service_provider record with current episode
							if($this->input->post('providerId2') != 'w' && !empty($this->input->post('serviceId2'))){
								$sData4 = [
										'episodeId' => $this->input->post('episodeId'),
										'serviceId' => $this->input->post('serviceId2'),
										'providerId' => $this->input->post('providerId2'),
								];
								$this->service_provider_model->create($sData4);

								}
					} else {

						if($this->input->post('providerId2') != 'w' && !empty($this->input->post('serviceId2'))){
							$sData5 = [
									'id' => $this->input->post('serviceProviderId2'),
									'serviceId' => $this->input->post('serviceId2'),
									'providerId' => $this->input->post('providerId2'),
							];
							$this->service_provider_model->update($sData2);
						}

					}

					//Update/ save patient service3

					if (empty($this->input->post('serviceProviderId3'))) {
							//Create service_provider record with current episode
							if($this->input->post('providerId3') != 'w' && !empty($this->input->post('serviceId3'))){
								$sData6 = [
										'episodeId' => $this->input->post('episodeId'),
										'serviceId' => $this->input->post('serviceId3'),
										'providerId' => $this->input->post('providerId3'),
								];
								$this->service_provider_model->create($sData6);

								}
					} else {
						if($this->input->post('providerId3') != 'w' && !empty($this->input->post('serviceId3'))){
							$sData7 = [
									'id' => $this->input->post('serviceProviderId3'),
									'serviceId' => $this->input->post('serviceId3'),
									'providerId' => $this->input->post('providerId3'),
							];
							$this->service_provider_model->update($sData7);
						}
					}


					$this->session->set_flashdata('message', 'Episode updated successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception',display('please_try_again'));
				}
				redirect('/patient/edit/'.$this->input->post('patientId'));
			}

		} else {
			$data['content'] = $this->load->view('department/certificate_form',$data,true);
	//	$this->session->set_flashdata('exception',display('please_try_again'));
		//	redirect('/patient/edit/'.$postData['patientId']);
			$this->load->view('layout/main_wrapper',$data);
		}
	}

	public function read($id = null){
		$data['module'] = 'Episode';
		$data['title'] = 'Episode Information';
		#-------------------------------#
		$data['episode'] = $this->episode_model->read_by_id($id);
		$data['services'] = $this->service_model->read();
		$data['episodeServices'] = $this->service_provider_model->read_all_by_episode_id($id);
		$data['content'] = $this->load->view('department/certificate_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function edit($id = null){
		$data['module'] = 'Episode';
		$data['title'] = 'Edit Episode';
		#-------------------------------#
		$data['episode'] = $this->episode_model->read_by_id($id);
		$data['services'] = $this->service_model->read();
		$data['employees'] = $this->employee_model->employees_list();

		$data['episodeServices'] = $this->service_provider_model->read_all_by_episode_id($id);
		$data['content'] = $this->load->view('department/certificate_form_edit',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function info($id = null){
		$data['module'] = 'Episode';
		$data['title'] = 'Episode Information';
		#-------------------------------#
		$data['episode'] = $this->episode_model->read_by_id($id);
		$data['episodeServices'] = $this->service_provider_model->read_all_by_episode_id($id);
		$data['content'] = $this->load->view('department/episode_info',$data,true);
		$this->load->view('layout/episode_wrapper',$data);
	}

	public function renew($episodeId = null){
		$data['module'] = 'Employee License';
		$data['title'] = 'Renew License';
		#-------------------------------#
		$episode = $this->episode_model->read_by_id($episodeId);
		$episodeTo = $episode->episodeTo;
		$episodeFrom = $episode->episodeTo;
		$date = new DateTime($episodeTo);
		$date->add(new DateInterval('P59D'));
		$newEpisodeTo = $date->format('d-m-Y');

		$episodeData = [
			'id' => $episodeId,
			'episodeTo' => $newEpisodeTo,
			'episodeFrom' => $episodeFrom
		];


		if($this->episode_model->update($episodeData)){
			$this->session->set_flashdata('message', 'Episode renewed successfully.');
		}else{
			$this->session->set_flashdata('message', 'An error occured. Please try again.');
		}
		redirect("patient/edit/$episode->patientId");
	}


	public function delete($id = null, $patientId)
	{
		if ($this->episode_model->delete($id)) {
			#set success message
			$this->session->set_flashdata('message', 'Episode deleted successfully.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('patient/edit/'.$patientId);
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

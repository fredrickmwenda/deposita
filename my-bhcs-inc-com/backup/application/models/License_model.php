<?php defined('BASEPATH') OR exit('No direct script access allowed');

class License_model extends CI_Model {

	private $table = 'license';

	public function __construct()
	{
		parent::__construct();
		$this->language = $this->input->cookie('Lng', true);
		$this->defualt = $this->db->get('setting')->row()->language;
	}

	public function create($data = [])
	{
		return $this->db->insert($this->table,$data);
	}

	public function get_employees_whose_licenses_due(){

			//1. Get all due licenses - from license table
			//1.1 Determine which employees they belong to - Join employee table
			//1.2 and display employee name
			//2. Get all employees
			//3. Match
			//4. Add match to a new array

			return $this->db->select("firstname, lastname")
				->from($this->table)

				->join('user', 'user_id = employeeId')
				->where('licDue BETWEEN now() and date_add(now(), interval 7 day)')
				->distinct()
				->get()
				->result();

	}


	public function read()
	{
		return $this->db->select("*")
			->from($this->table)
			->order_by('id','desc')
			->get()
			->result();
	}



	public function read_all()
	{
		return $this->db->select("main_department.id as mid, mdlang.*")
			->from('main_department_lang as mdlang')
			->join($this->table, 'main_department.id=mdlang.main_id', 'left')
			->where('mdlang.language', (!empty($this->language)?$this->language:$this->defualt))
			->order_by('mdlang.name','asc')
			->get()
			->result();
	}

	public function read_by_id($id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('id',$id)
			->get()
			->row();
	}

	public function read_by_employee_id($id = null)
	{
		return $this->db->select("*")
			->from('license')
			->where('employeeId',$id)
			->where('status',1)
			->get()
			->result();
	}

	public function read_all_by_employee_id($id = null)
	{
		return $this->db->select("license.*, user.firstname, user.lastname, user.user_id")
			->from('license')
			->join('user', 'user.user_id = license.employeeId', 'left')
			->where('employeeId',$id)
			->get()
			->result();
	}

	public function update($data = [])
	{
		return $this->db->where('id',$data['id'])
			->update($this->table,$data);
	}



	public function delete($id = null)
	{
		$this->db->where('id',$id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

 }

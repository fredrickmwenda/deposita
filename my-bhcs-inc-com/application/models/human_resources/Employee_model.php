<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

	private $table = "user";
	public function __construct()
	{
		parent::__construct();
		$this->language = $this->input->cookie('Lng', true);
		$this->defualt = $this->db->get('setting')->row()->language;
	}

	public function create($data = [])
	{
		$this->db->insert($this->table,$data);
		$insert_id = $this->db->insert_id();
        return  $insert_id;
	}
	public function create_role($data = []){
		return $this->db->insert('sec_userrole',$data);
	}



	public function create_lang($data = [])
	{
		return $this->db->insert('user_lang',$data);
	}

	public function read($user_type)
	{
		return $this->db->select("*, CONCAT_WS(' ', firstname, lastname) AS fullname, phone, address")
			->from($this->table)
			->where('user_role', $user_type)
			->order_by('user_id','desc')
			->get()
			->result();
	}
	public function employees_list(){
		$this->db->select('*');
        // $this->db->from('user');
				$this->db->join('user_lang', 'user.user_id = user_lang.user_id');
				$this->db->where('gen_role', 'employee');
				if (!$this->session->userdata('isAdmin')) {
					$this->db->where('branch', $this->session->userdata('branch'));
				}

				// $this->db->where('status', 1);
        $query = $this->db->get('user');
				// check the number of rows in the result set
				if ($query->num_rows() > 0) {
						// return the query result as array
						return $query->result();

				} else {
						// return the empty array if no row
						return array();
				}
	}

	public function filter_employees($status){
		// https://codeigniter.com/userguide3/database/query_builder.html#looking-for-similar-data

				$statusSearch;
				switch ($status) {
					case 'Active':
						$statusSearch = 1;
						break;
					case 'Inactive':
						$statusSearch = 0;
						break;

					default:
						// code...
						break;
				}

				$this->db->select('user.firstname, user.lastname, user.sex, user_lang.address, user_lang.cellphone');
				$this->db->join('user_lang', 'user.user_id = user_lang.user_id');
        $this->db->where('status', $statusSearch);
				if (!$this->session->userdata('isAdmin')) {
					$this->db->where('branch', $this->session->userdata('branch'));
				}
				$this->db->where('gen_role', 'employee');

        $query = $this->db->get('user');

        // check the number of rows in the result set
        if ($query->num_rows() > 0) {
            // return the query result as array
            return $query->result();

        } else {
            // return the empty array if no row
            return array();
        }
	}

	public function filter_users($status){
		// https://codeigniter.com/userguide3/database/query_builder.html#looking-for-similar-data

				$statusSearch;
				switch ($status) {
					case 'Active':
						$statusSearch = 1;
						break;
					case 'Inactive':
						$statusSearch = 0;
						break;

					default:
						// code...
						break;
				}

				$this->db->select('user.firstname, user.lastname, user.sex, user_lang.address, user.user_role, user.email, user_lang.cellphone');
				$this->db->join('user_lang', 'user.user_id = user_lang.user_id');
				$this->db->where('status', $statusSearch);
				if (!$this->session->userdata('isAdmin')) {
					$this->db->where('branch', $this->session->userdata('branch'));
				}
				$this->db->where('gen_role', 'user');

				$query = $this->db->get('user');

				// check the number of rows in the result set
				if ($query->num_rows() > 0) {
						// return the query result as array
						return $query->result();

				} else {
						// return the empty array if no row
						return array();
				}
	}

	public function users_list(){
		$this->db->select('user.firstname, user.lastname, user.sex, user_lang.address, user.user_role, user.email, user.user_id, user_lang.cellphone');
		$this->db->join('user_lang', 'user.user_id = user_lang.user_id');
				// $this->db->where('status', 1);
				if (!$this->session->userdata('isAdmin')) {
					$this->db->where('branch', $this->session->userdata('branch'));
				}
				$this->db->where('gen_role', 'user');
				$query = $this->db->get('user');

				if ($query->num_rows() > 0) {
						// return the query result as array
						return $query->result();

				} else {
						// return the empty array if no row
						return array();
				}
	}

	public function employees_lang(){

		if (!$this->session->userdata('isAdmin')) {
			return $this->db->select("user_lang.*, CONCAT_WS(' ', user.firstname, user.lastname) as fullname, address")
	              ->from('user_lang')
	              ->join('user', 'user.user_id=user_lang.user_id', 'left')
	              ->order_by('user_lang.user_id', 'asc')
								->where('branch', $this->session->userdata('branch'))
	              ->get()->result();
		}

		return $this->db->select("user_lang.*, CONCAT_WS(' ', user.firstname, user.lastname) as fullname, address")
              ->from('user_lang')
              ->join('user', 'user.user_id=user_lang.user_id', 'left')
              ->order_by('user_lang.user_id', 'asc')
              ->get()->result();


	}

	public function role_list(){
		$this->db->select('sec_userrole.*,sec_role.type');
        $this->db->from('sec_userrole');
        $this->db->join('sec_role', 'sec_userrole.roleid = sec_role.id');
        $this->db->join('user', 'sec_userrole.user_id = user.user_id');
        return $query = $this->db->get()->result();
	}
	public function user_roles(){
		return $this->db->select("*")
			->from('sec_role')
			->get()
			->result();
	}
	public function role_type($user_id){
		$this->db->select('sec_userrole.*,sec_role.type');
        $this->db->from('sec_userrole');
        $this->db->join('sec_role', 'sec_userrole.roleid = sec_role.id');
        $this->db->join('user', 'sec_userrole.user_id = user.user_id');
        $this->db->where('sec_userrole.user_id',$user_id);
        return $query = $this->db->get()->result();
	}

	public function read_by_id($user_id = null)
	{
		$this->db->select('*');
        $this->db->from('user');
        $this->db->join('sec_userrole', 'user.user_id = sec_userrole.user_id','left');
        $this->db->join('sec_role', 'sec_userrole.roleid = sec_role.id','left');
				$this->db->join('user_lang', 'user.user_id = user_lang.user_id','left');
        $this->db->where('user.user_id',$user_id);
        return $query = $this->db->get()->row();
	}

	public function read_profile_by_id($user_id = null)
	{
		$this->db->select('user_lang.*, user_lang.firstname as fname, user_lang.lastname as lname, user.*');
        $this->db->from('user_lang');
        $this->db->join('user', 'user.user_id = user_lang.user_id','left');
        $this->db->where('user.user_id',$user_id);
        $this->db->where('user_lang.language',(!empty($this->language)?$this->language:$this->defualt));
        return $query = $this->db->get()->row();
	}

	public function read_user_by_id($user_id = null)
	{
		$this->db->select('*');
        $this->db->from('user');
        $this->db->where('user_id',$user_id);
        return $query = $this->db->get()->row();
	}

	public function read_lang_by_id($id = null)
	{
		$this->db->select('*');
        $this->db->from('user_lang');
        $this->db->where('id',$id);
        return $query = $this->db->get()->row();
	}

	public function read_lang_by_employee_id($id = null)
	{
		$this->db->select('*');
				$this->db->from('user_lang');
				$this->db->where('user_id',$id);
				return $query = $this->db->get()->row();
	}

	public function update($data = [])
	{
		return $this->db->where('user_id',$data['user_id'])
			->update($this->table,$data);
	}

	public function update_lang($data = [])
	{
		return $this->db->where('id',$data['id'])
			->update('user_lang',$data);
	}

	public function delete($user_id = null){
		$this->db->where('user_id',$user_id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	public function delete_lang($id = null)
	{
		$this->db->where('id',$id)
			->delete('user_lang');
		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	// Search Employee headcode
	public function headcode(){
	    $query=$this->db->query("SELECT MAX(HeadCode) as HeadCode FROM acc_coa WHERE HeadLevel='4' And HeadCode LIKE '5020201%'");
	    return $query->row();
    }


		// search employee
		public function search_employee($searchText){
			return $this->db->select("*")
					->from($this->table)
					->like('firstname', $searchText)
					->or_like('lastname', $searchText)
					->or_like('user_id', $searchText)
					->or_like('CONCAT(firstname, " ", lastname)', $searchText)
					->get()
					->result();
		}
		function search_employee_req($query)
	 {

		$this->db->select("user_id, firstname, lastname");
		$this->db->from("user");
		if($query != '')
		{
			$this->db->group_start();
		 $this->db->like('firstname', $query);
		 $this->db->or_like('lastname', $query);
		 $this->db->or_like('user_id', $query);
		 $this->db->or_like('middlename', $query);
		 $this->db->or_like('CONCAT(firstname, " ", lastname)', $query);
		 $this->db->group_end();
		 $this->db->where('gen_role', 'employee');
		 $this->db->where('status', 1);
		}
		return $this->db->get();
	 }

    // insert employee coa info
    public function create_coa($data = [])
    {
        $this->db->insert('acc_coa',$data);
        return true;
    }


}

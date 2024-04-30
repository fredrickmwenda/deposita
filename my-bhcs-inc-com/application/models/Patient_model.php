<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_model extends CI_Model {

	private $table = "patient";

	public function create($data = []){
		return $this->db->insert($this->table,$data);
	}

	public function read()
	{
		if (!$this->session->userdata('isAdmin')) {
			return $this->db->select("*")
				->from($this->table)
				->where('status', 1)
				->where('branch_id', $this->session->userdata('branch'))
				->get()
				->result();
		}

		return $this->db->select("*")
			->from($this->table)
			->where('status', 1)
			->get()
			->result();
	}

	// search patient
	public function search_patient($searchText){
		return $this->db->select("*")
				->from($this->table)
				->like('firstname', $searchText)
				->or_like('lastname', $searchText)
				->or_like('patient_id', $searchText)
				->or_like('CONCAT(firstname, " ", lastname)', $searchText)
				->get()
				->result();
	}

	public function filter_patients($status){
		// https://codeigniter.com/userguide3/database/query_builder.html#looking-for-similar-data

				$statusSearch;
				switch ($status) {
					case 'Active':
						$statusSearch = 1;
						break;
					case 'Inactive':
						$statusSearch = 0;
						break;

					case 'DC':
						$statusSearch = 2;
						break;
					case 'Expired':
						$statusSearch = 3;
						break;
					default:
						// code...
						break;
				}

				if (!$this->session->userdata('isAdmin')) {
					$this->db->select("*");

						$this->db->where('status', $statusSearch);
						$this->db->where('branch_id', $this->session->userdata('branch'))
					;
				}

				 $this->db->select("*");

					$this->db->where('status', $statusSearch);

        $query = $this->db->get('patient');

        // check the number of rows in the result set
        if ($query->num_rows() > 0) {
            // return the query result as array
            return $query->result();

        } else {
            // return the empty array if no row
            return array();
        }
	}

	public function read_by_id($id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('id',$id)
			->get()
			->row();
	}

	public function getExistPatient($email){
		return $this->db->select("*")
			->from($this->table)
			->where('email',$email)
			->get()
			->row();
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

	public function headcode(){
	    $query=$this->db->query("SELECT MAX(HeadCode) as HeadCode FROM acc_coa WHERE HeadLevel='4' And HeadCode LIKE '1020302%'");
	    return $query->row();
    }

     public function create_coa($data = [])
    {
        $this->db->insert('acc_coa',$data);
        return true;
    }

}

<?php
abstract class DAO {
	protected $db;
	
	public function __construct() {
		$this->db = DBFactory::getPDOConnection();
	}
	
	// CRUD
	abstract public function create($object);
	abstract public function read($id);
	abstract public function update($object);
	abstract public function delete($object);
	
}
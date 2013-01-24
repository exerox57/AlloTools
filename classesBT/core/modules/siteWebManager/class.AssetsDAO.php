<?php
class AssetsDAO extends DAO{
	
	public function create($object) {
	
	}
	
	public function read($no) {
	
		$ligne1 = $this->db->prepare('SELECT * FROM jml_assets where id=?');
		$ligne1->bindParam(1, $no, PDO::PARAM_INT);
		$ligne1->execute();
		$ligne = $ligne1->fetch(PDO::FETCH_ASSOC);
		
		//return $ligne;
		return new Assets($ligne);
	}
	
	public function readAll(){
		$ligne1 = $this->db->prepare('SELECT * FROM jml_assets');
		$ligne1->execute();
		$ligne = $ligne1->fetch(PDO::FETCH_ASSOC);
		
		return new Assets($ligne);
	}
	
	public function update($object) {
	
	}
	
	public function delete($object) {
	
	}
}
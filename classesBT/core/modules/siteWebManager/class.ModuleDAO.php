<?php
class ModuleDAO extends DAO{
	
	public function create($object) {
	
	}
	
	//Retourne un Module spécifique
	//OK
	public function read($no) {
		$ligne1 = $this->db->prepare('SELECT * FROM jml_module where id=?');
		$ligne1->bindParam(1, $no, PDO::PARAM_INT);
		$ligne1->execute();
		$ligne = $ligne1->fetch(PDO::FETCH_ASSOC);
		
		//return $ligne;
		return new Module($ligne);
	}
	
	//Récuparation de la liste des ID Module
	public function findAllId() {
		$requete = $this->db->prepare('SELECT id FROM jml_module ORDER BY id');
		$requete->execute();
		$tableIdModule = $requete->fetchAll(PDO::FETCH_ASSOC);
		
		return $tableIdModule;
	}
	
	//vérifie la présence ou non de l'id dans la table
	public function exists($id) {
		$nb1 = $this->db->prepare('SELECT COUNT(*) AS nb FROM jml_module WHERE id=?');
		$nb1->bindParam(1, $id, PDO::PARAM_INT);
		$nb1->execute();
		$nb = $nb1->fetch(PDO::FETCH_ASSOC);
		
		return ($nb['nb'] == 1) ? true : false;
	}
	
	//Fonction d'Ajout / Mise à  jour d'un Module
	public function persist(Module $mod) {
		// Cas d'un update
		if($this->exists($mod->getId())) {
			$req = $this->db->prepare('
				UPDATE jml_module ct SET 
				title 			  = :title,
				position 		  = :position,
				module			  = :module,
				params 	 		  = :params,
				WHERE id = :id
			');
		
		}
		// Cas d'un insert
		else{
			$req = $this->db->prepare('
				INSERT INTO jml_module
				(id, title, position, module, jml_module.module, 
				jml_module.params)
				VALUES
				(:id, :title, :position, :module, :params)
			');
		}
		
		//Tableau de récupération des valeurs du param $cont
		//qui sont insérées dans la requete
		$creat = $cont->getCreated();
		$creat = '"'.$creat.'"';
		
		$array = array(
			'id' 				=> $cont->getId(),
			'title' 			=> $cont->getTitle() ,
			'position' 			=> $cont->getPosition() ,
			'module'	 		=> $cont->getModule(	) ,
			'params'			=> $cont->getParams() ,
			
		);
		//Execution de la requete
		return $req->execute($array);
	}
	
	//Override
	public function update($object) {
	
	}
	
	//Override
	public function delete($object) {
		$idSupp = $object->getId();
		if($this->exists($idSupp)) {
			$req = $this->db->prepare('DELETE FROM jml_module 
										WHERE id = ?'); 
			$req->bindParam(1, $idSupp, PDO::PARAM_INT);
			return $req->execute();
		}
	}
}
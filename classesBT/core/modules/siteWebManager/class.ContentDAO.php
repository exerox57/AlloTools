<?php
class ContentDAO extends DAO{
	
	public function create($object) {
	
	}
	
	//Retourne un Content spécifique
	//OK
	public function read($no) {
		$ligne1 = $this->db->prepare('SELECT * FROM jml_content where id=?');
		$ligne1->bindParam(1, $no, PDO::PARAM_INT);
		$ligne1->execute();
		$ligne = $ligne1->fetch(PDO::FETCH_ASSOC);
		
		//return $ligne;
		return new Content($ligne);
	}
	
	//Récuparation de la liste des ID Content
	public function findAllId() {
		$requete = $this->db->prepare('SELECT id FROM jml_content ORDER BY id');
		$requete->execute();
		$tableIdContent = $requete->fetchAll(PDO::FETCH_ASSOC);
		
		return $tableIdContent;
	}
	
	//vérifie la présence ou non de l'id dans la table
	public function exists($id) {
		$nb1 = $this->db->prepare('SELECT COUNT(*) AS nb FROM jml_content WHERE id=?');
		$nb1->bindParam(1, $id, PDO::PARAM_INT);
		$nb1->execute();
		$nb = $nb1->fetch(PDO::FETCH_ASSOC);
		
		return ($nb['nb'] == 1) ? true : false;
	}
	
	//Fonction d'Ajout / Mise à  jour d'un Content
	public function persist(Content $cont) {
		// Cas d'un update
		if($this->exists($cont->getId())) {
			$req = $this->db->prepare('
				UPDATE jml_content ct SET 
				title 			  = :title,
				alias 			  = :alias,
				introtext		  = :introtext,
				ct.fulltext 	  = :fulltext,
				state 			  = :state,
				ct.created 		  = :created,
				created_by 	  	  = :created_by
				WHERE id = :id
			');
		}
		// Cas d'un insert
		else{
			$req = $this->db->prepare('
				INSERT INTO jml_content
				(id, title, alias, introtext, jml_content.fulltext, state,
				jml_content.created, created_by)
				VALUES
				(:id, :title, :alias, :introtext, :fulltext,
				:state, :created, :created_by)
			');
		}
		
		//Tableau de récupération des valeurs du param $cont
		//qui sont insérées dans la requete
		$creat = $cont->getCreated();
		$creat = '"'.$creat.'"';
		
		$array = array(
			'id' 				=> $cont->getId(),
			'title' 			=> $cont->getTitle() ,
			'alias' 			=> $cont->getAlias() ,
			'introtext' 		=> $cont->getIntrotext() ,
			'fulltext'			=> $cont->getFulltext() ,
			'state' 			=> $cont->getState() ,
			'created' 			=> $creat,
			'created_by' 		=> $cont->getCreatedBy()
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
			$req = $this->db->prepare('DELETE FROM jml_content 
										WHERE id = ?'); 
			$req->bindParam(1, $idSupp, PDO::PARAM_INT);
			return $req->execute();
		}
	}
}
<?php
class MenuDAO extends DAO{
	
	public function create($object) {
	
	}
	
	//Retourne un Menu spécifique
	//OK
	public function read($no) {
		$ligne1 = $this->db->prepare('SELECT * FROM jml_menu where id=?');
		$ligne1->bindParam(1, $no, PDO::PARAM_INT);
		$ligne1->execute();
		$ligne = $ligne1->fetch(PDO::FETCH_ASSOC);
		
		//return $ligne;
		return new Menu($ligne);
	}
	
	//Retourne un tableau de Menu
	//A TESTER
	public function listeMenu(){
		//Selection des attributs importants pour l'utilisateur
		$ligne1 = $this->db->prepare('SELECT id, menutype, title, alias, link FROM jml_menu');
		$ligne1->execute();
		$ligne = $ligne1->fetch(PDO::FETCH_ASSOC);
		
		foreach($lignes as $ligne) {
			$menus[] = new Menu($donnees = array('id'=>(int) $ligne['id'], 'menutype' =>$ligne['menutype'], 'title'=>$ligne['title'], 'alias' =>$ligne['alias'], 'link' =>$ligne['link']));
		}
			
		return $menus;
	}
	
	
	 //Fonction qui renvoie true si l'enquête de début à déjà été remplie (ou en partie) et false sinon
	public function exists($id) {
		$nb1 = $this->db->prepare('SELECT COUNT(*) AS nb FROM jml_menu WHERE id=?');
		$nb1->bindParam(1, $id, PDO::PARAM_INT);
		$nb1->execute();
		$nb = $nb1->fetch(PDO::FETCH_ASSOC);
		return ($nb['nb'] == 1) ? true : false;
	}
	
	public function persist(Menu $menu) {
		// Cas d'un update
		//if($this->exists($menu->getId())) {
			$req = $this->db->prepare(
				'UPDATE jml_menu SET 
				id 				  = :id,
				menutype 		  = :menutype,
				title 			  = :title,
				alias 			  = :alias,
				note 			  = :note,
				path 			  = :path,
				link 			  = :link,
				type 			  = :type,
				published 		  = :published,
				parent_id 		  = :parent_id,
				level 			  = :level,
				img 			  = :img,
				template_style_id = :template_style_id
				WHERE id = :id
			');
		//}
		// Cas d'un insert
		//else {
		
			/*$req = $this->db->prepare('INSERT INTO jml_menu 
					(...)
					values
					(...)
					');*/
		//}
		//Tableau de récupération des valeurs du param $menu
		//qui sont insérées dans la requete
		$array = array(
			'id' 				=> $menu->getId() ,
			'menutype' 			=> $menu->getMenutype() ,
			'title' 			=> $menu->getTitle() ,
			'alias' 			=> $menu->getAlias() ,
			'note' 				=> $menu->getNote() ,
			'path' 				=> $menu->getPath() ,
			'link' 				=> $menu->getLink() ,
			'type' 				=> $menu->getType() ,
			'published' 		=> $menu->getPublished() ,
			'parent_id' 		=> $menu->getParentId() ,
			'level' 			=> $menu->getLevel() ,
			'img' 				=> $menu->getImg() ,
			'template_style_id' => $menu->getTemplateStyleId()
		);
		//Execution de la requete
		return $req->execute($array);
	}
	
	public function update($object) {
	
	}
	
	public function delete($object) {
	
	}
}
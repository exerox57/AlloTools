<?php

class SiteWebManager {
	
	/**
	 * Contient les rÃ©sultats à renvoyer à PHP
	 */
	private $result;
	
	/**
	 * Identifiant de la société à qui appartient le site
	 * @var string
	 */
	private $idRevend;
	
	/**
	* Liste des menus de la table Joomla
	*/
	private $menus;
	
	/**
	* Liste des articles de la table Joomla
	*/
	private $contents;
	
	/**
	 * Constructeur
	 * @param string $idRevend
	 */
	public function __construct($idRevend) {
		$this->idRevend = $idRevend;
		// TODO
	}
	
	/**
	 * Création d'une instance du module (préinitialisation)
	 * @param string $idRevend Identifiant de la société connectée
	 */
	public static function create($idRevend) {
		// Préinitialisation
		// ...
		// ... Gestion d'un autre paramètre, ou d'un objet englobant.... A voir en fonction de l'UML
		// ...
		return new SiteWebManager($idRevend);
	}
	
	/**
	 * Dispatcheur de commande
	 * @param string $cmd Nom de la fonction à exéctuer
	 * @param array $data Paramètre de la fonction à exécuter
	 */
	public function parseCommand($cmd, $data) {
		$this->result = array();
		if (!empty($cmd) && method_exists($this, $cmd)) {
			$res = call_user_func(array($this, $cmd), $data);
			if ($res === false) $this->result['error'] = 'Erreur : Problème avec la fonction '.$cmd.' de '.__CLASS__;
		}
		return $this->result;
	}
	
	
	/**
	 * Initialisation
	 * @param array $data
	 */
	public function init($data) {
	
		//------------RECUPERATION MENUS------------\\
		$menuDAO = new MenuDAO();

		$menuIds = $menuDAO->findAllId();
		$this->menus = array();
		foreach($menuIds as $id){
			$this->menus[] = $menuDAO->read($id['id']);
		}

		//Affichage des Menus (enfin du titre)
		for($i = 0; $i < count($this->menus); $i++){
			$pId = $this->menus[$i]->getParentId();

			//Classement parent/fils
			$this->result['listMenu'][] = array('id'=>$this->menus[$i]->getId(), 'lib'=>$this->menus[$i]->getAlias());
			for($j = 0; $j < count($this->menus); $j++){
				if($pId == $this->result['listMenu'][$j]['id']){
					$this->result['listMenu'][$j]['children'][] = array('id'=>$this->menus[$i]->getId(), 'lib'=>$this->menus[$i]->getAlias());
				}
			}
		}
		
		//------------RECUPERATION CONTENUS------------\\
		$contentDAO = new ContentDAO();

		$contentIds = $contentDAO->findAllId();
		$this->contents = array();
		foreach($contentIds as $id){
			$this->contents[] = $contentDAO->read($id['id']);
		}
		
		//Affichage des Contents (enfin du titre)
		for($i = 0; $i < count($this->contents); $i++){
			$this->result['listPage'][] = array('id'=>$this->contents[$i]->getId(), 'lib'=>$this->contents[$i]->getTitle());
		}
		
		
		$this->result['listModule'] = array();
	}
	
	/*
	* Retourne le Menu avec l'id recherché
	* @param int $id
	*/
	public function trouverMenu($id){
		$egale = false;
		$i = 0;
		while(!$egale){
			if($id == $this->menus[$i]->getId())
				$egale = true;
			else
				$i++;
		}
		return $this->menus[$i];
	}
	
	/*
	* Retourne l'Article avec l'id recherché
	* @param int $id
	*/
	public function trouverArticle($id){
		$egale = false;
		$i = 0;
		while(!$egale){
			if($id == $this->contents[$i]->getId())
				$egale = true;
			else
				$i++;
		}
		return $this->contents[$i];
	}
	
	/*
	* Affiche les details d'un Menu
	* et les renvois à $result['menu'] coté Flex
	* @param int $id
	*/
	public function openMenu($id){
		//Debug::F($id);
		$selectedMenu = $this->trouverMenu($id);
		$this->result['menu'] = array('titre'=>$selectedMenu->getTitle(), 'lien'=>$selectedMenu->getLink());
		//Affichage à completer
	}
	
	
	/*
	* Affiche les details d'un Article
	* et les renvois à $result['article'] coté Flex
	* @param int $id
	*/
	public function openArticle($id){
		//Debug::F($id);
		$selectedArticle = $this->trouverArticle($id);
		$this->result['article'] = array('titre'=>$selectedArticle->getTitle(), 'intro'=>$selectedArticle->getIntrotext(), 'contenu'=>$selectedArticle->getFulltext());
		//Affichage à completer
	}
	
	/*
	* Fonction de mise à jour d'un Article
	* @param Content $params
	*/
	public function updateArticle($params){
		$selectedArticle = $this->trouverArticle($params['id']);
		/*
			Procéder aux changements dans l'objet
			en récupérant les valeurs des textbox
		*/
		$selectedArticle->setTitle($params['titre']);
		$selectedArticle->setIntrotext($params['intro']);
		$selectedArticle->setFulltext($params['fulltext']);

		$articleDAO = new ContentDAO();
		if($articleDAO->persist($selectedArticle)){
			/*
				Message de confirmation
			*/
		}else{
			/*
				Message d'erreur
			*/
		}
	}
	
	/*
	* Fonction de mise à jour d'un Menu
	* @param Menu $arams
	*/
	public function updateMenu($params){
		$selectedMenu = $this->trouverMenu($params['id']);
		/*
			Procéder aux changements dans l'objet
			en récupérant les valeurs des textbox
		*/
		$selectedMenu->setTitle($params['titre']);
		$selectedMenu->setLink($params['lien']);

		$menuDAO = new MenuDAO();
		if($menuDAO->persist($selectedMenu)){
			
		}else{
			
		}
	}


	/*
	* Fonction de suppression d'un Menu
	* @param int $id
	*/
	public function supprimerMenu($id){
		$menu = $this->trouverMenu($id);
		$menuDAO = new MenuDAO();
		$menuDAO->delete($menu);
		//Retour message
	}
	
	
}
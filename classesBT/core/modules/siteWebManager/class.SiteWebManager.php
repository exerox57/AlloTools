<?php

class SiteWebManager {
	
	/**
	 * Contient les résultats � renvoyer � PHP
	 */
	private $result;
	
	/**
	 * Identifiant de la soci�t� � qui appartient le site
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
	 * Cr�ation d'une instance du module (pr�initialisation)
	 * @param string $idRevend Identifiant de la soci�t� connect�e
	 */
	public static function create($idRevend) {
		// Pr�initialisation
		// ...
		// ... Gestion d'un autre param�tre, ou d'un objet englobant.... A voir en fonction de l'UML
		// ...
		return new SiteWebManager($idRevend);
	}
	
	/**
	 * Dispatcheur de commande
	 * @param string $cmd Nom de la fonction � ex�ctuer
	 * @param array $data Param�tre de la fonction � ex�cuter
	 */
	public function parseCommand($cmd, $data) {
		$this->result = array();
		if (!empty($cmd) && method_exists($this, $cmd)) {
			$res = call_user_func(array($this, $cmd), $data);
			if ($res === false) $this->result['error'] = 'Erreur : Probl�me avec la fonction '.$cmd.' de '.__CLASS__;
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
			$this->result['listPage'][] = array('id'=>$this->menus[$i]->getId(), 'lib'=>$this->menus[$i]->getTitle());
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
		
		
		//Fils
		//$this->result['listPage'][4]['children'] = array(array('id'=>"75i", 'lib'=>'fggg'));
		
		$this->result['listModule'] = array();
	}
	
	/*
	* Retourne le Menu avec l'id recherch�
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
		return $i;
	}
	
	/*
	* Retourne l'Article avec l'id recherch�
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
	* et les renvois � $result['menu'] cot� Flex
	* @param int $id
	*/
	public function openMenu($id){
		//Debug::F($id);
		$selectedMenu = $this->trouverMenu($id);
		$this->result['menu'] = array('titre'=>$selectedMenu->getTitle(), 'contenu'=>$selectedMenu->getLink());
		//Affichage � completer
	}
	
	/*
	* Affiche les details d'un Article
	* et les renvois � $result['article'] cot� Flex
	* @param int $id
	*/
	public function openArticle($id){
		//Debug::F($id);
		$selectedArticle = $this->trouverArticle($id);
		$this->result['article'] = array('titre'=>$selectedArticle->getTitle(), 'contenu'=>$selectedArticle->getIntrotext());
		//Affichage � completer
	}
	
	/*
	* Fonction de mise � jour d'un Article
	* @param int $id
	*/
	public function updateArticle($id){
		$selectedArticle = $this->trouverArticle($id);
		/*
			Proc�der aux changements dans l'objet
			en r�cup�rant les valeurs des textbox
		*/
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
	* Fonction de mise � jour d'un Menu
	* @param int $id
	*/
	public function updateMenu($id){
		$selectedMenu = $this->trouverMenu($id);
		/*
			Proc�der aux changements dans l'objet
			en r�cup�rant les valeurs des textbox
		*/
		$menuDAO = new MenuDAO();
		if($menuDAO->persist($selectedMenu)){
			/*
				Message de confirmation
			*/
		}else{
			/*
				Message d'erreur
			*/
		}
	}
	
	
}
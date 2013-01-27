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
		$menus = array();
		foreach($menuIds as $id){
			$menus[] = $menuDAO->read($id['id']);
		}
		
		//Affichage des Menus (enfin du titre)
		for($i = 0; $i < count($menus); $i++){
			$this->result['listPage'][] = array('id'=>$menus[$i]->getId(), 'lib'=>$menus[$i]->getTitle());
		}
		
		//------------RECUPERATION CONTENUS------------\\
		$contentDAO = new ContentDAO();
		$contentDAO = new ContentDAO();

		$contentIds = $contentDAO->findAllId();
		$contents = array();
		foreach($contentIds as $id){
			$contents[] = $contentDAO->read($id['id']);
		}
		
		//Affichage des Contents (enfin du titre)
		for($i = 0; $i < count($contents); $i++){
			$this->result['listPage'][] = array('id'=>$contents[$i]->getId(), 'lib'=>$contents[$i]->getTitle());
		}
		
		
		//Fils
		//$this->result['listPage'][4]['children'] = array(array('id'=>"75i", 'lib'=>'fggg'));
		
		$this->result['listModule'] = array();
	}
	
	public function openArticle($id){
		Debug::F($id);
		$this->result['article'] = array('titre'=>'MON TITRE', 'contenu'=>'blabla');
	
	}
	
}
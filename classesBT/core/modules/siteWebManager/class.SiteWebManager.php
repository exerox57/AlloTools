<?php

class SiteWebManager {
	
	/**
	 * Contient les résultats à renvoyer à PHP
	 */
	private $result;
	
	/**
	 * Identifiant de la société qui appartient le site
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
	 * Création d'une instance du module (préinitialisation)
	 * @param string $idRevend Identifiant de la société connectée
	 */
	public static function create($idRevend) {
		// Préinitialisation
		// ...
		// ... Gestion d'un autre paramêtre, ou d'un objet englobant.... A voir en fonction de l'UML
		// ...
		return new SiteWebManager($idRevend);
	}
	
	/**
	 * Dispatcheur de commande
	 * @param string $cmd Nom de la fonction à exéctuer
	 * @param array $data Paramêtre de la fonction à exécuter
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
	
		//Test avec BDD
		$aDAO = new MenuDAO();
		//var $i = 3;
		$tx = '';
		
		$this->result['listPage'] = array();
		
		for($i = 1; $i < 15; $i++){
			$a = $aDAO->read($i);
			$n = $a->getTemplateStyleId();
			$this->result['listPage'][] = array('id'=>"$i", 'lib'=>$n);
		}
		
		//Test Update
		/*
		$m1 = $aDAO->read(21);
		$m1->setId(102);
		$resultat = $aDAO->persist($m1);*/
		
		//Test Insert
		/*$m1 = $aDAO->read(101);
		$m1->setId(103);
		$resultat = $aDAO->persist($m1);*/
		
		//Test Delete
		/*$m1 = $aDAO->read(102);
		$res = $aDAO->delete($m1);*/
		
		//Fils
		//$this->result['listPage'][4]['children'] = array(array('id'=>"75i", 'lib'=>'fggg'));
		
		$this->result['listModule'] = array();
	}
	
	public function openArticle($id){
		Debug::F($id);
		$this->result['article'] = array('titre'=>'MON TITRE', 'contenu'=>'blabla');
	
	}
	
}
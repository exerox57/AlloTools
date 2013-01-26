<?php 

class Content {
	
	private $id,
			$title,
			$alias,
			$introtext,
			$fulltext,
			$state,
			$created,
			$created_by
	;
	
	public function __construct(array $valeurs) {

		foreach ($valeurs as $key => $value) {
			$setter1 = ucfirst($key);
			$setter2 = explode('_', $setter1);
			$setter = '';
			foreach($setter2 as $s) {
				$setter .= ucfirst($s);
			}
			$setter = 'set'. $setter;
		
			if (method_exists($this, $setter))
				$this->$setter($value);
		}
	}
		
	//ID
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
			$this->id = $id;
	}
	//TITLE
	public function getTitle() {
		return $this->title;
	}
	public function setTitle($Title) {
			$this->title = $Title;
	}
	//ALIAS
	public function getAlias() {
		return $this->alias;
	}
	public function setAlias($a) {
			$this->alias = $a;
	}
	//INTRO_TEXT
	public function getIntrotext() {
		return $this->introtext;
	}
	public function setIntrotext($int) {
			$this->introtext = $int;
	}
	//FULL_TEXT
	public function getFulltext() {
		return $this->fulltext;
	}
	public function setFulltext($ft) {
			$this->fulltext = $ft;
	}
	//STATE
	public function getState() {
		return $this->state;
	}
	public function setState($st) {
			$this->state = $st;
	}
	//CREATED
	public function getCreated() {
		return $this->created;
	}
	public function setCreated($c) {
			$this->created = $c;
	}
	//CREATED_BY
	public function getCreatedBy() {
		return $this->created_by;
	}
	public function setCreatedBy($cb) {
			$this->created_by = $cb;
	}

}
?>
<?php 

class Assets {
	
	private  $name;
	
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
		
	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
			$this->name = $name;
	}
}
?>
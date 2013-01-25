<?php 

class Menu {
	
	private $id,
			$menutype,
			$title,
			$alias,
			$note,
			$path,
			$link,
			$type,
			$published,
			$parent_id,
			$level,
			$img,
			$template_style_id
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
		
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
			$this->id = $id;
	}
	public function getMenutype() {
		return $this->menutype;
	}
	
	public function setMenutype($mt) {
			$this->menutype = $mt;
	}
	public function getTitle() {
		return $this->title;
	}
	
	public function setTitle($Title) {
			$this->title = $Title;
	}
	public function getAlias() {
		return $this->alias;
	}
	
	public function setAlias($alias) {
			$this->alias = $alias;
	}
	public function getNote() {
		return $this->note;
	}
	
	public function setNote($note) {
			$this->note = $note;
	}
	public function getPath() {
		return $this->path;
	}
	
	public function setPath($path) {
			$this->path = $path;
	}
	public function getLink() {
		return $this->link;
	}
	
	public function setLink($link) {
			$this->link = $link;
	}
	public function getType() {
		return $this->type;
	}
	
	public function setType($type) {
			$this->type = $type;
	}
	public function getPublished() {
		return $this->published;
	}
	
	public function setPublished($published) {
			$this->published = $published;
	}
	public function getParentId() {
		return $this->parent_id;
	}
	
	public function setParentId($parent_id) {
			$this->parent_id = $parent_id;
	}
	public function getLevel() {
		return $this->level;
	}
	
	public function setLevel($level) {
			$this->level = $level;
	}
	public function getImg() {
		return $this->img;
	}
	
	public function setImg($img) {
			$this->img = $img;
	}
	public function getTemplateStyleId() {
		return $this->template_style_id;
	}
	
	public function setTemplateStyleId($template_style_id) {
			$this->template_style_id = $template_style_id;
	}
	
}
?>
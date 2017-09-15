<?php 
abstract class Pluriel {
	private $TB ; // peut être mis en Public si besoin est
	
	//---------- constructeur
	public function __construct () { $this->TB = array() ;}
	
	public function getArray() {return $this->TB;}

	//---------- renvoie le nombre d'elements dans la liste
	public function getNombre() { return count($this->TB) ; }
	
	//---------- renvoie l'objet correspondant à l'ID (peut renvoyer null)
	public function getObject($sonId) {
		if (!$this->isKey($sonId)) {return null;}
		return $this->TB[$sonId];
	}
	
	//---------- renvoie la première valeur. NON SECURISE
	public function getFirst() {
		return array_values($this->TB)[0] ;
	}
	
	//---------- mémorisation dans le TB associatif de l'objet avec son ID
	public function doAddObject(Element $objElement) {		
		$this->TB[$objElement->getID()] = $objElement ;
	}
	
	//---------- renvoie true si le paramètre est KEY dans le TB associatif
	public function isKey($id) {
		return array_key_exists($id, $this->TB) ;
	}
	
	//---------- effacement de la liste
	public function clear() {array_splice($this->TB,0) ; }
	
  
}
?>
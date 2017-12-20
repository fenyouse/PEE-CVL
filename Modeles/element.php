<?php
//---------- Classe de base de toutes les classes "METIER"
abstract class Element {

	private $ligne ; // stockage des données de l'instance, issues de la BDD

	//---------- constructeur
	protected function __construct($theLigne) {$this->ligne = $theLigne;}

	//---------- renvoie la valeur du champ spécifié en paramètre
	protected function getField($nom) { return $this->ligne[$nom] ; }

	//---------- renvoie l'ID.
	public function getID()           { return $this->ligne[static::champID()]; }

	//---------- renvoie le getselect suivi de 'WHERE condition sur clé primaire'
	public static function getSELECTOne() {
		return static::getSELECT().' WHERE '.static::champID().'=?';
	}

	/******************************
	IMPORTANT : 	toute classe dérivée non abstraite doit avoir le code pour
	public static function champID() {  }
	public static function getSELECT() {return 'SELECT ......';  }
	******************************/
}

?>

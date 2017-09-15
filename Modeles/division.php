<?php 
//---------- Classe Candidat
require_once 'Modeles/element.php';
require_once 'Modeles/pluriel.php';

class Division extends Element{

	//Singleton de mémorisation des instances
	private static $o_INSTANCES;
	public static function ajouterObjet($ligne){
		//créer (instancier) la liste si nécessaire
		if (static::$o_INSTANCES ==null){static::$o_INSTANCES = new Divisions();}
		//voir si l'objet existe avec la clef
		$tmp = static::$o_INSTANCES->getObject($ligne[static::champID()]);
		if($tmp!=null){return $tmp;}
		//n'existe pas : donc INSTANCIER Catégorie et mémoriser
		$tmp = new Division($ligne);
		static::$o_INSTANCES->doAddObject($tmp);
		return $tmp;
	}
	
	//publication liste instances
	public static function getInstances(){
		if (static::$o_INSTANCES ==null){static::$o_INSTANCES = new Divisions();}
		return static::$o_INSTANCES;
	}
		
	// doit impérativement trouver la categorie ayant pour id le paramètre
	public static function mustFind($id){
		if (static::$o_INSTANCES == null){static::$o_INSTANCES = new Divisions();}
		// regarder si instance existe
		$tmp = static::$o_INSTANCES->getObject($id);
		if($tmp!=null) {return $tmp;}
		//sinon pas trouver; chercher dans la BDD
		$req = static::getSELECT().' where DCode =?';
		echo "<br/>recherche $id";
		$ligne = SI::getSI()->SGBDgetLigne($req, $id);
		return static::ajouterObjet($ligne);
	}
	
	private $o_MesDivisions;
	
	//---------- constructeur : repose sur le constructeur parent
	protected function __construct($theLigne) {parent::__construct($theLigne);}
	
	//---------- renvoie la valeur du champ spécifié en paramètre
	public function getDCode(){
		return $this->getField('DCode');
	}
	

	
	public function getDivisions(){
		if($this->o_MesDivisions == null){
			$this->o_MesDivisions = new Divisions();
			$this->o_MesDivisions->remplir('PDTDCode="'.$this->getDCode().'"',null);
		}
		return $this->o_MesDivisions;
	}
	
	public function displayRow(){
		
		echo '<tr>';
		echo '<td>'.$this->getDCode().'</td>';
		//$this->getDivisions()->displayTable();
		echo '</tr>';
	
		
	}
	
	

	/******************************
	IMPORTANT : 	toute classe dérivée non abstraite doit avoir le code pour

	******************************/
	public static function champID() {return 'DCode';}
	public static function getSELECT() {return 'SELECT DCode  FROM divis';  }	


}

class Divisions extends Pluriel{

	//constructeur
	public function __construct(){
		parent::__construct();
	}
	
	public function remplir($condition=null, $ordre=null) {
		$req = Division::getSELECT();
		//ajouter condition si besoin est
		if ($condition != null) {
			$req.= " WHERE $condition"; // remplace $condition car guillemet et pas simple quote
		}
		if ($ordre != null){
			$req.=" ORDER BY $ordre";
		}
		
		//echo $req;
		
		//remplir à partir de la requete
		$curseur = SI::getSI()->SGBDgetPrepareExecute($req);
		//var_dump($curseur);
		foreach ($curseur as $uneLigne){
			$this->doAddObject(Division::ajouterObjet($uneLigne));
		}
	}
	
	public function displayTable(){
		echo'<center>';
		echo'<table border=1px>';
		// dire à chaque élément de mon tableau : afficher le row
		foreach ($this->getArray() as $unedivis) {
			$unedivis->displayRow();
		}
		echo '</table>';
		echo'</center>';
	}
	
	public function SELECT(){
		echo'<select>';
		// dire à chaque élément de mon tableau : afficher le row
		foreach ($this->getArray() as $unedivis) {
			$unedivis->option();
		}
		echo '</select>';
	}
	
}
?>
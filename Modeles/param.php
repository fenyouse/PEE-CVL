<?php 
//---------- Classe param
require_once 'Modeles/element.php';
require_once 'Modeles/pluriel.php';

class Param extends Element{

	//Singleton de mémorisation des instances
	private static $o_INSTANCES;
	public static function ajouterObjet($ligne){
		//créer (instancier) la liste si nécessaire
		if (static::$o_INSTANCES ==null){static::$o_INSTANCES = new Params();}
		//voir si l'objet existe avec la clef
		$tmp = static::$o_INSTANCES->getObject($ligne[static::champID()]);
		if($tmp!=null){return $tmp;}
		//n'existe pas : donc INSTANCIER Param et mémoriser
		$tmp = new Param($ligne);
		static::$o_INSTANCES->doAddObject($tmp);
		return $tmp;
	}
	
	//publication liste instances
	public static function getInstances(){
		if (static::$o_INSTANCES ==null){static::$o_INSTANCES = new Params();}
		return static::$o_INSTANCES;
	}
		
	// doit impérativement trouver la Param ayant pour id le paramètre
	public static function mustFind($id){
		if (static::$o_INSTANCES == null){static::$o_INSTANCES = new Params();}
		// regarder si instance existe
		$tmp = static::$o_INSTANCES->getObject($id);
		if($tmp!=null) {return $tmp;}
		//sinon pas trouver; chercher dans la BDD
		$req = static::getSELECT().' where PChoix =?';
		echo "<br/>recherche $id";
		$ligne = SI::getSI()->SGBDgetLigne($req, $id);
		return static::ajouterObjet($ligne);
	}
	
	private $o_MesElecteurs;
	
	//---------- constructeur : repose sur le constructeur parent
	protected function __construct($theLigne) {parent::__construct($theLigne);}
	
	//---------- renvoie la valeur du champ spécifié en paramètre
	public function getPChoix(){
		return $this->getField('PChoix');
	}
	
	public function getPDateDeb(){
		return $this->getField('PDateDeb');
	}
	
	public function getPDateFin(){
		return $this->getField('PDateFin');
	}
	
	public function getPBlancs(){
		return $this->getField('PBlancs');
	}
	
	public function getPNuls(){
		return $this->getField('PNuls');
	}
	
	
	public function getParams(){
		if($this->o_MesParams == null){
			$this->o_MesParams = new Params();
			$this->o_MesParams->remplir('PDTPChoix="'.$this->getPChoix().'"',null);
		}
		return $this->o_MesParams;
	}
	
	public function displayRow(){
		
		echo '<tr>';
		echo '<td>'.$this->getPChoix().'</td>';
		echo '<td>'.$this->getPDateDeb().'</td>';
		echo '<td>'.$this->getPDateFin().'</td>';
		echo '<td>'.$this->getPBlancs().'</td>';
		echo '<td>'.$this->getPNuls().'</td>';
		//$this->getParams()->displayTable();
		echo '</td>';
		echo '</tr>';
	
		
	}
	
	

	/******************************
	IMPORTANT : 	toute classe dérivée non abstraite doit avoir le code pour

	******************************/
	public static function champID() {return 'PChoix';}
	public static function getSELECT() {return 'SELECT PChoix,PDateDeb,PDateFin,PBlancs,PNuls FROM param';  }	


}

class Params extends Pluriel{

	//constructeur
	public function __construct(){
		parent::__construct();
	}
	
	public function remplir($condition=null, $ordre=null) {
		$req = Param::getSELECT();
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
			$this->doAddObject(Param::ajouterObjet($uneLigne));
		}
	}
	
	public function displayTable(){
		echo'<center>';
		echo'<table border=1px>';
		// dire à chaque élément de mon tableau : afficher le row
		foreach ($this->getArray() as $unparam) {
			$unparam->displayRow();
		}
		echo '</table>';
		echo'</center>';
	}
	
	public function SELECT(){
		echo'<select>';
		// dire à chaque élément de mon tableau : afficher le row
		foreach ($this->getArray() as $unparam) {
			$unparam->option();
		}
		echo '</select>';
	}
	
}
?>
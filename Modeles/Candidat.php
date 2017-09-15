<?php 
//---------- Classe Candidat
require_once 'Modeles/element.php';
require_once 'Modeles/pluriel.php';

class Candidat extends Element{

	//Singleton de mémorisation des instances
	private static $o_INSTANCES;
	public static function ajouterObjet($ligne){
		//créer (instancier) la liste si nécessaire
		if (static::$o_INSTANCES ==null){static::$o_INSTANCES = new Candidats();}
		//voir si l'objet existe avec la clef
		$tmp = static::$o_INSTANCES->getObject($ligne[static::champID()]);
		if($tmp!=null){return $tmp;}
		//n'existe pas : donc INSTANCIER Catégorie et mémoriser
		$tmp = new Candidat($ligne);
		static::$o_INSTANCES->doAddObject($tmp);
		return $tmp;
	}
	
	//publication liste instances
	public static function getInstances(){
		if (static::$o_INSTANCES ==null){static::$o_INSTANCES = new Candidats();}
		return static::$o_INSTANCES;
	}
		
	// doit impérativement trouver la categorie ayant pour id le paramètre
	public static function mustFind($id){
		if (static::$o_INSTANCES == null){static::$o_INSTANCES = new Candidats();}
		// regarder si instance existe
		$tmp = static::$o_INSTANCES->getObject($id);
		if($tmp!=null) {return $tmp;}
		//sinon pas trouver; chercher dans la BDD
		$req = static::getSELECT().' where CId =?';
		echo "<br/>recherche $id";
		$ligne = SI::getSI()->SGBDgetLigne($req, $id);
		return static::ajouterObjet($ligne);
	}
	
	private $o_MesProduits;
	
	//---------- constructeur : repose sur le constructeur parent
	protected function __construct($theLigne) {parent::__construct($theLigne);}
	
	//---------- renvoie la valeur du champ spécifié en paramètre
	public function getCId(){
		return $this->getField('CId');
	}
	
	public function getCIdBinome(){
		return $this->getField('CIdBinome');
	}
	
	public function getCNbV(){
		return $this->getField('CNbV');
	}
	
	public function getCandidats(){
		if($this->o_MesCandidats == null){
			$this->o_MesCandidats = new Candidats();
			$this->o_MesCandidatss->remplir('PDTCId="'.$this->getCId().'"',null);
		}
		return $this->o_MesCandidats;
	}
	
	public function displayRow(){
		
		echo '<tr>';
		echo '<td>'.$this->getCId().'</td>';
		echo '<td>'.$this->getCIdBinome().'</td>';
		echo '<td>'.$this->getCNbV().'</td>';
		//$this->getCandidats()->displayTable();
		echo '</td>';
		echo '</tr>';
	
		
	}
	
	

	/******************************
	IMPORTANT : 	toute classe dérivée non abstraite doit avoir le code pour

	******************************/
	public static function champID() {return 'CId';}
	public static function getSELECT() {return 'SELECT CId,CIdBinome,CNbV FROM candid';  }	


}

class Candidats extends Pluriel{

	//constructeur
	public function __construct(){
		parent::__construct();
	}
	
	public function remplir($condition=null, $ordre=null) {
		$req = Candidat::getSELECT();
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
			$this->doAddObject(Candidat::ajouterObjet($uneLigne));
		}
	}
	
	public function displayTable(){
		echo'<center>';
		echo'<table border=1px>';
		// dire à chaque élément de mon tableau : afficher le row
		foreach ($this->getArray() as $uncandid) {
			$uncandid->displayRow();
		}
		echo '</table>';
		echo'</center>';
	}
	
	public function SELECT(){
		echo'<select>';
		// dire à chaque élément de mon tableau : afficher le row
		foreach ($this->getArray() as $uneCateg) {
			$uneCateg->option();
		}
		echo '</select>';
	}
	
}
?>
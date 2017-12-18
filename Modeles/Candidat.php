<?php 
//---------- Classe Candidat


class Candidat extends Element{

	//Singleton de mémorisation des instances
	private static $o_INSTANCES;
	public static function ajouterObjet($ligne){
		//créer (instancier) la liste si nécessaire
		if (static::$o_INSTANCES ==null){static::$o_INSTANCES = new Candidats();}
		//voir si l'objet existe avec la clef
		$tmp = static::$o_INSTANCES->getObject($ligne[static::champID()]);
		if($tmp!=null){return $tmp;}
		//n'existe pas : donc INSTANCIER Candidat et mémoriser
		$tmp = new Candidat($ligne);
		static::$o_INSTANCES->doAddObject($tmp);
		return $tmp;
	}
	
	//publication liste instances
	public static function getInstances(){
		if (static::$o_INSTANCES ==null){static::$o_INSTANCES = new Candidats();}
		return static::$o_INSTANCES;
	}
		
	// doit impérativement trouver la candidat ayant pour id le paramètre
	public static function mustFind($id){
		if (static::$o_INSTANCES == null){static::$o_INSTANCES = new Candidats();}
		// regarder si instance existe
		$tmp = static::$o_INSTANCES->getObject($id);
		if($tmp!=null) {return $tmp;}
		//sinon pas trouver; chercher dans la BDD
		$req = static::getSELECT().' where CId =?';
		//echo "<br/>recherche $id";
		$ligne = SI::getSI()->SGBDgetLigne($req, $id);
		return static::ajouterObjet($ligne);
	}
	
	private $o_Meselecteurs;
	
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
		if($this->o_Meselecteurs == null){
			$this->o_Meselecteurs = new Electeurs();
			$this->o_Meselecteurs->remplir('EId="'.$this->getCId().'"',null);
		}
		return $this->o_Meselecteurs;
	}
	
	public function displayRow(){
		echo '<tr>';
		echo '<td>'.$this->getCId().'</td>';
		echo '<td>'.$this->getCIdBinome().'</td>';
		echo '<td>'.$this->getCNbV().'</td>';
		echo '</td>';
		echo '</tr>';

	}
	
	public function displayRow2(){
		echo '<tr>';
		echo '<td>'.$this->getCId().'</td>';
		echo '<td>'.$this->getCIdBinome().'</td>';
		echo '</td>';
		echo '</tr>';

	}
	

	/******************************
	IMPORTANT : 	toute classe dérivée non abstraite doit avoir le code pour

	******************************/
	public static function champID() {return 'CId';}
	public static function getSELECT() {return 'SELECT CId,CIdBinome,CNbV,CIdSuffrage FROM candid';  }	

	//renregistre le nouveau candidat et son binôme
	public static function SQLInsert(array $valeurs){
		$req = 'INSERT INTO candid (CId,CIdBinome,CIdSuffrage) VALUES(?,?,?)';
		return SI::getSI()->SGBDexecuteQuery($req,$valeurs);
	}
	
	//permet de modifier un candidat
	public static function SQLUpdate(array $valeurs){
		$req = 'UPDATE candid SET CId=?, CIdBinome=?, CNbV=?, CIdSuffrage=?,WHERE CId=?';
		return SI::getSI()->SGBDexecuteQuery($req,$valeurs);
	}

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
	
	public function displayTable2(){
		echo'<center>';
		echo'<table class="table table-striped table-dark" border=1px>';
		echo'<tr>';
		echo'<th> Id candidat</th>';
		echo'<th> Id binôme </th>';
		echo'</tr>';
		// dire à chaque élément de mon tableau : afficher le row
		foreach ($this->getArray() as $uncandid) {
			$uncandid->displayRow2();
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
<?php 
//---------- Classe division


class Division extends Element{

	//Singleton de mémorisation des instances
	private static $o_INSTANCES;
	public static function ajouterObjet($ligne){
		//créer (instancier) la liste si nécessaire
		if (static::$o_INSTANCES ==null){static::$o_INSTANCES = new Divisions();}
		//voir si l'objet existe avec la clef
		$tmp = static::$o_INSTANCES->getObject($ligne[static::champID()]);
		if($tmp!=null){return $tmp;}
		//n'existe pas : donc INSTANCIER Division et mémoriser
		$tmp = new Division($ligne);
		static::$o_INSTANCES->doAddObject($tmp);
		return $tmp;
	}
	
	//publication liste instances
	public static function getInstances(){
		if (static::$o_INSTANCES ==null){static::$o_INSTANCES = new Divisions();}
		return static::$o_INSTANCES;
	}
		
	// doit impérativement trouver la Division ayant pour id le paramètre
	public static function mustFind($id){
		if (static::$o_INSTANCES == null){static::$o_INSTANCES = new Divisions();}
		// regarder si instance existe
		$tmp = static::$o_INSTANCES->getObject($id);
		if($tmp!=null) {return $tmp;}
		//sinon pas trouver; chercher dans la BDD
		$req = static::getSELECT().' where DCode =?';
		//echo "<br/>recherche $id";
		$ligne = SI::getSI()->SGBDgetLigne($req, $id);
		return static::ajouterObjet($ligne);
	}
	
	private $o_MesElecteurs;
	//---------- constructeur : repose sur le constructeur parent
	protected function __construct($theLigne) {parent::__construct($theLigne);}
	
	//---------- renvoie la valeur du champ spécifié en paramètre
	public function getDCode(){
		return $this->getField('DCode');
	}
	
	public function getElecteurs(){
		if($this->o_MesElecteurs == null){
			$this->o_MesElecteurs = new Electeurs();
			$this->o_MesElecteurs->remplir('EIdDivis="'.$this->getDCode().'"',null);
		}
		return $this->o_MesElecteurs;
	}
	
	//affiche
	public function displayRow(){
		echo '<tr>';
		echo '<td td align="center">'.$this->getDCode().'</td>';
		echo '</tr>';
	}
	
	public function option(){
		$tmp = $this->getDCode();
		echo '<option value ="'.$tmp.'">';
		echo $this->getDCode();
		echo '</option>';

	}
	

	/******************************
	IMPORTANT : 	toute classe dérivée non abstraite doit avoir le code pour

	******************************/
	public static function champID() {return 'DCode';}
	public static function getSELECT() {return 'SELECT DCode FROM divis';  }	

	public static function SQLInsert(array $valeurs){
		$req = 'INSERT INTO divis (DCode) VALUES(?)';
		return SI::getSI()->SGBDexecuteQuery($req,$valeurs);
	}
	
	public static function SQLDelete($valeur){
		$req = 'DELETE FROM divis WHERE DCode = ?';
		return SI::getSI()->SGBDexecuteQuery($req,array($valeur));
	}

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
		echo'<table align="center" class="table" border=1px>';
		echo'<tr>';
		echo'<td align=center><b>Code Division</b></td>';
		echo'</tr>';
		// dire à chaque élément de mon tableau : afficher le row
		foreach ($this->getArray() as $unedivis) {
			$unedivis->displayRow();
		}
		echo '</table>';
		echo'</center>';
	}

	public function displaySelect($name){
		echo'<select style="width:auto" class="form-control" type="Text" required="required" name="'.$name.'">';
		echo '<option>  </option>';
		// dire à chaque élément de mon tableau : afficher le row
		foreach ($this->getArray() as $unedivision) {
			$unedivision->option();
		}
		echo '</select>';
	}
	
}
?>

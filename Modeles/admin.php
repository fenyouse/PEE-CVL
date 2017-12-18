<?php
//---------- Classe Admin

//----------------------------------------------
//                  CPE + TECH
//----------------------------------------------


public static function IdentificationAdmin($login,$mdp){
	$requete = "SELECT * from admin where ALogin ='".$login."'and APwd = '".md5($mdp)."'";

	$result = $theSI::getSI()->query($requete);
	$Identification = $result->fetch(PDO::FETCH_NUM);

	return $Identification[0];
}

public function GetDroitAdmin($login){
	$requete = "SELECT ADroit from admin where Alogin ='".$login."'";
	$result = $theSI ->query($requete);
	$DroitAdmin = $result->fetch(PDO::FETCH_NUM);

	return $DroitAdmin[0];
}

public function PostDateCoAdmin($login){
	$date = Now();
	$requete = "INSERT INTO admin (ADateLogin, ALastLogin) VALUES ('".$date."', '".$date."')";
	$tmp = $this->SGBDgetPrepareExecute($requete);

}





class Admin extends Element{

	//Singleton de mémorisation des instances
	private static $o_INSTANCES;
	public static function ajouterObjet($ligne){
		//créer (instancier) la liste si nécessaire
		if (static::$o_INSTANCES ==null){static::$o_INSTANCES = new Admins();}
		//voir si l'objet existe avec la clef
		$tmp = static::$o_INSTANCES->getObject($ligne[static::champID()]);
		if($tmp!=null){return $tmp;}
		//n'existe pas : donc INSTANCIER Admin et mémoriser
		$tmp = new Admin($ligne);
		static::$o_INSTANCES->doAddObject($tmp);
		return $tmp;
	}

	//publication liste instances
	public static function getInstances(){
		if (static::$o_INSTANCES ==null){static::$o_INSTANCES = new Admins();}
		return static::$o_INSTANCES;
	}

	// doit impérativement trouver la Admin ayant pour id le paramètre
	public static function mustFind($id){
		if (static::$o_INSTANCES == null){static::$o_INSTANCES = new Admins();}
		// regarder si instance existe
		$tmp = static::$o_INSTANCES->getObject($id);
		if($tmp!=null) {return $tmp;}
		//sinon pas trouver; chercher dans la BDD
		$req = static::getSELECT().' where ALogin =?';
		//echo "<br/>recherche $id";
		$ligne = SI::getSI()->SGBDgetLigne($req, $id);
		return static::ajouterObjet($ligne);
	}


	//---------- constructeur : repose sur le constructeur parent
	protected function __construct($theLigne) {parent::__construct($theLigne);}

	//---------- renvoie la valeur du champ spécifié en paramètre
	public function getALogin(){
		return $this->getField('ALogin');
	}

	public function getAPwd(){
		return $this->getField('APwd');
	}

	public function getADroit(){
		return $this->getField('ADroit');
	}


	public function displayRow(){

		echo '<tr>';
		echo '<td>'.$this->getALogin().'</td>';
		echo '<td>'.$this->getAPwd().'</td>';
		echo '<td>'.$this->getADroit().'</td>';
		echo "</tr>\n";


	}

	public function displayRow1() {
		echo '<tr>';
		echo '<td>'.$this->getALogin().'</td>';
		echo '</tr>';
	}
	public function displayRow2() {
		echo '<tr>';
		echo '<td>'.$this->getAPwd().'</td>';
		echo '</tr>';
	}
	public function displayRow3() {
		echo '<tr>';
		echo '<td>'.$this->getADroit().'</td>';
		echo '</tr>';
	}


	public function option(){
		$tmp = $this->getALogin();
		echo '<option value ='.$tmp.'">';
		echo $this->getALogin();
		echo '</option>';

	}
	public function option2(){
		$tmp = $this->getALogin();
		echo '<option value ='.$tmp.'">';
		echo $this->getADroit();
		echo '</option>';

	}

	/******************************
	IMPORTANT : 	toute classe dérivée non abstraite doit avoir le code pour

	******************************/
	public static function champID() {return 'ALogin';}
	public static function getSELECT() {return 'SELECT ALogin,APwd,ADroit FROM admin';  }


	public static function SQLInsert(array $valeurs){
		$req = 'INSERT INTO admin (ALogin,APwd,ADroit) VALUES(?,?,?)';
		return SI::getSI()->SGBDexecuteQuery($req,$valeurs);
	}
	public static function SQLDelete($ref){
		$req = 'DELETE FROM admin WHERE ALogin = ?';
		return SI::getSI()->SGBDexecuteQuery($req,array($ref));
	}

	public static function SQLUpdate(array $valeurs){
		$req = 'UPDATE admin SET ALogin=?, APwd=?, PDTPrix=?, ADroit=?,WHERE ALogin=?';
		return SI::getSI()->SGBDexecuteQuery($req,$valeurs);
	}


}

class Admins extends Pluriel{

	//constructeur
	public function __construct(){
		parent::__construct();
	}

	public function remplir($condition=null, $ordre=null) {
		$req = Admin::getSELECT();
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
			$this->doAddObject(Admin::ajouterObjet($uneLigne));
		}
	}

	public function displayTable(){
		echo '<td>';
		echo '<table>';
		// dire à chaque élément de mon tableau : Afficher le Row
		foreach ($this->getArray() as $unResultat) {
			$unResultat->displayRow1();
		}
		echo '</table>';
		echo '</td>';
		echo '<td>';
		echo '<table>';
		// dire à chaque élément de mon tableau : Afficher le Row
		foreach ($this->getArray() as $unResultat) {
			$unResultat->displayRow2();
		}
		echo '</table>';
		echo '</td>';
		echo '<td>';
		echo '<table>';
		// dire à chaque élément de mon tableau : Afficher le Row
		foreach ($this->getArray() as $unResultat) {
			$unResultat->displayRow3();
		}
		echo '</table>';
		echo '</td>';
	}

	public function displaySELECT(){
		echo'<select name="log">';
		// dire à chaque élément de mon tableau : afficher le row
		foreach ($this->getArray() as $unadmin) {
			$unadmin->option();
		}
		echo '</select>';
	}
	public function displaySELECT2(){
		echo'<select>';
		// dire à chaque élément de mon tableau : afficher le row
		foreach ($this->getArray() as $unadmin) {
			$unadmin->option2();
		}
		echo '</select>';
	}

}
?>

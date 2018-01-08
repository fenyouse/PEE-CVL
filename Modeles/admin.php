<?php
//---------- Classe Admin

//----------------------------------------------
//                  CPE + TECH
//----------------------------------------------

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
		$req = static::getSELECT().' where AId =?';
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

	public function getAId(){
		return $this->getField('AId');
	}
	public function getAPwd(){
		return $this->getField('APwd');
	}

	public function getADroit(){
		return $this->getField('ADroit');
	}

	//renvoie true si le mot de passe est cryptée
	public static function TestMdpCrypte ($login){

		$requete =static::getSELECT()." where ALogin ='".$login."'";
		$ligne = SI::getSI()->SGBDgetuneLigne($requete);
		//var_dump($ligne);
		$result = strlen($ligne['APwd']);
		//var_dump($result);
		return $result>6;
	}

	public static function AuthentificationAdmin($login,$mdp){

		//vérifier que l'eleve n'a pas voté et n'est pas deja connecté sinon renvoie null
		if (static::TestMdpCrypte($login)) {
			$requete =static::getSELECT()." where ALogin ='".$login."'and APwd = '".md5($mdp)."'";

		}else {
			$requete = static::getSELECT()." where ALogin ='".$login."'and APwd = '".$mdp."'";

		}
		$ligne = SI::getSI()->SGBDgetuneLigne($requete);
		if($ligne == null){return null;}

		$admin = static::ajouterObjet($ligne);

		return $admin;

	}

	//affiche
	public function displayRow(){

		echo '<tr>';
		echo '<td>'.$this->getALogin().'</td>';
		echo '<td>'.$this->getAPwd().'</td>';
		echo '<td>'.$this->getADroit().'</td>';
		echo "</tr>\n";
	}


	/******************************
	IMPORTANT : 	toute classe dérivée non abstraite doit avoir le code pour

	******************************/
	public static function champID() {return 'AId';}
	public static function getSELECT() {return 'SELECT AId,ALogin,APwd,ADroit FROM admin';  }

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

}
?>

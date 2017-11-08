<?php
//---------- Classe electeur
require_once 'Modeles/element.php';
require_once 'Modeles/pluriel.php';

class Electeur extends Element{

	//Singleton de mémorisation des instances
	private static $o_INSTANCES;
	public static function ajouterObjet($ligne){
		//créer (instancier) la liste si nécessaire
		if (static::$o_INSTANCES ==null){static::$o_INSTANCES = new Electeurs();}
		//voir si l'objet existe avec la clef
		$tmp = static::$o_INSTANCES->getObject($ligne[static::champID()]);
		if($tmp!=null){return $tmp;}
		//n'existe pas : donc INSTANCIER electeur et mémoriser
		$tmp = new Electeur($ligne);
		static::$o_INSTANCES->doAddObject($tmp);
		return $tmp;
	}

	//publication liste instances
	public static function getInstances(){
		if (static::$o_INSTANCES ==null){static::$o_INSTANCES = new Electeurs();}
		return static::$o_INSTANCES;
	}

	// doit impérativement trouver l' electeur ayant pour id le paramètre
	public static function mustFind($id){
		if (static::$o_INSTANCES == null){static::$o_INSTANCES = new Electeurs();}
		// regarder si instance existe
		$tmp = static::$o_INSTANCES->getObject($id);
		if($tmp!=null) {return $tmp;}
		//sinon pas trouver; chercher dans la BDD
		$req = static::getSELECT().' where EId =?';
		echo "<br/>recherche $id";
		$ligne = SI::getSI()->SGBDgetLigne($req, $id);
		return static::ajouterObjet($ligne);
	}

	private $o_MesElecteurs;

	//---------- constructeur : repose sur le constructeur parent
	protected function __construct($theLigne) {parent::__construct($theLigne);}

	//---------- renvoie la valeur du champ spécifié en paramètre
	public function getEId(){
		return $this->getField('EId');
	}

	public function getENom(){
		return $this->getField('ENom');
	}

	public function getEPrenom(){
		return $this->getField('EPrenom');
	}

	public function getEVote(){
		return $this->getField('EVote');
	}

	public function getELogin(){
		return $this->getField('ELogin');
	}

	public function getEIdDivis(){
		return $this->getField('EIdDivis');
	}

	public function getEDateLogin(){
		return $this->getField('EDateLogin');
	}

	public function getEAdresseIP(){
		return $this->getField('EAdresseIP');
	}

	public function getELastLogin(){
		return $this->getField('ELastLogin');
	}

	public function getESession(){
		return $this->getField('ESession');
	}

	public function getEDateLogout(){
		return $this->getField('EDateLogout');
	}

	public function getEModif(){
		return $this->getField('EModif');
	}


	public function getElecteurs(){
		if($this->o_MesElecteurs == null){
			$this->o_MesElecteurs = new Electeurs();
			$this->o_MesElecteurs->remplir('EId="'.$this->getEId().'"',null);
		}
		return $this->o_MesElecteurs;
	}

	/******************************
	IMPORTANT : 	toute classe dérivée non abstraite doit avoir le code pour

	******************************/
	public static function champID() {return 'EId';}
	public static function getSELECT() {return 'SELECT EId, ENom, EPrenom,EVote,EPwd,ELogin,EIdDivis,EDateLogin,EAdresseIP,ELastLogin,ESession,EDateLogout,EModif FROM elect';  }


}

class Electeurs extends Pluriel{

	//constructeur
	public function __construct(){
		parent::__construct();
	}

	public function remplir($condition=null, $ordre=null) {
		$req = Electeur::getSELECT();
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
			$this->doAddObject(Electeur::ajouterObjet($uneLigne));
		}
	}



}
?>

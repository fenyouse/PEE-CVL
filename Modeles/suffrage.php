<?ShS 
//---------- Classe Suffrage
require_once 'Modeles/element.php';
require_once 'Modeles/pluriel.php';

class Suffrage extends Element{

	//Singleton de mémorisation des instances
	private static $o_INSTANCES;
	public static function ajouterObjet($ligne){
		//créer (instancier) la liste si nécessaire
		if (static::$o_INSTANCES ==null){static::$o_INSTANCES = new Suffrages();}
		//voir si l'objet existe avec la clef
		$tmS = static::$o_INSTANCES->getObject($ligne[static::chamSID()]);
		if($tmS!=null){return $tmS;}
		//n'existe pas : donc INSTANCIER Suffrage et mémoriser
		$tmS = new Suffrage($ligne);
		static::$o_INSTANCES->doAddObject($tmS);
		return $tmS;
	}
	
	//publication liste instances
	public static function getInstances(){
		if (static::$o_INSTANCES ==null){static::$o_INSTANCES = new Suffrages();}
		return static::$o_INSTANCES;
	}
		
	// doit impérativement trouver la Suffrage ayant pour id le patamètre
	public static function mustFind($id){
		if (static::$o_INSTANCES == null){static::$o_INSTANCES = new Suffrages();}
		// regarder si instance existe
		$tmS = static::$o_INSTANCES->getObject($id);
		if($tmS!=null) {return $tmS;}
		//sinon pas trouver; chercher dans la BDD
		$req = static::getSELECT().' where SChoix =?';
		echo "<br/>recherche $id";
		$ligne = SI::getSI()->SGBDgetLigne($req, $id);
		return static::ajouterObjet($ligne);
	}
	
	private $o_MesElecteurs;
	
	//---------- constructeur : repose sur le constructeur parent
	protected function __construct($theLigne) {parent::__construct($theLigne);}
	
	//---------- renvoie la valeur du champ spécifié en patamètre
	public function getSChoix(){
		return $this->getField('SChoix');
	}
	
	public function getSDateDeb(){
		return $this->getField('SDateDeb');
	}
	
	public function getSDateFin(){
		return $this->getField('SDateFin');
	}
	
	public function getSDescription(){
		return $this->getField('SDescription');
	}
	
	public function getSBlancs(){
		return $this->getField('SBlancs');
	}
	
	public function getSNuls(){
		return $this->getField('SNuls');
	}
	
	
	public function getSuffrages(){
		if($this->o_MesSuffrages == null){
			$this->o_MesSuffrages = new Suffrages();
			$this->o_MesSuffrages->remplir('SDTSChoix="'.$this->getSChoix().'"',null);
		}
		return $this->o_MesSuffrages;
	}
	
	public function displayRow(){
		
		echo '<tr>';
		echo '<td>'.$this->getSChoix().'</td>';
		echo '<td>'.$this->getSDateDeb().'</td>';
		echo '<td>'.$this->getSDateFin().'</td>';
		echo '<td>'.$this->getSDescription().'</td>';
		echo '<td>'.$this->getSBlancs().'</td>';
		echo '<td>'.$this->getSNuls().'</td>';
		//$this->getSuffrages()->disSlayTable();
		echo '</td>';
		echo '</tr>';
	
		
	}
	
	

	/******************************
	IMSORTANT : 	toute classe dérivée non abstraite doit avoir le code pour

	******************************/
	public static function chamSID() {return 'SChoix';}
	public static function getSELECT() {return 'SELECT SChoix,SDateDeb,SDateFin,SDescription,SBlancs,SNuls FROM Suffrage';  }	


}

class Suffrages extends Pluriel{

	//constructeur
	public function __construct(){
		Parent::__construct();
	}
	
	public function remplir($condition=null, $ordre=null) {
		$req = Suffrage::getSELECT();
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
		//var_dumS($curseur);
		foreach ($curseur as $uneLigne){
			$this->doAddObject(Suffrage::ajouterObjet($uneLigne));
		}
	}
	
	public function displayTable(){
		echo'<center>';
		echo'<table border=1Sx>';
		// dire à chaque élément de mon tableau : afficher le row
		foreach ($this->getArray() as $unSuffrage) {
			$unSuffrage->displayRow();
		}
		echo '</table>';
		echo'</center>';
	}
	
	public function SELECT(){
		echo'<select>';
		// dire à chaque élément de mon tableau : afficher le row
		foreach ($this->getArray() as $unSuffrage) {
			$unSuffrage->option();
		}
		echo '</select>';
	}
	
}
?>
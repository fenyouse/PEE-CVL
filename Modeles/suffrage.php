<?php
//---------- Classe Suffrage


class Suffrage extends Element{

	//Singleton de mémorisation des instances
	private static $o_INSTANCES;
	public static function ajouterObjet($ligne){
		//créer (instancier) la liste si nécessaire
		if (static::$o_INSTANCES ==null){static::$o_INSTANCES = new Suffrages();}
		//voir si l'objet existe avec la clef
		$tmp = static::$o_INSTANCES->getObject($ligne[static::champID()]);
		if($tmp!=null){return $tmp;}
		//n'existe pas : donc INSTANCIER Suffrage et mémoriser
		$tmp = new Suffrage($ligne);
		static::$o_INSTANCES->doAddObject($tmp);
		return $tmp;
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
		$tmp = static::$o_INSTANCES->getObject($id);
		if($tmp!=null) {return $tmp;}
		//sinon pas trouver; chercher dans la BDD
		$req = static::getSELECT().' where 	SId =?';
		//&echo "<br/>recherche $id";
		$ligne = SI::getSI()->SGBDgetLigne($req, $id);
		return static::ajouterObjet($ligne);
	}

	private $o_MesCandidats;

	//---------- constructeur : repose sur le constructeur parent
	protected function __construct($theLigne) {parent::__construct($theLigne);}

	//---------- renvoie la valeur du champ spécifié en patamètre
	public function getSId(){
		return $this->getField('SId');
	}

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



	public function getCandidats(){
		if($this->o_MesCandidats == null){
			$this->o_MesCandidats = new Candidats();
			$this->o_MesCandidats->remplir('CIdSuffrage="'.$this->getSId().'"',null);
		}
		return $this->o_MesCandidats;
	}

	public function getCandidatsselect($selection){
		if($this->o_MesCandidats == null){
			$this->o_MesCandidats = new Candidats();
			$this->o_MesCandidats->remplir('CIdSuffrage="'.$selection.'"',null);
		}
		return $this->o_MesCandidats;
	}

	//affiche 
	public function displayRow(){
		echo '<tr>';
		echo '<td>'.$this->getSDateDeb().'</td>';
		echo '<td>'.$this->getSDateFin().'</td>';
		echo '<td>'.$this->getSDescription().'</td>';
		echo '</td>';
		echo '</tr>';
	}


	public function displayOption() {
		$tmp = $this->getSId();
		echo '<option value="'.$tmp.'">';
		echo $this->getSDescription();
		echo '</option>';
	}

	//affiche pour feuille pdf, gère les cellules du tableau suffrage
	public function displayOptionPDF($pdf,$fond) {
		$pdf->cell(6,0.7,utf8_decode($this->getSDescription()),1,0,'C',$fond);
		$pdf->cell(3.5,0.7,$this->getSDateDeb(),1,0,'C',$fond);
		$pdf->cell(3.5,0.7,$this->getSDateFin(),1,0,'C',$fond);
		$pdf->cell(2,0.7,$this->getSBlancs(),1,0,'C',$fond);
		$pdf->cell(2,0.7,$this->getSNuls(),1,0,'C',$fond);
	}

	/******************************
	IMSORTANT : 	toute classe dérivée non abstraite doit avoir le code pour

	******************************/
	public static function champID() {return 'SId';}
	public static function getSELECT() {return 'SELECT SId,SChoix,SDateDeb,SDateFin,SDescription,SBlancs,SNuls FROM suffrage';  }


	public static function SQLInsert(array $valeurs){
		$req = 'INSERT INTO suffrage (SChoix,SDateDeb,SDateFin,SDescription) VALUES(?,?,?,?)';
		return SI::getSI()->SGBDexecuteQuery($req,$valeurs);
	}

}

class Suffrages extends Pluriel{

	//constructeur
	public function __construct(){
		parent::__construct();
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
		echo'<table class="table" border=1Sx>';
		echo'<tr>';
		echo'<th> Date de debut </th>';
		echo'<th> Date de fin </th>';
		echo'<th> Description </th>';
		echo'</tr>';
		// dire à chaque élément de mon tableau : afficher le row
		foreach ($this->getArray() as $unSuffrage) {
			$unSuffrage->displayRow();
		}
		echo '</table>';
		echo'</center>';
	}

	//pour la selection par ajax
	public function displaySelect() {
		echo '<select name="selection" onChange="demanderDetails(this);">';
		echo '<option>   </option>';
		// dire à chaque élément de mon tableau : Afficher le Row
		foreach ($this->getArray() as $unsuffrage) {
			$unsuffrage->displayOption();
		}
		echo '</select>';
	}

	//pour récupérer la variable selection, la nommer au désir
	public function displaySelectSimple($name) {
		echo '<select class="form-control" type="Text" required="required" name="'.$name.'">';
		echo '<option>   </option>';
		// dire à chaque élément de mon tableau : Afficher le Row
		foreach ($this->getArray() as $unsuffrage) {
			$unsuffrage->displayOption();
		}
		echo '</select>';
	}


	//affichage sur PDF
	public function displaySelectPDF($pdf) {
		//les entêtes du tableau
		$header0= array('Description','DateDeb','DateFin','Blancs','Nuls');
		$pdf->SetFont('Arial','B',14);
		//cration de page
		$pdf->AddPage();
		$pdf->SetXY(7,3);
		//titre
		$pdf->Cell(5,1,utf8_decode('Les Résultats du Suffrage'));
		//logo
		$pdf->Image('img/Gustave_Eiffel_logo.png',18.5,0.2,2,4,'PNG');
		//gère le style du titre
		$pdf->SetFillColor(96,96,96);
		$pdf->SetTextColor(255);
		$pdf->SetXY(2,5);
		// les entêtes du tableau
		$pdf->cell(6,1,$header0[0],1,0,'C',1);
		$pdf->cell(3.5,1,$header0[1],1,0,'C',1);
		$pdf->cell(3.5,1,$header0[2],1,0,'C',1);
		$pdf->cell(2,1,$header0[3],1,0,'C',1);
		$pdf->cell(2,1,$header0[4],1,0,'C',1);
		//gère le style du tableau
		$pdf->SetFillColor(0xdd,0xdd,0xdd);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->SetXY(2,$pdf->GetY()+1);
		$fond=0;
		//les données du suffrage
		foreach ($this->getArray() as $unsuffrage) {
			$unsuffrage->displayOptionPDF($pdf,$fond);
			$pdf->SetXY(2.5,$pdf->GetY()+0.7);
			$fond=!$fond;
		}

	}

}
?>

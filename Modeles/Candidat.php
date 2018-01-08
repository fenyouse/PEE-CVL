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
	
	private $o_Myeleve;
	private $o_Mybinome;
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
	public function getCIdSuffrage(){
		return $this->getField('CIdSuffrage');
	}
	
	public function getEleve(){
		if($this->o_Myeleve!=null){return $this->o_Myeleve;}
			//catégorie non connue
			$this->o_Myeleve = Electeur::mustFind($this->getCId());
			return $this->o_Myeleve;
	}
	
	public function getBinome(){
		if($this->o_Mybinome!=null){return $this->o_Mybinome;}
			//catégorie non connue
			$this->o_Mybinome = Electeur::mustFind($this->getCIdBinome());
			return $this->o_Mybinome;
	}
	
	//affiche
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
	
		//Les candidats
		//$req="SELECT EIdDivis,ENom,EPrenom,ECodeINE,MAX(CNbV),CIdBinome,EId FROM elect,candid,suffrage where candid.CId = elect.Elogin and CIdSuffrage = "'.$SelectionSuffrage.'" order by ENom;";
	//binome
		//"SELECT EIdDivis,ENom,EPrenom,ECodeINE,EId FROM elect where ELogin = '".$binome."';";
		//
	
	//display des résultats du suffrage par candidats
	public function displayOptionPDFCandidats($pdf,$fond) {
		$pdf->cell(3,0.7,$this->getCId(),1,0,'C',$fond);
		$pdf->cell(3,0.7,$this->getCIdbinome(),1,0,'C',$fond);
		$pdf->cell(3,0.7,$this->getCNbV(),1,0,'C',$fond);
	}
	
	//display des coordonnées du candidat
	public function displayOptionPDFElu($pdf,$fond) {
		$pdf->cell(3,0.7,$this->getEleve()->getEIdDivis(),1,0,'C',$fond);
		$pdf->cell(3,0.7,$this->getEleve()->getEId(),1,0,'C',$fond);
		$pdf->cell(3,0.7,$this->getEleve()->getENom(),1,0,'C',$fond);
		$pdf->cell(3,0.7,$this->getEleve()->getEPrenom(),1,0,'C',$fond);
		$pdf->cell(3,0.7,$this->getEleve()->getECodeINE(),1,0,'C',$fond);
	}
	
	//display des coordonnées du binome
	public function displayOptionPDFBinome($pdf,$fond) {
		$pdf->cell(3,0.7,$this->getEleve()->getEIdDivis(),1,0,'C',$fond);
		//recherche des coordonnées du binôme dans la table électeur
		$objet = Electeur::mustFind($this->getCIdbinome());
		$pdf->cell(3,0.7,$objet->getEId(),1,0,'C',$fond);
		$pdf->cell(3,0.7,$objet->getENom(),1,0,'C',$fond);
		$pdf->cell(3,0.7,$objet->getEPrenom(),1,0,'C',$fond);
		$pdf->cell(3,0.7,$objet->getECodeINE(),1,0,'C',$fond);
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
			$req.=" WHERE $condition"; // remplace $condition car guillemet et pas simple quote
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
	
	//permet de remplir suivant la requête
	public function remplirAVECRequete($req) {	
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
	
	//affichage sur PDF des candidats du suffrage selectionner
	public function displaySelectPDFCandidats($pdf) {
		//les entêtes du tableau
		$header2= array('Id Candidats ','Id Binomes','nb Vote');
		$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(8,7);
		//titre
		$pdf->Cell(5,1, utf8_decode('Candidats et Binômes :'));
		//gère le style du titre
		$pdf->SetFillColor(96,96,96);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetXY(6,8);
		//gère les placements des cellules par rapport aux colonnes
		for($i=0;$i<sizeof($header2);$i++)
			$pdf->cell(3,1,$header2[$i],1,0,'C',1);
		//gère le style du tableau
		$pdf->SetFillColor(0xdd,0xdd,0xdd);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(6,$pdf->GetY()+1);
		$fond=0;
		//les résultats des candidats du suffrage selectionner
		foreach ($this->getArray() as $descandidat) {
			$descandidat->displayOptionPDFCandidats($pdf,$fond);
			$pdf->SetXY(6,$pdf->GetY()+0.7);
			$fond=!$fond;
		} 	
		
	}
	
	
	//affichage sur PDF du candidat élu
	public function displaySelectPDFElu($pdf) {
		//les entêtes du tableau
		$header2= array('Division','Id','Nom','Prenom','INE');
		$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(8,18);
		//titre
		$pdf->Cell(5,1, utf8_decode('Elu et Binôme :'));
		//gère le style du titre
		$pdf->SetFillColor(96,96,96);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetXY(3,20);
		//gère les placements des cellules par rapport aux colonnes
		for($i=0;$i<sizeof($header2);$i++)
			$pdf->cell(3,1,$header2[$i],1,0,'C',1);
		//gère le style du tableau
		$pdf->SetFillColor(0xdd,0xdd,0xdd);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','',8);
		$pdf->SetXY(3,$pdf->GetY()+1);
		$fond=0;
		//le candidat ayant eux le maximum de vote avec ses coordonnées
		foreach ($this->getArray() as $uncandidat) {
				$uncandidat->displayOptionPDFElu($pdf,$fond);
				$pdf->SetXY(3,$pdf->GetY()+0.7);
				$fond=!$fond;
		} 
		//le binome du candidat ayant eux le maximum de vote avec ses coordonnées
		foreach ($this->getArray() as $uncandidat) {
				$uncandidat->displayOptionPDFBinome($pdf,$fond);
				$pdf->SetXY(3,$pdf->GetY()+0.7);
				$fond=!$fond;
		} 
		
	}
	
}
?>
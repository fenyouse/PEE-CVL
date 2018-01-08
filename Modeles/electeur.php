<?php
//---------- Classe electeur
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
		//echo "<br/>recherche $id";
		$ligne = SI::getSI()->SGBDgetLigne($req, $id);
		return static::ajouterObjet($ligne);
	}


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

	public function getECodeINE(){
		return $this->getField('ECodeINE');
	}

	public function getEVote(){
		return $this->getField('EVote');
	}

	public function getEPwd(){
		return $this->getField('EPwd');
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


	//renvoie true si le mot de passe est cryptée
	public static function TestMdpCrypte ($login){

		$requete =static::getSELECT()." where ELogin ='".$login."'";
		$ligne = SI::getSI()->SGBDgetuneLigne($requete);
		//var_dump($ligne);
		$result = strlen($ligne['EPwd']);
		//var_dump($result);
		return $result>8;
	}

	public static function AuthentificationEleve($login,$mdp){

		//vérifier que l'eleve n'a pas voté et n'est pas deja connecté sinon renvoie null
		if (static::TestMdpCrypte($login)) {
			$requete =static::getSELECT()." where ELogin ='".$login."'and EPwd = '".md5($mdp)."'";

		}else {
			$requete = static::getSELECT()." where ELogin ='".$login."'and EPwd = '".$mdp."'";

		}
		//var_dump($requete);
		$ligne = SI::getSI()->SGBDgetuneLigne($requete);

		//var_dump($ligne);
		if($ligne == null){return null;}

		$eleve = static::ajouterObjet($ligne);
		static::PostDateCoEleve($login);
		return $eleve;

	}



	public static function PostDateCoEleve($login){

		$date = date('Y-m-d H:i:s');
		$valeurs = array($date,$date,'1',$login);
		//var_dump($valeurs);
		$requete = "UPDATE elect SET EDateLogin =?,ELastLogin= ?,EModif=? WHERE ELogin =? ";
		$result = SI::getSI()->SGBDexecuteQuery($requete,$valeurs);
		//var_dump($result);
		return $result;
	}

	public static function PostLogoutEleve($id){
		$date = date('Y-m-d H:i:s');
		$valeurs = array($date,0,$id);
		$requete = "UPDATE elect SET EDateLogout =?,EModif=? WHERE EId =? ";
		$result = SI::getSI()->SGBDexecuteQuery($requete,$valeurs);
		//var_dump($result);
		return $result;
	}


	//à tester
	public static function UpdatePassword($login,$oldMdp,$newMdp){
		if (static::TestMdpCrypte($login)) {
			$valeurs = array(md5($newMdp),$login,md5($oldMdp));
			//var_dump($valeurs);
			$requete = "UPDATE elect SET EPwd= ? WHERE ELogin =? AND EPwd=?";
			$result = SI::getSI()->SGBDexecuteQuery($requete,$valeurs);
		}else {
			$valeurs = array(md5($newMdp),$login,$oldMdp);
			//var_dump($valeurs);
			$requete = "UPDATE elect SET EPwd= ? WHERE ELogin =? AND EPwd=?";
			$result = SI::getSI()->SGBDexecuteQuery($requete,$valeurs);
		}


		return $result;
	}


	//affiche
	//les informations de chaque élève
	public function displayOptionPDFElecteur($pdf,$fond) {
		$pdf->cell(3,0.7,$this->getEIdDivis(),1,0,'C',$fond);
		$pdf->cell(6,0.7,$this->getENom(),1,0,'C',$fond);
		$pdf->cell(3,0.7,$this->getEPrenom(),1,0,'C',$fond);
		$pdf->cell(2,0.7,$this->getEPwd(),1,0,'C',$fond);
		$pdf->cell(3,0.7,$this->getELogin(),1,0,'C',$fond);
	}
	
	/******************************
	IMPORTANT : 	toute classe dérivée non abstraite doit avoir le code pour

	******************************/
	public static function champID() {return 'EId';}
	public static function getSELECT() {return 'SELECT EId, ENom, EPrenom,ECodeINE,EVote,EPwd,ELogin,EIdDivis,EDateLogin,EAdresseIP,ELastLogin,ESession,EDateLogout,EModif FROM elect';  }


	public static function SQLInsert(array $valeurs){
		$req = 'INSERT INTO elect (EId,ENom, EPrenom,ECodeINE,EPwd,ELogin,EIdDivis,EModif) VALUES(?,?,?,?,?,?,?,?)';
		return SI::getSI()->SGBDexecuteQuery($req,$valeurs);
	}

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

	//permet de remplir suivant la requête
	public function remplirAVECRequete($req,$condition=null, $ordre=null) {
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

	//affichage sur PDF
	public function displaySelectPDFElecteur($pdf) {
		//les entêtes du tableau
		$header= array('Division','Nom','Prenom','Pwd','Login');
		$pdf->SetFont('Arial','B',14);
		//cration de page
		$pdf->AddPage();
		$pdf->SetXY(6,2);
		//titre
		$pdf->Cell(3, 1,utf8_decode('Identifiants des élèves par division'));
		//logo
		$pdf->Image('img/Gustave_Eiffel_logo.png',18.5,0.2,2,4,'PNG');
		//gère le style du titre
		$pdf->SetFillColor(96,96,96);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetXY(2,4);
		//les entêtes du tableau un par un car la lageur est différente
		$pdf->cell(3,1,$header[0],1,0,'C',1);
		$pdf->cell(6,1,$header[1],1,0,'C',1);
		$pdf->cell(3,1,$header[2],1,0,'C',1);
		$pdf->cell(2,1,$header[3],1,0,'C',1);
		$pdf->cell(3,1,$header[4],1,0,'C',1);
		//gère le style du tableau
		$pdf->SetFillColor(0xdd,0xdd,0xdd);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->SetXY(2,$pdf->GetY()+1);
		$fond=0;
		//compteur
		$j=0;
		//la première division de la base
		$divis = "1EEC";
		//boucle l'affichage et les données par ligne
		foreach ($this->getArray() as $unelecteur) {
			//valeur de division pour le titre à chauqe page
			$divis2 = $unelecteur->getEIdDivis();
			//si ça a bouclé au moins une fois alors on créer une nouvelle page 
			//avec un titre contenant la nouvelle division aborder et les données des élèves de celle-ci
			if($j >1){
				if ($divis2 != $divis){
					//les entêtes du tableau
					$header= array('Division','Nom','Prenom','Pwd','Login');
					$pdf->SetFont('Arial','B',14);
					//création de la page
					$pdf->AddPage();
					$pdf->SetXY(6,2);
					//titre
					$pdf->Cell(3, 2,utf8_decode('Identifiants des élèves de la "'.$divis2.'"'));
					//logo
					$pdf->Image('img/Gustave_Eiffel_logo.png',18.5,0.2,2,4,'PNG');
					//gère le style du titre
					$pdf->SetFillColor(96,96,96);
					$pdf->SetTextColor(255,255,255);
					//pas la même valeur que la hauteur du premier tableau car sinon le logo déborde dessus
					$pdf->SetXY(2,5);
					//les entêtes du tableau un par un car la lageur est différente
					$pdf->cell(3,1,$header[0],1,0,'C',1);
					$pdf->cell(6,1,$header[1],1,0,'C',1);
					$pdf->cell(3,1,$header[2],1,0,'C',1);
					$pdf->cell(2,1,$header[3],1,0,'C',1);
					$pdf->cell(3,1,$header[4],1,0,'C',1);
					//gère le style du tableau
					$pdf->SetFillColor(0xdd,0xdd,0xdd);
					$pdf->SetTextColor(0,0,0);
					$pdf->SetFont('Arial','',10);
					$pdf->SetXY(2,$pdf->GetY()+1);
					$pdf->Image('img/Gustave_Eiffel_logo.png',18.5,0.2,2,4,'PNG');
			}}
			//les données des élèves-électeurs
			$unelecteur->displayOptionPDFElecteur($pdf,$fond);
			$divis = $unelecteur->getEIdDivis();
			$pdf->SetXY(2,$pdf->GetY()+0.7);
			$fond=!$fond;
			$j=$j+1;
		}

	}


}
?>

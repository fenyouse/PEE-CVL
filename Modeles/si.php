<?php

class SI {
	private $cnx ;
	private static $theSI;

	//---------- CONSTRUCTEUR PRIVATE
	private function __construct() {
		$this->cnx = new PDO('mysql:host=127.0.0.1; dbname=cvl',
										'root', '',
										array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES latin1'));
		$this->cnx->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

		static::$theSI=$this; // memorisation au static
	}

	//----------------------------------------------
	//                      ELEVES
	//----------------------------------------------
	public function TestMdpCrypte ($login,$mdp){
		$requete = "select EPwd from elect where Elogin ='".$login;
		$result = $theSI ->query($requete);
		$testCrypte = $result->fetch(PDO::FETCH_NUM);

		return $testCrypte.sizeof();
	}

	public function AuthentificationEleve($login,$mdp){
		//vérifier que l'eleve n'a pas voté et n'est pas deja connecté sinon renvoie 0
		if ($this->testMdpCrypte($login,$mdp)>6) {

			$requete = "select count(*)from elect where Elogin ='".$login."' and EPwd = '".md5($mdp)."'";
	    $result = $theSI ->query($requete);
	    $authentification = $result->fetch(PDO::FETCH_NUM);

	    return $authentification[0];

		}else {

			$requete = "select count(*)from elect where Elogin ='".$login."' and EPwd = '".$mdp."'";
	    $result = $theSI ->query($requete);
	    $authentification = $result->fetch(PDO::FETCH_NUM);

	    return $authentification[0];
		}
	}

	public function IdentificationEleve($login,$mdp){
		$requete = "select * from elect where Elogin ='".$login."'and EPwd = '".md5($mdp)."'";
	  $result = $theSI ->query($requete);
	  $Identification = $result->fetch(PDO::FETCH_NUM);

	  return $Identification[0];
	}

	public function PostDateCoEleve($login){
		$date = Now();
		$requete = "INSERT INTO elect (EDateLogin, ELastLogin) VALUES ('".$date."', '".$date."')";
		$result = $this->SGBDgetPrepareExecute($requete);

		return $result;
	}

	public function UpdatePassword($login,$mdp){
		$requete = "UPDATE elect SET EPwd= '".md5($mdp)."' WHERE ELogin ='".$login."' ";
		$result = $this->SGBDgetPrepareExecute($requete);

		return $result;
	}

	//----------------------------------------------
	//                  CPE + TECH
	//----------------------------------------------

	public function AuthentificationAdmin($login,$mdp){

		$requete = "select count(*)from admin where ALogin ='".$login."' and APwd = '".md5($mdp)."'";
    $result = $theSI ->query($requete);
    $authentification = $result->fetch(PDO::FETCH_NUM);

    return $authentification[0];

	}

	public function IdentificationAdmin($login,$mdp){
		$requete = "select * from admin where ALogin ='".$login."'and APwd = '".md5($mdp)."'";
	  $result = $theSI ->query($requete);
	  $Identification = $result->fetch(PDO::FETCH_NUM);

	  return $Identification[0];
	}

	public function GetDroitAdmin($login){
		$requete = "select ADroit from admin where Alogin ='".$login."'";
    $result = $theSI ->query($requete);
    $DroitAdmin = $result->fetch(PDO::FETCH_NUM);

    return $DroitAdmin[0];
	}

	public function PostDateCoAdmin($login){
		$date = Now();
		$requete = "INSERT INTO admin (ADateLogin, ALastLogin) VALUES ('".$date."', '".$date."')";
		$tmp = $this->SGBDgetPrepareExecute($requete);

	}







	//---------- renvoie le SI Singleton
	public static function getSI() {
		if (static::$theSI==null) {static::$theSI = new SI();}
		return static::$theSI;
	}

	//----------------------------------------------
	//                      SGBD
	//----------------------------------------------
	public function SGBDgetPrepare($req) {
		return $this->cnx->prepare($req);
	}
	public function SGBDgetPrepareExecute($req) {
		$stmt = $this->SGBDgetPrepare($req);
		$stmt->execute() ;
		return $stmt ;
	}
	// ecriture d'une methode permetanbt de renvoyer une seule ligne
	public function SGBDgetLigne($req,$id){
		$work = $this->SGBDgetPrepare($req);
		$work->bindParam(1,$id);
		$work->execute();
		return $work->fetch();

	}
}
?>

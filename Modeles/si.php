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

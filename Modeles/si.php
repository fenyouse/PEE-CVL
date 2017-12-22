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


	public function SGBDgetuneLigne($req){
		$work = $this->SGBDgetPrepare($req);
		$work->execute();
		return $work->fetch();
	}

	public function SGBDexecuteQuery($requete, array $valeurs) {
		$work = $this->SGBDgetPrepare($requete) ;
		//echo "$requete<br/>";
		$i=0;
		foreach ($valeurs as &$v) {
			$i++;
			//echo "$i : $v <br/>";
			$work->bindParam($i, $v);
		}
		$R = array();
		try {
			$work->execute();
			$tberr = $work->errorInfo();
			if ($tberr[0]=='00000') {
				$tmp = $work->rowCount();
				if ($tmp==0) {
					$R = array(	'pgstatus' => 0,
									'pgerror' => 0,
									'pgcomment' => 'aucune information modifiée');
				} else {
					$R = array(	'pgstatus' => $tmp,
									'pgerror' => 0,
									'pgcomment' => "l'opération a affecté $tmp occurrence(s)");
				}
			} else {
				$R = array(	'pgstatus' => -1,
								'pgerror' => $tberr[0],
								'pgcomment' => $tberr[2]);
			}
		} catch (Exception $e) {
				$R = array(	'pgstatus' => -3,
								'pgerror' => 0,
								'pgcomment' => $e->getMessage());
		}
		return $R;
	}

}
?>

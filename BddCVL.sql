SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE suffrage (
  SId varchar(10) NOT NULL,
  SChoix int(2) NOT NULL DEFAULT '5',
  SDateDeb datetime NOT NULL,
  SDateFin datetime NOT NULL,
  SDescription varchar(40) NOT NULL,
  SBlancs int(4) NOT NULL DEFAULT '0',
  SNuls int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (SId)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE candid (
  CId varchar(10) NOT NULL,
  CIdBinome varchar(10) NOT NULL,
  CNbV int(5) NOT NULL DEFAULT '0',
  CIdSuffrage varchar(10) NOT NULL,
  PRIMARY KEY (CId),
  CONSTRAINT suffrage_info_candid        
  FOREIGN KEY (CIdSuffrage)           
  REFERENCES suffrage(SId)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE elect (
  EId varchar(10) NOT NULL,
  ENom varchar(30) NOT NULL,
  EPrenom varchar(30) NOT NULL,
  ECodeINE Varchar(11),
  EVote datetime DEFAULT NULL,
  EPwd varchar(50) NOT NULL,
  ELogin varchar(20) NOT NULL,
  EIdDivis varchar(10) NOT NULL,
  EDateLogin datetime DEFAULT NULL,
  EAdresseIP varchar(20) DEFAULT NULL,
  ELastLogin datetime DEFAULT NULL,
  ESession varchar(100) DEFAULT NULL,
  EDateLogout datetime DEFAULT NULL,
  EModif int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (EId),
  CONSTRAINT elect_info_candid        
  FOREIGN KEY (EId)           
  REFERENCES candid(CId)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE divis (
  DCode varchar(10) NOT NULL,
  PRIMARY KEY (DCode)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE admin(
  AId varchar(10) NOT NULL,
  ALogin varchar(20) NOT NULL,
  APwd varchar(50) NOT NULL,
  ADroit varchar(4) NOT NULL,
  PRIMARY KEY (AId)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;	

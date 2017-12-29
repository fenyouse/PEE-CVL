SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE suffrage (
  SId INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  SChoix int(2) NOT NULL DEFAULT '5',
  SDateDeb datetime NOT NULL,
  SDateFin datetime NOT NULL,
  SDescription text(256) NOT NULL,
  SBlancs int(4) NOT NULL DEFAULT '0',
  SNuls int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (SId)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE candid (
  CId varchar(10) NOT NULL,
  CIdBinome varchar(10) NOT NULL,
  CNbV int(5) NOT NULL DEFAULT '0',
  CIdSuffrage int(50) NOT NULL,
  PRIMARY KEY (CId,CIdSuffrage)
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
  PRIMARY KEY (EId)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE divis (
  DCode varchar(10) NOT NULL,
  PRIMARY KEY (DCode)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE admin(
  AId INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  ALogin varchar(20) NOT NULL,
  APwd varchar(50) NOT NULL,
  ADroit varchar(4) NOT NULL,
  PRIMARY KEY (AId)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO divis SET DCode='1EEC'; INSERT INTO divis SET DCode='1GCO1'; INSERT INTO divis SET DCode='1GCO2';
INSERT INTO divis SET DCode='1GGES';INSERT INTO divis SET DCode='1SBA'; INSERT INTO divis SET DCode='1SBB';
INSERT INTO divis SET DCode='1SBC'; INSERT INTO divis SET DCode='1SBSI'; INSERT INTO divis SET DCode='1SE1';
INSERT INTO divis SET DCode='1SE2'; INSERT INTO divis SET DCode='1SSIA'; INSERT INTO divis SET DCode='1SSB';
INSERT INTO divis SET DCode='1SSIC';INSERT INTO divis SET DCode='1STIA'; INSERT INTO divis SET DCode='1STIB';
INSERT INTO divis SET DCode='1STIC'; INSERT INTO divis SET DCode='1STID'; INSERT INTO divis SET DCode='1STIE';
INSERT INTO divis SET DCode='1STIC'; INSERT INTO divis SET DCode='1STID'; INSERT INTO divis SET DCode='1STIE';
INSERT INTO divis SET DCode='2A'; INSERT INTO divis SET DCode='2B'; INSERT INTO divis SET DCode='2C';
INSERT INTO divis SET DCode='2D'; INSERT INTO divis SET DCode='20'; INSERT INTO divis SET DCode='200';
INSERT INTO divis SET DCode='2EEC'; INSERT INTO divis SET DCode='2F'; INSERT INTO divis SET DCode='2G';
INSERT INTO divis SET DCode='2H'; INSERT INTO divis SET DCode='2I'; INSERT INTO divis SET DCode='2J';
INSERT INTO divis SET DCode='2K'; INSERT INTO divis SET DCode='2L'; INSERT INTO divis SET DCode='2M';

INSERT INTO admin
SET AId=1, ALogin='VBEY56', APwd='58HTGR', ADroit='TECH';
INSERT INTO admin
SET AId=2, ALogin='OLMDQ4', APwd='AKEC8V', ADroit='CPE';

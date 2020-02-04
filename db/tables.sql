drop database if exists microwave;

CREATE DATABASE `microwave` charset=utf8;

GRANT ALL PRIVILEGES ON `microwave`.* TO 'microwaveuser'@'localhost' identified by '!Lamp12!';

use microwave;

CREATE TABLE `pathway` (
  `idpathway` int(11) NOT NULL AUTO_INCREMENT,
  `pathname` varchar(100) NOT NULL UNIQUE, 
  `opfrq` float NOT NULL, -- 1 util 100 valided
  `description` varchar(255) NOT NULL,
  `note` text,
  `pathfile` varchar(100) NOT NULL,
  PRIMARY KEY (`idpathway`)
); 


CREATE TABLE `points` (
  `idpoints`   int(11) NOT NULL AUTO_INCREMENT,
  `startpoint` float,
  `endpoint`   float,
  `groundheight`  float NOT NULL,
  `antennaheight` float NOT NULL, -- 1 util 100 valided
  `antennatype` varchar(10) NOT NULL,
  `antennalength` float NOT NULL,
  `idpathway` int(11) NOT NULL,-- FK
   PRIMARY KEY (`idpoints`),
   FOREIGN KEY (`idpathway`) REFERENCES pathway(`idpathway`)
); 



CREATE TABLE `midpoint` (
  `idmidPoint` int(11) NOT NULL AUTO_INCREMENT,
  `distance` float NULL,
  `groundheight` float NOT NULL,
  `terraintype` varchar(50) NOT NULL,
  `obstrucheight` float NOT NULL ,
  `obstructype` varchar(50) NOT NULL,
  `idpathway` int(11) NOT NULL, -- FK 
  PRIMARY KEY (`idmidPoint`) ,
  FOREIGN KEY (`idpathway`) REFERENCES pathway(`idpathway`)
); 

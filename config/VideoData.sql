CREATE TABLE `VideoData` (
	`ID` int( 11 ) NOT NULL AUTO_INCREMENT ,
	`Duration` time DEFAULT NULL ,
	`Bitrate` smallint( 4 ) DEFAULT NULL ,
	`Name` varchar( 15 ) DEFAULT NULL ,
	`Description` varchar( 255 ) DEFAULT NULL ,
	`Location` varchar( 127 ) DEFAULT NULL ,
	`Uploaded` TIMESTAMP NOT NULL DEFAULT NOW( ) ,
	`Created` datetime DEFAULT NULL ,
	`File` varchar( 127 ) DEFAULT NULL ,
	PRIMARY KEY ( `ID` )
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

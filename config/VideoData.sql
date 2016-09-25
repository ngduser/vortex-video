CREATE TABLE `VideoData` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Duration` time DEFAULT '00:00:00',
 `Bitrate` smallint(4) DEFAULT '0',
 `Name` varchar(127) DEFAULT 'File Name Unknown',
 `Description` varchar(255) DEFAULT 'No Description Given',
 `UUID` char(13) DEFAULT '-999',
 `Uploaded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `Title` varchar(127) DEFAULT 'No Title Given',
 `Ext` char(3) DEFAULT 'mp4',
 PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1

DROP TABLE IF EXISTS wcf1_sketch;
CREATE TABLE wcf1_sketch (
	sketchID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL DEFAULT '',
	title VARCHAR(255) NOT NULL DEFAULT '',
	content TEXT,
	flags VARCHAR(255) NOT NULL DEFAULT '',
	enableTPLCode TINYINT(1) NOT NULL DEFAULT 0,
	enableSmilies TINYINT(1) NOT NULL DEFAULT 0,
	enableHTML TINYINT(1) NOT NULL DEFAULT 0,
	enableBBCodes TINYINT(1) NOT NULL DEFAULT 0,
	views INT(10) NOT NULL DEFAULT 0,
	languageID INT(10) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS wcf1_sketch_author;
CREATE TABLE wcf1_sketch_author (
	sketchID INT(10) NOT NULL DEFAULT 0,
	userID INT(10) NOT NULL DEFAULT 0,
	timeID INT(10) NOT NULL DEFAULT 0,
	PRIMARY KEY (sketchID, userID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

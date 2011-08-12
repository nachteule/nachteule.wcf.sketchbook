<?php
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * @author	Nachteule`
 * @license	GNU Lesser General Public License
 * @package nachteule.wcf.sketchbook
 */
class Sketch extends DatabaseObject {
	public $authors;
	
	public function __construct($sketchID, $row = null, $name = null) {
		if (!empty($sketchID)) {
			$sql = "SELECT *
					FROM wcf".WCF_N."_sketch
					WHERE sketchID = ".$sketchID;
			$row = WCF::getDB()->getFirstRow($sql);
		}
		
		if (!empty($name)) {
			$sql = "SELECT *
					FROM wcf".WCF_N."_sketch
					WHERE name = '".escapeString($name)."'";
			$row = WCF::getDB()->getFirstRow($sql);
		}
		
		return parent::__construct($row);
	}
	
	public function getAuthors() {
		if ($this->authors === null) {
			$this->authors = array();
			
			$sql = "SELECT user.userID, user.username, author.time
					FROM wcf".WCF_N."_sketch author
					LEFT JOIN wcf".WCF_N."_user user
					ON (user.userID = author.userID)
					WHERE author.sketchID = ".$this->sketchID."
					ORDER BY TIME DESC";
			$result = WCF::getDB()->sendQuery($sql);
			while ($row = WCF::getDB()->fetchArray($result))
				$this->authors[] = $row;
		}
		
		return $this->authors;
	}
}

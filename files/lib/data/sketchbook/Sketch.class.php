<?php
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * @author	Nachteule`
 * @license	GNU Lesser General Public License
 * @package nachteule.wcf.sketchbook
 */
class Sketch extends DatabaseObject {
	public $authors;
	public $breadcrumbs;
	public $flags = array();
	
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
	
	protected function handleData($data) {
		parent::handleData($data);
		$flags = ArrayUtil::trim(explode(',', $this->data['flags']));
		foreach ($flags as $flag) {
			$flag = ArrayUtil::trim(explode('=', $flag, 2));
			$this->flags[$flag[0]] = (isset($flag[1]) ? $flag[1] : true);
		}
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
	
	public function getBreadcrumbs() {
		if ($this->breadcrumbs === null) {
			$this->breadcrumbs = array();
			
			$parents = array();
			$parts = explode('/', escapeString($this->name));
			$count = count($parts);
			if ($count > 1) {
				for ($i = 1; $i <= $count; $i++)
					$parents[] = implode('/', array_slice($parts, 0, $i));
			
				$sql = "SELECT name, title
						FROM wcf".WCF_N."_sketch
						WHERE name IN ('".$parents."')";
				$result = WCF::getDB()->sendQuery($sql);
				while ($row = WCF::getDB()->fetchArray($result))
					$this->breadcrumbs[$row['name']] = $row['title'];
			}
		}
		
		return $this->breadcrumbs;
	}
	
	public function isFlag($flag) {
		if (!isset($this->flags[$flag]))
			return false;
		
		return $this->flags[$flag];
	}
}

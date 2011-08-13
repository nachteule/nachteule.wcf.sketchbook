<?php
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * @author	Nachteule`
 * @license	GNU Lesser General Public License
 * @package nachteule.wcf.sketchbook
 */
class Sketch extends DatabaseObject {
	public static $cache;
	public $authors;
	public $breadcrumbs;
	public $childs;
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
		
		if (empty($row['name']))
			$this->name = $name;
		
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
			
			if (self::$cache === null)
				self::loadCache();
			
			$parts = explode('/', $this->name);
			$count = count($parts);
			if ($count > 1) {
				for ($i = 1; $i <= $count; $i++) {
					$parent = implode('/', array_slice($parts, 0, $i));
					
					if (isset(self::$cache['titles'][$parent]))
						$this->breadcrumbs[$parent] = self::$cache['titles'][$parent];
					else
						$this->breadcrumbs[$parent] = $parts[$i];
				}
			}
		}
		
		return $this->breadcrumbs;
	}
	
	public function getChilds() {
		if ($this->childs === null) {
			$this->childs = array();
			
			$parts = explode('/', $this->name)
			$current = &self::$cache['structure'];
			foreach ($parts as $child)
				$current = &$current[$child];
			
			foreach ($current as $child => $childs) {
				$this->childs[$child] = array(
					'title' => self::$cache['titles'][$this->name.'/'.$child],
					'childs' => count($childs)
				);
			}
		}
		
		return $this->childs;
	}
	
	public function isFlag($flag) {
		if (!isset($this->flags[$flag]))
			return false;
		
		return $this->flags[$flag];
	}
	
	public static function loadCache() {
		WCF::getCache()->addResource(
			'sketchbook',
			WCF_DIR.'cache/cache.sketchbook.php',
			WCF_DIR.'lib/system/cache/builder/CacheBuilderSketchbook.class.php'
		);
		self::$cache = WCF::getCache()->get('sketchbook');
	}
}

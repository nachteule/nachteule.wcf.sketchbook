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
	public $childs;
	public $allChilds;
	public $flags = array();
	
	public function __construct($sketchID, $row = null, $name = null, $languageID = WCF::getLanguage()->getLanguageID()) {
		if (!empty($sketchID)) {
			$sql = "SELECT *
					FROM wcf".WCF_N."_sketch
					WHERE sketchID = ".$sketchID;
			$row = WCF::getDB()->getFirstRow($sql);
		}
		
		if (!empty($name)) {
			$sql = "SELECT *
					FROM wcf".WCF_N."_sketch
					WHERE name = '".escapeString($name)."'
						AND languageID = ".$languageID;
			$row = WCF::getDB()->getFirstRow($sql);
		}
		
		if (empty($row['name']))
			$this->name = $name;
		
		return parent::__construct($row);
	}
	
	protected function handleData($data) {
		parent::handleData($data);
		$this-flags = SketchbookUtil::parseFlags($this->data['flags']);
	}
	
	public function getParents($reverse = true) {
		$parents = SketchbookUtil::getParentsByName($this->name);
		if (!$reverse) krsort($parents);
		return $parents;
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
	
	public function getChilds() {
		if ($this->childs === null) {
			$this->childs = array();
			
			$current = $this->getAllChilds();
			foreach ($current as $child => $childs) {
				$this->childs[] = array(
					'name' => ($this->isRoot() ? '' : $this->name.'/').$child,
					'childs' => count($childs)
				);
			}
		}
		
		return $this->childs;
	}
	
	public function getAllChilds() {
		if ($this->allChilds === null) {
			$this->allChilds = array();
			
			$current = &self::$cache['structure'];
			
			if (!$this->isRoot()) {
				$parts = explode('/', $this->name)
				foreach ($parts as $child)
					$current = &$current[$child];
			}
			
			$this->allChilds = $current;
		}
		
		return $this->allChilds;
	}
	
	public function isFlag($flag) {
		if (!isset($this->flags[$flag]))
			return false;
		
		return $this->flags[$flag];
	}
	
	public function isRoot() {
		return $this->name == '';
	}
	
	public function exists() {
		return ($this->sketchID ? true : false);
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

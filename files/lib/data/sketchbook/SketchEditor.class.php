<?php
require_once(WCF_DIR.'lib/data/sketchbook/Sketch.class.php');

/**
 * @author	Nachteule`
 * @license	GNU Lesser General Public License
 * @package nachteule.wcf.sketchbook
 */
class SketchEditor extends Sketch {
	/**
	 * Creates a new sketch.
	 *
	 * @param	string	$name
	 * @param	string	$title
	 * @param	string	$content
	 * @param	string	$flags
	 * @param	boolean	$enableTPLCode
	 * @param	boolean	$enableSmilies
	 * @param	boolean	$enableHTML
	 * @param	boolean	$enableBBCodes
	 * @param	integer	$views
	 */
	public static function create($name, $title, $content, $flags = array(), $enableTPLCode = false, $enableSmilies = false, $enableHTML = true, $enableBBCodes = true, $views = 0) {
		$sql = "INSERT INTO wcf".WCF_N."_sketch
					(name, title, content, flags, enableTPLCode, enableSmilies, enableHTML, enableBBCodes, views)
				VALUES ('".escapeString($name)."',
				'".escapeString($title)."',
				'".escapeString($content)."',
				'".escapeString(SketchEditor::buildFlagString($this->flags))."',
				".($enableTPLCode ? 1 : 0).",
				".($enableSmilies ? 1 : 0).",
				".($enableHTML ? 1 : 0).",
				".($enableBBCodes ? 1 : 0).",
				".$views.")";
		WCF::getDB()->sendQuery($sql);
		$sketchID = WCF::getDB()->getInsertedID();
		return new SketchEditor($sketchID);
	}
	
	/**
	 * Updates a sketch.
	 *
	 * @param	string	$name
	 * @param	string	$title
	 * @param	string	$content
	 * @param	string	$flags
	 * @param	boolean	$enableTPLCode
	 * @param	boolean	$enableSmilies
	 * @param	boolean	$enableHTML
	 * @param	boolean	$enableBBCodes
	 * @param	integer	$views
	 */
	public function update($name, $title, $content, $flags, $enableTPLCode, $enableSmilies, $enableHTML, $enableBBCodes, $views) {
		$sql = "UPDATE wcf".WCF_N."_sketch SET
					name = '".escapeString($name)."',
					title = '".escapeString($title)."',
					content = '".escapeString($content)."',
					flags = '".escapeString(SketchEditor::buildFlagString($flags))."',
					enableTPLCode = ".($enableTPLCode ? 1 : 0).",
					enableSmilies = ".($enableSmilies ? 1 : 0).",
					enableHTML = ".($enableHTML ? 1 : 0).",
					enableBBCodes = ".($enableBBCodes ? 1 : 0).",
					views = ".$views."
				WHERE sketchID = ".$this->sketchID;
		WCF::getDB()->sendQuery($sql);
	}
	
	public function addAuthor($userID, $time = TIME_NOW) {
		$sql = "INSERT INTO wcf".WCF_N."_sketch_author
					(sketchID, userID, time)
				VALUES
					(".$this->sketchID.", ".$userID.", ".$time.")
				ON DUPLICATE KEY UPDATE time = ".$time;
		WCF::getDB()->sendQuery($sql);
	}
	
	public function flag($flags) {
		$this->flags = array_merge($this->flags, $flags);
		
		$sql = "UPDATE wcf".WCF_N."_sketch SET
					flags = '".escapeString(SketchEditor::buildFlagString($this->flags))."'
				WHERE sketchID = ".$this->sketchID;
		WCF::getDB()->sendQuery($sql);
	}
	
	public static function buildFlagString($flags) {
		$string = '';
		foreach ($flags as $flag => $value) {
			if (!$value) continue;
			if (!empty($string)) $string .= ', ';
			$string .= $flag.($value !== true ? '='.$value : '');
		}
		return $string;
	}
	
	/**
	 * Deletes a sketch.
	 */
	public function delete() {
		$sql = "DELETE FROM wcf".WCF_N."_sketch_author
				WHERE sketchID = ".$this->sketchID;
		WCF::getDB()->sendQuery($sql);
		
		$sql = "DELETE FROM wcf".WCF_N."_sketch
				WHERE sketchID = ".$this->sketchID;
		WCF::getDB()->sendQuery($sql);
	}
}

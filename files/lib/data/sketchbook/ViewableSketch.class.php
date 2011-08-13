<?php
require_once(WCF_DIR.'lib/data/sketchbook/Sketch.class.php');
require_once(WCF_DIR.'lib/system/event/EventHandler.class.php');
require_once(WCF_DIR.'lib/data/message/bbcode/MessageParser.class.php');

/**
 * @author	Nachteule`
 * @license	GNU Lesser General Public License
 * @package nachteule.wcf.sketchbook
 */
class ViewableSketch extends Sketch {
	public $formattedContent;
	public $title;
	
	public function getFormattedContent() {
		if ($this->enableTPLCode)
			$this->formattedContent = WCF::getTPL()->fetchString($this->content);
		
		EventHandler::fireAction($this, 'shouldParseMessage');
		
		MessageParser::getInstance()->setOutputType('text/html');
		$this->formattedContent = MessageParser::getInstance()->parse(
			$this->formattedContent,
			$this->enableSmilies,
			$this->enableHTML,
			$this->enableBBCodes
		);
		
		EventHandler::fireAction($this, 'didParseMessage');
		
		return $this->formattedContent;
	}
	
	public function getTitle() {
		if ($this->title === null) {
			$title = array_values($this->getBreadcrumbs());
			krsort($title);
			$this->title = implode(' - ', $title);
		}
		
		return $this->title;
	}
	
	public function increaseViews() {
		$this->data['views']++;
		
		$sql = "UPDATE wcf".WCF_N."_sketch SET views = views + 1
				WHERE sketchID = ".$this->sketchID;
		WCF::getDB()->sendQuery($sql);
	}
}

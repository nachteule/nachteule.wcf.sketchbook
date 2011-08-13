<?php
require_once(WCF_DIR.'lib/page/AbstractPage.class.php');
require_once(WCF_DIR.'lib/data/sketchbook/ViewableSketch.class.php');

/**
 * @author	Nachteule`
 * @license	GNU Lesser General Public License
 * @package nachteule.wcf.sketchbook
 */
class SketchPage extends AbstractPage {
	public $templateName = 'sketch';
	public $name;
	public $sketchID;
	public $sketch;
	
	/**
	 * @see Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (!empty($_GET['sketchID']))
			$this->sketchID = intval($_GET['sketchID']);
		
		if (!empty($_GET['name']))
			$this->name = StringUtil::trim($_GET['name']);
		
		$this->sketch = new ViewableSketch($this->sketchID, null, $this->name);
		if (!$this->sketch->sketchID)
			$this->templateName = 'sketchNotFound';
		else
			$this->sketch->increaseViews();
	}
	
	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'sketch' => $this->sketch
		));
	}
}

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
	public $sketch;
	
	/**
	 * @see Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (!empty($_GET['name']))
			$this->name = StringUtil::trim($_GET['name']);
		
		$this->sketch = new ViewableSketch(null, null, $this->name);
		if ($this->sketch->sketchID)
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

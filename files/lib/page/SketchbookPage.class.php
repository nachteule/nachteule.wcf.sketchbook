<?php
require_once(WCF_DIR.'lib/page/AbstractPage.class.php');
require_once(WCF_DIR.'lib/data/sketchbook/Sketch.class.php');

/**
 * @author	Nachteule`
 * @license	GNU Lesser General Public License
 * @package nachteule.wcf.sketchbook
 */
class SketchbookPage extends AbstractPage {
	public $templateName = 'sketch';
	public $name = '';
	public $sketch;
	public $titles;
	
	/**
	 * @see Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (!empty($_GET['name']))
			$this->name = StringUtil::trim($_GET['name']);
		
		$this->sketch = new Sketch(null, null, $this->name);
		
		if (Sketch::$cache === null)
			Sketch::loadCache();
		
		$this->titles = Sketch::$cache['titles'];
	}
	
	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'sketch' => $this->sketch,
			'titles' => $this->titles
		));
	}
}

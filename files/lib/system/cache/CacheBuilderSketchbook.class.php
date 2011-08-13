<?php
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * @author	Nachteule`
 * @license	GNU Lesser General Public License
 * @package nachteule.wcf.sketchbook
 */
class CacheBuilderSketchbook implements CacheBuilder {
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		$sketchbook = array(
			'structure' => array(),
			'titles' => array()
		);
		
		$sql = "SELECT name, title
				FROM wcf".WCF_N."_sketch
				ORDER BY name ASC";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$sketchbook['titles'][$row['name']] = $row['title'];
			
			$parts = explode('/', $row['name']);
			
			$current = &$sketchbook['structure'];
			foreach ($parts as $child) {
				if (!isset($current[$child]))
					$current[$child] = array();
				
				$current = &$current[$child];
			}
			
			$current['title'] = $row['title'];
		}
		
		return $sketchbook;
	}
}

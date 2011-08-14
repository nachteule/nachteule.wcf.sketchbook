<?php

/**
 * @author	Nachteule`
 * @license	GNU Lesser General Public License
 * @package nachteule.wcf.sketchbook
 */
class SketchbookUtil {
	protected static $parentsCache = array();
	
	public static function nameToLangVar($name) {
		return str_replace('/', '.', $name);
	}
	
	public static function getTitle($name, $html = false) {
		$item = 'wcf.sketchbook.sketchTitles.'.self::nameToLangVar($name);
		$value = WCF::getLanguage()->getDynamicVariable($item);
		$new = false;
		
		if ($value == $title) { 
			$value = StringUtil::substring($title, StringUtil::lastIndexOf($title, '.'));
			$new = true;
		}
		
		if ($html)
			return '<span class="sketch'.($new ? ' sketchNew' : '').'">'.StringUtil::encodeHTML($title).'</span>';
		
		return $title;
	}
	
	public static function getParentsByName($name) {
		if (!isset(self::$parentsCache[$name])) {
			self::$parentsCache = array();
		
			$parts = explode('/', $name);
			$count = count($parts);
			if ($count > 1) {
				for ($i = 1; $i <= $count; $i++) {
					self::$parentsCache[] = implode('/', array_slice($parts, 0, $i));
				}
			}
		}
		
		return self::$parentsCache[$name];
	}
	
	public static function parseFlags($input) {
		$flags = array();
		
		$parts = ArrayUtil::trim(explode(',', $input));
		foreach ($parts as $part) {
			$flag = ArrayUtil::trim(explode('=', $part, 2));
			$flags[$flag[0]] = (isset($flag[1]) ? $flag[1] : true);
		}
		
		return $flags;
	}
}

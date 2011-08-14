<?php
require_once(WCF_DIR.'lib/system/template/TemplatePluginModifier.class.php');

/**
 * @author	Nachteule`
 * @license	GNU Lesser General Public License
 * @package nachteule.wcf.sketchbook
 */
class TemplatePluginModifierSketchTitle implements TemplatePluginModifier {
	/**
	 * @see TemplatePluginModifier::execute()
	 */
	public function execute($tagArgs, Template $tplObj) {
		$html = true;
		if (isset($tagArs[1]))
			$html = (bool) $tagArgs[1];
		
		return ShoutboxUtil::getTitle($tagArgs[0], $html);
	}
}

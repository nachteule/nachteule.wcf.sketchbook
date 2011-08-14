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
		return ShoutboxUtil::getTitle($tagArgs[0]);
	}
}

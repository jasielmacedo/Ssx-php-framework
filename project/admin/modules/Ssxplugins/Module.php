<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

$locale = new SsxModulesLocale();

$locale->plural = "Plugins";
$locale->singular = "Plugin";

Ssx::$themes->setModuleLocale($locale);

	
	Ssx::$themes->set_slug_action('config');
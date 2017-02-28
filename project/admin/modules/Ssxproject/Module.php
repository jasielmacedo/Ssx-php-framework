<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

$locale = new SsxModulesLocale();

$locale->plural = "Configurações do Site";
$locale->singular = "Site";

Ssx::$themes->setModuleLocale($locale);
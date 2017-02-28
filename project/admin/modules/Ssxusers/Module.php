<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */
 
 Ssx::$themes->set_theme_title('| Usuários', false);
 
 $locale = new SsxModulesLocale();
 
 $locale->plural = "Usuários";
 $locale->singular = "Usuário";
 
 Ssx::$themes->setModuleLocale($locale);
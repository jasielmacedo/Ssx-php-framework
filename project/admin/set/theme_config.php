<?php
/**
 * 
 * @author jasiel macedo <jasielmacedo@gmail.com>
 * @version 1.3
 * 
 */

  
 
  Ssx::$themes->set_theme_title('Área administrativa', true);
  
  load_css('css/bootstrap.min.css');
  load_css('css/bootstrap-icon.css');
  
  
  $SsxAdminMenu = new SsxAdminMenu();
  $SsxAdminMenu->addMenu('users', 'Configura&ccedil;&otilde;es', 'Ssxproject')
  					->addSubmenu('users', 'Usu&aacute;rios', get_url('ssxusers','index'), 'Ssxusers', 'index')
  					->addSubmenu('users', 'Adicionar usu&aacute;rio', get_url('ssxusers','edit'),  'Ssxusers', 'edit')
  					->addSubmenu('users', 'Ver grupos de usuários', get_url('ssxgroups','index'), 'Ssxgroups', 'index')
  					->addSubmenu('users', 'Adicionar Grupo', get_url('ssxgroups','edit'), 'Ssxgroups', 'edit')
  					->addSubmenu('users', 'Permissões de Acesso', get_url('ssxacl','edit'), 'Ssxacl', 'edit')
  					->addSubmenu('users', 'Definições do Site',get_url('ssxproject', 'index'),'Ssxproject', 'index')
  					->addSubmenu('users', 'Logs do Sistema',get_url('ssxproject', 'log'),'Ssxproject', 'log')
  				->addMenu('tickets', 'Atendimento', 'Tickets')
  					->addSubmenu('tickets', 'Todos os Chamados', get_url('tickets','index'), 'Tickets', 'index')
  					->addSubmenu('tickets', 'Abrir novo Chamado', get_url('tickets','add'), 'Tickets', 'add')
  					->addSubmenu('tickets', 'Tipos de Chamado', get_url('tickets','tipos'), 'Tickets', 'tipos')
  					->addSubmenu('tickets', 'Prioridade de Grupos', get_url('tickets','grouprules'), 'Tickets', 'grouprules')
  				->addMenu('pages', 'P&aacute;ginas', 'Ssxpages')
  					->addSubmenu('pages', 'Ver Páginas', get_url('ssxpages','index'), 'Ssxpages', 'index')
  					->addSubmenu('pages', 'Adicionar página', get_url('ssxpages','edit'), 'Ssxpages', 'edit')
  				->addMenu('plugins', 'Plugins', 'Ssxplugins')
  					->addSubmenu('plugins', 'Plugins instalados', get_url('ssxplugins','index'), 'Ssxplugins', 'index')
  					->addSubmenu('plugins', 'Instalar plugin', get_url('ssxplugins','install'),  'Ssxplugins', 'install')
  				->addMenu('auth','Minha conta','Home')
  					->addSubmenu('auth', 'Alterar senha', get_url('auth','change_pass'), 'Auth', 'change_pass')
  					->addSubmenu('auth', 'Sair', get_url('auth','logout'), 'Auth', 'login');		

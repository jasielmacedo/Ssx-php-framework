<?php
/**
 * 
 * Plugin gerador do menu da area administrativa
 * Criar um menu, basta informar o id e o nome do menu na função addMenu
 * Para adicionar um sublink dentro do menu, basta usar a função addSubMenu e informar o id do menu o nome do submenu e o link
 * 
 * @copyright 2012 Skyaz Games
 *  
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

class SsxAdminMenu
{
	protected $menus;
	
	protected $sublinks;
	
	public $enabled = true;
	
	public function __construct(){
		
		$this->menus = array();
		$this->sublinks = array();
		
		// será chamado quando for enviado as variáveis para a view
		SsxActivity::addListener('ssx_display', array($this, 'draw'));
	}
	
	public function &addMenu($menu_id, $menu_name, $module_permission="Home", $url="")
	{
		if(!is_string($menu_id) || !is_string($menu_name))
			return $this;

		if(!SsxAcl::checkPermissionForModule($module_permission,the_platform()))	
			return $this;
			
		if($this->getMenuExists($menu_id))
			return $this;
			
		array_push($this->menus, 
					array(
							'id'=>"menu_" . $menu_id,
							'name'=>$menu_name,
							'url'=>$url
					));	
		return $this;
	}
	
	private function getMenuExists($menu_id)
	{
		if(!$menu_id)
			return false;
			
		if(is_array($this->menus))
		{
			foreach($this->menus as $menu)
			{
				if($menu['id'] == "menu_" . $menu_id)
					return true;
			}
		}
		return false;
	}
	
	public function &addSubmenu($menu_id, $menu_name, $url, $module_permission="Home", $action_permission="index")
	{
		if(!is_string($menu_id) || !is_string($menu_name) || !is_string($url))
			return $this;
			
		if(!SsxAcl::checkPermissionForAction($module_permission,$action_permission, the_platform()))
			return $this;
			
		if(!$this->getMenuExists($menu_id))
			return $this;
			
		if(is_array($this->sublinks))
		{
			$this->sublinks["menu_".$menu_id][] = array(
														'name'=>$menu_name,
														'url'=>$url
													);
		}
			
		return $this;
	}
	
	private function scriptToFuncionability()
	{
		ob_start();
		?>
			<script type="text/javascript">
				cssdropdown.startchrome("chromemenu"); 
		 	</script>
		<?php 
		$scriptToFunc = ob_get_clean();
		return $scriptToFunc;
	}
	
	public function draw()
	{		
		if(!$this->enabled)
			return;
			
		$contentPane = "";
		
		if(count($this->menus))
		{
			$contentPane .= '
			<div class="container">
			<div class="navbar navbar-default" role="navigation">
				<div class="container">
					<div class="navbar-header">
						 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				            <span class="icon-bar"></span>
				            <span class="icon-bar"></span>
				            <span class="icon-bar"></span>
				          </button>
						<a class="navbar-brand" href="'.siteurl().'">&Aacute;rea administrativa</a>
					</div>
							<div class="navbar-collapse collapse">
            					<ul class="nav navbar-nav">';

			foreach($this->menus as $row)
			{
				$url = isset($row['url']) && $row['url']?$row['url']:"javascript:void(0);";
				$rel = "";
				
				
				if(isset($this->sublinks[$row['id']]) && $this->sublinks[$row['id']])
				{
					$contentPane .= "<li class='dropdown'><a href='".$url."' class='dropdown-toggle' data-toggle='dropdown'>".$row['name']." <b class='caret'></b></a>";
						$contentPane .= "<ul class='dropdown-menu'>";
						foreach($this->sublinks[$row['id']] as $subitems)
						{
							$contentPane .= '<li><a href="'.$subitems['url'].'">'.$subitems['name'].'</a></li>';
						}
						$contentPane .= "</ul>";
					$contentPane .= "</li>";
				}else{
					$contentPane .= "<li><a href='".$url."'>".$row['name']."</a></li>";	
				}
			}
			
			$contentPane .= "</ul></div></div></div></div>";
		}
		
		
		Ssx::$themes->assign('plugin_menu', $contentPane);
	}
	
	public function disableMenu()
	{		
		Ssx::$themes->assign('plugin_menu', "");	
		
		$this->enabled = false;
	}
}
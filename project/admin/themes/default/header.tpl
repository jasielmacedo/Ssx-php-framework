<!DOCTYPE html>
<html lang="pt-BR" xml:lang="pt-BR" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>{$ssx_theme_title}</title>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {$ssx_head}
    
    
</head>
<body>
 {$plugin_menu}
 <div class="container">
 	{if $locale}
 		<ol class="breadcrumb">
		  <li><a href="{$siteurl}">Home</a></li>
		  {if $this_action neq "index"}
		  	<li><a href="{$siteurl}{$this_module}/">{$locale->plural}</a></li>
		  	<li class="active">{$locale->singular}</li>
		  {else}
		  	<li class="active">{$locale->plural}</li>
		  {/if}
		</ol>
 	{/if}
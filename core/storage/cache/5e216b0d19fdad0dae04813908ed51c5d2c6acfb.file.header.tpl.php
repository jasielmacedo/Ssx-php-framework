<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-10 17:41:52
         compiled from "E:\dropbox\Dropbox\ssx\project\admin\themes\default\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1942957320140a60090-85069291%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5e216b0d19fdad0dae04813908ed51c5d2c6acfb' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\ssx\\project\\admin\\themes\\default\\header.tpl',
      1 => 1440280502,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1942957320140a60090-85069291',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ssx_theme_title' => 0,
    'ssx_head' => 0,
    'plugin_menu' => 0,
    'locale' => 0,
    'siteurl' => 0,
    'this_action' => 0,
    'this_module' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_57320140a8eea1_05735456',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57320140a8eea1_05735456')) {function content_57320140a8eea1_05735456($_smarty_tpl) {?><!DOCTYPE html>
<html lang="pt-BR" xml:lang="pt-BR" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $_smarty_tpl->tpl_vars['ssx_theme_title']->value;?>
</title>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <?php echo $_smarty_tpl->tpl_vars['ssx_head']->value;?>

    
    
</head>
<body>
 <?php echo $_smarty_tpl->tpl_vars['plugin_menu']->value;?>

 <div class="container">
 	<?php if ($_smarty_tpl->tpl_vars['locale']->value) {?>
 		<ol class="breadcrumb">
		  <li><a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
">Home</a></li>
		  <?php if ($_smarty_tpl->tpl_vars['this_action']->value!="index") {?>
		  	<li><a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/"><?php echo $_smarty_tpl->tpl_vars['locale']->value->plural;?>
</a></li>
		  	<li class="active"><?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
</li>
		  <?php } else { ?>
		  	<li class="active"><?php echo $_smarty_tpl->tpl_vars['locale']->value->plural;?>
</li>
		  <?php }?>
		</ol>
 	<?php }?><?php }} ?>

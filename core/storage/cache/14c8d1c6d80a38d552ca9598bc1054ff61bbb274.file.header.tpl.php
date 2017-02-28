<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-09 22:25:52
         compiled from "E:\dropbox\Dropbox\ssx\project\themes\default\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:40825730f250cea8f4-78083867%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '14c8d1c6d80a38d552ca9598bc1054ff61bbb274' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\ssx\\project\\themes\\default\\header.tpl',
      1 => 1440277260,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '40825730f250cea8f4-78083867',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ssx_theme_title' => 0,
    'ssx_head' => 0,
    'siteurl' => 0,
    'siteurl_clean' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5730f250cf6474_28997889',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5730f250cf6474_28997889')) {function content_5730f250cf6474_28997889($_smarty_tpl) {?><!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml">
<head>
  
    <title><?php echo $_smarty_tpl->tpl_vars['ssx_theme_title']->value;?>
</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <?php echo $_smarty_tpl->tpl_vars['ssx_head']->value;?>

    
    
</head>
<body itemscope itemtype="http://schema.org/WebPage">
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Menu</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
">Ssx Framework</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
">Home</a></li>
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['siteurl_clean']->value;?>
admin">Admin</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <div class="container" role="main"><?php }} ?>

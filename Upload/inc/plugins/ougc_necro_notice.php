<?php

/*
 * OUGC Necro Post Notice plugin
 * Author: Omar Gonzalez.
 * Copyright: � 2012 Omar Gonzalez, All Rights Reserved
 * 
 * Website: http://www.udezain.com.ar
 *
 * Show a alert bar when replying to old threads.
 *
************************************************************/

/*
 * This plugin is under uDezain free plugins license. In short:
 * ============================================================
 * 1.- You may edit whatever you want to fit your needs without premission.
 * 2.- You MUST NOT redistribute this or any modified version of this plugin by any means without the author written permission.
 * 3.- You MUST NOT remove any license comments in any file that comes with this plugin pack.
 *
 * By downloading / installing / using this plugin you accept these conditions and the full attached license.
 * If no license file was attached within this plugin pack, you can read it in the following places:
 * 	1.- http://www.udezain.com.ar/eula-free.txt
 * 	2.- http://www.udezain.com.ar/eula-free.php
************************************************************/
 
// Die if IN_MYBB is not defined, for security reasons.
defined('IN_MYBB') or die('This file cannot be accessed directly.');

// Run the ACP hooks.
if(!defined('IN_ADMINCP'))
{
	$plugins->add_hook('showthread_start', 'ougc_necro_notice');
	$plugins->add_hook('newreply_start', 'ougc_necro_notice');

	//Cache our template.
	if(THIS_SCRIPT == 'showthread.php' || THIS_SCRIPT == 'newreply.php')
	{
		global $templatelist;

		if(isset($templatelist))
		{
			$templatelist .= ',';
		}
		else
		{
			$templatelist = '';
		}
		$templatelist .= 'ougcnecronotice';
	}
}

// PLUGINLIBRARY
defined('PLUGINLIBRARY') or define('PLUGINLIBRARY', MYBB_ROOT.'inc/plugins/pluginlibrary.php');

//Necessary plugin information for the ACP plugin manager.
function ougc_necro_notice_info()
{
	global $lang;
	isset($lang->ougc_necro_notice) or $lang->load('ougc_necro_notice');

	return array(
		'name'			=> 'OUGC Necro Post Notice',
		'description'	=> $lang->ougc_necro_notice_d,
		'website'		=> 'http://mods.mybb.com/view/disable-guests',
		'author'		=> 'Omar G.',
		'authorsite'	=> 'http://community.mybb.com/user-25096.html',
		'version'		=> '1.1',
		'guid'			=> 'f2e864384ac2a13e3511684aed51c754',
		'compatibility'	=> '16*',
		'pl_url'		=> 'http://mods.mybb.com/view/pluginlibrary',
		'pl_version'	=> 11,
	);
}

//Activate the plugin.
function ougc_necro_notice_activate()
{
	global $PL, $lang;
	ougc_necro_notice_pl_req();

	// Add our settings
	$PL->settings('ougc_necro_notice', $lang->ougc_necro_notice, $lang->ougc_necro_notice_d, array(
		'time'	=> array(
			'title'			=> $lang->ougc_necro_notice_time,
			'description'	=> $lang->ougc_necro_notice_time_d,
			'optionscode'	=> 'text',
			'value'			=> 30,
		),
		'forums'	=> array(
			'title'			=> $lang->ougc_necro_notice_forums,
			'description'	=> $lang->ougc_necro_notice_forums_d,
			'optionscode'	=> 'text',
			'value'			=> '',
		),
		'groups'	=> array(
			'title'			=> $lang->ougc_necro_notice_groups,
			'description'	=> $lang->ougc_necro_notice_groups_d,
			'optionscode'	=> 'text',
			'value'			=> '',
		),
		'page'	=> array(
			'title'			=> $lang->ougc_necro_notice_page,
			'description'	=> $lang->ougc_necro_notice_page_d,
			'optionscode'	=> 'select
newreply='.$lang->ougc_necro_notice_page_newreply.'
showthread='.$lang->ougc_necro_notice_page_showthread.'
both='.$lang->ougc_necro_notice_page_both,
			'value'			=> 'both',
		),
	));

	// Insert template/group
	$PL->templates('ougcnecronotice', $lang->ougc_necro_notice, array(
		''	=> '<div class="red_alert">{$lang->ougc_necro_notice_alert}</div>',
	));

	require_once MYBB_ROOT.'/inc/adminfunctions_templates.php';
	find_replace_templatesets('showthread_quickreply', '#'.preg_quote('<f').'#', '{$thread[\'necro_notice\']}<f');
	find_replace_templatesets('newreply', '#'.preg_quote('{$reply_errors}').'#', '{$thread[\'necro_notice\']}{$reply_errors}');
}

//Deactivate the plugin.
function ougc_necro_notice_deactivate()
{
	ougc_necro_notice_pl_req();

	require_once MYBB_ROOT.'/inc/adminfunctions_templates.php';
	find_replace_templatesets('showthread_quickreply', '#'.preg_quote('{$thread[\'necro_notice\']}').'#', '', 0);
	find_replace_templatesets('newreply', '#'.preg_quote('{$thread[\'necro_notice\']}').'#', '', 0);
}

// _is_installed routine
function ougc_necro_notice_is_installed()
{
	global $db;

	return (bool)$db->fetch_field($db->simple_select('settinggroups', 'gid', 'name="ougc_necro_notice"'), 'gid');
}

// _install routine
function ougc_necro_notice_install()
{
	ougc_necro_notice_pl_req();
}

// _install routine
function ougc_necro_notice_uninstall()
{
	global $PL;
	ougc_necro_notice_pl_req();

	// Delete settings
	$PL->settings_delete('ougc_necro_notice');

	// Delete template/group
	$PL->templates_delete('ougcnecronotice');
}

// PluginLibrary dependency check
function ougc_necro_notice_pl_req()
{
	global $lang;
	isset($lang->ougc_necro_notice) or $lang->load('ougc_necro_notice');
	$info = ougc_necro_notice_info();

	if(!file_exists(PLUGINLIBRARY))
	{
		flash_message($lang->sprintf($lang->ougc_necro_notice_plreq, $info['pl_url'], $info['pl_version']), 'error');
		admin_redirect('index.php?module=config-plugins');
		exit;
	}

	global $PL;
	$PL or require_once PLUGINLIBRARY;

	if($PL->version < $info['pl_version'])
	{
		flash_message($lang->sprintf($lang->ougc_necro_notice_plreq, $PL->version, $info['pl_version'], $info['pl_url']), 'error');
		admin_redirect('index.php?module=config-plugins');
		exit;
	}
}

// Show the bar
function ougc_necro_notice()
{
	global $settings, $thread;

	$thread['necro_notice'] = '';
	
	$pages = array('newreply.php', 'showthread.php');
	if($settings['ougc_necro_notice_page'] == 'newreply')
	{
		unset($pages[1]);
	}
	elseif($settings['ougc_necro_notice_page'] == 'showthread')
	{
		unset($pages[0]);
	}

	if(!in_array(THIS_SCRIPT, $pages))
	{
		return;
	}

	if(!empty($settings['ougc_necro_notice_forums']))
	{
		if(in_array($thread['fid'], array_unique(array_map('intval', explode(',', $settings['ougc_necro_notice_forums'])))))
		{
			return;
		}
	}

	global $PL;
	$PL or require_once PLUGINLIBRARY;

	if(!empty($settings['ougc_necro_notice_groups']))
	{
		if((bool)$PL->is_member($settings['ougc_necro_notice_groups']))
		{
			return;
		}
	}

	global $thread;
	$days = ((int)$settings['ougc_necro_notice_time'] < 1 ? 1 : (int)$settings['ougc_necro_notice_time']);

	if($thread['lastpost'] < TIME_NOW-(86400*$days))
	{
		global $lang, $templates;
		isset($lang->ougc_necro_notice) or $lang->load('ougc_necro_notice');

		$lang_val = ($days > 1 ? $lang->ougc_necro_notice_days : $lang->ougc_necro_notice_day);
		$lang->ougc_necro_notice_alert = $lang->sprintf($lang->ougc_necro_notice_alert, my_number_format($days), $lang_val);

		eval('$thread[\'necro_notice\'] = "'.$templates->get('ougcnecronotice').'";');
	}
}
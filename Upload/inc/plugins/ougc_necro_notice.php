<?php

/***************************************************************************
 *
 *	OUGC Pages plugin (/inc/plugins/ougc_necro_notice.php)
 *	Author: Omar Gonzalez
 *	Copyright: © 2012 - 2020 Omar Gonzalez
 *
 *	Website: https://ougc.network
 *
 *	Show a alert bar when replying to old threads.
 *
 ***************************************************************************
 
****************************************************************************
	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
****************************************************************************/
 
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
		'website'		=> 'https://ougc.network',
		'author'		=> 'Omar G.',
		'authorsite'	=> 'https://ougc.network',
		'version'		=> '1.8.20',
		'versioncode'	=> 1820,
		'compatibility'	=> '18*',
		'codename'		=> 'ougc_necro_notice',
		'pl_url'		=> 'https://community.mybb.com/mods.php?action=view&pid=573',
		'pl_version'	=> 13,
	);
}

//Activate the plugin.
function ougc_necro_notice_activate()
{
	global $PL, $lang, $cache;
	ougc_necro_notice_pl_req();

	// Add our settings
	$PL->settings('ougc_necro_notice', $lang->ougc_necro_notice, $lang->ougc_necro_notice_d, array(
		'time'	=> array(
			'title'			=> $lang->ougc_necro_notice_time,
			'description'	=> $lang->ougc_necro_notice_time_d,
			'optionscode'	=> 'numeric',
			'value'			=> 30,
		),
		'forums'	=> array(
			'title'			=> $lang->ougc_necro_notice_forums,
			'description'	=> $lang->ougc_necro_notice_forums_d,
			'optionscode'	=> 'forumselect',
			'value'			=> '',
		),
		'groups'	=> array(
			'title'			=> $lang->ougc_necro_notice_groups,
			'description'	=> $lang->ougc_necro_notice_groups_d,
			'optionscode'	=> 'groupselect',
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

	// Insert/update version into cache
	$plugins = $cache->read('ougc_plugins');
	if(!$plugins)
	{
		$plugins = array();
	}

	$info = ougc_necro_notice_info();

	if(!isset($plugins['necro_notice']))
	{
		$plugins['necro_notice'] = $info['versioncode'];
	}

	/*~*~* RUN UPDATES START *~*~*/

	/*~*~* RUN UPDATES END *~*~*/

	$plugins['necro_notice'] = $info['versioncode'];
	$cache->update('ougc_plugins', $plugins);
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
	global $cache;

	$plugins = $cache->read('ougc_plugins');

	return isset($plugins['necro_notice']);
}

// _install routine
function ougc_necro_notice_install()
{
	ougc_necro_notice_pl_req();
}

// _uninstall routine
function ougc_necro_notice_uninstall()
{
	global $PL, $cache;
	ougc_necro_notice_pl_req();

	// Delete settings
	$PL->settings_delete('ougc_necro_notice');

	// Delete template/group
	$PL->templates_delete('ougcnecronotice');

	// Delete version from cache
	$plugins = (array)$cache->read('ougc_plugins');

	if(isset($plugins['necro_notice']))
	{
		unset($plugins['necro_notice']);
	}

	if(!empty($plugins))
	{
		$cache->update('ougc_plugins', $plugins);
	}
	else
	{
		$PL->cache_delete('ougc_plugins');
	}
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

	if(
		is_member($settings['ougc_necro_notice_groups']) ||
		is_member($settings['ougc_necro_notice_forums'], array('usergroup' => $thread['fid']))
	)
	{
		return;
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
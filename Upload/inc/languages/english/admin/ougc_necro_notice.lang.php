<?php

/*
 * OUGC Necro Post Notice plugin
 * Author: Omar Gonzalez.
 * Copyright: © 2012 Omar Gonzalez, All Rights Reserved
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

$l['ougc_necro_notice'] = 'OUGC Necro Post Notice';
$l['ougc_necro_notice_d'] = 'This plugin will warn users when replying old threads.';

// Settings
$l['ougc_necro_notice_time'] = 'Days for Warn';
$l['ougc_necro_notice_time_d'] = 'Days since the lastpost to show the warn? Default "30" days.';
$l['ougc_necro_notice_forums'] = 'Forum to Ignore';
$l['ougc_necro_notice_forums_d'] = 'Insert a comma separate list of forums ids (FID) to ignore. Leave empty to disable.';
$l['ougc_necro_notice_groups'] = 'Groups to Ignore';
$l['ougc_necro_notice_groups_d'] = 'Insert a comma separate list of groups ids (GID) to ignore. Leave empty to disable.';
$l['ougc_necro_notice_page'] = 'Where to Show the Bar';
$l['ougc_necro_notice_page_d'] = 'Whe do you want to show the warn bar?';
$l['ougc_necro_notice_page_newreply'] = 'New Reply';
$l['ougc_necro_notice_page_showthread'] = 'Show Thread';
$l['ougc_necro_notice_page_both'] = 'Both';



// PluginLibrary
$l['ougc_necro_notice_plreq'] = 'This plugin requires <a href="{1}">PluginLibrary</a> version {2} or later to be uploaded to your forum.';
$l['ougc_necro_notice_plold'] = 'This plugin requires PluginLibrary version {1} or later, whereas your current version is {2}. Please do update <a href="{3}">PluginLibrary</a>.';
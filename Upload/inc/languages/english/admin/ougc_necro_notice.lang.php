<?php

/***************************************************************************
 *
 *   OUGC Necro Post plugin (/inc/languages/english/admin/ougc_necro_notice.lang.php)
 *	 Author: Omar Gonzalez
 *   Copyright: © 2012 Omar Gonzalez
 *   
 *   Website: http://community.mybb.com/user-25096.html
 *
 *   Show a alert bar when replying to old threads.
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
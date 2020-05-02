<?php

/***************************************************************************
 *
 *	OUGC Pages plugin (/inc/languages/espanol/admin/ougc_necro_notice.lang.php)
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

$l['ougc_necro_notice'] = 'OUGC Necro Post Notice';
$l['ougc_necro_notice_d'] = 'Este plugin mostrara una notificacion a los usuarios que intentan responder a temas viejos.';

// Settings
$l['ougc_necro_notice_time'] = 'Dias';
$l['ougc_necro_notice_time_d'] = 'Los dias que deben pasar desde la ultima respuesta para mostrar la notificacion.';
$l['ougc_necro_notice_forums'] = 'Foros a Ignorar';
$l['ougc_necro_notice_forums_d'] = 'Selecciona los foros en donde esta notificacion no sera mostrada.';
$l['ougc_necro_notice_groups'] = 'Grupos a Ignorar';
$l['ougc_necro_notice_groups_d'] = 'Selecciona los grupos a quienes no se les mostrara la notificacion.';
$l['ougc_necro_notice_page'] = 'Ubicacion';
$l['ougc_necro_notice_page_d'] = 'Puedes mostrar la notificacion sobre la respuesta rapida o en la pagina de respuesta neuva.';
$l['ougc_necro_notice_page_newreply'] = 'Formulario de respuestas.';
$l['ougc_necro_notice_page_showthread'] = 'Pagina de temas.';
$l['ougc_necro_notice_page_both'] = 'Ambos';

// PluginLibrary
$l['ougc_necro_notice_plreq'] = 'Este plugin requiere <a href="{1}">PluginLibrary</a> version {2} para funcionar. Por favor asegurate de subir los archivos necesarios.';
$l['ougc_necro_notice_plold'] = $l['ougc_necro_notice_plreq'];
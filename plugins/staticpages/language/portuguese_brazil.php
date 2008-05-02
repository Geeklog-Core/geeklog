<?php

###############################################################################
# portuguese_brazil.php
# Esta � a p�gina em portugu�s do Brasil para o plug-in Geeklog Static Page!
#
# Tradu��o: Alcides Soares Filho (Maio de 2004)
# asoaresfil@uol.com.br
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_STATIC = array(
    'newpage' => 'Nova P�gina',
    'adminhome' => 'Home Admin',
    'staticpages' => 'P�ginas Est�ticas',
    'staticpageeditor' => 'Editor de P�ginas Est�ticas',
    'writtenby' => 'Escrito por',
    'date' => '�ltima Atualiza��o',
    'title' => 'T�tulo',
    'content' => 'Conte�do',
    'hits' => 'Hits',
    'staticpagelist' => 'Lista de P�ginas Est�ticas',
    'url' => 'URL',
    'edit' => 'Edita',
    'lastupdated' => '�ltima Atualiza��o',
    'pageformat' => 'Formato da P�gina',
    'leftrightblocks' => 'Blocos � Esquerda & Direita',
    'blankpage' => 'P�gina em Branco',
    'noblocks' => 'Sem Blocos',
    'leftblocks' => 'Blocos � Esquerda',
    'addtomenu' => 'Adiciona ao Menu',
    'label' => 'Identifica��o',
    'nopages' => 'N�o h� p�ginas est�ticas no sistema ainda',
    'save' => 'salva',
    'preview' => 'prev� p�gina',
    'delete' => 'apaga',
    'cancel' => 'cancela',
    'access_denied' => 'Acesso n�o autorizado',
    'access_denied_msg' => 'Voc� est� ilegalmente tentando acessar a p�gina de administra��o de P�ginas Est�ticas.  Saiba que todas tentativas de acesso ilegal ficam registradas neste sistema',
    'all_html_allowed' => 'Todos c�digos HTML s�o permitidos',
    'results' => 'Resultado da P�gina Est�tica',
    'author' => 'Autor',
    'no_title_or_content' => 'Voc� deve ao menos preencher os campos de <b>T�tulo</b> e <b>Conte�do</b>.',
    'no_such_page_anon' => 'Por favor fa�a o LOGIN...',
    'no_page_access_msg' => "Isto pode ter acontecido porque voc� n�o efetuou o LOGIN, ou ainda porque n�o � membro do {$_CONF['site_name']}. Por favor <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> torne-se um membro usu�rio do site</a> {$_CONF['site_name']} para ter acesso a todos recursos dispon�veis",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Aten��o: c�digo PHP dentro da sua p�gina ser� avaliado se voc� solicitar esta op��o. Use com cautela !!',
    'exit_msg' => 'Mensagem de Sa�da: ',
    'exit_info' => 'Habilita Mensagem informando que LOGIN � necess�rio.  Deixe desmarcado para seguran�a normal e mensagem.',
    'deny_msg' => 'Acesso a esta p�gina n�o permitido.  Ou a p�gina foi movida/removida ou voc� n�o tem permiss�o para acess�-la.',
    'stats_headline' => 'Top 10 P�ginas Est�ticas',
    'stats_page_title' => 'T�tulo da P�gina',
    'stats_hits' => 'Hits',
    'stats_no_hits' => 'Parece que ainda n�o h� p�ginas est�ticas neste site ou que ainda nenhuma delas foi visitada.',
    'id' => 'ID',
    'duplicate_id' => 'A identidade - ID - que voc� escolheu para esta p�gina est�tica j� est� em uso. Por favor selecione uma outra identidade - ID.',
    'instructions' => 'Para modificar ou apagar uma p�gina est�tica, clique no n�mero da p�gina abaixo. Para ver uma p�gina est�tica, clique no T�tulo da p�gina que voc� quer ver. Para criar uma npva p�gina est�tica, clica em P�gina Nova acima. Clique no [C] para criar uma c�pia de uma p�gina j� existente.',
    'centerblock' => 'Centraliza Bloco: ',
    'centerblock_msg' => 'Quando marcado, faz com que a p�gina est�tica seja mostrada como um bloco central na p�gina de �ndice (index).',
    'topic' => 'T�pico: ',
    'position' => 'Posi��o: ',
    'all_topics' => 'Todos',
    'no_topic' => 'Somente Homepage',
    'position_top' => 'Topo da P�gina',
    'position_feat' => 'Depois de Publica��o',
    'position_bottom' => 'P� da P�gina',
    'position_entire' => 'P�gina Inteira',
    'head_centerblock' => 'Centraliza Bloco',
    'centerblock_no' => 'N�o',
    'centerblock_top' => 'Topo',
    'centerblock_feat' => 'P�. Publica��o',
    'centerblock_bottom' => 'Embaixo de tudo',
    'centerblock_entire' => 'P�gina Inteira',
    'inblock_msg' => 'Em um bloco: ',
    'inblock_info' => 'Espalha - Wrap - a P�gina Est�tica no Bloco.',
    'title_edit' => 'Edita p�gina',
    'title_copy' => 'Faz c�pia desta p�gina',
    'title_display' => 'Mostra p�gina',
    'select_php_none' => 'n�o executa c�digo PHP',
    'select_php_return' => 'executa PHP (volta)',
    'select_php_free' => 'executa PHP',
    'php_not_activated' => "O uso de PHP em p�ginas est�ticas n�o est� ativado. Por favor veja a <a href=\"{$_CONF['site_url']}/docs/staticpages.html#php\">documenta��o</a> para saber de mais detalhes.",
    'printable_format' => 'Printable Format',
    'copy' => 'Copy',
    'limit_results' => 'Limit Results',
    'search' => 'Search',
    'submit' => 'Submit'
);

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'Static Pages',
    'title' => 'Static Pages Configuration'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'Allow PHP?',
    'sort_by' => 'Sort Centerblocks by',
    'sort_menu_by' => 'Sort Menu Entries by',
    'delete_pages' => 'Delete Pages with Owner?',
    'in_block' => 'Wrap Pages in Block?',
    'show_hits' => 'Show Hits?',
    'show_date' => 'Show Date?',
    'filter_html' => 'Filter HTML?',
    'censor' => 'Censor Content?',
    'default_permissions' => 'Page Default Permissions',
    'aftersave' => 'After Saving Page',
    'atom_max_items' => 'Max. Pages in Webservices Feed'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Static Pages Main Settings',
    'fs_permissions' => 'Default Permissions'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    2 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title'),
    3 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Label' => 'label'),
    9 => array('Forward to page' => 'item', 'Display List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3)
);

?>
<?php

###############################################################################
# portuguese_brazil.php
# Esta é a página em português do Brasil para o plug-in Geeklog Static Page!
#
# Tradução: Alcides Soares Filho (Maio de 2004)
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
    'newpage' => 'Nova Página',
    'adminhome' => 'Home Admin',
    'staticpages' => 'Páginas Estáticas',
    'staticpageeditor' => 'Editor de Páginas Estáticas',
    'writtenby' => 'Escrito por',
    'date' => 'Última Atualização',
    'title' => 'Título',
    'page_title' => 'Page Title',
    'content' => 'Conteúdo',
    'hits' => 'Hits',
    'staticpagelist' => 'Lista de Páginas Estáticas',
    'url' => 'URL',
    'edit' => 'Edita',
    'lastupdated' => 'Última Atualização',
    'pageformat' => 'Formato da Página',
    'leftrightblocks' => 'Blocos à Esquerda & Direita',
    'blankpage' => 'Página em Branco',
    'noblocks' => 'Sem Blocos',
    'leftblocks' => 'Blocos à Esquerda',
    'addtomenu' => 'Adiciona ao Menu',
    'label' => 'Identificação',
    'nopages' => 'Não há páginas estáticas no sistema ainda',
    'save' => 'salva',
    'preview' => 'prevê página',
    'delete' => 'apaga',
    'cancel' => 'cancela',
    'access_denied' => 'Acesso não autorizado',
    'access_denied_msg' => 'Você está ilegalmente tentando acessar a página de administração de Páginas Estáticas.  Saiba que todas tentativas de acesso ilegal ficam registradas neste sistema',
    'all_html_allowed' => 'Todos códigos HTML são permitidos',
    'results' => 'Resultado da Página Estática',
    'author' => 'Autor',
    'no_title_or_content' => 'Você deve ao menos preencher os campos de <b>Título</b> e <b>Conteúdo</b>.',
    'no_such_page_anon' => 'Por favor faça o LOGIN...',
    'no_page_access_msg' => "Isto pode ter acontecido porque você não efetuou o LOGIN, ou ainda porque não é membro do {$_CONF['site_name']}. Por favor <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> torne-se um membro usuário do site</a> {$_CONF['site_name']} para ter acesso a todos recursos disponíveis",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Atenção: código PHP dentro da sua página será avaliado se você solicitar esta opção. Use com cautela !!',
    'exit_msg' => 'Mensagem de Saída: ',
    'exit_info' => 'Habilita Mensagem informando que LOGIN é necessário.  Deixe desmarcado para segurança normal e mensagem.',
    'deny_msg' => 'Acesso a esta página não permitido.  Ou a página foi movida/removida ou você não tem permissão para acessá-la.',
    'stats_headline' => 'Top 10 Páginas Estáticas',
    'stats_page_title' => 'Título da Página',
    'stats_hits' => 'Hits',
    'stats_no_hits' => 'Parece que ainda não há páginas estáticas neste site ou que ainda nenhuma delas foi visitada.',
    'id' => 'ID',
    'duplicate_id' => 'A identidade - ID - que você escolheu para esta página estática já está em uso. Por favor selecione uma outra identidade - ID.',
    'instructions' => 'Para modificar ou apagar uma página estática, clique no número da página abaixo. Para ver uma página estática, clique no Título da página que você quer ver. Para criar uma npva página estática, clica em Página Nova acima. Clique no [C] para criar uma cópia de uma página já existente.',
    'centerblock' => 'Centraliza Bloco: ',
    'centerblock_msg' => 'Quando marcado, faz com que a página estática seja mostrada como um bloco central na página de índice (index).',
    'topic' => 'Tópico: ',
    'position' => 'Posição: ',
    'all_topics' => 'Todos',
    'no_topic' => 'Somente Homepage',
    'position_top' => 'Topo da Página',
    'position_feat' => 'Depois de Publicação',
    'position_bottom' => 'Pé da Página',
    'position_entire' => 'Página Inteira',
    'head_centerblock' => 'Centraliza Bloco',
    'centerblock_no' => 'Não',
    'centerblock_top' => 'Topo',
    'centerblock_feat' => 'Pé. Publicação',
    'centerblock_bottom' => 'Embaixo de tudo',
    'centerblock_entire' => 'Página Inteira',
    'inblock_msg' => 'Em um bloco: ',
    'inblock_info' => 'Espalha - Wrap - a Página Estática no Bloco.',
    'title_edit' => 'Edita página',
    'title_copy' => 'Faz cópia desta página',
    'title_display' => 'Mostra página',
    'select_php_none' => 'não executa código PHP',
    'select_php_return' => 'executa PHP (volta)',
    'select_php_free' => 'executa PHP',
    'php_not_activated' => "O uso de PHP em páginas estáticas não está ativado. Por favor veja a <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">documentação</a> para saber de mais detalhes.",
    'printable_format' => 'Printable Format',
    'copy' => 'Copy',
    'limit_results' => 'Limit Results',
    'search' => 'Search',
    'submit' => 'Submit',
    'no_new_pages' => 'No new pages',
    'pages' => 'Pages',
    'comments' => 'Comments',
    'draft' => 'Draft',
    'draft_yes' => 'Yes',
    'draft_no' => 'No'
);

$PLG_staticpages_MESSAGE15 = 'Your comment has been submitted for review and will be published when approved by a moderator.';
$PLG_staticpages_MESSAGE19 = 'Your page has been successfully saved.';
$PLG_staticpages_MESSAGE20 = 'Your page has been successfully deleted.';
$PLG_staticpages_MESSAGE21 = 'This page does not exist yet. To create the page, please fill in the form below. If you are here by mistake, click the Cancel button.';

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
    'sort_list_by' => 'Sort Admin List by',
    'delete_pages' => 'Delete Pages with Owner?',
    'in_block' => 'Wrap Pages in Block?',
    'show_hits' => 'Show Hits?',
    'show_date' => 'Show Date?',
    'filter_html' => 'Filter HTML?',
    'censor' => 'Censor Content?',
    'default_permissions' => 'Page Default Permissions',
    'aftersave' => 'After Saving Page',
    'atom_max_items' => 'Max. Pages in Webservices Feed',
    'meta_tags' => 'Enable Meta Tags',
    'comment_code' => 'Comment Default',
    'draft_flag' => 'Draft Flag Default',
    'newstaticpagesinterval' => 'New Static Page Interval',
    'hidenewstaticpages' => 'Hide New Static Pages',
    'title_trim_length' => 'Title Trim Length',
    'includecenterblocks' => 'Include Center Block Static Pages',
    'includephp' => 'Include Static Pages with PHP',
    'includesearch' => 'Enable Static Pages in Search',
    'includesearchcenterblocks' => 'Include Center Block Static Pages',
    'includesearchphp' => 'Include Static Pages with PHP'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Static Pages Main Settings',
    'fs_whatsnew' => 'What\'s New Block',
    'fs_search' => 'Search Results',
    'fs_permissions' => 'Default Permissions'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    2 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title'),
    3 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Label' => 'label'),
    4 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Author' => 'author'),
    5 => array('Hide' => 'hide', 'Show - Use Modified Date' => 'modified', 'Show - Use Created Date' => 'created'),
    9 => array('Forward to page' => 'item', 'Display List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    17 => array('Comments Enabled' => 0, 'Comments Disabled' => -1)
);

?>

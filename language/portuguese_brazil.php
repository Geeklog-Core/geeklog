<?php

###############################################################################
# portuguese_brazil.php
# This is the brazilian-portuguese language page for GeekLog!
# Special thanks to Mischa Polivanov for his work on this project
#
# Copyright (C) 2002 Dener C. Brito - LAST UPDATE: March 26,2002
# dener@crube.net
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

$LANG_CHARSET = 'iso-8859-1';

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################

###############################################################################
# lib-common.php

$LANG01 = array(
    1 => 'Enviado por:',
    2 => 'ler mais',
    3 => 'comentários',
    4 => 'Editar',
    5 => 'Enquete',
    6 => 'Resultados',
    7 => 'Resultados da Enquete',
    8 => 'votos',
    9 => 'Funções Administrativas:',
    10 => 'Submissions',
    11 => 'Histórias',
    12 => 'Blocos',
    13 => 'Tópicos',
    14 => 'Links',
    15 => 'Eventos',
    16 => 'Enquetes',
    17 => 'Usuários',
    18 => 'SQL Query',
    19 => 'Sair do Sistema',
    20 => 'Informações do Usuário:',
    21 => 'Usuário',
    22 => 'ID',
    23 => 'Nível de Acesso',
    24 => 'Anônimo',
    25 => 'Responder',
    26 => 'Os comentários a seguir são propriedade de quem os enviou. Este site não é responsável pelas opiniões expressas por seus usuários ou visitantes.',
    27 => 'Mensagem mais recente',
    28 => 'Excluir',
    29 => 'Sem comentários.',
    30 => 'Histórias Anteriores',
    31 => 'Tags HTML Permitidas:',
    32 => 'Erro, nome de usuário inválido',
    33 => 'Erro, não foi possível gravar no arquivo log',
    34 => 'Erro',
    35 => 'Sair',
    36 => 'em',
    37 => 'No user stories',
    38 => 'Content Syndication',
    39 => 'Atualizar',
    40 => 'You have <tt>register_globals = Off</tt> in your <tt>php.ini</tt>. However, Geeklog requires <tt>register_globals</tt> to be <strong>on</strong>. Before you continue, please set it to <strong>on</strong> and restart your web server.',
    41 => 'Guest Users',
    42 => 'Autoria de:',
    43 => 'Responder',
    44 => 'Comentário Anterior',
    45 => 'Erro MySQL: Número',
    46 => 'Erro MySQL: Mensagem',
    47 => 'Login',
    48 => 'Minha Conta',
    49 => 'Prefs. Exibição',
    50 => 'Erro: SQL statement',
    51 => 'ajuda',
    52 => 'Novo',
    53 => 'Administração',
    54 => 'Não foi possível abrir o arquivo.',
    55 => 'Erro em',
    56 => 'Votar',
    57 => 'Senha',
    58 => 'Entrar',
    59 => "Deseja registrar-se? Clique <a href=\"{$_CONF['site_url']}/users.php?mode=new\">aqui</a>",
    60 => 'Comentar',
    61 => 'Registrar-se',
    62 => 'palavras',
    63 => 'Prefs. Comentários',
    64 => 'Enviar para um Amigo',
    65 => 'Versão para Impressão',
    66 => 'Meu Calendário',
    67 => 'Bem-vindo ao ',
    68 => 'início',
    69 => 'contato',
    70 => 'busca',
    71 => 'contribuir',
    72 => 'links',
    73 => 'enquetes',
    74 => 'calendário',
    75 => 'busca avançada',
    76 => 'estatísticas do site',
    77 => 'Plugins',
    78 => 'Próximos Eventos',
    79 => 'O que há de novo',
    80 => 'histórias nas últimas',
    81 => 'história nas últimas',
    82 => 'horas',
    83 => 'COMENTÁRIOS',
    84 => 'LINKS',
    85 => '48 horas',
    86 => 'Sem novos comentários',
    87 => '14 dias',
    88 => 'Sem novos links',
    89 => 'Não há eventos programados',
    90 => 'Início',
    91 => 'Criou esta página em',
    92 => 'segundos',
    93 => 'Copyright',
    94 => 'Todas as marcas e copyrights nesta página pertencem aos seus respectivos proprietários.',
    95 => 'Powered By',
    96 => 'Grupos',
    97 => 'Lista de Palavras',
    98 => 'Plug-ins',
    99 => 'HISTÓRIAS',
    100 => 'Sem novas histórias',
    101 => 'Seus Eventos',
    102 => 'Eventos do Site',
    103 => 'DB Backups',
    104 => 'por',
    105 => 'Mail Users',
    106 => 'Views',
    107 => 'GL Version Test',
    108 => 'Clear Cache',
    109 => 'Report abuse',
    110 => 'Report this post to the site admin',
    111 => 'View PDF Version',
    112 => 'Registered Users',
    113 => 'Documentation'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => 'Calendário de Eventos',
    2 => 'Lamentamos, mas há não eventos a exibir.',
    3 => 'Quando',
    4 => 'Onde',
    5 => 'Descrição',
    6 => 'Adicionar um Evento',
    7 => 'Próximos Eventos',
    8 => 'Ao adicionar este evento ao seu calendário você poderá ver somente os eventos em que estiver interessado clicando em "Meu Calendário" na área Funções do Usuário.',
    9 => 'Adicionar ao Meu Calendário',
    10 => 'Remover do Meu Calendário',
    11 => "Adicionando Evento ao Calendário de {$_USER['username']}",
    12 => 'Evento',
    13 => 'Início',
    14 => 'Término',
    15 => 'Back to Calendar'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Comentar',
    2 => 'Modo',
    3 => 'Sair',
    4 => 'Criar Conta',
    5 => 'Usuário',
    6 => 'Este site requer que você efetue o login para enviar um comentário.  Se você ainda não tem uma conta, utilize o formulário abaixo para criar uma.',
    7 => 'Seu último comentário foi há',
    8 => " segundos atrás.  Este site requer pelo menos {$_CONF['commentspeedlimit']} segundos entre comentários",
    9 => 'Comentário',
    10 => 'Send Report',
    11 => 'Enviar Comentário',
    12 => 'Por favor, preencha os campos Nome, Email, Título e Comentário, pois eles são necessário para a aceitação de seu comentário.',
    13 => 'Suas Informações',
    14 => 'Preview',
    15 => 'Report this post',
    16 => 'Título',
    17 => 'Erro',
    18 => 'Recomendações',
    19 => 'Por favor, envie mensagens relacionadas ao assunto tratado no tópico.',
    20 => 'Tente responder aos comentários já publicados ao invés de iniciar novos threads.',
    21 => 'Leia as mensagens de outros usuários antes de enviar a sua para prevenir duplicidade de conteúdo.',
    22 => 'Seja descritivo ao preencher o campo Assunto.',
    23 => 'Seu email NÃO será publicado.',
    24 => 'Usuário Anônimo',
    25 => 'Are you sure you want to report this post to the site admin?',
    26 => '%s reported the following abusive comment post:',
    27 => 'Abuse report'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Perfil de',
    2 => 'Nome',
    3 => 'Nome Completo',
    4 => 'Senha',
    5 => 'Email',
    6 => 'Homepage',
    7 => 'Biografia',
    8 => 'PGP Key',
    9 => 'Salvar',
    10 => 'Últimos 10 comentários',
    11 => 'Sem Comentários',
    12 => 'Preferências de Usuário para',
    13 => 'Enviar resumo diário via Email',
    14 => 'Esta senha é gerada aleatoriamente. É recomendado que você altere a mesma imediatamente. Para alterar sua senha, efetue o login e clique em Informações da conta no menu Funções do Usuário.',
    15 => "Sua conta no {$_CONF['site_name']} foi criada. Para ter acesso à mesma, você deve efetuar o login utilizando as informações abaixo. Poor favor, guarde este email para futuras consultas.",
    16 => 'Informações sobre sua Conta',
    17 => 'Conta inexistente',
    18 => 'O endereço fornecido não parece ser um email válido',
    19 => 'O nome de usuário ou o email fornecido já constam em nossa base de dados',
    20 => 'O endereço fornecido não parece ser um email válido',
    21 => 'Erro',
    22 => "Registro no {$_CONF['site_name']}!",
    23 => "Criando uma conta de usuário proporcionará a você todos os benefícios da associação ao {$_CONF['site_name']} e permitirá a você enviar comentários e mensagens em seu nome. Se não tiver uma conta, você só poderá enviar mensagens anonimamente. Por favor, note que seu endereço de email <b><i>nunca</i></b> será exibido publicamente neste site.",
    24 => 'Sua senha será enviada ao endereço de email que você forneceu.',
    25 => 'Esqueceu sua Senha?',
    26 => 'Entre seu nome de usuário e clique em Enviar Senha. Uma nova senha será enviada para o endereço constante em nossos registros.',
    27 => 'Registre-se!',
    28 => 'Enviar Senha',
    29 => 'saiu do',
    30 => 'entrou no',
    31 => 'A função selecionada exige a entrada no sistema',
    32 => 'Assinatura',
    33 => 'Não será exibida publicamente',
    34 => 'Este é o seu nome real',
    35 => 'Entre a senha para alterá-la',
    36 => 'Iniciar com http://',
    37 => 'Aplicada aos seus comentários',
    38 => 'Sobre você. (Qualquer pessoa poderá ler isto) ',
    39 => 'Sua chave pública PGP para ser compartilhada',
    40 => 'Sem ícones nos Tópicos',
    41 => 'Willing to Moderate',
    42 => 'Formato de Datas',
    43 => 'Máximo de Histórias',
    44 => 'Sem caixas',
    45 => 'Preferências de Exibição para',
    46 => 'Ítens Excluídos para',
    47 => 'Configuração do Box de Notícias para',
    48 => 'Tópicos',
    49 => 'Sem ícones nas histórias',
    50 => 'Desmarque se não estiver interessado',
    51 => 'Somente as Notícias',
    52 => 'O padrão é',
    53 => 'Receber as notícias via resumo diário',
    54 => 'Selecione os tópicos e autores que você não quer ver.',
    55 => 'Se você deixar todos desmarcados, subentende-se que você deseja a seleção padrão. Se você iniciar a seleção, lembre-se de selecionar todos os que você deseja, pois a seleção padrão será ignorada. Entradas padrão são exibidas em <b>negrito</b>.',
    56 => 'Autores',
    57 => 'Modo de Exibição',
    58 => 'Ordenar por',
    59 => 'Limite de Comentários',
    60 => 'Como você prefere que os comentários sejam exibidos?',
    61 => 'Novos ou antigos primeiro?',
    62 => 'O padrão é 100',
    63 => "Sua senha foi enviada. Por favor, siga as instruções constantes no email. Obrigado por participar do {$_CONF['site_name']}",
    64 => 'Preferências Atuais para',
    65 => 'Tente Entrar novamente',
    66 => "Você cometeu um erro ao preencher os campos. Por favor, tente efetuar o login novamente. Você é um <a href=\"{$_CONF['site_url']}/users.php?mode=new\">novo usuário</a>?",
    67 => 'Membro Desde',
    68 => 'Lembrar de mim por',
    69 => 'Por quanto tempo você deseja ser lembrado após efetuar o login?',
    70 => "Personalize o layout e o conteúdo do {$_CONF['site_name']}",
    71 => "Uma das características do {$_CONF['site_name']} é a possibilidade poder personalizar todo o seu conteúdo e alterar o layout do site. Para poder usufruir destas vantagens você precisa<a href=\"{$_CONF['site_url']}/users.php?mode=new\">registrar-se</a> no {$_CONF['site_name']}.  Você já é um membro? Efetue o login!",
    72 => 'Tema',
    73 => 'Idioma',
    74 => 'Change what this site looks like!',
    75 => 'Emailed Topics for',
    76 => 'If you select a topic from the list below you will receive any new stories posted to that topic at the end of each day.  Choose only the topics that interest you!',
    77 => 'Photo',
    78 => 'Add a picture of yourself!',
    79 => 'Check here to delete this picture',
    80 => 'Login',
    81 => 'Send Email',
    82 => 'Last 10 stories for user',
    83 => 'Posting statistics for user',
    84 => 'Total number of articles:',
    85 => 'Total number of comments:',
    86 => 'Find all postings by',
    87 => 'Your login name',
    88 => "Someone (possibly you) has requested a new password for your account \"%s\" on {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nIf you really want this action to be taken, please click on the following link:\n\n",
    89 => "If you do not want this action to be taken, simply ignore this message and the request will be disregarded (your password will remain unchanged).\n\n",
    90 => 'You can enter a new password for your account below. Please note that your old password is still valid until you submit this form.',
    91 => 'Set New Password',
    92 => 'Enter New Password',
    93 => 'Your last request for a new password was %d seconds ago. This site requires at least %d seconds between password requests.',
    94 => 'Delete Account "%s"',
    95 => 'Click the "delete account" button below to remove your account from our database. Please note that any stories and comments you posted under this account will <strong>not</strong> be deleted but show up as being posted by "Anonymous".',
    96 => 'delete account',
    97 => 'Confirm Account Deletion',
    98 => 'Are you sure you want to delete your account? By doing so, you will not be able to log into this site again (unless you create a new account). If you are sure, click "delete account" again on the form below.',
    99 => 'Privacy Options for',
    100 => 'Email from Admin',
    101 => 'Allow email from Site Admins',
    102 => 'Email from Users',
    103 => 'Allow email from other users',
    104 => 'Show Online Status',
    105 => 'Show up in Who\'s Online block',
    106 => 'Location',
    107 => 'Shown in your public profile'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Sem notícias para exibir',
    2 => 'Não há novas histórias para exibir. Talvez não haja novidades para este tópico ou suas preferências de exibição são muito restritivas.',
    3 => 'para o tópico %s',
    4 => 'Artigo de Hoje',
    5 => 'Próximo',
    6 => 'Anterior',
    7 => 'First',
    8 => 'Last'
);

###############################################################################
# links.php

$LANG06 = array(
    1 => 'Links',
    2 => 'Não há links a exibir.',
    3 => 'Adicionar Link'
);

###############################################################################
# pollbooth.php

$LANG07 = array(
    1 => 'Voto Registrado',
    2 => 'Seu voto foi registrado.',
    3 => 'Enquete',
    4 => 'Enquetes no Sistema',
    5 => 'Votos',
    6 => 'View other poll questions'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Houve um erro ao enviar sua mensagem. Por favor, tente novamente.',
    2 => 'Mensagem enviada.',
    3 => 'Please make sure you use a valid email address in the Reply To field.',
    4 => 'Por favor, preencha os campos Seu Nome, Responder para, Assunto e Mensagem',
    5 => 'Erro: Usuário desconhecido.',
    6 => 'Há um erro.',
    7 => 'Perfil de Usuário para',
    8 => 'ID',
    9 => 'URL',
    10 => 'Enviar email para',
    11 => 'Seu Nome:',
    12 => 'Responder:',
    13 => 'Assunto:',
    14 => 'Mensagem:',
    15 => 'HTML não será traduzido.',
    16 => 'Enviar Mensagem',
    17 => 'Enviar História para um Amigo',
    18 => 'Nome',
    19 => 'Email',
    20 => 'Seu Nome',
    21 => 'Seu Email',
    22 => 'Todos os campos são requeridos',
    23 => "Este email foi enviado a você por %s em %s pois ele acha que você pode se interessar por um artigo no {$_CONF['site_url']}.  Isto não é um SPAM e os endereço de email envolvidos não são exibidos ou guardados para uso posterior.",
    24 => 'Comentário sobre esta história em',
    25 => 'Você precisa efetuar o login para utilizar este recurso. Ao efetuar o login, você nos ajuda a prevenir o mal-uso do sistema',
    26 => 'Este formulário permite a você enviar um email para o usuário selecionado. Todos os campos são obrigatórios.',
    27 => 'Apresentação',
    28 => '%s escreveu: ',
    29 => "Este é o resumo diário do {$_CONF['site_name']} para ",
    30 => ' Resumo Diário ',
    31 => 'Title',
    32 => 'Date',
    33 => 'Read the full article at',
    34 => 'End of Message',
    35 => 'Sorry, this user prefers not to receive any emails.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Busca Avançada',
    2 => 'Palavras-chave',
    3 => 'Tópico',
    4 => 'Todos',
    5 => 'Tipo',
    6 => 'Histórias',
    7 => 'Comentários',
    8 => 'Autores',
    9 => 'Todos',
    10 => 'Buscar',
    11 => 'Resultados da Busca',
    12 => 'correspondências',
    13 => 'Resultado da Busca: nenhuma correspondência',
    14 => 'Não há correspondência para sua busca em',
    15 => 'Por favor, tente novamente.',
    16 => 'Título',
    17 => 'Data',
    18 => 'Autor',
    19 => "Pesquisar em toda a Base de Dados do {$_CONF['site_name']} ",
    20 => 'Data',
    21 => 'para',
    22 => '(Formato de Data MM-DD-AAAA)',
    23 => 'Hits',
    24 => 'Encontrou',
    25 => 'correspondências para',
    26 => 'itens em',
    27 => 'segundos',
    28 => 'Nenhuma história ou comentário correspondente encontrados',
    29 => 'Resultados: Histórias e Comentário',
    30 => 'No links matched your search',
    31 => 'This plug-in returned no matches',
    32 => 'Event',
    33 => 'URL',
    34 => 'Location',
    35 => 'All Day',
    36 => 'No events matched your search',
    37 => 'Event Results',
    38 => 'Link Results',
    39 => 'Links',
    40 => 'Events',
    41 => 'Your query string should have at least 3 characters.',
    42 => 'Please use a date formatted as YYYY-MM-DD (year-month-day).',
    43 => 'exact phrase',
    44 => 'all of these words',
    45 => 'any of these words',
    46 => 'Next',
    47 => 'Previous',
    48 => 'Author',
    49 => 'Date',
    50 => 'Hits',
    51 => 'Link',
    52 => 'Location',
    53 => 'Story Results',
    54 => 'Comment Results',
    55 => 'the phrase',
    56 => 'AND',
    57 => 'OR'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Estatísticas do Site',
    2 => 'Total de Hits no Sistema',
    3 => 'Histórias(Comentários) no Sistema',
    4 => 'Enquetes(Respostas) no Sistema',
    5 => 'Links(Cliques) no Sistema',
    6 => 'Eventos no Sistema',
    7 => '10 Histórias Mais Lidas',
    8 => 'Título',
    9 => 'Visualizações',
    10 => 'Aparentemente não há histórias neste site ou ninguém leu as que foram publicadas.',
    11 => '10 Histórias Mais Comentadas',
    12 => 'Comentários',
    13 => 'Aparentemente não há histórias neste site ou ninguém comentou as que foram publicadas.',
    14 => '10 Enquetes Mais Votadas',
    15 => 'Pergunta',
    16 => 'Votos',
    17 => 'Aparentemente não há enquetes neste site ou ninguém votou nas existentes.',
    18 => 'Top 10 - Links',
    19 => 'Links',
    20 => 'Hits',
    21 => 'Aparentemente não há links neste site ou ninguém clicou nos existentes.',
    22 => 'Top 10 - Histórias Recomendadas via email',
    23 => 'Emails',
    24 => 'Aparentemente ninguém enviou uma história via email neste site'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'Relacionado',
    2 => 'Enviar para um Amigo',
    3 => 'Versão para Impressão',
    4 => 'Opções da História',
    5 => 'PDF Story Format'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'Para enviar uma %s você precisa efetuar o login.',
    2 => 'Login',
    3 => 'Novo Usuário',
    4 => 'Enviar um Evento',
    5 => 'Enviar um Link',
    6 => 'Enviar uma História',
    7 => 'Login é Requerido',
    8 => 'OK',
    9 => 'Ao enviar informações para utilização neste site nós solicitamos a você que siga as seguintes recomendações...<ul><li>Preencha todos os campos, eles são obrigatórios<li>Forneça informações completas e apuradas<li>Verifique as URLs</ul>',
    10 => 'Título',
    11 => 'Link',
    12 => 'Data de Início',
    13 => 'Data de Término',
    14 => 'Local',
    15 => 'Descrição',
    16 => 'Se outra, especifique',
    17 => 'Categoria',
    18 => 'Outra',
    19 => 'Leia Primeiro',
    20 => 'Erro: Faltando Categoria',
    21 => 'Ao selecionar "Outra" favor indicar um nome',
    22 => 'Erro: Campos em branco',
    23 => 'Por favor, preencha todos os campos do formulário. Todos os campos são obrigatórios.',
    24 => 'Sugestão recebida',
    25 => 'Sua sugestão de %s foi arquivada com sucesso.',
    26 => 'Limite de Velocidade',
    27 => 'Usuário',
    28 => 'Tópico',
    29 => 'História',
    30 => 'Sua última sugestão foi enviada há ',
    31 => " segundos. Este site requer pelo menos {$_CONF['speedlimit']} segundos entre o envio de uma mensagem e outra",
    32 => 'Preview',
    33 => 'Preview da História',
    34 => 'Sair',
    35 => 'Tags HTML não são permitidas',
    36 => 'Modo',
    37 => "Sugerindo um evento ao {$_CONF['site_name']} irá incluí-lo no Calendário Principal, onde os usuários poderão adicioná-lo aos seus Calendários Pessoais. Este recurso <b>NÃO</b> permite a você arquivar seus eventos pessoais como aniversários e celebrações.<br><br>Uma vez enviado, seu evento será remetido ao nosso administrador para verificação, e caso o mesmo seja aprovado, será incluído no Calendário Principal.",
    38 => 'Adicionar Evento ao',
    39 => 'Calendário Principal',
    40 => 'Calendário Pessoal',
    41 => 'Início',
    42 => 'Término',
    43 => 'Evento Diário',
    44 => 'Endereço',
    45 => 'continuação',
    46 => 'Cidade/Distrito',
    47 => 'Estado',
    48 => 'CEP',
    49 => 'Tipo de Evento',
    50 => 'Editar Tipos de Eventos',
    51 => 'Local',
    52 => 'Excluir',
    53 => 'Create Account'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Autenticação Requerida',
    2 => 'Negado! Informações de Login Incorretas',
    3 => 'Senha inválida para o usuário',
    4 => 'Usuário:',
    5 => 'Senha:',
    6 => 'Todos os acessos à área administrativa deste site são monitorados e revisados.<br>Esta página é para uso exclusivo das pessoas autorizadas.',
    7 => 'entrar'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Direitos Insuficientes',
    2 => 'Você não tem permissão para editar este bloco.',
    3 => 'Editor de Blocos',
    4 => 'There was a problem reading this feed (see error.log for details).',
    5 => 'Título',
    6 => 'Tópico',
    7 => 'Todos',
    8 => 'Nível de Acesso',
    9 => 'Ordem',
    10 => 'Tipo',
    11 => 'Portal',
    12 => 'Normal',
    13 => 'Opções - Portal',
    14 => 'RDF URL',
    15 => 'Última Atualizaçao RDF',
    16 => 'Opções - Normal',
    17 => 'Conteúdo',
    18 => 'Por favor, preencha os campos Título, Nível de Securança e Conteúdo',
    19 => 'Gerenciador de Blocos',
    20 => 'Título',
    21 => 'Nível de Segurança',
    22 => 'Tipo',
    23 => 'Ordem',
    24 => 'Tópico',
    25 => 'Para modificar ou excluir um bloco, clique no bloco abaixo. Para criar um bloco, clique em Novo Bloco.',
    26 => 'Layout',
    27 => 'Bloco PHP',
    28 => 'Opções Bloco PHP',
    29 => 'Função do Bloco',
    30 => 'If you would like to have one of your blocks use PHP code, enter the name of the function above.  Your function name must start with the prefix "phpblock_" (e.g. phpblock_getweather).  If it does not have this prefix, your function will NOT be called.  We do this to keep people who may have hacked your Geeklog installation from putting arbitrary function calls that may be harmful to your system.  Be sure not to put empty parenthisis "()" after your function name.  Finally, it is recommended that you put all your PHP Block code in custom_code.php.  That will allow the code to stay with you even when you upgrade to a newer version of Geeklog.',
    31 => 'Erro no Bloco PHP. A função , %s, não existe.',
    32 => 'Error Missing Field(s)',
    33 => 'You must enter the URL to the .rdf file for portal blocks',
    34 => 'You must enter the title and the function for PHP blocks',
    35 => 'You must enter the title and the content for normal blocks',
    36 => 'You must enter the content for layout blocks',
    37 => 'Bad PHP block function name',
    38 => 'Functions for PHP Blocks must have the prefix \'phpblock_\' (e.g. phpblock_getweather).  The \'phpblock_\' prefix is required for security reasons to prevent the execution of arbitrary code.',
    39 => 'Lado',
    40 => 'Esquerdo',
    41 => 'Direito',
    42 => 'You must enter the blockorder and security level for Geeklog default blocks',
    43 => 'Somente na Página Inicial',
    44 => 'Acesso Negado',
    45 => "You are trying to access a block that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/block.php\">go back to the block administration screen</a>.",
    46 => 'Novo Bloco',
    47 => 'Administração',
    48 => 'Nome',
    49 => ' (sem espaços e único)',
    50 => 'URL do Arquivo de Ajuda',
    51 => 'inclua http://',
    52 => 'Se você deixar em branco, o ícone de ajuda para este bloco não será exibido',
    53 => 'Enabled',
    54 => 'save',
    55 => 'cancel',
    56 => 'delete',
    57 => 'Move Block Down',
    58 => 'Move Block Up',
    59 => 'Move block to the right side',
    60 => 'Move block to the left side'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => 'Editor de Eventos',
    2 => 'Error',
    3 => 'Título',
    4 => 'URL',
    5 => 'Início',
    6 => 'Término',
    7 => 'Local',
    8 => 'Descrição',
    9 => '(incluir http://)',
    10 => 'Você deve preencher todos os campos deste formulário!',
    11 => 'Gerenciador de Eventos',
    12 => 'To modify or delete a event, click on that event below.  To create a new event click on new event above.',
    13 => 'Título',
    14 => 'Início',
    15 => 'Término',
    16 => 'Acesso Negado',
    17 => "You are trying to access an event that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/event.php\">go back to the event administration screen</a>.",
    18 => 'Novo Evento',
    19 => 'Administração',
    20 => 'save',
    21 => 'cancel',
    22 => 'delete',
    23 => 'Bad start date.',
    24 => 'Bad end date.',
    25 => 'End date is before start date.'
);

###############################################################################
# admin/link.php

$LANG23 = array(
    1 => 'Editor de Links',
    2 => '',
    3 => 'Título',
    4 => 'URL',
    5 => 'Categoria',
    6 => '(incluir http://)',
    7 => 'Outra',
    8 => 'Hits',
    9 => 'Descrição',
    10 => 'Você deve digitar um Título, um URL e a Descrição.',
    11 => 'Gerenciador de Links',
    12 => 'To modify or delete a link, click on that link below.  To create a new link click new link above.',
    13 => 'Título',
    14 => 'Categoria',
    15 => 'URL',
    16 => 'Acesso Negado',
    17 => "You are trying to access a link that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/link.php\">go back to the link administration screen</a>.",
    18 => 'Novo Link',
    19 => 'Administração',
    20 => 'Se outra, especifique',
    21 => 'save',
    22 => 'cancel',
    23 => 'delete'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Histórias Anteriores',
    2 => 'Próximas Histórias',
    3 => 'Modo',
    4 => 'Formatação',
    5 => 'Editor de Histórias',
    6 => 'There are no stories in the system',
    7 => 'Autor',
    8 => 'save',
    9 => 'preview',
    10 => 'cancel',
    11 => 'delete',
    12 => 'ID',
    13 => 'Título',
    14 => 'Tópico',
    15 => 'Data',
    16 => 'Introdução',
    17 => 'Texto/Conteúdo',
    18 => 'Hits',
    19 => 'Comentários',
    20 => '',
    21 => '',
    22 => 'Lista de Histórias',
    23 => 'To modify or delete a story, click on that story\'s number below. To view a story, click on the title of the story you wish to view. To create a new story click on new story above.',
    24 => 'The ID you chose for this story is already in use. Please use another ID.',
    25 => '',
    26 => 'Preview',
    27 => '',
    28 => '',
    29 => '',
    30 => 'File Upload Errors',
    31 => 'Please fill in the Author, Title and Intro Text fields',
    32 => 'História do Dia',
    33 => 'Só pode haver uma única História do Dia',
    34 => 'Rascunho',
    35 => 'Sim',
    36 => 'Não',
    37 => 'Mais por',
    38 => 'Mais de',
    39 => 'Emails',
    40 => 'Acesso Negado ',
    41 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  You may view the article in read-only below. Please <a href=\"{$_CONF['site_admin_url']}/story.php\">go back to the story administration screen</a> when you are done.",
    42 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  Please <a href=\"{$_CONF['site_admin_url']}/story.php\">go back to the story administration screen</a>.",
    43 => 'Nova História',
    44 => 'Administração',
    45 => 'Acesso',
    46 => '<b>NOTE:</b> if you modify this date to be in the future, this article will not be published until that date.  That also means the story will not be included in your RDF headline feed and it will be ignored by the search and statistics pages.',
    47 => 'Images',
    48 => 'image',
    49 => 'right',
    50 => 'left',
    51 => 'To add one of the images you are attaching to this article you need to insert specially formatted text.  The specially formatted text is [imageX], [imageX_right] or [imageX_left] where X is the number of the image you have attached.  NOTE: You must use the images you attach.  If you do not you will be unable to save your story.<BR><P><B>PREVIEWING</B>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    52 => 'Delete',
    53 => 'was not used.  You must include this image in the intro or body before you can save your changes',
    54 => 'Attached Images Not Used',
    55 => 'The following errors occured while trying to save your story.  Please correct these errors before saving',
    56 => 'Show Topic Icon',
    57 => 'View unscaled image',
    58 => 'Story Management',
    59 => 'Option',
    60 => 'Enabled',
    61 => 'Auto Archive',
    62 => 'Auto Delete'
);

###############################################################################
# admin/poll.php

$LANG25 = array(
    1 => 'Modo',
    2 => 'Please enter a question and at least one answer.',
    3 => 'Enquete Criada',
    4 => 'Enquete %s salva',
    5 => 'Editar Enquete',
    6 => 'ID da Enquete',
    7 => '(não use espaços)',
    8 => 'Exibir na Página Inicial',
    9 => 'Pergunta',
    10 => 'Respostas / Votos',
    11 => 'There was an error getting poll answer data about the poll %s',
    12 => 'There was an error getting poll question data about the poll %s',
    13 => 'Criar Enquete',
    14 => 'save',
    15 => 'cancel',
    16 => 'delete',
    17 => 'Please enter a Poll ID',
    18 => 'Lista de Enquetes',
    19 => 'To modify or delete a poll, click on that poll.  To create a new poll click on new poll above.',
    20 => 'Votantes',
    21 => 'Acesso Negado',
    22 => "You are trying to access a poll that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/poll.php\">go back to the poll administration screen</a>.",
    23 => 'Nova Enquete',
    24 => 'Administração',
    25 => 'Sim',
    26 => 'Não'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Editor de Tópicos',
    2 => 'ID',
    3 => 'Nome',
    4 => 'Imagem',
    5 => '(não use espaços)',
    6 => 'Deleting a topic deletes all stories and blocks associated with it',
    7 => 'Por favor, preencha os campos ID e Nome do Tópico',
    8 => 'Gerenciador de Tópicos',
    9 => 'To modify or delete a topic, click on that topic.  To create a new topic click the new topic button to the left. You will find you access level for each topic in parenthesis',
    10 => 'Ordem de Exibição',
    11 => 'Hístórias/Página',
    12 => 'Acesso Negado',
    13 => "You are trying to access a topic that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/topic.php\">go back to the topic administration screen</a>.",
    14 => 'Ordem',
    15 => 'alfabética',
    16 => 'o padrão é',
    17 => 'Novo Tópico',
    18 => 'Administração',
    19 => 'save',
    20 => 'cancel',
    21 => 'delete',
    22 => 'Default',
    23 => 'make this the default topic for new story submissions',
    24 => '(*)',
    25 => 'Archive Topic',
    26 => 'make this the default topic for archived stories. Only one topic allowed.'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Editor de Usuários',
    2 => 'ID',
    3 => 'User Name',
    4 => 'Nome Completo',
    5 => 'Senha',
    6 => 'Nível de Acesso',
    7 => 'Email',
    8 => 'Homepage',
    9 => '(não use espaços)',
    10 => 'Please fill in the Username, Full name, Security Level and Email Address fields',
    11 => 'Gerenciador de Usuários',
    12 => 'To modify or delete a user, click on that user below.  To create a new user click the new user button to the left.',
    13 => 'Nível de Acesso',
    14 => 'Data Registro.',
    15 => 'Novo Usuário',
    16 => 'Administração',
    17 => 'alterar senha',
    18 => 'cancelar',
    19 => 'excluir',
    20 => 'salvar',
    21 => 'The username you tried saving already exists.',
    22 => 'Erro',
    23 => 'Batch Add',
    24 => 'Batch Import of Users',
    25 => 'You can import a batch of users into Geeklog.  The import file must be a tab-delimited text file and must have the fields in the following order: full name, username, email address.  Each user you import will be emailed with a random password.  You must have one user entered per line.  Failure to follow these instructions will cause problems that may require manual work so double check your entries!',
    26 => 'Search',
    27 => 'Limit Results',
    28 => 'Check here to delete this picture',
    29 => 'Path',
    30 => 'Import',
    31 => 'New Users',
    32 => 'Done processing. Imported %d and encountered %d failures',
    33 => 'submit',
    34 => 'Error: You must specify a file to upload.',
    35 => 'Last Login',
    36 => '(never)'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Aprovar',
    2 => 'Excluir',
    3 => 'Editar',
    4 => 'Profile',
    10 => 'Title',
    11 => 'Start Date',
    12 => 'URL',
    13 => 'Category',
    14 => 'Date',
    15 => 'Topic',
    16 => 'User name',
    17 => 'Full name',
    18 => 'Email',
    34 => 'Comando e Controle',
    35 => 'Story Submissions',
    36 => 'Link Submissions',
    37 => 'Event Submissions',
    38 => 'Enviar',
    39 => 'There are no submissions to moderate at this time',
    40 => 'User Submissions'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => 'Domingo',
    2 => 'Segunda',
    3 => 'Terça',
    4 => 'Quarta',
    5 => 'Quinta',
    6 => 'Sexta',
    7 => 'Sábado',
    8 => 'Adicionar Evento',
    9 => 'Evento do Site',
    10 => 'Eventos para',
    11 => 'Calendário Principal',
    12 => 'Meu Calendário',
    13 => 'Janeiro',
    14 => 'Fevereiro',
    15 => 'Março',
    16 => 'Abril',
    17 => 'Maio',
    18 => 'Junho',
    19 => 'Julho',
    20 => 'Agosto',
    21 => 'Setembro',
    22 => 'Outubro',
    23 => 'Novembro',
    24 => 'Dezembro',
    25 => 'Back to ',
    26 => 'Todos os Dias',
    27 => 'Semanal',
    28 => 'Calendário Pessoal de',
    29 => 'Calendário Público',
    30 => 'excluir evento',
    31 => 'Adicionar',
    32 => 'Evento',
    33 => 'Data',
    34 => 'Hora',
    35 => 'Quick Add',
    36 => 'Enviar',
    37 => 'Lamentamos, mas o Calendário Pessoal não está habilitado neste site',
    38 => 'Editor de Eventos Pessoais',
    39 => 'Day',
    40 => 'Week',
    41 => 'Month'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => 'Mail',
    2 => 'De',
    3 => 'Responder para',
    4 => 'Assunto',
    5 => 'Conteúdo',
    6 => 'Enviar para:',
    7 => 'Todos os Usuários',
    8 => 'Administrador',
    9 => 'Opções',
    10 => 'HTML',
    11 => 'Mensagem Urgente!',
    12 => 'Enviado',
    13 => 'Reset',
    14 => 'Ignorar preferências do usuário ',
    15 => 'Erro ao enviar para: ',
    16 => 'Mensagens enviadas para: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Enviar outra mensagem</a>",
    18 => 'To',
    19 => 'NOTE: if you wish to send a message to all site members, select the Logged-in Users group from the drop down.',
    20 => "Successfully sent <successcount> messages and unsuccessfully sent <failcount> messages.  If you need them, the details of each message attempts is below.  Otherwise you can <a href=\"{$_CONF['site_admin_url']}/mail.php\">Send another message</a> or you can <a href=\"{$_CONF['site_admin_url']}/moderation.php\">go back to the administration page</a>.",
    21 => 'Failures',
    22 => 'Successes',
    23 => 'No failures',
    24 => 'No successes',
    25 => '-- Select Group --',
    26 => 'Please fill in all the fields on the form and select a group of users from the drop down.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system.  It is important that you only install plugins downloaded from the <a href="http://www.geeklog.net" target="_blank">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems.  It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites.  Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin.  In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.',
    2 => 'Plug-in Installation Disclaimer',
    3 => 'Plug-in Installation Form',
    4 => 'Arquivo Plug-in',
    5 => 'Lista de Plug-ins',
    6 => 'Atenção: Plug-in já instalado!',
    7 => 'O plug-in que você está tentando instalar já existe. Remova-o antes de reinstalá-lo',
    8 => 'Houve uma falha durante a verificação de compatibilidade do Plugin',
    9 => 'This plugin requires a newer version of Geeklog. Either upgrade your copy of <a href=http://www.geeklog.net>Geeklog</a> or get a newer version of the plug-in.',
    10 => '<br><b>Não há plugins instalados atualmente.</b><br><br>',
    11 => 'To modify or delete a plug-in, click on that plug-in\'s number below. To learn more about a plug-in, click the plug-in name and you will be directed to that plug-in\'s website. To install or upgrade a plug-in click on new plug-in above.',
    12 => 'no plugin name provided to plugineditor()',
    13 => 'Editor de Plugins',
    14 => 'Novo Plug-in',
    15 => 'Admininistração',
    16 => 'Nome',
    17 => 'Versão',
    18 => 'Versão Geeklog',
    19 => 'Habilitado',
    20 => 'Sim',
    21 => 'Não',
    22 => 'Instalar',
    23 => 'Salvar',
    24 => 'Cancelar',
    25 => 'Excluir',
    26 => 'Nome',
    27 => 'Homepage',
    28 => 'Versão',
    29 => 'Versão Geeklog',
    30 => 'Excluir Plug-in?',
    31 => 'Are you sure you want to delete this plug-in?  By doing so you will remove all the files, data and data structures that this plug-in uses.  If you are sure, click delete again on the form below.',
    32 => '<p><b>Error AutoLink tag not correct format</b></p>',
    33 => 'Code Version',
    34 => 'Update'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'create feed',
    2 => 'save',
    3 => 'delete',
    4 => 'cancel',
    10 => 'Content Syndication',
    11 => 'New Feed',
    12 => 'Admin Home',
    13 => 'To modify or delete a feed, click on the feed\'s title below. To create a new feed, click on New Feed above.',
    14 => 'Title',
    15 => 'Type',
    16 => 'Filename',
    17 => 'Format',
    18 => 'last updated',
    19 => 'Enabled',
    20 => 'Yes',
    21 => 'No',
    22 => '<i>(no feeds)</i>',
    23 => 'all Stories',
    24 => 'Feed Editor',
    25 => 'Feed Title',
    26 => 'Limit',
    27 => 'Length of entries',
    28 => '(0 = no text, 1 = full text, other = limit to that number of chars.)',
    29 => 'Description',
    30 => 'Last Update',
    31 => 'Character Set',
    32 => 'Language',
    33 => 'Contents',
    34 => 'Entries',
    35 => 'Hours',
    36 => 'Select type of feed',
    37 => 'You have at least one plugin installed that supports content syndication. Below you will need to select whether you want to create a Geeklog feed or a feed from one of the plugins.',
    38 => 'Error: Missing Fields',
    39 => 'Please fill in the Feed Title, Description, and Filename.',
    40 => 'Please enter a  number of entries or number of hours.',
    41 => 'Links',
    42 => 'Events'
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "Your password has been emailed to you and should arrive momentarily. Please follow the directions in the message and we thank-you for using {$_CONF['site_name']}",
    2 => "Thank-you for submitting your story to {$_CONF['site_name']}.  It has been submitted to our staff for approval. If approved, your story will be available for others to read on our site.",
    3 => "Thank-you for submitting a link to {$_CONF['site_name']}.  It has been submitted to our staff for approval.  If approved, your link will be seen in the <a href={$_CONF['site_url']}/links.php>links</a> section.",
    4 => "Thank-you for submitting an event to {$_CONF['site_name']}.  It has been submitted to our staff for approval.  If approved, your event will be seen in our <a href={$_CONF['site_url']}/calendar.php>calendar</a> section.",
    5 => 'Your account information has been successfully saved.',
    6 => 'Your display preferences have been successfully saved.',
    7 => 'Your comment preferences have been successfully saved.',
    8 => 'You have been successfully logged out.',
    9 => 'Your story has been successfully saved.',
    10 => 'A história foi excluída com sucesso.',
    11 => 'Your block has been successfully saved.',
    12 => 'O bloco foi excluído com sucesso.',
    13 => 'Your topic has been successfully saved.',
    14 => 'The topic and all it\'s stories an blocks have been successfully deleted.',
    15 => 'Your link has been successfully saved.',
    16 => 'O link foi excluído com sucesso.',
    17 => 'Your event has been successfully saved.',
    18 => 'O evento foi excluído com sucesso.',
    19 => 'Your poll has been successfully saved.',
    20 => 'A enquete foi excluída com sucesso.',
    21 => 'The new user has been successfully saved.',
    22 => 'O usuário foi excluído com sucesso',
    23 => 'Error trying to add an event to your calendar. There was no event id passed.',
    24 => 'The event has been saved to your calendar',
    25 => 'Cannot open your personal calendar until you login',
    26 => 'Event was successfully removed from your personal calendar',
    27 => 'Mensagem enviada com sucesso.',
    28 => 'The plug-in has been successfully saved',
    29 => 'Lamentamos, mas calendários pessoais não estão habilitados neste site',
    30 => 'Acesso Negado',
    31 => 'Sorry, you do not have access to the story administration page.  Please note that all attempts to access unauthorized features are logged',
    32 => 'Sorry, you do not have access to the topic administration page.  Please note that all attempts to access unauthorized features are logged',
    33 => 'Sorry, you do not have access to the block administration page.  Please note that all attempts to access unauthorized features are logged',
    34 => 'Sorry, you do not have access to the link administration page.  Please note that all attempts to access unauthorized features are logged',
    35 => 'Sorry, you do not have access to the event administration page.  Please note that all attempts to access unauthorized features are logged',
    36 => 'Sorry, you do not have access to the poll administration page.  Please note that all attempts to access unauthorized features are logged',
    37 => 'Sorry, you do not have access to the user administration page.  Please note that all attempts to access unauthorized features are logged',
    38 => 'Sorry, you do not have access to the plugin administration page.  Please note that all attempts to access unauthorized features are logged',
    39 => 'Sorry, you do not have access to the mail administration page.  Please note that all attempts to access unauthorized features are logged',
    40 => 'Mensagem do Sistema',
    41 => 'Sorry, you do not have access to the word replacement page.  Please not that all attempts to access unauthorized features are logged',
    42 => 'Your word has been successfully saved.',
    43 => 'A palavra foi excluída com sucesso.',
    44 => 'The plug-in was successfully installed!',
    45 => 'O plug-in foi excluído com sucesso.',
    46 => 'Sorry, you do not have access to the database backup utility.  Please note that all attempts to access unauthorized features are logged',
    47 => 'This functionality only works under *nix.  If you are running *nix as your operating system then your cache has been successfully cleared. If you are on Windows, you will need to search for files name adodb_*.php and remove them manually.',
    48 => "Thank you for applying for a membership with {$_CONF['site_name']}. Our team will review your application. If approved, your password will be emailed to you at the email address you just entered.",
    49 => 'Your group has been successfully saved.',
    50 => 'The group has been successfully deleted.',
    51 => 'This username is already in use. Please choose another one.',
    52 => 'The email address provided does not appear to be a valid email address.',
    53 => 'Your new password has been accepted. Please use your new password below to log in now.',
    54 => 'Your request for a new password has expired. Please try again below.',
    55 => 'An email has been sent to you and should arrive momentarily. Please follow the directions in the message to set a new password for your account.',
    56 => 'The email address provided is already in use for another account.',
    57 => 'Your account has been successfully deleted.',
    58 => 'Your feed has been successfully saved.',
    59 => 'The feed has been successfully deleted.',
    60 => 'The plugin was successfully updated',
    61 => 'Plugin %s: Unknown message placeholder'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Acesso',
    'ownerroot' => 'Proprietário/Root',
    'group' => 'Grupo ',
    'readonly' => 'Somente Leitura',
    'accessrights' => 'Direito de Acesso',
    'owner' => 'Proprietário ',
    'grantgrouplabel' => 'Grant Above Group Edit Rights',
    'permmsg' => 'NOTE: members is all logged in members of the site and anonymous is all users browsing the site that aren\'t logged in.',
    'securitygroups' => 'Security Groups',
    'editrootmsg' => "Even though you are a User Administrator, you can't edit a root user without first being a root user yourself.  You can edit all other users except root users. Please note that all attempts to illegally edit root users are logged.  Please go back to the <a href=\"{$_CONF['site_admin_url']}/user.php\">User Administration page</a>.",
    'securitygroupsmsg' => 'Select the checkboxes for the groups you want the user to belong to.',
    'groupeditor' => 'Editor de Grupos',
    'description' => 'Descrição',
    'name' => 'Nome',
    'rights' => 'Direitos',
    'missingfields' => 'Missing Fields',
    'missingfieldsmsg' => 'You must supply the name and a description for a group',
    'groupmanager' => 'Gerenciador de Grupos',
    'newgroupmsg' => 'To modify or delete a group, click on that group below. To create a new group click new group above. Please note that core groups cannot be deleted because they are used in the system.',
    'groupname' => 'Nome',
    'coregroup' => 'Core Group',
    'yes' => 'Sim',
    'no' => 'Não',
    'corerightsdescr' => "This group is a core {$_CONF['site_name']} Group.  Therefore the rights for this group cannot be edited.  Below is a read-only list of the rights this group has access to.",
    'groupmsg' => 'Security Groups on this site are hierarchical.  By adding this group to any of the groups below you will giving this group the same rights that those groups have.  Where possible it is encouraged you use the groups below to give rights to a group.  If you need this group to have custom rights then you can select the rights to various site features in the section below called \'Rights\'.  To add this group to any of the ones below simply check the box next to the group(s) that you want.',
    'coregroupmsg' => "This group is a core {$_CONF['site_name']} Group.  Therefore the groups that this groups belongs to cannot be edited.  Below is a read-only list of the groups this group belongs to.",
    'rightsdescr' => 'A groups access to a certain right below can be given directly to the group OR to a different group that this group is a part of.  The ones you see below without a checkbox are the rights that have been given to this group because it belongs to another group with that right.  The rights with checkboxes below are rights that can be given directly to this group.',
    'lock' => 'Bloquear',
    'members' => 'Membros',
    'anonymous' => ' Anônimos ',
    'permissions' => 'Permissões',
    'permissionskey' => 'R = ler, E = editar (direito de editar pressupõe direito de ler)',
    'edit' => 'Editar',
    'none' => 'Nenhum',
    'accessdenied' => 'Acesso Negado',
    'storydenialmsg' => "You do not have access to view this story.  This could be because you aren't a member of {$_CONF['site_name']}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF['site_name']} to receive full membership access!",
    'eventdenialmsg' => "You do not have access to view this event.  This could be because you aren't a member of {$_CONF['site_name']}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF['site_name']} to receive full membership access!",
    'nogroupsforcoregroup' => 'This group doesn\'t belong to any of the other groups',
    'grouphasnorights' => 'This group doesn\'t have access to any of the administrative features of this site',
    'newgroup' => 'Novo Grupo',
    'adminhome' => 'Administração',
    'save' => 'salvar',
    'cancel' => 'cancelar',
    'delete' => 'delete',
    'canteditroot' => 'You have tried to edit the Root group but you are not in the Root group yourself therefore your access to this group is denied.  Please contact the system administrator if you feel this is an error',
    'listusers' => 'List Users',
    'listthem' => 'list',
    'usersingroup' => 'Users in group "%s"',
    'usergroupadmin' => 'User Group Administration',
    'add' => 'Add',
    'remove' => 'Remove',
    'availmembers' => 'Available Members',
    'groupmembers' => 'Group Members',
    'canteditgroup' => 'To edit this group, you have to be a member of the group. Please contact the system administrator if you feel this is an error.',
    'cantlistgroup' => 'To see the members of this group, you have to be a member yourself. Please contact the system administrator if you feel this is an error.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => 'Last 10 Back-ups',
    'do_backup' => 'Do Backup',
    'backup_successful' => 'Database back up was successful.',
    'no_backups' => 'No backups in the system',
    'db_explanation' => 'To create a new backup of your Geeklog system, hit the button below',
    'not_found' => "Incorrect path or mysqldump utility not executable.<br>Check <strong>\$_DB_mysqldump_path</strong> definition in config.php.<br>Variable currently defined as: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Backup Failed: Filesize was 0 bytes',
    'path_not_found' => "{$_CONF['backup_path']} does not exist or is not a directory",
    'no_access' => "ERROR: Directory {$_CONF['backup_path']} is not accessible.",
    'backup_file' => 'Backup file',
    'size' => 'Size',
    'bytes' => 'Bytes',
    'total_number' => 'Total number of backups: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Home',
    2 => 'Contact',
    3 => 'Get Published',
    4 => 'Links',
    5 => 'Polls',
    6 => 'Calendar',
    7 => 'Site Stats',
    8 => 'Personalize',
    9 => 'Search',
    10 => 'advanced search'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => '404 Error',
    2 => 'Gee, I\'ve looked everywhere but I can not find <b>%s</b>.',
    3 => "<p>We're sorry, but the file you have requested does not exist. Please feel free to check the <a href=\"{$_CONF['site_url']}\">main page</a> or the <a href=\"{$_CONF['site_url']}/search.php\">search page</a> to see if you can find what you lost."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Login required',
    2 => 'Sorry, to access this area you need to be logged in as a user.',
    3 => 'Login',
    4 => 'New User'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'The PDF feature has been disabled',
    2 => 'The document provided was not rendered. The document was received but could not be processed.  Please make sure to submit only html formatted documents that have been written to the xHTML standard. Please note that overly complex html documents may not render correctly or at all.The document resulting from your attempt was 0 bytes in length, and has been deleted. If you\'re sure that your document should render fine, please re-submit it.',
    3 => 'Unknown error during PDF generation',
    4 => "No page data was given or you want to use the ad-hoc PDF generation tool below.  If you think you are getting this page\n          in error then please contact the system administrator.  Otherwise, you may use the form below to generate PDF's in an ad-hoc fashion.",
    5 => 'Loading your document.',
    6 => 'Please wait while your document is loaded.',
    7 => 'You may right click the button below and choose \'save target...\' or \'save link location...\' to save a copy of your document.',
    8 => "The path given in the configuration file to the HTMLDoc binary is invalid or this system cannot execute it.  Please contact the site administrator if this problem\n          persists.",
    9 => 'PDF Generator',
    10 => "This is the Ad-hoc PDF Generation tool. It will attempt to convert any URL you give into a PDF.  Please note that some web pages will not render properly with this feature.  This\n           is a limitation of the HTMLDoc PDF generation tool and such errors should not be reported to the administrators of this site",
    11 => 'URL',
    12 => 'Generate PDF!',
    13 => 'The PHP configuration on this server does not allow URLs to be used with the fopen() command.  The system administrator must edit the php.ini file and set allow_url_fopen to On',
    14 => 'The PDF you requested either does not exist or you tried to illegally access a file.'
);

?>
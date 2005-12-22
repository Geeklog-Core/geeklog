<?php

###############################################################################
# portuguese_brazil.php
# Esta é a página em Português do Brasil para o GeekLog!
# Agradecimentos especiais para Mischa Polivanov pelo seu trabalho neste projeto
#
# Copyright (C) 2002 Dener C. Brito - LAST UPDATE: March 26,2002
# dener@crube.net
#
# Revisado e Atualizado em 28/Fevereiro/2005 por Alcides Soares Filho
# asoaresfil@uol.com.br - arquivo versão 1.3.11
#
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
    10 => 'Submissões',
    11 => 'Publicações',
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
    30 => 'Publicações Anteriores',
    31 => 'Tags HTML Permitidas:',
    32 => 'Erro, nome de usuário inválido',
    33 => 'Erro, não foi possível gravar no arquivo log',
    34 => 'Erro',
    35 => 'Sair',
    36 => 'em',
    37 => 'Não há publicações de usuários',
    38 => 'Assinatura de Conteúdos',
    39 => 'Atualizar',
    40 => 'Você tem <tt>register_globals = Off</tt> no seu arquivo <tt>php.ini</tt>. O Geeklog requer <tt>register_globals</tt> colocado como <strong>on</strong>. Antes de continuar, faça esse ajuste para <strong>on</strong> e reinicialize seu servidor WEB.',
    41 => 'Usuários Convidados',
    42 => 'Autoria de:',
    43 => 'Responder',
    44 => 'Comentário Anterior',
    45 => 'Erro MySQL: Número',
    46 => 'Erro MySQL: Mensagem',
    47 => 'Login',
    48 => 'Minha Conta',
    49 => 'Preferências de Exibição',
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
    63 => 'Preferências de Comentários',
    64 => 'Enviar para um Amigo',
    65 => 'Versão para Impressão',
    66 => 'Meu Calendário',
    67 => 'Bem-vindo à ',
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
    80 => 'publicações nas últimas',
    81 => 'publicação nas últimas',
    82 => 'horas',
    83 => 'COMENTÁRIOS',
    84 => 'LINKS',
    85 => '48 horas',
    86 => 'Sem novos comentários',
    87 => '14 dias',
    88 => 'Sem novos links',
    89 => 'Não há eventos programados',
    90 => 'Homepage Principal',
    91 => 'Criou esta página em',
    92 => 'segundos',
    93 => 'Copyright',
    94 => 'Todas as marcas e copyrights nesta página pertencem aos seus respectivos proprietários.',
    95 => 'Patrocinado por',
    96 => 'Grupos',
    97 => 'Lista de Palavras',
    98 => 'Plugins',
    99 => 'HISTÓRIAS',
    100 => 'Sem novas publicações',
    101 => 'Seus Eventos',
    102 => 'Eventos do Site',
    103 => 'Backups do DB',
    104 => 'por',
    105 => 'E-Mail para usuários',
    106 => 'Leituras',
    107 => 'Teste da Versão Geeklog',
    108 => 'Limpa Cachê',
    109 => 'Reporta abuso',
    110 => 'Reporta este envio para a administração do site',
    111 => 'Vê Versão PDF',
    112 => 'Usuários Registrados',
    113 => 'Documentação',
    114 => 'TRACKBACKS',
    115 => 'No new trackback comments',
    116 => 'Trackback',
    117 => 'Directory',
    118 => 'Please continue reading on the next page:',
    119 => "Lost your <a href=\"{$_CONF['site_url']}/users.php?mode=getpassword\">password</a>?",
    120 => 'Permanent link to this comment',
    121 => 'Comments (%d)',
    122 => 'Trackbacks (%d)',
    123 => 'All HTML is allowed'
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
    15 => 'Volta para Calendário'
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
    7 => 'Seu último comentário foi há ',
    8 => " segundos atrás.  Este site requer pelo menos {$_CONF['commentspeedlimit']} segundos entre comentários",
    9 => 'Comentário',
    10 => 'Enviar Relatório',
    11 => 'Enviar Comentário',
    12 => 'Por favor, preencha os campos Nome, E-mail, Título e Comentário, pois eles são necessários para a aceitação de seu comentário.',
    13 => 'Suas Informações',
    14 => 'Prevê',
    15 => 'Reporta este envio',
    16 => 'Título',
    17 => 'Erro',
    18 => 'Recomendações',
    19 => 'Por favor, envie mensagens relacionadas ao assunto tratado no tópico.',
    20 => 'Tente responder aos comentários já publicados ao invés de iniciar novos threads (um novo ramo).',
    21 => 'Leia as mensagens de outros usuários antes de enviar a sua para prevenir duplicidade de conteúdo.',
    22 => 'Seja descritivo ao preencher o campo Assunto.',
    23 => 'Seu e-mail NÃO será publicado.',
    24 => 'Usuário Anônimo',
    25 => 'Tem certeza que quer reportar este envio para a administração do site?',
    26 => '%s reportou o seguinte envio considerado abusivo:',
    27 => 'Reporta Comentário Abusivo'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Perfil de',
    2 => 'Nome',
    3 => 'Nome Completo',
    4 => 'Senha',
    5 => 'E-mail',
    6 => 'Homepage',
    7 => 'Biografia',
    8 => 'Chave PGP',
    9 => 'Salvar',
    10 => 'Últimos 10 comentários',
    11 => 'Sem Comentários',
    12 => 'Preferências de Usuário para',
    13 => 'Enviar resumo diário via E-mail',
    14 => 'Esta senha é gerada aleatoriamente. É recomendado que você altere a mesma imediatamente. Para alterar sua senha, efetue o login e clique em Informações da conta no menu Funções do Usuário.',
    15 => "Sua conta no {$_CONF['site_name']} foi criada. Para ter acesso à mesma, você deve efetuar o login utilizando as informações abaixo. Por favor, guarde este e-mail para futuras consultas.",
    16 => 'Informações sobre sua Conta',
    17 => 'Conta inexistente',
    18 => 'O endereço fornecido não parece ser um e-mail válido',
    19 => 'O nome de usuário ou o e-mail fornecido já constam em nossa base de dados',
    20 => 'O endereço fornecido não parece ser um e-mail válido',
    21 => 'Erro',
    22 => "Registro no {$_CONF['site_name']}!",
    23 => "Criando uma conta de usuário proporcionará a você todos os benefícios da associação ao site {$_CONF['site_name']} - o que permitirá a você enviar comentários e mensagens em seu nome. Se não tiver uma conta, você só poderá enviar mensagens anonimamente. Por favor, note que seu endereço de e-mail <b><i>nunca</i></b> será exibido publicamente neste site.",
    24 => 'Sua senha será enviada ao endereço de e-mail que você forneceu.',
    25 => 'Esqueceu sua Senha?',
    26 => 'Entre com seu nome de usuário e clique em Enviar Senha. Uma nova senha será enviada para o endereço constante em nossos registros.',
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
    41 => 'Aguardando Moderação',
    42 => 'Formato de Datas',
    43 => 'Máximo de Publicações',
    44 => 'Sem caixas',
    45 => 'Preferências de Exibição para',
    46 => 'Itens Excluídos para',
    47 => 'Configuração da Caixa de Notícias para',
    48 => 'Tópicos',
    49 => 'Sem ícones nas publicações',
    50 => 'Desmarque se não estiver interessado',
    51 => 'Somente as Notícias',
    52 => 'O padrão é',
    53 => 'Receber as notícias via resumo diário',
    54 => 'Selecione os tópicos e autores que você <b>não</b> quer ver.',
    55 => 'Se você deixar todos desmarcados, subentende-se que você deseja a seleção padrão. Se você iniciar a seleção, lembre-se de selecionar todos os que você deseja, pois a seleção padrão será ignorada. Entradas padrão são exibidas em <b>negrito</b>.',
    56 => 'Autores',
    57 => 'Modo de Exibição',
    58 => 'Ordenar por',
    59 => 'Limite de Comentários',
    60 => 'Como você prefere que os comentários sejam exibidos?',
    61 => 'Novos ou antigos primeiro?',
    62 => 'O padrão é 100',
    63 => "Sua senha foi enviada. Por favor, siga as instruções constantes no e-mail. Obrigado por participar do {$_CONF['site_name']}",
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
    74 => 'Muda a aparência de todo o site!',
    75 => 'Tópicos enviados por e-mail para',
    76 => 'Se você selecionar um tópico da lista abaixo, você receberá toda e qualquer nova publicação que for enviada para cada tópico escolhido, em geral no final de cada dia. Escolha SOMENTE os tópicos que realmente interessam para você!',
    77 => 'Foto',
    78 => 'Adicione a sua Foto!',
    79 => 'Marque aqui para apagar esta foto',
    80 => 'Login',
    81 => 'Envia E-mail',
    82 => 'Últimas 10 publicações para o usuário',
    83 => 'Estatísticas de Envios para o usuário',
    84 => 'Número total de publicações:',
    85 => 'Número total de comentários:',
    86 => 'Encontra todos os Envios postados por',
    87 => 'Seu nome de Login',
    88 => "Alguém (provavelmente você) requisitou uma nova senha para a sua conta \"%s\" no site {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nSe você realmente quer obter uma nova senha, por favor clique no seguinte link:\n\n",
    89 => "Se você NÃO quer uma nova senha, simplesmente ignore esta mensagem. O pedido NÃO será processado (e sua senha permanecerá inalterada).\n\n",
    90 => 'Você pode entrar com uma nova senha para a sua conta, logo abaixo. Por favor observe que sua antiga senha será válida até que você submeta este formulário com sucesso.',
    91 => 'Define Nova Senha',
    92 => 'Entra com Nova Senha',
    93 => 'Seu último pedido para uma nova senha foi feito %d segundos atrás. Este site requer pelo menos %d segundos de intervalo entre pedidos de novas senhas.',
    94 => 'Apaga a Conta "%s"',
    95 => 'Clique no botão abaixo "Apaga a Conta" para remover sua conta de nosso banco de dados. Por favor observe que quaisquer publicações e comentários enviados através desta conta  <strong>NÃO</strong> serão apagados e serão mostrados como se tivessem sido postados por  "Anônimos".',
    96 => 'apaga conta',
    97 => 'Confirmação de Apagar a Conta',
    98 => 'Tem certeza que quer apagar sua conta? Depois disso, você não conseguirá entrar neste site novamente (a menos que crie uma nova conta). Se você tem certeza, clique em  "apaga conta" novamente no formulário abaixo.',
    99 => 'Opções de Privacidade para',
    100 => 'E-mail da Administração',
    101 => 'Permite e-mail da Administração do Site',
    102 => 'E-mail de Usuários',
    103 => 'Permite e-mail vindos de outros usuários',
    104 => 'Mostra seu Status on-line',
    105 => 'aparece no bloco Quem está on-line',
    106 => 'Localidade',
    107 => 'Mostra no seu perfil público',
    108 => 'Confirm new password',
    109 => 'Enter the New password again here',
    110 => 'Current Password',
    111 => 'Please enter your Current password',
    112 => 'You have exceeded the number of allowed login attempts.  Please try again later.',
    113 => 'Login Attempt Failed',
    114 => 'Account Disabled',
    115 => 'Your account has been disabled, you may not login. Please contact an Administrator.',
    116 => 'Account Awaiting Activation',
    117 => 'Your account is currently awaiting activation by an administrator. You will not be able to login until your account has been approved.',
    118 => "Your {$_CONF['site_name']} account has now been activated by an administrator. You may now login to the site at the url below using your username (<username>) and password as previously emailed to you.",
    119 => 'If you have forgotten your password, you may request a new one at this url:',
    120 => 'Account Activated',
    121 => 'Service',
    122 => 'Sorry, new user registration is disabled',
    123 => "Are you a <a href=\"{$_CONF['site_url']}/users.php?mode=new\">new user</a>?"
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Sem notícias para exibir',
    2 => 'Não há novas publicações para exibir. Talvez não haja novidades para este tópico ou suas preferências de exibição são muito restritivas.',
    3 => 'para o Tópico %s',
    4 => 'Artigo de Hoje',
    5 => 'Próximo',
    6 => 'Anterior',
    7 => 'Primeiro',
    8 => 'Último'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Houve um erro ao enviar sua mensagem. Por favor, tente novamente.',
    2 => 'Mensagem enviada.',
    3 => 'Por favor utilize um endereço de e-mail válido no campo de Reply.',
    4 => 'Por favor, preencha os campos Seu Nome, Responder para, Assunto e Mensagem',
    5 => 'Erro: Usuário desconhecido.',
    6 => 'Há um erro.',
    7 => 'Perfil de Usuário para',
    8 => 'ID',
    9 => 'URL',
    10 => 'Enviar e-mail para',
    11 => 'Seu Nome:',
    12 => 'Responder:',
    13 => 'Assunto:',
    14 => 'Mensagem:',
    15 => 'HTML não será traduzido.',
    16 => 'Enviar Mensagem',
    17 => 'Enviar Publicação para um Amigo',
    18 => 'Nome',
    19 => 'E-mail',
    20 => 'Seu Nome',
    21 => 'Seu E-mail',
    22 => 'Todos os campos são requeridos',
    23 => "Este e-mail foi enviado a você por %s em %s pois ele acha que você pode se interessar por um artigo no {$_CONF['site_url']}.  Isto não é um SPAM e os endereços de e-mail envolvidos não são exibidos ou guardados para uso posterior.",
    24 => 'Comentários sobre esta publicação em',
    25 => 'Você precisa efetuar o login para utilizar este recurso. Ao efetuar o login, você nos ajuda a prevenir o mal-uso do sistema',
    26 => 'Este formulário permite a você enviar um e-mail para o usuário selecionado. Todos os campos são obrigatórios.',
    27 => 'Apresentação',
    28 => '%s escreveu: ',
    29 => "Este é o resumo diário do {$_CONF['site_name']} para ",
    30 => ' Resumo Diário ',
    31 => 'Título',
    32 => 'Data',
    33 => 'Leia o artigo na íntegra em ',
    34 => 'Fim da Mensagem',
    35 => 'Desculpe-nos, mas este usuário definiu em suas preferências que não quer receber e-mails.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Busca Avançada',
    2 => 'Palavras-chave',
    3 => 'Tópico',
    4 => 'Todos',
    5 => 'Tipo',
    6 => 'Publicações',
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
    23 => 'Leituras',
    24 => 'Encontrou',
    25 => 'correspondências para',
    26 => 'itens em',
    27 => 'segundos',
    28 => 'Nenhuma publicação ou comentário correspondente foi encontrado',
    29 => 'Resultados: Publicações e Comentários',
    30 => 'Nenhum link combinou com a sua pesquisa',
    31 => 'Nenhum plugin combinou com sua pesquisa',
    32 => 'Evento',
    33 => 'URL',
    34 => 'Localidade',
    35 => 'Dia inteiro',
    36 => 'Nenhum evento combinou com sua pesquisa',
    37 => 'Resultado da Pesquisa de Eventos',
    38 => 'Resultado da Pesquisa de Links',
    39 => 'Links',
    40 => 'Eventos',
    41 => 'Sua palavra de pesquisa deve ter no mínimo 3 caracteres.',
    42 => 'Por favor utilize a data formatada como YYYY-MM-DD (ano-mês-dia).',
    43 => 'frase exata',
    44 => 'todas estas palavras',
    45 => 'qualquer uma destas palavras',
    46 => 'Próximo',
    47 => 'Prévio',
    48 => 'Autor',
    49 => 'Data',
    50 => 'Leituras',
    51 => 'Link',
    52 => 'Localidade',
    53 => 'Resultado da Pesquisa de Publicações',
    54 => 'Resultado da Pesquisa de Comentários',
    55 => 'e a frase',
    56 => 'AND',
    57 => 'OR',
    58 => 'More results &gt;&gt;',
    59 => 'Results',
    60 => 'per page',
    61 => 'Refine search'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Estatísticas do Site',
    2 => 'Total de Hits no Sistema',
    3 => 'Publicações(Comentários) no Sistema',
    4 => 'Enquetes(Respostas) no Sistema',
    5 => 'Links(Cliques) no Sistema',
    6 => 'Eventos no Sistema',
    7 => '10 Publicações Mais Lidas',
    8 => 'Título',
    9 => 'Visualizações',
    10 => 'Aparentemente não há publicações neste site ou ninguém leu as que foram publicadas.',
    11 => '10 Publicações Mais Comentadas',
    12 => 'Comentários',
    13 => 'Aparentemente não há publicações neste site ou ninguém comentou as que foram publicadas.',
    14 => '10 Enquetes Mais Votadas',
    15 => 'Pergunta',
    16 => 'Votos',
    17 => 'Aparentemente não há enquetes neste site ou ninguém votou nas existentes.',
    18 => 'Top 10 - Links',
    19 => 'Links',
    20 => 'Hits',
    21 => 'Aparentemente não há links neste site ou ninguém clicou nos existentes.',
    22 => 'Top 10 - Publicações Recomendadas via e-mail',
    23 => 'E-mails',
    24 => 'Aparentemente ninguém enviou uma publicação via e-mail neste site',
    25 => 'Top Ten Trackback Commented Stories',
    26 => 'No trackback comments found.',
    27 => 'Number of active users',
    28 => 'Top Ten Events',
    29 => 'Event',
    30 => 'Hits',
    31 => 'It appears that there are no events on this site or no one has ever clicked on one.'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'Relacionado',
    2 => 'Enviar para um Amigo',
    3 => 'Versão para Impressão',
    4 => 'Opções da Publicação',
    5 => 'Formato de Publicação PDF'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'Para enviar uma %s você precisa efetuar o login.',
    2 => 'Login',
    3 => 'Novo Usuário',
    4 => 'Enviar um Evento',
    5 => 'Enviar um Link',
    6 => 'Enviar uma Publicação',
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
    29 => 'Publicação',
    30 => 'Sua última sugestão foi enviada há ',
    31 => " segundos. Este site requer pelo menos {$_CONF['speedlimit']} segundos entre o envio de uma mensagem e outra",
    32 => 'Pré-vê',
    33 => 'Pré-vê a Publicação',
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
    53 => 'Criar Conta'
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
    4 => 'Houve um problema de leitura com este RSS/feed (veja arquivo error.log para saber detalhes).',
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
    15 => 'Última Atualização RDF',
    16 => 'Opções - Normal',
    17 => 'Conteúdo',
    18 => 'Por favor, preencha os campos Título, Nível de Segurança e Conteúdo',
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
    30 => 'Se você quiser ter um dos seus blocos usando código PHP, entre com o nome da função acima.  O nome da sua função DEVE começar com o prefixo "phpblock_" (p.e. phpblock_getweather).  Se sua função NÃO tiver este prefixo, ela NÃO será chamada pelo programa.  Fizemos isto para evitar que sejam utilizadas funções que podem ser perigosas para o sistema.  Esteja certo de colocar um parênteses "()" logo depois do nome da sua função.  Finalmente, recomendamos que você SEMPRE  coloque todo o seu código de BLOCOS PHP dentro do arquivo  custom_code.php.  Isto permitirá que SEU código seja preservado quando você fizer o UPGRADE para uma nova versão do Geeklog.',
    31 => 'Erro no Bloco PHP. A função , %s, não existe.',
    32 => 'Erro, Faltando Campo(s)',
    33 => 'Você DEVE entrar com a URL para o arquivo .rdf para os blocos do portal',
    34 => 'Você DEVE entrar com o título E a função para os blocos PHP',
    35 => 'Você DEVE entrar com o título E o conteúdo para os blocos normais',
    36 => 'Você DEVE entrar com o conteúdo para os blocos de layout',
    37 => 'Nome de função Errado para o bloco de PHP',
    38 => 'Funções para Blocos PHP Blocks DEVEM ter o prefixo \'phpblock_\' (p.e. phpblock_getweather).  O prefixo \'phpblock_\' prefix é requerido por razões de segurança, evitando a execução de códigos arbitrários.',
    39 => 'Lado',
    40 => 'Esquerdo',
    41 => 'Direito',
    42 => 'Você DEVE entrar com a ordem do bloco e com o nível de segurança para os blocos padrão do Geeklog',
    43 => 'Somente na Página Inicial',
    44 => 'Acesso Negado',
    45 => "Você está tentando acessar um bloco para o qual não tem autorização.  Esta tentativa foi registrada. Favor <a href=\"{$_CONF['site_admin_url']}/block.php\">retorna para a tela de Administração de Blocos</a>.",
    46 => 'Novo Bloco',
    47 => 'Administração',
    48 => 'Nome',
    49 => ' (sem espaços e único)',
    50 => 'URL do Arquivo de Ajuda',
    51 => 'inclua http://',
    52 => 'Se você deixar em branco, o ícone de ajuda para este bloco não será exibido',
    53 => 'Habilitado',
    54 => 'salva',
    55 => 'cancela',
    56 => 'apaga',
    57 => 'Move Bloco para Baixo',
    58 => 'Move Bloco para Cima',
    59 => 'Move bloco para Lado Direito',
    60 => 'Move bloco para Lado Esquerdo',
    61 => 'No Title',
    62 => 'Article Limit',
    63 => 'Bad Block Title',
    64 => 'Your Title must not be empty and cannot contain HTML!',
    65 => 'Order'
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
    12 => 'Para modificar ou apagar um evento, clique no respectivo evento abaixo.  Para criar um novo evento, clique em Novo Evento, acima.',
    13 => 'Título',
    14 => 'Início',
    15 => 'Término',
    16 => 'Acesso Negado',
    17 => "Você está acessando um evento para o qual não tem autorização.  Esta tentativa foi registrada. Por favor <a href=\"{$_CONF['site_admin_url']}/event.php\">retorne para a tela de Administração de Eventos</a>.",
    18 => 'Novo Evento',
    19 => 'Administração',
    20 => 'salva',
    21 => 'cancela',
    22 => 'apaga',
    23 => 'Data de início incorreta.',
    24 => 'Data final incorreta.',
    25 => 'Data Final é menor que Data Inicial.'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Publicações Anteriores',
    2 => 'Próximas Publicações',
    3 => 'Modo',
    4 => 'Formatação',
    5 => 'Editor de Publicações',
    6 => 'Não há publicações no sistema',
    7 => 'Autor',
    8 => 'salva',
    9 => 'pré-ver',
    10 => 'cancela',
    11 => 'apaga',
    12 => 'ID',
    13 => 'Título',
    14 => 'Tópico',
    15 => 'Data',
    16 => 'Introdução',
    17 => 'Texto/Conteúdo',
    18 => 'Leituras',
    19 => 'Comentários',
    20 => 'Ping',
    21 => 'Send Ping',
    22 => 'Lista de Publicações',
    23 => 'Para modificar ou apagar uma publicação, clique no número da publicação abaixo. Para ler uma publicação, clique no título da mesma. Para criar uma publicação nova, clique em Nova Publicação, acima.',
    24 => 'O número de identificação - ID - que você escolheu para esta publicação já está em uso. Por favor escolha um outro número de identificação - ID.',
    25 => 'Error when saving story',
    26 => 'Prevê',
    27 => 'If you use [unscaledX] instead of [imageX], the image will be inserted at its original dimensions.',
    28 => '<p><b>PREVIEWING</b>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    29 => 'Trackbacks',
    30 => 'Erros no Upload de arquivos',
    31 => 'Por favor preencha os campos Autor, Título and e Texto de Introdução',
    32 => 'Publicação do Dia',
    33 => 'Só pode haver uma única Publicação do Dia',
    34 => 'Rascunho',
    35 => 'Sim',
    36 => 'Não',
    37 => 'Mais por',
    38 => 'Mais de',
    39 => 'E-mails',
    40 => 'Acesso Negado ',
    41 => "Você está tentando acessar uma publicação para a qual você não tem autorização.  Sua tentativa foi registrada.  Você pode ler esta publicação, mas não pode editar, clicando abaixo. Por favor <a href=\"{$_CONF['site_admin_url']}/story.php\">retorne para a tela de Administração de Publicações</a> quando estiver pronto.",
    42 => "Você está tentando acessar uma publicação para a qual não tem autorização. Esta tentativa foi registrada.  Por favor <a href=\"{$_CONF['site_admin_url']}/story.php\">retorne para a tela de Administração de Publicações.</a>.",
    43 => 'Nova Publicação',
    44 => 'Administração',
    45 => 'Acesso',
    46 => '<b>NOTE:</b> se você modificar esta data de forma que ela fique no futuro, esta publicação não aparecerá até o início dessa data futura.  Isto também significa que esta publicação não será incluída nos arquivos de assinatura RDF e que será ignorado nas páginas de pesquisa e de estatísticas.',
    47 => 'Imagens',
    48 => 'imagem',
    49 => 'LEFT',
    50 => 'RIGHT',
    51 => 'Para adicionar uma das imagens que você está anexando a este artigo (publicação) , você tem de inserir (no texto) um pequeno texto especialmente formatado. Este texto formatado deve ser [imageX], [imageX_right] ou [imageX_left] (com os colchetes) onde X é o número da imagem que você está anexando.  NOTA: Você DEVE usar as imagens que você anexa. Se você NÃO fizer isso, NÃO conseguirá salvar a sua publicação.<BR><P><B>PREVENDO A PUBLICAÇÃO</B>: Se você quiser pré-ver uma publicação com imagens anexadas, a melhor prática é salvar a publicação como RASCUNHO ao invés de usar o botão Pré-ver. Somente use o botão de pré-ver quando NÃO tiver imagens anexadas.',
    52 => 'Apaga',
    53 => 'não foi utilizada.  Você DEVE incluir esta imagem na introdução ou no corpo da publicação ANTES de salvar suas alterações',
    54 => 'Imagens Anexadas não Utilizadas',
    55 => 'Os seguintes erros ocorreram enquanto sua publicação estava sendo salva. Por favor corrija esse erros antes de salvar novamente.',
    56 => 'Mostra Ícone do Tópico',
    57 => 'Vê imagem sem escala',
    58 => 'Gerenciamento de Publicações',
    59 => 'Opção',
    60 => 'Permitido',
    61 => 'Auto Arquiva',
    62 => 'Auto Apaga',
    63 => '',
    64 => '',
    65 => '',
    66 => '',
    67 => 'Expand the Content Edit Area size',
    68 => 'Reduce the Content Edit Area size',
    69 => 'Publish Story Date',
    70 => 'Toolbar Selection',
    71 => 'Basic Toolbar',
    72 => 'Common Toolbar',
    73 => 'Advanced Toolbar',
    74 => 'Advanced II Toolbar',
    75 => 'Full Featured',
    76 => 'Publish Options',
    77 => 'Javascript needs to be enabled for Advanced Editor. Option can be disabled in the main site config.php',
    78 => 'Click <a href="%s/story.php?mode=edit&amp;sid=%s&amp;editopt=default">here</a> to use default editor'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Editor de Tópicos',
    2 => 'ID',
    3 => 'Nome',
    4 => 'Imagem',
    5 => '(não use espaços)',
    6 => 'Ao apagar um tópico, são apagados todas as publicações e blocos associados a esse tópico',
    7 => 'Por favor, preencha os campos ID e Nome do Tópico',
    8 => 'Gerenciador de Tópicos',
    9 => 'Para modificar ou apagar um tópico, clique sobre o nome do tópico.  Para criar um novo tópico, clique no botar Criar Novo Tópico à esquerda. Você irá ver o seu nível de acesso para cada tópico dentro de parênteses',
    10 => 'Ordem de Exibição',
    11 => 'Publicações/Página',
    12 => 'Acesso Negado',
    13 => "Você está tentando acessar um tópico para o qual não tem autorização. Sua tentativa foi registrada. Por favor <a href=\"{$_CONF['site_admin_url']}/topic.php\">retorne para a tela de Administração de Tópicos</a>.",
    14 => 'Ordem',
    15 => 'alfabética',
    16 => 'o padrão é',
    17 => 'Novo Tópico',
    18 => 'Administração',
    19 => 'salva',
    20 => 'cancela',
    21 => 'apaga',
    22 => 'Padrão',
    23 => 'faça deste o tópico padrão para novas submissões de publicações',
    24 => '(*)',
    25 => 'Arquiva Tópico',
    26 => 'faça deste o tópico padrão para publicações arquivadas. Somente um tópico é permitido.',
    27 => 'Or Upload Topic Icon',
    28 => 'Maximum',
    29 => 'File Upload Errors'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Editor de Usuários',
    2 => 'ID',
    3 => 'Nome de Usuário',
    4 => 'Nome Completo',
    5 => 'Senha',
    6 => 'Nível de Segurança',
    7 => 'E-mail',
    8 => 'Homepage',
    9 => '(não use espaços)',
    10 => 'Por favor preencha os campos Nome de Usuário, Nome Completo, Nível de Segurança e E-mail',
    11 => 'Gerenciador de Usuários',
    12 => 'Para modificar ou apagar um usuário, clique sobre o usuário abaixo. Para criar um novo usuário, clique no botão Novo Usuário à esquerda.',
    13 => 'Nível de Acesso',
    14 => 'Data Registro.',
    15 => 'Novo Usuário',
    16 => 'Administração',
    17 => 'alterar senha',
    18 => 'cancelar',
    19 => 'excluir',
    20 => 'salvar',
    21 => 'O nome de usuário que você está tentando usar já existe.',
    22 => 'Erro',
    23 => 'Adiciona Lote (Batch)',
    24 => 'Importação de Usuários em Lote (Batch)',
    25 => 'Você pode importar um lote (batch) de usuários no Geeklog.  O arquivo de importação DEVE ser um arquivo TEXTO, delimitado por tab (tabulador) e conter os seguintes campos na seguinte ordem: : nome completo, nome de usuário, endereço de e-mail.  Cada usuário que você importar receberá uma senha, criada de forma aleatória.  Você deve ter apenas um usuário por linha de entrada. Falhas ao seguir estas instruções irão causar problemas sérios, que irão requerer trabalho manual. Por isso, faça uma dupla verificação de tudo antes de fazer a importação!',
    26 => 'Pesquisa',
    27 => 'Limita Resultados',
    28 => 'Clique aqui para apagar esta imagem',
    29 => 'Path',
    30 => 'Importa',
    31 => 'Novos Usuários',
    32 => 'Processamento realizado. Foram feitas %d importações e encontradas %d falhas',
    33 => 'envia',
    34 => 'Erro: Você deve especificar um arquivo para upload.',
    35 => 'Último Login',
    36 => '(nunca)',
    37 => 'UID',
    38 => 'Group Listing',
    39 => 'Password (again)',
    40 => 'Registration Date',
    41 => 'Last login Date',
    42 => 'Banned',
    43 => 'Awaiting Activation',
    44 => 'Awaiting Authorization',
    45 => 'Active',
    46 => 'User Status',
    47 => 'Edit'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Aprovar',
    2 => 'Excluir',
    3 => 'Editar',
    4 => 'Perfil',
    10 => 'Título',
    11 => 'Data de Início',
    12 => 'URL',
    13 => 'Categoria',
    14 => 'Data',
    15 => 'Tópico',
    16 => 'Nome de usuário',
    17 => 'Nome Completo',
    18 => 'E-mail',
    34 => 'Comando e Controle',
    35 => 'Submissões de Publicações',
    36 => 'Submissões de Links',
    37 => 'Submissões de Eventos',
    38 => 'Enviar',
    39 => 'Não há submissões a serem moderadas agora',
    40 => 'Submissões de Usuários'
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
    25 => 'Volta para ',
    26 => 'Todos os Dias',
    27 => 'Semanal',
    28 => 'Calendário Pessoal de',
    29 => 'Calendário Público',
    30 => 'excluir evento',
    31 => 'Adicionar',
    32 => 'Evento',
    33 => 'Data',
    34 => 'Hora',
    35 => 'Adição Rápida',
    36 => 'Enviar',
    37 => 'Lamentamos, mas o Calendário Pessoal não está habilitado neste site',
    38 => 'Editor de Eventos Pessoais',
    39 => 'Dia',
    40 => 'Semana',
    41 => 'Mês'
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
    13 => 'Limpa',
    14 => 'Ignorar preferências do usuário ',
    15 => 'Erro ao enviar para: ',
    16 => 'Mensagens enviadas para: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Enviar outra mensagem</a>",
    18 => 'Para',
    19 => 'NOTA: se você pretende mandar uma mensagem para todos os membros do site, selecione o grupo de usuários Logged-in no menu de seleção.',
    20 => "Foram enviadas com sucesso <successcount> mensagens and <failcount> mensagens apresentaram falha.  Se você precisar, os detalhes de cada mensagem é mostrado abaixo.  Caso necessário você pode <a href=\"{$_CONF['site_admin_url']}/mail.php\">Enviar outra mensagem</a> ou então você pode <a href=\"{$_CONF['site_admin_url']}/moderation.php\">retornar à página de administração</a>.",
    21 => 'Falhas',
    22 => 'Sucessos',
    23 => 'Sem falhas',
    24 => 'Sem sucessos',
    25 => '-- Selecione Grupo --',
    26 => 'Por favor preencha os campos no formulário e selecione um grupo de usuários no menu.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'A instalação de plugins pode causar danos à sua instalação padrão do Geeklog e, possivelmente, até para seu sistema.  Por isso é importante que você só instale plugins que foram baixados de <a href="http://www.geeklog.net" target="_blank">Geeklog Homepage</a>, uma vez que nós testamos todos os plugins enviados para o site em uma variedade de sistemas operacionais.  É importante que você compreenda que o processo de instalação de um plugin irá requerer a execução de alguns comandos de arquivos de sistema - que podem causar problemas de segurança especialmente se você utilizar plugins de outros sites. Mesmo que você tome todos os cuidados que estamos propondo, nós não podemos garantir o sucesso de qualquer instalação e nem podemos nos responsabilizar por quaisquer danos causados na instalação de um Plugin Geeklog.  Em outras palavras, todo o risco de qualquer instalação é seu. Sempre siga as indicações de como instalar manualmente um plugin. Estas instruções sempre vem no pacote de cada instalação.',
    2 => 'Plug-in Disclaimer de Instalação',
    3 => 'Plug-in Formulário de Instalação',
    4 => 'Arquivo Plug-in',
    5 => 'Lista de Plugins',
    6 => 'Atenção: Plug-in já instalado!',
    7 => 'O plug-in que você está tentando instalar já existe. Remova-o antes de reinstalá-lo',
    8 => 'Houve uma falha durante a verificação de compatibilidade do Plugin',
    9 => 'Este plugin requer uma nova versão do Geeklog. Procure fazer uma atualização da sua cópia do<a href=http://www.geeklog.net>Geeklog</a>  e ou busque uma nova versão do plugin.',
    10 => '<br><b>Não há plugins instalados atualmente.</b><br><br>',
    11 => 'Para modificar ou apagar um plug-in, clique no número do plug-in abaixo. Para aprender mais sobre o plug-in, clique no nome do plug-in e você será direcionado para o site do plug-in. Para instalar ou atualizar um plug-in , clique em Novo Plug-in acima.',
    12 => 'nenhum nome de plugin foi fornecido para o plugineditor()',
    13 => 'Editor de Plugins',
    14 => 'Novo Plug-in',
    15 => 'Administração',
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
    31 => 'Tem certeza que quer apagar este plug-in?  Ao fazer isso você vai remover todos os arquivos, dados e estruturas de dados que este plug-in utiliza.  Se você tem certeza, clique em Apaga novamente no formulário a seguir.',
    32 => '<p><b>Erro: tag AutoLink não está no formato correto</b></p>',
    33 => 'Versão do Código',
    34 => 'Atualiza',
    35 => 'Edit',
    36 => 'Code',
    37 => 'Data',
    38 => 'Update!'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'cria novo feed',
    2 => 'salva',
    3 => 'apaga',
    4 => 'cancela',
    10 => 'Assinatura de Conteúdos',
    11 => 'Novo Feed',
    12 => 'Home Administrativa',
    13 => 'Para modificar ou apagar um feed, clique no título do feed, abaixo. Para criar um novo feed, clique em Novo Feed, acima.',
    14 => 'Título',
    15 => 'Tipo',
    16 => 'Nome do Arquivo',
    17 => 'Formato',
    18 => 'última atualização',
    19 => 'Permitido',
    20 => 'Sim',
    21 => 'Não',
    22 => '<i>(sem feeds)</i>',
    23 => 'todas Publicações',
    24 => 'Editor de Feed',
    25 => 'Título do Feed',
    26 => 'Limite',
    27 => 'Comprimento das entradas',
    28 => '(0 = sem texto, 1 = texto inteiro, outro número = limita a este número de caracteres.)',
    29 => 'Descrição',
    30 => 'Última Atualização',
    31 => 'Set de Caracteres',
    32 => 'Linguagem',
    33 => 'Conteúdos',
    34 => 'Entradas',
    35 => 'Horas',
    36 => 'Seleciona tipo de feed',
    37 => 'Você tem ao menos um plugin instalado que suporta assinatura de conteúdos. Abaixo você precisará selecionar se você quer criar um feed Geeklog feed ou criar um feed através de um dos plugins.',
    38 => 'Erro: Faltando preencher campos',
    39 => 'Por favor preencha Título do Feed, Descrição e Nome do Arquivo.',
    40 => 'Por favor defina um número de entradas ou um número de horas.',
    41 => 'Links',
    42 => 'Eventos',
    43 => 'All',
    44 => 'None',
    45 => 'Header-link in topic',
    46 => 'Limit Results',
    47 => 'Search',
    48 => 'Edit',
    49 => 'Feed Logo',
    50 => "Relative to site url ({$_CONF['site_url']})"
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "Sua senha foi mandada por e-mail para você e deve chegar em breve. Por favor siga as instruções na mensagem e muito obrigado por usar o site {$_CONF['site_name']}",
    2 => "Muito obrigado por registrar sua publicação no site {$_CONF['site_name']}.  Ela será submetida ao nosso pessoal de staff para aprovação. Se aprovada, sua publicação ficará disponível para todos os outros usuários que acessarem o nosso site.",
    3 => "Muito obrigado por registrar um link no site {$_CONF['site_name']}.  Ele será submetido ao nosso pessoal de staff para aprovação.  Se aprovado, seu link será visto na seção de links em <a href={$_CONF['site_url']}/links.php>links</a>.",
    4 => "Muito obrigado por inscrever um Evento no site {$_CONF['site_name']}.  Ele será submetido ao nosso pessoal de staff para aprovação.  Se aprovado, seu Evento estará em nossa seção <a href={$_CONF['site_url']}/calendar.php>Calendário</a>.",
    5 => 'A informação de sua conta foi salva com sucesso.',
    6 => 'Suas preferências de tela (display) foram salvas com sucesso.',
    7 => 'Suas preferências de Comentários foram salvas com sucesso.',
    8 => 'Seu micro foi desconectado do site com sucesso (logout).',
    9 => 'Sua publicação foi salva com sucesso.',
    10 => 'A publicação foi excluída com sucesso.',
    11 => 'Seu bloco foi salvo com sucesso.',
    12 => 'O bloco foi excluído com sucesso.',
    13 => 'Seu tópico foi salvo com sucesso.',
    14 => 'O tópico e todas suas publicações e blocos foram apagados com sucesso.',
    15 => 'Seu link foi salvo com sucesso.',
    16 => 'O link foi excluído com sucesso.',
    17 => 'Seu evento foi incluído com sucesso.',
    18 => 'O evento foi excluído com sucesso.',
    19 => 'Sua enquete foi salva com sucesso.',
    20 => 'A enquete foi excluída com sucesso.',
    21 => 'O novo usuário foi salvo com sucesso.',
    22 => 'O usuário foi excluído com sucesso',
    23 => 'Erro ao tentar adicionar um Evento ao seu Calendário. Não foi informada nenhuma identidade (ID) para o evento.',
    24 => 'O evento foi salvo com sucesso no seu calendário',
    25 => 'Não é possível abrir seu calendário pessoal de você não efetuar seu login.',
    26 => 'O evento foi removido com sucesso de seu calendário pessoal',
    27 => 'Mensagem enviada com sucesso.',
    28 => 'O plug-in foi salvo com sucesso',
    29 => 'Lamentamos, mas calendários pessoais não estão habilitados neste site',
    30 => 'Acesso Negado',
    31 => 'Lamentamos, mas você não tem acesso a pagina de Administração de Publicações.  Por favor note que todas as tentativas de acesso não autorizado ficam registradas.',
    32 => 'Lamentamos, mas você não tem acesso a pagina de Administração de Tópicos.  Por favor note que todas as tentativas de acesso não autorizado ficam registradas.',
    33 => 'Lamentamos, mas você não tem acesso a pagina de Administração de Blocos.  Por favor note que todas as tentativas de acesso não autorizado ficam registradas.',
    34 => 'Lamentamos, mas você não tem acesso a pagina de Administração de Links.  Por favor note que todas as tentativas de acesso não autorizado ficam registradas.',
    35 => 'Lamentamos, mas você não tem acesso a pagina de Administração de Eventos.  Por favor note que todas as tentativas de acesso não autorizado ficam registradas.',
    36 => 'Lamentamos, mas você não tem acesso a pagina de Administração de Enquetes.  Por favor note que todas as tentativas de acesso não autorizado ficam registradas.',
    37 => 'Lamentamos, mas você não tem acesso a pagina de Administração de Usuários.  Por favor note que todas as tentativas de acesso não autorizado ficam registradas.',
    38 => 'Lamentamos, mas você não tem acesso a pagina de Administração de Plugins.  Por favor note que todas as tentativas de acesso não autorizado ficam registradas.',
    39 => 'Lamentamos, mas você não tem acesso a pagina de Administração de Mail.  Por favor note que todas as tentativas de acesso não autorizado ficam registradas.',
    40 => 'Mensagem do Sistema',
    41 => 'Lamentamos, mas você não tem acesso à página de substituição de palavras.  Por favor note que todas as tentativas de acesso não autorizado ficam registradas.',
    42 => 'Sua palavra foi registrada com sucesso.',
    43 => 'A palavra foi excluída com sucesso.',
    44 => 'O plug-in foi instalado com sucesso!',
    45 => 'O plug-in foi excluído com sucesso.',
    46 => 'Lamentamos, mas você não tem acesso ao utilitário de backup do banco de dados.  Por favor note que todas as tentativas de acesso não autorizado ficam registradas.',
    47 => 'Esta funcionalidade só opera em sistemas do padrão *nix.  Se você estiver rodando  *nix como seu sistema operacional, então o seu cachê foi limpo com sucesso. Se você roda em Windows, você precisará pesquisar os arquivos com nome adodb_*.php and removê-los manualmente.',
    48 => "Muito obrigado por se inscrever como membro do site {$_CONF['site_name']}. Nossa equipe irá revisar a sua inscrição. Se aprovada, sua senha será enviada por e-mail para o endereço com o qual você se registrou.",
    49 => 'Seu grupo foi salvo com sucesso.',
    50 => 'Seu grupo foi apagado com sucesso.',
    51 => 'Este nome de usuário já está sendo usado por outra pessoa. Por favor escolha um outro.',
    52 => 'O endereço de e-mail fornecido não parece ser um endereço de e-mail válido.',
    53 => 'Sua nova senha foi aceita. Por favor utilize a nova senha abaixo para fazer o login agora.',
    54 => 'Seu pedido de uma nova senha expirou. Por favor tente novamente abaixo.',
    55 => 'Um e-mail foi enviado para você e deve chegar em breve. Por favor siga as instruções nele contidas para definir uma nova senha para a sua conta.',
    56 => 'O endereço de e-mail fornecido já está em uso por outra pessoa.',
    57 => 'Sua conta foi apagada com sucesso.',
    58 => 'Seu feed foi salvo com sucesso.',
    59 => 'Seu feed foi apagado com sucesso.',
    60 => 'O plugin foi atualizado com sucesso',
    61 => 'Plugin %s: mensagem de local desconhecido',
    62 => 'The trackback comment has been deleted.',
    63 => 'An error occurred when deleting the trackback comment.',
    64 => 'Your trackback comment has been successfully sent.',
    65 => 'Weblog directory service successfully saved.',
    66 => 'The weblog directory service has been deleted.',
    67 => 'The new password does not match the confirmation password!',
    68 => 'You have to enter the correct current password.',
    69 => 'Your account has been blocked!',
    70 => 'Your account is awaiting administrator approval.',
    71 => 'Your account has now been confirmed and is awaiting administrator approval.',
    72 => 'An error occured while attempting to install the plugin. See error.log for details.',
    73 => 'An error occured while attempting to uninstall the plugin. See error.log for details.',
    74 => 'The pingback has been successfully sent.',
    75 => 'Trackbacks must be sent using a POST request.'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Acesso',
    'ownerroot' => 'Proprietário/Raiz',
    'group' => 'Grupo ',
    'readonly' => 'Somente Leitura',
    'accessrights' => 'Direito de Acesso',
    'owner' => 'Proprietário ',
    'grantgrouplabel' => 'Concede Direitos de Edição para o Grupo Acima',
    'permmsg' => 'NOTA: Membros equivale a todos usuários que estão plugados com login no momento e Anônimos equivale a todos usuários que estão navegando no site no momento mas NÃO fizeram seu login.',
    'securitygroups' => 'Grupos de Segurança',
    'editrootmsg' => "Mesmo que você seja um Usuário Administrador, você não pode editar um usuário raiz se você mesmo também não for um usuário raiz. Você pode editar todos os outros usuários, exceto usuários da raiz. Por favor note que todas tentativas ilegais de tentar editar usuário raiz ficam registradas. Por favor retorne para a <a href=\"{$_CONF['site_admin_url']}/user.php\">página de Administração de Usuários</a>.",
    'securitygroupsmsg' => 'Selecione os checkboxes para os grupos que você quer que o usuário venha a pertencer.',
    'groupeditor' => 'Editor de Grupos',
    'description' => 'Descrição',
    'name' => 'Nome',
    'rights' => 'Direitos',
    'missingfields' => 'Campos Faltantes',
    'missingfieldsmsg' => 'Você DEVE fornecer o Nome e a Descrição para um grupo',
    'groupmanager' => 'Gerenciador de Grupos',
    'newgroupmsg' => 'Para modificar ou apagar um grupo, clique no grupo abaixo. Para criar um novo grupo, clique em Novo Grupo, acima. Por favor note que os grupos que são core groups - e não podem ser apagados - pois eles são usados pelo sistema.',
    'groupname' => 'Nome',
    'coregroup' => 'Core Group',
    'yes' => 'Sim',
    'no' => 'Não',
    'corerightsdescr' => "Este grupo é um Grupo Core do site {$_CONF['site_name']}.  Desta forma, os direitos para este grupo NÃO podem ser editados.  Abaixo segue uma lista somente para leitura dos direitos que este grupo tem acesso.",
    'groupmsg' => 'Grupos de Segurança, neste site, são hierárquicos. Ao adicionar este grupo a qualquer um dos grupos abaixo, você estará dando a este grupo os mesmos direitos que aqueles grupos têm. Encorajamos você a, sempre que for possível, usar os grupos abaixo para dar direitos a um novo grupo.  Se você depois precisar que este grupo tenha direitos específicos você pode selecionar os direitos dos diversos recursos do site na seção abaixo chamada  \'Direitos\'.  Para adicionar este grupo a qualquer um dos grupos abaixo, simplesmente marque o box próximo ao(s) grupo(s) que você quiser.',
    'coregroupmsg' => "Este grupo é um Grupo Core do site {$_CONF['site_name']}.  Desta forma, os grupos a que este grupo pertence não podem ser editados.  Abaixo segue uma lista apenas para leitura dos grupos s que este grupo pertence.",
    'rightsdescr' => 'O acesso de um grupo a um determinado direito, abaixo, pode ser dado diretamente para o grupo OU para um grupo diferente - a que este grupo pertença. Os que você vê abaixo sem o checkbox marcado são direitos dados a este grupo por que ele pertence a um outro grupo que já tem esses direitos. Os direitos com checkboxes, abaixo, são direitos que podem ser dados diretamente a este grupo.',
    'lock' => 'Bloquear',
    'members' => 'Membros',
    'anonymous' => ' Anônimos ',
    'permissions' => 'Permissões',
    'permissionskey' => 'R = ler, E = editar (direito de editar pressupõe direito de ler)',
    'edit' => 'Editar',
    'none' => 'Nenhum',
    'accessdenied' => 'Acesso Negado',
    'storydenialmsg' => "Você não tem acesso para ver esta publicação.  Isto pode ocorrer porque você ainda não é membro do site {$_CONF['site_name']}.  Por favor <a href=users.php?mode=new> torne-se um membro</a> do {$_CONF['site_name']} para receber direitos plenos de acesso!",
    'eventdenialmsg' => "Você não tem acesso para ver este evento.  Isto pode ocorrer porque você ainda não é membro do site {$_CONF['site_name']}.  Por favor <a href=users.php?mode=new> torne-se um membro</a> do {$_CONF['site_name']} para receber direitos plenos de acesso!",
    'nogroupsforcoregroup' => 'Este grupo não pertence a qualquer um dos outros grupos',
    'grouphasnorights' => 'Este grupo não tem acesso a quaisquer recursos de administração deste site',
    'newgroup' => 'Novo Grupo',
    'adminhome' => 'Administração',
    'save' => 'salvar',
    'cancel' => 'cancelar',
    'delete' => 'apagar',
    'canteditroot' => 'Você tentou editar o Grupo raiz. Mas você mesmo não pertence ao grupo raiz e, por este motivo, seu acesso não é permitido.  Por favor, contate o administrador do sistema se você acha que isto é um erro.',
    'listusers' => 'Lista de Usuários',
    'listthem' => 'lista',
    'usersingroup' => 'Usuários no Grupo "%s"',
    'usergroupadmin' => 'Administração de Usuários no Grupo',
    'add' => 'Adiciona',
    'remove' => 'Remove',
    'availmembers' => 'Membros Disponíveis',
    'groupmembers' => 'Membros do Grupo',
    'canteditgroup' => 'Para editar este grupo, você tem de ser membro do grupo. Por favor, contate o administrador do sistema se você acha que isto é um erro.',
    'cantlistgroup' => 'Para ver os membros deste grupo, você também tem que ser um membro deste grupo. Por favor, contate o administrador do sistema se você acha que isto é um erro.',
    'editgroupmsg' => 'To modify the group membership, click on the member names(s) and use the add or remove buttons. If the member is a member of the group, their name will appear on the right side only. Once you are complete - press <b>Save</b> to update the group and return to the main group admin page.',
    'listgroupmsg' => 'Listing of all current members in the group: <b>%s</b>',
    'search' => 'Search',
    'submit' => 'Submit',
    'limitresults' => 'Limit Results',
    'group_id' => 'Group ID',
    'plugin_access_denied_msg' => 'You are illegally trying access a plugin administration page.  Please note that all attempts to illegally access this page are logged.',
    'groupexists' => 'Group name already exists',
    'groupexistsmsg' => 'There is already a group with this name. Group names must be unique.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => 'Últimos 10 Backups',
    'do_backup' => 'Fazer Backup',
    'backup_successful' => 'Backup do banco de dados feito com sucesso.',
    'db_explanation' => 'Para criar um novo backup do seu sistema Geeklog, clique o botão abaixo',
    'not_found' => "Path (caminho) incorreto ou utilitário chamado mysqldump não está executando.<br>Verifique <strong>\$_DB_mysqldump_path</strong> - definição que está no arquivo config.php.<br>Essa variável está no momento definida como: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Backup Falhou: tamanho do arquivo com 0 bytes',
    'path_not_found' => "{$_CONF['backup_path']} não existe ou não é um diretório",
    'no_access' => "ERRO: Diretório {$_CONF['backup_path']} não está acessível.",
    'backup_file' => 'Arquivo de Backup',
    'size' => 'Tamanho',
    'bytes' => 'Bytes',
    'total_number' => 'Número total de backups: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Homepage',
    2 => 'Contato',
    3 => 'Publique um Artigo',
    4 => 'Links',
    5 => 'Enquetes',
    6 => 'Calendário',
    7 => 'Estatísticas do Site',
    8 => 'Personalização do Site',
    9 => 'Pesquisa site',
    10 => 'pesquisa avançada',
    11 => 'Directory'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => 'Erro 404',
    2 => 'Gee, travei em algum lugar mas não posso encontrar o local <b>%s</b>.',
    3 => "<p>Lamentamos, mas o arquivo que você pediu não existe mais. Por favor fique a vontade para verificar a <a href=\"{$_CONF['site_url']}\">página principal</a> ou a <a href=\"{$_CONF['site_url']}/search.php\">página de pesquisa</a> para ver se você acha o que não encontrou."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Login é requerido',
    2 => 'Lamentamos mas, para acessar esta área você deve fazer o login como um usuário.',
    3 => 'Login',
    4 => 'Novo Usuário'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'O recurso de PDF está desabilitado',
    2 => 'O documento fornecido não foi processado no formato PDF. O documento foi recebido, mas não pode ser processado. Por favor verifique se foram submetidos documentos formatados contendo somente comandos html que foram escritos para o padrão xHTML. Por favor note que documentos html muito complexos podem não processar corretamente ou simplesmente nem processarem (processo chamado de renderização). O documento resultante de sua tentativa ficou com 0 bytes de tamanho - e foi apagado. Se você tem certeza que o documento pode ser processado - renderizado - resubmeta o mesmo.',
    3 => 'Erro desconhecido na geração do PDF',
    4 => "Não foi fornecida uma página com dados ou você que usar a ferramenta de geração de PDF ad-hoc, abaixo.  Se você pensa que está tendo erro nesta página\n          por favor contate o administrador do sistema.  Ou então você pode usar o formulário abaixo para gerar o PDF com um aspecto ad-hoc.",
    5 => 'Carregando seu documento.',
    6 => 'Por favor aguarde enquanto seu documento é carregado.',
    7 => 'Você pode dar um clique com o botão direito do mouse no botão abaixo e escolher\'Salva em...\' ou \'Salva num link...\' para salvar a copia do seu documento.',
    8 => 'O path (caminho) fornecido no arquivo de configuração (para o arquivo binário HTMLDoc) é inválido ou o sistema não pode executá-lo. Por favor contate o administrador do site se este problema persistir.',
    9 => 'Gerador de PDF',
    10 => "Esta é ferramenta de Geração de PDF Ad-hoc. Ela tentará converter qualquer URL fornecida num documento PDF. Por favor fique ciente que algumas páginas não irão renderizar perfeitamente com este recurso.  Esta\n           é uma limitação da ferramenta e os erros desta natureza não devem ser reportados para o administrador do site",
    11 => 'URL',
    12 => 'Gerar PDF!',
    13 => 'A configuração PHP deste servidor não permite que URLs sejam usadas com o comando  fopen().  O administrador do sistema deve editar o arquivo php.ini file e definir o parâmetro allow_url_fopen como On',
    14 => 'O PDF que você requisitou ou não existe ou você tentou acessar este arquivo de forma ilegal.'
);

###############################################################################
# trackback.php

$LANG_TRB = array(
    'trackback' => 'Trackback',
    'from' => 'from',
    'tracked_on' => 'Tracked on',
    'read_more' => '[read more]',
    'intro_text' => 'Here\'s what others have to say about \'%s\':',
    'no_comments' => 'No trackback comments for this entry.',
    'this_trackback_url' => 'Trackback URL for this entry:',
    'num_comments' => '%d trackback comments',
    'send_trackback' => 'Send Pings',
    'preview' => 'Preview',
    'editor_title' => 'Send trackback comment',
    'trackback_url' => 'Trackback URL',
    'entry_url' => 'Entry URL',
    'entry_title' => 'Entry Title',
    'blog_name' => 'Site Name',
    'excerpt' => 'Excerpt',
    'truncate_warning' => 'Note: The receiving site may truncate your excerpt',
    'button_send' => 'Send',
    'button_preview' => 'Preview',
    'send_error' => 'Error',
    'send_error_details' => 'Error when sending trackback comment:',
    'url_missing' => 'No Entry URL',
    'url_required' => 'Please enter at least a URL for the entry.',
    'target_missing' => 'No Trackback URL',
    'target_required' => 'Please enter a trackback URL',
    'error_socket' => 'Could not open socket.',
    'error_response' => 'Response not understood.',
    'error_unspecified' => 'Unspecified error.',
    'select_url' => 'Select Trackback URL',
    'not_found' => 'Trackback URL not found',
    'autodetect_failed' => 'Geeklog could not detect the Trackback URL for the post you want to send your comment to. Please enter it manually below.',
    'trackback_explain' => 'From the links below, please select the URL you want to send your Trackback comment to. Geeklog will then try to determine the correct Trackback URL for that post. Or you can <a href="%s">enter it manually</a> if you know it already.',
    'no_links_trackback' => 'No links found. You can not send a Trackback comment for this entry.',
    'pingback' => 'Pingback',
    'pingback_results' => 'Pingback results',
    'send_pings' => 'Send Pings',
    'send_pings_for' => 'Send Pings for "%s"',
    'no_links_pingback' => 'No links found. No Pingbacks were sent for this entry.',
    'pingback_success' => 'Pingback sent.',
    'no_pingback_url' => 'No pingback URL found.',
    'resend' => 'Resend',
    'ping_all_explain' => 'You can now notify the sites you linked to (<a href="http://en.wikipedia.org/wiki/Pingback">Pingback</a>), advertise that your site has been updated by pinging weblog directory services, or send a <a href="http://en.wikipedia.org/wiki/Trackback">Trackback</a> comment in case you wrote about a post on someone else\'s site.',
    'pingback_button' => 'Send Pingback',
    'pingback_short' => 'Send Pingbacks to all sites linked from this entry.',
    'pingback_disabled' => '(Pingback disabled)',
    'ping_button' => 'Send Ping',
    'ping_short' => 'Ping weblog directory services.',
    'ping_disabled' => '(Ping disabled)',
    'trackback_button' => 'Send Trackback',
    'trackback_short' => 'Send a Trackback comment.',
    'trackback_disabled' => '(Trackback disabled)',
    'may_take_a_while' => 'Please note that sending Pingbacks and Pings may take a while.',
    'ping_results' => 'Ping results',
    'unknown_method' => 'Unknown ping method',
    'ping_success' => 'Ping sent.',
    'error_site_name' => 'Please enter the site\'s name.',
    'error_site_url' => 'Please enter the site\'s URL.',
    'error_ping_url' => 'Please enter a valid Ping URL.',
    'no_services' => 'No weblog directory services configured.',
    'services_headline' => 'Weblog Directory Services',
    'service_explain' => 'To modify or delete a weblog directory service, click on the edit icon of that service below. To add a new weblog directory service, click on "Create New" above.',
    'service' => 'Service',
    'ping_method' => 'Ping method',
    'service_website' => 'Website',
    'service_ping_url' => 'URL to ping',
    'ping_standard' => 'Standard Ping',
    'ping_extended' => 'Extended Ping',
    'ping_unknown' => '(unknown method)',
    'edit_service' => 'Edit Weblog Directory Service',
    'trackbacks' => 'Trackbacks',
    'editor_intro' => 'Prepare your trackback comment for <a href="%s">%s</a>.',
    'editor_intro_none' => 'Prepare your trackback comment.',
    'trackback_note' => 'To send a trackback comment for a story, go to the list of stories and click on "Send Ping" for the story. To send a trackback that is not related to a story, <a href="%s">click here</a>.',
    'pingback_explain' => 'Enter a URL to send the Pingback to. The pingback will point to your site\'s homepage.',
    'pingback_url' => 'Pingback URL',
    'site_url' => 'This site\'s URL',
    'pingback_note' => 'To send a pingback for a story, go to the list of stories and click on "Send Ping" for the story. To send a pingback that is not related to a story, <a href="%s">click here</a>.',
    'pbtarget_missing' => 'No Pingback URL',
    'pbtarget_required' => 'Please enter a pingback URL',
    'pb_error_details' => 'Error when sending the pingback:'
);

###############################################################################
# directory.php

$LANG_DIR = array(
    'title' => 'Article Directory',
    'title_year' => 'Article Directory for %d',
    'title_month_year' => 'Article Directory for %s %d',
    'nav_top' => 'Back to Article Directory',
    'no_articles' => 'No articles.'
);

###############################################################################
# "What's New" Time Strings
# 
# For the first two strings, you can use the following placeholders.
# Order them so it makes sense in your language:
# %i    item, "Stories"
# %n    amount, "2", "20" etc.
# %t    time, "2" (weeks)
# %s    scale, "hrs", "weeks"

$LANG_WHATSNEW = array(
    'new_string' => '%n new %i in the last %t %s',
    'new_last' => 'last %t %s',
    'minutes' => 'minutes',
    'hours' => 'hours',
    'days' => 'days',
    'weeks' => 'weeks',
    'months' => 'months',
    'minute' => 'minute',
    'hour' => 'hour',
    'day' => 'day',
    'week' => 'week',
    'month' => 'month'
);

###############################################################################
# Admin - Strings
# 
# These are some standard strings used by core functions as well as plugins to
# display administration lists and edit pages

$LANG_ADMIN = array(
    'search' => 'Search',
    'limit_results' => 'Limit Results',
    'submit' => 'Submit',
    'edit' => 'Edit',
    'admin_home' => 'Admin Home',
    'create_new' => 'Create New',
    'enabled' => 'Enabled',
    'title' => 'Title',
    'type' => 'Type',
    'topic' => 'Topic',
    'help_url' => 'Help File URL',
    'save' => 'Save',
    'cancel' => 'Cancel',
    'delete' => 'Delete',
    'copy' => 'Copy',
    'no_results' => '- No entries found -',
    'data_error' => 'There was an error processing the subscription data. Please check the data source.'
);

###############################################################################
# Localisation of the texts for the various drop-down menus that are actually
# stored in the database. If these exist, they override the texts from the
# database.

$LANG_commentcodes = array(
    0 => 'Comments Enabled',
    -1 => 'Comments Disabled'
);


$LANG_commentmodes = array(
    'flat' => 'Flat',
    'nested' => 'Nested',
    'threaded' => 'Threaded',
    'nocomment' => 'No Comments'
);

$LANG_cookiecodes = array(
    0 => '(don\'t)',
    3600 => '1 Hour',
    7200 => '2 Hours',
    10800 => '3 Hours',
    28800 => '8 Hours',
    86400 => '1 Day',
    604800 => '1 Week',
    2678400 => '1 Month'
);

$LANG_dateformats = array(
    0 => 'System Default'
);

$LANG_featurecodes = array(
    0 => 'Not Featured',
    1 => 'Featured'
);

$LANG_frontpagecodes = array(
    0 => 'Show Only in Topic',
    1 => 'Show on Front Page'
);

$LANG_postmodes = array(
    'plaintext' => 'Plain Old Text',
    'html' => 'HTML Formatted'
);

$LANG_sortcodes = array(
    'ASC' => 'Oldest First',
    'DESC' => 'Newest First'
);

$LANG_trackbackcodes = array(
    0 => 'Trackback Enabled',
    -1 => 'Trackback Disabled'
);

?>
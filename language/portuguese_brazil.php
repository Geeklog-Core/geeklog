<?php

###############################################################################
# portuguese_brazil.php
# Esta � a p�gina em Portugu�s do Brasil para o GeekLog!
# Agradecimentos especiais para Mischa Polivanov pelo seu trabalho neste projeto
#
# Copyright (C) 2002 Dener C. Brito - LAST UPDATE: March 26,2002
# dener@crube.net
#
# Revisado e Atualizado em 28/Fevereiro/2005 por Alcides Soares Filho
# asoaresfil@uol.com.br - arquivo vers�o 1.3.11
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
# $LANGXX[YY]:  $LANG - nome da vari�vel
#               XX    - n�mero de identifica��o do arquivo
#               YY    - n�mero de identifica��o da frase
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
# FRASES DO SUS�RIO - Estas s�o frases usadas nos scripts voltados ao usu�rio 
# final
# NOTA DO TRADUTOR (Alcides): "story" ou "stories" em portugu�s n�o fica muito
# legal deixar como Hist�ria ou Hist�rias. Foram adotados os termos 
# "Publica��o" ou "Publica��es" respectivamente
###############################################################################

###############################################################################
# lib-common.php

$LANG01 = array(
    1 => 'Enviado por:',
    2 => 'ler mais',
    3 => 'coment�rios',
    4 => 'Editar',
    5 => 'Enquete',
    6 => 'Resultados',
    7 => 'Resultados da Enquete',
    8 => 'votos',
    9 => 'Fun��es Administrativas:',
    10 => 'Submiss�es',
    11 => 'Publica��es',
    12 => 'Blocos',
    13 => 'T�picos',
    14 => 'Links',
    15 => 'Eventos',
    16 => 'Enquetes',
    17 => 'Usu�rios',
    18 => 'SQL Query',
    19 => 'Sair do Sistema',
    20 => 'Informa��es do Usu�rio:',
    21 => 'Usu�rio',
    22 => 'ID',
    23 => 'N�vel de Acesso',
    24 => 'An�nimo',
    25 => 'Responder',
    26 => 'Os coment�rios a seguir s�o propriedade de quem os enviou. Este site n�o � respons�vel pelas opini�es expressas por seus usu�rios ou visitantes.',
    27 => 'Mensagem mais recente',
    28 => 'Excluir',
    29 => 'Sem coment�rios.',
    30 => 'Publica��es Anteriores',
    31 => 'Tags HTML Permitidas:',
    32 => 'Erro, nome de usu�rio inv�lido',
    33 => 'Erro, n�o foi poss�vel gravar no arquivo log',
    34 => 'Erro',
    35 => 'Sair',
    36 => 'em',
    37 => 'N�o h� publica��es de usu�rios',
    38 => 'Assinatura de Conte�dos',
    39 => 'Atualizar',
    40 => 'Voc� tem <tt>register_globals = Off</tt> no seu arquivo <tt>php.ini</tt>. O Geeklog requer <tt>register_globals</tt> colocado como <strong>on</strong>. Antes de continuar, fa�a esse ajuste para <strong>on</strong> e reinicialize seu servidor WEB.',
    41 => 'Usu�rios Convidados',
    42 => 'Autoria de:',
    43 => 'Responder',
    44 => 'Coment�rio Anterior',
    45 => 'Erro MySQL: N�mero',
    46 => 'Erro MySQL: Mensagem',
    47 => 'Login',
    48 => 'Minha Conta',
    49 => 'Prefer�ncias de Exibi��o',
    50 => 'Erro: SQL statement',
    51 => 'ajuda',
    52 => 'Novo',
    53 => 'Administra��o',
    54 => 'N�o foi poss�vel abrir o arquivo.',
    55 => 'Erro em',
    56 => 'Votar',
    57 => 'Senha',
    58 => 'Entrar',
    59 => "Deseja registrar-se? Clique <a href=\"{$_CONF['site_url']}/users.php?mode=new\">aqui</a>",
    60 => 'Comentar',
    61 => 'Registrar-se',
    62 => 'palavras',
    63 => 'Prefer�ncias de Coment�rios',
    64 => 'Enviar para um Amigo',
    65 => 'Vers�o para Impress�o',
    66 => 'Meu Calend�rio',
    67 => 'Bem-vindo � ',
    68 => 'in�cio',
    69 => 'contato',
    70 => 'busca',
    71 => 'contribuir',
    72 => 'links',
    73 => 'enquetes',
    74 => 'calend�rio',
    75 => 'busca avan�ada',
    76 => 'estat�sticas do site',
    77 => 'Plugins',
    78 => 'Pr�ximos Eventos',
    79 => 'O que h� de novo',
    80 => 'publica��es nas �ltimas',
    81 => 'publica��o nas �ltimas',
    82 => 'horas',
    83 => 'COMENT�RIOS',
    84 => 'LINKS',
    85 => '48 horas',
    86 => 'Sem novos coment�rios',
    87 => '14 dias',
    88 => 'Sem novos links',
    89 => 'N�o h� eventos programados',
    90 => 'Homepage Principal',
    91 => 'Criou esta p�gina em',
    92 => 'segundos',
    93 => 'Copyright',
    94 => 'Todas as marcas e copyrights nesta p�gina pertencem aos seus respectivos propriet�rios.',
    95 => 'Patrocinado por',
    96 => 'Grupos',
    97 => 'Lista de Palavras',
    98 => 'Plugins',
    99 => 'HIST�RIAS',
    100 => 'Sem novas publica��es',
    101 => 'Seus Eventos',
    102 => 'Eventos do Site',
    103 => 'Backups do DB',
    104 => 'por',
    105 => 'E-Mail para usu�rios',
    106 => 'Leituras',
    107 => 'Teste da Vers�o Geeklog',
    108 => 'Limpa Cach�',
    109 => 'Reporta abuso',
    110 => 'Reporta este envio para a administra��o do site',
    111 => 'V� Vers�o PDF',
    112 => 'Usu�rios Registrados',
    113 => 'Documenta��o'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => 'Calend�rio de Eventos',
    2 => 'Lamentamos, mas h� n�o eventos a exibir.',
    3 => 'Quando',
    4 => 'Onde',
    5 => 'Descri��o',
    6 => 'Adicionar um Evento',
    7 => 'Pr�ximos Eventos',
    8 => 'Ao adicionar este evento ao seu calend�rio voc� poder� ver somente os eventos em que estiver interessado clicando em "Meu Calend�rio" na �rea Fun��es do Usu�rio.',
    9 => 'Adicionar ao Meu Calend�rio',
    10 => 'Remover do Meu Calend�rio',
    11 => "Adicionando Evento ao Calend�rio de {$_USER['username']}",
    12 => 'Evento',
    13 => 'In�cio',
    14 => 'T�rmino',
    15 => 'Volta para Calend�rio'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Comentar',
    2 => 'Modo',
    3 => 'Sair',
    4 => 'Criar Conta',
    5 => 'Usu�rio',
    6 => 'Este site requer que voc� efetue o login para enviar um coment�rio.  Se voc� ainda n�o tem uma conta, utilize o formul�rio abaixo para criar uma.',
    7 => 'Seu �ltimo coment�rio foi h� ',
    8 => " segundos atr�s.  Este site requer pelo menos {$_CONF['commentspeedlimit']} segundos entre coment�rios",
    9 => 'Coment�rio',
    10 => 'Enviar Relat�rio',
    11 => 'Enviar Coment�rio',
    12 => 'Por favor, preencha os campos Nome, E-mail, T�tulo e Coment�rio, pois eles s�o necess�rios para a aceita��o de seu coment�rio.',
    13 => 'Suas Informa��es',
    14 => 'Prev�',
    15 => 'Reporta este envio',
    16 => 'T�tulo',
    17 => 'Erro',
    18 => 'Recomenda��es',
    19 => 'Por favor, envie mensagens relacionadas ao assunto tratado no t�pico.',
    20 => 'Tente responder aos coment�rios j� publicados ao inv�s de iniciar novos threads (um novo ramo).',
    21 => 'Leia as mensagens de outros usu�rios antes de enviar a sua para prevenir duplicidade de conte�do.',
    22 => 'Seja descritivo ao preencher o campo Assunto.',
    23 => 'Seu e-mail N�O ser� publicado.',
    24 => 'Usu�rio An�nimo',
    25 => 'Tem certeza que quer reportar este envio para a administra��o do site?',
    26 => '%s reportou o seguinte envio considerado abusivo:',
    27 => 'Reporta Coment�rio Abusivo'
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
    10 => '�ltimos 10 coment�rios',
    11 => 'Sem Coment�rios',
    12 => 'Prefer�ncias de Usu�rio para',
    13 => 'Enviar resumo di�rio via E-mail',
    14 => 'Esta senha � gerada aleatoriamente. � recomendado que voc� altere a mesma imediatamente. Para alterar sua senha, efetue o login e clique em Informa��es da conta no menu Fun��es do Usu�rio.',
    15 => "Sua conta no {$_CONF['site_name']} foi criada. Para ter acesso � mesma, voc� deve efetuar o login utilizando as informa��es abaixo. Por favor, guarde este e-mail para futuras consultas.",
    16 => 'Informa��es sobre sua Conta',
    17 => 'Conta inexistente',
    18 => 'O endere�o fornecido n�o parece ser um e-mail v�lido',
    19 => 'O nome de usu�rio ou o e-mail fornecido j� constam em nossa base de dados',
    20 => 'O endere�o fornecido n�o parece ser um e-mail v�lido',
    21 => 'Erro',
    22 => "Registro no {$_CONF['site_name']}!",
    23 => "Criando uma conta de usu�rio proporcionar� a voc� todos os benef�cios da associa��o ao site {$_CONF['site_name']} - o que permitir� a voc� enviar coment�rios e mensagens em seu nome. Se n�o tiver uma conta, voc� s� poder� enviar mensagens anonimamente. Por favor, note que seu endere�o de e-mail <b><i>nunca</i></b> ser� exibido publicamente neste site.",
    24 => 'Sua senha ser� enviada ao endere�o de e-mail que voc� forneceu.',
    25 => 'Esqueceu sua Senha?',
    26 => 'Entre com seu nome de usu�rio e clique em Enviar Senha. Uma nova senha ser� enviada para o endere�o constante em nossos registros.',
    27 => 'Registre-se!',
    28 => 'Enviar Senha',
    29 => 'saiu do',
    30 => 'entrou no',
    31 => 'A fun��o selecionada exige a entrada no sistema',
    32 => 'Assinatura',
    33 => 'N�o ser� exibida publicamente',
    34 => 'Este � o seu nome real',
    35 => 'Entre a senha para alter�-la',
    36 => 'Iniciar com http://',
    37 => 'Aplicada aos seus coment�rios',
    38 => 'Sobre voc�. (Qualquer pessoa poder� ler isto) ',
    39 => 'Sua chave p�blica PGP para ser compartilhada',
    40 => 'Sem �cones nos T�picos',
    41 => 'Aguardando Modera��o',
    42 => 'Formato de Datas',
    43 => 'M�ximo de Publica��es',
    44 => 'Sem caixas',
    45 => 'Prefer�ncias de Exibi��o para',
    46 => 'Itens Exclu�dos para',
    47 => 'Configura��o da Caixa de Not�cias para',
    48 => 'T�picos',
    49 => 'Sem �cones nas publica��es',
    50 => 'Desmarque se n�o estiver interessado',
    51 => 'Somente as Not�cias',
    52 => 'O padr�o �',
    53 => 'Receber as not�cias via resumo di�rio',
    54 => 'Selecione os t�picos e autores que voc� <b>n�o</b> quer ver.',
    55 => 'Se voc� deixar todos desmarcados, subentende-se que voc� deseja a sele��o padr�o. Se voc� iniciar a sele��o, lembre-se de selecionar todos os que voc� deseja, pois a sele��o padr�o ser� ignorada. Entradas padr�o s�o exibidas em <b>negrito</b>.',
    56 => 'Autores',
    57 => 'Modo de Exibi��o',
    58 => 'Ordenar por',
    59 => 'Limite de Coment�rios',
    60 => 'Como voc� prefere que os coment�rios sejam exibidos?',
    61 => 'Novos ou antigos primeiro?',
    62 => 'O padr�o � 100',
    63 => "Sua senha foi enviada. Por favor, siga as instru��es constantes no e-mail. Obrigado por participar do {$_CONF['site_name']}",
    64 => 'Prefer�ncias Atuais para',
    65 => 'Tente Entrar novamente',
    66 => "Voc� cometeu um erro ao preencher os campos. Por favor, tente efetuar o login novamente. Voc� � um <a href=\"{$_CONF['site_url']}/users.php?mode=new\">novo usu�rio</a>?",
    67 => 'Membro Desde',
    68 => 'Lembrar de mim por',
    69 => 'Por quanto tempo voc� deseja ser lembrado ap�s efetuar o login?',
    70 => "Personalize o layout e o conte�do do {$_CONF['site_name']}",
    71 => "Uma das caracter�sticas do {$_CONF['site_name']} � a possibilidade poder personalizar todo o seu conte�do e alterar o layout do site. Para poder usufruir destas vantagens voc� precisa<a href=\"{$_CONF['site_url']}/users.php?mode=new\">registrar-se</a> no {$_CONF['site_name']}.  Voc� j� � um membro? Efetue o login!",
    72 => 'Tema',
    73 => 'Idioma',
    74 => 'Muda a apar�ncia de todo o site!',
    75 => 'T�picos enviados por e-mail para',
    76 => 'Se voc� selecionar um t�pico da lista abaixo, voc� receber� toda e qualquer nova publica��o que for enviada para cada t�pico escolhido, em geral no final de cada dia. Escolha SOMENTE os t�picos que realmente interessam para voc�!',
    77 => 'Foto',
    78 => 'Adicione a sua Foto!',
    79 => 'Marque aqui para apagar esta foto',
    80 => 'Login',
    81 => 'Envia E-mail',
    82 => '�ltimas 10 publica��es para o usu�rio',
    83 => 'Estat�sticas de Envios para o usu�rio',
    84 => 'N�mero total de publica��es:',
    85 => 'N�mero total de coment�rios:',
    86 => 'Encontra todos os Envios postados por',
    87 => 'Seu nome de Login',
    88 => "Algu�m (provavelmente voc�) requisitou uma nova senha para a sua conta \"%s\" no site {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nSe voc� realmente quer obter uma nova senha, por favor clique no seguinte link:\n\n",
    89 => "Se voc� N�O quer uma nova senha, simplesmente ignore esta mensagem. O pedido N�O ser� processado (e sua senha permanecer� inalterada).\n\n",
    90 => 'Voc� pode entrar com uma nova senha para a sua conta, logo abaixo. Por favor observe que sua antiga senha ser� v�lida at� que voc� submeta este formul�rio com sucesso.',
    91 => 'Define Nova Senha',
    92 => 'Entra com Nova Senha',
    93 => 'Seu �ltimo pedido para uma nova senha foi feito %d segundos atr�s. Este site requer pelo menos %d segundos de intervalo entre pedidos de novas senhas.',
    94 => 'Apaga a Conta "%s"',
    95 => 'Clique no bot�o abaixo "Apaga a Conta" para remover sua conta de nosso banco de dados. Por favor observe que quaisquer publica��es e coment�rios enviados atrav�s desta conta  <strong>N�O</strong> ser�o apagados e ser�o mostrados como se tivessem sido postados por  "An�nimos".',
    96 => 'apaga conta',
    97 => 'Confirma��o de Apagar a Conta',
    98 => 'Tem certeza que quer apagar sua conta? Depois disso, voc� n�o conseguir� entrar neste site novamente (a menos que crie uma nova conta). Se voc� tem certeza, clique em  "apaga conta" novamente no formul�rio abaixo.',
    99 => 'Op��es de Privacidade para',
    100 => 'E-mail da Administra��o',
    101 => 'Permite e-mail da Administra��o do Site',
    102 => 'E-mail de Usu�rios',
    103 => 'Permite e-mail vindos de outros usu�rios',
    104 => 'Mostra seu Status on-line',
    105 => 'aparece no bloco Quem est� on-line',
    106 => 'Localidade',
    107 => 'Mostra no seu perfil p�blico'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Sem not�cias para exibir',
    2 => 'N�o h� novas publica��es para exibir. Talvez n�o haja novidades para este t�pico ou suas prefer�ncias de exibi��o s�o muito restritivas.',
    3 => 'para o T�pico %s',
    4 => 'Artigo de Hoje',
    5 => 'Pr�ximo',
    6 => 'Anterior',
    7 => 'Primeiro',
    8 => '�ltimo'
);

###############################################################################
# links.php

$LANG06 = array(
    1 => 'Links',
    2 => 'N�o h� links a exibir.',
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
    6 => 'Ver quest�es de outras enquetes'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Houve um erro ao enviar sua mensagem. Por favor, tente novamente.',
    2 => 'Mensagem enviada.',
    3 => 'Por favor utilize um endere�o de e-mail v�lido no campo de Reply.',
    4 => 'Por favor, preencha os campos Seu Nome, Responder para, Assunto e Mensagem',
    5 => 'Erro: Usu�rio desconhecido.',
    6 => 'H� um erro.',
    7 => 'Perfil de Usu�rio para',
    8 => 'ID',
    9 => 'URL',
    10 => 'Enviar e-mail para',
    11 => 'Seu Nome:',
    12 => 'Responder:',
    13 => 'Assunto:',
    14 => 'Mensagem:',
    15 => 'HTML n�o ser� traduzido.',
    16 => 'Enviar Mensagem',
    17 => 'Enviar Publica��o para um Amigo',
    18 => 'Nome',
    19 => 'E-mail',
    20 => 'Seu Nome',
    21 => 'Seu E-mail',
    22 => 'Todos os campos s�o requeridos',
    23 => "Este e-mail foi enviado a voc� por %s em %s pois ele acha que voc� pode se interessar por um artigo no {$_CONF['site_url']}.  Isto n�o � um SPAM e os endere�os de e-mail envolvidos n�o s�o exibidos ou guardados para uso posterior.",
    24 => 'Coment�rios sobre esta publica��o em',
    25 => 'Voc� precisa efetuar o login para utilizar este recurso. Ao efetuar o login, voc� nos ajuda a prevenir o mal-uso do sistema',
    26 => 'Este formul�rio permite a voc� enviar um e-mail para o usu�rio selecionado. Todos os campos s�o obrigat�rios.',
    27 => 'Apresenta��o',
    28 => '%s escreveu: ',
    29 => "Este � o resumo di�rio do {$_CONF['site_name']} para ",
    30 => ' Resumo Di�rio ',
    31 => 'T�tulo',
    32 => 'Data',
    33 => 'Leia o artigo na �ntegra em ',
    34 => 'Fim da Mensagem',
    35 => 'Desculpe-nos, mas este usu�rio definiu em suas prefer�ncias que n�o quer receber e-mails.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Busca Avan�ada',
    2 => 'Palavras-chave',
    3 => 'T�pico',
    4 => 'Todos',
    5 => 'Tipo',
    6 => 'Publica��es',
    7 => 'Coment�rios',
    8 => 'Autores',
    9 => 'Todos',
    10 => 'Buscar',
    11 => 'Resultados da Busca',
    12 => 'correspond�ncias',
    13 => 'Resultado da Busca: nenhuma correspond�ncia',
    14 => 'N�o h� correspond�ncia para sua busca em',
    15 => 'Por favor, tente novamente.',
    16 => 'T�tulo',
    17 => 'Data',
    18 => 'Autor',
    19 => "Pesquisar em toda a Base de Dados do {$_CONF['site_name']} ",
    20 => 'Data',
    21 => 'para',
    22 => '(Formato de Data MM-DD-AAAA)',
    23 => 'Leituras',
    24 => 'Encontrou',
    25 => 'correspond�ncias para',
    26 => 'itens em',
    27 => 'segundos',
    28 => 'Nenhuma publica��o ou coment�rio correspondente foi encontrado',
    29 => 'Resultados: Publica��es e Coment�rios',
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
    41 => 'Sua palavra de pesquisa deve ter no m�nimo 3 caracteres.',
    42 => 'Por favor utilize a data formatada como YYYY-MM-DD (ano-m�s-dia).',
    43 => 'frase exata',
    44 => 'todas estas palavras',
    45 => 'qualquer uma destas palavras',
    46 => 'Pr�ximo',
    47 => 'Pr�vio',
    48 => 'Autor',
    49 => 'Data',
    50 => 'Leituras',
    51 => 'Link',
    52 => 'Localidade',
    53 => 'Resultado da Pesquisa de Publica��es',
    54 => 'Resultado da Pesquisa de Coment�rios',
    55 => 'e a frase',
    56 => 'AND',
    57 => 'OR'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Estat�sticas do Site',
    2 => 'Total de Hits no Sistema',
    3 => 'Publica��es(Coment�rios) no Sistema',
    4 => 'Enquetes(Respostas) no Sistema',
    5 => 'Links(Cliques) no Sistema',
    6 => 'Eventos no Sistema',
    7 => '10 Publica��es Mais Lidas',
    8 => 'T�tulo',
    9 => 'Visualiza��es',
    10 => 'Aparentemente n�o h� publica��es neste site ou ningu�m leu as que foram publicadas.',
    11 => '10 Publica��es Mais Comentadas',
    12 => 'Coment�rios',
    13 => 'Aparentemente n�o h� publica��es neste site ou ningu�m comentou as que foram publicadas.',
    14 => '10 Enquetes Mais Votadas',
    15 => 'Pergunta',
    16 => 'Votos',
    17 => 'Aparentemente n�o h� enquetes neste site ou ningu�m votou nas existentes.',
    18 => 'Top 10 - Links',
    19 => 'Links',
    20 => 'Hits',
    21 => 'Aparentemente n�o h� links neste site ou ningu�m clicou nos existentes.',
    22 => 'Top 10 - Publica��es Recomendadas via e-mail',
    23 => 'E-mails',
    24 => 'Aparentemente ningu�m enviou uma publica��o via e-mail neste site'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'Relacionado',
    2 => 'Enviar para um Amigo',
    3 => 'Vers�o para Impress�o',
    4 => 'Op��es da Publica��o',
    5 => 'Formato de Publica��o PDF'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'Para enviar uma %s voc� precisa efetuar o login.',
    2 => 'Login',
    3 => 'Novo Usu�rio',
    4 => 'Enviar um Evento',
    5 => 'Enviar um Link',
    6 => 'Enviar uma Publica��o',
    7 => 'Login � Requerido',
    8 => 'OK',
    9 => 'Ao enviar informa��es para utiliza��o neste site n�s solicitamos a voc� que siga as seguintes recomenda��es...<ul><li>Preencha todos os campos, eles s�o obrigat�rios<li>Forne�a informa��es completas e apuradas<li>Verifique as URLs</ul>',
    10 => 'T�tulo',
    11 => 'Link',
    12 => 'Data de In�cio',
    13 => 'Data de T�rmino',
    14 => 'Local',
    15 => 'Descri��o',
    16 => 'Se outra, especifique',
    17 => 'Categoria',
    18 => 'Outra',
    19 => 'Leia Primeiro',
    20 => 'Erro: Faltando Categoria',
    21 => 'Ao selecionar "Outra" favor indicar um nome',
    22 => 'Erro: Campos em branco',
    23 => 'Por favor, preencha todos os campos do formul�rio. Todos os campos s�o obrigat�rios.',
    24 => 'Sugest�o recebida',
    25 => 'Sua sugest�o de %s foi arquivada com sucesso.',
    26 => 'Limite de Velocidade',
    27 => 'Usu�rio',
    28 => 'T�pico',
    29 => 'Publica��o',
    30 => 'Sua �ltima sugest�o foi enviada h� ',
    31 => " segundos. Este site requer pelo menos {$_CONF['speedlimit']} segundos entre o envio de uma mensagem e outra",
    32 => 'Pr�-v�',
    33 => 'Pr�-v� a Publica��o',
    34 => 'Sair',
    35 => 'Tags HTML n�o s�o permitidas',
    36 => 'Modo',
    37 => "Sugerindo um evento ao {$_CONF['site_name']} ir� inclu�-lo no Calend�rio Principal, onde os usu�rios poder�o adicion�-lo aos seus Calend�rios Pessoais. Este recurso <b>N�O</b> permite a voc� arquivar seus eventos pessoais como anivers�rios e celebra��es.<br><br>Uma vez enviado, seu evento ser� remetido ao nosso administrador para verifica��o, e caso o mesmo seja aprovado, ser� inclu�do no Calend�rio Principal.",
    38 => 'Adicionar Evento ao',
    39 => 'Calend�rio Principal',
    40 => 'Calend�rio Pessoal',
    41 => 'In�cio',
    42 => 'T�rmino',
    43 => 'Evento Di�rio',
    44 => 'Endere�o',
    45 => 'continua��o',
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
    1 => 'Autentica��o Requerida',
    2 => 'Negado! Informa��es de Login Incorretas',
    3 => 'Senha inv�lida para o usu�rio',
    4 => 'Usu�rio:',
    5 => 'Senha:',
    6 => 'Todos os acessos � �rea administrativa deste site s�o monitorados e revisados.<br>Esta p�gina � para uso exclusivo das pessoas autorizadas.',
    7 => 'entrar'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Direitos Insuficientes',
    2 => 'Voc� n�o tem permiss�o para editar este bloco.',
    3 => 'Editor de Blocos',
    4 => 'Houve um problema de leitura com este RSS/feed (veja arquivo error.log para saber detalhes).',
    5 => 'T�tulo',
    6 => 'T�pico',
    7 => 'Todos',
    8 => 'N�vel de Acesso',
    9 => 'Ordem',
    10 => 'Tipo',
    11 => 'Portal',
    12 => 'Normal',
    13 => 'Op��es - Portal',
    14 => 'RDF URL',
    15 => '�ltima Atualiza��o RDF',
    16 => 'Op��es - Normal',
    17 => 'Conte�do',
    18 => 'Por favor, preencha os campos T�tulo, N�vel de Seguran�a e Conte�do',
    19 => 'Gerenciador de Blocos',
    20 => 'T�tulo',
    21 => 'N�vel de Seguran�a',
    22 => 'Tipo',
    23 => 'Ordem',
    24 => 'T�pico',
    25 => 'Para modificar ou excluir um bloco, clique no bloco abaixo. Para criar um bloco, clique em Novo Bloco.',
    26 => 'Layout',
    27 => 'Bloco PHP',
    28 => 'Op��es Bloco PHP',
    29 => 'Fun��o do Bloco',
    30 => 'Se voc� quiser ter um dos seus blocos usando c�digo PHP, entre com o nome da fun��o acima.  O nome da sua fun��o DEVE come�ar com o prefixo "phpblock_" (p.e. phpblock_getweather).  Se sua fun��o N�O tiver este prefixo, ela N�O ser� chamada pelo programa.  Fizemos isto para evitar que sejam utilizadas fun��es que podem ser perigosas para o sistema.  Esteja certo de colocar um par�nteses "()" logo depois do nome da sua fun��o.  Finalmente, recomendamos que voc� SEMPRE  coloque todo o seu c�digo de BLOCOS PHP dentro do arquivo  custom_code.php.  Isto permitir� que SEU c�digo seja preservado quando voc� fizer o UPGRADE para uma nova vers�o do Geeklog.',
    31 => 'Erro no Bloco PHP. A fun��o , %s, n�o existe.',
    32 => 'Erro, Faltando Campo(s)',
    33 => 'Voc� DEVE entrar com a URL para o arquivo .rdf para os blocos do portal',
    34 => 'Voc� DEVE entrar com o t�tulo E a fun��o para os blocos PHP',
    35 => 'Voc� DEVE entrar com o t�tulo E o conte�do para os blocos normais',
    36 => 'Voc� DEVE entrar com o conte�do para os blocos de layout',
    37 => 'Nome de fun��o Errado para o bloco de PHP',
    38 => 'Fun��es para Blocos PHP Blocks DEVEM ter o prefixo \'phpblock_\' (p.e. phpblock_getweather).  O prefixo \'phpblock_\' prefix � requerido por raz�es de seguran�a, evitando a execu��o de c�digos arbitr�rios.',
    39 => 'Lado',
    40 => 'Esquerdo',
    41 => 'Direito',
    42 => 'Voc� DEVE entrar com a ordem do bloco e com o n�vel de seguran�a para os blocos padr�o do Geeklog',
    43 => 'Somente na P�gina Inicial',
    44 => 'Acesso Negado',
    45 => "Voc� est� tentando acessar um bloco para o qual n�o tem autoriza��o.  Esta tentativa foi registrada. Favor <a href=\"{$_CONF['site_admin_url']}/block.php\">retorna para a tela de Administra��o de Blocos</a>.",
    46 => 'Novo Bloco',
    47 => 'Administra��o',
    48 => 'Nome',
    49 => ' (sem espa�os e �nico)',
    50 => 'URL do Arquivo de Ajuda',
    51 => 'inclua http://',
    52 => 'Se voc� deixar em branco, o �cone de ajuda para este bloco n�o ser� exibido',
    53 => 'Habilitado',
    54 => 'salva',
    55 => 'cancela',
    56 => 'apaga',
    57 => 'Move Bloco para Baixo',
    58 => 'Move Bloco para Cima',
    59 => 'Move bloco para Lado Direito',
    60 => 'Move bloco para Lado Esquerdo'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => 'Editor de Eventos',
    2 => 'Error',
    3 => 'T�tulo',
    4 => 'URL',
    5 => 'In�cio',
    6 => 'T�rmino',
    7 => 'Local',
    8 => 'Descri��o',
    9 => '(incluir http://)',
    10 => 'Voc� deve preencher todos os campos deste formul�rio!',
    11 => 'Gerenciador de Eventos',
    12 => 'Para modificar ou apagar um evento, clique no respectivo evento abaixo.  Para criar um novo evento, clique em Novo Evento, acima.',
    13 => 'T�tulo',
    14 => 'In�cio',
    15 => 'T�rmino',
    16 => 'Acesso Negado',
    17 => "Voc� est� acessando um evento para o qual n�o tem autoriza��o.  Esta tentativa foi registrada. Por favor <a href=\"{$_CONF['site_admin_url']}/event.php\">retorne para a tela de Administra��o de Eventos</a>.",
    18 => 'Novo Evento',
    19 => 'Administra��o',
    20 => 'salva',
    21 => 'cancela',
    22 => 'apaga',
    23 => 'Data de in�cio incorreta.',
    24 => 'Data final incorreta.',
    25 => 'Data Final � menor que Data Inicial.'
);

###############################################################################
# admin/link.php

$LANG23 = array(
    1 => 'Editor de Links',
    2 => '',
    3 => 'T�tulo',
    4 => 'URL',
    5 => 'Categoria',
    6 => '(incluir http://)',
    7 => 'Outra',
    8 => 'Hits',
    9 => 'Descri��o',
    10 => 'Voc� deve digitar um T�tulo, um URL e uma Descri��o.',
    11 => 'Gerenciador de Links',
    12 => 'Para modificar ou apagar um , clique no respectivo link, abaixo.  Para criar um novo link, clique em Novo Link, acima.',
    13 => 'T�tulo',
    14 => 'Categoria',
    15 => 'URL',
    16 => 'Acesso Negado',
    17 => "Voc� est� tentando acessar um link para o qual n�o tem autoriza��o.  Esta tentativa foi registrada. Por favor <a href=\"{$_CONF['site_admin_url']}/link.php\">retorne para sua tela de Administra��o de Links</a>.",
    18 => 'Novo Link',
    19 => 'Administra��o',
    20 => 'Se outra, especifique',
    21 => 'salva',
    22 => 'cancela',
    23 => 'apaga'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Publica��es Anteriores',
    2 => 'Pr�ximas Publica��es',
    3 => 'Modo',
    4 => 'Formata��o',
    5 => 'Editor de Publica��es',
    6 => 'N�o h� publica��es no sistema',
    7 => 'Autor',
    8 => 'salva',
    9 => 'pr�-ver',
    10 => 'cancela',
    11 => 'apaga',
    12 => 'ID',
    13 => 'T�tulo',
    14 => 'T�pico',
    15 => 'Data',
    16 => 'Introdu��o',
    17 => 'Texto/Conte�do',
    18 => 'Leituras',
    19 => 'Coment�rios',
    20 => '',
    21 => '',
    22 => 'Lista de Publica��es',
    23 => 'Para modificar ou apagar uma publica��o, clique no n�mero da publica��o abaixo. Para ler uma publica��o, clique no t�tulo da mesma. Para criar uma publica��o nova, clique em Nova Publica��o, acima.',
    24 => 'O n�mero de identifica��o - ID - que voc� escolheu para esta publica��o j� est� em uso. Por favor escolha um outro n�mero de identifica��o - ID.',
    25 => '',
    26 => 'Prev�',
    27 => '',
    28 => '',
    29 => '',
    30 => 'Erros no Upload de arquivos',
    31 => 'Por favor preencha os campos Autor, T�tulo and e Texto de Introdu��o',
    32 => 'Publica��o do Dia',
    33 => 'S� pode haver uma �nica Publica��o do Dia',
    34 => 'Rascunho',
    35 => 'Sim',
    36 => 'N�o',
    37 => 'Mais por',
    38 => 'Mais de',
    39 => 'E-mails',
    40 => 'Acesso Negado ',
    41 => "Voc� est� tentando acessar uma publica��o para a qual voc� n�o tem autoriza��o.  Sua tentativa foi registrada.  Voc� pode ler esta publica��o, mas n�o pode editar, clicando abaixo. Por favor <a href=\"{$_CONF['site_admin_url']}/story.php\">retorne para a tela de Administra��o de Publica��es</a> quando estiver pronto.",
    42 => "Voc� est� tentando acessar uma publica��o para a qual n�o tem autoriza��o. Esta tentativa foi registrada.  Por favor <a href=\"{$_CONF['site_admin_url']}/story.php\">retorne para a tela de Administra��o de Publica��es.</a>.",
    43 => 'Nova Publica��o',
    44 => 'Administra��o',
    45 => 'Acesso',
    46 => '<b>NOTE:</b> se voc� modificar esta data de forma que ela fique no futuro, esta publica��o n�o aparecer� at� o in�cio dessa data futura.  Isto tamb�m significa que esta publica��o n�o ser� inclu�da nos arquivos de assinatura RDF e que ser� ignorado nas p�ginas de pesquisa e de estat�sticas.',
    47 => 'Imagens',
    48 => 'imagem',
    49 => 'LEFT',
    50 => 'RIGHT',
    51 => 'Para adicionar uma das imagens que voc� est� anexando a este artigo (publica��o) , voc� tem de inserir (no texto) um pequeno texto especialmente formatado. Este texto formatado deve ser [imageX], [imageX_right] ou [imageX_left] (com os colchetes) onde X � o n�mero da imagem que voc� est� anexando.  NOTA: Voc� DEVE usar as imagens que voc� anexa. Se voc� N�O fizer isso, N�O conseguir� salvar a sua publica��o.<BR><P><B>PREVENDO A PUBLICA��O</B>: Se voc� quiser pr�-ver uma publica��o com imagens anexadas, a melhor pr�tica � salvar a publica��o como RASCUNHO ao inv�s de usar o bot�o Pr�-ver. Somente use o bot�o de pr�-ver quando N�O tiver imagens anexadas.',
    52 => 'Apaga',
    53 => 'n�o foi utilizada.  Voc� DEVE incluir esta imagem na introdu��o ou no corpo da publica��o ANTES de salvar suas altera��es',
    54 => 'Imagens Anexadas n�o Utilizadas',
    55 => 'Os seguintes erros ocorreram enquanto sua publica��o estava sendo salva. Por favor corrija esse erros antes de salvar novamente.',
    56 => 'Mostra �cone do T�pico',
    57 => 'V� imagem sem escala',
    58 => 'Gerenciamento de Publica��es',
    59 => 'Op��o',
    60 => 'Permitido',
    61 => 'Auto Arquiva',
    62 => 'Auto Apaga'
);

###############################################################################
# admin/poll.php

$LANG25 = array(
    1 => 'Modo',
    2 => 'Por favor entre com uma pergunta e pelo menos uma resposta.',
    3 => 'Enquete Criada',
    4 => 'Enquete %s salva',
    5 => 'Editar Enquete',
    6 => 'ID da Enquete',
    7 => '(n�o use espa�os)',
    8 => 'Exibir na P�gina Inicial',
    9 => 'Pergunta',
    10 => 'Respostas / Votos',
    11 => 'Houve um erro nos dados de resposta da enquete %s',
    12 => 'Houve um erro nos dados da quest�o da enquete %s',
    13 => 'Criar Enquete',
    14 => 'salvar',
    15 => 'cancelar',
    16 => 'apagar',
    17 => 'Por favor entre com uma identifica��o para a enquete (ID)',
    18 => 'Lista de Enquetes',
    19 => 'Para modificar ou apagar uma enquete, clique sobre a respectiva enquete.  Para criar uma nova enquete, clique em Nova Enquete acima.',
    20 => 'Votantes',
    21 => 'Acesso Negado',
    22 => "Voc� est� tentando acessar uma enquete para a qual n�o tem autoriza��o.  Esta tentativa foi registrada. Por favor <a href=\"{$_CONF['site_admin_url']}/poll.php\">retorne para a tela de Administra��o de Enquetes</a>.",
    23 => 'Nova Enquete',
    24 => 'Administra��o',
    25 => 'Sim',
    26 => 'N�o'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Editor de T�picos',
    2 => 'ID',
    3 => 'Nome',
    4 => 'Imagem',
    5 => '(n�o use espa�os)',
    6 => 'Ao apagar um t�pico, s�o apagados todas as publica��es e blocos associados a esse t�pico',
    7 => 'Por favor, preencha os campos ID e Nome do T�pico',
    8 => 'Gerenciador de T�picos',
    9 => 'Para modificar ou apagar um t�pico, clique sobre o nome do t�pico.  Para criar um novo t�pico, clique no botar Criar Novo T�pico � esquerda. Voc� ir� ver o seu n�vel de acesso para cada t�pico dentro de par�nteses',
    10 => 'Ordem de Exibi��o',
    11 => 'Publica��es/P�gina',
    12 => 'Acesso Negado',
    13 => "Voc� est� tentando acessar um t�pico para o qual n�o tem autoriza��o. Sua tentativa foi registrada. Por favor <a href=\"{$_CONF['site_admin_url']}/topic.php\">retorne para a tela de Administra��o de T�picos</a>.",
    14 => 'Ordem',
    15 => 'alfab�tica',
    16 => 'o padr�o �',
    17 => 'Novo T�pico',
    18 => 'Administra��o',
    19 => 'salva',
    20 => 'cancela',
    21 => 'apaga',
    22 => 'Padr�o',
    23 => 'fa�a deste o t�pico padr�o para novas submiss�es de publica��es',
    24 => '(*)',
    25 => 'Arquiva T�pico',
    26 => 'fa�a deste o t�pico padr�o para publica��es arquivadas. Somente um t�pico � permitido.'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Editor de Usu�rios',
    2 => 'ID',
    3 => 'Nome de Usu�rio',
    4 => 'Nome Completo',
    5 => 'Senha',
    6 => 'N�vel de Seguran�a',
    7 => 'E-mail',
    8 => 'Homepage',
    9 => '(n�o use espa�os)',
    10 => 'Por favor preencha os campos Nome de Usu�rio, Nome Completo, N�vel de Seguran�a e E-mail',
    11 => 'Gerenciador de Usu�rios',
    12 => 'Para modificar ou apagar um usu�rio, clique sobre o usu�rio abaixo. Para criar um novo usu�rio, clique no bot�o Novo Usu�rio � esquerda.',
    13 => 'N�vel de Acesso',
    14 => 'Data Registro.',
    15 => 'Novo Usu�rio',
    16 => 'Administra��o',
    17 => 'alterar senha',
    18 => 'cancelar',
    19 => 'excluir',
    20 => 'salvar',
    21 => 'O nome de usu�rio que voc� est� tentando usar j� existe.',
    22 => 'Erro',
    23 => 'Adiciona Lote (Batch)',
    24 => 'Importa��o de Usu�rios em Lote (Batch)',
    25 => 'Voc� pode importar um lote (batch) de usu�rios no Geeklog.  O arquivo de importa��o DEVE ser um arquivo TEXTO, delimitado por tab (tabulador) e conter os seguintes campos na seguinte ordem: : nome completo, nome de usu�rio, endere�o de e-mail.  Cada usu�rio que voc� importar receber� uma senha, criada de forma aleat�ria.  Voc� deve ter apenas um usu�rio por linha de entrada. Falhas ao seguir estas instru��es ir�o causar problemas s�rios, que ir�o requerer trabalho manual. Por isso, fa�a uma dupla verifica��o de tudo antes de fazer a importa��o!',
    26 => 'Pesquisa',
    27 => 'Limita Resultados',
    28 => 'Clique aqui para apagar esta imagem',
    29 => 'Path',
    30 => 'Importa',
    31 => 'Novos Usu�rios',
    32 => 'Processamento realizado. Foram feitas %d importa��es e encontradas %d falhas',
    33 => 'envia',
    34 => 'Erro: Voc� deve especificar um arquivo para upload.',
    35 => '�ltimo Login',
    36 => '(nunca)'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Aprovar',
    2 => 'Excluir',
    3 => 'Editar',
    4 => 'Perfil',
    10 => 'T�tulo',
    11 => 'Data de In�cio',
    12 => 'URL',
    13 => 'Categoria',
    14 => 'Data',
    15 => 'T�pico',
    16 => 'Nome de usu�rio',
    17 => 'Nome Completo',
    18 => 'E-mail',
    34 => 'Comando e Controle',
    35 => 'Submiss�es de Publica��es',
    36 => 'Submiss�es de Links',
    37 => 'Submiss�es de Eventos',
    38 => 'Enviar',
    39 => 'N�o h� submiss�es a serem moderadas agora',
    40 => 'Submiss�es de Usu�rios'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => 'Domingo',
    2 => 'Segunda',
    3 => 'Ter�a',
    4 => 'Quarta',
    5 => 'Quinta',
    6 => 'Sexta',
    7 => 'S�bado',
    8 => 'Adicionar Evento',
    9 => 'Evento do Site',
    10 => 'Eventos para',
    11 => 'Calend�rio Principal',
    12 => 'Meu Calend�rio',
    13 => 'Janeiro',
    14 => 'Fevereiro',
    15 => 'Mar�o',
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
    28 => 'Calend�rio Pessoal de',
    29 => 'Calend�rio P�blico',
    30 => 'excluir evento',
    31 => 'Adicionar',
    32 => 'Evento',
    33 => 'Data',
    34 => 'Hora',
    35 => 'Adi��o R�pida',
    36 => 'Enviar',
    37 => 'Lamentamos, mas o Calend�rio Pessoal n�o est� habilitado neste site',
    38 => 'Editor de Eventos Pessoais',
    39 => 'Dia',
    40 => 'Semana',
    41 => 'M�s'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => 'Mail',
    2 => 'De',
    3 => 'Responder para',
    4 => 'Assunto',
    5 => 'Conte�do',
    6 => 'Enviar para:',
    7 => 'Todos os Usu�rios',
    8 => 'Administrador',
    9 => 'Op��es',
    10 => 'HTML',
    11 => 'Mensagem Urgente!',
    12 => 'Enviado',
    13 => 'Limpa',
    14 => 'Ignorar prefer�ncias do usu�rio ',
    15 => 'Erro ao enviar para: ',
    16 => 'Mensagens enviadas para: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Enviar outra mensagem</a>",
    18 => 'Para',
    19 => 'NOTA: se voc� pretende mandar uma mensagem para todos os membros do site, selecione o grupo de usu�rios Logged-in no menu de sele��o.',
    20 => "Foram enviadas com sucesso <successcount> mensagens and <failcount> mensagens apresentaram falha.  Se voc� precisar, os detalhes de cada mensagem � mostrado abaixo.  Caso necess�rio voc� pode <a href=\"{$_CONF['site_admin_url']}/mail.php\">Enviar outra mensagem</a> ou ent�o voc� pode <a href=\"{$_CONF['site_admin_url']}/moderation.php\">retornar � p�gina de administra��o</a>.",
    21 => 'Falhas',
    22 => 'Sucessos',
    23 => 'Sem falhas',
    24 => 'Sem sucessos',
    25 => '-- Selecione Grupo --',
    26 => 'Por favor preencha os campos no formul�rio e selecione um grupo de usu�rios no menu.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'A instala��o de plugins pode causar danos � sua instala��o padr�o do Geeklog e, possivelmente, at� para seu sistema.  Por isso � importante que voc� s� instale plugins que foram baixados de <a href="http://www.geeklog.net" target="_blank">Geeklog Homepage</a>, uma vez que n�s testamos todos os plugins enviados para o site em uma variedade de sistemas operacionais.  � importante que voc� compreenda que o processo de instala��o de um plugin ir� requerer a execu��o de alguns comandos de arquivos de sistema - que podem causar problemas de seguran�a especialmente se voc� utilizar plugins de outros sites. Mesmo que voc� tome todos os cuidados que estamos propondo, n�s n�o podemos garantir o sucesso de qualquer instala��o e nem podemos nos responsabilizar por quaisquer danos causados na instala��o de um Plugin Geeklog.  Em outras palavras, todo o risco de qualquer instala��o � seu. Sempre siga as indica��es de como instalar manualmente um plugin. Estas instru��es sempre vem no pacote de cada instala��o.',
    2 => 'Plug-in Disclaimer de Instala��o',
    3 => 'Plug-in Formul�rio de Instala��o',
    4 => 'Arquivo Plug-in',
    5 => 'Lista de Plugins',
    6 => 'Aten��o: Plug-in j� instalado!',
    7 => 'O plug-in que voc� est� tentando instalar j� existe. Remova-o antes de reinstal�-lo',
    8 => 'Houve uma falha durante a verifica��o de compatibilidade do Plugin',
    9 => 'Este plugin requer uma nova vers�o do Geeklog. Procure fazer uma atualiza��o da sua c�pia do<a href=http://www.geeklog.net>Geeklog</a>  e ou busque uma nova vers�o do plugin.',
    10 => '<br><b>N�o h� plugins instalados atualmente.</b><br><br>',
    11 => 'Para modificar ou apagar um plug-in, clique no n�mero do plug-in abaixo. Para aprender mais sobre o plug-in, clique no nome do plug-in e voc� ser� direcionado para o site do plug-in. Para instalar ou atualizar um plug-in , clique em Novo Plug-in acima.',
    12 => 'nenhum nome de plugin foi fornecido para o plugineditor()',
    13 => 'Editor de Plugins',
    14 => 'Novo Plug-in',
    15 => 'Administra��o',
    16 => 'Nome',
    17 => 'Vers�o',
    18 => 'Vers�o Geeklog',
    19 => 'Habilitado',
    20 => 'Sim',
    21 => 'N�o',
    22 => 'Instalar',
    23 => 'Salvar',
    24 => 'Cancelar',
    25 => 'Excluir',
    26 => 'Nome',
    27 => 'Homepage',
    28 => 'Vers�o',
    29 => 'Vers�o Geeklog',
    30 => 'Excluir Plug-in?',
    31 => 'Tem certeza que quer apagar este plug-in?  Ao fazer isso voc� vai remover todos os arquivos, dados e estruturas de dados que este plug-in utiliza.  Se voc� tem certeza, clique em Apaga novamente no formul�rio a seguir.',
    32 => '<p><b>Erro: tag AutoLink n�o est� no formato correto</b></p>',
    33 => 'Vers�o do C�digo',
    34 => 'Atualiza'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'cria novo feed',
    2 => 'salva',
    3 => 'apaga',
    4 => 'cancela',
    10 => 'Assinatura de Conte�dos',
    11 => 'Novo Feed',
    12 => 'Home Administrativa',
    13 => 'Para modificar ou apagar um feed, clique no t�tulo do feed, abaixo. Para criar um novo feed, clique em Novo Feed, acima.',
    14 => 'T�tulo',
    15 => 'Tipo',
    16 => 'Nome do Arquivo',
    17 => 'Formato',
    18 => '�ltima atualiza��o',
    19 => 'Permitido',
    20 => 'Sim',
    21 => 'N�o',
    22 => '<i>(sem feeds)</i>',
    23 => 'todas Publica��es',
    24 => 'Editor de Feed',
    25 => 'T�tulo do Feed',
    26 => 'Limite',
    27 => 'Comprimento das entradas',
    28 => '(0 = sem texto, 1 = texto inteiro, outro n�mero = limita a este n�mero de caracteres.)',
    29 => 'Descri��o',
    30 => '�ltima Atualiza��o',
    31 => 'Set de Caracteres',
    32 => 'Linguagem',
    33 => 'Conte�dos',
    34 => 'Entradas',
    35 => 'Horas',
    36 => 'Seleciona tipo de feed',
    37 => 'Voc� tem ao menos um plugin instalado que suporta assinatura de conte�dos. Abaixo voc� precisar� selecionar se voc� quer criar um feed Geeklog feed ou criar um feed atrav�s de um dos plugins.',
    38 => 'Erro: Faltando preencher campos',
    39 => 'Por favor preencha T�tulo do Feed, Descri��o e Nome do Arquivo.',
    40 => 'Por favor defina um n�mero de entradas ou um n�mero de horas.',
    41 => 'Links',
    42 => 'Eventos'
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "Sua senha foi mandada por e-mail para voc� e deve chegar em breve. Por favor siga as instru��es na mensagem e muito obrigado por usar o site {$_CONF['site_name']}",
    2 => "Muito obrigado por registrar sua publica��o no site {$_CONF['site_name']}.  Ela ser� submetida ao nosso pessoal de staff para aprova��o. Se aprovada, sua publica��o ficar� dispon�vel para todos os outros usu�rios que acessarem o nosso site.",
    3 => "Muito obrigado por registrar um link no site {$_CONF['site_name']}.  Ele ser� submetido ao nosso pessoal de staff para aprova��o.  Se aprovado, seu link ser� visto na se��o de links em <a href={$_CONF['site_url']}/links.php>links</a>.",
    4 => "Muito obrigado por inscrever um Evento no site {$_CONF['site_name']}.  Ele ser� submetido ao nosso pessoal de staff para aprova��o.  Se aprovado, seu Evento estar� em nossa se��o <a href={$_CONF['site_url']}/calendar.php>Calend�rio</a>.",
    5 => 'A informa��o de sua conta foi salva com sucesso.',
    6 => 'Suas prefer�ncias de tela (display) foram salvas com sucesso.',
    7 => 'Suas prefer�ncias de Coment�rios foram salvas com sucesso.',
    8 => 'Seu micro foi desconectado do site com sucesso (logout).',
    9 => 'Sua publica��o foi salva com sucesso.',
    10 => 'A publica��o foi exclu�da com sucesso.',
    11 => 'Seu bloco foi salvo com sucesso.',
    12 => 'O bloco foi exclu�do com sucesso.',
    13 => 'Seu t�pico foi salvo com sucesso.',
    14 => 'O t�pico e todas suas publica��es e blocos foram apagados com sucesso.',
    15 => 'Seu link foi salvo com sucesso.',
    16 => 'O link foi exclu�do com sucesso.',
    17 => 'Seu evento foi inclu�do com sucesso.',
    18 => 'O evento foi exclu�do com sucesso.',
    19 => 'Sua enquete foi salva com sucesso.',
    20 => 'A enquete foi exclu�da com sucesso.',
    21 => 'O novo usu�rio foi salvo com sucesso.',
    22 => 'O usu�rio foi exclu�do com sucesso',
    23 => 'Erro ao tentar adicionar um Evento ao seu Calend�rio. N�o foi informada nenhuma identidade (ID) para o evento.',
    24 => 'O evento foi salvo com sucesso no seu calend�rio',
    25 => 'N�o � poss�vel abrir seu calend�rio pessoal de voc� n�o efetuar seu login.',
    26 => 'O evento foi removido com sucesso de seu calend�rio pessoal',
    27 => 'Mensagem enviada com sucesso.',
    28 => 'O plug-in foi salvo com sucesso',
    29 => 'Lamentamos, mas calend�rios pessoais n�o est�o habilitados neste site',
    30 => 'Acesso Negado',
    31 => 'Lamentamos, mas voc� n�o tem acesso a pagina de Administra��o de Publica��es.  Por favor note que todas as tentativas de acesso n�o autorizado ficam registradas.',
    32 => 'Lamentamos, mas voc� n�o tem acesso a pagina de Administra��o de T�picos.  Por favor note que todas as tentativas de acesso n�o autorizado ficam registradas.',
    33 => 'Lamentamos, mas voc� n�o tem acesso a pagina de Administra��o de Blocos.  Por favor note que todas as tentativas de acesso n�o autorizado ficam registradas.',
    34 => 'Lamentamos, mas voc� n�o tem acesso a pagina de Administra��o de Links.  Por favor note que todas as tentativas de acesso n�o autorizado ficam registradas.',
    35 => 'Lamentamos, mas voc� n�o tem acesso a pagina de Administra��o de Eventos.  Por favor note que todas as tentativas de acesso n�o autorizado ficam registradas.',
    36 => 'Lamentamos, mas voc� n�o tem acesso a pagina de Administra��o de Enquetes.  Por favor note que todas as tentativas de acesso n�o autorizado ficam registradas.',
    37 => 'Lamentamos, mas voc� n�o tem acesso a pagina de Administra��o de Usu�rios.  Por favor note que todas as tentativas de acesso n�o autorizado ficam registradas.',
    38 => 'Lamentamos, mas voc� n�o tem acesso a pagina de Administra��o de Plugins.  Por favor note que todas as tentativas de acesso n�o autorizado ficam registradas.',
    39 => 'Lamentamos, mas voc� n�o tem acesso a pagina de Administra��o de Mail.  Por favor note que todas as tentativas de acesso n�o autorizado ficam registradas.',
    40 => 'Mensagem do Sistema',
    41 => 'Lamentamos, mas voc� n�o tem acesso � p�gina de substitui��o de palavras.  Por favor note que todas as tentativas de acesso n�o autorizado ficam registradas.',
    42 => 'Sua palavra foi registrada com sucesso.',
    43 => 'A palavra foi exclu�da com sucesso.',
    44 => 'O plug-in foi instalado com sucesso!',
    45 => 'O plug-in foi exclu�do com sucesso.',
    46 => 'Lamentamos, mas voc� n�o tem acesso ao utilit�rio de backup do banco de dados.  Por favor note que todas as tentativas de acesso n�o autorizado ficam registradas.',
    47 => 'Esta funcionalidade s� opera em sistemas do padr�o *nix.  Se voc� estiver rodando  *nix como seu sistema operacional, ent�o o seu cach� foi limpo com sucesso. Se voc� roda em Windows, voc� precisar� pesquisar os arquivos com nome adodb_*.php and remov�-los manualmente.',
    48 => "Muito obrigado por se inscrever como membro do site {$_CONF['site_name']}. Nossa equipe ir� revisar a sua inscri��o. Se aprovada, sua senha ser� enviada por e-mail para o endere�o com o qual voc� se registrou.",
    49 => 'Seu grupo foi salvo com sucesso.',
    50 => 'Seu grupo foi apagado com sucesso.',
    51 => 'Este nome de usu�rio j� est� sendo usado por outra pessoa. Por favor escolha um outro.',
    52 => 'O endere�o de e-mail fornecido n�o parece ser um endere�o de e-mail v�lido.',
    53 => 'Sua nova senha foi aceita. Por favor utilize a nova senha abaixo para fazer o login agora.',
    54 => 'Seu pedido de uma nova senha expirou. Por favor tente novamente abaixo.',
    55 => 'Um e-mail foi enviado para voc� e deve chegar em breve. Por favor siga as instru��es nele contidas para definir uma nova senha para a sua conta.',
    56 => 'O endere�o de e-mail fornecido j� est� em uso por outra pessoa.',
    57 => 'Sua conta foi apagada com sucesso.',
    58 => 'Seu feed foi salvo com sucesso.',
    59 => 'Seu feed foi apagado com sucesso.',
    60 => 'O plugin foi atualizado com sucesso',
    61 => 'Plugin %s: mensagem de local desconhecido'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Acesso',
    'ownerroot' => 'Propriet�rio/Raiz',
    'group' => 'Grupo ',
    'readonly' => 'Somente Leitura',
    'accessrights' => 'Direito de Acesso',
    'owner' => 'Propriet�rio ',
    'grantgrouplabel' => 'Concede Direitos de Edi��o para o Grupo Acima',
    'permmsg' => 'NOTA: Membros equivale a todos usu�rios que est�o plugados com login no momento e An�nimos equivale a todos usu�rios que est�o navegando no site no momento mas N�O fizeram seu login.',
    'securitygroups' => 'Grupos de Seguran�a',
    'editrootmsg' => "Mesmo que voc� seja um Usu�rio Administrador, voc� n�o pode editar um usu�rio raiz se voc� mesmo tamb�m n�o for um usu�rio raiz. Voc� pode editar todos os outros usu�rios, exceto usu�rios da raiz. Por favor note que todas tentativas ilegais de tentar editar usu�rio raiz ficam registradas. Por favor retorne para a <a href=\"{$_CONF['site_admin_url']}/user.php\">p�gina de Administra��o de Usu�rios</a>.",
    'securitygroupsmsg' => 'Selecione os checkboxes para os grupos que voc� quer que o usu�rio venha a pertencer.',
    'groupeditor' => 'Editor de Grupos',
    'description' => 'Descri��o',
    'name' => 'Nome',
    'rights' => 'Direitos',
    'missingfields' => 'Campos Faltantes',
    'missingfieldsmsg' => 'Voc� DEVE fornecer o Nome e a Descri��o para um grupo',
    'groupmanager' => 'Gerenciador de Grupos',
    'newgroupmsg' => 'Para modificar ou apagar um grupo, clique no grupo abaixo. Para criar um novo grupo, clique em Novo Grupo, acima. Por favor note que os grupos que s�o core groups - e n�o podem ser apagados - pois eles s�o usados pelo sistema.',
    'groupname' => 'Nome',
    'coregroup' => 'Core Group',
    'yes' => 'Sim',
    'no' => 'N�o',
    'corerightsdescr' => "Este grupo � um Grupo Core do site {$_CONF['site_name']}.  Desta forma, os direitos para este grupo N�O podem ser editados.  Abaixo segue uma lista somente para leitura dos direitos que este grupo tem acesso.",
    'groupmsg' => 'Grupos de Seguran�a, neste site, s�o hier�rquicos. Ao adicionar este grupo a qualquer um dos grupos abaixo, voc� estar� dando a este grupo os mesmos direitos que aqueles grupos t�m. Encorajamos voc� a, sempre que for poss�vel, usar os grupos abaixo para dar direitos a um novo grupo.  Se voc� depois precisar que este grupo tenha direitos espec�ficos voc� pode selecionar os direitos dos diversos recursos do site na se��o abaixo chamada  \'Direitos\'.  Para adicionar este grupo a qualquer um dos grupos abaixo, simplesmente marque o box pr�ximo ao(s) grupo(s) que voc� quiser.',
    'coregroupmsg' => "Este grupo � um Grupo Core do site {$_CONF['site_name']}.  Desta forma, os grupos a que este grupo pertence n�o podem ser editados.  Abaixo segue uma lista apenas para leitura dos grupos s que este grupo pertence.",
    'rightsdescr' => 'O acesso de um grupo a um determinado direito, abaixo, pode ser dado diretamente para o grupo OU para um grupo diferente - a que este grupo perten�a. Os que voc� v� abaixo sem o checkbox marcado s�o direitos dados a este grupo por que ele pertence a um outro grupo que j� tem esses direitos. Os direitos com checkboxes, abaixo, s�o direitos que podem ser dados diretamente a este grupo.',
    'lock' => 'Bloquear',
    'members' => 'Membros',
    'anonymous' => ' An�nimos ',
    'permissions' => 'Permiss�es',
    'permissionskey' => 'R = ler, E = editar (direito de editar pressup�e direito de ler)',
    'edit' => 'Editar',
    'none' => 'Nenhum',
    'accessdenied' => 'Acesso Negado',
    'storydenialmsg' => "Voc� n�o tem acesso para ver esta publica��o.  Isto pode ocorrer porque voc� ainda n�o � membro do site {$_CONF['site_name']}.  Por favor <a href=users.php?mode=new> torne-se um membro</a> do {$_CONF['site_name']} para receber direitos plenos de acesso!",
    'eventdenialmsg' => "Voc� n�o tem acesso para ver este evento.  Isto pode ocorrer porque voc� ainda n�o � membro do site {$_CONF['site_name']}.  Por favor <a href=users.php?mode=new> torne-se um membro</a> do {$_CONF['site_name']} para receber direitos plenos de acesso!",
    'nogroupsforcoregroup' => 'Este grupo n�o pertence a qualquer um dos outros grupos',
    'grouphasnorights' => 'Este grupo n�o tem acesso a quaisquer recursos de administra��o deste site',
    'newgroup' => 'Novo Grupo',
    'adminhome' => 'Administra��o',
    'save' => 'salvar',
    'cancel' => 'cancelar',
    'delete' => 'apagar',
    'canteditroot' => 'Voc� tentou editar o Grupo raiz. Mas voc� mesmo n�o pertence ao grupo raiz e, por este motivo, seu acesso n�o � permitido.  Por favor, contate o administrador do sistema se voc� acha que isto � um erro.',
    'listusers' => 'Lista de Usu�rios',
    'listthem' => 'lista',
    'usersingroup' => 'Usu�rios no Grupo "%s"',
    'usergroupadmin' => 'Administra��o de Usu�rios no Grupo',
    'add' => 'Adiciona',
    'remove' => 'Remove',
    'availmembers' => 'Membros Dispon�veis',
    'groupmembers' => 'Membros do Grupo',
    'canteditgroup' => 'Para editar este grupo, voc� tem de ser membro do grupo. Por favor, contate o administrador do sistema se voc� acha que isto � um erro.',
    'cantlistgroup' => 'Para ver os membros deste grupo, voc� tamb�m tem que ser um membro deste grupo. Por favor, contate o administrador do sistema se voc� acha que isto � um erro.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => '�ltimos 10 Backups',
    'do_backup' => 'Fazer Backup',
    'backup_successful' => 'Backup do banco de dados feito com sucesso.',
    'no_backups' => 'Sem backups no sistema',
    'db_explanation' => 'Para criar um novo backup do seu sistema Geeklog, clique o bot�o abaixo',
    'not_found' => "Path (caminho) incorreto ou utilit�rio chamado mysqldump n�o est� executando.<br>Verifique <strong>\$_DB_mysqldump_path</strong> - defini��o que est� no arquivo config.php.<br>Essa vari�vel est� no momento definida como: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Backup Falhou: tamanho do arquivo com 0 bytes',
    'path_not_found' => "{$_CONF['backup_path']} n�o existe ou n�o � um diret�rio",
    'no_access' => "ERRO: Diret�rio {$_CONF['backup_path']} n�o est� acess�vel.",
    'backup_file' => 'Arquivo de Backup',
    'size' => 'Tamanho',
    'bytes' => 'Bytes',
    'total_number' => 'N�mero total de backups: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Homepage',
    2 => 'Contato',
    3 => 'Publique um Artigo',
    4 => 'Links',
    5 => 'Enquetes',
    6 => 'Calend�rio',
    7 => 'Estat�sticas do Site',
    8 => 'Personaliza��o do Site',
    9 => 'Pesquisa site',
    10 => 'pesquisa avan�ada'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => 'Erro 404',
    2 => 'Gee, travei em algum lugar mas n�o posso encontrar o local <b>%s</b>.',
    3 => "<p>Lamentamos, mas o arquivo que voc� pediu n�o existe mais. Por favor fique a vontade para verificar a <a href=\"{$_CONF['site_url']}\">p�gina principal</a> ou a <a href=\"{$_CONF['site_url']}/search.php\">p�gina de pesquisa</a> para ver se voc� acha o que n�o encontrou."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Login � requerido',
    2 => 'Lamentamos mas, para acessar esta �rea voc� deve fazer o login como um usu�rio.',
    3 => 'Login',
    4 => 'Novo Usu�rio'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'O recurso de PDF est� desabilitado',
    2 => 'O documento fornecido n�o foi processado no formato PDF. O documento foi recebido, mas n�o pode ser processado. Por favor verifique se foram submetidos documentos formatados contendo somente comandos html que foram escritos para o padr�o xHTML. Por favor note que documentos html muito complexos podem n�o processar corretamente ou simplesmente nem processarem (processo chamado de renderiza��o). O documento resultante de sua tentativa ficou com 0 bytes de tamanho - e foi apagado. Se voc� tem certeza que o documento pode ser processado - renderizado - resubmeta o mesmo.',
    3 => 'Erro desconhecido na gera��o do PDF',
    4 => "N�o foi fornecida uma p�gina com dados ou voc� que usar a ferramenta de gera��o de PDF ad-hoc, abaixo.  Se voc� pensa que est� tendo erro nesta p�gina\n          por favor contate o administrador do sistema.  Ou ent�o voc� pode usar o formul�rio abaixo para gerar o PDF com um aspecto ad-hoc.",
    5 => 'Carregando seu documento.',
    6 => 'Por favor aguarde enquanto seu documento � carregado.',
    7 => 'Voc� pode dar um clique com o bot�o direito do mouse no bot�o abaixo e escolher\'Salva em...\' ou \'Salva num link...\' para salvar a copia do seu documento.',
    8 => "O path (caminho) fornecido no arquivo de configura��o (para o arquivo bin�rio HTMLDoc) � inv�lido ou o sistema n�o pode execut�-lo. Por favor contate o administrador do site se este problema persistir.",
    9 => 'Gerador de PDF',
    10 => "Esta � ferramenta de Gera��o de PDF Ad-hoc. Ela tentar� converter qualquer URL fornecida num documento PDF. Por favor fique ciente que algumas p�ginas n�o ir�o renderizar perfeitamente com este recurso.  Esta\n           � uma limita��o da ferramenta e os erros desta natureza n�o devem ser reportados para o administrador do site",
    11 => 'URL',
    12 => 'Gerar PDF!',
    13 => 'A configura��o PHP deste servidor n�o permite que URLs sejam usadas com o comando  fopen().  O administrador do sistema deve editar o arquivo php.ini file e definir o par�metro allow_url_fopen como On',
    14 => 'O PDF que voc� requisitou ou n�o existe ou voc� tentou acessar este arquivo de forma ilegal.'
);

?>

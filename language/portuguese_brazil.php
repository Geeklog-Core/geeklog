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

###############################################################################
# Array Format:
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################

###############################################################################
# common.php

$LANG01 = array(
	1 => "Enviado por:",
	2 => "ler mais",
	3 => "coment�rios",
	4 => "Editar",
	5 => "Enquete",
	6 => "Resultados",
	7 => "Resultados da Enquete",
	8 => "votos",
	9 => "Fun��es Administrativas:",
	10 => "Submissions",
	11 => "Hist�rias",
	12 => "Blocos",
	13 => "T�picos",
	14 => "Links",
	15 => "Eventos",
	16 => "Enquetes",
	17 => "Usu�rios",
	18 => "SQL Query",
	19 => "Sair do Sistema",
	20 => "Informa��es do Usu�rio:",
	21 => "Usu�rio",
	22 => "ID",
	23 => "N�vel de Acesso",
	24 => "An�nimo",
	25 => "Responder",
	26 => "Os coment�rios a seguir s�o propriedade de quem os enviou. Este site n�o � respons�vel pelas opini�es expressas por seus usu�rios ou visitantes.",
	27 => "Mensagem mais recente",
	28 => "Excluir",
	29 => "Sem coment�rios.",
	30 => "Hist�rias Anteriores",
	31 => "Tags HTML Permitidas:",
	32 => "Erro, nome de usu�rio inv�lido",
	33 => "Erro, n�o foi poss�vel gravar no arquivo log",
	34 => "Erro",
	35 => "Sair",
	36 => "em",
	37 => "",
	38 => "",
	39 => "Atualizar",
	40 => "",
	41 => "",
	42 => "Autoria de:",
	43 => "Responder",
	44 => "Coment�rio Anterior",
	45 => "Erro MySQL: N�mero",
	46 => "Erro MySQL: Mensagem",
	47 => "Login",
	48 => "Minha Conta",
	49 => "Prefs. Exibi��o",
	50 => "Erro: SQL statement",
	51 => "ajuda",
	52 => "Novo",
	53 => "Administra��o",
	54 => "N�o foi poss�vel abrir o arquivo.",
	55 => "Erro em",
	56 => "Votar",
	57 => "Senha",
	58 => "Entrar",
	59 => "Deseja registrar-se? Clique <a href=\"{$_CONF['site_url']}/users.php?mode=new\">aqui</a>",
	60 => "Comentar",
	61 => "Registrar-se",
	62 => "palavras",
	63 => "Prefs. Coment�rios",
	64 => "Enviar para um Amigo",
	65 => "Vers�o para Impress�o",
	66 => "Meu Calend�rio",
	67 => "Bem-vindo ao ",
	68 => "in�cio",
	69 => "contato",
	70 => "busca",
	71 => "contribuir",
	72 => "links",
	73 => "enquetes",
	74 => "calend�rio",
	75 => "busca avan�ada",
	76 => "estat�sticas do site",
	77 => "Plugins",
	78 => "Pr�ximos Eventos",
	79 => "O que h� de novo",
	80 => "hist�rias nas �ltimas",
	81 => "hist�ria nas �ltimas",
	82 => "horas",
	83 => "COMENT�RIOS",
	84 => "LINKS",
	85 => "48 horas",
	86 => "Sem novos coment�rios",
	87 => "14 dias",
	88 => "Sem novos links",
	89 => "N�o h� eventos programados",
	90 => "In�cio",
	91 => "Criou esta p�gina em",
	92 => "segundos",
	93 => "Copyright",
	94 => "Todas as marcas e copyrights nesta p�gina pertencem aos seus respectivos propriet�rios.",
	95 => "Powered By",
	96 => "Grupos",
    97 => "Lista de Palavras",
	98 => "Plug-ins",
	99 => "HIST�RIAS",
    100 => "Sem novas hist�rias"
    101 => 'Seus Eventos',
	102 => 'Eventos do Site',
	103 => 'DB Backups',
    104 => 'por'
);

###############################################################################
# calendar.php

$LANG02 = array(
	1 => "Calend�rio de Eventos",
	2 => "Lamentamos, mas h� n�o eventos a exibir.",
	3 => "Quando",
	4 => "Onde",
	5 => "Descri��o",
	6 => "Adicionar um Evento",
	7 => "Pr�ximos Eventos",
	8 => 'Ao adicionar este evento ao seu calend�rio voc� poder� ver somente os eventos em que estiver interessado clicando em "Meu Calend�rio" na �rea Fun��es do Usu�rio.',
	9 => "Adicionar ao Meu Calend�rio",
	10 => "Remover do Meu Calend�rio",
	11 => "Adicionando Evento ao Calend�rio de {$_USER['username']}",
	12 => "Evento",
	13 => "In�cio",
	14 => "T�rmino"
);

###############################################################################
# comment.php

$LANG03 = array(
	1 => "Comentar",
	2 => "Modo",
	3 => "Sair",
	4 => "Criar Conta",
	5 => "Usu�rio",
	6 => "Este site requer que voc� efetue o login para enviar um coment�rio.  Se voc� ainda n�o tem uma conta, utilize o formul�rio abaixo para criar uma.",
	7 => "Seu �ltimo coment�rio foi h�",
	8 => " segundos atr�s.  Este site requer pelo menos {$_CONF["commentspeedlimit"]} segundos entre coment�rios",
	9 => "Coment�rio",
	10 => '',
	11 => "Enviar Coment�rio",
	12 => "Por favor, preencha os campos Nome, Email, T�tulo e Coment�rio, pois eles s�o necess�rio para a aceita��o de seu coment�rio.",
	13 => "Suas Informa��es",
	14 => "Preview",
	15 => "",
	16 => "T�tulo",
	17 => "Erro",
	18 => 'Recomenda��es',
	19 => 'Por favor, envie mensagens relacionadas ao assunto tratado no t�pico.',
	20 => 'Tente responder aos coment�rios j� publicados ao inv�s de iniciar novos threads.',
	21 => 'Leia as mensagens de outros usu�rios antes de enviar a sua para prevenir duplicidade de conte�do.',
	22 => 'Seja descritivo ao preencher o campo Assunto.',
	23 => 'Seu email N�O ser� publicado.',
	24 => 'Usu�rio An�nimo'
);

###############################################################################
# users.php

$LANG04 = array(
	1 => "Perfil de",
	2 => "Nome",
	3 => "Nome Completo",
	4 => "Senha",
	5 => "Email",
	6 => "Homepage",
	7 => "Biografia",
	8 => "PGP Key",
	9 => "Salvar",
	10 => "�ltimos 10 coment�rios",
	11 => "Sem Coment�rios",
	12 => "Prefer�ncias de Usu�rio para",
	13 => "Enviar resumo di�rio via Email",
	14 => "Esta senha � gerada aleatoriamente. � recomendado que voc� altere a mesma imediatamente. Para alterar sua senha, efetue o login e clique em Informa��es da conta no menu Fun��es do Usu�rio.",
	15 => "Sua conta no {$_CONF["site_name"]} foi criada. Para ter acesso � mesma, voc� deve efetuar o login utilizando as informa��es abaixo. Poor favor, guarde este email para futuras consultas.",
	16 => "Informa��es sobre sua Conta",
	17 => "Conta inexistente",
	18 => "O endere�o fornecido n�o parece ser um email v�lido",
	19 => "O nome de usu�rio ou o email fornecido j� constam em nossa base de dados",
	20 => "O endere�o fornecido n�o parece ser um email v�lido",
	21 => "Erro",
	22 => "Registro no {$_CONF['site_name']}!",
	23 => "Criando uma conta de usu�rio proporcionar� a voc� todos os benef�cios da associa��o ao {$_CONF['site_name']} e permitir� a voc� enviar coment�rios e mensagens em seu nome. Se n�o tiver uma conta, voc� s� poder� enviar mensagens anonimamente. Por favor, note que seu endere�o de email <b><i>nunca</i></b> ser� exibido publicamente neste site.",
	24 => "Sua senha ser� enviada ao endere�o de email que voc� forneceu.",
	25 => "Esqueceu sua Senha?",
	26 => "Entre seu nome de usu�rio e clique em Enviar Senha. Uma nova senha ser� enviada para o endere�o constante em nossos registros.",
	27 => "Registre-se!",
	28 => "Enviar Senha",
	29 => "saiu do",
	30 => "entrou no",
	31 => "A fun��o selecionada exige a entrada no sistema",
	32 => "Assinatura",
	33 => "N�o ser� exibida publicamente",
	34 => "Este � o seu nome real",
	35 => "Entre a senha para alter�-la",
	36 => "Iniciar com http://",
	37 => "Aplicada aos seus coment�rios",
	38 => "Sobre voc�. (Qualquer pessoa poder� ler isto) ",
	39 => "Sua chave p�blica PGP para ser compartilhada",
	40 => "Sem �cones nos T�picos",
	41 => "Willing to Moderate",
	42 => "Formato de Datas",
	43 => "M�ximo de Hist�rias",
	44 => "Sem caixas",
	45 => "Prefer�ncias de Exibi��o para",
	46 => "�tens Exclu�dos para",
	47 => "Configura��o do Box de Not�cias para",
	48 => "T�picos",
	49 => "Sem �cones nas hist�rias",
	50 => "Desmarque se n�o estiver interessado",
	51 => "Somente as Not�cias",
	52 => "O padr�o � 10",
	53 => "Receber as not�cias via resumo di�rio",
	54 => "Selecione os t�picos e autores que voc� n�o quer ver.",
	55 => "Se voc� deixar todos desmarcados, subentende-se que voc� deseja a sele��o padr�o. Se voc� iniciar a sele��o, lembre-se de selecionar todos os que voc� deseja, pois a sele��o padr�o ser� ignorada. Entradas padr�o s�o exibidas em <b>negrito</b>.",
	56 => "Autores",
	57 => "Modo de Exibi��o",
	58 => "Ordenar por",
	59 => "Limite de Coment�rios",
	60 => "Como voc� prefere que os coment�rios sejam exibidos?",
	61 => "Novos ou antigos primeiro?",
	62 => "O padr�o � 100",
	63 => "Sua senha foi enviada. Por favor, siga as instru��es constantes no email. Obrigado por participar do " . $_CONF["site_name"],
	64 => "Prefer�ncias Atuais para",
	65 => "Tente Entrar novamente",
	66 => "Voc� cometeu um erro ao preencher os campos. Por favor, tente efetuar o login novamente. Voc� � um <a href=\"{$_CONF['site_url']}/users.php?mode=new\">novo usu�rio</a>?",
	67 => "Membro Desde",
	68 => "Lembrar de mim por",
	69 => "Por quanto tempo voc� deseja ser lembrado ap�s efetuar o login?",
	70 => "Personalize o layout e o conte�do do {$_CONF['site_name']}",
	71 => "Uma das caracter�sticas do {$_CONF['site_name']} � a possibilidade poder personalizar todo o seu conte�do e alterar o layout do site. Para poder usufruir destas vantagens voc� precisa<a href=\"{$_CONF['site_url']}/users.php?mode=new\">registrar-se</a> no {$_CONF['site_name']}.  Voc� j� � um membro? Efetue o login!",
    72 => "Tema",
    73 => "Idioma"
);

###############################################################################
# index.php

$LANG05 = array(
	1 => "Sem not�cias para exibir",
	2 => "N�o h� novas hist�rias para exibir. Talvez n�o haja novidades para este t�pico ou suas prefer�ncias de exibi��o s�o muito restritivas.",
	3 => "para o t�pico $topic",
	4 => "Artigo de Hoje",
	5 => "Pr�ximo",
	6 => "Anterior"
);

###############################################################################
# links.php

$LANG06 = array(
	1 => "Links",
	2 => "N�o h� links a exibir.",
	3 => "Adicionar Link"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
	1 => "Voto Registrado",
	2 => "Seu voto foi registrado.",
	3 => "Enquete",
	4 => "Enquetes no Sistema",
	5 => "Votos"
);

###############################################################################
# profiles.php

$LANG08 = array(
	1 => "Houve um erro ao enviar sua mensagem. Por favor, tente novamente.",
	2 => "Mensagem enviada.",
	3 => "Please make sure you use a valid email address in the Reply To field.",
	4 => "Por favor, preencha os campos Seu Nome, Responder para, Assunto e Mensagem",
	5 => "Erro: Usu�rio desconhecido.",
	6 => "H� um erro.",
	7 => "Perfil de Usu�rio para",
	8 => "ID",
	9 => "URL",
	10 => "Enviar email para",
	11 => "Seu Nome:",
	12 => "Responder:",
	13 => "Assunto:",
	14 => "Mensagem:",
	15 => "HTML n�o ser� traduzido.",
	16 => "Enviar Mensagem",
	17 => "Enviar Hist�ria para um Amigo",
	18 => "Nome",
	19 => "Email",
	20 => "Seu Nome",
	21 => "Seu Email",
	22 => "Todos os campos s�o requeridos",
	23 => "Este email foi enviado a voc� por $from em $fromemail pois ele acha que voc� pode se interessar por um artigo no {$_CONF["site_url"]}.  Isto n�o � um SPAM e os endere�o de email envolvidos n�o s�o exibidos ou guardados para uso posterior.",
	24 => "Coment�rio sobre esta hist�ria em",
	25 => "Voc� precisa efetuar o login para utilizar este recurso. Ao efetuar o login, voc� nos ajuda a prevenir o mal-uso do sistema",
	26 => "Este formul�rio permite a voc� enviar um email para o usu�rio selecionado. Todos os campos s�o obrigat�rios.",
	27 => "Apresenta��o",
	28 => "$from escreveu: $shortmsg"
	29 => "Este � o resumo di�rio do {$_CONF['site_name']} para ",
	30 => " Resumo Di�rio "
);

###############################################################################
# search.php

$LANG09 = array(
	1 => "Busca Avan�ada",
	2 => "Palavras-chave",
	3 => "T�pico",
	4 => "Todos",
	5 => "Tipo",
	6 => "Hist�rias",
	7 => "Coment�rios",
	8 => "Autores",
	9 => "Todos",
	10 => "Buscar",
	11 => "Resultados da Busca",
	12 => "correspond�ncias",
	13 => "Resultado da Busca: nenhuma correspond�ncia",
	14 => "N�o h� correspond�ncia para sua busca em"
	15 => "Por favor, tente novamente.",
	16 => "T�tulo",
	17 => "Data",
	18 => "Autor",
	19 => "Pesquisar em toda a Base de Dados do {$_CONF["site_name"]} ",
	20 => "Data",
	21 => "para",
	22 => "(Formato de Data MM-DD-AAAA)",
	23 => "Hits",
	24 => "Encontrou",
	25 => "correspond�ncias para",
	26 => "itens em",
	27 => "segundos",
    28 => 'Nenhuma hist�ria ou coment�rio correspondente encontrados',
    29 => 'Resultados: Hist�rias e Coment�rio'
);

###############################################################################
# stats.php

$LANG10 = array(
	1 => "Estat�sticas do Site",
	2 => "Total de Hits no Sistema",
	3 => "Hist�rias(Coment�rios) no Sistema",
	4 => "Enquetes(Respostas) no Sistema",
	5 => "Links(Cliques) no Sistema",
	6 => "Eventos no Sistema",
	7 => "10 Hist�rias Mais Lidas",
	8 => "T�tulo",
	9 => "Visualiza��es",
	10 => "Aparentemente n�o h� hist�rias neste site ou ningu�m leu as que foram publicadas.",
	11 => "10 Hist�rias Mais Comentadas",
	12 => "Coment�rios",
	13 => "Aparentemente n�o h� hist�rias neste site ou ningu�m comentou as que foram publicadas.",
	14 => "10 Enquetes Mais Votadas",
	15 => "Pergunta",
	16 => "Votos",
	17 => "Aparentemente n�o h� enquetes neste site ou ningu�m votou nas existentes.",
	18 => "Top 10 - Links",
	19 => "Links",
	20 => "Hits",
	21 => "Aparentemente n�o h� links neste site ou ningu�m clicou nos existentes.",
	22 => "Top 10 - Hist�rias Recomendadas via email",
	23 => "Emails",
	24 => "Aparentemente ningu�m enviou uma hist�ria via email neste site"
);

###############################################################################
# article.php

$LANG11 = array(
	1 => "Relacionado",
	2 => "Enviar para um Amigo",
	3 => "Vers�o para Impress�o",
	4 => "Op��es da Hist�ria"
);

###############################################################################
# submit.php

$LANG12 = array(
	1 => "Para enviar uma $type voc� precisa efetuar o login.",
	2 => "Login",
	3 => "Novo Usu�rio",
	4 => "Enviar um Evento",
	5 => "Enviar um Link",
	6 => "Enviar uma Hist�ria",
	7 => "Login � Requerido",
	8 => "OK",
	9 => "Ao enviar informa��es para utiliza��o neste site n�s solicitamos a voc� que siga as seguintes recomenda��es...<ul><li>Preencha todos os campos, eles s�o obrigat�rios<li>Forne�a informa��es completas e apuradas<li>Verifique as URLs</ul>",
	10 => "T�tulo",
	11 => "Link",
	12 => "Data de In�cio",
	13 => "Data de T�rmino",
	14 => "Local",
	15 => "Descri��o",
	16 => "Se outra, especifique",
	17 => "Categoria",
	18 => "Outra",
	19 => "Leia Primeiro",
	20 => "Erro: Faltando Categoria",
	21 => "Ao selecionar \"Outra\" favor indicar um nome",
	22 => "Erro: Campos em branco",
	23 => "Por favor, preencha todos os campos do formul�rio. Todos os campos s�o obrigat�rios.",
	24 => "Sugest�o recebida",
	25 => "Sua sugest�o de $type foi arquivada com sucesso.",
	26 => "Limite de Velocidade",
	27 => "Usu�rio",
	28 => "T�pico",
	29 => "Hist�ria",
	30 => "Sua �ltima sugest�o foi enviada h� ",
	31 => " segundos. Este site requer pelo menos {$_CONF["speedlimit"]} segundos entre o envio de uma mensagem e outra",
	32 => "Preview",
	33 => "Preview da Hist�ria",
	34 => "Sair",
	35 => "Tags HTML n�o s�o permitidas",
	36 => "Modo",
	37 => "Sugerindo um evento ao {$_CONF["site_name"]} ir� inclu�-lo no Calend�rio Principal, onde os usu�rios poder�o adicion�-lo aos seus Calend�rios Pessoais. Este recurso <b>N�O</b> permite a voc� arquivar seus eventos pessoais como anivers�rios e celebra��es.<br><br>Uma vez enviado, seu evento ser� remetido ao nosso administrador para verifica��o, e caso o mesmo seja aprovado, ser� inclu�do no Calend�rio Principal.",
    38 => "Adicionar Evento ao",
    39 => "Calend�rio Principal",
    40 => "Calend�rio Pessoal",
    41 => "In�cio",
    42 => "T�rmino",
    43 => "Evento Di�rio",
    44 => 'Endere�o',
    45 => 'continua��o',
    46 => 'Cidade/Distrito',
    47 => 'Estado',
    48 => 'CEP',
    49 => 'Tipo de Evento',
    50 => 'Editar Tipos de Eventos',
    51 => 'Local',
    52 => 'Excluir'
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
	1 => "Autentica��o Requerida",
	2 => "Negado! Informa��es de Login Incorretas",
	3 => "Senha inv�lida para o usu�rio",
	4 => "Usu�rio:",
	5 => "Senha:",
	6 => "Todos os acessos � �rea administrativa deste site s�o monitorados e revisados.<br>Esta p�gina � para uso exclusivo das pessoas autorizadas.",
	7 => "entrar"
);

###############################################################################
# block.php

$LANG21 = array(
	1 => "Direitos Insuficientes",
	2 => "Voc� n�o tem permiss�o para editar este bloco.",
	3 => "Editor de Blocos",
	4 => "",
	5 => "T�tulo",
	6 => "T�pico",
	7 => "Todos",
	8 => "N�vel de Acesso",
	9 => "Ordem",
	10 => "Tipo",
	11 => "Portal",
	12 => "Normal",
	13 => "Op��es - Portal",
	14 => "RDF URL",
	15 => "�ltima Atualiza�ao RDF",
	16 => "Op��es - Normal",
	17 => "Conte�do",
	18 => "Por favor, preencha os campos T�tulo, N�vel de Securan�a e Conte�do",
	19 => "Gerenciador de Blocos",
	20 => "T�tulo",
	21 => "N�vel de Seguran�a",
	22 => "Tipo",
	23 => "Ordem",
	24 => "T�pico",
	25 => "Para modificar ou excluir um bloco, clique no bloco abaixo. Para criar um bloco, clique em Novo Bloco.",
	26 => "Layout",
	27 => "Bloco PHP",
        28 => "Op��es Bloco PHP",
        29 => "Fun��o do Bloco",
        30 => "If you would like to have one of your blocks use PHP code, enter the name of the function above.  Your function name must start with the prefix \"phpblock_\" (e.g. phpblock_getweather).  If it does not have this prefix, your function will NOT be called.  We do this to keep people who may have hacked your Geeklog installation from putting arbitrary function calls that may be harmful to your system.  Be sure not to put empty parenthisis \"()\" after your function name.  Finally, it is recommended that you put all your PHP Block code in custom_code.php.  That will allow the code to stay with you even when you upgrade to a newer version of Geeklog.",
        31 => "Erro no Bloco PHP. A fun��o , $function, n�o existe.",
        32 => "Error Missing Field(s)",
        33 => "You must enter the URL to the .rdf file for portal blocks",
        34 => "You must enter the title and the function for PHP blocks",
        35 => "You must enter the title and the content for normal blocks",
        36 => "You must enter the content for layout blocks",
        37 => "Bad PHP block function name",
        38 => "Functions for PHP Blocks must have the prefix 'phpblock_' (e.g. phpblock_getweather).  The 'phpblock_' prefix is required for security reasons to prevent the execution of arbitrary code.",
	39 => "Lado",
	40 => "Esquerdo",
	41 => "Direito",
	42 => "You must enter the blockorder and security level for Geeklog default blocks",
	43 => "Somente na P�gina Inicial",
	44 => "Acesso Negado",
	45 => "You are trying to access a block that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/block.php\">go back to the block administration screen</a>.",
	46 => 'Novo Bloco',
	47 => 'Administra��o',
    48 => 'Nome',
    49 => ' (sem espa�os e �nico)'
    50 => 'URL do Arquivo de Ajuda',
	51 => 'inclua http://',
    52 => 'Se voc� deixar em branco, o �cone de ajuda para este bloco n�o ser� exibido'
);

###############################################################################
# event.php

$LANG22 = array(
	1 => "Editor de Eventos",
	2 => "",
	3 => "T�tulo",
	4 => "URL",
	5 => "In�cio",
	6 => "T�rmino",
	7 => "Local",
	8 => "Descri��o",
	9 => "(incluir http://)",
	10 => "Voc� deve preencher todos os campos deste formul�rio!",
	11 => "Gerenciador de Eventos",
	12 => "To modify or delete a event, click on that event below.  To create a new event click on new event above.",
	13 => "T�tulo",
	14 => "In�cio",
	15 => "T�rmino",
	16 => "Acesso Negado",
	17 => "You are trying to access an event that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/event.php\">go back to the event administration screen</a>.",
	18 => 'Novo Evento',
	19 => 'Administra��o'
);

###############################################################################
# link.php

$LANG23 = array(
	1 => "Editor de Links",
	2 => "",
	3 => "T�tulo",
	4 => "URL",
	5 => "Categoria",
	6 => "(incluir http://)",
	7 => "Outra",
	8 => "Hits",
	9 => "Descri��o",
	10 => "Voc� deve digitar um T�tulo, um URL e a Descri��o.",
	11 => "Gerenciador de Links",
	12 => "To modify or delete a link, click on that link below.  To create a new link click new link above.",
	13 => "T�tulo",
	14 => "Categoria",
	15 => "URL",
	16 => "Acesso Negado",
	17 => "You are trying to access a link that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/link.php\">go back to the link administration screen</a>.",
	18 => 'Novo Link',
	19 => 'Administra��o',
	20 => 'Se outra, especifique'
);

###############################################################################
# story.php

$LANG24 = array(
	1 => "Hist�rias Anteriores",
	2 => "Pr�ximas Hist�rias",
	3 => "Modo",
	4 => "Formata��o",
	5 => "Editor de Hist�rias",
	6 => "",
	7 => "Autor",
	8 => "",
	9 => "",
	10 => "",
	11 => "",
	12 => "",
	13 => "T�tulo",
	14 => "T�pico",
	15 => "Data",
	16 => "Introdu��o",
	17 => "Texto/Conte�do",
	18 => "Hits",
	19 => "Coment�rios",
	20 => "",
	21 => "",
	22 => "Lista de Hist�rias",
	23 => "To modify or delete a story, click on that story's number below. To view a story, click on the title of the story you wish to view. To create a new story click on new story above.",
	24 => "",
	25 => "",
	26 => "Preview",
	27 => "",
	28 => "",
	29 => "",
	30 => "",
	31 => "Please fill in the Author, Title and Intro Text fields",
	32 => "Hist�ria do Dia",
	33 => "S� pode haver uma �nica Hist�ria do Dia",
	34 => "Rascunho",
	35 => "Sim",
	36 => "N�o",
	37 => "Mais por",
	38 => "Mais de",
	39 => "Emails",
	40 => "Acesso Negado ",
	41 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  You may view the article in read-only below. Please <a href=\"{$_CONF["site_admin_url"]}/story.php\">go back to the story administration screen</a> when you are done.",
	42 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  Please <a href=\"{$_CONF["site_admin_url"]}/story.php\">go back to the story administration screen</a>.",
	43 => 'Nova Hist�ria',
	44 => 'Administra��o',
	45 => 'Acesso'
	46 => '<b>NOTE:</b> if you modify this date to be in the future, this article will not be published until that date.  That also means the story will not be included in your RDF headline feed and it will be ignored by the search and statistics pages.'
);

###############################################################################
# poll.php

$LANG25 = array(
	1 => "Modo",
	2 => "",
	3 => "Enquete Criada",
	4 => "Enquete $qid salva",
	5 => "Editar Enquete",
	6 => "ID da Enquete",
	7 => "(n�o use espa�os)",
	8 => "Exibir na P�gina Inicial",
	9 => "Pergunta",
	10 => "Respostas / Votos",
	11 => "There was an error getting poll answer data about the poll $qid",
	12 => "There was an error getting poll question data about the poll $qid",
	13 => "Criar Enquete",
	14 => "",
	15 => "",
	16 => "",
	17 => "",
	18 => "Lista de Enquetes",
	19 => "To modify or delete a poll, click on that poll.  To create a new poll click on new poll above.",
	20 => "Votantes",
	21 => "Acesso Negado",
	22 => "You are trying to access a poll that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/poll.php\">go back to the poll administration screen</a>.",
	23 => 'Nova Enquete',
	24 => 'Administra��o',
	25 => 'Sim',
	26 => 'N�o'
);

###############################################################################
# topic.php

$LANG27 = array(
	1 => "Editor de T�picos",
	2 => "ID",
	3 => "Nome",
	4 => "Imagem",
	5 => "(n�o use espa�os)",
	6 => "Deleting a topic deletes all stories and blocks associated with it",
	7 => "Por favor, preencha os campos ID e Nome do T�pico",
	8 => "Gerenciador de T�picos",
	9 => "To modify or delete a topic, click on that topic.  To create a new topic click the new topic button to the left. You will find you access level for each topic in parenthesis",
	10=> "Ordem de Exibi��o",
	11 => "H�st�rias/P�gina",
	12 => "Acesso Negado",
	13 => "You are trying to access a topic that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_admin_url"]}/topic.php\">go back to the topic administration screen</a>.",
	14 => "Ordem",
	15 => "alfab�tica",
	16 => "o padr�o �",
	17 => "Novo T�pico",
	18 => "Administra��o"
);

###############################################################################
# user.php

$LANG28 = array(
	1 => "Editor de Usu�rios",
	2 => "ID",
	3 => "User Name",
	4 => "Nome Completo",
	5 => "Senha",
	6 => "N�vel de Acesso",
	7 => "Email",
	8 => "Homepage",
	9 => "(n�o use espa�os)",
	10 => "Please fill in the Username, Full name, Security Level and Email Address fields",
	11 => "Gerenciador de Usu�rios",
	12 => "To modify or delete a user, click on that user below.  To create a new user click the new user button to the left.",
	13 => "N�vel de Acesso",
	14 => "Data Registro.",
	15 => 'Novo Usu�rio',
	16 => 'Administra��o',
	17 => 'alterar senha',
	18 => 'cancelar',
	19 => 'excluir',
	20 => 'salvar',
	18 => 'cancelar',
	19 => 'excluir',
	20 => 'salvar',
    21 => 'The username you tried saving already exists.',
    22 => 'Erro'
);


###############################################################################
# moderation.php

$LANG29 = array(
	1 => "Aprovar",
	2 => "Excluir",
	3 => "Editar",
	34 => "Comando e Controle",
	35 => "Story Submissions",
	36 => "Link Submissions",
	37 => "Event Submissions",
	38 => "Enviar",
	39 => "There are no submissions to moderate at this time"
);

###############################################################################
# calendar.php

$LANG30 = array(
	1 => "Domingo",
	2 => "Segunda",
	3 => "Ter�a",
	4 => "Quarta",
	5 => "Quinta",
	6 => "Sexta",
	7 => "S�bado",
	8 => "Adicionar Evento",
	9 => "Evento do Site",
	10 => "Eventos para",
	11 => "Calend�rio Principal",
	12 => "Meu Calend�rio",
	13 => "Janeiro",
	14 => "Fevereiro",
	15 => "Mar�o",
	16 => "Abril",
	17 => "Maio",
	18 => "Junho",
	19 => "Julho",
	20 => "Agosto",
	21 => "Setembro",
	22 => "Outubro",
	23 => "Novembro",
	24 => "Dezembro",
	25 => "",
    26 => "Todos os Dias",
    27 => "Semanal",
    28 => "Calend�rio Pessoal de",
    29 => "Calend�rio P�blico",
    30 => "excluir evento",
    31 => "Adicionar",
    32 => "Evento",
    33 => "Data",
    34 => "Hora",
    35 => "Quick Add",
    36 => "Enviar",
    37 => "Lamentamos, mas o Calend�rio Pessoal n�o est� habilitado neste site",
    38 => "Editor de Eventos Pessoais"
);

###############################################################################
# admin/mail.php
$LANG31 = array(
 	1 => "Mail",
 	2 => "De",
 	3 => "Responder para",
 	4 => "Assunto",
 	5 => "Conte�do",
 	6 => "Enviar para:",
 	7 => "Todos os Usu�rios",
 	8 => "Administrador",
	9 => "Op��es",
	10 => "HTML",
 	11 => "Mensagem Urgente!",
 	12 => "Enviado",
 	13 => "Reset",
 	14 => "Ignorar prefer�ncias do usu�rio ",
 	15 => "Erro ao enviar para: ",
	16 => "Mensagens enviadas para: ",
	17 => "<a href=" . $_CONF["site_admin_url"] . "/mail.php>Enviar outra mensagem</a>"
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "Your password has been emailed to you and should arrive momentarily. Please follow the directions in the message and we thank-you for using " . $_CONF["site_name"],
	2 => "Thank-you for submitting your story to {$_CONF["site_name"]}.  It has been submitted to our staff for approval. If approved, your story will be available for others to read on our site.",
	3 => "Thank-you for submitting a link to {$_CONF["site_name"]}.  It has been submitted to our staff for approval.  If approved, your link will be seen in the <a href={$_CONF["site_url"]}/links.php>links</a> section.",
	4 => "Thank-you for submitting an event to {$_CONF["site_name"]}.  It has been submitted to our staff for approval.  If approved, your event will be seen in our <a href={$_CONF["site_url"]}/calendar.php>calendar</a> section.",
	5 => "Your account information has been successfully saved.",
	6 => "Your display preferences have been successfully saved.",
	7 => "Your comment preferences have been successfully saved.",
	8 => "You have been successfully logged out.",
	9 => "Your story has been successfully saved.",
	10 => "A hist�ria foi exclu�da com sucesso.",
	11 => "Your block has been successfully saved.",
	12 => "O bloco foi exclu�do com sucesso.",
	13 => "Your topic has been successfully saved.",
	14 => "The topic and all it's stories an blocks have been successfully deleted.",
	15 => "Your link has been successfully saved.",
	16 => "O link foi exclu�do com sucesso.",
	17 => "Your event has been successfully saved.",
	18 => "O evento foi exclu�do com sucesso.",
	19 => "Your poll has been successfully saved.",
	20 => "A enquete foi exclu�da com sucesso.",
	21 => "The new user has been successfully saved.",
	22 => "O usu�rio foi exclu�do com sucesso",
	23 => "Error trying to add an event to your calendar. There was no event id passed.",
	24 => "The event has been saved to your calendar",
	25 => "Cannot open your personal calendar until you login",
	26 => "Event was successfully removed from your personal calendar",
	27 => "Mensagem enviada com sucesso.",
	28 => "The plug-in has been successfully saved",
	29 => "Lamentamos, mas calend�rios pessoais n�o est�o habilitados neste site",
	30 => "Acesso Negado",
	31 => "Sorry, you do not have access to the story administration page.  Please note that all attempts to access unauthorized features are logged",
	32 => "Sorry, you do not have access to the topic administration page.  Please note that all attempts to access unauthorized features are logged",
	33 => "Sorry, you do not have access to the block administration page.  Please note that all attempts to access unauthorized features are logged",
	34 => "Sorry, you do not have access to the link administration page.  Please note that all attempts to access unauthorized features are logged",
	35 => "Sorry, you do not have access to the event administration page.  Please note that all attempts to access unauthorized features are logged",
	36 => "Sorry, you do not have access to the poll administration page.  Please note that all attempts to access unauthorized features are logged",
	37 => "Sorry, you do not have access to the user administration page.  Please note that all attempts to access unauthorized features are logged",
	38 => "Sorry, you do not have access to the plugin administration page.  Please note that all attempts to access unauthorized features are logged",
	39 => "Sorry, you do not have access to the mail administration page.  Please note that all attempts to access unauthorized features are logged",
	40 => "Mensagem do Sistema",
    41 => "Sorry, you do not have access to the word replacement page.  Please not that all attempts to access unauthorized features are logged",
    42 => "Your word has been successfully saved.",
	43 => "A palavra foi exclu�da com sucesso.",
    44 => 'The plug-in was successfully installed!',
    45 => 'O plug-in foi exclu�do com sucesso.'
    46 => "Sorry, you do not have access to the database backup utility.  Please note that all attempts to access unauthorized features are logged"
);

// for plugins.php

$LANG32 = array (
	1 => "Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system.  It is important that you only install plugins downloaded from the <a href=\"http://geeklog.sourceforge.net\" target=\"_blank\">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems.  It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites.  Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin.  In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.",
	2 => "Plug-in Installation Disclaimer",
	3 => "Plug-in Installation Form",
	4 => "Arquivo Plug-in",
	5 => "Lista de Plug-ins",
	6 => "Aten��o: Plug-in j� instalado!",
	7 => "O plug-in que voc� est� tentando instalar j� existe. Remova-o antes de reinstal�-lo",
	8 => "Houve uma falha durante a verifica��o de compatibilidade do Plugin",
	9 => "This plugin requires a newer version of Geeklog. Either upgrade your copy of <a href=http://www.geeklog.org>Geeklog</a> or get a newer version of the plug-in.",
	10 => "<br><b>N�o h� plugins instalados atualmente.</b><br><br>",
	11 => "To modify or delete a plug-in, click on that plug-in's number below. To learn more about a plug-in, click the plug-in name and you will be directed to that plug-in's website. To install or upgrade a plug-in click on new plug-in above.",
	12 => 'no plugin name provided to plugineditor()',
	13 => 'Editor de Plugins',
	14 => 'Novo Plug-in',
	15 => 'Admininistra��o',
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
    31 => 'Are you sure you want to delete this plug-in?  By doing so you will remove all the files, data and data structures that this plug-in uses.  If you are sure, click delete again on the form below.'
);

$LANG_ACCESS = array(
	access => "Acesso",
    ownerroot => "Propriet�rio/Root",
    group => "Grupo ",
    readonly => "Somente Leitura",
	accessrights => "Direito de Acesso",
	owner => "Propriet�rio ",
	grantgrouplabel => "Grant Above Group Edit Rights",
	permmsg => "NOTE: members is all logged in members of the site and anonymous is all users browsing the site that aren't logged in.",
	securitygroups => "Security Groups",
	editrootmsg => "Even though you are a User Administrator, you can't edit a root user without first being a root user yourself.  You can edit all other users except root users. Please note that all attempts to illegally edit root users are logged.  Please go back to the <a href=\"{$_CONF["site_admin_url"]}/users.php\">User Administration page</a>.",
	securitygroupsmsg => "Select the checkboxes for the groups you want the user to belong to.",
	groupeditor => "Editor de Grupos",
	description => "Descri��o",
	name => "Nome",
 	rights => "Direitos",
	missingfields => "Missing Fields",
	missingfieldsmsg => "You must supply the name and a description for a group",
	groupmanager => "Gerenciador de Grupos",
	newgroupmsg => "To modify or delete a group, click on that group below. To create a new group click new group above. Please note that core groups cannot be deleted because they are used in the system.",
	groupname => "Nome",
	coregroup => "Core Group",
	yes => "Sim",
	no => "N�o",
	corerightsdescr => "This group is a core {$_CONF["site_name"]} Group.  Therefore the rights for this group cannot be edited.  Below is a read-only list of the rights this group has access to.",
	groupmsg => "Security Groups on this site are hierarchical.  By adding this group to any of the groups below you will giving this group the same rights that those groups have.  Where possible it is encouraged you use the groups below to give rights to a group.  If you need this group to have custom rights then you can select the rights to various site features in the section below called 'Rights'.  To add this group to any of the ones below simply check the box next to the group(s) that you want.",
	coregroupmsg => "This group is a core {$_CONF["site_name"]} Group.  Therefore the groups that this groups belongs to cannot be edited.  Below is a read-only list of the groups this group belongs to.",
	rightsdescr => "A groups access to a certain right below can be given directly to the group OR to a different group that this group is a part of.  The ones you see below without a checkbox are the rights that have been given to this group because it belongs to another group with that right.  The rights with checkboxes below are rights that can be given directly to this group.",
	lock => "Bloquear",
	members => "Membros",
	anonymous => " An�nimos ",
	permissions => "Permiss�es",
	permissionskey => "R = ler, E = editar (direito de editar pressup�e direito de ler)",
	edit => "Editar",
	none => "Nenhum",
	accessdenied => "Acesso Negado",
	storydenialmsg => "You do not have access to view this story.  This could be because you aren't a member of {$_CONF["site_name"]}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF["site_name"]} to receive full membership access!",
	eventdenialmsg => "You do not have access to view this event.  This could be because you aren't a member of {$_CONF["site_name"]}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF["site_name"]} to receive full membership access!",
	nogroupsforcoregroup => "This group doesn't belong to any of the other groups",
	grouphasnorights => "This group doesn't have access to any of the administrative features of this site",
	newgroup => 'Novo Grupo',
	adminhome => 'Administra��o',
	save => 'salvar',
	cancel => 'cancelar',
	canteditroot => 'You have tried to edit the Root group but you are not in the Root group yourself therefore your access to this group is denied.  Please contact the system administrator if you feel this is an error'
);

#admin/word.php
$LANG_WORDS = array(
    editor => "Substitui��o de Termos/Palavras",
    wordid => "ID da Palavra",
    intro => "Para modificar ou excluir uma palavra, clique nela. Para adicionar uma � lista, clique no bot�o � esquerda. To create a new word replacement click the new word button to the left.",
    wordmanager => "Gerenciador de Palavras",
    word => "Palavra",
    replacmentword => "Substituir por",
    newword => "Nova Palavra"
);

$LANG_DB_BACKUP = array(
    last_ten_backups => 'Last 10 Back-ups',
    do_backup => 'Do Backup',
    backup_successful => 'Database back up was successful.',
    no_backups => 'No backups in the system',
    db_explanation => 'To create a new backup of your Geeklog system, hit the button below'
);

?>

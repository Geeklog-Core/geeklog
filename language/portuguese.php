<?php

###############################################################################
# portuguese.php
# Esta é a tradução em Português do GeekLog!
#
# Copyright (C) 2003 Mário Seabra
# mseabra@bairrinfor.com
#
# Este programa é software livre; é permitida a sua distribuição e /ou
# modificação dentro dos termos GNU General Public License
# como publicado pela Free Software Foundation; incluindo a versão 2
# da Licença, ou (por opção sua) qualquer versão anterior.
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

$LANG_CHARSET = "iso-8859-1";

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
	1 => "Contribuição de:",
	2 => "mais",
	3 => "comentário",
	4 => "Editar",
	5 => "Votação",
	6 => "Resultados",
	7 => "Votações",
	8 => "votos",
	9 => "Funções administrativas:",
	10 => "Submissões",
	11 => "Notícias",
	12 => "Blocos",
	13 => "Tópicos",
	14 => "Ligações",
	15 => "Eventos",
	16 => "Votações",
	17 => "Utilizadores",
	18 => "SQL Query",
	19 => "Sair",
	20 => "Informação do utilizador:",
	21 => "Utilizador",
	22 => "ID do utilizador",
	23 => "Nível de segurança",
	24 => "Anónimo",
	25 => "Responder",
	26 => "Os seguintes comentários são da responsabilidade de quem os fez. A página não é responsavél pelo contéudo dos mesmos.",
	27 => "Comentário mais recente",
	28 => "Apagar",
	29 => "Sem comentários.",
	30 => "Notícias anteriores",
	31 => "Tags HTML permitidas:",
	32 => "Erro, nome de utilizador inválido",
	33 => "Erro, não consegue escrever para o ficheiro de log",
	34 => "Erro",
	35 => "Sair",
	36 => "ligado",
	37 => "Nenhuma notícia",
	38 => "",
	39 => "Actualizar",
	40 => "",
	41 => "Utilizadores convidados",
	42 => "Enviada por:",
	43 => "Responder",
	44 => "Parent",
	45 => "Número de erro MySQL",
	46 => "Mensagem de erro MySQL",
	47 => "Utilizador",
	48 => "Informação da conta",
	49 => "Mostrar preferências",
	50 => "Erro de SQL",
	51 => "ajuda",
	52 => "Novo",
	53 => "Administração",
	54 => "Impossível abrir o ficheiro.",
	55 => "Erro em",
	56 => "Votar",
	57 => "Password",
	58 => "Entrar",
	59 => "Ainda não tem uma conta?  Inscreva-se como <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Novo Utilizador</a>",
	60 => "Faça um comentário",
	61 => "Criar uma conta",
	62 => "palavras",
	63 => "Preferências para os comentários",
	64 => "Enviar artigo por Email",
	65 => "Ver versão para impressão",
	66 => "Calendário pessoal",
	67 => "Bem-vindo a ",
	68 => "início",
	69 => "contacto",
	70 => "procurar",
	71 => "contribute",
	72 => "recursos",
	73 => "últimas votações",
	74 => "calendário",
	75 => "pesquisa avançada",
	76 => "estatísticas",
	77 => "Plugins",
	78 => "Próximos Eventos",
	79 => "Novidades",
	80 => "notícias nas últimas",
	81 => "notícia nas últimas",
	82 => "horas",
	83 => "COMENTÁRIOS",
	84 => "LIGAÇÕES",
	85 => "últimas 48 horas",
	86 => "Nenhum comentário novo",
	87 => "últimas 2 semanas",
	88 => "Nenhuma ligação recente",
	89 => "Não há eventos brevemente",
	90 => "Início",
	91 => "Página criada em",
	92 => "segundos",
	93 => "Copyright",
	94 => "Todos os direitos de copyright desta página pertencem aos respectivos proprietários.",
	95 => "Suportado por",
	96 => "Grupos",
    97 => "Lista de palavras",
	98 => "Plug-ins",
	99 => "NOTÍCIAS",
    100 => "Nenhuma notícia nova",
    101 => 'Eventos pessoais',
    102 => 'Eventos globais',
    103 => 'DB Backups',
    104 => 'por',
    105 => 'Enviar email',
    106 => 'Visitas',
    107 => 'Teste à versão do GL',
    108 => 'Limpar Cache'
);

###############################################################################
# calendar.php

$LANG02 = array(
	1 => "Calendário de Eventos",
	2 => "Não há eventos para mostrar.",
	3 => "Quando",
	4 => "Onde",
	5 => "Descrição",
	6 => "Adicionar um Evento",
	7 => "Próximos Eventos",
	8 => 'Adicionando este evento ao seu calendário pode ver rapidamente os eventos do seu interesse clicando em "O meu calendário" na área de funções do utilizador.',
	9 => "Adicionar ao meu calendário",
	10 => "Remover do meu calendário",
	11 => "A adicionar evento ao calendário de {$_USER['username']}",
	12 => "Evento",
	13 => "Início",
	14 => "Fim",
        15 => "Voltar ao calendário"
);

###############################################################################
# comment.php

$LANG03 = array(
	1 => "Fazer comentário",
	2 => "Modo de envio",
	3 => "Sair",
	4 => "Registar utilizador",
	5 => "Nome de utilizador",
	6 => "Este site obriga a que tenha efectuado o login para fazer um comentário, Por favor efectue o login.  Se não tiver uma conta criada pode utilizar o formulário seguinte para se registar.",
	7 => "O seu último comentário foi ",
	8 => " segundos atrás.  Este site a pelo menos {$_CONF["commentspeedlimit"]} segundos entre comentários",
	9 => "Comentário",
	10 => '',
	11 => "Enviar comentário",
	12 => "Preencha os campos título e comentário. Estes campos são necessários para o envio de um comentário.",
	13 => "A sua informação",
	14 => "Previsualizar",
	15 => "",
	16 => "Título",
	17 => "Erro",
	18 => 'A ter em conta',
	19 => 'Tente manter os seus comentários relacionados com os tópicos.',
	20 => 'Tente responder aos outros comentários em vez de iniciar um assunto novo.',
	21 => 'Leia as mensagens das outras pessoas antes de fazer o seu comentário para evitar comentários em duplicado.',
	22 => 'Utilize um assunto objectivo que descreva a que se refere o seu comentário.',
	23 => 'O seu endereço de email não é tornado público.',
	24 => 'Utilizador anónimo'
);

###############################################################################
# users.php

$LANG04 = array(
	1 => "Perfil de utilizador de",
	2 => "Nome de utilizador",
	3 => "Nome completo",
	4 => "Password",
	5 => "Email",
	6 => "Página principal",
	7 => "Bio",
	8 => "PGP Key",
	9 => "Guardar informação",
	10 => "Últimos 10 comentários do utilizador",
	11 => "Nenhum comentário efectuado",
	12 => "Preferências do utilizador para",
	13 => "Email Nightly Digest",
	14 => "Esta password foi gerada aleatoriamente. Recomendamos que a altere o mais rápido possível. Para alterar a password, efectue o login e clique em Informação da conta no bloco Utilizador.",
	15 => "A sua conta em {$_CONF["site_name"]} foi criada com sucesso. Para poder utilizar todas as potêncialidades deve efectuar o login com a informação que lhe foi enviada. Guarde esta email para referência futura.",
	16 => "Informação da sua conta",
	17 => "A conta não existe",
	18 => "O endereço de email introduzido não é válido",
	19 => "O nome de utilizador ou email introduzido já existe",
	20 => "O endereço de email introduzido não é válido",
	21 => "Erro",
	22 => "Registe-se em {$_CONF['site_name']}!",
	23 => "Registar-se dá-lhe todos os benefícios de ser um membro da comunidade {$_CONF['site_name']} e permite-lhe fazer comentários e enviar informação com a identificação da sua autoria. Se não tiver uma conta, apenas poderá enviar informação anónima. Note que o seu endereço de email <b><i>nunca</i></b> será publicado neste site.",
	24 => "A sua password será enviada para o endereço que indicar.",
	25 => "Esqueceu-se da sua password?",
	26 => "Introduza o seu nome de utilizador e clique em Email Password. Será enviada uma nova password para o email com que se registou.",
	27 => "Registe-se agora!",
	28 => "Email Password",
	29 => "saiu a partir de",
	30 => "entrou a partir de",
	31 => "A função pretendida obriga a efectuar o login",
	32 => "Assinatura",
	33 => "Não é mostrado publicamente",
	34 => "Este é o seu nome real",
	35 => "Introduza a password para alterar",
	36 => "Inicie com http://",
	37 => "Aplicado aos seus comentários",
	38 => "Isto é tudo acerca de si! Todos podem ler isto",
	39 => "A sua chave PGP pública para partilhar",
	40 => "Sem icones de tópico",
	41 => "Pretende ser moderador",
	42 => "Formato da data",
	43 => "Máximo de notícias",
	44 => "Sem caixas",
	45 => "Mostrar preferências para",
	46 => "Itens excluidos para",
	47 => "Configuração da caixa de novidades para",
	48 => "Tópicos",
	49 => "Sem icones nas notícias",
	50 => "Desmarque se não está interessado",
	51 => "Apenas notícias novas",
	52 => "Por defeito é",
	53 => "Receber as notícias do dia",
	54 => "Marque as caixas para os tópicos e autores que não pretende ver.",
	55 => "Se deixar tudo desmarcado, significa que pretende a selecção feita por defeito. Se seleccionar alguma das caixas, não se esqueça de seleccionar todas as que pretende pois a selecção feita por defeito é anulada. A selecção feita por defeito está a Negrito.",
	56 => "Autores",
	57 => "Modo de visualização",
	58 => "Ordenação",
	59 => "Limite de comentários",
	60 => "Como quer que os seus comentários sejam mostrados?",
	61 => "Novas ou antigas primeiro?",
	62 => "Por defeito é 100",
	63 => "A sua password foi enviada por email e deve chegar em breve. Siga as indicações presentes no email e obrigado por utilizar o site " . $_CONF["site_name"],
	64 => "Preferências de comentários de",
	65 => "Tente efectuar o login novamente",
	66 => "É provavel que se tenha enganado nos seus dados de login.  Tente fazer o login novamente. É um <a href=\"{$_CONF['site_url']}/users.php?mode=new\">novo utilizador</a>?",
	67 => "Membro desde",
	68 => "Lembrar durante",
	69 => "Durante quanto tempo quer ser lembrado depois de efectuar o login?",
	70 => "Personalize a aparência e contéudo do site {$_CONF['site_name']}",
	71 => "Uma das opções do site {$_CONF['site_name']} é que pode personalizar o contéudo que quer ver e a aparência do site.  Para poder usar esta opção deve-se <a href=\"{$_CONF['site_url']}/users.php?mode=new\">registar</a> em {$_CONF['site_name']}.  Já é um membro registado?  Então utilize o formulário de login do lado esquerdo!",
    72 => "Tema",
    73 => "Idioma",
    74 => "Mude a aparência deste site!",
    75 => "Tópicos enviadoas para",
    76 => "Se seleccionar um tópico da lista receberá todas as notícias colocadas nesse tópico durante o dia.  Seleccione apenas os tópicos do seu interesse!",
    77 => "Foto",
    78 => "Adicione a sua fotografia!",
    79 => "Marque aqui para apagar esta imagem",
    80 => "Login",
    81 => "Enviar Email",
    82 => 'Últimas 10 notícias do utilizador',
    83 => 'Estatística de artigos do utilizador',
    84 => 'Número total de artigos:',
    85 => 'Número total de comentários:',
    86 => 'Encontrar todos os artigos de'
);

###############################################################################
# index.php

$LANG05 = array(
	1 => "Nenhuma notícia para mostrar",
	2 => "Não há notícias novas para mostrar.  Pode não haver notícias para este tópico ou as suas definições são demasiado restrictivas",
	3 => " para o tópico $topic",
	4 => "Artigos do dia",
	5 => "Próxima",
	6 => "Anterior"
);

###############################################################################
# links.php

$LANG06 = array(
	1 => "Páginas disponíveis",
	2 => "Não há páginas para mostrar.",
	3 => "Adicionar uma ligação"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
	1 => "Voto Registado",
	2 => "O seu voto foi registado",
	3 => "Voto",
	4 => "Votações no sistema",
	5 => "Votos"
);

###############################################################################
# profiles.php

$LANG08 = array(
	1 => "Houve um erro ao enviar a sua mensagem. Tente novamente.",
	2 => "Mensagem enviada com sucesso.",
	3 => "Certifique-se que utiliza um endereço de email válido no campo Responder para.",
	4 => "Preencha os campos Nome, Responder Para, Assunto e Mensagem",
	5 => "Erro: Nenhum utilizador.",
	6 => "Existe um erro.",
	7 => "Perfil de utilizador para",
	8 => "Nome",
	9 => "URL do utilizador",
	10 => "Enviar email para",
	11 => "Nome:",
	12 => "Responder para:",
	13 => "Assunto:",
	14 => "Mensagem:",
	15 => "HTML não será traduzido.",
	16 => "Enviar mensagem",
	17 => "Enviar Notícia a um amigo",
	18 => "Para",
	19 => "Email",
	20 => "De",
	21 => "Email",
	22 => "São necessários todos os campos",
	23 => "Este email foi-lhe enviado por $from em $fromemail porque ele(a) acredita que possa estar interessado(a) neste artigo do site {$_CONF["site_url"]}.  Isto não é SPAM e os endereços de email envolvidos nesta operação não ficam registados para uso posterior.",
	24 => "Comentários a esta notícia em",
	25 => "Deve efectuar o login para poder utilizar esta opção.  Efectuando o login, ajuda-nos a prevenir a utilização fraudulenta do sistema",
	26 => "Este formulário permite-lhe enviar um email para o utilizador seleccionado.  É necessário o preenchimento de todos os campos.",
	27 => "Mensagem curta",
	28 => "$from escreveu: $shortmsg",
    29 => "Este é o envio diário automático de {$_CONF['site_name']} para ",
    30 => " Novidades diárias para ",
    31 => "Titulo",
    32 => "Data",
    33 => "Leia o artigo completo em",
    34 => "Fim da mensagem"
);

###############################################################################
# search.php

$LANG09 = array(
	1 => "Pesquisa avançada",
	2 => "Palavras a pesquisar",
	3 => "Tópico",
	4 => "Tudo",
	5 => "Tipo",
	6 => "Notícias",
	7 => "Comentários",
	8 => "Autores",
	9 => "Tudo",
	10 => "Pesquisar",
	11 => "Resultados da pesquisa",
	12 => "resultados",
	13 => "Nenhuma correspondência com o critério",
	14 => "Não foram encontrados registos na sua pesquisa de",
	15 => "Tente de novo.",
	16 => "Título",
	17 => "Data",
	18 => "Autor",
	19 => "Pesquise na base de dados {$_CONF["site_name"]} em todas as notícias",
	20 => "Data",
	21 => "até",
	22 => "(Formato AAAA-MM-DD)",
	23 => "Visitas",
	24 => "Encontrados",
	25 => "resultados para",
	26 => "itens em",
	27 => "segundos",
    28 => 'Nenhuma notícia ou comentário corresponde ao seu critério',
    29 => 'Resultado de Notícias e Comentários',
    30 => 'Nenhuma ligação corresponde a sua pesquisa',
    31 => 'Este plug-in não devolveu resultados',
    32 => 'Evento',
    33 => 'URL',
    34 => 'Localização',
    35 => 'Todo o dia',
    36 => 'Nenhum evento corresponde ao critério',
    37 => 'Resultado de eventos',
    38 => 'Resultado de ligações',
    39 => 'Ligações',
    40 => 'Eventos',
    41 => 'A frase a pesquisar deve ter no mínimo 3 caracteres.',
    42 => 'Utilize uma data com o seguinte formato AAAA-MM-DD (ano-mês-dia).'
);

###############################################################################
# stats.php

$LANG10 = array(
	1 => "Estatísticas do site",
	2 => "Número total de Ligações ao sitema",
	3 => "Notícias(Comentários) no sistema",
	4 => "Votações(Respostas) no sistema",
	5 => "Links(Clicks) no sistema",
	6 => "Evento no sistema",
	7 => "Top Ten de notícias visitadas",
	8 => "Título da notícia",
	9 => "Visitas",
	10 => "Parece que não há nenhuma notícia no site ou nenhuma delas foi ainda visitada.",
	11 => "Top Ten de notícias comentadas",
	12 => "Comentários",
	13 => "Parece que não há nenhuma notícia no site ou ainda não foi feito nenhum comentário.",
	14 => "Top Ten de votações",
	15 => "Pergunta da votação",
	16 => "Votos",
	17 => "Parece que não há nenhuma votação no site ou ainda ninguém votou em nenhuma.",
	18 => "Top Ten Links",
	19 => "Links",
	20 => "Visitas",
	21 => "Parece que não existem links no site ou ainda nenhum deles foi visitado.",
	22 => "Top Ten Notícias enviadas",
	23 => "Emails",
	24 => "Parece que ainda não foi enviada nenhuma notícia deste site"
);

###############################################################################
# article.php

$LANG11 = array(
	1 => "Artigos relaccionados",
	2 => "Enviar notícia a um amigo",
	3 => "Versão para impressão",
	4 => "Opções da notícia"
);

###############################################################################
# submit.php

$LANG12 = array(
	1 => "Para enviar um $type deve efectuar o login como utilizador.",
	2 => "Login",
	3 => "Novo utilizador",
	4 => "Enviar um evento",
	5 => "Enviar um link",
	6 => "Enviar uma notícia",
	7 => "É necessário Login",
	8 => "Enviar",
	9 => "Ao enviar informações para utilização neste site pedimos-lhe que cumpra as seguintes recomendações...<ul><li>Preencha todos os campos, eles são necessários<li>Forneça informação correta e completa<li>Verifique os URLs</ul>",
	10 => "Titulo",
	11 => "Ligação",
	12 => "Data de início",
	13 => "Data de fim",
	14 => "Localização",
	15 => "Descrição",
	16 => "Se outra, especifique",
	17 => "Categoria",
	18 => "Outra",
	19 => "Ler primeiro",
	20 => "Erro: Falta a categoria",
	21 => "Ao seleccionar \"Outra\" indique o nome da categoria",
	22 => "Erro: Faltam campos",
	23 => "Preencha todos os campos do formulário.  Todos eles são necessários.",
	24 => "Envio registado",
	25 => "O seu envio $type foi registado com sucesso.",
	26 => "Limite de velocidade",
	27 => "Utilizador",
	28 => "Tópico",
	29 => "Notícia",
	30 => "O seu último envio foi à ",
	31 => " segundos.  Este site obriga a pelo menos {$_CONF["speedlimit"]} segundos entre envios",
	32 => "Previsualizar",
	33 => "Previsualização da notícia",
	34 => "Sair",
	35 => "Tags HTML não são permitidas",
	36 => "Modo de colocação",
	37 => "Enviar um evento para {$_CONF["site_name"]} colocará este este evento no calendário geral onde os utilizadores poderam adicioná-lo ao seu calendário pessoal. Esta opção <b>NÃO</b> foi pensada para armazenar os seus eventos pessoais tipo aniversários e datas comemorativas.<br><br>Quando publica o seu evento este é enviado aos administradores e se aprovado, o seu evento aparecerá no calendário geral.",
    38 => "Adicionar evento para",
    39 => "Calendário geral",
    40 => "Calendário pessoal",
    41 => "Fim",
    42 => "Início",
    43 => "Todo o dia",
    44 => 'Morada',
    45 => '',
    46 => 'Localidade',
    47 => 'Cidade',
    48 => 'C. Postal',
    49 => 'Tipo',
    50 => 'Editar Tipos de Evento',
    51 => 'Localização',
    52 => 'Apagar',
    53 => 'Criar conta'
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
	1 => "Autenticação necessária",
	2 => "Não autorizado! Informação de Login incorrecta",
	3 => "Password inválida para o utilizador",
	4 => "Utilizador:",
	5 => "Password:",
	6 => "Todos os acessos administrativos deste site são registados e auditados.<br>Está página é apenas para utilização de pessoal autorizado.",
	7 => "login"
);

###############################################################################
# block.php

$LANG21 = array(
	1 => "Direitos de administração insuficientes",
	2 => "Não tem permissões suficientes para editar este bloco.",
	3 => "Editor de blocos",
	4 => "",
	5 => "Título",
	6 => "Tópico",
	7 => "Todos",
	8 => "Nível de segurança",
	9 => "Ordem",
	10 => "Tipo",
	11 => "Bloco de portal",
	12 => "Bloco normal",
	13 => "Opções de bloco de portal",
	14 => "RDF URL",
	15 => "Última actualização RDF",
	16 => "Opções para Blocos Normais",
	17 => "Contéudo dos blocos",
	18 => "Preencha os campos Título, Nível de segurança e Contéudo",
	19 => "Manutenção de blocos",
	20 => "Título",
	21 => "Nível de segurança",
	22 => "Tipo",
	23 => "Ordem",
	24 => "Tópico",
	25 => "Para modificar ou apagar um bloco, clique nesse bloco.  Para criar um bloco novo clique em Novo Bloco.",
	26 => "Aparência do bloco",
	27 => "Bloco de PHP",
    28 => "Opções de bloco PHP",
    29 => "Função",
    30 => "Se pretende que um dos seus blocos utilize código PHP, introduza o nome da função a utilizar. O nome da função deve ter o prefixo \"phpblock_\" (ex. phpblock_getweather). Se não tiver este prefixo, a sua função não será executada. Isto serve para que alguém que tenha conseguido acesso não autorizado ao seu site possa colocar código malicioso no seu sistema. Certifique-se que não coloca parentesis vazios \"()\" depois do nome da sua função.  Finalmente, é recomendado que coloque todo o seu código PHP em /camino/para/geeklog/system/lib-custom.php.  Isto permite-lhe que o seu código permaneça mesmo ao efectuar um upgrade à sua versão do Geeklog.",
    31 => 'Erro no bloco PHP.  A função $function não existe.',
    32 => "Erro: Faltam campos",
    33 => "Deve introduzir o URL para o ficheiro .rdf para os blocos de portal",
    34 => "Deve introduzir o título e a função para os blocos PHP",
    35 => "Deve introduzir o título e o contéudo para os blocos normais",
    36 => "Deve introduzir o contéudo para os blocos de layout",
    37 => "Nome de função PHP incorrecta",
    38 => "Funções para os blocos PHP devem conter o prefixo 'phpblock_' (ex. phpblock_getweather).  O prefixo 'phpblock_' é necessário por razões de segurança.",
	39 => "Lado",
	40 => "Esquerdo",
	41 => "Direito",
	42 => "Deve introduzir a ordem do bloco e o nível de segurança para os blocos por defeito do Geeklog",
	43 => "Apenas página principal",
	44 => "Acesso não permitido",
	45 => "Está a tentar aceder a um bloco para o qual não tem permissões. Este procedimento foi registado. Volte à <a href=\"{$_CONF["site_admin_url"]}/block.php\">janela de administração</a>.",
	46 => 'Novo Bloco',
	47 => 'Administração',
    48 => 'Nome',
    49 => ' (sem espaços e deve ser único)',
    50 => 'URL de ficheiro de ajuda',
    51 => 'inclua http://',
    52 => 'Se deixar em branco não aparecerá icon de ajuda para este bloco',
    53 => 'Autorizado',
    54 => 'guardar',
    55 => 'cancelar',
    56 => 'apagar'
);

###############################################################################
# event.php

$LANG22 = array(
	1 => "Editor de eventos",
	2 => "",
	3 => "Título",
	4 => "URL",
	5 => "Data de início",
	6 => "Data de fim",
	7 => "Localização",
	8 => "Descrição",
	9 => "(inclua http://)",
	10 => "Deve inserir datas, horas, descrição e localização para o evento!",
	11 => "Manutenção de eventos",
	12 => "Para modificar ou apagar um evento, clique nesse evento a seguir.  Para criar um novo evento clique em Novo evento.",
	13 => "Título",
	14 => "Data de início",
	15 => "Data de fim",
	16 => "Acesso não permitido",
	17 => "Está a tentar aceder a um evento para o qual não tem permissões.  Esta acção ficou registada. Por favor <a href=\"{$_CONF["site_admin_url"]}/event.php\">volte ao écran de administração de eventos</a>.",
	18 => 'Novo evento',
	19 => 'Administração',
    20 => 'guardar',
    21 => 'cancelar',
    22 => 'apagar'
);

###############################################################################
# link.php

$LANG23 = array(
	1 => "Editor de ligações",
	2 => "",
	3 => "Título",
	4 => "URL",
	5 => "Categoria",
	6 => "(inclua http://)",
	7 => "Outra",
	8 => "Visitas",
	9 => "Descrição",
	10 => "Deve introduzir um título, o URL e a descrição.",
	11 => "Manutenção de ligações",
	12 => "Para modificar ou apagar uma ligação, clique na ligação a seguir.  Para inserir uma nova ligação clique em Nova Ligação.",
	13 => "Título",
	14 => "Categoria",
	15 => "URL",
	16 => "Acesso não permitido",
	17 => "Esta a tentar aceder a uma ligação para a qual não tem permissões.  Esta acção ficou registada. Por favor <a href=\"{$_CONF["site_admin_url"]}/link.php\">volte ao écran de administração de ligações</a>.",
	18 => 'Nova Ligação',
	19 => 'Administração',
	20 => 'Se outra, especifique',
    21 => 'guardar',
    22 => 'cancelar',
    23 => 'apagar'
);

###############################################################################
# story.php

$LANG24 = array(
	1 => "Notícia anterior",
	2 => "Notícia seguinte",
	3 => "Modo",
	4 => "Modo de envio",
	5 => "Editor de notícias",
	6 => "Não há notícias no sistema",
	7 => "Autor",
	8 => "guardar",
	9 => "previsualizar",
	10 => "cancelar",
	11 => "apagar",
	12 => "",
	13 => "Título",
	14 => "Tópico",
	15 => "Data",
	16 => "Introdução",
	17 => "Corpo",
	18 => "Visitas",
	19 => "Comentários",
	20 => "",
	21 => "",
	22 => "Lista de notícias",
	23 => "Para modificar ou apagar uma notícia, clique no número da notícia a seguir. Para ver uma notícia, clique no título da notícia que pretende ver. Para introduzir uma notícia clique em Inserir notícia a seguir.",
	24 => "",
	25 => "",
	26 => "Previsualização de notícias",
	27 => "",
	28 => "",
	29 => "",
	30 => "",
	31 => "Por favor preencha os campos Autor, Título e Introdução",
	32 => "Featured",
	33 => "Só pode haver uma notícia featured",
	34 => "Rascunho",
	35 => "Sim",
	36 => "Não",
	37 => "Mais de",
	38 => "Mais a partir de",
	39 => "Emails",
	40 => "Acesso não autorizado",
	41 => "Está a tentar aceder a uma notícia para a qual não tem permissões.  Esta acção ficou registada.  Pode ver esta notícia com permissões de leitura a seguir. Por favor <a href=\"{$_CONF["site_admin_url"]}/story.php\">volte ao écran de administração de notícias</a> quando terminar.",
	42 => "Está a tentar aceder a uma notícia para a qual não tem permissões.  Esta acção ficou registada.  Por favor <a href=\"{$_CONF["site_admin_url"]}/story.php\">volte ao écran de administração de notícias</a>.",
	43 => 'Inserir notícia',
	44 => 'Administração',
	45 => 'Acesso',
    46 => '<b>NOTA:</b> se modificar esta data para uma data futura, esta notícia não será publicada antes dessa data.  Isto significa também que a sua notícia não aparecerá nos cabeçalhos e será ignorada pelas pesquisas e páginas de estatísticas.',
    47 => 'Imagens',
    48 => 'imagem',
    49 => 'direita',
    50 => 'esquerda',
    51 => 'Para adicionar uma das imagens que está a anexar a esta notícia precisa de introduzir texto com formato especial.  O formato especial do texto é [imagemX], [imagemX_direita] ou [imagemX_esquerda] onde X é o número da imagem que anexou.  NOTA: Deve utilizar as imagens que anexou.  Caso contrário não poderá guardar a sua notícia.<BR><P><B>PREVISUALIZAR</B>: Previsualizar uma notícia que contenha imagens deve ser efectuado guardando a notícia como rascunho EM VEZ DE seleccionar o botão de previsualização.  Utilize o botão de previsualização apenas quando não tiver imagens anexadas.',
    52 => 'Apagar',
    53 => 'não foi utilizada.  Deve incluir esta imagem na introdução ou no corpo da notícia antes de guardar as alterações',
    54 => 'Imagens associadas e não utilizadas',
    55 => 'Ocorreram os seguintes erros ao tentar guardar a sua notícia.  Por favor, corrija estes erros antes de guardar',
    56 => 'Mostrar imagem de tópico'
);

###############################################################################
# poll.php

$LANG25 = array(
	1 => "Modo",
	2 => "",
	3 => "Data de criação",
	4 => "Votação $qid guardada",
	5 => "Editar votação",
	6 => "ID da votação",
	7 => "(não utilize espaços)",
	8 => "Aparece na página inicial",
	9 => "Pergunta",
	10 => "Respostas / Votos",
	11 => "Foi encontrado um erro ao carregar uma resposta da votação $qid",
	12 => "Foi encontrado um erro ao carregar a questão da votação $qid",
	13 => "Criar Votação",
	14 => "guardar",
	15 => "cancelar",
	16 => "apagar",
	17 => "",
	18 => "Lista de votações",
	19 => "Para modificar ou apagar uma votação, clique na mesma.  Para criar uma votação nova clique em Criar votação.",
	20 => "Votantes",
	21 => "Acesso interdito",
	22 => "Está atentar aceder a uma votação à qual não tem acesso.  Este evento foi registado. Por favor <a href=\"{$_CONF["site_admin_url"]}/poll.php\">volte ao écran de administração de votações</a>.",
	23 => 'Nova votação',
	24 => 'Administração',
	25 => 'Sim',
	26 => 'Não'
);

###############################################################################
# topic.php

$LANG27 = array(
	1 => "Editor de tópicos",
	2 => "ID do tópico",
	3 => "Nome",
	4 => "Imagem",
	5 => "(não utilize espaços)",
	6 => "Apagar um tópico remove também todas as notícias e blocos associados a ele.",
	7 => "Preencha os campos ID de tópico e Nome",
	8 => "Manutenção de tópicos",
	9 => "Para modificar ou apagar um tópico, clique nesse tópico.  Para criar um novo tópico clique no botão Novo tópico à esquerda. Encontra o seu nível de acesso para cada tópico dentro de parêntesis",
	10=> "Ordem",
	11 => "Notícias/Página",
	12 => "Acesso interdito",
	13 => "Está a tentar aceder a um tópico para o qual não tem permissão.  Esta tentativa foi registado. Por favor <a href=\"{$_CONF["site_admin_url"]}/topic.php\">volte ao écran de administração de tópicos</a>.",
	14 => "Método de ordenação",
	15 => "alfabética",
	16 => "normal é",
	17 => "Novo Tópico",
	18 => "Administração",
    19 => 'guardar',
    20 => 'cancelar',
    21 => 'apagar'
);

###############################################################################
# user.php

$LANG28 = array(
	1 => "Detalhes do utilizador",
	2 => "ID do utilizador",
	3 => "Nome do utilizador",
	4 => "Nome completo",
	5 => "password",
	6 => "Nível de segurança",
	7 => "Email",
	8 => "Página WEB",
	9 => "(não utilize espaços)",
	10 => "Por favor preencha o Nome do utilizador, Nome completo, Nível de segurança e endereço de Email",
	11 => "Manutenção de utilizadores",
	12 => "Para modificar ou apagar um utilizador, clique nesse utilizador abaixo. Para criar um novo utilizador clique no botão Novo utilizador à esquerda. Pode efectuar pesquisas simples introduzindo partes do nome de utilizador, endereço de email ou do nome completo (ex.*Manuel* ou *.pt) no formulário abaixo.",
	13 => "Nível de segurança",
	14 => "Data de registo",
	15 => 'Novo utilizador',
	16 => 'Administração',
	17 => 'mudar password',
	18 => 'cancelar',
	19 => 'apagar',
	20 => 'guardar',
	18 => 'cancelar',
	19 => 'apagar',
	20 => 'guardar',
    21 => 'O nome de utilizador que tentou guardar já existe.',
    22 => 'Erro',
    23 => 'Adicionar automático',
    24 => 'Importação automática de utilizadores',
    25 => 'Pode importar um ficheiro de utilizadores para o site. O ficheiro de importação deve ser delimitado por tabulações e deve conter os campos na seguinte ordem: nome completo, nome de utilizador, endereço de email. Cada utilizador importado receberá uma password por email. Deve ter um utilizador em cada linha. Uma falha num destes pontos causará problemas que terão de ser resolvidos manualmente para resolver duplicação de registos!',
    26 => 'Procurar',
    27 => 'Limite de Resultados',
    28 => 'Seleccione aqui para apagar esta imagem',
    29 => 'Caminho',
    30 => 'Importar',
    31 => 'Novos Utilizadores',
    32 => 'Processo concluído. Foram importados $successes e encontrados $failures erros',
    33 => 'enviar',
    34 => 'Erro: Deve especificar um ficheiro para carregar.'
);


###############################################################################
# moderation.php

$LANG29 = array(
    1 => "Aprovar",
    2 => "Apagar",
    3 => "Editar",
    4 => 'Perfil',
    10 => "Título",
    11 => "Data de início",
    12 => "URL",
    13 => "Categoria",
    14 => "Data",
    15 => "Tópico",
    16 => 'Nome de utilizador',
    17 => 'Nome completo',
    18 => 'Email',
    34 => "Comando e Control",
    35 => "Noticia para aprovação",
    36 => "Ligações para aprovação",
    37 => "Eventos para aprovação",
    38 => "Submeter",
    39 => "Não à envios para moderação neste momento",
    40 => "Envios do utilizador"
);

###############################################################################
# calendar.php

$LANG30 = array(
	1 => "Domingo",
	2 => "Segunda",
	3 => "Terça",
	4 => "Quarta",
	5 => "Quinta",
	6 => "Sexta",
	7 => "Sábado",
	8 => "Adicionar Evento",
	9 => "Evento Geral",
	10 => "Eventos para",
	11 => "Calendário Geral",
	12 => "O Meu Calendário",
	13 => "Janeiro",
	14 => "Fevereiro",
	15 => "Março",
	16 => "Abril",
	17 => "Maio",
	18 => "Junho",
	19 => "Julho",
	20 => "Agosto",
	21 => "Setembro",
	22 => "Outubro",
	23 => "Novembro",
	24 => "Dezembro",
	25 => "Voltar a ",
    26 => "Todo o dia",
    27 => "Semana",
    28 => "Calendário pessoal de",
    29 => "Calendário público",
    30 => "apagar evento",
    31 => "Adicionar",
    32 => "Evento",
    33 => "Data",
    34 => "Hora",
    35 => "Adicionar rápido",
    36 => "Enviar",
    37 => "Pedimos desculpa, o calendário pessoal está inactivo neste site",
    38 => "Editor de eventos pessoais",
    39 => 'Dia',
    40 => 'Semana',
    41 => 'Mês'
);

###############################################################################
# admin/mail.php
$LANG31 = array(
 	1 => $_CONF['site_name'] . " Utilitáriod de email",
 	2 => "De",
 	3 => "Responder a",
 	4 => "Assunto",
 	5 => "Mensagem",
 	6 => "Enviar para:",
 	7 => "Todos os utilizadores",
 	8 => "Admin",
	9 => "Opções",
	10 => "HTML",
 	11 => "Urgent message!",
 	12 => "Enviar",
 	13 => "Limpar",
 	14 => "Ignorar preferêncios do utilizador",
 	15 => "Erro ao enviar para: ",
	16 => "Mensagens enviadas com sucesso para: ",
	17 => "<a href=" . $_CONF["site_admin_url"] . "/mail.php>Enviar outra mensagem</a>",
    18 => "Para",
    19 => "NOTA: se pretende enviar uma mensagem para todos os utilizadores do site, seleccione o grupo Logged-in Users na lista.",
    20 => "Enviadas <successcount> mensagens com sucesso e <failcount> sem sucesso.  Se precisar, os detalhes para cada mensagem estão a seguir. Caso contrário pode <a href=\"" . $_CONF['site_admin_url'] . "/mail.php\">Enviar outra mensagem</a> ou voltar à <a href=\"" . $_CONF['site_admin_url'] . "/moderation.php\">pagina de administração</a>.",
    21 => 'Falhas',
    22 => 'Sucessos',
    23 => 'Nenhuma falha',
    24 => 'Nenhum sucesso',
    25 => '-- Selecione o grupo --',
    26 => "Preencha todos os campos no formulário e seleccione um grupo na lista."
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "A sua password foi enviada para o seu email e deve chegar em breve. Siga as indicações presentes na mensagem e obrigado por utilizar o site " . $_CONF["site_name"],
	2 => "Obrigado por enviar a sua notícia para {$_CONF["site_name"]}.  Foi enviado para a nossa equipa para aprovação. Se for aceite, a sua notícia estará disponível para todos os utilizadores do nosso site.",
	3 => "Obrigado por enviar a sua ligação para {$_CONF["site_name"]}.  Foi enviado para a nossa equipa para aprovação.  Se for aceite, o seu link estará disponível na secção <a href={$_CONF["site_url"]}/links.php>links.</a>",
	4 => "Obrigado por enviar o seu evento para {$_CONF["site_name"]}.  Foi enviado para a nossa equipa para aprovação.  Se for aceite, o seu evento estará visível na secção <a href={$_CONF["site_url"]}/calendar.php>calendário.</a>",
	5 => "A informação da sua conta foi guardada com sucesso.",
	6 => "As suas preferências do layout do site foram guardadas com sucesso.",
	7 => "As suas preferências para os comentários foram guardadas com sucesso.",
	8 => "Terminou a sua sessão com sucesso.",
	9 => "A sua notícia foi registada com sucesso.",
	10 => "A sua notícia foi apagada com sucesso.",
	11 => "O seu bloco foi guardado com sucesso.",
	12 => "O bloco foi apagado com sucesso.",
	13 => "O seu tópico foi guardado com sucesso.",
	14 => "O tópico e todas as notícias desse tópico foram apagados com sucesso.",
	15 => "O seu link foi guardado com sucesso.",
	16 => "O link foi apagado com sucesso.",
	17 => "O seu evento foi registado com sucesso.",
	18 => "O evento foi apagado com sucesso.",
	19 => "A sua votação foi guardada com sucesso.",
	20 => "A votação foi apagada com sucesso.",
	21 => "O novo utilizador foi guardado com sucesso.",
	22 => "O utilizador foi apagado com sucesso",
	23 => "Erro ao tentar adicionar um evento ao seu calendário. Não foi indicado o id do evento.",
	24 => "O evento foi adicionado ao seu calendário",
	25 => "Não pode abrir o seu calendário pessoal enquanto não efectuar o login",
	26 => "O evento foi retirado do seu calendário pessoal com sucesso",
	27 => "Mensagem enviada com sucesso.",
	28 => "O plug-in foi guardado com sucesso",
	29 => "Pedimos desculpa, o calendário pessoal não está autorizado neste site",
	30 => "Acesso não permitido",
	31 => "Não tem acesso à manutenção de notícias. Relembramos que todas as tentativas de acesso a funções não autorizadas são registadas",
	32 => "Não tem acesso à manutenção de tópicos. Relembramos que todas as tentativas de acesso a funções não autorizadas são registadas",
	33 => "Não tem acesso à manutenção de blocos. Relembramos que todas as tentativas de acesso a funções não autorizadas são registadas",
	34 => "Não tem acesso à manutenção de links. Relembramos que todas as tentativas de acesso a funções não autorizadas são registadas",
	35 => "Não tem acesso à manutenção de eventos. Relembramos que todas as tentativas de acesso a funções não autorizadas são registadas",
	36 => "Não tem acesso à manutenção de votações. Relembramos que todas as tentativas de acesso a funções não autorizadas são registadas",
	37 => "Não tem acesso à manutenção de utilizadores. Relembramos que todas as tentativas de acesso a funções não autorizadas são registadas",
	38 => "Não tem acesso à manutenção de plugin's. Relembramos que todas as tentativas de acesso a funções não autorizadas são registadas",
	39 => "Não tem acesso à manutenção de email. Relembramos que todas as tentativas de acesso a funções não autorizadas são registadas",
	40 => "Mensagem do sistema",
    41 => "Não tem acesso à manutenção de palavras de substituição. Relembramos que todas as tentativas de acesso a funções não autorizadas são registadas",
    42 => "A palavra foi guardada com sucesso.",
	43 => "A palavra foi apagada com sucesso.",
    44 => 'O plug-in foi instalado com sucesso!',
    45 => 'O plug-in foi apagado com sucesso.',
    46 => "Não tem acesso à manutenção de cópias da base de dados. Relembramos que todas as tentativas de acesso a funções não autorizadas são registadas",
    47 => "Esta funcionalidade apenas trabalha em ambientes *nix.  Se estiver a trabalhar num ambiente *nix a cache foi limpa com sucesso. Se estiver no Windows, procure os ficheiros com o nome adodb_*.php e remova-os manualmente.",
    48 => 'Obrigado por se aplicar como um membro de ' . $_CONF['site_name'] . '. A nossa equipa irá rever a sua aplicação. Se aprovada, a sua password será enviada para o email que nos indicou.',
    49 => "O seu grupo foi guardado com sucesso.",
    50 => "O grupo foi apagado com sucesso."
);

// for plugins.php

$LANG32 = array (
	1 => "A instalação de plugins pode danificar a instalação do Geeklog e, possivelmente, o sistema. É importante que apenas instale plugins descarregados do <a href=\"http://www.geeklog.net\" target=\"_blank\">Site Geeklog</a> dado que nós testamos todos os plugins enviados para o nosso site nos mais variados sistemas operativos. É importante que perceba que a instalação de plugin's requere a execução de comandos do sistema que lhe podem trazer problemas de segurança se esses plugins não vierem de sites fidedignos. Para além deste aviso, nós não garantimos o sucesso da instalação de plugins nem podemos ser responsabilizados pelos danos causados pela instalação de plugin's. Por outras palavras, instale à sua responsabilidade. Por prudencia, recomendações de como instalar um plugin manualmente vem incluidas com cada plugin.",
	2 => "Responsabilidade da Instalação de Plug-in",
	3 => "Formulário de instalação de Plug-in",
	4 => "Ficheiro do Plug-in",
	5 => "Lista de Plug-in's ",
	6 => "Aviso: o Plug-in já está instalado!",
	7 => "O plug-in que está a tentar instalar já existe. Tem de apagar antes de reinstalar",
	8 => "Falhou o teste de compatibilidade do Plugin",
	9 => "Este plugin necessita de uma versão mais recente do Geeklog. Faça a actualização da sua cópia do <a href=\"http://www.geeklog.net\">Geeklog</a> ou procure outra versão do plug-in.",
	10 => "<br><b>Não há plugins instalados.</b><br><br>",
	11 => "Para modificar ou apagar um plug-in, clique no número desse plugin. Para saber maia sobre um plug-in, clique no nome do plug-in e será redireccionado para o site desse plugin. Para instalar ou actualizar um plug-in consulte a sua documentação.",
	12 => 'nenhum nome de plugin enviado à função plugineditor()',
	13 => 'Editor de Plug-in',
	14 => 'Novo Plug-in',
	15 => 'Administração',
	16 => 'Nome do Plug-in',
	17 => 'Versão do Plug-in',
	18 => 'Versão do Geeklog',
	19 => 'Activo',
	20 => 'Sim',
	21 => 'Não',
	22 => 'Instalar',
    23 => 'Guardar',
    24 => 'Cancelar',
    25 => 'Apagar',
    26 => 'Nome',
    27 => 'Página Web',
    28 => 'Versão do Plug-in',
    29 => 'Versão do GL',
    30 => 'Apagar o Plug-in?',
    31 => 'Tem a certeza que pretende apagar este plug-in?  Ao efectuar isto remove todos os dados e estructuras que este plug-in utiliza. Se tem a certeza, clique em apagar novamente.'
);

$LANG_ACCESS = array(
	access => "Acesso",
    ownerroot => "Editor/Root",
    group => "Grupo",
    readonly => "Só leitura",
	accessrights => "Direitos de acesso",
	owner => "Autor",
	grantgrouplabel => "Dar permissão de edição a todos os Grupos",
	permmsg => "NOTA: membros são todos os utilizadores que efectuaram o login e anónimos são os visitantes da página sem login efectuado.",
	securitygroups => "Grupos de segurança",
	editrootmsg => "Mesmo sendo membro do grupo de Administradores, não pode editar a informação de um utilizador root sem ser primeiro um utilizador root também.  Pode editar todos os utilizadores excepto os do grupo root. Lembramos que todas as tentativas de edição ilegal de utilizadores root são registadas.  Volte à página de <a href=\"{$_CONF["site_admin_url"]}/user.php\">Administração de utilizadores</a>.",
	securitygroupsmsg => "Seleccione as caixas dos grupos aos quais o utilizador irá pertencer.",
	groupeditor => "Editor de grupos",
	description => "Descrição",
	name => "Nome",
 	rights => "Direitos",
	missingfields => "Faltam campos",
	missingfieldsmsg => "Deve introduzir o nome e a descrição do grupo",
	groupmanager => "Manutenção de grupos",
	newgroupmsg => "Para modificar ou apagar um grupo, clique nesse grupo. Para criar um grupo novo clique em Novo grupo. Relembramos que os grupos do núcleo não podem ser apagados porque são utilizados no sistema.",
	groupname => "Nome",
	coregroup => "Grupo do núcleo",
	yes => "Sim",
	no => "Não",
	corerightsdescr => "Este grupo pertence ao núcleo do site {$_CONF["site_name"]}.  Daí que os direitos deste grupo não podem ser editados.  A seguir está a lista dos direitos de acesso dos membros deste grupo.",
	groupmsg => "Os Grupos de Segurança deste site são hierárquicos.  Adicionando este grupo a qualquer um dos grupos a seguir está a dar a este grupo os mesmos direitos desses grupos. Onde seja possível aconselhamos a utilizar os grupos listados a seguir para dar permissões ao grupo. Se necessita que este grupo tenha direitos personalizados seleccione os direitos de acesso às mais variadas funcionalidades deste site seleccionando 'Direitos'.  Para adicionar este grupo a qualquer um dos seguintes seleccione a caixa correspondente.",
	coregroupmsg => "Este grupo pertence ao núcleo do site {$_CONF["site_name"]}.  Daí que os direitos deste grupo não podem ser editados.  A seguir está a lista dos direitos de acesso dos membros deste grupo.",
	rightsdescr => "O acesso de um grupo a um determinado direito pode ser dado directamente ao grupo OU a um grupo diferente que contenha esses direitos. Os que vê a seguir sem caixa de selecção são os direitos dados a este grupo porque este pertence a um grupo que tem essas permissões. Os direitos com caixas de selecção são direitos que podem ser dados directamente a este grupo.",
	lock => "Bloquear",
	members => "Membros",
	anonymous => "Anónimos",
	permissions => "Permissões",
	permissionskey => "L = leitura, E = edição, direitos de edição assumem direitos de leitura",
	edit => "Editar",
	none => "N/A",
	accessdenied => "Acesso não autorizado",
	storydenialmsg => "Não tem permissão para ver esta notícia.  Isto pode acontecer porque você não é membro do site {$_CONF["site_name"]}.  <a href=users.php?mode=new> Torne-se membro</a> do site {$_CONF["site_name"]} para ter acesso como utilizador registado!",
	eventdenialmsg => "Não tem permissão para ver este evento.  Isto pode acontecer porque você não é membro do site {$_CONF["site_name"]}.  <a href=users.php?mode=new> Torne-se membro</a> do site {$_CONF["site_name"]} para ter acesso como utilizador registado!",
	nogroupsforcoregroup => "Este grupo não pertence a qualquer um dos outros grupos",
	grouphasnorights => "Este grupo não tem qualquer acesso administrativo neste site",
	newgroup => 'Novo grupo',
	adminhome => 'Administração',
	save => 'guardar',
	cancel => 'cancelar',
	delete => 'apagar',
	canteditroot => 'Tentou editar o grupo Root mas como não está incluído nesse grupo não lhe é permitido o acesso. Contacte o administrador do sistema se acha que isto se deve a um erro'	
);

#admin/word.php
$LANG_WORDS = array(
    editor => "Editor de palavras de substituição",
    wordid => "ID da palavra",
    intro => "Para modificar ou apagar uma palavra, clique nessa palavra.  Para criar uma palavra nova de substituição clique no botão Nova palavra.",
    wordmanager => "Manutenção de palavras",
    word => "Palavra",
    replacmentword => "Palavra de substituição",
    newword => "Nova palavra"
);

$LANG_DB_BACKUP = array(
    last_ten_backups => 'Últimas 10 cópias de segurança',
    do_backup => 'Fazer cópia',
    backup_successful => 'Cópia efectuada com sucesso.',
    no_backups => 'Nenhuma cópia de segurança efectuada até ao momento',
    db_explanation => 'Para criar uma cópia de segurança prima o botão a seguir',
    not_found => "Caminho incorrecto ou o utilitário mysqldump não é executável.<br>Verifique a definição de <strong>\$_DB_mysqldump_path</strong> em config.php.<br>Variavel actualmente definida como: <var>{$_DB_mysqldump_path}</var>",
    zero_size => 'Erro na cópia: O tamanho do ficheiro é 0 bytes',
    path_not_found => "{$_CONF['backup_path']} não existe ou não é uma directoria",
    no_access => "ERRO: A directoria {$_CONF['backup_path']} não está acessível.",
    backup_file => 'Ficheiro da cópia',
    size => 'Tamanho',
    bytes => 'Bytes'
);

$LANG_BUTTONS = array(
    1 => "Início",
    2 => "Contacto",
    3 => "Publicar",
    4 => "Ligações",
    5 => "Votações",
    6 => "Calendário",
    7 => "Estatísticas",
    8 => "Personalizar",
    9 => "Pesquisar",
    10 => "pesquisa avançada"
);

$LANG_404 = array(
    1 => "Erro 404",
    2 => "Procurei em todo o lado mas não encontrei <b>%s</b>.",
    3 => "<p>Pedimos desculpa, mas o ficheiro que pediu não existe. Sinta-se à vontade e verifique na <a href=\"{$_CONF['site_url']}\">página principal</a> ou na <a href=\"{$_CONF['site_url']}/search.php\">página de pesquisa</a> para tentar encontrar o que perdeu."
);

$LANG_LOGIN = array (
    1 => 'Login necessário',
    2 => 'Queira desculpar, para aceder a esta área necessita de efectuar o login como utilizador.',
    3 => 'Login',
    4 => 'Novo utilizador'
);

?>

<?php

###############################################################################
# french_canada.php
# This is a french language version for GeekLog!
#
#
# Copyright (C) 2003 Jean-Francois Allard
# jfallard@jfallard.com
#
# Original translation work by Florent Guiliani
# flyer@perinfo.com
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
	1 => 'Contribution de:',
	2 => 'suppl&eacute;ment d\'info',
	3 => 'commentaires',
	4 => 'Modifier',
	5 => 'Voter',
	6 => 'R&eacute;sultats',
	7 => 'R&eacute;sultats du sondage',
	8 => 'votes',
	9 => 'Fonctions Admin:',
	10 => 'Propositions',
	11 => 'Articles',
	12 => 'Blocs',
	13 => 'Sujets',
	14 => 'Liens',
	15 => 'Activit&eacute;s',
	16 => 'Sondages',
	17 => 'Membres',
	18 => 'Requête SQL',
	19 => 'Se d&eacute;connecter',
	20 => 'Infos personnelles:',
	21 => 'Nom d\'utilisateur',
	22 => 'Num&eacute;ro d\'utilisateur:',
	23 => 'Niveau de s&eacute;curit&eacute;',
	24 => 'Anonyme',
	25 => 'R&eacute;pondre',
	26 => 'Ce site n\'est pas responsable du contenu des commentaires. Ceux-ci sont de la responsabilit&eacute; des auteurs',
	27 => 'Commentaire le plus r&eacute;cent',
	28 => 'Effacer',
	29 => 'Aucuns commentaires.',
	30 => 'Vieux articles',
	31 => 'Balises HTML autoris&eacute;es:',
	32 => 'Erreur: Nom d\'utilisateur erron&eacute;',
	33 => 'Erreur: Impossibilit&eacute; d\'enregistrer la r&eacute;f&eacute;rence',
	34 => 'Erreur',
	35 => 'Se d&eacute;connecter',
	36 => 'sur',
	37 => 'Aucun article d\'utilisateur',
	38 => '(CNT 38)',
	39 => 'Rafra&icirc;chir',
	40 => '(CNT 40)',
	41 => 'Visiteur(s)',
	42 => 'Cr&eacute;&eacute; par:',
	43 => 'Pour y r&eacute;pondre',
	44 => 'Parent',
	45 => 'Num&eacute;ro d\'erreur MySQL',
	46 => 'Message d\'erreur MySQL',
	47 => 'Espace Membres',
	48 => 'Informations personnelles',
	49 => 'Pr&eacute;f&eacute;rences d\'affichage',
	50 => 'Erreur dans la requête SQL',
	51 => 'aide',
	52 => 'Nouveau',
	53 => 'Centre administratif',
	54 => 'Fichier impossible &agrave; ouvrir.',
	55 => 'Erreur &agrave;',
	56 => 'Voter',
	57 => 'Mot de passe',
	58 => 'Connexion',
	59 => "Pas encore de compte?  Enregistrez-vous comme <a href=\"{$_CONF['site_url']}/users.php?mode=new\">nouveau membre</a>",
	60 => 'Ajouter un commentaire',
	61 => 'Cr&eacute;er un nouveau compte',
	62 => 'mots',
	63 => 'Commentaires pr&eacute;f&eacute;r&eacute;s',
	64 => 'Envoyer cet article &agrave; un ami',
	65 => 'Version imprimable',
	66 => 'Mon calendrier',
	67 => 'Bienvenue chez ',
	68 => 'entr&eacute;e',
	69 => 'contact',
	70 => 'chercher',
	71 => 'contribuer',
	72 => 'ressources internet',
	73 => 'sondages pr&eacute;c&eacute;dents',
	74 => 'calendrier',
	75 => 'recherche avanc&eacute;e',
	76 => 'statistiques du site',
	77 => 'Plugins',
	78 => 'Pour bient&ocirc;t',
	79 => 'Quoi de neuf ?',
	80 => 'derniers articles',
	81 => 'dernier article',
	82 => 'heures',
	83 => 'COMMENTAIRES',
	84 => 'LIENS',
	85 => 'derni&egrave;res 48 heures',
	86 => 'Pas de nouveau commentaires',
	87 => '2 derni&egrave;res semaines',
	88 => 'Pas de liens r&eacute;cents',
	89 => 'Il n\'y a pas d\'&eacute;v&egrave;nement &agrave; venir',
	90 => 'Entr&eacute;e',
	91 => 'Page g&eacute;n&eacute;r&eacute;e en',
	92 => 'secondes',
	93 => 'Tout droits r&eacute;serv&eacute;s',
	94 => 'Toutes les marques cit&eacute;es apartiennent &agrave; leurs propri&eacute;taires respectifs.',
	95 => 'G&eacute;n&eacute;r&eacute; par',
	96 => 'Groupes',
        97 => 'Liste de mots',
	98 => 'Plug-ins',
	99 => 'ARTICLES',
    100 => 'Pas de nouveaux articles',
    101 => 'Vos activit&eacute;s',
    102 => 'Activit&eacute;s g&eacute;n&eacute;rales',
    103 => 'Sauvegarde de la BDD',
    104 => 'par',
    105 => 'Courriel aux membres',
    106 => 'Vu',
    107 => 'MAJ de GL',
    108 => 'Vider la cache'
);

###############################################################################
# calendar.php

$LANG02 = array(
	1 => 'Calendrier des activit&eacute;s',
	2 => 'D&eacute;sol&eacute; il n\'y a pas d\'activit&eacute; &agrave; afficher.',
	3 => 'Quand',
	4 => 'O&ugrave;',
	5 => 'Description',
	6 => 'Ajouter une activit&eacute;',
	7 => 'Prochaine activit&eacute;',
	8 => 'En ajoutant cette activit&eacute; au calendrier vous pouvez visionnez rapidement les activit&eacute;s qui vous int&eacute;ressent en cliquant sur &laquo;Mon Calendrier&raquo; dans le cadre &laquo;Fonctions membres&raquo;.',
	9 => 'Ajouter &agrave; mon calendrier',
	10 => 'Retirer de mon calendrier',
	11 => "Ajouter l'activit&eacute; au clendrier de {$_USER['username']}",
	12 => 'Activit&eacute;',
	13 => 'Commence',
	14 => 'Fini',
        15 => 'Retour au calendrier'
);

###############################################################################
# comment.php

$LANG03 = array(
	1 => 'Ajouter un commentaire',
	2 => 'Format',
	3 => 'Se d&eacute;connecter',
	4 => 'Cr&eacute;er un compte',
	5 => 'Nom d\'utilisateur',
	6 => 'L\'envoi d\'un commentaire requiers que vous soyez enregistr&eacute; et connect&eacute;. Si vous n\'avez pas encore de compte, vous pouvez vous inscrire &agrave; l\'aide du formulaire ci-dessous.',
	7 => 'Votre dernier commentaire &eacute;tait il y a ',
	8 => " secondes. Vous devez attendre au moins {$_CONF['commentspeedlimit']} secondes entre chaque commentaire.",
	9 => 'Commenter',
	10 => 'CNT 10',
	11 => 'Envoyer le commentaire',
	12 => 'Vous devez obligatoirement compl&eacute;ter les champs Titre et Commentaire avant d\'envoyer.',
	13 => 'Vos infos',
	14 => 'Aper&ccedil;u',
	15 => 'CNT 15',
	16 => 'Titre',
	17 => 'Erreur',
	18 => 'Remarque importante',
	19 => 'Essayez de respecter le sujet de l\'article dans votre r&eacute;ponse.',
	20 => 'Essayez de r&eacute;pondre aux commentaires des autres plut&ocirc;t qu\'&agrave; l\'article lui même.',
	21 => 'Lisez tous les messages des autres avant d\'envoyer votre propre message afin faire de r&eacute;p&eacute;tition.',
	22 => 'Veuillez utiliser un titre en lien avec votre message.',
	23 => 'Votre adresse courriel NE SERA PAS rendue publique.',
	24 => 'Utilisateur anonyme'
);

###############################################################################
# users.php

$LANG04 = array(
	1 => 'Profil membre de',
	2 => 'Nom d\'utilisateur',
	3 => 'Nom complet',
	4 => 'Mot de passe',
	5 => 'Courriel',
	6 => 'Site Internet',
	7 => 'Biographie',
	8 => 'Cl&eacute; PGP',
	9 => 'Mettre &agrave; jour',
	10 => 'Les 10 derniers commentaires de l\'utilisateur',
	11 => 'Aucun commentaire',
	12 => 'Pr&eacute;f&eacute;rences d\'utilisation de',
	13 => 'Courriel temporis&eacute; la nuit',
	14 => 'Ce mot de passe a &eacute;t&eacute; g&eacute;n&eacute;r&eacute; automatiquement. Il est recommend&eacute; que vous le changiez imm&eacute;diatement. Pour ce faire, connectez-vous et cliquez sur &laquo;informations personnelles&raquo; dans le menu &laquo;membre&raquo;.',
	15 => "Votre compte, nomm&eacute; {$_CONF['site_name']}, a &eacute;t&eacute; cr&eacute;&eacute; avec succ&egrave;s. Vous devez utiliser les informations ci-dessous pour vous connecter. Veuillez sauvegarder ce message pour vous y r&eacute;f&eacute;rer.",
	16 => 'Informations sur votre compte',
	17 => 'Ce compte n\'existe pas',
	18 => 'L\'adresse courriel semble ne pas être valide.',
	19 => 'L\'adresse courriel fournie est d&eacute;ja utilis&eacute;e par un autre membre.',
	20 => 'L\'adresse courriel fournie ne semble pas être valide.',
	21 => 'Erreur',
	22 => "Enregistrez-vous avec {$_CONF['site_name']}!",
	23 => "Apres avoir cr&eacute;&eacute; votre compte {$_CONF['site_name']} vous pourrez envoyer des commentaires et d'autres &eacute;l&eacute;ments. Si vous n'avez pas de compte, vous ne pourrez seulement qu'envoyer des commentaires anonymes. Votre adresse courriel ne sera jamais publi&eacute;e sur ce site.",
	24 => 'Le mot de passe vous sera envoy&eacute; par courriel &agrave; l\'adresse enregistr&eacute;e.',
	25 => 'Avez-vous oubli&eacute; votre mot de passe?',
	26 => 'Saisissez <em>soit</em> votre nom d\'utilisateur <em>soit</em> l\'adresse courriel enregistr&eacute;e &agrave; ce compte, et cliquez &laquo;Envoi du mot de passe&raquo;. Des instructions &agrave; suivre concernant l\'enregistrement d\'un nouveau mot de passe vous seront adress&eacute;es par courriel.',
	27 => 'Enregistrez-vous maintenant!',
	28 => 'Envoi du mot de passe',
	29 => 'd&eacute;connect&eacute; de',
	30 => 'connect&eacute; &agrave;',
	31 => 'Vous devez être connect&eacute; pour ex&eacute;cuter cette fonction',
	32 => 'Signature',
	33 => 'Jamais affich&eacute;e publiquement',
	34 => 'Votre nom v&eacute;ritable',
	35 => 'Entrez votre mot de passe afin de le changer',
	36 => 'Commence par http://',
	37 => 'Appliquer &agrave; vos commentaires',
	38 => 'Tout sur vous! Accessible par tous',
	39 => 'Votre cl&eacute; puplique PGP &agrave; partager',
	40 => 'Pas d\'ic&ocirc;ne de sujet',
	41 => 'En attente d\'autorisation',
	42 => 'Format de date',
	43 => 'Nombre maximal d\'articles',
	44 => 'Pas de bo&icirc;tes',
	45 => 'Pr&eacute;f&eacute;rences d\'affichage pour',
	46 => 'El&eacute;ments &agrave; exclure pour',
	47 => 'Configuration de la bo&icirc;te des Nouvelles pour',
	48 => 'Sujets',
	49 => 'Pas d\'ic&ocirc;ne dans les articles',
	50 => 'D&eacute;cocher les cases si vous n\'êtes pas inter&eacute;ss&eacute;',
	51 => 'Seulement les articles de Nouvelles',
	52 => 'Par d&eacute;faut',
	53 => 'Recevoir les articles du jour chaque nuit',
	54 => 'Cocher les cases pour les auteurs et les articles que vous ne voulez pas voir appara&icirc;tre',
	55 => 'Si vous laissez toutes les cases d&eacute;coch&eacute;es, cela signifie que vous souhaitez la s&eacute;lection par d&eacute;faut. Si vous s&eacute;lectionnez au moins une case, n\'oubliez pas de s&eacute;lectionner toutes celles qui vous int&eacute;ressent car les autres seront ignor&eacute;es. Les cases s&eacute;lectionn&eacute;es par d&eacute;faut apparaissent en gras.',
	56 => 'Auteur',
	57 => 'Format',
	58 => 'Ordre de tri',
	59 => 'Nombre maximum de commentaires',
	60 => 'Comment souhaitez vous que vos commentaires appara&icirc;ssent?',
	61 => 'Les plus r&eacute;cents ou les plus anciens en premier?',
	62 => '100 par d&eacute;faut',
	63 => "Votre mot de passe vous a &eacute;t&eacute; envoy&eacute; par courriel et ne devrait pas tarder. Suivez les instructions du message et encore merci d'utiliser " . $_CONF['site_name'],
	64 => 'Pr&eacute;f&eacute;rences des commentaires pour',
	65 => 'Essayez de vous connecter &agrave; nouveau',
	66 => "Vous avez peut-être mal saisi le nom de votre compte. Essayer encore de vous connecter &agrave; l'aide du formulaire ci-dessous. Pas encore membre? Inscrivez-vous comme <a href=\"{$_CONF['site_url']}/users.php?mode=new\">ici</a>?",
	67 => 'Membre depuis',
	68 => 'S\'en souvenir pour moi',
	69 => 'Combien de temps devrions-nous garder votre connection  active?',
	70 => "Personnaliser l'aspect et le contenu de {$_CONF['site_name']}",
	71 => "Une fonctionnalit&eacute; int&eacute;ressante de {$_CONF['site_name']} est que vous pouvez en personnaliser l'aspect et le contenu. Afin de pouvoir utiliser ces fonctionnalit&eacute;s vous devez vous <a href=\"{$_CONF['site_url']}/users.php?mode=new\">enregistrer</a> au pr&egrave;s de {$_CONF['site_name']}.  Vous êtes d&eacute;j&agrave; membre?  Alors utilisez la passerelle de connection dans la barre de gauche pour vous connecter!",
    72 => 'Aspect',
    73 => 'Langue',
    74 => 'Changez l\'aspect de ce site!',
    75 => 'Envoyez des courriel &agrave; ces sujets',
    76 => 'Si vous s&eacute;lectionnez un (des) sujet(s) parmi ceux ci-dessous, vous recevrez par courriel &agrave; la fin de chaque journ&eacute;e (vers 22H) les nouveaux articles concerant ces sujets. Choisissez uniquement les sujets qui vous int&eacute;ressent !',
    77 => 'Photo',
    78 => 'Ajouter votre propre photo!',
    79 => 'Cochez ici pour effacer cette photo',
    80 => 'Nom de connexion',
    81 => 'Envoyer courriel',
    82 => '10 derniers article du membre',
    83 => 'Statistiques du membre',
    84 => 'Nombre total d\'articles:',
    85 => 'Nombre total de commentaires:',
    86 => 'Chercher les articles par',
    87 => 'Votre nom de membre',
    88 => "Quelqu'un (possiblement vous-même) avez demand&eacute; un nouveau mot de passe pour le compte '%s' sur " . $_CONF['site_name'] . ", <" . $_CONF['site_url'] . ">.\n\nSi vous d&eacute;sirez r&eacute;ellement que cette action soit entreprise, nous vous prions de cliquer sur ce lien:\n\n",
    89 => 'Pour refuser d\'entreprendre cette action, vous n\'avez simplement qu\'&agrave; ignorer ce message, ainsi aucune nouvelle action ne sera alors entreprise (votre mot de passe demeurera inchang&eacute;).\n\n',
    90 => 'Vous pouvez choisir un nouveau mot de passe pour le compte ci-dessous. Pri&egrave;re de noter que l\'ancien mot de passe demeurera actif jusqu\'&agrave; ce que vous soumettiez ce formulaire.',
    91 => 'R&eacute;glez le nouveau mot de passe',
    92 => 'Entrez le nouveau mot de passe',
    93 => 'Votre derni&egrave;re requête pour l\'obtention d\'un nouveau mot de passe &eacute;tait il y a %d secondes de cela. Ce site requiers que s\'&eacute;coule au moins %d secondes entre les requêtes de nouveaux mots de passe.',
    94 => 'Effacer le compte "%s"',
    95 => 'Cliquez sur "Effacer le compte" ci-dessous pour effacer votre compte de notre banque de donn&eacute;es. Notez que toutes vos interventions sur ce site seront conserv&eacute;es, &eacute;tant attribu&eacute;es &agrave; un utilisateur &laquo;Anonyme&raquo; en remplacement de votre nom de membre.',
    96 => 'effacer le compte',
    97 => 'Confirmez l\'effacement de votre compte',
    98 => 'Êtes-vous certain de vouloir effacer ce compte? Car ce faisant, vous ne pourrez alors plus acc&eacute;der aux fonctions de ce site (sauf en cr&eacute;ant un nouveau compte). Si vous en êtes certain, cliquez alors sur "effacer le compte" une derni&egrave;re fois ci-dessous.',
    99 => 'Options de s&eacute;curit&eacute; pour',
    100 => '&eacute;crivez &agrave; l\'administrateur du site',
    101 => 'Autorisez les courriels provenant de l\'administrateur du site',
    102 => 'Courriels des membres',
    103 => 'Allouez la r&eacute;ception de courriels provenant d\'autre membres',
    104 => 'Affichez votre pr&eacute;sence en ligne',
    105 => 'Affichez ma pr&eacute;sence dans le bloc &laquo;En ligne&raquo;'
);

###############################################################################
# index.php

$LANG05 = array(
	1 => 'Aucun article &agrave; afficher',
	2 => 'Il n\'y a pas de nouveaux articles &agrave; afficher. Il n\'y a peut-être pas de nouveaut&eacute;s pour ce sujet ou alors vos pr&eacute;f&eacute;rences sont trop restrictives.',
	3 => ' pour le sujet $topic',
	4 => 'Article du jour',
	5 => 'Suivant',
	6 => 'Pr&eacute;c&eacute;dent'
);

###############################################################################
# links.php

$LANG06 = array(
	1 => 'Ressources Internet',
	2 => 'Il n\'y a aucune ressource &agrave; afficher',
	3 => 'Ajoutez un lien'
);

###############################################################################
# pollbooth.php

$LANG07 = array(
	1 => 'Vote enregistr&eacute;',
	2 => 'Votre vote a &eacute;t&eacute; comptabilis&eacute;',
	3 => 'Voter',
	4 => 'Sondages existants',
	5 => 'Votes',
	6 => 'Voyez les autres questions sond&eacute;es'
);

###############################################################################
# profiles.php

$LANG08 = array(
	1 => 'Une erreur s\'est produite lors de l\'envoi de votre message. Veuillez r&eacute;essayer.',
	2 => 'Message a &eacute;t&eacute; envoy&eacute; avec succ&egrave;s.',
	3 => 'V&eacute;rifiez que l\'adresse du champ &laquo;r&eacute;pondre &agrave;&raquo; est valide.',
	4 => 'Veuillez compl&eacute;ter les champs: &laquo;Votre nom&raquo;, &laquo;r&eacute;ponse &agrave;&raquo;, &laquo;sujet&raquo; et &laquo;message&raquo;',
	5 => 'Erreur: membre inconnu.',
	6 => 'Il y a eu une erreur.',
	7 => 'Profil membre de ',
	8 => 'Nom de connexion',
	9 => 'URL membre',
	10 => 'Envoyer un courriel &agrave;',
	11 => 'Votre nom:',
	12 => 'R&eacute;pondre &agrave;:',
	13 => 'Subject:',
	14 => 'Message:',
	15 => 'Les balises HTML ne seront pas traduites.',
	16 => 'Envoyer Message',
	17 => 'Envoyer cette article &agrave; un ami',
	18 => 'Pour',
	19 => 'Adresse courriel',
	20 => 'De',
	21 => 'Adresse courriel',
	22 => 'Tous les champs sont obligatoires',
	23 => "Ce courriel vous a &eacute;t&eacute; envoy&eacute; de la part de $from at $fromemail car il pensait que vous pourriez être int&eacute;ress&eacute; par {$_CONF['site_url']}. Ce n'est pas un SPAM et l'adresse courriel utilis&eacute;e n'est pas stok&eacute;e dans une liste d'envoi.",
	24 => 'Commentaire sur cet article &agrave;',
	25 => 'Vous devez être connect&eacute; pour utiliser cette fonction. Votre identification permettra de contr&ocirc;ler tout abus du syst&egrave;me',
	26 => 'Ce formulaire vous permet d\'envoyer un courriel &agrave; tous les membres s&eacute;lectionn&eacute;s. Tous les champs sont obligatoires.',
	27 => 'Message court',
	28 => '$from a &eacute;crit: $shortmsg',
	29 => "Voici les articles du jour {$_CONF['site_name']} pour ",
    	30 => ' lettre d\'information de ',
    	31 => 'Titre',
    	32 => 'Date',
    	33 => 'Lire l\'article complet &agrave;',
    	34 => 'Fin du message',
    	35 => 'D&eacute;sol&eacute;, ce membre ne d&eacute;sire pas recevoir de messages.'
);

###############################################################################
# search.php

$LANG09 = array(
	1 => 'Recherche avanc&eacute;e',
	2 => 'Mots cl&eacute;s',
	3 => 'Sujet',
	4 => 'Tous',
	5 => 'Type',
	6 => 'Articles',
	7 => 'Commentaires',
	8 => 'Auteurs',
	9 => 'Tous',
	10 => 'Chercher',
	11 => 'R&eacute;sultats de recherche',
	12 => 's&eacute;lections',
	13 => 'Aucun r&eacute;sultats n\'a &eacute;t&eacute; trouv&eacute;',
	14 => 'Aucun r&eacute;sultat ne correspond &agrave; vos crit&egrave;res',
	15 => 'Veuillez r&eacute;essayer.',
	16 => 'Titre',
	17 => 'Date',
	18 => 'Auteur',
	19 => "Chercher dans toute la base de donn&eacute;es de {$_CONF['site_name']} des articles anciens ou recents.",
	20 => 'Date',
	21 => '&agrave;',
	22 => '(Format des dates AAAA-MM-JJ)',
	23 => 'Actions',
	24 => 'Trouv&eacute; %d items',
	25 => 'R&eacute;sultats pour',
	26 => 'Items',
	27 => 'secondes',
    	28 => 'Il n\'y a pas d\'articles ou de commentaires correspondant &agrave; vos crit&egrave;res',
    	29 => 'Articles et commentaires trouv&eacute;s',
    	30 => 'Aucun lien trouv&eacute;',
    	31 => 'Aucun lien trouv&eacute; pour ce plugin',
    	32 => 'Activit&eacute;',
    	33 => 'URL',
    	34 => 'Localisation',
    	35 => 'Tous les jours',
    	36 => 'Aucune activit&eacute; trouv&eacute;e',
    	37 => 'Activit&eacute;s trouv&eacute;es',
    	38 => 'Liens trouv&eacute;s',
    	39 => 'Liens',
    	40 => 'Activit&eacute;s',
    	41 => 'Votre sujet de recherche devrait comporter au moins 3 caract&egrave;res.',
    	42 => 'Pri&egrave;re d\'utiliser une date exprim&eacute;e comme suit: AAAA-MM-JJ (ann&eacute;e-mois-jour).',
    	43 => 'phrase exacte',
    	44 => 'tous ces mots',
    	45 => 'n\'importe quel mot',
    	46 => 'Suivant',
    	47 => 'Pr&eacute;c&eacute;dant',
    	48 => 'Auteur',
    	49 => 'Date',
    	50 => 'Clics',
    	51 => 'Lien',
    	52 => 'Localisation',
    	53 => 'R&eacute;sultats d\'articles',
    	54 => 'R&eacute;sultats de commentaires',
    	55 => 'la phrase',
    	56 => 'ET',
    	57 => 'OU'
);

###############################################################################
# stats.php

$LANG10 = array(
	1 => 'Statistiques du site',
	2 => 'Nombre de clics sur le site',
	3 => 'Nombre d\'articles',
	4 => 'Nombre de sondages',
	5 => 'Nombre de liens',
	6 => 'Nombre d\'activit&eacute;s',
	7 => 'Top-10 des articles les plus regard&eacute;s',
	8 => 'Titre d\'article',
	9 => 'Pages regard&eacute;es',
	10 => 'Soit il n\'y a pas d\'article sur ce site, soit ils n\'ont pas &eacute;t&eacute; regard&eacute;s',
	11 => 'Top-10 des articles les plus comment&eacute;s',
	12 => 'Commentaires',
	13 => 'Soit il n\'y a pas d\'article sur ce site, soit aucun commentaires n\'a encore &eacute;t&eacute; fait.',
	14 => 'Top-10 des sondages les populaires',
	15 => 'Questions des sondages',
	16 => 'Votes',
	17 => 'Soit il n\'y a aucun sondage sur ce site, soit personne n\'a encore vot&eacute;',
	18 => 'Top-10 des liens les plus populaires',
	19 => 'Liens',
	20 => 'Clics',
	21 => 'Soit il n\'y a encore aucun lien, soit personne n\'a encore cliqu&eacute; dessus',
	22 => 'Top-10 des articles les plus envoy&eacute;s par courriel',
	23 => 'Courriels',
	24 => 'Personne n\'a encore envoy&eacute; d\'article par courriel'
);

###############################################################################
# article.php

$LANG11 = array(
	1 => 'Sujets voisins',
	2 => 'Envoyer cet article &agrave; un ami',
	3 => 'Version imprimable',
	4 => 'Option des articles'
);

###############################################################################
# submit.php

$LANG12 = array(
	1 => 'Pour envoyer un $type vous devez vous identifier comme membre.',
	2 => 'Nom de membre',
	3 => 'Nouveau membre',
	4 => 'Soumettre une activit&eacute;',
	5 => 'Soumettre un lien',
	6 => 'Soumettre un article',
	7 => 'Identification requise',
	8 => 'Envoyer',
	9 => 'Veuillez compl&eacute;ter tous les champs et v&eacute;rifier &agrave; deux fois TOUTES les informations.',
	10 => 'Titre',
	11 => 'Lien',
	12 => 'D&eacute;but',
	13 => 'Fin',
	14 => 'Localisation',
	15 => 'Description',
	16 => 'Si autre, pr&eacute;cisez',
	17 => 'Cat&eacute;gorie',
	18 => 'Autre',
	19 => 'Lisez en premier',
	20 => 'Erreur: cat&eacute;gorie manquante',
	21 => 'Si vous s&eacute;lectionnez &laquo;Autre&raquo; veuillez indiquer une cat&eacute;gorie',
	22 => 'Erreur: champs manquants',
	23 => 'Veuillez compl&eacute;ter tous les champs du formulaire. Ils sont tous obligatoires.',
	24 => 'Proposition enregistr&eacute;e',
	25 => 'Vos propositions $type ont &eacute;t&eacute; sauvegard&eacute;es avec succ&egrave;s.',
	26 => 'Vitesse limite',
	27 => 'Membre',
	28 => 'Sujet',
	29 => 'Article',
	30 => 'Votre derni&egrave;re proposition &eacute;tait il y a',
	31 => " secondes. Vous devez attendre au moins {$_CONF['speedlimit']} secondes entre chaque propositions",
	32 => 'Aper&ccedil;u',
	33 => 'Aper&ccedil;u de l\'article',
	34 => 'Se d&eacute;connecter',
	35 => 'Les balises HTML ne sont pas accept&eacute;es',
	36 => 'Format',
	37 => "Le fait de sugg&eacute;rer une activit&eacute;e &agrave; {$_CONF['site_name']} aura pour effet d'inclure cette activit&eacute; dans le calendrier g&eacute;n&eacute;ral. Les membres pourront alors ajouter cette activit&eacute; dans leur calendrier personnel. Cette fonctionnalit&eacute; <b>ne doit pas</b> servir aux anniversaires.<br><br>L'administrateur du site se r&eacute;serve le droit d'accepter ou de refuser toute proposition",
    38 => 'Ajouter l\'activit&eacute; &agrave;',
    39 => 'Calendrier g&eacute;n&eacute;ral',
    40 => 'Calendrier personnel',
    41 => 'Fin',
    42 => 'D&eacute;but',
    43 => 'Activit&eacute;s aujourd\'hui',
    44 => 'Adresse (ligne 1)',
    45 => 'Adresse (ligne 2)',
    46 => 'Ville',
    47 => 'R&eacute;gion',
    48 => 'Code postal',
    49 => 'Type d\'activit&eacute;',
    50 => 'Modifier le type',
    51 => 'Localisation',
    52 => 'Supprimer',
    53 => 'Cr&eacute;er un compte'
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
	1 => 'Identification requise',
	2 => 'Utilisateur ou mot de passe incorrect',
	3 => 'Mot de passe incorrect',
	4 => 'Nom du membre:',
	5 => 'Mot de passe:',
	6 => 'Toutes tentatives d\'acc&egrave;s &agrave; cette portion du site est enregistr&eacute;e et analys&eacute;e.<br>Cette page est r&eacute;serv&eacute;e aux personnes autoris&eacute;es.',
	7 => 'Connexion'
);

###############################################################################
# block.php

$LANG21 = array(
	1 => 'Droits insuffisants',
	2 => 'Vous n\'avez pas les droits n&eacute;cessaires pour modifier ce cadre',
	3 => 'Editeur de cadre',
	4 => 'CNT 4',
	5 => 'titre du cadre',
	6 => 'sujet',
	7 => 'tous',
	8 => 'niveau de s&eacute;curit&eacute; du cadre',
	9 => 'Ordre du cadre',
	10 => 'type du cadre',
	11 => 'Cadre Portail',
	12 => 'Cadre Normal',
	13 => 'Cadre portail d\'option',
	14 => 'URL RDF',
	15 => 'Derni&egrave;re MAJ RDF',
	16 => 'Cadre normal d\'option',
	17 => 'Contenu du cadre',
	18 => 'Veuillez remplir les champs: titre, niveau de s&eacute;curit&eacute; et contenu du cadre',
	19 => 'Contr&ocirc;leur de cadre',
	20 => 'Cadre titre',
	21 => 'Cadre niv. sec.',
	22 => 'Cadre type',
	23 => 'Cadre ordre',
	24 => 'Cadre sujet',
	25 => 'Cliquez sur le lien ci-dessous pour modifier ou supprimer un cadre.  Cliquez sur le lien nouveau cadre pour cr&eacute;er un nouveau cadre.',
	26 => 'Cadre d\'affichage',
	27 => 'Cadre PHP',
    28 => 'Option du cadre PHP',
    29 => 'Cadre fonction',
    30 => 'Si vous voulez que l\'un de vos cadres utilise du PHP, saisissez le nom de la fonction &agrave; utiliser.  Le nom de la fonction doit commencer par \'phpblock_\' (ex: phpblock_getweather).  Si ce n\'est pas le cas, votre fonction NE SERA PAS appell&eacute;e, ceci pour des raisons de s&eacute;curit&eacute;.  Ne mettez pas de parenth&egrave;ses vides \'()\' apr&egrave;s le nom de votre fonction.  Enfin, nous vous recommandons de mettre tout le code des cadre PHP dans /path/to/geeklog/system/lib-custom.php.  Cela permettera de garder votre code même apr&egrave;s une mise &agrave; jour de geeklog.',
    31 => 'Erreur dans le cadre PHP.  La fonction, $function, n\'existe pas.',
    32 => 'Erreur: champs manquant',
    33 => 'Vous devez mettre l\'URL dans le fichier .rdf pour le cadre portail.',
    34 => 'Vous devez renseigner le titre et la fonction du cadre PHP.',
    35 => 'Vous devez entrer le titre et le contenu du cadre normal.',
    36 => 'Vous devez entrer le contenu pour le cadre d\'affichage.',
    37 => 'Nom erron&eacute; dans la fonction du cadre PHP',
    38 => 'Les fonctions des cadres PHP doivent commencer par "phpblock_" (ex: phpblock_getweather).  Le pr&eacute;fixe "phpblock_" est n&eacute;cessaire pour des raisons de s&eacute;curit&eacute; qui empêche l\'ex&eacute;cution de code arbitraire.',
	39 => 'C&ocirc;t&eacute;',
	40 => 'Gauche',
	41 => 'Droit',
	42 => 'Vous devez saisir l\'ordre et le niveau de s&eacute;curit&eacute; pour les cadres par d&eacute;faut de geeklog',
	43 => 'Accueil seulement',
	44 => 'Acc&egrave;s interdit',
	45 => "Vous essayez d'acc&eacute;der &agrave; un cadre auquel vous n'avez pas droit.  Cette tentative est enregistr&eacute;e. Veuillez <a href=\'{$_CONF['site_admin_url']}/block.php\'>retourner &agrave; la page de controle des cadres</a>.",
	46 => 'Nouveau Cadre',
	47 => 'Accueil admin',
    48 => 'Nom du cadre',
    49 => ' (pas d\'espace et doit être unique)',
    50 => 'URL d\'aide',
    51 => 'inclure http:// ',
    52 => 'Laisser vide pour ne pas afficher l\'icone d\'aide',
    53 => 'Activ&eacute;',
    54 => 'enregistrer',
    55 => 'annuler',
    56 => 'supprimer'
);

###############################################################################
# event.php

$LANG22 = array(
	1 => 'Editeur d\'activit&eacute;',
	2 => 'CNT 2',
	3 => 'Titre',
	4 => 'URL',
	5 => 'D&eacute;but',
	6 => 'Fin',
	7 => 'Localisation',
	8 => 'Description',
	9 => '(inclure http://)',
	10 => 'Vous devez s&eacute;lectionner une date, une heure, une description et une localisation!',
	11 => 'Contr&ocirc;leur d\'activit&eacute;',
	12 => 'Pour supprimer ou modifier une activit&eacute;, cliquez sur le bouton ci-dessous. Pour cr&eacute;er une nouvelle activit&eacute; cliquez sur &laquo;Nouvelle activit&eacute;&raquo;.',
	13 => 'titre',
	14 => 'd&eacute;but',
	15 => 'fin',
	16 => 'Acc&egrave;s interdit',
	17 => "vous essayez d'acc&eacute;der &agrave; une activit&eacute; auquel vous n'avez pas les droits. Cette tentative a &eacute;t&eacute; enregistr&eacute;e. Retournez &agrave; <a href=\'{$_CONF['site_admin_url']}/event.php\'>la page d'aministration des activit&eacute;s</a>.",
	18 => 'Nouvelle activit&eacute;',
	19 => 'Page de l\'administrateur',
    20 => 'enregistrer',
    21 => 'annuler',
    22 => 'supprimer'
);

###############################################################################
# link.php

$LANG23 = array(
	1 => 'Editeur de liens',
	2 => 'CNT 2',
	3 => 'Titre',
	4 => 'URL',
	5 => 'Cat&eacute;gorie',
	6 => '(http:// inclus)',
	7 => 'Autre',
	8 => 'Nombre de s&eacute;lection',
	9 => 'Description',
	10 => 'Vous devez saisir un titre, une URL et une description.',
	11 => 'Contr&ocirc;leur de lien',
	12 => 'Cliquez sur le lien ci-dessous pour modifier ou supprimer un lien.  Cliquez sur Nouveau Lien pour cr&eacute;er un lien.',
	13 => 'Titre',
	14 => 'Cat&eacute;gorie',
	15 => 'URL',
	16 => 'Acc&egrave;s interdit',
	17 => "Vous essayez d'acc&eacute;der &agrave; un lien auquel vous n'avez pas les droits.  Cette tentative est enregistr&eacute;e. Veuillez <a href=\'{$_CONF['site_admin_url']}/link.php\'>retourner &agrave; la page de controle des liens</a>.",
	18 => 'Nouveau lien',
	19 => 'Accueil Admin',
	20 => 'Si autre, pr&eacute;cisez',
    21 => 'enregistrer',
    22 => 'annuler',
    23 => 'supprimer'
);

###############################################################################
# story.php

$LANG24 = array(
	1 => 'Articles pr&eacute;c&eacute;dents',
	2 => 'Articles suivants',
	3 => 'Mode',
	4 => 'Format',
	5 => 'Editeur d\'articles',
	6 => 'Il n\'y a pas d\'articles dans le syst&egrave;me',
	7 => 'Auteur',
	8 => 'Enregistrer',
	9 => 'Aper&ccedil;u',
	10 => 'Annuler',
	11 => 'Supprimer',
	12 => '',
	13 => 'Titre',
	14 => 'Sujet',
	15 => 'Date',
	16 => 'Texte d\'intro',
	17 => 'Texte int&eacute;gral',
	18 => 'Clics',
	19 => 'Commentaires',
	20 => '',
	21 => '',
	22 => 'Liste des articles',
	23 => 'Pour modifier ou supprimer un article, cliquez sur son num&eacute;ro. Pour visionner un article, cliquez sur le titre de l\'article. Pour cr&eacute;er un nouvel article, cliquez sur le bouton &eacute;crire un article.',
	24 => '',
	25 => '',
	26 => 'Aper&ccedil;u de l\'article',
	27 => '',
	28 => '',
	29 => '',
	30 => '',
	31 => 'Veuillez inscrire le titre et le texte d\'introduction.',
	32 => 'Tête d\'affiche',
	33 => 'Il ne peut y avoir qu\'un seul article en tête d\'affiche',
	34 => 'Brouillon',
	35 => 'Oui',
	36 => 'Non',
	37 => 'Plus sur',
	38 => 'Plus de',
	39 => 'Emails',
	40 => 'Acc&egrave;s refus&eacute;',
	41 => "Vous essayez d'acc&eacute;der &agrave; un article auqule vous n'avez pas droit.  Cette tentative est enregistr&eacute;e.  Vous pouvez voir cet article en lecture seule uniquement. Veuillez <a href=\'{$_CONF['site_admin_url']}/story.php\'>retourner sur la page de contr&ocirc;le des article</a> lorsque vous aurez fini.",
	42 => "Vous essayez d'acc&eacute;der &agrave; un article auquel vous n'avez pas droit.  Cette tentative est enregistr&eacute;e.  Veuillez <a href=\'{$_CONF['site_admin_url']}/story.php\'>retourner &agrave; la page de contr&ocirc;le des articles</a>.",
	43 => 'Nouvel article',
	44 => 'Accueil Admin',
	45 => 'Acc&egrave;s',
    46 => '<b>REMARQUE:</b> si vous indiquez une date future, cet article n\'appara&icirc;tra qu\'&agrave; partir de cette date. Cela signifie aussi que l\'article sera ignor&eacute; des recherches et des statistiques.',
    47 => 'Images',
    48 => 'image',
    49 => 'droite',
    50 => 'gauche',
    51 => 'Pour ajouter une des images que vous avez fournies vous devez ins&eacute;rer un texte sp&eacute;cial dans votre article. Vous devez ins&eacute;rer [imageX], [imageX_right] ou [imageX_left] o&ugrave; X est le num&eacute;ro de l\'image que vous avez fournie.  REMARQUE: vous devez utiliser toutes les images fournies.  Si vous ne le faites pas vous ne pourrez pas enregistrer votre article.<BR><P><B>APERCU</B>: lors de l\'utilisation d\'images il est pr&eacute;f&eacute;rables de faire un brouillon plut&ocirc;t que d\'utiliser la fonction d\'apercu.  Utilisez le bouton d\'apercu uniquement lorsqu\'il n\'y a pas d\'image.',
    52 => 'Supprimer',
    53 => 'n\'est pas utilis&eacute;e.  Vous devez ins&eacute;rer l\'image dans le texte de votre article avant de l\'enregistrer.',
    54 => 'Image fournie non utilis&eacute;e',
    55 => 'L\'erreur suivante est apparue lors de l\'enregistrement de votre article.  Veuillez corriger ces erreurs et r&eacute;essayer',
    56 => 'Montrer l\'ic&ocirc;ne',
    57 => 'Montrer l\'image originale'
);

###############################################################################
# poll.php

$LANG25 = array(
	1 => 'Mode',
	2 => 'Pri&egrave;re d\'inscrire une question et au moins un choix de r&eacute;ponse',
	3 => 'Sondage cr&eacute;&eacute;',
	4 => 'Sondage $qid enregistr&eacute;',
	5 => 'Modifier sondage',
	6 => 'N&deg; de sondage',
	7 => '(ne pas utiliser d\'espaces)',
	8 => 'Appara&icirc;t sur la page d\'accueil',
	9 => 'Question',
	10 => 'R&eacute;ponses / Votes',
	11 => 'Une erreur s\'est produite lors de l\'obtention des r&eacute;ponses du sondage $qid',
	12 => 'Une erreur s\'est produite lors de l\'obtention des questions du sondage $qid',
	13 => 'Nouveau Sondage',
	14 => 'Enregistrer',
	15 => 'Annuler',
	16 => 'Supprimer',
	17 => 'Pri&egrave;re d\'inscrire un n&deg; de sondage',
	18 => 'Liste des sondages',
	19 => 'Cliquez sur un sondage pour le modifier ou le supprimer.  Cliquez sur Nouveau Sondage pour cr&eacute;er un sondage.',
	20 => 'Votants',
	21 => 'Acc&egrave;s interdit',
	22 => "vous essayez d'acc&eacute;der &agrave; un sondage auquel vous n'avez pas droit.  Cette tentative est enregistr&eacute;e. Veuillez <a href=\'{$_CONF['site_admin_url']}/poll.php\'>retourner &agrave; la page de contr&ocirc;le des sondages</a>.",
	23 => 'Nouveau Sondage',
	24 => 'Accueil Admin',
	25 => 'Oui',
	26 => 'Non'
);

###############################################################################
# topic.php

$LANG27 = array(
	1 => 'Editeur de sujet',
	2 => 'Num&eacute;ro',
	3 => 'Nom',
	4 => 'Image',
	5 => '(ne pas utiliser d\'espaces)',
	6 => 'Supprimer un sujet supprimera tous les articles et cadres en relations avec celui-ci',
	7 => 'Veuillez renseigner le num&eacute;ro et le nom du sujet.',
	8 => 'Contr&ocirc;leur de sujet',
	9 => 'Cliquez sur un sujet pour le modifier ou le supprimer.  Cliquez sur le bouton &laquo;Nouveau Sujet&raquo; &agrave; gauche pour cr&eacute;er un sujet. Vos droits d\'acc&egrave;s concernent tout sujet apparaissant entre parenth&egrave;ses.',
	10=> 'Ordre de tri',
	11 => 'Articles/Page',
	12 => 'Acc&egrave;s interdit',
	13 => "vous essayez d'acc&eacute;der &agrave; un sujet auquel vous n'avez pas droit.  Cette tentative est enregistr&eacute;e. Veuillez <a href=\'{$_CONF['site_admin_url']}/topic.php\'>retourner &agrave; la page de contr&ocirc;le des sujets</a>.",
	14 => 'M&eacute;thode de tri',
	15 => 'alphab&eacute;tique',
	16 => 'par d&eacute;faut:',
	17 => 'Nouveau Sujet',
	18 => 'Accueil Admin',
    	19 => 'Enregistrer',
    	20 => 'Annuler',
    	21 => 'Supprimer',
	22 => 'Par d&eacute;faut',
    	23 => 'Faites de ce sujet le choix par d&eacute;faut pour la cr&eacute;ation de nouveaux articles',
    	24 => '(*)'
);

###############################################################################
# user.php

$LANG28 = array(
	1 => 'Editeur du membre',
	2 => 'Num&eacute;ro',
	3 => 'Nom de connexion',
	4 => 'Nom complet',
	5 => 'Mot de passe',
	6 => 'Niveau de s&eacute;curit&eacute;',
	7 => 'Adresse courriel',
	8 => 'Page d\'accueil',
	9 => '(ne pas utiliser d\'espaces)',
	10 => 'Veuillez renseigner le nom de connexion, le nom complet, le nom complet et l\'adresse courriel.',
	11 => 'Contr&ocirc;leur des membres',
	12 => 'Cliquez sur un membre pour le modifier ou le supprimer.  Cliquez sur le bouton Nouveau membre &agrave; gauche pour cr&eacute;er un compte. Vous pouvez faire des recherches simple en entrant une partie du nom de connexion, du nom complet ou de l\'adresse courriel (ex:*son* ou *.edu) dans le formulaire ci-dessous.',
	13 => 'Niv. Sec.',
	14 => 'Date d\'enregistrement',
	15 => 'Nouveau membre',
	16 => 'Accueil Admin',
	17 => 'Changer le mot de passe',
	18 => 'Annuler',
	19 => 'Supprimer',
	20 => 'enregistrer',
	18 => 'Annuler',
	19 => 'Supprimer',
	20 => 'Enregistrer',
    21 => 'Le nom de connexion est d&eacute;j&agrave; utilis&eacute;.',
    22 => 'Erreur',
    23 => 'Ajout par lot',
    24 => 'Importation par lot d\'utilisateurs',
    25 => 'Vous pouvez importer un lot d\'utilisateur dans le syst&egrave;me.  Les champ du fichier d\'import doivent être s&eacute;par&eacute;s par une tabulation. Ils doivent appara&icirc;tre dans l\'ordre suivant: Nom complet, nom de connexion, adresse courriel.  Chaque utilisateur import&eacute; sera averti par courriel et aura un mot de passe auto-g&eacute;n&eacute;r&eacute;.  Il ne doit y avoir qu\'un seul utilisateur par ligne.  Ne pas respecter ces consignes peut entra&icirc;ner des d&eacute;gat qui ne seront r&eacute;parables que manuellement, alors redoublez de vigilance!',
    26 => 'Chercher',
    27 => 'Nb de r&eacute;sultats max',
    28 => 'Coche la case pour supprimer la photo',
    29 => 'Chemin',
    30 => 'Importer',
    31 => 'Nouveaux membres',
    32 => 'Traitement termin&eacute;. $successes membres ont &eacute;t&eacute; import&eacute;s et il y a $failures erreurs',
    33 => 'envoyer',
    34 => 'Erreur: Vous devez pr&eacute;ciser un fichier &agrave; t&eacute;l&eacute;charger.',
    35 => 'Dernier acc&egrave;s',
    36 => '(jamais)'
);


###############################################################################
# moderation.php

$LANG29 = array(
    1 => 'Valider',
    2 => 'Supprimer',
    3 => 'Modifier',
    4 => 'Profil',
    10 => 'Titre',
    11 => 'D&eacute;but',
    12 => 'URL',
    13 => 'Cat&eacute;gorie',
    14 => 'Date',
    15 => 'Sujet',
    16 => 'Membre',
    17 => 'Nom Complet',
    18 => 'Courriel',
    34 => 'Commandes et Contr&ocirc;les',
    35 => 'Soumissions d\'articles',
    36 => 'Soumission de liens',
    37 => 'Soumission d\'activit&eacute;s',
    38 => 'Envoyer',
    39 => 'Il n\'y a aucune soumission &agrave; administrer pour le moment',
    40 => 'Soumissions des membres'
);

###############################################################################
# calendar.php

$LANG30 = array(
	1 => 'Dimanche',
	2 => 'Lundi',
	3 => 'Mardi',
	4 => 'Mercredi',
	5 => 'Jeudi',
	6 => 'Vendredi',
	7 => 'Samedi',
	8 => 'Ajouter une activit&eacute;',
	9 => 'activit&eacute; geeklog',
	10 => 'Activit&eacute;s pour',
	11 => 'Calendrier g&eacute;n&eacute;ral',
	12 => 'Calendrier personnel',
	13 => 'Janvier',
	14 => 'F&eacute;vrier',
	15 => 'Mars',
	16 => 'Avril',
	17 => 'Mai',
	18 => 'Juin',
	19 => 'Juillet',
	20 => 'Ao&ucirct',
	21 => 'Septembre',
	22 => 'Octobre',
	23 => 'Novembre',
	24 => 'D&eacute;cembre',
	25 => 'Retour &agrave; ',
    26 => 'Tous les jours',
    27 => 'Semaine',
    28 => 'Calendrier personnel de',
    29 => 'Calendrier public',
    30 => 'Supprimer l\'activit&eacute;',
    31 => 'Ajouter',
    32 => 'Activit&eacute;',
    33 => 'Date',
    34 => 'Heure',
    35 => 'Ajout rapide',
    36 => 'Envoyer',
    37 => 'D&eacute;sol&eacute;, le calendrier personnel n\'est pas activ&eacute;',
    38 => 'Editeur d\'activit&eacute;s personnelles',
    39 => 'Jour',
    40 => 'Semaine',
    41 => 'Mois'
);

###############################################################################
# admin/mail.php
$LANG31 = array(
 	1 => "Envoyer un mail aux membres de ".$_CONF['site_name'],
 	2 => 'De',
 	3 => 'Adresse de r&eacute;ponse',
 	4 => 'Sujet',
 	5 => 'Message',
 	6 => '&agrave;:',
 	7 => 'Tous les membres',
 	8 => 'Admin',
	9 => 'Options',
	10 => 'HTML',
 	11 => 'message urgent!',
 	12 => 'Envoyer',
 	13 => 'Effacer',
 	14 => 'Ignorer les pr&eacute;f&eacute;rences membre',
 	15 => 'Erreur lors de l\'envoi d\'un message &agrave;: ',
	16 => 'Message envoy&eacute; avec succ&egrave;s &agrave;: ',
	17 => '<a href="' . $_CONF['site_admin_url'] . '/mail.php">Envoyer un autre message</a>',
    18 => '&agrave;',
    19 => 'Remarque: si vous voulez envoyer un message &agrave; tous les membres, utilisez le groupe Logged-in dans le champ A.',
    20 => '<successcount> messages ont &eacute;t&eacute; envoy&eacute;s avec succ&egrave;s et <failcount> n\'ont pas pu être envoy&eacute;s.  Vous trouverez le d&eacute;tail de chaque tentative ci-dessous.  Vous pouvez &eacute;galement <a href="' . $_CONF['site_admin_url'] . '/mail.php">envoyer un autre message</a> ou <a href="' . $_CONF['site_admin_url'] . '/moderation.php">revenir &agrave; la page d\'administration</a>.',
    21 => '&eacute;checs',
    22 => 'Succ&egrave;s',
    23 => 'Pas d\'&eacute;checs',
    24 => 'Pas de succ&egrave;s',
    25 => '-- Choisir un groupe --',
    26 => 'Remplissez tous les champs et choisissez un groupe parmi la liste.'
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "Votre mot de passe a &eacute;t&eacute; envoy&eacute; par courriel et devrait vous parvenir sous peu. Suivez les instructions incluses dans le message et encore merci d'utiliser " . $_CONF['site_name'],
	2 => "Merci de proposer un article &agrave; {$_CONF['site_name']}.  Il a &eacute;t&eacute; envoy&eacute; &agrave; notre &eacute;quipe qui en disposera. Votre article sera publi&eacute; s'il est retenu.",
	3 => "Merci de proposer un lien &agrave; {$_CONF['site_name']}.  Il a &eacute;t&eacute; envoy&eacute; &agrave; notre &eacute;quipe qui en disposera.  S'il est retenu, votre lien sera affich&eacute; <a href={$_CONF['site_url']}/links.php>ici</a>.",
	4 => "Merci de proposer une activit&eacute; &agrave; {$_CONF['site_name']}.  Elle a &eacute;t&eacute; envoy&eacute;e &agrave; notre &eacute;quipe qui en disposera. Si elle est retenue, votre activit&eacute; sera affich&eacute;e <a href={$_CONF['site_url']}/calendar.php>ici</a>.",
	5 => 'Vos informations ont &eacute;t&eacute; mises &agrave; jour avec succ&egrave;s.',
	6 => 'Vos pr&eacute;f&eacute;rences d\'affichage ont &eacute;t&eacute; mises &agrave; jour avec succ&egrave;s.',
	7 => 'Vos pr&eacute;f&eacute;rences de commentaire ont &eacute;t&eacute; mises &agrave; jour avec succ&egrave;s.',
	8 => 'Vous avez &eacute;t&eacute; d&eacute;connect&eacute; avec succ&egrave;s.',
	9 => 'Votre article a &eacute;t&eacute; enregistr&eacute; avec succ&egrave;s.',
	10 => 'L\'article a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s.',
	11 => 'Votre cadre a &eacute;t&eacute; enregistr&eacute; avec succ&egrave;s.',
	12 => 'Le cadre a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s.',
	13 => 'Votre sujet a &eacute;t&eacute; enregistr&eacute; avec succ&egrave;s.',
	14 => 'Le sujet et tous ses articles ainsi que ses cadres ont &eacute;t&eacute; supprim&eacute;s avec succ&egrave;s.',
	15 => 'Votre lien a &eacute;t&eacute; enregistr&eacute; avec succ&egrave;s.',
	16 => 'Le lien a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s.',
	17 => 'Votre activit&eacute; a &eacute;t&eacute; enregistr&eacute;e avec succ&egrave;s.',
	18 => 'L\'activit&eacute; a &eacute;t&eacute; supprim&eacute;e avec succ&egrave;s.',
	19 => 'Votre sondage a &eacute;t&eacute; enregistr&eacute; avec succ&egrave;s.',
	20 => 'Le sondage a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s.',
	21 => 'Le nouveau membre a &eacute;t&eacute; enregistr&eacute; avec succ&egrave;s.',
	22 => 'L\'utilisateur a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s.',
	23 => 'Erreur durant l\'ajout d\'une activit&eacute; &agrave; votre calendrier. Aucun identifiant d\'activit&eacute; n\'a &eacute;t&eacute; transmis.',
	24 => 'L\'activit&eacute; a &eacute;t&eacute; enregistr&eacute;e dans votre calendrier.',
	25 => 'Vous devez vous connecter pour consulter votre calendrier',
	26 => 'L\'activit&eacute; a &eacute;t&eacute; supprim&eacute;e de votre calendrier avec succ&egrave;s.',
	27 => 'Message envoy&eacute; avec succ&egrave;s.',
	28 => 'Le plugin a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s.',
	29 => 'Les calendriers personnels ne sont pas activ&eacute;s.',
	30 => 'Acc&egrave;s interdit',
	31 => 'Vous n\'avez pas acc&egrave;s &agrave; la page d\'administration des articles. Toutes les tentatives d\'acc&egrave;s &agrave; des parties non autoris&eacute;es sont enregistr&eacute;es.',
	32 => 'Vous n\'avez pas acc&egrave;s &agrave; la page d\'administration des sujets. Toutes les tentatives d\'acc&egrave;s &agrave; des parties non autoris&eacute;es sont enregistr&eacute;es.',
	33 => 'Vous n\'avez pas acc&egrave;s &agrave; la page d\'administration des cadres. Toutes les tentatives d\'acc&egrave;s &agrave; des parties non autoris&eacute;es sont enregistr&eacute;es.',
	34 => 'Vous n\'avez pas acc&egrave;s &agrave; la page d\'administration des liens. Toutes les tentatives d\'acc&egrave;s &agrave; des parties non autoris&eacute;es sont enregistr&eacute;es.',
	35 => 'Vous n\'avez pas acc&egrave;s &agrave; la page d\'administration des activit&eacute;s. Toutes les tentatives d\'acc&egrave;s &agrave; des parties non autoris&eacute;es sont enregistr&eacute;es.',
	36 => 'Vous n\'avez pas acc&egrave;s &agrave; la page d\'administration des sondages. Toutes les tentatives d\'acc&egrave;s &agrave; des parties non autoris&eacute;es sont enregistr&eacute;es.',
	37 => 'Vous n\'avez pas acc&egrave;s &agrave; la page d\'administration des membres. Toutes les tentatives d\'acc&egrave;s &agrave; des parties non autoris&eacute;es sont enregistr&eacute;es.',
	38 => 'Vous n\'avez pas acc&egrave;s &agrave; la page d\'administration des plugins. Toutes les tentatives d\'acc&egrave;s &agrave; des parties non autoris&eacute;es sont enregistr&eacute;es.',
	39 => 'Vous n\'avez pas acc&egrave;s &agrave; la page d\'administration des courriels. Toutes les tentatives d\'acc&egrave;s &agrave; des parties non autoris&eacute;es sont enregistr&eacute;es.',
	40 => 'Message syst&egrave;me',
    41 => 'Vous n\'avez pas acc&egrave;s &agrave; la page d\'administration des substitutions de mots. Toutes les tentatives d\'acc&egrave;s &agrave; des parties non autoris&eacute;es sont enregistr&eacute;ss.',
    42 => 'Votre mot a &eacute;t&eacute; enregistr&eacute; avec succ&egrave;s.',
    43 => 'Le mot a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s.',
    44 => 'Le plugin a &eacute;t&eacute; install&eacute; avec succ&egrave;s!',
    45 => 'Le plugin a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s.',
    46 => 'Vous n\'avez pas acc&egrave;s &agrave; l\'utilitaire de sauvegarde de la base de donn&eacute;es. Toutes les tentatives d\'acc&egrave;s &agrave; des parties non autoris&eacute;es sont enregistr&eacute;es.',
    47 => 'Cet option ne fonctionne que sur *nix. Si vous utilisez *nix alors votre cache a &eacute;t&eacute; vid&eacute;e avec succ&egrave;s. Si vous utilisez Windows, vous devez chercher les fichiers adodb_*.php et les supprimer &agrave; la main.',
    48 => 'Merci d\'avoir demand&eacute; un compte membre sur ' . $_CONF['site_name'] . '. La demande a &eacute;t&eacute; envoy&eacute;e &agrave; notre &eacute;quipe qui en disposera. Lorsque la demande sera accept&eacute;e, votre mot de passe vous sera envoy&eacute; par courriel &agrave; l\'adresse que vous avez fournie.',
    49 => 'Votre groupe a &eacute;t&eacute; enregistr&eacute; avec succ&egrave;s.',
    50 => 'Le groupe a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s.',
    51 => 'Ce nom de membre existe d&eacute;j&agrave;. Pri&egrave;re d\'en choisir un nouveau.',
    52 => 'Le courriel fourni ne para&icirc;t pas être valide.',
    53 => 'Votre nouveau mot de passe &agrave; &eacute;t&eacute; accept&eacute;. Pri&egrave;re de l\'inscrire ci-dessous pour acc&eacute;der au site.',
    54 => 'Votre requête pour l\'obtention d\'un nouveau mot de passe est expir&eacute;e. Pri&egrave;re d\'essayer de nouveau ci-dessous.',
    55 => 'Un courriel qui vient de vous être envoy&eacute; devrait vous parvenir sous peu. Pri&egrave;re de suivre les instructions du message et de proc&eacute;der &agrave; l\'enregistrement de votre nouveau mot de passe.',
    56 => 'L\'adresse courriel fournie est d&eacute;j&agrave; utilis&eacute;e par un autre compte.',
    57 => 'Votre compte &agrave; &eacute;t&eacute; effac&eacute; avec succ&egrave;s.'
);


// for plugins.php

$LANG32 = array (
	1 => 'L\'installation de plugins peut endommager le syst&egrave;me.  Il est important de n\'installer que des plugins approuv&eacute;s par <a href=\'http://www.geeklog.net\' target=\'_blank\'>Geeklog</a> car nous les testons sur plusieurs syst&egrave;mes. Installer des plugins requiert l\'ex&eacute;cution de plusieurs commandes syst&egrave;mes qui peuvent poser des probl&egrave;mes de s&eacute;curit&eacute;, particuli&egrave;rement si vous utilisez des plugins de provenances inconnues. Vous êtes averti des domages que peut causer l\'installation d\'un plugin. En d\'autres termes, vous installez des plugins &agrave; vos propres risques. Les instructions d\'installation des plugins sont incluses dans chaque plugin.',
	2 => 'Instructions d\'installation d\'un plugin',
	3 => 'Formulaire d\'installation d\'un plugin',
	4 => 'Fichier du plugin',
	5 => 'Liste des plugins',
	6 => 'Attention: plugin d&eacute;j&agrave; install&eacute;!',
	7 => 'Le plugin que vous essayez d\'installer existe d&eacute;j&agrave;.  Veuillez supprimer le plugin avant de le r&eacute;installer.',
	8 => 'Test de compatibilit&eacute; du plugin &eacute;chou&eacute;',
	9 => 'Ce plugin requiert une version plus r&eacute;cente du syst&egrave;me. Vous pouvez mettre &agrave; jour votre <a href=\'http://www.geeklog.net\'>Geeklog</a> ou obtenir une autre version du plugin.',
	10 => '<br><b>Aucun plugin n\'est actuellement install&eacute;.</b><br><br>',
	11 => 'Cliquez sur le num&eacute;ro du plugin pour le modifier ou le supprimer. Pour en savoir d\'avantage sur les plugins, cliquez sur le nom du plugin et vous serez redirig&eacute; vers le site web du plugin. Pour installer ou mettre &agrave; jour un plugin veuillez vous r&eacute;f&eacute;rer &agrave; la documentation du plugin.',
	12 => 'Aucun nom de plugin n\'a &eacute;t&eacute; pass&eacute; &agrave; plugineditor()',
	13 => 'Editeur de plugin',
	14 => 'Nouveau plugin',
	15 => 'Accueil Admin',
	16 => 'Nom du plugin',
	17 => 'Version du plugin',
	18 => 'Version de Geeklog',
	19 => 'Activ&eacute;',
	20 => 'Oui',
	21 => 'Non',
	22 => 'Installer',
    23 => 'Enregistrer',
    24 => 'Annuler',
    25 => 'Supprimer',
    26 => 'Nom du plugin',
    27 => 'Site web du plugin',
    28 => 'Version du plugin',
    29 => 'Version de Geeklog',
    30 => 'Supprimer le plugin ?',
    31 => 'Etes-vous s&ucircr de vouloir supprimer ce plugin? Toutes les donn&eacute;es, fiches et structures utilis&eacute;s par ce plugin seront d&eacute;truites.  Si vous êtes certain de vouloir supprimer le plugin, cliquez sur le bouton &laquo;Supprimer&raquo;.'
);

$LANG_ACCESS = array(
	access => 'Acc&egrave;s',
        ownerroot => 'Propri&eacute;taire/Admin',
        group => 'Groupe',
        readonly => 'Lecture seule',
	accessrights => 'Droits d\'acc&egrave;s',
	owner => 'Propri&eacute;taire',
	grantgrouplabel => 'Autorisation au del&agrave; du groupe d\'&eacute;dition',
	permmsg => 'REMARQUE: les membres sont tous les utilisateurs identifi&eacute;s et les anonymes sont tous les autres.',
	securitygroups => 'Groupe de s&eacute;curit&eacute;',
	editrootmsg => "Except&eacute; si vous êtes administrateur, vous ne pouvez pas modifier un autre administrateur. Vous pouvez modifier tous les utilisateurs except&eacute;s les administrateurs. Toutes tentatives de modifications d\'un administrateur sont enregistr&eacute;es. Retournez sur la <a href=\'{$_CONF['site_admin_url']}/user.php\'>page d'administration</a>.",
	securitygroupsmsg => 'S&eacute;lectionner les cases des groupes auxquels l\'utilisateur appartient',
	groupeditor => 'Editeur de groupe',
	description => 'Description',
	name => 'Nom',
 	rights => 'Droits',
	missingfields => 'Champs manquants',
	missingfieldsmsg => 'Vous devez saisir un nom et une description',
	groupmanager => 'Administrateur de groupe',
	newgroupmsg => 'Pour modifier ou supprimer un groupe, cliquez sur le groupe ci-dessous. Pour cr&eacute;er un nouveu groupe, cliquez sur Nouveau Groupe. Les groupes natifs ne peuvent pas être supprim&eacute;s car ils sont utilis&eacute;s par le syst&egrave;me.',
	groupname => 'Nom du groupe',
	coregroup => 'Groupe syst&egrave;me',
	yes => 'Oui',
	no => 'Non',
	corerightsdescr => "Ce groupe est un groupe syst&egrave;me de {$_CONF['site_name']}.  Les droits de ce groupe ne peuvent pas être modifi&eacute;s.  La liste ci-dessous des droits d'acc&egrave;s du groupe n'est pas modifiable.",
	groupmsg => 'Les droits des groupes sont hi&eacute;rarchiques.  En ajoutant un groupe &agrave; un autre vous ajoutez tous les droits de ce groupe &agrave; l\'autre.  Lorsque c\'est possible, utilisez les groupes d&eacute;ja d&eacute;finis.  Si vous avez besoin de droits sp&eacute;cifiques, vous pouvez les choisir dans la liste ci-dessous.  Pour Ajouter un groupe &agrave; celui-ci cliquez sur la case du groupe &agrave; ajouter.',
	coregroupmsg => "Ce groupe est un groupe syst&egrave;me de {$_CONF['site_name']}.  Les droits de ce groupe ne peuvent pas être modifi&eacute;s. La liste ci-dessous des groupes inclus de ce groupe n'est pas modifiable.",
	rightsdescr => 'Les droits suivants peuvent être donn&eacute;s directement au groupe OU provenir d\'un groupe inclus. Les droits sans case &agrave; cocher proviennent de groupe inclus. Les droits qui ont des cases &agrave; cocher sont donn&eacute;s directement au groupe.',
	lock => 'Bloquer',
	members => 'Membres',
	anonymous => 'Anonymes',
	permissions => 'Permissions',
	permissionskey => 'R = lecture, E = modification, le droit de modification implique le droit de lecture',
	edit => 'Modifier',
	none => 'Rien',
	accessdenied => 'Acc&egrave;s interdit',
	storydenialmsg => "vous n'avez pas le droit de lire cette article. Peut-être que vous n'êtes pas membre de {$_CONF['site_name']}.  Vous pouvez <a href=users.php?mode=new>vous enregistrer</a> sur {$_CONF['site_name']} pour obtenir un compte membre!",
	eventdenialmsg => "vous n'avez pas acc&egrave;s &agrave; cet &eacute;v&egrave;nement. Peut-être que vous n'êtes pas membre de {$_CONF['site_name']}.  Vous pouvez <a href=users.php?mode=new>vous enregistrer</a> sur {$_conf['site_name']} pour obtenir un compte membre!",
	nogroupsforcoregroup => 'Le groupe n\'inclue aucun autre groupe',
	grouphasnorights => 'Le groupe n\'a pas acc&egrave;s aux fonctions administratives',
	newgroup => 'Nouveau Groupe',
	adminhome => 'Accueil Admin',
	save => 'enregistrer',
	cancel => 'annuler',
	delete => 'supprimer',
	canteditroot => 'Vous avez essay&eacute; de modifier le groupe administrateur mais vous n\'en faites pas partie. Vous n\'avez pas acc&egrave;s &agrave; ce groupe. Veuillez contacter l\'administrateur si vous pensez que c\'est une erreur.'	
);

#admin/word.php
$LANG_WORDS = array(
    editor => 'Editeur de substitution de mots',
    wordid => 'Num&eacute;ro du mot',
    intro => 'Cliquez sur un mot pour le modifier ou le supprimer.  Cliquez sur Nouveau Mot &agrave; gauche pour cr&eacute;er une substitution de mot.',
    wordmanager => 'Gestionnaire de mots',
    word => 'Mot',
    replacmentword => 'Substitution de mots',
    newword => 'Nouveau Mot'
);

$LANG_DB_BACKUP = array(
    last_ten_backups => '10 dernieres sauvegardes',
    do_backup => 'Faire une sauvegarde',
    backup_successful => 'Sauvegarde de la base de donn&eacute;e effectu&eacute;e avec succ&egrave;s',
    no_backups => 'Aucune sauvegarde dans le syst&egrave;me',
    db_explanation => 'Cliquez sur le bouton ci-dessous pour effectuer une sauvegarde de votre syst&egrave;me Geeklog',
    not_found => 'Chemin incorecte ou le fichier mysqldump n\'est pas ex&eacute;cutable.<br>V&eacute;rifiez le param&egrave;tre <strong>\$_DB_mysqldump_path</strong> dans le fichier config.php.<br>Ce param&egrave;tre est actuellement positionn&eacute; &agrave; : <var>{$_DB_mysqldump_path}</var>',
    zero_size => 'Sauvegarde &eacute;chou&eacute;e: la taille du fichier &eacute;tait de 0 octets.',
    path_not_found => "{$_CONF['backup_path']} n'existe pas ou n'est pas un r&eacute;pertoire.",
    no_access => "Erreur: le r&eacute;pertoire {$_CONF['backup_path']} n'est pas accessible.",
    backup_file => 'Fichier de sauvegarde',
    size => 'Taille',
    bytes => 'Octets'
);

$LANG_BUTTONS = array(
    1 => 'Entr&eacute;e',
    2 => 'Contacts',
    3 => 'Ecrire un article',
    4 => 'Liens',
    5 => 'Sondages',
    6 => 'Calendrier',
    7 => 'Statistiques du site',
    8 => 'Personnaliser',
    9 => 'Chercher',
    10 => 'Recherche avanc&eacute;e'
);

$LANG_404 = array(
    1 => 'Erreur 404',
    2 => "Le syst&egrave;me ne trouve pas <b>http://{$HTTP_SERVER_VARS['HTTP_HOST']}{$HTTP_SERVER_VARS['REQUEST_URI']}</b>.",
    3 => "<p>Le fichier que vous demandez n'existe pas. Allez &agrave; la <a href=\'{$_CONF['site_url']}\'>page principale</a> ou la <a href=\'{$_CONF['site_url']}/search.php\'>page de recherche</a> afin de retrouver ce que vous avez perdu."
);

$LANG_LOGIN = array (
    1 => 'Vous devez vous connecter',
    2 => 'Vous devez vous identifier &agrave; l\'aide de l\'espace membre pour acc&eacute;der &agrave; cette partie du site.',
    3 => 'Accueil',
    4 => 'Nouveau membre'
);

?>

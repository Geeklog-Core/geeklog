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

$LANG_CHARSET = 'UTF-8';

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
    108 => 'Vider la cache',
    109 => 'Report abuse',
    110 => 'Report this post to the site admin',
    111 => 'View PDF Version',
    112 => 'Registered Users',
    113 => 'Documentation',
    114 => 'TRACKBACKS',
    115 => 'No new trackback comments',
    116 => 'Trackback',
    117 => 'Directory',
    118 => 'Please continue reading on the next page:',
    119 => "Lost your <a href=\"{$_CONF['site_url']}/users.php?mode=getpassword\">password</a>?",
    120 => 'Permanent link to this comment',
    121 => 'Comments (%d)',
    122 => 'Trackbacks (%d)',
    123 => 'All HTML is allowed',
    124 => 'Click to delete all checked items',
    125 => 'Are you sure you want to Delete all checked items?',
    126 => 'Select or de-select all items'
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
    24 => 'Utilisateur anonyme',
    25 => 'Are you sure you want to report this post to the site admin?',
    26 => '%s reported the following abusive comment post:',
    27 => 'Abuse report'
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
    63 => "Votre mot de passe vous a &eacute;t&eacute; envoy&eacute; par courriel et ne devrait pas tarder. Suivez les instructions du message et encore merci d'utiliser {$_CONF['site_name']}",
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
    88 => "Quelqu'un (possiblement vous-même) avez demand&eacute; un nouveau mot de passe pour le compte '%s' sur {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nSi vous d&eacute;sirez r&eacute;ellement que cette action soit entreprise, nous vous prions de cliquer sur ce lien:\n\n",
    89 => "Pour refuser d\'entreprendre cette action, vous n\'avez simplement qu\'&agrave; ignorer ce message, ainsi aucune nouvelle action ne sera alors entreprise (votre mot de passe demeurera inchang&eacute;).\n\n",
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
    105 => 'Affichez ma pr&eacute;sence dans le bloc &laquo;En ligne&raquo;',
    106 => 'Location',
    107 => 'Shown in your public profile',
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
    123 => "Are you a <a href=\"{$_CONF['site_url']}/users.php?mode=new\">new user</a>?",
    124 => 'Confirm Email',
    125 => 'You have to enter the same email address in both fields!',
    126 => 'Please repeat for confirmation',
    127 => 'To change any of these settings, you will have to enter your current password.',
    128 => 'Your Name',
    129 => 'Password &amp; Email',
    130 => 'About You',
    131 => 'Daily Digest Options',
    132 => 'Daily Digest Feature',
    133 => 'Comment Display',
    134 => 'Comment Options',
    135 => '<li>Default mode for how comments will be displayed</li><li>Default order to display comments</li><li>Set maximum number of comments to show - default is 100</li>',
    136 => 'Exclude Topics and Authors',
    137 => 'Filter Story Content',
    138 => 'Misc Settings',
    139 => 'Layout and Language',
    140 => '<li>No Topic Icons if checked will not display the story topic icons</li><li>No boxes if checked will only show the Admin Menu, User Menu and Topics<li>Set the maximum number of stories to show per page</li><li>Set your theme and perferred date format</li>',
    141 => 'Privacy Settings',
    142 => 'The default setting is to allow users & admins to email fellow site members and show your status as online. Un-check these options to protect your privacy.',
    143 => 'Filter Block Content',
    144 => 'Show & hide boxes',
    145 => 'Your Public Profile',
    146 => 'Password and email',
    147 => 'Edit your account password, email and autologin feature. You will need to enter the same password or email address twice as a confirmation.',
    148 => 'User Information',
    149 => 'Modify your user information that will be shown to other users.<li>The signature will be added to any comments or forum posts you made</li><li>The BIO is a brief summary of yourself to share</li><li>Share your PGP Key</li>',
    150 => 'Warning: Javascript recommended for enhanced functionality',
    151 => 'Preview',
    152 => 'Username & Password',
    153 => 'Layout & Language',
    154 => 'Content',
    155 => 'Privacy',
    156 => 'Delete Account'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Aucun article &agrave; afficher',
    2 => 'Il n\'y a pas de nouveaux articles &agrave; afficher. Il n\'y a peut-être pas de nouveaut&eacute;s pour ce sujet ou alors vos pr&eacute;f&eacute;rences sont trop restrictives.',
    3 => ' pour le sujet %s',
    4 => 'Article du jour',
    5 => 'Suivant',
    6 => 'Pr&eacute;c&eacute;dent',
    7 => 'First',
    8 => 'Last'
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
    23 => "Ce courriel vous a &eacute;t&eacute; envoy&eacute; de la part de %s at %s car il pensait que vous pourriez être int&eacute;ress&eacute; par {$_CONF['site_url']}. Ce n'est pas un SPAM et l'adresse courriel utilis&eacute;e n'est pas stok&eacute;e dans une liste d'envoi.",
    24 => 'Commentaire sur cet article &agrave;',
    25 => 'Vous devez être connect&eacute; pour utiliser cette fonction. Votre identification permettra de contr&ocirc;ler tout abus du syst&egrave;me',
    26 => 'Ce formulaire vous permet d\'envoyer un courriel &agrave; tous les membres s&eacute;lectionn&eacute;s. Tous les champs sont obligatoires.',
    27 => 'Message court',
    28 => '%s a &eacute;crit: ',
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
    57 => 'OU',
    58 => 'More results &gt;&gt;',
    59 => 'Results',
    60 => 'per page',
    61 => 'Refine search'
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
    24 => 'Personne n\'a encore envoy&eacute; d\'article par courriel',
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
    1 => 'Sujets voisins',
    2 => 'Envoyer cet article &agrave; un ami',
    3 => 'Version imprimable',
    4 => 'Option des articles',
    5 => 'PDF Story Format'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'Pour envoyer un %s vous devez vous identifier comme membre.',
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
    25 => 'Vos propositions %s ont &eacute;t&eacute; sauvegard&eacute;es avec succ&egrave;s.',
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
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

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
# admin/block.php

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
    31 => 'Erreur dans le cadre PHP.  La fonction, %s, n\'existe pas.',
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
    56 => 'supprimer',
    57 => 'Move Block Down',
    58 => 'Move Block Up',
    59 => 'Move block to the right side',
    60 => 'Move block to the left side',
    61 => 'No Title',
    62 => 'Article Limit',
    63 => 'Bad Block Title',
    64 => 'Your Title must not be empty and cannot contain HTML!',
    65 => 'Order',
    66 => 'Autotags',
    67 => 'Check to allow autotags'
);

###############################################################################
# admin/story.php

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
    12 => 'ID',
    13 => 'Titre',
    14 => 'Sujet',
    15 => 'Date',
    16 => 'Texte d\'intro',
    17 => 'Texte int&eacute;gral',
    18 => 'Clics',
    19 => 'Commentaires',
    20 => 'Ping',
    21 => 'Send Ping',
    22 => 'Liste des articles',
    23 => 'Pour modifier ou supprimer un article, cliquez sur son num&eacute;ro. Pour visionner un article, cliquez sur le titre de l\'article. Pour cr&eacute;er un nouvel article, cliquez sur le bouton &eacute;crire un article.',
    24 => 'The ID you chose for this story is already in use. Please use another ID.',
    25 => 'Error when saving story',
    26 => 'Aper&ccedil;u de l\'article',
    27 => 'If you use [unscaledX] instead of [imageX], the image will be inserted at its original dimensions.',
    28 => '<p><b>PREVIEWING</b>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    29 => 'Trackbacks',
    30 => 'File Upload Errors',
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
    57 => 'Montrer l\'image originale',
    58 => 'Story Management',
    59 => 'Option',
    60 => 'Enabled',
    61 => 'Auto Archive',
    62 => 'Auto Delete',
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
    78 => 'Click <a href="%s/story.php?mode=edit&amp;sid=%s&amp;editopt=default">here</a> to use default editor',
    79 => 'Preview',
    80 => 'Editor',
    81 => 'Publish Options',
    82 => 'Images',
    83 => 'Archive Options',
    84 => 'Permissions',
    85 => 'Show All',
    86 => 'Advanced Editor',
    87 => 'Story Stats'
);

###############################################################################
# admin/topic.php

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
    10 => 'Ordre de tri',
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
    24 => '(*)',
    25 => 'Archive Topic',
    26 => 'make this the default topic for archived stories. Only one topic allowed.',
    27 => 'Or Upload Topic Icon',
    28 => 'Maximum',
    29 => 'File Upload Errors'
);

###############################################################################
# admin/user.php

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
    32 => 'Traitement termin&eacute;. %d membres ont &eacute;t&eacute; import&eacute;s et il y a %d erreurs',
    33 => 'envoyer',
    34 => 'Erreur: Vous devez pr&eacute;ciser un fichier &agrave; t&eacute;l&eacute;charger.',
    35 => 'Dernier acc&egrave;s',
    36 => '(jamais)',
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
    47 => 'Edit',
    48 => 'Show Admin Groups',
    49 => 'Admin Group',
    50 => 'Check to allow filtering this group as an Admin Use Group',
    51 => 'Online Days',
    52 => '<br>Note: "Online Days" is the number of days between the first registration and the last login.',
    53 => 'registered',
    54 => 'Batch Delete',
    55 => 'This only works if you have <code>$_CONF[\'lastlogin\'] = true;</code> in your config.php',
    56 => 'Please choose the type of user you want to delete and press "Update List". Then, uncheck those from the list you do not want to delete and press "Delete". Please note that you will only delete those that are currently visible in case the list spans over several pages.',
    57 => 'Phantom users',
    58 => 'Short-Time Users',
    59 => 'Old Users',
    60 => 'Users that registered more than ',
    61 => ' months ago, but never logged in.',
    62 => 'Users that registered more than ',
    63 => ' months ago, then logged in within 24 hours, but since then never came back to your site.',
    64 => 'Normal users, who simply did not visit your site since ',
    65 => ' months.',
    66 => 'Update List',
    67 => 'Months since registration',
    68 => 'Online Hours',
    69 => 'Offline Months',
    70 => 'could not be deleted',
    71 => 'sucessfully deleted',
    72 => 'No User selected for deletion',
    73 => 'Are You sure you want to permanently delete ALL selected users?',
    74 => 'Recent Users',
    75 => 'Users that registered in the last ',
    76 => ' months'
);

###############################################################################
# admin/moderation.php

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
# admin/mail.php

$LANG31 = array(
    1 => "Envoyer un mail aux membres de {$_CONF['site_name']}",
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
    17 => "<a href=\"{$_CONF['site_admin_url']}/mail.php\">Envoyer un autre message</a>",
    18 => '&agrave;',
    19 => 'Remarque: si vous voulez envoyer un message &agrave; tous les membres, utilisez le groupe Logged-in dans le champ A.',
    20 => "<successcount> messages ont &eacute;t&eacute; envoy&eacute;s avec succ&egrave;s et <failcount> n'ont pas pu être envoy&eacute;s.  Vous trouverez le d&eacute;tail de chaque tentative ci-dessous.  Vous pouvez &eacute;galement <a href=\"{$_CONF['site_admin_url']}/mail.php\">envoyer un autre message</a> ou <a href=\"{$_CONF['site_admin_url']}/moderation.php\">revenir &agrave; la page d'administration</a>.",
    21 => '&eacute;checs',
    22 => 'Succ&egrave;s',
    23 => 'Pas d\'&eacute;checs',
    24 => 'Pas de succ&egrave;s',
    25 => '-- Choisir un groupe --',
    26 => 'Remplissez tous les champs et choisissez un groupe parmi la liste.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
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
    31 => 'Etes-vous s&ucircr de vouloir supprimer ce plugin? Toutes les donn&eacute;es, fiches et structures utilis&eacute;s par ce plugin seront d&eacute;truites.  Si vous êtes certain de vouloir supprimer le plugin, cliquez sur le bouton &laquo;Supprimer&raquo;.',
    32 => '<p><b>Error AutoLink tag not correct format</b></p>',
    33 => 'Code Version',
    34 => 'Update',
    35 => 'Edit',
    36 => 'Code',
    37 => 'Data',
    38 => 'Update!'
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
    42 => 'Events',
    43 => 'All',
    44 => 'None',
    45 => 'Header-link in topic',
    46 => 'Limit Results',
    47 => 'Search',
    48 => 'Edit',
    49 => 'Feed Logo',
    50 => "Relative to site url ({$_CONF['site_url']})",
    51 => 'The filename you have chosen is already used by another feed. Please choose a different one.',
    52 => 'Error: existing Filename'
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "Votre mot de passe a &eacute;t&eacute; envoy&eacute; par courriel et devrait vous parvenir sous peu. Suivez les instructions incluses dans le message et encore merci d'utiliser {$_CONF['site_name']}",
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
    48 => "Merci d'avoir demand&eacute; un compte membre sur {$_CONF['site_name']}. La demande a &eacute;t&eacute; envoy&eacute;e &agrave; notre &eacute;quipe qui en disposera. Lorsque la demande sera accept&eacute;e, votre mot de passe vous sera envoy&eacute; par courriel &agrave; l'adresse que vous avez fournie.",
    49 => 'Votre groupe a &eacute;t&eacute; enregistr&eacute; avec succ&egrave;s.',
    50 => 'Le groupe a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s.',
    51 => 'Ce nom de membre existe d&eacute;j&agrave;. Pri&egrave;re d\'en choisir un nouveau.',
    52 => 'Le courriel fourni ne para&icirc;t pas être valide.',
    53 => 'Votre nouveau mot de passe &agrave; &eacute;t&eacute; accept&eacute;. Pri&egrave;re de l\'inscrire ci-dessous pour acc&eacute;der au site.',
    54 => 'Votre requête pour l\'obtention d\'un nouveau mot de passe est expir&eacute;e. Pri&egrave;re d\'essayer de nouveau ci-dessous.',
    55 => 'Un courriel qui vient de vous être envoy&eacute; devrait vous parvenir sous peu. Pri&egrave;re de suivre les instructions du message et de proc&eacute;der &agrave; l\'enregistrement de votre nouveau mot de passe.',
    56 => 'L\'adresse courriel fournie est d&eacute;j&agrave; utilis&eacute;e par un autre compte.',
    57 => 'Votre compte &agrave; &eacute;t&eacute; effac&eacute; avec succ&egrave;s.',
    58 => 'Your feed has been successfully saved.',
    59 => 'The feed has been successfully deleted.',
    60 => 'The plugin was successfully updated',
    61 => 'Plugin %s: Unknown message placeholder',
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
    75 => 'Trackbacks must be sent using a POST request.',
    76 => 'Do you really want to delete this item?',
    77 => 'WARNING:<br>You have set your default encoding to UTF-8. However, your server does not support multibyte encodings. Please install mbstring functions for PHP or choose a different character set/language.',
    78 => 'Please make sure that the email address and the confirmation email address are the same.',
    79 => 'The page you have been trying to open refers to a function that no longer exists on this site.',
    80 => 'The plugin that created this feed is currently disabled. You will not be able to edit this feed until you re-enable the parent plugin.',
    81 => 'You may have mistyped your login credentials.  Please try logging in again below.',
    82 => 'You have exceeded the number of allowed login attempts.  Please try again later.',
    83 => 'To change your password, email address, or for how long to remember you, please enter your current password.',
    84 => 'To delete your account, please enter your current password.'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Acc&egrave;s',
    'ownerroot' => 'Propri&eacute;taire/Admin',
    'group' => 'Groupe',
    'readonly' => 'Lecture seule',
    'accessrights' => 'Droits d\'acc&egrave;s',
    'owner' => 'Propri&eacute;taire',
    'grantgrouplabel' => 'Autorisation au del&agrave; du groupe d\'&eacute;dition',
    'permmsg' => 'REMARQUE: les membres sont tous les utilisateurs identifi&eacute;s et les anonymes sont tous les autres.',
    'securitygroups' => 'Groupe de s&eacute;curit&eacute;',
    'editrootmsg' => "Except&eacute; si vous êtes administrateur, vous ne pouvez pas modifier un autre administrateur. Vous pouvez modifier tous les utilisateurs except&eacute;s les administrateurs. Toutes tentatives de modifications d\'un administrateur sont enregistr&eacute;es. Retournez sur la <a href=\'{$_CONF['site_admin_url']}/user.php\'>page d'administration</a>.",
    'securitygroupsmsg' => 'S&eacute;lectionner les cases des groupes auxquels l\'utilisateur appartient',
    'groupeditor' => 'Editeur de groupe',
    'description' => 'Description',
    'name' => 'Nom',
    'rights' => 'Droits',
    'missingfields' => 'Champs manquants',
    'missingfieldsmsg' => 'Vous devez saisir un nom et une description',
    'groupmanager' => 'Administrateur de groupe',
    'newgroupmsg' => 'Pour modifier ou supprimer un groupe, cliquez sur le groupe ci-dessous. Pour cr&eacute;er un nouveu groupe, cliquez sur Nouveau Groupe. Les groupes natifs ne peuvent pas être supprim&eacute;s car ils sont utilis&eacute;s par le syst&egrave;me.',
    'groupname' => 'Nom du groupe',
    'coregroup' => 'Groupe syst&egrave;me',
    'yes' => 'Oui',
    'no' => 'Non',
    'corerightsdescr' => "Ce groupe est un groupe syst&egrave;me de {$_CONF['site_name']}.  Les droits de ce groupe ne peuvent pas être modifi&eacute;s.  La liste ci-dessous des droits d'acc&egrave;s du groupe n'est pas modifiable.",
    'groupmsg' => 'Les droits des groupes sont hi&eacute;rarchiques.  En ajoutant un groupe &agrave; un autre vous ajoutez tous les droits de ce groupe &agrave; l\'autre.  Lorsque c\'est possible, utilisez les groupes d&eacute;ja d&eacute;finis.  Si vous avez besoin de droits sp&eacute;cifiques, vous pouvez les choisir dans la liste ci-dessous.  Pour Ajouter un groupe &agrave; celui-ci cliquez sur la case du groupe &agrave; ajouter.',
    'coregroupmsg' => "Ce groupe est un groupe syst&egrave;me de {$_CONF['site_name']}.  Les droits de ce groupe ne peuvent pas être modifi&eacute;s. La liste ci-dessous des groupes inclus de ce groupe n'est pas modifiable.",
    'rightsdescr' => 'Les droits suivants peuvent être donn&eacute;s directement au groupe OU provenir d\'un groupe inclus. Les droits sans case &agrave; cocher proviennent de groupe inclus. Les droits qui ont des cases &agrave; cocher sont donn&eacute;s directement au groupe.',
    'lock' => 'Bloquer',
    'members' => 'Membres',
    'anonymous' => 'Anonymes',
    'permissions' => 'Permissions',
    'permissionskey' => 'R = lecture, E = modification, le droit de modification implique le droit de lecture',
    'edit' => 'Modifier',
    'none' => 'Rien',
    'accessdenied' => 'Acc&egrave;s interdit',
    'storydenialmsg' => "vous n'avez pas le droit de lire cette article. Peut-être que vous n'êtes pas membre de {$_CONF['site_name']}.  Vous pouvez <a href=users.php?mode=new>vous enregistrer</a> sur {$_CONF['site_name']} pour obtenir un compte membre!",
    'nogroupsforcoregroup' => 'Le groupe n\'inclue aucun autre groupe',
    'grouphasnorights' => 'Le groupe n\'a pas acc&egrave;s aux fonctions administratives',
    'newgroup' => 'Nouveau Groupe',
    'adminhome' => 'Accueil Admin',
    'save' => 'enregistrer',
    'cancel' => 'annuler',
    'delete' => 'supprimer',
    'canteditroot' => 'Vous avez essay&eacute; de modifier le groupe administrateur mais vous n\'en faites pas partie. Vous n\'avez pas acc&egrave;s &agrave; ce groupe. Veuillez contacter l\'administrateur si vous pensez que c\'est une erreur.',
    'listusers' => 'List Users',
    'listthem' => 'list',
    'usersingroup' => 'Users in group "%s"',
    'usergroupadmin' => 'User Group Administration',
    'add' => 'Add',
    'remove' => 'Remove',
    'availmembers' => 'Available Members',
    'groupmembers' => 'Group Members',
    'canteditgroup' => 'To edit this group, you have to be a member of the group. Please contact the system administrator if you feel this is an error.',
    'cantlistgroup' => 'To see the members of this group, you have to be a member yourself. Please contact the system administrator if you feel this is an error.',
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
    'last_ten_backups' => '10 dernieres sauvegardes',
    'do_backup' => 'Faire une sauvegarde',
    'backup_successful' => 'Sauvegarde de la base de donn&eacute;e effectu&eacute;e avec succ&egrave;s',
    'db_explanation' => 'Cliquez sur le bouton ci-dessous pour effectuer une sauvegarde de votre syst&egrave;me Geeklog',
    'not_found' => "Chemin incorecte ou le fichier mysqldump n'est pas ex&eacute;cutable.<br>V&eacute;rifiez le param&egrave;tre <strong>\$_DB_mysqldump_path</strong> dans le fichier config.php.<br>Ce param&egrave;tre est actuellement positionn&eacute; &agrave; : <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Sauvegarde &eacute;chou&eacute;e: la taille du fichier &eacute;tait de 0 octets.',
    'path_not_found' => "{$_CONF['backup_path']} n'existe pas ou n'est pas un r&eacute;pertoire.",
    'no_access' => "Erreur: le r&eacute;pertoire {$_CONF['backup_path']} n'est pas accessible.",
    'backup_file' => 'Fichier de sauvegarde',
    'size' => 'Taille',
    'bytes' => 'Octets',
    'total_number' => 'Total number of backups: %d'
);

###############################################################################

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
    10 => 'Recherche avanc&eacute;e',
    11 => 'Directory'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => 'Erreur 404',
    2 => 'Le syst&egrave;me ne trouve pas <b>http://</b>.',
    3 => "<p>Le fichier que vous demandez n'existe pas. Allez &agrave; la <a href=\'{$_CONF['site_url']}\'>page principale</a> ou la <a href=\'{$_CONF['site_url']}/search.php\'>page de recherche</a> afin de retrouver ce que vous avez perdu."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Vous devez vous connecter',
    2 => 'Vous devez vous identifier &agrave; l\'aide de l\'espace membre pour acc&eacute;der &agrave; cette partie du site.',
    3 => 'Accueil',
    4 => 'Nouveau membre'
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
    'pb_error_details' => 'Error when sending the pingback:',
    'delete_trackback' => 'To delete this Trackback click: '
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
# Month names

$LANG_MONTH = array(
    1 => 'Janvier',
    2 => 'F&eacute;vrier',
    3 => 'Mars',
    4 => 'Avril',
    5 => 'Mai',
    6 => 'Juin',
    7 => 'Juillet',
    8 => 'Ao&ucirct',
    9 => 'Septembre',
    10 => 'Octobre',
    11 => 'Novembre',
    12 => 'D&eacute;cembre'
);

###############################################################################
# Weekdays

$LANG_WEEK = array(
    1 => 'Dimanche',
    2 => 'Lundi',
    3 => 'Mardi',
    4 => 'Mercredi',
    5 => 'Jeudi',
    6 => 'Vendredi',
    7 => 'Samedi'
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
    'edit_adv' => 'Adv. Edit',
    'admin_home' => 'Admin Home',
    'create_new' => 'Create New',
    'create_new_adv' => 'Create New (Adv.)',
    'enabled' => 'Enabled',
    'title' => 'Title',
    'type' => 'Type',
    'topic' => 'Topic',
    'help_url' => 'Help File URL',
    'save' => 'Save',
    'cancel' => 'Cancel',
    'delete' => 'Delete',
    'delete_sel' => 'Delete selected',
    'copy' => 'Copy',
    'no_results' => '- No entries found -',
    'data_error' => 'There was an error processing the subscription data. Please check the data source.',
    'preview' => 'Preview',
    'records_found' => 'Records found'
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
<?php

###############################################################################
# french.php
# This is the french language page for GeekLog!
#
# Copyright (C) 2002 Florent Guiliani
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
    1 => 'Effectu� par:',
    2 => 'en savoir plus',
    3 => 'commentaires',
    4 => 'Modifier',
    5 => 'Voter',
    6 => 'R�sultats',
    7 => 'R�sultats du sondage',
    8 => 'votes',
    9 => 'Fonctions Admin:',
    10 => 'Propositions',
    11 => 'Articles',
    12 => 'Cadres',
    13 => 'Sujets',
    14 => 'Liens',
    15 => 'Ev�nements',
    16 => 'Sondages',
    17 => 'Utilisateurs',
    18 => 'Requ�te SQL',
    19 => 'Se d�connecter',
    20 => 'Informations personnelles:',
    21 => 'Nom d\'utilisateur',
    22 => 'Num�ro d\'utilisateur:',
    23 => 'Niveau de s�curit�',
    24 => 'Anonyme',
    25 => 'R�pondre',
    26 => 'Ce site n\'est pas responsable du contenu des commentaires. Ceux-ci sont de la responsabilit� des auteurs',
    27 => 'Dernier commentaire',
    28 => 'Effacer',
    29 => 'Aucun commentaire.',
    30 => 'Vieux articles',
    31 => 'Balise HTML autoris�es:',
    32 => 'Erreur: Utilisateur invalide',
    33 => 'Erreur: Impossible d\'ecrire dans le fichier de log.',
    34 => 'Erreur',
    35 => 'Se d�connecter',
    36 => 'sur',
    37 => 'Aucun article utilisateur',
    38 => '(CNT 38)',
    39 => 'Rafra�chir',
    40 => '(CNT 40)',
    41 => 'Visiteur',
    42 => 'Appartient �:',
    43 => 'Y r�pondre',
    44 => 'Parent',
    45 => 'Num�ro d\'erreur MySQL',
    46 => 'Message d\'erreur MySQL',
    47 => 'Espace Membres',
    48 => 'Informations personnelles',
    49 => 'Pr�f�rences d\'affichage',
    50 => 'Erreur dans la requ�te SQL',
    51 => 'Aide',
    52 => 'Nouveau',
    53 => 'Point de d�part de l\'Admin',
    54 => 'Ne peut ouvrir ce fichier.',
    55 => 'Erreur �',
    56 => 'Voter',
    57 => 'Mot de passe',
    58 => 'Connexion',
    59 => "Pas encore de compte?  Enregistrez vous <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Ici</a>",
    60 => 'Ajouter un commentaire',
    61 => 'Cr�er un nouveau compte',
    62 => 'mots',
    63 => 'Pr�f�rences commentaires',
    64 => 'Envoyer cet article � un ami',
    65 => 'Version imprimable',
    66 => 'Mon calendrier',
    67 => 'Bienvenue �',
    68 => 'Survol',
    69 => 'contact',
    70 => 'chercher',
    71 => 'contribuer',
    72 => 'ressources du web',
    73 => 'sondages pr�c�dents',
    74 => 'calendrier',
    75 => 'recherche avanc�e',
    76 => 'statistiques du site',
    77 => 'Plugins',
    78 => 'Ev�nement � venir',
    79 => 'Quoi de neuf',
    80 => 'derniers articles',
    81 => 'dernier article',
    82 => 'heures',
    83 => 'COMMENTAIRES',
    84 => 'LIENS',
    85 => 'derni�res 48 heures',
    86 => 'Pas de nouveau commentaires',
    87 => '2 dernieres semaines',
    88 => 'pas de nouveau liens',
    89 => 'Il n\'ya pas d\'�v�nement � venir',
    90 => 'Survol',
    91 => 'Page cr��e en',
    92 => 'secondes',
    93 => 'Tout droits r�serv�s',
    94 => 'Toutes les marques cit�es apartiennent � leurs propri�taires respectifs.',
    95 => 'G�n�r� par',
    96 => 'Groupes',
    97 => 'Liste de mots',
    98 => 'Plug-ins',
    99 => 'Articles',
    100 => 'Pas de nouveaux articles',
    101 => 'Vos �v�nements',
    102 => 'Ev�nements g�n�raux',
    103 => 'Sauvegarde de la BDD',
    104 => 'par',
    105 => 'Mail aux membres',
    106 => 'Vu',
    107 => 'MAJ de GL',
    108 => 'Vider le cache'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => 'Calendrier des �v�nements',
    2 => 'D�sol� il n\'ya pas d\'�v�nement � afficher.',
    3 => 'Quand',
    4 => 'O�',
    5 => 'Description',
    6 => 'Ajouter un �v�nement',
    7 => 'Prochain �v�nements',
    8 => 'En ajoutant cet �v�nement au calendrier vous pouvez visionnez rapidement les �v�nements qui vous int�ressent en cliquant sur "Mon Calendrier" dans le cadre Fonctions utilisateurs.',
    9 => 'Ajouter � mon calendrier',
    10 => 'Retirer de mon calendrier',
    11 => "Ajouter l'�v�nement au clendrier de {$_USER['username']}",
    12 => 'Ev�nement',
    13 => 'Commence',
    14 => 'Fini',
    15 => 'Retour au calendrier'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Ajouter un commentaire',
    2 => 'Format',
    3 => 'Se d�connecter',
    4 => 'Cr�er un compte',
    5 => 'Utilisateur',
    6 => 'Vous devez vous identifier pour pouvoir �crire un commentaire. Si vous n\'avez pas de compte vous pouvez utiliser le formulaire ci dessous afin de vous en procurer un.',
    7 => 'Votre dernier commentaire �tait il y a ',
    8 => " secondes. Vous devez attendre au moins {$_CONF['commentspeedlimit']} secondes entre chaque commentaire.",
    9 => 'Commenter',
    10 => 'CNT 10',
    11 => 'Envoyer le commentaire',
    12 => 'Veuillez obligatoirement remplir le titre et le commentaire.',
    13 => 'Informations personnelles',
    14 => 'Aper�u',
    15 => 'CNT 15',
    16 => 'Titre',
    17 => 'Erreur',
    18 => 'Remarque importante',
    19 => 'Essayez de rester autour du sujet de l\'article.',
    20 => 'Essayez de r�pondre aux commentaires des autres plut�t qu\'� l\'article lui m�me.',
    21 => 'Lisez tous les messages des autres avant d\'envoyer votre propre message afin de ne pas se r�p�ter.',
    22 => 'Veillez � utiliser un titre le plus significatif possible.',
    23 => 'Votre adresse email ne sera pas rendue publique.',
    24 => 'Utilisateur anonyme'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Profil utilisateur de',
    2 => 'Nom de connexion',
    3 => 'Nom complet',
    4 => 'Mot de passe',
    5 => 'Email',
    6 => 'Page d\'accueil',
    7 => 'Bio',
    8 => 'cl� PGP',
    9 => 'Enregistrer',
    10 => 'les 10 derniers commentaires de l\'utilisateur',
    11 => 'Aucun commentaires',
    12 => 'Pr�f�rences utilisateurs de',
    13 => 'Email temporis� la nuit',
    14 => 'Ce mot de passe a �t� g�n�r� automatiquement. Il est recommend� que vous le changiez imm�diatement. Pour ce faire, connectez-vous et cliquez sur informations personnelles dans le menu utilisateur.',
    15 => "Votre compte nomm� {$_CONF['site_name']} a �t� cr�� avec succ�s. Vous devez utiliser les informations ci-dessous pour vous conncter. Veillez � sauvegarder ses informations afin de les retrouver.",
    16 => 'Informations sur votre compte',
    17 => 'Ce compte n\'existe pas',
    18 => 'L\'adresse email semble ne pas �tre valide.',
    19 => 'L\'adresse email fournie est d�ja utilis� par un autre compte.',
    20 => 'L\'adresse email fournie ne semble pas �tre valide.',
    21 => 'Erreur',
    22 => "Enregistrez-vous avec {$_CONF['site_name']}!",
    23 => "Apres avoir cr�� votre compte {$_CONF['site_name']} vous pourrez envoyer des commentaires et d'autres �l�ments. Si vous n'avez pas de compte, Vous pourrez seulement envoyer des commentaires anonymes. Votre adresse email ne sera jamais publi� sur ce site.",
    24 => 'Votre mot de passe va vous �tre envoy� par email � l\'adresse que vous avez fournie.',
    25 => 'Avez-vous oubli� votre mot de passe?',
    26 => 'Saisissez votre nom d\'utilisateur et cliquez sur Envoyer Mot de passe, votre mot de passe vous sera envoy� par email.',
    27 => 'S\'enregistrer maintenant!',
    28 => 'Envoyer mot de passe',
    29 => 'd�connect� de',
    30 => 'connect� dans',
    31 => 'vous devez �tre connect� pour ex�cuter cette fonction',
    32 => 'Signature',
    33 => 'Ne jamais faire appara�tre publiquement',
    34 => 'C\'est votre vrai nom',
    35 => 'Entrez votre mot de passe afin de la changer',
    36 => 'Commence par http://',
    37 => 'Appliquer � vos commentaires',
    38 => 'Tout sur vous! Tous le monde pourra le voir',
    39 => 'Votre cl� puplique PGP � partager',
    40 => 'Pas d\'ic�ne de sujet',
    41 => 'En attente d\'autorisation',
    42 => 'Format de date',
    43 => 'Nombre maximum d\'articles',
    44 => 'Pas de bo�tes',
    45 => 'Pr�f�rences d\'affichage pour',
    46 => 'El�ments � exclure pour',
    47 => 'Nouvelle configuration de bo�te pour',
    48 => 'Sujets',
    49 => 'Pas d\'ic�ne dans les articles',
    50 => 'D�cocher les cases si vous n\'�tes pas inter�ss�',
    51 => 'Seulement les nouveaux articles',
    52 => 'Par d�faut',
    53 => 'Recevoir les articles du jour chaque nuit',
    54 => 'Cocher les cases pour les sujets et articles que vous ne voulez pas voire appara�tre',
    55 => 'Si vous laissez toutes les cases d�coch�es, cela signifie que vous souhaitez le comportement par d�faut. Si vous s�lectionnez au moins une case, n\'oubliez pas de s�lectionner toutes celles qui vous int�ressent car les autres vont �tre ignor�es. Les cases s�lectionn�es par d�faut apparaissent en gras.',
    56 => 'Auteur',
    57 => 'Format',
    58 => 'Ordre de tri',
    59 => 'Nombre maximum de commentaires',
    60 => 'Comment souhaitez vous que vos commentaires appara�ssent?',
    61 => 'Les plus r�cent ou les plus vieux en premier?',
    62 => '100 par d�faut',
    63 => "Votre mot de passe vous a �t� envoy� par email et ne devrais pas tarder. Suivez les instructions du message et encore merci d'utiliser {$_CONF['site_name']}",
    64 => 'Pr�f�rences des commentaires pour',
    65 => 'Essayez encore de vous connecter',
    66 => "Vous avez peut-�tre fait une faute dans le nom de votre compte. Essayer encore de vous connectez � l'aide du formulaire ci-dessous. Vous �te peut-�tre un <a href=\"{$_CONF['site_url']}/users.php?mode=new\">nouvel utilisateur</a>?",
    67 => 'Utilisateur depuis',
    68 => 'S\'en souvenir pour moi',
    69 => 'Combien de temps se souvenir de vous apr�s vous �tre connect�?',
    70 => "Personnaliser l'aspect et le contenu de {$_CONF['site_name']}",
    71 => "Une fonctionnalit� int�ressante de {$_CONF['site_name']} est que vous pouvez en personnaliser l'aspect et le contenu. Afin de pouvoir utiliser ces fonctionnalit�s vous devez vous <a href=\"{$_CONF['site_url']}/users.php?mode=new\">enregistrer</a> au pr�s de {$_CONF['site_name']}.  Vous �tes d�j� membre?  Alors utilisez le formulaire de connection dans la barre de gauche pour vous connecter!",
    72 => 'Aspect',
    73 => 'Langue',
    74 => 'Changez l\'aspect de ce site!',
    75 => 'Envoyez des email pour les sujet',
    76 => 'Si vous s�lectionner des sujets parmi ceux ci-dessous vous recevrez par email � la fin de chaque journ�e (vers 22H) les nouveaux articles concerant ces sujets. Choisissez uniquement les sujets qui vous int�ressent !',
    77 => 'Photo',
    78 => 'Ajouter votre propre photo!',
    79 => 'Cochez ici pour effacer cette photo',
    80 => 'Nom de connexion',
    81 => 'Envoyer email',
    82 => '10 derni�rs article de l\'utilisateur',
    83 => 'Statistiques de l\'utilisateur',
    84 => 'Nombre total d\'articles:',
    85 => 'Nombre total de commentaires:',
    86 => 'Chercher les articles par',
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
    105 => 'Show up in Who\'s Online block'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Aucun article � afficher',
    2 => 'Il n\'y a pas de nouveau articles � afficher. Il n\'y a peut-�tre pas de nouveaut�s pour ce sujet ou alors vos pr�f�rences sont trop restrictives.',
    3 => " pour le sujet {$topic}",
    4 => 'Article Important du jour',
    5 => 'Suivant',
    6 => 'Pr�c�dent'
);

###############################################################################
# links.php

$LANG06 = array(
    1 => 'R�f�rences web',
    2 => 'Il n\'y a aucune r�f�rence � afficher',
    3 => 'Ajouter un lien'
);

###############################################################################
# pollbooth.php

$LANG07 = array(
    1 => 'Vote Enregistr�',
    2 => 'Votre vote a �t� comptabilis�',
    3 => 'Voter',
    4 => 'Sondages existants',
    5 => 'Votes',
    6 => 'View other poll questions'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Une erreur s\'est produite lors de l\'envoi de votre message. Veuillez r�essayer.',
    2 => 'Message envoy� avec succ�s.',
    3 => 'V�rifiez que l\'adresse du champ r�pondre � est valide.',
    4 => 'Veuillez remplir les champ: Votre nom, r�ponse �, sujet et message',
    5 => 'Erreur: utilisateur inconnu.',
    6 => 'Il y a eu une erreur.',
    7 => 'Profil utilisateur de ',
    8 => 'Nom de connexion',
    9 => 'URL utilisateur',
    10 => 'Envoyer un email �',
    11 => 'Votre nom:',
    12 => 'R�pondre �:',
    13 => 'Subject:',
    14 => 'Message:',
    15 => 'les code HTML ne seront pas traduit.',
    16 => 'Envoyer Message',
    17 => 'Envoyer cette article � un ami',
    18 => 'Pour',
    19 => 'Adresse email',
    20 => 'De',
    21 => 'Adresse email',
    22 => 'Tous les champs sont obligatoires',
    23 => "Cette email vous a �t� envoy� de la part de {$from} at {$fromemail} car il pensait que vous pourriez �tre int�ress� par {$_CONF['site_url']}. Ce n'est pas un spam et l'adresse email utilis� n'est pas stok�e dans une liste d'envoi.",
    24 => 'Commentaire sur cet article �',
    25 => 'vous devez �tre connect� pour utiliser cette fonction.',
    26 => 'Ce formulaire vous permet d\'envoyer un email � tous les utilisateurs s�lectionn�s. Tous les champs sont obligatoires.',
    27 => 'Message court',
    28 => "{$from} a �crit: {$shortmsg}",
    29 => "Voici les article du jour {$_CONF['site_name']} pour ",
    30 => ' lettre d\'information de ',
    31 => 'Titre',
    32 => 'Date',
    33 => 'Lire l\'article complet � ',
    34 => 'Fin du message',
    35 => 'Sorry, this user prefers not to receive any emails.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Recherche avanc�e',
    2 => 'Mot cl�s',
    3 => 'Sujet',
    4 => 'tous',
    5 => 'type',
    6 => 'Articles',
    7 => 'Commentaires',
    8 => 'Auteurs',
    9 => 'tous',
    10 => 'Chercher',
    11 => 'R�sultats',
    12 => 'R�sultats',
    13 => 'Aucun r�sultats n\'a �t� trouv�',
    14 => 'Aucun r�sultat ne correspond � vos crit�res',
    15 => 'Veuillez r�essayer.',
    16 => 'Titre',
    17 => 'Date',
    18 => 'Auteur',
    19 => "Chercher dans toute la base de donn�es de {$_CONF['site_name']} des articles ancients ou recents.",
    20 => 'Date',
    21 => '�',
    22 => '(Format des dates YYYY-MM-DD)',
    23 => 'Actions',
    24 => 'Trouv�',
    25 => 'R�sultats pour',
    26 => 'Elements pour',
    27 => 'secondes',
    28 => 'Il n\'y a pas d\'articles ou de commentaires correspondant � vos crit�res',
    29 => 'Articles et commentaires trouv�s',
    30 => 'Aucun lien trouv�',
    31 => 'Aucun plugin trouv�',
    32 => 'Ev�nement',
    33 => 'URL',
    34 => 'Localisation',
    35 => 'Tous les jours',
    36 => 'Aucun �v�nement trouv�',
    37 => 'Ev�nements trouv�s',
    38 => 'Liens trouv�s',
    39 => 'Liens',
    40 => 'Ev�nements',
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
    1 => 'Statistiques du site',
    2 => 'Nombre d\'actions',
    3 => 'Nombre d\'articles',
    4 => 'Nombre de sondages',
    5 => 'Nombre de liens',
    6 => 'Nombre d\'�v�nements',
    7 => 'Classement des articles les plus regard�s',
    8 => 'Titre d\'article',
    9 => 'Visionnages',
    10 => 'Soit il n\'y a pas d\'article sur ce site soit personne ne les as encore vus',
    11 => 'Articles les plus comment�s',
    12 => 'Commentaires',
    13 => 'Soit il n\'y a pas d\'article sur ce site soit aucun commentaires n\'a encore �t� fait.',
    14 => 'Sondages les plus renseign�s',
    15 => 'Questions de sondages',
    16 => 'Votes',
    17 => 'Il n\'y a aucun sondages ou alors aucun votes enregistr�',
    18 => 'Liens les plus utilis�s',
    19 => 'Liens',
    20 => 'Actions',
    21 => 'Soit il n\'y a aucun lien soit personne n\'a encore cliqu� dessus',
    22 => 'Articles les plus envoy�s par mail',
    23 => 'Emails',
    24 => 'Personne n\'a encore envoy� d\'article par mail'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'Sujet en relation',
    2 => 'Envoyer cet article � un ami',
    3 => 'Version imprimable',
    4 => 'Option des articles'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => "Pour envoyer un {$type} vous devez vous identifier.",
    2 => 'Nom de connexion',
    3 => 'Nouvel utilisateur',
    4 => 'Envoyer un �v�nement',
    5 => 'Envoyer un lien',
    6 => 'Envoyer un article',
    7 => 'Identification requise',
    8 => 'Envoyer',
    9 => 'Veuillez remplir tous les champs et v�rifier � deux fois les informations.',
    10 => 'Titre',
    11 => 'Lien',
    12 => 'D�but',
    13 => 'Fin',
    14 => 'Localisation',
    15 => 'Description',
    16 => 'Si autre, pr�cisez',
    17 => 'Cat�gorie',
    18 => 'Autre',
    19 => 'Lisez en premier',
    20 => 'Erreur: cat�gorie manquante',
    21 => 'Si vous s�lectionnez "Autre" veuillez fournir une cat�gorie',
    22 => 'Erreur: champs manquants',
    23 => 'Veuillez remplir tous les champs du formulaire. Ils sont tous obligatoires.',
    24 => 'Proposition enregistr�e',
    25 => "Vos propositions {$type} ont �t� sauv�es avec succ�s.",
    26 => 'Vitesse limite',
    27 => 'utilisateur',
    28 => 'Sujet',
    29 => 'Article',
    30 => 'Votre derni�re proposition �tait il y a',
    31 => " secondes. Vous devez attendre au moins {$_CONF['speedlimit']} secondes entre chaque propositions",
    32 => 'Aper�u',
    33 => 'Aper�u de l\'article',
    34 => 'Se d�connecter',
    35 => 'les balises HTML ne sont pas autoris�es',
    36 => 'Format',
    37 => "Proposer un �v�nement � {$_CONF['site_name']} va mettre votre �v�nement dans le calendrier g�n�ral. Les utilisateurs pourront alors ajouter votre �v�nement dans leur calendrier personnel. Cette fonctionnalit� ne doit pas servir aux anniversaires. Apr�s avoir envoy� votre �v�nement il sera ou non approuv� par l'administrateur et appara�tra ou non dans le calendrier g�n�ral.",
    38 => 'Ajouter l\'�v�nement �',
    39 => 'Calendrier g�n�ral',
    40 => 'Calendrier personnel',
    41 => 'fin',
    42 => 'd�but',
    43 => 'Tous les jours � �v�nement',
    44 => 'Adresse 1',
    45 => 'Adresse 2',
    46 => 'Ville',
    47 => 'R�gion',
    48 => 'Code postal',
    49 => 'Type d\'�v�nement',
    50 => 'Modifier le type',
    51 => 'Localisation',
    52 => 'Supprimer',
    53 => 'Cr�er un compte'
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
    4 => 'Utilisateur:',
    5 => 'Mot de passe:',
    6 => 'Toutes tentatives d\'acc�s � cette portion du site est enregistr�e et analys�e.<br>Cette page est r�serv�e aux personnes autoris�es.',
    7 => 'Connexion'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Droits insuffisants',
    2 => 'Vous n\'avez pas les droits n�cessaires pour modifier ce cadre',
    3 => 'Editeur de cadre',
    4 => 'CNT 4',
    5 => 'titre du cadre',
    6 => 'sujet',
    7 => 'tous',
    8 => 'niveau de s�curit� du cadre',
    9 => 'Ordre du cadre',
    10 => 'type du cadre',
    11 => 'Cadre Portail',
    12 => 'Cadre Normal',
    13 => 'Cadre portail d\'option',
    14 => 'URL RDF',
    15 => 'Derni�re MAJ RDF',
    16 => 'Cadre normal d\'option',
    17 => 'Contenu du cadre',
    18 => 'Veuillez remplir les champs: titre, niveau de s�curit� et contenu du cadre',
    19 => 'Contr�leur de cadre',
    20 => 'Cadre titre',
    21 => 'Cadre niv. sec.',
    22 => 'Cadre type',
    23 => 'Cadre ordre',
    24 => 'Cadre sujet',
    25 => 'Cliquez sur le lien ci-dessous pour modifier ou supprimer un cadre.  Cliquez sur le lien nouveau cadre pour cr�er un nouveau cadre.',
    26 => 'Cadre d\'affichage',
    27 => 'Cadre PHP',
    28 => 'Option du cadre PHP',
    29 => 'Cadre fonction',
    30 => 'Si vous voulez que l\'un de vos cadres utilise du PHP, saisissez le nom de la fonction � utiliser.  Le nom de la fonction doit commencer par "phpblock_" (ex: phpblock_getweather).  Si ce n\'est pas le cas, votre fonction NE SERA PAS appell�e.  Nous faisons �a pour des raisons de s�curit�.  Ne mettez pas de parenth�ses vides "()" apr�s le nom de votre fonction.  Enfin, nous vous recommandons de mettre tout le code des cadre PHP dans /path/to/geeklog/system/lib-custom.php.  Cela permettera de garder votre code m�me apr�s une mise � jour de geeklog.',
    31 => 'Erreur dans le cadre PHP.  La fonction, $function, n\'existe pas.',
    32 => 'Erreur: champs manquant',
    33 => 'Vous devez mettre l\'URL dans le fichier .rdf pour le cadre portail.',
    34 => 'Vous devez renseigner le titre et la fonction du cadre PHP.',
    35 => 'Vous devez entrer le titre et le contenu du cadre normal.',
    36 => 'Vous devez entrer le contenu pour le cadre d\'affichage.',
    37 => 'Nom erron� dans la fonction du cadre PHP',
    38 => 'Les fonctions des cadres PHP doivent commencer par \'phpblock_\' (ex: phpblock_getweather).  Le pr�fixe \'phpblock_\' est n�cessaire pour des raisons de s�curit� qui emp�che l\'ex�cution de code arbitraire.',
    39 => 'C�t�',
    40 => 'Gauche',
    41 => 'Droit',
    42 => 'Vous devez saisir l\'ordre et le niveau de s�curit� pour les cadres par d�faut de geeklog',
    43 => 'Accueil seulement',
    44 => 'Acc�s interdit',
    45 => "Vous essayez d'acc�der � un cadre auquel vous n'avez pas le droit.  Cette tentative est enregistr�e. Veuillez <a href=\"{$_CONF['site_admin_url']}/block.php\">retourner � la page de controle des cadres</a>.",
    46 => 'Nouveau Cadre',
    47 => 'Accueil admin',
    48 => 'Nom du cadre',
    49 => ' (pas d\'espace et doit �tre unique)',
    50 => 'URL d\'aide',
    51 => 'http:// inclus',
    52 => 'laisser � vide pour ne pas afficher l\'icone d\'aide',
    53 => 'Activ�',
    54 => 'enregistrer',
    55 => 'annuler',
    56 => 'supprimer',
    57 => 'Move Block Down',
    58 => 'Move Block Up',
    59 => 'Move block to the right side',
    60 => 'Move block to the left side'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => 'Editeur d\'�v�nement',
    2 => 'CNT 2',
    3 => 'titre',
    4 => 'URL',
    5 => 'd�but',
    6 => 'fin',
    7 => 'localisation',
    8 => 'description',
    9 => '(http:// comprid)',
    10 => 'vous devez s�lectionner une date, une heure, une description et une localisation!',
    11 => 'Contr�leur d\'�v�nement',
    12 => 'Pour supprimer ou modifier un �v�nement, cliquez sur le bouton ci-dessous. Pour cr�er un nouvel �v�nement cliquez sur nouvel �v�nement.',
    13 => 'titre',
    14 => 'd�but',
    15 => 'fin',
    16 => 'Acc�s interdit',
    17 => "vous essayez d'acc�der � un �v�nement auquel vous n'avez pas les droits. Cette tentative a �t� enregistr�e. Retournez � <a href=\"{$_CONF['site_admin_url']}/event.php\">la page d'aministration des �v�nements</a>.",
    18 => 'Nouvel Ev�nement',
    19 => 'Page de l\'administrateur',
    20 => 'enregistrer',
    21 => 'annuler',
    22 => 'supprimer'
);

###############################################################################
# admin/link.php

$LANG23 = array(
    1 => 'Editeur de liens',
    2 => 'CNT 2',
    3 => 'Titre',
    4 => 'URL',
    5 => 'Cat�gorie',
    6 => '(http:// inclus)',
    7 => 'Autre',
    8 => 'Nombre de s�lection',
    9 => 'Description',
    10 => 'Vous devez saisir un titre, une URL et une description.',
    11 => 'Contr�leur de lien',
    12 => 'Cliquez sur le lien ci-dessous pour modifier ou supprimer un lien.  Cliquez sur Nouveau Lien pour cr�er un lien.',
    13 => 'Titre',
    14 => 'Cat�gorie',
    15 => 'URL',
    16 => 'Acc�s interdit',
    17 => "Vous essayez d'acc�der � un lien auquel vous n'avez pas les droits.  Cette tentative est enregistr�e. Veuillez <a href=\"{$_CONF['site_admin_url']}/link.php\">� la page de controle des liens</a>.",
    18 => 'Nouveau lien',
    19 => 'Accueil Admin',
    20 => 'Si autre, pr�cisez',
    21 => 'enregistrer',
    22 => 'annuler',
    23 => 'supprimer'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Articles pr�c�dents',
    2 => 'Articles suivants',
    3 => 'Mode',
    4 => 'Format',
    5 => 'Editeur d\'articles',
    6 => 'Il n\'y a pas d\'articles dans le syst�me',
    7 => 'Auteur',
    8 => 'Enregistrer',
    9 => 'Aper�u',
    10 => 'Annuler',
    11 => 'Supprimer',
    12 => '',
    13 => 'Titre',
    14 => 'Sujet',
    15 => 'Date',
    16 => 'Texte d\'intro',
    17 => 'Texte int�gral',
    18 => 'Hits',
    19 => 'Commentaires',
    20 => '',
    21 => '',
    22 => 'Liste des articles',
    23 => 'Pour modifier ou supprimer un article, cliquez sur son num�ro. Pour visionner un article, cliquez sur le titre de l\'article. Pour cr�er un nouvel article, cliquez sur le bouton �crire un article.',
    24 => '',
    25 => '',
    26 => 'Aper�u de l\'article',
    27 => '',
    28 => '',
    29 => '',
    30 => 'File Upload Errors',
    31 => 'Veuillez renseigner l\'auteur, le titre et le texte d\'introduction.',
    32 => 'T�te d\'affiche',
    33 => 'Il ne peut y avoir qu\'un seul article en t�te d\'affiche',
    34 => 'Brouillon',
    35 => 'Oui',
    36 => 'Non',
    37 => 'Plus sur',
    38 => 'Plus de',
    39 => 'Emails',
    40 => 'Acc�s refus�',
    41 => "Vous essayez d'acc�der � un article auqule vous n'avez pas droit.  Cette tentative est enregistr�e.  Vous pouvez voir cet article en lecture seule uniquement. Veuillez <a href=\"{$_CONF['site_admin_url']}/story.php\">retourner sur la page de contr�le des article</a> lorsque vous aurez fini.",
    42 => "Vous essayez d'acc�der � un article auquel vous n'avez pas droit.  Cette tentative est enregistr�e.  Veuillez <a href=\"{$_CONF['site_admin_url']}/story.php\">retourner � la page de contr�le des articles</a>.",
    43 => 'Nouvel article',
    44 => 'Accueil Admin',
    45 => 'Acc�s',
    46 => '<b>REMARQUE:</b> si vous indiquez une date future, cet article n\'appara�tra qu\'� partir de cette date. Cela signifie aussi que l\'article sera ignor� des recherches et des statistiques.',
    47 => 'Images',
    48 => 'image',
    49 => 'droite',
    50 => 'gauche',
    51 => 'Pour ajouter une des images que vous avez fournies vous devez ins�rer un texte sp�cial dans votre article. Vous devez ins�rer [imageX], [imageX_right] ou [imageX_left] o� X est le num�ro de l\'image que vous avez fournie.  REMARQUE: vous devez utiliser toutes les images fournies.  Si vous ne le faites pas vous ne pourrez pas enregistrer votre article.<BR><P><B>APERCU</B>: lors de l\'utilisation d\'images il est pr�f�rables de faire un brouillon plut�t que d\'utiliser la fonction d\'apercu.  Utilisez le bouton d\'apercu uniquement lorsqu\'il n\'y a pas d\'image.',
    52 => 'Supprimer',
    53 => 'n\'est pas utilis�e.  Vous devez ins�rer l\'image dans le texte de votre article avant de l\'enregistrer.',
    54 => 'Image fournie non utilis�e',
    55 => 'L\'erreur suivante est apparue lors de l\'enregistrement de votre article.  Veuillez corriger ces erreurs et r�essayer',
    56 => 'Montrer l\'ic�ne',
    57 => 'View unscaled image'
);

###############################################################################
# admin/poll.php

$LANG25 = array(
    1 => 'Mode',
    2 => 'Please enter a question and at least one answer.',
    3 => 'Sondage cr��',
    4 => "Sondage {$qid} enregistr�",
    5 => 'Modifier sondage',
    6 => 'N� Sondage',
    7 => '(ne pas utiliser d\'espaces)',
    8 => 'Appara�t sur la page d\'accueil',
    9 => 'Question',
    10 => 'R�ponses / Votes',
    11 => "Une erreur s'est produite lors de l'obtention des r�ponses du sondage {$qid}",
    12 => "Une erreur s'est produite lors de l'obtention des questions du sondage {$qid}",
    13 => 'Nouveau Sondage',
    14 => 'enregistrer',
    15 => 'annuler',
    16 => 'supprimer',
    17 => 'Please enter a Poll ID',
    18 => 'Liste des sondages',
    19 => 'Cliquez sur un sondage pour le modifier ou le supprimer.  Cliquez sur Nouveau Sondage pour cr�er un sondage.',
    20 => 'Votants',
    21 => 'Acc�s interdit',
    22 => "vous essayez d'acc�der � un sondage auquel vous n'avez pas droit.  Cette tentative est enregistr�e. Veuillez <a href=\"{$_CONF['site_admin_url']}/poll.php\">retourner � la page de contr�le des sondages</a>.",
    23 => 'Nouveau Sondage',
    24 => 'Accueil Admin',
    25 => 'Oui',
    26 => 'Non'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Editeur de sujet',
    2 => 'Num�ro',
    3 => 'Nom',
    4 => 'Image',
    5 => '(ne pas utiliser d\'espaces)',
    6 => 'Supprimer un sujet supprimera tous les articles et cadres en relations avec celui-ci',
    7 => 'Veuillez renseigner le num�ro et le nom du sujet.',
    8 => 'Contr�leur de sujet',
    9 => 'Cliquez sur un sujet pour le modifier ou le supprimer.  Cliquez sur le bouton Nouveau Sujet � gauche pour cr�er un sujet. Vos droits d\'acc�s envers chaque sujet apparaissent entre parenth�ses.',
    10 => 'Ordre de tri',
    11 => 'Articles/Page',
    12 => 'Acc�s interdit',
    13 => "vous essayez d'acc�der � un sujet auquel vous n'avez pas droit.  Cette tentative est enregistr�e. Veuillez <a href=\"{$_CONF['site_admin_url']}/topic.php\">retourner � la page de contr�le des sujets</a>.",
    14 => 'M�thode de tri',
    15 => 'alphab�tique',
    16 => 'd�faut:',
    17 => 'Nouveau Sujet',
    18 => 'Accueil Admin',
    19 => 'Enregistrer',
    20 => 'Annuler',
    21 => 'Supprimer',
    22 => 'Default',
    23 => 'make this the default topic for new story submissions',
    24 => '(*)'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Editeur d\'utilisateur',
    2 => 'Num�ro',
    3 => 'Nom de connexion',
    4 => 'Nom complet',
    5 => 'Mot de passe',
    6 => 'Niveau de s�curit�',
    7 => 'Adresse email',
    8 => 'Page d\'accueil',
    9 => '(ne pas utiliser d\'espaces)',
    10 => 'Veuillez renseigner le nom de connexion, le nom complet, le nom complet et l\'adresse email.',
    11 => 'Contr�leur d\'utilisateurs',
    12 => 'Cliquez sur un utilisateur pour le modifier ou le supprimer.  Cliquez sur le bouton Nouvel utilisateur � gauche pour cr�er un utilisateur. Vous pouvez faire des recherches simple en entrant une partie du nom de connexion, du nom complet ou de l\'adresse email (ex:*son* ou *.edu) dans le formulaire ci-dessous.',
    13 => 'Niv. Sec.',
    14 => 'Date d\'enregistrement',
    15 => 'Nouvel Utilisateur',
    16 => 'Accueil Admin',
    17 => 'Changer le mot de passe',
    18 => 'Annuler',
    19 => 'Supprimer',
    20 => 'Enregistrer',
    21 => 'Le nom de connexion est d�j� utilis�.',
    22 => 'Erreur',
    23 => 'Ajout par lot',
    24 => 'Importation par lot d\'utilisateurs',
    25 => 'vous pouvez importer un lot d\'utilisateur dans geeklog.  Les champ du fichier d\'import doivent �tre s�par�s par une tabulation. Ils doivent appara�tre dans l\'ordre suivant: Nom complet, nom de connexion, adresse email.  Chaque utilisateur import� sera averti par email et aura un mot de passe auto-g�n�r�.  Il ne doit y avoir qu\'un seul utilisateur par ligne.  Ne pas respecter ces consignes peut entra�ner des d�gat qui ne seront r�parables que manuellement alors redoublez de vigilance!',
    26 => 'Chercher',
    27 => 'Nb r�sultats max',
    28 => 'Coche la case pour supprimer la photo',
    29 => 'Chemin',
    30 => 'Importer',
    31 => 'Nouveaux Utilisateurs',
    32 => 'Traitement termin�. $successes utilisateurs ont �t� import�s et $failures sont tomb�s en erreur',
    33 => 'envoyer',
    34 => 'Erreur: Vous devez pr�ciser un fichier � charger.',
    35 => 'Last Login',
    36 => '(never)'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Valider',
    2 => 'Supprimer',
    3 => 'Modifier',
    4 => 'Profil',
    10 => 'Titre',
    11 => 'D�but',
    12 => 'URL',
    13 => 'Cat�gorie',
    14 => 'Date',
    15 => 'Sujet',
    16 => 'Utilisateur',
    17 => 'Nom Complet',
    18 => 'Email',
    34 => 'Commandes et Contr�les',
    35 => 'Soumissions d\'articles',
    36 => 'Soumission de liens',
    37 => 'Soumission d\'�v�nements',
    38 => 'Envoyer',
    39 => 'Il n\'y a aucune soumission � administrer pour le moment',
    40 => 'Soumissions utilisateur'
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
    8 => 'Ajouter un �v�nement',
    9 => '�v�nement geeklog',
    10 => 'Ev�nements pour',
    11 => 'Calendrier g�n�ral',
    12 => 'Calendrier personnel',
    13 => 'Janvier',
    14 => 'F�vrier',
    15 => 'Mars',
    16 => 'Avril',
    17 => 'Mai',
    18 => 'Juin',
    19 => 'Juillet',
    20 => 'Ao�t',
    21 => 'Septembre',
    22 => 'Octobre',
    23 => 'Novembre',
    24 => 'D�cembre',
    25 => 'Retour � ',
    26 => 'tous les jours',
    27 => 'semaine',
    28 => 'Calendrier personnel de ',
    29 => 'Calendrier public',
    30 => 'Supprimer l\'�v�nement',
    31 => 'Ajouter',
    32 => 'Ev�nement',
    33 => 'Date',
    34 => 'Heure',
    35 => 'Ajout rapide',
    36 => 'Envoyer',
    37 => 'D�sol�, le calendrier personnel n\'est pas activ�',
    38 => 'Editeur d\'�v�nements personnels',
    39 => 'Jour',
    40 => 'Semaine',
    41 => 'Mois'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "Envoyer un mail aux utilisateurs de {$_CONF['site_name']}",
    2 => 'De',
    3 => 'Adresse de r�ponse',
    4 => 'Sujet',
    5 => 'Message',
    6 => 'A:',
    7 => 'Tous les utilisateurs',
    8 => 'Admin',
    9 => 'Options',
    10 => 'HTML',
    11 => 'message urgent!',
    12 => 'Envoyer',
    13 => 'Effacer',
    14 => 'Ignorer les pr�f�rences utilisateurs',
    15 => 'Erreur lors de l\'envoi d\'un message �: ',
    16 => 'Message envoy� avec succ�s �: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Envoyer un autre message</a>",
    18 => 'A',
    19 => 'Remarque: si vous voulez envoyer un message � tous les utilisateurs, utilisez le group Logged-in dans le champ A.',
    20 => "<successcount> messages ont �t� envoy�s avec succ�s et <failcount> n'ont pas pu �tre envoy�s.  Vous trouverez le d�tail de chaque tentative ci-dessous.  Vous pouvez �galement <a href=\"{$_CONF['site_admin_url']}/mail.php\">envoyer un autre message</a> ou <a href=\"{$_CONF['site_admin_url']}/moderation.php\">revenir � la page d'administration</a>.",
    21 => 'Rat�s',
    22 => 'R�ussis',
    23 => 'pas d\'�chec',
    24 => 'pas de succ�s',
    25 => '-- Choisir un groupe --',
    26 => 'Remplissez tous les champs et choississez un groupe parmis la liste.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Installer des plugin peut causer des domages � geeklog.  Il est important de n\'installer que des plugins provenant de <a href="http://www.geeklog.net" target="_blank">Geeklog</a> car nous les testons et les approuvons pour plusieurs syst�mes.  Installer des plugins requiert l\'ex�cution de plusieurs commandes syst�mes qui peuvent poser des probl�mes de s�curit� particuli�rement si vous utilisez des plugin provenant de tierse partie.  Vous �tes averti des domages que peut causer l\'installation d\'un plugin.  En d\'autres termes, vous installez des plugin � vos propres risques.  Les instructions d\'installation des plugins sont incluses dans chaque plugin.',
    2 => 'Instructions d\'installation d\'un plugin',
    3 => 'Formulaire d\'installation d\'un plugin',
    4 => 'Fichier de plugin',
    5 => 'Liste de plugins',
    6 => 'Attention: plugin d�j� install�!',
    7 => 'Le plugin que vous essayer d\'installer existe d�j�.  Veuillez supprimer le plugin avant de le r�installer.',
    8 => 'Test de compatibilit� du plugin �chou�',
    9 => 'Ce plugin requiert une version plus r�cente de geeklog. Vous pouvez mettre � jour votre <a href="http://www.geeklog.net">Geeklog</a> ou obtenir une autre version du plugin.',
    10 => '<br><b>Aucun plugin n\'est actuellement install�.</b><br><br>',
    11 => 'Cliquez sur le num�ro du plugin pour le modifier ou le supprimer. Pour en savoir d\'avantage sur les plugins, cliquez sur le nom du plugin et vous serez dirig� vers le site web du plugin. Pour installer ou mettre � jour un plugin veuillez vous r�f�rer � la documentation du plugin.',
    12 => 'Aucun nom de plugin n\'a �t� pass� � plugineditor()',
    13 => 'Editeur de plugin',
    14 => 'Nouveau plugin',
    15 => 'Accueil Admin',
    16 => 'Nom du plugin',
    17 => 'Version du plugin',
    18 => 'Version de Geeklog',
    19 => 'Activ�',
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
    31 => 'Etes-vous s�r de vouloir supprimer ce plugin ?  Toutes les donn�es, fichiers et structures utilis�s par ce plugin seront d�truits.  Si vous �tes s�r cliquez sur le bouton Supprimer.'
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
    1 => "Votre mot de passe vous a �t� envoy� par mail et devrait arriver d'un moment � l'autre. Suivez les instructions incluses dans le message et encore merci d'utiliser {$_CONF['site_name']}",
    2 => "Merci de proposer un article � {$_CONF['site_name']}.  Il a �t� envoy� � notre �quipe qui l'aprouvera ou non. Dans la cas positif votre article sera publi�.",
    3 => "Merci de proposer un lien � {$_CONF['site_name']}.  Il a �t� envoy� � notre �quipe qui l'aprouvera ou non.  Dans le cas positif votre lien sera publi� <a href={$_CONF['site_url']}/links.php>ici</a>.",
    4 => "Merci de proposer un �v�nement � {$_CONF['site_name']}.  Il a �t� envoy� � notre �quipe qui l'aprouvera ou non.  Dans le cas positif votre �v�nement sera publi� <a href={$_CONF['site_url']}/calendar.php>ici</a>.",
    5 => 'Vos informations ont �t� mises � jour avec succ�s.',
    6 => 'Vos pr�f�rences d\'affichages ont �t� mises � jour avec succ�s.',
    7 => 'Vos pr�f�rences de commentaires ont �t� mises � jour avec succ�s.',
    8 => 'Vous avez �t� d�connect� avec succ�s.',
    9 => 'Votre article a �t� enregistr� avec succ�s.',
    10 => 'L\'article a �t� supprim� avec succ�s.',
    11 => 'Votre cadre a �t� enregistr� avec succ�s.',
    12 => 'Le cadre a �t� supprim� avec succ�s.',
    13 => 'Votre sujet a �t� enregistr� avec succ�s.',
    14 => 'Le sujet et tous ses articles ainsi que ses cadres ont �t� supprim�s avec succ�s.',
    15 => 'Votre lien a �t� enregistr� avec succ�s.',
    16 => 'Le lien a �t� supprim� avec succ�s.',
    17 => 'Votre �v�nement a �t� enregistr� avec succ�s.',
    18 => 'L\'�v�nement a �t� supprim� avec succ�s.',
    19 => 'Votre sondage a �t� enregistr� avec succ�s.',
    20 => 'Le sondage a �t� supprim� avec succ�s.',
    21 => 'Le nouvel utilisateur a �t� enregistr� avec succ�s.',
    22 => 'L\'utilisateur a �t� supprim� avec succ�s.',
    23 => 'Erreur durant l\'ajout d\'un �v�nement � votre calendrier. Aucun identifiant d\'�v�nement n\'a �t� transmis.',
    24 => 'L\'�v�nement a �t� enregistr� dans votre calendrier.',
    25 => 'Vous devez vous connecter pour consulter votre calendrier',
    26 => 'L\'�v�nement a �t� supprim� de votre calendrier avec succ�s.',
    27 => 'Message envoy� avec succ�s.',
    28 => 'Le plugin a �t� supprim� avec succ�s.',
    29 => 'Les calendriers personnels ne sont pas activ�s.',
    30 => 'Acc�s Interdit',
    31 => 'Vous n\'avez pas acc�s � la page d\'adminisrtation des articles.  Toutes les tentatives d\'acc�s � des parties non autoris�es sont enregistr�es.',
    32 => 'Vous n\'avez pas acc�s � la page d\'administration des sujets.  Toutes les tentatives d\'acc�s � des parties non autoris�es sont enregistr�es.',
    33 => 'Vous n\'avez pas acc�s � la page d\'administration des cadres.  Toutes les tentatives d\'acc�s � des parties non autoris�es sont enregistr�es.',
    34 => 'Vous n\'avez pas acc�s � la page d\'administration des liens.  Toutes les tentatives d\'acc�s � des parties non autoris�es sont enregistr�es.',
    35 => 'Vous n\'avez pas acc�s � la page d\'administration des �v�nements.  Toutes les tentatives d\'acc�s � des parties non autoris�es sont enregistr�es.',
    36 => 'Vous n\'avez pas acc�s � la page d\'administration des sondages.  Toutes les tentatives d\'acc�s � des parties non autoris�es sont enregistr�es.',
    37 => 'Vous n\'avez pas acc�s � la page d\'administration des utilisateurs.  Toutes les tentatives d\'acc�s � des parties non autoris�es sont enregistr�es.',
    38 => 'Vous n\'avez pas acc�s � la page d\'administration des plugins.  Toutes les tentatives d\'acc�s � des parties non autoris�es sont enregistr�es.',
    39 => 'Vous n\'avez pas acc�s � la page d\'administration des mails.  Toutes les tentatives d\'acc�s � des parties non autoris�es sont enregistr�es.',
    40 => 'Message du syst�me',
    41 => 'Vous n\'avez pas acc�s � la page d\'administration des substitutions de mots.  Toutes les tentatives d\'acc�s � des parties non autoris�es sont enregistr�ss.',
    42 => 'Votre mot a �t� enregistr� avec succ�s.',
    43 => 'Le mot a �t� supprim� avec succ�s.',
    44 => 'Le plugin a �t� install� avec succ�s!',
    45 => 'Le plugin a �t� supprim� avec succ�s.',
    46 => 'Vous n\'avez pas acc�s � l\'utilitaire de sauvegarde de la base de donn�es.  Toutes les tentatives d\'acc�s � des parties non autoris�es sont enregistr�es.',
    47 => 'Cette fonctionnalit� ne fonctionne que sur *nix.  Si vous utilisez *nix alors votre cache a �t� vid� avec succ�s. Si vous utilisez Windows, vous devez chercher les fichiers adodb_*.php et les supprimer � la main.',
    48 => "Merci d'avoir demand� votre compte utilisateur pour {$_CONF['site_name']}. Il a �t� envoy� � notre �quipe qui l'aprouvera ou non. Dans le cas positif, votre mot de passe vous sera envoy� par email � l'adresse que vous avez fournie.",
    49 => 'Votre groupe a �t� enregistr� avec succ�s.',
    50 => 'Le groupe a �t� supprim� avec succ�s.',
    51 => 'This username is already in use. Please choose another one.',
    52 => 'The email address provided does not appear to be a valid email address.',
    53 => 'Your new password has been accepted. Please use your new password below to log in now.',
    54 => 'Your request for a new password has expired. Please try again below.',
    55 => 'An email has been sent to you and should arrive momentarily. Please follow the directions in the message to set a new password for your account.',
    56 => 'The email address provided is already in use for another account.',
    57 => 'Your account has been successfully deleted.',
    58 => 'Your feed has been successfully saved.',
    59 => 'The feed has been successfully deleted.'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Acc�s',
    'ownerroot' => 'Propri�taire/Admin',
    'group' => 'Groupe',
    'readonly' => 'Lecture seule',
    'accessrights' => 'Droits d\'acc�s',
    'owner' => 'Propri�taire',
    'grantgrouplabel' => 'Autorisation au dela du groupe d\'�dition',
    'permmsg' => 'REMARQUE: les membres sont tous les utilisateurs identifi�s et les anonymes sont tous les autres.',
    'securitygroups' => 'Groupe de s�curit�',
    'editrootmsg' => "Except� si vous �tes administrateur, vous ne pouvez pas modifier un autre administrateur.  Vous pouvez modifier tous les utilisateurs except�s les administrateur. Toutes tentatives de modifications d'un administrateur sont enregistr�es.  Retournez sur la <a href=\"{$_CONF['site_admin_url']}/user.php\">page d'administration</a>.",
    'securitygroupsmsg' => 'S�lectionner les cases des groupes auxquels l\'utilisateur appartient',
    'groupeditor' => 'Editeur de groupe',
    'description' => 'Description',
    'name' => 'Nom',
    'rights' => 'Droits',
    'missingfields' => 'Champs manquants',
    'missingfieldsmsg' => 'Vous devez saisir un nom et une description',
    'groupmanager' => 'Administrateur de groupe',
    'newgroupmsg' => 'Pour modifier ou supprimer un groupe, cliquez sur le groupe ci-dessous. Pour cr�er un nouveu groupe, cliquez sur Nouveau Groupe. Les groupes natifs ne peuvent pas �tre supprim�s car ils sont utilis�s par le syst�me.',
    'groupname' => 'Nom du groupe',
    'coregroup' => 'Groupe syst�me',
    'yes' => 'Oui',
    'no' => 'Non',
    'corerightsdescr' => "Ce groupe est un groupe syst�me de {$_CONF['site_name']}.  Les droits de ce groupe ne peuvent pas �tre modifi�s.  La liste ci-dessous des droits d'acc�s du groupe n'est pas modifiable.",
    'groupmsg' => 'Les droits des groupes sont hi�rarchiques.  En ajoutant un groupe � un autre vous ajoutez tous les droits de ce groupe � l\'autre.  Lorsque c\'est possible, utilisez les groupes d�ja d�finis.  Si vous avez besoin de droits sp�cifiques, vous pouvez les choisir dans la liste ci-dessous.  Pour Ajouter un groupe � celui-ci cliquez sur la case du groupe � ajouter.',
    'coregroupmsg' => "Ce groupe est un groupe syst�me de {$_CONF['site_name']}.  Les droits de ce groupe ne peuvent pas �tre modifi�s. La liste ci-dessous des groupes inclus de ce groupe n'est pas modifiable.",
    'rightsdescr' => 'Les droits suivants peuvent �tre donn�s directement au groupe OU provenir d\'un groupe inclus. Les droits sans case � cocher proviennent de groupe inclus. Les droits qui ont des cases � cocher sont donn�s directement au groupe.',
    'lock' => 'Bloquer',
    'members' => 'Membres',
    'anonymous' => 'Anonymes',
    'permissions' => 'Permissions',
    'permissionskey' => 'R = lecture, E = modification, le droit de modification implique le droit de lecture',
    'edit' => 'Modifier',
    'none' => 'Rien',
    'accessdenied' => 'Acc�s interdit',
    'storydenialmsg' => 'vous n\'avez pas le droit de lire cette article. Peut-�tre que vous n\'�tes pas membre de .  Vous pouvez <a href=users.php?mode=new>vous enregistrer</a> sur  pour obtenir un compte utilisateur!',
    'eventdenialmsg' => 'vous n\'avez pas acc�s � cet �v�nement. Peut-�tre que vous n\'�tes pas membre de .  Vous pouvez <a href=users.php?mode=new>vous enregistrer</a> sur  pour obtenir un compte utilisateur!',
    'nogroupsforcoregroup' => 'Le groupe n\'inclue aucun autre groupe',
    'grouphasnorights' => 'Le groupe n\'a pas acc�s aux fonctiones administratives',
    'newgroup' => 'Nouveau Groupe',
    'adminhome' => 'Accueil Admin',
    'save' => 'enregistrer',
    'cancel' => 'annuler',
    'delete' => 'supprimer',
    'canteditroot' => 'Vous avez essay� de modifier le groupe administrateur mais vous n\'en faites pas partie. Vous n\'avez pas acc�s � ce groupe. Veuillez contacter l\'administrateur si vous pensez que c\'est une erreur.',
    'listusers' => 'List Users',
    'listthem' => 'list',
    'usersingroup' => 'Users in group "%s"',
    'usergroupadmin' => 'User Group Administration',
    'add' => 'Add',
    'remove' => 'Remove',
    'availmembers' => 'Available Members',
    'groupmembers' => 'Group Members',
    'canteditgroup' => 'To edit this group, you have to be a member of the group. Please contact the system administrator if you feel this is an error.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => '10 dernieres sauvegardes',
    'do_backup' => 'Faire une sauvegarde',
    'backup_successful' => 'Sauvegarde de la base de donn�e effectu�e avec succ�s',
    'no_backups' => 'Aucune sauvegarde dans le syst�me',
    'db_explanation' => 'Cliquez sur le bouton ci-dessous pour effectuer une sauvegarde de votre syst�me Geeklog',
    'not_found' => "Chemin incorecte ou le fichier mysqldump n'est pas ex�cutable.<br>V�rifiez le param�tre <strong>\$_DB_mysqldump_path</strong> dans le fichier config.php.<br>Ce param�tre est actuellement positionn� � : <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Sauvegarde �chou�e: la taille du fichier �tait de 0 octets.',
    'path_not_found' => "{$_CONF['backup_path']} n'existe pas ou n'est pas un r�pertoire.",
    'no_access' => "Erreur: le r�pertoire {$_CONF['backup_path']} n'est pas accessible.",
    'backup_file' => 'Fichier de sauvegarde',
    'size' => 'Taille',
    'bytes' => 'Octets',
    'total_number' => 'Total number of backups: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Survol',
    2 => 'Contacts',
    3 => 'Ecrire un article',
    4 => 'Liens',
    5 => 'Sondages',
    6 => 'Calendrier',
    7 => 'Statistiques du site',
    8 => 'Personnaliser',
    9 => 'Chercher',
    10 => 'Recherche avanc�e'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => 'Erreur 404',
    2 => 'Le syst�me ne trouve pas <b>%s</b>.',
    3 => "<p>Le fichier que vous demandez n'existe pas. Allez � la <a href=\"{$_CONF['site_url']}\">page principale</a> ou la <a href=\"{$_CONF['site_url']}/search.php\">page de recherche</a> afin de retrouver ce que vous avez perdu."
);

###############################################################################

$LANG_LOGIN = array(
    1 => 'Vous devez vous connecter',
    2 => 'Vous devez vous identifier � l\'aide de l\'espace membre pour acc�der � cette partie du site.',
    3 => 'Accueil',
    4 => 'Nouvel utilisateur'
);

?>

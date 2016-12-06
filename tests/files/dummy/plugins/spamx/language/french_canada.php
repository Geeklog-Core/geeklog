<?php

/**
 * File: french_canada.php
 * This is the French language page for the Geeklog Spam-X Plug-in!
 * 
 * Copyright (C) 2004-2005 by the following authors:
 * Author        Tom Willett        tomw AT pigstye DOT net
 *
 * French translation provided by Alain Ponton.
 *
 * Licensed under GNU General Public License
 *
 * $Id: french_canada.php,v 1.11 2008/05/02 15:08:10 dhaun Exp $
 */

global $LANG32;

$LANG_SX00 = array(
    'inst1' => '<p>Si vous faites ce qui suit, alors tout le monde ',
    'inst2' => 'pourra voir et importer votre Liste Noire personnelle. Nous pouvons alors cr�er une base de donn�es ',
    'inst3' => 'plus efficace.</p><p>Si vous avez soumis votre site et ne d�sirez pas qu\'il reste sur cette liste ',
    'inst4' => 'envoyez un courriel �  <a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a> pour me le faire savoir. ',
    'inst5' => 'Toutes les demandes seront honor�es',
    'submit' => 'Soumettre',
    'subthis' => '� la base de donn�es centrale Spam-X',
    'secbut' => 'Ce second bouton permet de cr�er un fichier RDF afin de permettre l\'importation de votre liste.',
    'sitename' => 'Nom du Site: ',
    'URL' => 'URL vers la Liste Spam-X: ',
    'RDF' => 'URL du fichier RDF: ',
    'impinst1a' => 'Avant d\'utiliser l\'utilitaire anti-comentaires ind�sirables Spam-X pour voir et importer les listes noires personnelles des autres',
    'impinst1b' => ' sites, je vous demande d\'utiliser les deux boutons suivants. (Le dernier est obligatoire.)',
    'impinst2' => 'Le premier soumet votre site web au site Gplugs/Spam-X afin de l\'ajouter � la liste principale des ',
    'impinst2a' => 'sites partagant leur liste noire. (Note: si vous avez plusieurs sites, vous devriez en d�signer un comme site ma�tre ',
    'impinst2b' => 'et soumettre ce dernier seulement. Ceci vous permettra de mettre votre site � jour facilement tout en conservant une liste plus petite.) ',
    'impinst2c' => 'Apr�s avoir cliqu� le bouton Soumettre, utilisez le bouton [pr�c�dent] de votre navigateur pour revenir � cette page.',
    'impinst3' => 'Les donn�es suivantes seront envoy�es: (vous pouvez les modifier si n�cessaire).',
    'availb' => 'Listes Noires Disponibles',
    'clickv' => 'Cliquez pour voir la Liste Noire',
    'clicki' => 'Cliquez pour Importer la Liste Noire',
    'ok' => 'OK',
    'rsscreated' => 'Fil RSS Cr��',
    'add1' => 'Ajout� ',
    'add2' => ' entr�es de la',
    'add3' => '\' liste noire de.',
    'adminc' => 'Commandes Administration:',
    'mblack' => 'Ma Liste Noire:',
    'rlinks' => 'Liens relatifs:',
    'e3' => 'Pour ajouter les mots de la liste de Censure Geeklogs Cliquez le bouton:',
    'addcen' => 'Ajouter Liste de Censure',
    'addentry' => 'Ajouter l\'entr�e',
    'e1' => 'Pour supprimer une entr�e cliquez dessus.',
    'e2' => 'Pour ajouter une entr�e, entrez-la dans la case et cliquez Ajouter.  Les entr�es peuvent utiliser les expressions r�guli�res compl�tes de Perl.',
    'pblack' => 'Liste Noire Personnelle Spam-X',
    'conmod' => 'Configurer utilisation du module Spam-X',
    'acmod' => 'Modules Action de Spam-X',
    'exmod' => 'Modules V�rification de Spam-X',
    'actmod' => 'Modules actifs',
    'avmod' => 'Modules disponibles',
    'coninst' => '<hr' . XHTML . '>Cliquez sur un module actif pour le supprimer, cliquez sur un module disponible pour l\'ajouter.<br' . XHTML . '>Les modules sont ex�cut�s dans l\'ordre affich�.',
    'fsc' => 'Correspondance de commentaire ind�sirable trouv�e ',
    'fsc1' => ' envoy� par l\'utilisateur ',
    'fsc2' => ' adresse IP ',
    'uMTlist' => 'Mettre � jour Liste Noire principale',
    'uMTlist2' => ': Ajout� ',
    'uMTlist3' => ' entr�es et supprim�es ',
    'entries' => ' entr�es.',
    'uPlist' => 'Mettre � jour Liste Noire personnelle',
    'entriesadded' => 'entr�es ajout�es',
    'entriesdeleted' => 'entr�es supprim�es',
    'viewlog' => 'Voir fichier log Spam-X',
    'clearlog' => 'Vider fichier ',
    'logcleared' => '- fichier log Spam-X vide',
    'plugin' => 'Plugin',
    'access_denied' => 'Acc�s refus�',
    'access_denied_msg' => 'Seulement les utilisateurs Root ont acc�s � cette page.  Votre code d\'usager et votre adresse IP ont �t� enregistr�s.',
    'admin' => 'Administration Plugin',
    'install_header' => 'Installer/D�sinstaller Plugin',
    'installed' => 'Le Plugin est install�',
    'uninstalled' => 'le Plugin n\'est pas install�',
    'install_success' => 'Installation r�ussie',
    'install_failed' => 'Echec de l\'installation  -- Voyez votre le fichier d\'erreur pour en conna�tre la raison.',
    'uninstall_msg' => 'D�sinstallation du Plugin r�ussie',
    'install' => 'Installer',
    'uninstall' => 'D�sinstaller',
    'warning' => 'Attention! Plugin encore activ�',
    'enabled' => 'D�sactivez le plugin avant la d�sinstallation.',
    'readme' => 'ARR�TEZ! Avant d\'installer veuillez lire le ',
    'installdoc' => 'Document d\'installation.',
    'spamdeleted' => 'Commentaire ind�sirable supprim�',
    'foundspam' => 'Correspondance de commentaire ind�sirable trouv�e ',
    'foundspam2' => ' envoy� par l\'utilisateur ',
    'foundspam3' => ' adresse IP ',
    'deletespam' => 'Supprimer Commentaire',
    'numtocheck' => 'Nombre de commentaires � v�rifier',
    'note1' => '<p>Note: La suppression en lot a pour but de faciliter la t�che lorsque vous �tes victime d\'un',
    'note2' => ' commentaire ind�sirable et que Spam-X ne le reconna�t pas.  <ul><li>Trouvez d\'abord le(s) lien(s) ou autre ',
    'note3' => 'identificateurs de ce commentaire ind�sirable et ajoutez-le � votre liste noire personnelle.</li><li>Ensuite ',
    'note4' => 'revenez ici et ex�cutez Spam-X pour v�rifier les derniers commentaires.</li></ul><p>Les commentaires ',
    'note5' => 'sont v�rifi�s � partir des plus r�cents -- v�rifier plus de commentaires ',
    'note6' => 'n�cessite plus de temps pour la v�rification</p>',
    'masshead' => '<hr' . XHTML . '><h1 align="center">Suppression de commentaires en lot</h1>',
    'masstb' => '<hr' . XHTML . '><h1 align="center">Mass Delete Trackback Spam</h1>',
    'comdel' => ' commentaires supprim�s.',
    'initial_Pimport' => '<p>Importer Liste Noire Personnelle"',
    'initial_import' => 'Importer Liste Noire Principale Originale',
    'import_success' => '<p>Importation avec succ�s de %d entr�es dans la liste noire.',
    'import_failure' => '<p><strong>Erreur:</strong> Aucune entr�e trouv�e.',
    'allow_url_fopen' => '<p>D�sol�, la configuration de votre serveur web ne permet pas la lecture de fichiers distants (<code>allow_url_fopen</code> est d�sactiv�). Veuillez t�l�charger la liste noire de l\'adresse suivante et placez-la dans le r�pertoire "data" de Geeklog, <tt>%s</tt>, avant un nouvel essai:',
    'documentation' => 'Documentation du Plugin Spam-X',
    'emailmsg' => "Un nouveau commentaire ind�sirable a �t� envoy� � \"%s\"\nUser UID:\"%s\"\n\nContent:\"%s\"",
    'emailsubject' => 'Spam post at %s',
    'ipblack' => 'Spam-X IP Blacklist',
    'ipofurlblack' => 'Spam-X IP of URL Blacklist',
    'headerblack' => 'Spam-X HTTP Header Blacklist',
    'headers' => 'Request headers:',
    'stats_headline' => 'Spam-X Statistics',
    'stats_page_title' => 'Blacklist',
    'stats_entries' => 'Entries',
    'stats_mtblacklist' => 'MT-Blacklist',
    'stats_pblacklist' => 'Personal Blacklist',
    'stats_ip' => 'Blocked IPs',
    'stats_ipofurl' => 'Blocked by IP of URL',
    'stats_header' => 'HTTP headers',
    'stats_deleted' => 'Posts deleted as spam',
    'plugin_name' => 'Spam-X',
    'slvwhitelist' => 'SLV Whitelist'
);

// Define Messages that are shown when Spam-X module action is taken
$PLG_spamx_MESSAGE128 = 'Commentaire ind�sirable d�tect� et Commentaire ou Message supprim�.';
$PLG_spamx_MESSAGE8 = 'Commentaire ind�sirable d�tect� et Commentaire supprim�. Courriel envoy� � l\Administrateur.';

// Messages for the plugin upgrade
$PLG_spamx_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_spamx_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['spamx'] = array(
    'label' => 'Spam-X',
    'title' => 'Spam-X Configuration'
);

$LANG_confignames['spamx'] = array(
    'action' => 'Spam-X Actions',
    'notification_email' => 'Notification Email',
    'admin_override' => 'Don\'t Filter Admin Posts',
    'logging' => 'Enable Logging',
    'timeout' => 'Timeout'
);

$LANG_configsubgroups['spamx'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['spamx'] = array(
    'fs_main' => 'Spam-X Main Settings'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['spamx'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false)
);

?>
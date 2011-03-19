<?php

/**
 * File: french_france.php
 * This is the French language page for the Geeklog Spam-X Plug-in!
 * 
 * Copyright (C) 2004-2005 by the following authors:
 * Author        Tom Willett        tomw AT pigstye DOT net
 *
 * French translation provided by Alain Ponton.
 *
 * Licensed under GNU General Public License
 */

global $LANG32;

$LANG_SX00 = array(
    'inst1' => '<p>Si vous faites ce qui suit, alors tout le monde ',
    'inst2' => 'pourra voir et importer votre Liste Noire personnelle. Nous pouvons alors créer une base de données ',
    'inst3' => 'plus efficace.</p><p>Si vous avez soumis votre site et ne désirez pas qu\'il reste sur cette liste ',
    'inst4' => 'envoyez un courriel à  <a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a> pour me le faire savoir. ',
    'inst5' => 'Toutes les demandes seront honorées',
    'submit' => 'Soumettre',
    'subthis' => 'à la base de données centrale Spam-X',
    'secbut' => 'Ce second bouton permet de créer un fichier RDF afin de permettre l\'importation de votre liste.',
    'sitename' => 'Nom du Site: ',
    'URL' => 'URL vers la Liste Spam-X: ',
    'RDF' => 'URL du fichier RDF: ',
    'impinst1a' => 'Avant d\'utiliser l\'utilitaire anti-comentaires indésirables Spam-X pour voir et importer les listes noires personnelles des autres',
    'impinst1b' => ' sites, je vous demande d\'utiliser les deux boutons suivants. (Le dernier est obligatoire.)',
    'impinst2' => 'Le premier soumet votre site web au site Gplugs/Spam-X afin de l\'ajouter à la liste principale des ',
    'impinst2a' => 'sites partagant leur liste noire. (Note: si vous avez plusieurs sites, vous devriez en désigner un comme site maître ',
    'impinst2b' => 'et soumettre ce dernier seulement. Ceci vous permettra de mettre votre site à jour facilement tout en conservant une liste plus petite.) ',
    'impinst2c' => 'Après avoir cliqué le bouton Soumettre, utilisez le bouton [précédent] de votre navigateur pour revenir à cette page.',
    'impinst3' => 'Les données suivantes seront envoyées: (vous pouvez les modifier si nécessaire).',
    'availb' => 'Listes Noires Disponibles',
    'clickv' => 'Cliquez pour voir la Liste Noire',
    'clicki' => 'Cliquez pour Importer la Liste Noire',
    'ok' => 'OK',
    'rsscreated' => 'Fil RSS Créé',
    'add1' => 'Ajouté ',
    'add2' => ' entrées de la',
    'add3' => '\' liste noire de.',
    'adminc' => 'Commandes Administration:',
    'mblack' => 'Ma Liste Noire:',
    'rlinks' => 'Liens relatifs:',
    'e3' => 'Pour ajouter les mots de la liste de Censure Geeklogs Cliquez le bouton:',
    'addcen' => 'Ajouter Liste de Censure',
    'addentry' => 'Ajouter l\'entrée',
    'e1' => 'Pour supprimer une entrée cliquez dessus.',
    'e2' => 'Pour ajouter une entrée, entrez-la dans la case et cliquez Ajouter.  Les entrées peuvent utiliser les expressions régulières complètes de Perl.',
    'pblack' => 'Liste Noire Personnelle Spam-X',
    'conmod' => 'Configurer utilisation du module Spam-X',
    'acmod' => 'Modules Action de Spam-X',
    'exmod' => 'Modules Vérification de Spam-X',
    'actmod' => 'Modules actifs',
    'avmod' => 'Modules disponibles',
    'coninst' => '<hr' . XHTML . '>Cliquez sur un module actif pour le supprimer, cliquez sur un module disponible pour l\'ajouter.<br' . XHTML . '>Les modules sont exécutés dans l\'ordre affiché.',
    'fsc' => 'Correspondance de commentaire indésirable trouvée ',
    'fsc1' => ' envoyé par l\'utilisateur ',
    'fsc2' => ' adresse IP ',
    'uMTlist' => 'Mettre à jour Liste Noire principale',
    'uMTlist2' => ': Ajouté ',
    'uMTlist3' => ' entrées et supprimées ',
    'entries' => ' entrées.',
    'uPlist' => 'Mettre à jour Liste Noire personnelle',
    'entriesadded' => 'entrées ajoutées',
    'entriesdeleted' => 'entrées supprimées',
    'viewlog' => 'Voir fichier log Spam-X',
    'clearlog' => 'Vider fichier ',
    'logcleared' => '- fichier log Spam-X vide',
    'plugin' => 'Plugin',
    'access_denied' => 'Accès refusé',
    'access_denied_msg' => 'Seulement les utilisateurs Root ont accès à cette page.  Votre code d\'usager et votre adresse IP ont été enregistrés.',
    'admin' => 'Administration Plugin',
    'install_header' => 'Installer/Désinstaller Plugin',
    'installed' => 'Le Plugin est installé',
    'uninstalled' => 'le Plugin n\'est pas installé',
    'install_success' => 'Installation réussie',
    'install_failed' => 'Echec de l\'installation  -- Voyez votre le fichier d\'erreur pour en connaître la raison.',
    'uninstall_msg' => 'Désinstallation du Plugin réussie',
    'install' => 'Installer',
    'uninstall' => 'Désinstaller',
    'warning' => 'Attention! Plugin encore activé',
    'enabled' => 'Désactivez le plugin avant la désinstallation.',
    'readme' => 'ARRÊTEZ! Avant d\'installer veuillez lire le ',
    'installdoc' => 'Document d\'installation.',
    'spamdeleted' => 'Commentaire indésirable supprimé',
    'foundspam' => 'Correspondance de commentaire indésirable trouvée ',
    'foundspam2' => ' envoyé par l\'utilisateur ',
    'foundspam3' => ' adresse IP ',
    'deletespam' => 'Supprimer Commentaire',
    'numtocheck' => 'Nombre de commentaires à vérifier',
    'note1' => '<p>Note: La suppression en lot a pour but de faciliter la tâche lorsque vous êtes victime d\'un',
    'note2' => ' commentaire indésirable et que Spam-X ne le reconnaît pas.  <ul><li>Trouvez d\'abord le(s) lien(s) ou autre ',
    'note3' => 'identificateurs de ce commentaire indésirable et ajoutez-le à votre liste noire personnelle.</li><li>Ensuite ',
    'note4' => 'revenez ici et exécutez Spam-X pour vérifier les derniers commentaires.</li></ul><p>Les commentaires ',
    'note5' => 'sont vérifiés à partir des plus récents -- vérifier plus de commentaires ',
    'note6' => 'nécessite plus de temps pour la vérification</p>',
    'masshead' => '<hr' . XHTML . '><h1 align="center">Suppression de commentaires en lot</h1>',
    'masstb' => '<hr' . XHTML . '><h1 align="center">Mass Delete Trackback Spam</h1>',
    'comdel' => ' commentaires supprimés.',
    'initial_Pimport' => '<p>Importer Liste Noire Personnelle"',
    'initial_import' => 'Importer Liste Noire Principale Originale',
    'import_success' => '<p>Importation avec succès de %d entrées dans la liste noire.',
    'import_failure' => '<p><strong>Erreur:</strong> Aucune entrée trouvée.',
    'allow_url_fopen' => '<p>Désolé, la configuration de votre serveur web ne permet pas la lecture de fichiers distants (<code>allow_url_fopen</code> est désactivé). Veuillez télécharger la liste noire de l\'adresse suivante et placez-la dans le répertoire "data" de Geeklog, <tt>%s</tt>, avant un nouvel essai:',
    'documentation' => 'Documentation du Plugin Spam-X',
    'emailmsg' => "Un nouveau commentaire indésirable a été envoyé à \"%s\"\nUser UID:\"%s\"\n\nContent:\"%s\"",
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
$PLG_spamx_MESSAGE128 = 'Commentaire indésirable détecté et Commentaire ou Message supprimé.';
$PLG_spamx_MESSAGE8 = 'Commentaire indésirable détecté et Commentaire supprimé. Courriel envoyé à l\Administrateur.';

// Messages for the plugin upgrade
$PLG_spamx_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_spamx_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['spamx'] = array(
    'label' => 'Spam-X',
    'title' => 'Spam-X Configuration'
);

$LANG_confignames['spamx'] = array(
    'spamx_action' => 'Spam-X Actions',
    'notification_email' => 'Notification Email',
    'logging' => 'Enable Logging',
    'timeout' => 'Timeout'
);

$LANG_configsubgroups['spamx'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['spamx'] = array(
    'tab_main' => 'Spam-X Main Settings'
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

<?php

###############################################################################
# italian.php
# Traduzione italiana per GeekLog!
# Special thanks to Mischa Polivanov for his work on this project
#
# Copyright (C) 2002 quess65 webmaster@dynamikteam.net
# Copyright (C) 2005 magomarcelo magomarcelo@gmail.com magomarcelo.blogspot.com
#
# Questo programma è free software; puoi ridistribuire e/o
# modificarlo sotto i termini della GNU General Public License
# come pubblicato da Free Software Foundation; dalla versione 2
# della Licenza, o (come preferisci) a qualsiasi delle versioni
# successive.
#
# Questo programma è distribuito con la speranza sia utile,
# ma SENZA NESSUNA GARANZIA; senza qualsiasi garanzia implicita di
# COMMERCIABILITA o USO PER SCOPI PARTICOLARI. Vedi la
# GNU General Public License per ulteriori dettagli.
#
# Dovresti aver ricevuto una copia della GNU General Public License
# insieme a questo programma; altrimenti scrivi a Free Software
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
    1 => 'Inviato da:',
    2 => 'continua ->',
    3 => 'commenti',
    4 => 'Modifica',
    5 => 'Vota',
    6 => 'Risultati',
    7 => 'Risultati vot.',
    8 => 'voti',
    9 => 'Funzioni Ammin:',
    10 => 'Inserimenti',
    11 => 'Articoli',
    12 => 'Blocchi',
    13 => 'Argomenti',
    14 => 'Links',
    15 => 'Eventi',
    16 => 'Sondaggi',
    17 => 'Utenti',
    18 => 'SQL Query',
    19 => 'Esci',
    20 => 'Informazioni utente:',
    21 => 'Nome Utente',
    22 => 'ID Utente',
    23 => 'Livello di sicurezza',
    24 => 'Anonimo',
    25 => 'Invia Commento',
    26 => 'I seguenti commenti sono propriet&agrave; di chi li ha inviati. Questo sito non &egrave; responsabile dei contenuti degli stessi.',
    27 => 'Inserimenti pi&ugrave; recenti',
    28 => 'Elimina',
    29 => 'Nessun commento.',
    30 => 'Articoli Meno Recenti',
    31 => 'Permetti tag HTML:',
    32 => 'Errore, nome utente non valido',
    33 => 'Errore, non puoi scrivere nel file di log',
    34 => 'Errore',
    35 => 'Esci',
    36 => 'su',
    37 => 'Nessun articolo dagli utenti',
    38 => 'Content Syndication',
    39 => 'Aggiorna',
    40 => 'Hai <tt>register_globals = Off</tt> nel tuo <tt>php.ini</tt>. Tuttavia, Geeklog richiede che <tt>register_globals</tt> sia <strong>On</strong>. Prima di continuare, prego impostalo ad <strong>on</strong> e riavvia il tuo web server.',
    41 => 'Ospiti',
    42 => 'Inviato da:',
    43 => 'Rispondi a questo',
    44 => 'Relativo',
    45 => 'Numero Errore MySQL',
    46 => 'Messaggio Errore MySQL',
    47 => 'Funzioni Utente',
    48 => 'Info Account',
    49 => 'Preferenze',
    50 => 'Errore nello statement SQL',
    51 => 'Aiuto',
    52 => 'Nuovo',
    53 => 'Home Ammin.',
    54 => 'Impossibile aprire il file.',
    55 => 'Errore su',
    56 => 'Vota',
    57 => 'Password',
    58 => 'Entra',
    59 => "Non hai ancora un account? Iscriviti come <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Nuovo Utente</a>",
    60 => 'Inserisci un commento',
    61 => 'Crea un nuovo Account',
    62 => 'parole',
    63 => 'Preferenze Commenti',
    64 => 'Invia l\'articolo ad un amico',
    65 => 'Visualizza la versione stampabile',
    66 => 'Il mio Calendario',
    67 => 'Benvenuto su ',
    68 => 'Home',
    69 => 'Contatto',
    70 => 'Cerca',
    71 => 'Scrivi',
    72 => 'Link',
    73 => 'Sondaggi',
    74 => 'Calendario',
    75 => 'Ricerca Avanzata',
    76 => 'Statistiche Sito',
    77 => 'Plug-in',
    78 => 'Eventi in arrivo',
    79 => 'Novit&agrave;',
    80 => 'Articoli nelle ultime',
    81 => 'Articolo nelle ultime',
    82 => 'ore',
    83 => 'COMMENTI',
    84 => 'LINK',
    85 => '<br>nelle ultime 48 ore',
    86 => 'Nessun nuovo commento',
    87 => '<br>nelle ultime 2 settimane',
    88 => 'Nessun nuovo link',
    89 => 'Nessun evento in arrivo',
    90 => 'Home',
    91 => 'Pagina creata in',
    92 => 'secondi',
    93 => 'Copyright',
    94 => 'Tutti i marchi e copyrights su questa pagina appartengono ai rispettivi proprietari.',
    95 => 'Powered By',
    96 => 'Gruppi',
    97 => 'Lista parole',
    98 => 'Plug-in',
    99 => 'ARTICOLI',
    100 => 'Nessun nuovo articolo',
    101 => 'I Tuoi Eventi',
    102 => 'Eventi nel sito',
    103 => 'Backup DB',
    104 => 'da',
    105 => 'Invio E-mail',
    106 => 'Visualizzazioni',
    107 => 'Test Versione GeekLog',
    108 => 'Svuota Cache',
    109 => 'Segnala abuso',
    110 => 'Segnala questo inserimento all\'ammin. del sito',
    111 => 'Visualizza Versione PDF',
    112 => 'Utenti Registrati',
    113 => 'Documentazione',
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
    1 => 'Calendario eventi',
    2 => 'Nessun evento da visualizzare.',
    3 => 'Quando',
    4 => 'Dove',
    5 => 'Descrizione',
    6 => 'Aggiungi un evento',
    7 => 'Prossimi eventi',
    8 => 'Aggiungendo questo evento al tuo calendario potrai accedere in modo veloce a tutti gli eventi cui sei interessato facendo clic su "Il mio calendario" nel blocco "Funzioni Utente".',
    9 => 'Aggiungi al mio calendario',
    10 => 'Elimina dal mio calendario',
    11 => "Aggiungi un evento al calendario di {$_USER['username']}",
    12 => 'Evento',
    13 => 'Inizio',
    14 => 'Fine',
    15 => 'Torna al calendario'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Inserisci un commento',
    2 => 'Modo Inserimento',
    3 => 'Esci',
    4 => 'Crea un Account',
    5 => 'Nome Utente',
    6 => 'Per poter inserire un commento su questo sito &egrave; necessario loggarsi. Se non hai ancora un account puoi usare il form sottostante per crearne uno.',
    7 => 'Il tuo ultimo commento risale a ',
    8 => " secondi f&agrave;  Devi attendere {$_CONF['commentspeedlimit']} secondi per inserire un nuovo commento",
    9 => 'Commento',
    10 => 'Invia Segnalazione',
    11 => 'Inserisci Commento',
    12 => 'Per poter inserire un commento &egrave; necessario riempire tutti i campi.',
    13 => 'Le tue info',
    14 => 'Anteprima',
    15 => 'Segnala questo inserimento',
    16 => 'Titolo',
    17 => 'Errore',
    18 => 'Materiale Importante',
    19 => 'Per favore prova a mantenere questo inserimento in cima agli argomenti.',
    20 => 'Prova a rispondere ad un commento di un altro utente anzich&egrave; aprire un nuovo inserimento.',
    21 => 'Leggi i messaggi degli altri utenti prima di inviare il tuo in maniera da evitare messaggi doppi.',
    22 => 'Usa un soggetto che descriva il contenuto del messaggio.',
    23 => 'Il tuo indirizzo e-mail non sar&agrave; reso pubblico.',
    24 => 'Utente Anonimo',
    25 => 'Sei sicuro di voler segnalare questo inserimento all\'amminstratore del sito?',
    26 => '%s ha segnalato come abuso il seguente inserimento di commento:',
    27 => 'Segnalazione abuso'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Profilo Utente di',
    2 => 'Nome Utente',
    3 => 'Nome Completo',
    4 => 'Password',
    5 => 'E-mail',
    6 => 'Homepage',
    7 => 'Bio',
    8 => 'Chiave PGP',
    9 => 'Registra Informazioni',
    10 => 'Ultimi 10 commenti dell\'utente',
    11 => 'Nessun commento dell\'utente',
    12 => 'Preferenze dell\'utente',
    13 => 'E-mail Digest Notturno',
    14 => 'Questa password &egrave; generata in maniera casuale. Si raccomanda di cambiare la password al pi presto. Per cambiare la password, entra nel sito, poi fai clic su Informazioni Account dal men&ugrave; utente.',
    15 => "Il tuo account su {$_CONF['site_name']} &egrave; stato creato correttamente. Per entrare nel sito usa le informazioni sottostanti. Si consiglia di registrare la mail per non perdere i dati dell'account.",
    16 => 'Informazioni del tuo account',
    17 => 'L\'Account non esiste',
    18 => 'L\'indirizzo e-mail fornito non &egrave; un indirizzo valido',
    19 => 'Il nome utente o l\'indirizzo e-mail fornito &egrave; gi&agrave; esistente',
    20 => 'L\'indirizzo e-mail fornito non &egrave; un indirizzo valido',
    21 => 'Errore',
    22 => "Registrati su {$_CONF['site_name']}!",
    23 => "<div align=justify>La creazione di un Account Utente d&agrave; la possibilit&agrave; di partecipare alla costruzione di {$_CONF['site_name']} e ti permette di inviare commenti e articoli da te realizzati. Senza un Account sarai in grado di inserire solo come Anonimo. Prego nota che il tuo indirizzo e-mail non sar&agrave; <b><i>mai</i></b> disponibile pubblicamente o visualizzata nel sito.<div>",
    24 => 'La tua password sar&agrave; inviata all\'indirizzo da te inserito.',
    25 => 'Ti sei dimenticato la tua password?',
    26 => 'Inserisci <em>almeno</em> il tuo nome utente <em>o</em> l\'indirizzo e-mail usato per registrarti e fai clic su E-mail Password. Le Istruzioni su come impostare la nuova new password ti saranno inviate all\'indirizzo registrato.',
    27 => 'Registrati Ora!',
    28 => 'Invia Password via E-mail',
    29 => 'uscito da',
    30 => 'entrato in',
    31 => 'La funzione da te selezionata richiede la tua autenticazione',
    32 => 'Firma',
    33 => 'Mai disponibile pubblicamente',
    34 => 'Questo &egrave; il tuo vero nome',
    35 => 'Inserisci una password per cambiarla',
    36 => 'Iniziando con http://',
    37 => 'Applicato ai tuoi commenti',
    38 => 'Informazioni Aggiuntive! Tutti possono leggere questo',
    39 => 'La tua chiave pubblica PGP key da condividere',
    40 => 'Nascondi Icone Argomenti',
    41 => 'Disponibile a Moderare',
    42 => 'Formato Data',
    43 => 'Numero Massimo di Articoli',
    44 => 'Nascondi box',
    45 => 'Mostra preferenze per',
    46 => 'Escludi Oggetti per',
    47 => 'Nuovo box di Configurazione per',
    48 => 'Articoli',
    49 => 'Nascondi icone in articoli',
    50 => 'Deseleziona se non interessato',
    51 => 'Solo i nuovi articoli',
    52 => 'Per definizione &egrave;',
    53 => 'Ricevi gli articoli giornalieri ogni notte',
    54 => 'Seleziona l\'opzione per gli articoli e gli autori che non vuoi vedere.',
    55 => 'Se lasci tutto non selezionato, significa che vuoi lasciare la selezione di default dei box. Se inizi a selezionare i box, ricordati di impostare tutti quelli desiderati in quanto la configurazione di default verr&agrave; ignorata. Quelli di default sono visualizzati in grassetto.',
    56 => 'Autori',
    57 => 'Modalit&agrave; Visualizzazione',
    58 => 'Ordinamento',
    59 => 'Limiti per i commenti',
    60 => 'Come preferisci siano visualizzati i tuoi commenti?',
    61 => 'Prima i pi&ugrave; recenti o i meno recenti?',
    62 => 'Per definizione &egrave; 100',
    63 => "La tua password &egrave; stata inviata e dovrebbe arrivarti a momenti. Prego segui le istruzioni del messaggio e grazie per la tua partecipazione a {$_CONF['site_name']}",
    64 => 'Preferenze Commenti per',
    65 => 'Prova a entrare di nuovo',
    66 => "Devi aver digitato male le tue credenziali di accesso. Prego riprova di nuovo sotto. Sei un <a href=\"{$_CONF['site_url']}/users.php?mode=new\">nuovo utente</a>?",
    67 => 'Membro dal',
    68 => 'Ricordami per',
    69 => 'Per quanto tempo vuoi essere ricordato dopo l\'ingresso nel sito?',
    70 => "Personalizza lo stile e il contenuto per {$_CONF['site_name']}",
    71 => "Una delle funzionalit&agrave; di {$_CONF['site_name']} &egrave; che puoi personalizzare il contenuto che vuoi visualizzare e lo stile con cui visualizzarlo.  Per utilizzare questa funzione devi prima <a href=\"{$_CONF['site_url']}/users.php?mode=new\">registrarti</a> in {$_CONF['site_name']}. Sei gi&agrave; un membro? Allora usa il form di accesso che trovi alla tua sinistra per entrare!",
    72 => 'Tema',
    73 => 'Lingua',
    74 => 'Cambia lo stile di visualizzazione come preferisci!',
    75 => 'Argomenti da inviare via e-mail per',
    76 => 'Se selezioni almeno un argomento dalla lista sottostante riceverai via e-mail ogni nuovo articolo associato all\'argomento alla fine della giornata. Seleziona solo gli argomenti che ti interessano!',
    77 => 'Foto',
    78 => 'Aggiungi una tua foto!',
    79 => 'Seleziona qu&igrave; per eliminare questa immagine',
    80 => 'Entra',
    81 => 'Invia E-mail',
    82 => 'Ultimi 10 articoli dagli utenti',
    83 => 'Statistiche di inserimento per utente',
    84 => 'Numero totale di articoli:',
    85 => 'Numero totale di commenti:',
    86 => 'Trova tutti gli inserimenti di',
    87 => 'Il tuo nome utente',
    88 => "Qualcuno (probabilmente tu) ha richiesto una nuova password per il tuo account \"%s\" su {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nSe vuoi veramente eseguire questa azione, prego fai clic sul link seguente:\n\n",
    89 => "Se non vuoi eseguire questa operazione, semplicemente ignora questo messaggio e la richiesta sar&agrave; scartata (la tua password non sar&agrave; modificata).\n\n",
    90 => 'Puoi inserire una nuova password per il tuo account sotto. Prego nota che la tua vecchia password &egrave; ancora valida fino a che non invii questo form.',
    91 => 'Imposta Nuova Password',
    92 => 'Inserisci Nuova Password',
    93 => 'La tua ultima richiesta di una nuova password &egrave; stata eseguita %d secondi f&agrave;. Questo sito richiede almeno %d secondi tra una richiesta e l\'altra.',
    94 => 'Elimina Account "%s"',
    95 => 'Fai clic sul bottone "elimina account" qu&igrave;sotto per eliminare il tuo account dal nostro database. Prego nota che qualsiasi articolo e commento da te inserito con questo account <strong>non</strong> sar&agrave; eliminato ma visualizzato come inviato da un "Anonimo".',
    96 => 'Elimina account',
    97 => 'Conferma Eliminazione Account',
    98 => 'Sei proprio sicuro di voler eliminare il tuo account? Cos&igrave; facendo, non sarai pi&ugrave; in grado di entrare ancora in questo sito (fintantoch&egrave; non crei un nuovo account). Se sei sicuro, fai clic su "Elimina account" di nuovo nel form qu&igrave; sotto.',
    99 => 'Opzioni della Privacy per',
    100 => 'E-mail dall\'Amministratore',
    101 => 'Permetti invio e-mail dagli Amministratori del Sito',
    102 => 'E-mail dagli Utenti',
    103 => 'Permetti invio e-mail da altri Utenti',
    104 => 'Visualizza in Online Status',
    105 => 'Mostrami nel blocco Who\'s Online',
    106 => 'Localit&agrave;',
    107 => 'Mostra nel tuo profilo pubblico',
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
    1 => 'Non ci sono News da visualizzare',
    2 => '<br>Non ci sono nuovi articoli da visualizzare. Questo perch&egrave; o non ci sono nuovi articoli relativi a questo argomento o le tue preferenze utente sono troppo restrittive ',
    3 => 'per l\'argomento <b>%s</b>',
    4 => 'Articolo del giorno',
    5 => 'Successivo',
    6 => 'Precedente',
    7 => 'Primo',
    8 => 'Ultimo'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'C\'&egrave; stato un errore nell\'invio del tuo messaggio. Prego riprova un\'altra volta.',
    2 => 'Messaggio inviato correttamente.',
    3 => 'Prego assicurati di usare un indirizzo e-mail valido nel campo Rispondi a:.',
    4 => 'Prego compila i campi Tuo Nome, Rispondi a:,Soggetto e Messaggio',
    5 => 'Errore: Nessun Utente.',
    6 => 'C\'&egrave; stato un errore.',
    7 => 'Profilo Utente per',
    8 => 'Nome Utente',
    9 => 'URL Utente',
    10 => 'Invia mail a',
    11 => 'Tuo Nome:',
    12 => 'Rispondi a:',
    13 => 'Soggetto:',
    14 => 'Messaggio:',
    15 => 'L\'HTML non sar&agrave; tradotto.',
    16 => 'Invia Messaggio',
    17 => 'Spedisci l\'Articolo a un amico',
    18 => 'A Nome',
    19 => 'A Indirizzo E-mail',
    20 => 'Da Nome',
    21 => 'Da Indirizzo E-mail',
    22 => 'Tutti i campi sono richiesti',
    23 => "Questa e-mail ti &egrave; stata inviata da %s a %s perch&egrave; pensa possa interessarti questo articolo proveniente da {$_CONF['site_url']}.  Questa non &egrave; SPAM e il tuo indirizzo e-mail utilizzato in questa operazione non verr&agrave; registrato nella lista per un successivo uso.",
    24 => 'Commento su questo articolo a',
    25 => 'Devi essere un utente registrato per accedere a questa funzione. Identificandoti come utente ci aiuti a prevenire eventuali abusi sul sistema',
    26 => 'Questo form ti permette di inviare una e-mail all\'utente selezionato.  Tutti i campi sono richiesti.',
    27 => 'Messaggio breve',
    28 => '%s scrive: ',
    29 => "Questo è la newsletter quotidiana per {$_CONF['site_name']} del ",
    30 => ' - Newsletter quotidiana del ',
    31 => 'Titolo',
    32 => 'Data',
    33 => 'Leggi l\'articolo completo su',
    34 => 'Fine del messaggio',
    35 => 'Spiacenti, l\'Utente preferisce non ricevere e-mail.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Ricerca Avanzata',
    2 => 'Parole chiave',
    3 => 'Argomenti',
    4 => 'Tutti',
    5 => 'Tipo',
    6 => 'Articoli',
    7 => 'Commenti',
    8 => 'Autori',
    9 => 'Tutti',
    10 => 'Ricerca',
    11 => 'Risultati Ricerca',
    12 => 'risultati',
    13 => 'Risultati Ricerca: Nessun risultato',
    14 => 'Non ci sono risultati per la tua ricerca su',
    15 => 'Prego riprova.',
    16 => 'Titolo',
    17 => 'Data',
    18 => 'Autore',
    19 => "Ricerca nell'intero database di articoli correnti e passati di {$_CONF['site_name']}",
    20 => 'Data',
    21 => 'a',
    22 => '(Formato Data YYYY-MM-DD)',
    23 => 'Visite',
    24 => 'Trovato %d risultati',
    25 => 'Ricerca effettuata per',
    26 => 'oggetti in',
    27 => 'secondi',
    28 => 'Nessun articolo o commento trovato per la tua ricerca',
    29 => 'Risultato Articoli e Commenti',
    30 => 'Nessun Link trovato per la tua ricerca',
    31 => 'Questo plug-in non restituisce nessun risultato',
    32 => 'Evento',
    33 => 'URL',
    34 => 'Localit&agrave;',
    35 => 'Tutti i giorni',
    36 => 'Nessun Evento trovato per la tua ricerca',
    37 => 'Risultato Eventi',
    38 => 'Risultato Link',
    39 => 'Link',
    40 => 'Eventi',
    41 => 'La tua stringa di ricerca deve avere almeno 3 caratteri.',
    42 => 'Prego usa una data formattata come YYYY-MM-DD (anno-mese-giorno).',
    43 => 'frase esatta',
    44 => 'tutte queste parole',
    45 => 'qualsiasi di queste parole',
    46 => 'Prossimo',
    47 => 'Precedente',
    48 => 'Autore',
    49 => 'Data',
    50 => 'Visite',
    51 => 'Link',
    52 => 'Localit&agrave;',
    53 => 'Risultato Articoli',
    54 => 'Risultato Commenti',
    55 => 'la stringa',
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
    1 => 'Statistiche Sito',
    2 => 'Visite Totali nel sistema',
    3 => 'Articoli(Commenti) nel sistema',
    4 => 'Votazioni(Voti) nel sistema',
    5 => 'Links(Clicks) nel sistema',
    6 => 'Eventi nel sistema',
    7 => 'Top 10 Articoli Visitati',
    8 => 'Titolo Articolo',
    9 => 'Visite',
    10 => 'Sembra non ci siano articoli in questo sito.',
    11 => 'Top 10 Articoli Commentati',
    12 => 'Commenti',
    13 => 'Sembra non ci siano articoli disponibili in questo sito o nessuno ha ancora inserito un commento sullo stesso.',
    14 => 'Top 10 Sondaggi',
    15 => 'Domanda Sondaggio',
    16 => 'Voti',
    17 => 'Sembra che nessuno abbia ancora inviato un sondaggio in questo sito nessuno abbia ancora votato.',
    18 => 'Top 10 Link',
    19 => 'Link',
    20 => 'Visite',
    21 => 'Sembra che nessuno abbia ancora inviato un link su questo sito o nessuno ha fatto clic sui link disponibili.',
    22 => 'Top 10 Articoli Inseriti',
    23 => 'E-mail',
    24 => 'Sembra che nessuno abbia ancora inviato un articolo su questo sito',
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
    1 => 'Relativo a..',
    2 => 'Invia l\'Articolo a un amico',
    3 => 'Articolo in Formato Stampabile',
    4 => 'Opzioni',
    5 => 'Articolo in Formato PDF'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'Per inserire un %s &egrave; richiesto che tu ti autentifichi come utente.',
    2 => 'Entra',
    3 => 'Nuovo Utente',
    4 => 'Invia un Evento',
    5 => 'Invia un Link',
    6 => 'Invia un Articolo',
    7 => 'Autenticazione Richiesta',
    8 => 'Invia',
    9 => 'Per l\'inserimento di informazioni da utilizzare in questo sito ti chiediamo di seguire i seguenti consigli...<ul><li>Inserisci tutti i campi, sono tutti richiesti<li>Fornisci informazioni complete e accurate<li>Controlla bene tutti gli URLs</ul>',
    10 => 'Titolo',
    11 => 'Link',
    12 => 'Data Inizio',
    13 => 'Data Fine',
    14 => 'Localit&agrave;',
    15 => 'Descrizione',
    16 => 'Se altro, prego specifica',
    17 => 'Categoria',
    18 => 'Altro',
    19 => 'Leggi prima',
    20 => 'Errore: Categoria Mancante',
    21 => 'Quando selezionato "Altro" fornisci anche il nome della categoria',
    22 => 'Errore: Campi Mancanti',
    23 => 'Prego compila tutti i campi del form. Tutti i campi sono richiesti.',
    24 => 'Inserimento Registrato',
    25 => 'Il tuo %s inserimento &egrave; stato registrato correttamente.',
    26 => 'Limite Velocit&agrave;',
    27 => 'Nome Utente',
    28 => 'Argomento',
    29 => 'Articolo',
    30 => 'Il tuo ultimo inserimento risale a ',
    31 => " secondi f&agrave;.  Questo sito richiede almeno {$_CONF['speedlimit']} secondi fra un inserimento e l'altro",
    32 => 'Anteprima',
    33 => 'Anteprima Articolo',
    34 => 'Esci',
    35 => 'I tag HTML non sono consentiti',
    36 => 'Modalit&agrave; Inserimento',
    37 => "L'Inserimento di un evento in {$_CONF['site_name']} metter&agrave; il tuo evento nel calendario principale e permetter&agrave; agli utenti di aggiungerlo al loro calendario personale. Questa funzione <b>NON</b> &egrave; stata realizzata per inserire compleanni o anniversari.<br><br>Una volta inserito sar&agrave; inviato al nostro amministratore e se approvato il tuo evento apparir&agrave; sul calendario principale.",
    38 => 'Aggiungi Evento a',
    39 => 'Calendario Principale',
    40 => 'Calendario Personale',
    41 => 'Ora Fine',
    42 => 'Ora Inizio',
    43 => 'Evento Giornaliero',
    44 => 'Indirizzo 1',
    45 => 'Indirizzo 2',
    46 => 'Citt&agrave; Paese',
    47 => 'Stato',
    48 => 'C.A.P.',
    49 => 'Tipo Evento',
    50 => 'Modifica Tipi di Eventi',
    51 => 'Localit&agrave;',
    52 => 'Elimina',
    53 => 'Crea un Account'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Autenticazione Richiesta',
    2 => 'Negato! Informazioni d\'accesso non corrette',
    3 => 'Password non valida per l\'utente',
    4 => 'Nome Utente:',
    5 => 'Password:',
    6 => 'Tutti gli accessi alle parti amministrative di questo sito sono registrate e controllate.<br>Questa pagina e per il solo personale autorizzato.',
    7 => 'Entra'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Permessi di amministrazione insufficienti',
    2 => 'Non hai i permessi necessari per modificare questo blocco.',
    3 => 'Editor Blocchi',
    4 => 'Si &egrave; verificato un problema nella lettura di questo feed (vedi error.log per dettagli).',
    5 => 'Titolo Blocco',
    6 => 'Argomento',
    7 => 'Tutti',
    8 => 'Livello Sicurezza Blocco',
    9 => 'Ordine Blocco',
    10 => 'Tipo Blocco',
    11 => 'Blocco Portale',
    12 => 'Blocco Normale',
    13 => 'Opzioni Blocco Portale',
    14 => 'RDF URL',
    15 => 'Ultimo Agg. RDF',
    16 => 'Opzioni Blocco Normale',
    17 => 'Contenuto Blocco',
    18 => 'Prego completa i campi Titolo Blocco, Livello Sicurezza e Contenuto',
    19 => 'Manager Blocchi',
    20 => 'Titolo Blocco',
    21 => 'SecLev Blocco',
    22 => 'Tipo Blocco',
    23 => 'Ordine Blocco',
    24 => 'Argomento Blocco',
    25 => 'Per modificare o eliminare un blocco, fai clic sul blocco selezionato. <br>Per creare un nuovo blocco fai clic su [ Nuovo Blocco ] sopra.',
    26 => 'Impaginazione Blocco',
    27 => 'Blocco PHP',
    28 => 'Opzioni Blocco PHP',
    29 => 'Funzione Blocco',
    30 => 'Se desideri avere un blocco che usi il codice PHP, inserisci il nome della funzione sotto.  Il nome della tua funzione deve iniziare con il prefisso "phpblock_" (es. phpblock_getweather).  Se non ha questo prefisso, la tua funzione NON verr&agrave; richiamata.  Questo per evitare che altre persone possano hackerare la vostra installazione di Geeklog inserendo funzioni di chiamate a codice arbitrario che possa danneggiare il vostro sistema.  Assicuratevi di inserire le parentesi vuote "()" dopo il vostro nome della funzione.  <br><br>Per ultimo, &egrave; raccomandabile mettere tutto il codice del Blocco in /path/to/geeklog/system/lib-custom.php.  <br><b>Questo permette di registrare il tuo codice nel caso di aggiornamenti di Geeklog.</b>',
    31 => 'Errore nel Blocco PHP.  La Funzione, %s, non esiste.',
    32 => 'Errore Campo(i) Mancante(i)',
    33 => 'Devi inserire la URL del file .rdf per il blocco portale',
    34 => 'Devi inserire il titolo e la funzione per il blocco PHP',
    35 => 'Devi inserire il titolo e il contenuto del blocco Normale',
    36 => 'Devi inserire il contenuto per il layout blocco',
    37 => 'Errato nome della funzione Blocco PHP',
    38 => 'La funzione per il Blocco PHP deve avere il prefisso \'phpblock_\' (es. phpblock_getweather).  Il prefisso \'phpblock_\' &egrave; richiesto per ragioni di sicurezza in particolare per prevenire le esecuzioni di codice arbitrario.',
    39 => 'Lato',
    40 => 'Sinistro',
    41 => 'Destro',
    42 => 'Devi inserire l\'ordine del blocco e il livello di sicurezza per i blocchi di default di Geeklog',
    43 => 'Solo in Homepage',
    44 => 'Accesso Negato',
    45 => "Stai tentando di accedere a un blocco del quale non hai i permessi di modifica.  Questo tentativo sar&agrave; registrato. Prego <a href=\"{$_CONF['site_admin_url']}/block.php\">ritorna alla schermata di amministrazione</a>.",
    46 => 'Nuovo Blocco',
    47 => 'Home Amministrazione',
    48 => 'Nome Blocco',
    49 => ' (nessun spazio e deve essere univoco)',
    50 => 'URL File di Help',
    51 => 'includi http://',
    52 => 'Se lasci in bianco questo spazio non verr&agrave; visualizzata la icona di Help per questo blocco',
    53 => 'Abilitato',
    54 => 'Registra',
    55 => 'Annulla',
    56 => 'Elimina',
    57 => 'Sposta Blocco In Basso',
    58 => 'Sposta Blocco in Alto',
    59 => 'Sposta blocco sul lato destro',
    60 => 'Sposta blocco sul lato sinistro',
    61 => 'No Title',
    62 => 'Article Limit',
    63 => 'Bad Block Title',
    64 => 'Your Title must not be empty and cannot contain HTML!',
    65 => 'Order'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => 'Editor Eventi',
    2 => 'Error',
    3 => 'Titolo Evento',
    4 => 'URL Evento',
    5 => 'Data Inizio Evento',
    6 => 'Data Fine Evento',
    7 => 'Localit&agrave; Evento',
    8 => 'Descrizione Evento',
    9 => '(includi http://)',
    10 => 'Devi fornire la data/orario, descrizione e localit&agrave; evento!',
    11 => 'Lista Eventi',
    12 => 'Per modificare o eliminare un evento, fai clic sull\'evento selezionato sotto.  <br>Per creare un nuovo evento fai clic su [ Nuovo Evento ] sopra. Fai clic su [C] per creare una copia di un evento esistente.',
    13 => 'Titolo Evento',
    14 => 'Data Inizio',
    15 => 'Data Fine',
    16 => 'Accesso Negato',
    17 => "Stai tentando di accedere a un evento del quale non hai i permessi di modifica.  Questo tentativo sar&agrave; registrato. Prego <a href=\"{$_CONF['site_admin_url']}/event.php\">ritorna alla schermata di amministrazione</a>.",
    18 => 'Nuovo Evento',
    19 => 'Home Amministrazione',
    20 => 'Registra',
    21 => 'Annulla',
    22 => 'Elimina',
    23 => 'Data inizio errata.',
    24 => 'Data fine errata.',
    25 => 'Data fine prima di data inizio.'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Articolo Precedente',
    2 => 'Prossimo Articolo',
    3 => 'Modalit&agrave;',
    4 => 'Modo Ins.',
    5 => 'Editor Articoli',
    6 => 'Non ci sono articoli nel sistema',
    7 => 'Autore',
    8 => 'Registra',
    9 => 'Anteprima',
    10 => 'Annulla',
    11 => 'Elimina',
    12 => 'ID',
    13 => 'Titolo',
    14 => 'Argomento',
    15 => 'Data',
    16 => 'Testo Intro',
    17 => 'Corpo',
    18 => 'Visite',
    19 => 'Commenti',
    20 => 'Ping',
    21 => 'Send Ping',
    22 => 'Lista Articoli',
    23 => 'Per modificare o eliminare un articolo, fai clic sul numero dell\'articolo. <br>Per visualizzare un articolo, fai clic sul titolo dell\'articolo desiderato. <br>Per creare un nuovo articolo fai clic su [ Nuovo Articolo ] sopra.',
    24 => 'L\'ID da te scelto per questo articolo &egrave; gi&agrave; in uso. Prego scegli un altro ID.',
    25 => 'Error when saving story',
    26 => 'Anteprima Articolo',
    27 => 'If you use [unscaledX] instead of [imageX], the image will be inserted at its original dimensions.',
    28 => '<p><b>PREVIEWING</b>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    29 => 'Trackbacks',
    30 => 'Errore nel caricamento File',
    31 => 'Prego compila i campi di testo Titolo e Intro',
    32 => 'Evidenz.',
    33 => 'Ci pu&ograve; essere solo un articolo Evidenziato',
    34 => 'Draft',
    35 => 'Si',
    36 => 'No',
    37 => 'Altro da',
    38 => 'Altro su',
    39 => 'E-mail',
    40 => 'Accesso negato',
    41 => "Stai tentando di accedere a un articolo dove non hai i permessi di accesso. Questo tentativo sar&agrave; tracciato. Puoi visualizzare l\articolo in sola lettura sotto. Prego <a href=\"{$_CONF['site_admin_url']}/story.php\">ritorna alla schermata amministrazione articoli</a> una volta terminato.",
    42 => "Stai tentando di accedere a un articolo dove non hai i permessi di accesso. Questo tentativo sar&agrave; tracciato. Prego <a href=\"{$_CONF['site_admin_url']}/story.php\">ritorna alla schermata amministrazione articoli</a>.",
    43 => 'Nuovo Articolo',
    44 => 'Home Amministrazione',
    45 => 'Accesso',
    46 => '<b>NOTA:</b> se modifichi questa data postadatandola, questo articolo non sar&agrave; pubblicato fino a suddetta data.  Questo significa inoltre che l\'articolo non sar&agrave; incluso nel tuo <em>RDF headline</em> e verr&agrave; ignorato dalla ricerca e dalle statistiche.',
    47 => 'Immagini',
    48 => 'image',
    49 => 'right',
    50 => 'left',
    51 => 'Per aggiungere una delle immagini in allegato a questo articolo devi inserire del codice di testo speciale. Questo codice speciale &egrave; [imageX], [imageX_right] o [imageX_left] dove X &egrave; il numero della immagine allegata.  <br>NOTA: Devi utilizzare le immagini allegate. Altrimenti non sarai in grado di registrare il tuo articolo.<br><p><b>ANTEPRIMA</b>: L\'Anteprima di un articolo con immagini allegate risulta pi&ugrave; agevole da realizzare registrandolo come bozza AL POSTO di fare clic sul bottone anteprima. Usare il bottone anteprima solo con immagini che non sono allegate.',
    52 => 'Elimina',
    53 => 'non &egrave; utilizzata.  Devi includere questa immagine nell\'intro o nel corpo per poter registrare le tue modifiche',
    54 => 'Immagini in Allegato Non Usate',
    55 => 'Si sono verificati i seguenti errori durante la registrazione del tuo articolo. Prego correggi gli errori prima di registrarlo',
    56 => 'Mostra Icona Argomento',
    57 => 'Mostra Immagine non ridimensionata',
    58 => 'Gestione Articoli',
    59 => 'Opzione',
    60 => 'Attivata',
    61 => 'Archivazione Automatica',
    62 => 'Eliminazione Automatica',
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
    1 => 'Editor Argomento',
    2 => 'ID Argomento',
    3 => 'Nome Argomento',
    4 => 'Immagine Argomento',
    5 => '(non utilizzare spazi)',
    6 => 'Eliminando un argomento eliminerai anche gli articoli e i blocchi ad esso associati',
    7 => 'Prego compila i campi ID Argomento e Nome Argomento',
    8 => 'Manager Argomenti',
    9 => 'Per modificare o eliminare un argomento, fai clic sull\'argomento selezionato. <br>Per creare un nuovo argomento fai clic sul [ Nuovo Argomento ] in alto. <br>Dovresti trovare il tuoi permessi di accesso per ogni argomento elencati fra parentesi. L\'Asterisco (*) indica l\'argomento di default.',
    10 => 'Ordinamento',
    11 => 'Articoli/Pagina',
    12 => 'Accesso negato',
    13 => "Stai cercando di accedere a un argomento del quale non hai i permessi di visualizzazione.  Questo tentativo &egrave; stato registrato. Prego <a href=\"{$_CONF['site_admin_url']}/topic.php\">ritorna alla pagina amministrazione argomenti</a>.",
    14 => 'Metodo Ordinamento',
    15 => 'alfabetico',
    16 => 'per definizione &egrave;',
    17 => 'Nuovo Argomento',
    18 => 'Home Amministrazione',
    19 => 'Registra',
    20 => 'Annulla',
    21 => 'Elimina',
    22 => 'Default',
    23 => 'fai di questo l\'argomento di default per gli inserimenti dei nuovi articoli',
    24 => '(*)',
    25 => 'Argomento di Archivio',
    26 => 'rendi questo l\'argomento di default per gli articoli archiviati. Un solo argomento permesso.',
    27 => 'Or Upload Topic Icon',
    28 => 'Maximum',
    29 => 'File Upload Errors'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Editor Utenti',
    2 => 'ID Utente',
    3 => 'Nome Utente',
    4 => 'Nome Completo',
    5 => 'Password',
    6 => 'Livello di Sicurezza',
    7 => 'Indirizzo E-mail',
    8 => 'Homepage',
    9 => '(non utilizzare spazi)',
    10 => 'Prego compila i campi Nome Utente e Indirizzo E-mail',
    11 => 'Manager Utenti',
    12 => 'Per modificare o eliminare un utente, fai clic su un utente qu&igrave; sotto. <br>Per creare un nuovo utente fai clic sul bottone [ Nuovo Utente ] in alto. <br>Per eseguire una ricerca semplice inserisci parti di nome utente,indirizzo e-mail o nome completo (es.*son* or *.edu) nel form sottostante.',
    13 => 'Liv. Sic.',
    14 => 'Data Reg.',
    15 => 'Nuovo Utente',
    16 => 'Home Ammin.',
    17 => 'Modifica Pass',
    18 => 'Annulla',
    19 => 'Elimina',
    20 => 'Registra',
    21 => 'Il Nome Utente che stai tentando di registrare &egrave; gi&agrave; presente nel database.',
    22 => 'Errore',
    23 => 'Aggiungi (Batch)',
    24 => 'Importazione Batch di Utenti',
    25 => 'Puoi importare un batch di utenti in Geeklog. Il file da importare deve essere delimitato da tab di spaziatura e deve avere i campi nel seguente ordine: nome completo, nome utente, indirizzo e-mail.  a ogni utente che importi sar&agrave; inviata una mail con una password casuale.  Devi avere un utente per ogni riga del file.  La non corretta esecuzione delle seguenti istruzioni potrebbe causare problemi risolvibili solo con del lavoro manuale sul database, quindi fai molta attenzione alle tue operazioni!',
    26 => 'Ricerca',
    27 => 'Risultati limite',
    28 => 'Fai clic qu&igrave; per eliminare questa immagine',
    29 => 'Percorso',
    30 => 'Importa',
    31 => 'Nuovo Utente',
    32 => 'Processo Eseguito. Importato %d e incontrati %d problemi',
    33 => 'invia',
    34 => 'Errore: Devi specificare un file da caricare.',
    35 => 'Ultimo Accesso',
    36 => '(mai)',
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
    1 => 'Approva',
    2 => 'Elimina',
    3 => 'Modifica',
    4 => 'Profilo',
    10 => 'Titolo',
    11 => 'Data inizio',
    12 => 'URL',
    13 => 'Categoria',
    14 => 'Data',
    15 => 'Argomento',
    16 => 'Nome Utente',
    17 => 'Nome Completo',
    18 => 'E-mail',
    34 => 'Console di Amministrazione',
    35 => 'Inserimento Articolo',
    36 => 'Inserimento Link',
    37 => 'Inserimento Evento',
    38 => 'Invia',
    39 => 'Non ci sono inserimenti da moderare al momento',
    40 => 'Inserimenti Utente'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => 'Domenica',
    2 => 'Luned&igrave;',
    3 => 'Marted&igrave;',
    4 => 'Mercoled&igrave;',
    5 => 'Gioved&igrave;',
    6 => 'Venerd&igrave;',
    7 => 'Sabato',
    8 => 'Aggiungi evento',
    9 => 'Eventi %s',
    10 => 'Eventi per',
    11 => 'Calendario Principale',
    12 => 'Il mio calendario',
    13 => 'Gennaio',
    14 => 'Febbraio',
    15 => 'Marzo',
    16 => 'Aprile',
    17 => 'Maggio',
    18 => 'Giugno',
    19 => 'Luglio',
    20 => 'Agosto',
    21 => 'Settembre',
    22 => 'Ottobre',
    23 => 'Novembre',
    24 => 'Dicembre',
    25 => 'Ritorna a ',
    26 => 'Tutti i giorni',
    27 => 'Settimana',
    28 => 'Calendario personale per',
    29 => 'Calendario pubblico',
    30 => 'Elimina evento',
    31 => 'Inserisci',
    32 => 'Evento',
    33 => 'Data',
    34 => 'Tempo',
    35 => 'Inserimento veloce',
    36 => 'Invia',
    37 => 'Spiacenti, la funzione calendario personale non &egrave; abilitato su questo sito',
    38 => 'Editor Eventi Personali',
    39 => 'Giorno',
    40 => 'Settimana',
    41 => 'Mese'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} Mail Utility",
    2 => 'Da',
    3 => 'Rispondi a',
    4 => 'Soggetto',
    5 => 'Commento',
    6 => 'Invia a:',
    7 => 'Tutti gli utenti',
    8 => 'Amministrazione',
    9 => 'Opzioni',
    10 => 'HTML',
    11 => 'Messaggio urgente!',
    12 => 'Invia',
    13 => 'Azzera',
    14 => 'Ignora preferenze utente',
    15 => 'Errore nell\'invio a: ',
    16 => 'Messaggio inviato correttamente a: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Invia un'altro messaggio</a>",
    18 => 'A',
    19 => 'NOTA: se vuoi inviare un messaggio a tutti i membri del sito, seleziona il gruppo Logged-in Users dalla lista.',
    20 => "Messaggi inviati correttamente <successcount> e messaggi non inviati <failcount>. Se lo necessiti, i dettagli di ogni messaggio sono elencati sotto.  Altrimenti puoi <a href=\"{$_CONF['site_admin_url']}/mail.php\">Inviare un'altro messaggio</a> o puoi <a href=\"{$_CONF['site_admin_url']}/moderation.php\">ritornare alla pagina amministrazione</a>.",
    21 => 'Fallito',
    22 => 'Eseguito correttamente',
    23 => 'Nessun errore',
    24 => 'Nessuna esecuzione',
    25 => '-- Seleziona Gruppo --',
    26 => 'Prego compila tutti i campi del form e seleziona un gruppo dal men&ugrave;  a tendina.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'L\'Installazione di plug-in potrebbe provocare danni alla tua installazione di Geeklog ed eventualmente anche il tuo sistema. &Egrave; importante che tu installi solo i plug-in scaricati dalla <a href="http://www.geeklog.net" target="_blank">Homepage di Geeklog</a> in quanto questi plug-in vengono regolarmente testati da noi su numerosi sistemi operativi. E\' altres&igrave; importante che tu capisca che il processo di installazione richiede l\'esecuzione di alcuni comandi di sistema che potrebbero intaccare la sicurezza del sistema stesso (in particolare se utilizzi plug-in di terze parti). Anche con questo avvertenza che ti diamo, noi non garantiamo il successo della installazione e non siamo responsabili di eventuali danni causati dall\'installazione di plug-in. In altre parole, installa a tuo rischio!. Per gli amanti del rischio,  indicazioni su come installare manualmente un plug-in sono incluse in ogni pacchetto plug-in.',
    2 => 'Note di Installazione Plug-in',
    3 => 'Form Installazione Plug-in',
    4 => 'Plug-in File',
    5 => 'Lista Plug-in',
    6 => 'Attenzione: Plug-in gi&agrave; installato!',
    7 => 'Il plug-in che vuoi installare &egrave; gia installato nel sistema. Elimina il plug-in esistente prima di reinstallare la nuova versione',
    8 => 'Controllo Compatibilit&agrave; Plug-in Fallita',
    9 => 'Questo plug-in richiede una nuova versione di Geeklog. Puoi aggiornare la tua copia di <a href=http://www.geeklog.net>Geeklog</a> o prendere una nuova versione del plug-in.',
    10 => '<br><b>Al momento nessun plug-in risulta installato.</b><br><br>',
    11 => 'Per modificare o eliminare un plug-in, fai clic sul numero del plug-in dalla lista sottostante. <br>Per apprendere su come usare il plug-in, fai clic sul nome del plug-in e sarai redirezionato direttamente al sito del plug-in. <br>Per installare o aggiornare un plug-in fai clic su nuovo-plug-in sopra.',
    12 => 'nessun nome di plug-in fornito da plugineditor()',
    13 => 'Editor Plug-in',
    14 => 'Nuovo Plug-in',
    15 => 'Home Amministrazione',
    16 => 'Nome Plug-in',
    17 => 'Versione Plug-in',
    18 => 'Versione Geeklog',
    19 => 'Abilitato',
    20 => 'Si',
    21 => 'No',
    22 => 'Installa',
    23 => 'Registra',
    24 => 'Annulla',
    25 => 'Elimina',
    26 => 'Nome Plug-in',
    27 => 'Homepage Plug-in',
    28 => 'Versione Plug-in',
    29 => 'Versione Geeklog',
    30 => 'Elimina Plug-in?',
    31 => 'Sei sicuro di voler eliminare questo plug-in? Cos&igrave; facendo eliminerai anche tutti i file associati, dati e struttura utilizzati da questo plug-in. Se sei sicuro, fai clic su elimina nel form sottostante.',
    32 => '<p><b>Errore, formato tag AutoLink errato</b></p>',
    33 => 'Versione Codice',
    34 => 'Aggiorna',
    35 => 'Edit',
    36 => 'Code',
    37 => 'Data',
    38 => 'Update!'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'crea feed',
    2 => 'registra',
    3 => 'elimina',
    4 => 'annulla',
    10 => 'Content Syndication',
    11 => 'Nuovo Feed',
    12 => 'Home Admin',
    13 => 'Per modificare o eliminare un feed, fai clic sul titolo del feed sotto. Per creare un nuovo feed, fai clic su Nuovo Feed sopra.',
    14 => 'Titolo',
    15 => 'Tipo',
    16 => 'Nome File',
    17 => 'Formato',
    18 => 'ultimo aggiornamento',
    19 => 'Abilitato',
    20 => 'Si',
    21 => 'No',
    22 => '<i>(nessun feed)</i>',
    23 => 'tutte gli Articoli',
    24 => 'Editor Feed',
    25 => 'Titolo Feed',
    26 => 'Limita',
    27 => 'Lunghezza elementi',
    28 => '(0 = senza testo, 1 = testo completo, altro = limita a questo numero di caratteri.)',
    29 => 'Descriztione',
    30 => 'Ultimo Aggiornamento',
    31 => 'Set Caratteri',
    32 => 'Lingua',
    33 => 'Contenuti',
    34 => 'Elementi',
    35 => 'Ore',
    36 => 'Seleziona il tipo del feed',
    37 => 'Hai almeno un plug-in installato che supporta la content syndication. Sotto devi selezionare se vuoi creare un feed Geeklog o un feed da uno dei plug-in.',
    38 => 'Errore: Campi Mancanti',
    39 => 'Prego inserire Titolo Feed, Descrizione e Nome File.',
    40 => 'Prego inserire un numero di elementi o un numero di ore.',
    41 => 'Link',
    42 => 'Eventi',
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
    1 => "La password &egrave; stata inviata all'indirizzo e-mail da te fornito, dovrebbe arrivare a momenti. Prego segui le istruzioni del messaggio per accedere al sito e grazie per il tuo supporto a {$_CONF['site_name']}",
    2 => "Grazie per aver inserito un articolo in {$_CONF['site_name']}.  L'evento &egrave; stato inviato al nostro staff per l'approvazione. Se approvato, il tuo articolo sar&agrave; disponibile per la visualizzazione nel nostro sito.",
    3 => "Grazie per aver inserito un link in {$_CONF['site_name']}.  L'evento &egrave; stato inviato al nostro staff per l'approvazione.  Se approvato il tuo link sar&agrave; visibile nella sezione <a href={$_CONF['site_url']}/links.php>links</a>.",
    4 => "Grazie per aver inserito un evento in {$_CONF['site_name']}.  L'evento &egrave; stato inviato al nostro staff per l'approvazione.  Se approvato, il tuo evento sar&agrave; visibile nel nostro <a href={$_CONF['site_url']}/calendar.php>calendario</a>.",
    5 => 'Le tue informazioni utente sono state registrate correttamente.',
    6 => 'Le tue preferenze di visualizzazione sono state registrate correttamente.',
    7 => 'Le tue preferenze commenti sono state registrate correttamente.',
    8 => 'Sei uscito dall\'area utenti correttamente.',
    9 => 'Il tuo articolo &egrave; stato registrato correttamente.',
    10 => 'L\'articolo &egrave; stato eliminato correttamente.',
    11 => 'Il tuo blocco &egrave; stato registrato correttamente.',
    12 => 'Il blocco &egrave; stato eliminato correttamente.',
    13 => 'Il tuo argomento &egrave; stato registrato correttamente.',
    14 => 'L\'argomento e tutte gli articoli e blocchi associati sono stati eliminati correttamente.',
    15 => 'Il tuo link &egrave; stato registrato correttamente.',
    16 => 'Il link &egrave; stato eliminato correttamente.',
    17 => 'Il tuo evento &egrave; stato registrato correttamente.',
    18 => 'L\'evento &egrave; stato eliminato correttamente.',
    19 => 'Il tuo sondaggio &egrave; stato registrato correttamente.',
    20 => 'La votazione &egrave; stata eliminata correttamente.',
    21 => 'Il nuovo utente &egrave; stato registrato correttamente.',
    22 => 'L\'utente &egrave; stato eliminato correttamente',
    23 => 'Errore durante il tentativo di aggiungere l\'evento al tuo calendario. ID Evento mancante.',
    24 => 'L\'Evento &egrave; stato registrato correttamente  nel tuo calendario',
    25 => 'Impossibile aprire il calendario personale, entra prima nel sito',
    26 => 'L\'Evento &egrave; stato rimosso correttamente dal tuo calendario personale',
    27 => 'Il Messaggio &egrave; stato inviato correttamente.',
    28 => 'Il plug-in &egrave; stato registrato correttamente',
    29 => 'Spiacenti, il calendario personale non &egrave; abilitato su questo sito',
    30 => 'Accesso negato',
    31 => 'Spiacenti, non hai i permessi per accedere alla pagina amministrazione articoli.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.',
    32 => 'Spiacenti, non hai i permessi per accedere alla pagina amministrazione argomenti.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.',
    33 => 'Spiacenti, non hai i permessi per accedere alla pagina amminitrazione blocchi.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.',
    34 => 'Spiacenti, non hai i permessi per accedere alla pagina amministrazione link.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.',
    35 => 'Spiacenti, non hai i permessi per accedere alla pagina amministrazione eventi.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.',
    36 => 'Spiacenti, non hai i permessi per accedere alla pagina amministrazione sondaggi.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.',
    37 => 'Spiacenti, non hai i permessi per accedere alla pagina amministrazione utenti.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.',
    38 => 'Spiacenti, non hai i permessi per accedere alla pagina amministrazione plug-in.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.',
    39 => 'Spiacenti, non hai i permessi per accedere alla pagina amministrazione mail.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.',
    40 => 'Messaggio di Sistema',
    41 => 'Spiacenti, non hai i permessi per accedere alla pagina sostituzione parole.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.',
    42 => 'La tua parola &egrave; stata registrata correttamente.',
    43 => 'La parola &egrave; stata eliminata correttamente.',
    44 => 'Il plug-in &egrave; stato installato correttamente!',
    45 => 'Il plug-in &egrave; stato eliminato correttamente.',
    46 => 'Spiacenti, non hai i permessi per accedere all\'utility database backup.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.',
    47 => 'Questa funzionalit&agrave; funziona solo sotto *nix. Se Geeklog sta girando sotto un sistema operativo *nix la tua cache verr&agrave; regolarmente azzerata. Se sei su Windows, dovrai necessariamente cercare i files con nome adodb_*.php ed eliminarli manualmente.',
    48 => "Grazie per la tua richiesta di registrazione a {$_CONF['site_name']}. Il nostro Team valuter&agrave; la tua richiesta. Se approvata ti verr&agrave; inviata via posta elettronica la password alla casella e-mail da te specificata.",
    49 => 'Il tuo gruppo &egrave; stato registrato correttamente.',
    50 => 'Il gruppo &egrave; stato eliminato correttamente.',
    51 => 'Questo Nome Utente &egrave; gi&agrave; in uso. Prego selezionane un\'altro.',
    52 => 'L\'indirizzo e-mail da t&egrave; inserito non sembra essere un indirizzo e-mail valido.',
    53 => 'La tua nuova password &egrave; stata accettata. Prego usa la tua nuova password per riaccedere al sito.',
    54 => 'La tua richiesta per una nuova password &egrave; spirata. Prego riprova di nuovo.',
    55 => 'Una e-mail ti &egrave; stata inviata e dovrebbe arrivare a breve. Prego segui le istruzioni contentute nel messaggio per impostare una nuova password per il tup account.',
    56 => 'L\'indirizzo e-mail da te fornito &egrave; gi&agrave; in uso per un altro account.',
    57 => 'Il tuo account &grave; stato eliminato.',
    58 => 'Il tuo feed &egrave stato registrato correttamente.',
    59 => 'Il feed &egrave stato eliminato correttamente.',
    60 => 'Il plug-in &egrave stato aggiornato correttamente',
    61 => 'Plug-in %s: Segnaposto messaggio sconosciuto',
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
    'access' => 'Accessi',
    'ownerroot' => 'Proprietario/Root',
    'group' => 'Gruppo',
    'readonly' => 'Sola-Lettura',
    'accessrights' => 'Permessi di Accesso',
    'owner' => 'Proprietario',
    'grantgrouplabel' => 'Grant Above Group Edit Rights',
    'permmsg' => 'NOTA: i membri sono tutti gli utenti registrati nel sito e anonimi tutti i rimanenti visitatori non registrati.',
    'securitygroups' => 'Sicurezza Gruppi',
    'editrootmsg' => "Ricorda! Anche se sei un Utente Amministratore, non puoi modificare l'utente root senza essere prima entrato con l'account di root. Puoi modificare tutti gli gli altri utenti ad eccezzione dell'utente root. Prego nota che tutti i tentativi di modificare illegalmente l'utente root vengono registrati. Ritorna a <a href=\"{$_CONF['site_admin_url']}/user.php\">Pagina Ammin. Utenti</a>.",
    'securitygroupsmsg' => 'Seleziona la casella per i gruppi nei quali vuoi inserire l\'utente.',
    'groupeditor' => 'Editor Gruppi',
    'description' => 'Descrizione',
    'name' => 'Nome',
    'rights' => 'Permessi',
    'missingfields' => 'Campi Mancanti',
    'missingfieldsmsg' => 'Devi fornire un nome e una descrizione per il gruppo',
    'groupmanager' => 'Manager Gruppi',
    'newgroupmsg' => 'Per modificare o eliminare un gruppo, selezionalo dalla lista sottostante. <br>Per creare un nuovo gruppo fai clic su [ Nuovo Gruppo ] sopra. <br>Considera che il gruppo principale non pu&ograve; essere eliminato in quanto usato dal sistema.',
    'groupname' => 'Nome Gruppo',
    'coregroup' => 'Gruppo Principale',
    'yes' => 'Si',
    'no' => 'No',
    'corerightsdescr' => "Questo Gruppo di {$_CONF['site_name']} &egrave; il gruppo principale. Per definizione i permessi di questo gruppo non possono essere modificati.  Sotto c'&egrave; la lista in sola lettura dei permessi a cui questo gruppo ha accesso.",
    'groupmsg' => 'Il modello di sicurezza per i Gruppi in questo sito &egrave; di tipo gerarchico.  Aggiungendo questo gruppo a uno qualsiasi dei gruppi elencati sotto fa s&igrave; che il gruppo prenda gli stessi permessi del gruppo superiore.  Dove possibile siete incoraggiati a usare i gruppi sottostanti per dare i permessi al gruppo.  Se avete necessit&agrave; di dare dei permessi personalizzati al gruppo potete selezionare i permessi fra le varie funzioni del sito nella sezione chiamata \'Permessi\'.  Per aggiungere questo gruppo a uno dei gruppi sottostanti seleziona la spunta nella caselle del gruppo(i) che desideri modificare.',
    'coregroupmsg' => "Questo gruppo &egrave; il gruppo principale di {$_CONF['site_name']} .  Normalmente i gruppi che sono sottostanti a questo gruppo non posono essere modificati.  Sotto puoi trovare una lista in sola lettura dei gruppi associati a questo gruppo.",
    'rightsdescr' => 'Alcuni permessi di accesso ai gruppi possono essere settati direttamente al gruppo o a un gruppo differente facente parte del gruppo.  Quelli che vedi sotto non selezionati sono i permessi che sono stati impostati a questo gruppo in quanto facente parte di altri gruppi e quindi ereditati.  I permessi selezionabili sono i permessi che posono essere dati direttamente a questo gruppo.',
    'lock' => 'Bloccato',
    'members' => 'Membro',
    'anonymous' => 'Anonimo',
    'permissions' => 'Permessi',
    'permissionskey' => 'R = lettura, E = modifica, permesso di modifica implica permessi di lettura',
    'edit' => 'Modifica',
    'none' => 'Nessuno',
    'accessdenied' => 'Accesso negato',
    'storydenialmsg' => "Non disponi dei permessi per visualizzare questo articolo. Questo perch&egrave; non sei un membro registrato di {$_CONF['site_name']}.  Prego <a href=users.php?mode=new> diventa un membro</a> of {$_CONF['site_name']} per avere pieno accesso al sito!",
    'eventdenialmsg' => "Non disponi dei permessi per visualizzare questo evento. Questo perch&egrave; non sei un membro registrato di {$_CONF['site_name']}.  Prego <a href=users.php?mode=new> diventa un membro</a> of {$_CONF['site_name']} per avere pieno accesso al sito!",
    'nogroupsforcoregroup' => 'Questo Gruppo non ha alcun collegamento con gli altri gruppi',
    'grouphasnorights' => 'Questo Gruppo non ha accesso a nessuna funzione amministrativa del sito',
    'newgroup' => 'Nuovo Gruppo',
    'adminhome' => 'Home Amministratore',
    'save' => 'Registra',
    'cancel' => 'Annulla',
    'delete' => 'Elimina',
    'canteditroot' => 'Hai provato a modificare il Gruppo Root ma non fai parte del gruppo stesso e quindi la tua modifica non &egrave; consentita. Prego contatta gli Amministratori se ritieni questo messaggio un errore',
    'listusers' => 'Lista Utenti',
    'listthem' => 'lista',
    'usersingroup' => 'Utenti nel gruppo %s',
    'usergroupadmin' => 'Amministrazione Gruppi Utenti',
    'add' => 'Add',
    'remove' => 'Remove',
    'availmembers' => 'Membri Disponibili',
    'groupmembers' => 'Membri del Gruppo',
    'canteditgroup' => 'Per modificare questo gruppo, devi esserne membro. Prego contatta l\'amministratore del sistema se pensi si tratti di un errore.',
    'cantlistgroup' => 'Per vedere i membri di questo gruppo, deve esserne membro tu stesso. Prego contatta l\'amministratore del sistema se pensi si tratti di un errore.',
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
    'last_ten_backups' => 'Ultimi 10 Backup',
    'do_backup' => 'Esegui il Backup',
    'backup_successful' => 'Il Backup &egrave; stato eseguito correttamente.',
    'db_explanation' => 'Per creare un nuovo Backup del tuo sistema Geeklog, fai clic sul bottone sottostante',
    'not_found' => "Percorso non corretto o utility mysqldump non eseguibile.<br>Controlla il percorso <strong>\$_DB_mysqldump_path</strong> in config.php.<br>La variabile attualmente &egrave; definit&agrave; come: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Backup Fallito: La dimensione del File era di 0 bytes',
    'path_not_found' => "{$_CONF['backup_path']} non esiste o non &egrave; una directory",
    'no_access' => "ERRORE: La Directory {$_CONF['backup_path']} non &egrave; accessibile.",
    'backup_file' => 'File di backup',
    'size' => 'Dim.',
    'bytes' => 'Byte',
    'total_number' => 'Numero Totale di backup: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Home',
    2 => 'Contatti',
    3 => 'Pubblica',
    4 => 'Link',
    5 => 'Sondaggi',
    6 => 'Calendario',
    7 => 'Statistiche Sito',
    8 => 'Preferenze',
    9 => 'Ricerca',
    10 => 'Ricerca Avanzata',
    11 => 'Directory'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => 'Errore 404',
    2 => 'Attenzione, Abbiamo cercato in tutto il sito ma l\'argomento <b>%s</b> non &egrave; stato trovato.',
    3 => 'Siamo spiacenti, ma il file da te richiesto non esiste. Prego controlla nella pagina principale o nella pagina di ricerca per vedere se puoi trovare quanto da te richiesto.'
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Autenticazione richiesta',
    2 => 'Spiacenti, per accedere a questa area devi essere registrato come utente.',
    3 => 'Entra',
    4 => 'Nuovo Utente'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'La funzionalit&agrave; PDF &egrave; stata disabilitata',
    2 => 'Il documento fornito non &grave; stato renderizzato. Il documento &egrave; stato ricevuto ma non &grave stato possibile processarlo. Prego controlla di aver inviato solo documenti in formato HTML che siano stati scritti secondo lo standard xHTML. Prego nota che documenti estremamente complessi potrebbero non esserre renderizzati correttamente o non esserlo affatto. Il documento risultante dal tuo tentativo era di 0 byte di lunghezza, ed &grave; stato eliminato. Se sei sicuro che il tuo documento dovesse essere renderizzato per bene, prego reinvialo.',
    3 => 'Errore sconosciuto nella generazione del PDF',
    4 => "Dati pagina non forniti, o vuoi utilizare lo strumento di generazione PDF ad-hoc sotto. Se pensi di aver ricevuto questa pagina\n per errore, contatta prego l\'amminstratore di sistema. Altrimenti, puoi utilizzare il form sottostante per generare PDF in modalit&agrave; ad-hoc.",
    5 => 'Carico il tuo documento.',
    6 => 'Attendi prego mentre il tuo documento viene caricato.',
    7 => 'Puoi fare clic con il pulsante destro sotto e scegliere \'registra  collegamento...\' o \'scarica documento collegato...\' per registrare una copia del documento.',
    8 => "Il percorso fornito nel file di configurazione per l\'eseguibile di  HTMLDoc &egrave; invalido o questo sistema non pu&ograve; eseguirlo. Prego contatta l\'amministratore del sito se questo problema\npersiste.",
    9 => 'Generatore PDF',
    10 => "Questo &egrave; lo strumento di Generazione PDF Ad-hoc. Prover&agrave; a convertire qualsiasi URL gli si fornisca in un PDF. Prego nota che alcune pagine web non saranno visualizzate correttamente con questa funzionalit&agrave;. Questa\n&grave; una limitazione dello strumento di generazione PDF HTMLDoc e tali errori non dovrebbero essere segnalati all\'amministratore di questo sito",
    11 => 'URL',
    12 => 'Genera PDF!',
    13 => 'La configurazione PHP su questo server non permette di utilizzare URL con il comando fopen(). L\'amministratore di sistema deve modificare il file  php.ini ed impostare allow_url_fopen ad On',
    14 => 'Il PDF da te richiesto o non esiste o hai provato ad accedervi illegalmente.'
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
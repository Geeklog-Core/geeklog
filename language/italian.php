<?php

###############################################################################
# italian.php
# Traduzione italiana per GeekLog!
# Special thanks to Mischa Polivanov for his work on this project
#
# Copyright (C) 2002 quess65
# webmaster@dynamikteam.net
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
	1 => "Contributo di:",
	2 => "altro ->",
	3 => "commenti",
	4 => "Modifica",
	5 => "Vota",
	6 => "Risultati",
	7 => "Risultati vot.",
	8 => "voti",
	9 => "Area Amministratore:",
	10 => "Inserimenti",
	11 => "Articoli",
	12 => "Blocchi",
	13 => "Argomenti",
	14 => "Links",
	15 => "Eventi",
	16 => "Sondaggi",
	17 => "Utenti",
	18 => "SQL Query",
	19 => "Esci",
	20 => "Informazioni utente:",
	21 => "Nome Utente",
	22 => "ID Utente",
	23 => "Livello di sicurezza",
	24 => "Anonimo",
	25 => "Invia Commento",
	26 => "I seguenti commenti sono propriet&igrave; di chi li ha inviati. Questo sito non &egrave; responsabile dei contenuti degli stessi.",
	27 => "Inserimenti pi&ugrave; recenti",
	28 => "Cancella",
	29 => "Nessun commento.",
	30 => "Vecchie Storie",
	31 => "Permetti tag HTML:",
	32 => "Errore, nome utente non valido",
	33 => "Errore, non puoi scrivere nel file di log",
	34 => "Errore",
	35 => "Esci",
	36 => "on",
	37 => "Nessun articolo dagli utenti",
	38 => "",
	39 => "Aggiorna",
	40 => "",
	41 => "Ospiti",
	42 => "Contributo di:",
	43 => "Rispondi a questo",
	44 => "Relativo",
	45 => "MySQL Error Number",
	46 => "MySQL Error Message",
	47 => "Area Utenti",
	48 => "Info Account",
	49 => "Preferenze",
	50 => "Errore nello stato SQL",
	51 => "Aiuto",
	52 => "Nuovo",
	53 => "Home Amministratore",
	54 => "Impossibile aprire il file.",
	55 => "Errore su",
	56 => "Vota",
	57 => "Password",
	58 => "Entra",
	59 => "Non hai ancora un account?  Iscriviti come <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Nuovo Utente</a>",
	60 => "Inserisci un commento",
	61 => "Crea un nuovo Account",
	62 => "parole",
	63 => "Preferenze Commenti",
	64 => "Invia l'articolo ad un amico",
	65 => "Visualizza la versione stampabile",
	66 => "Il mio Calendario",
	67 => "Benvenuto su ",
	68 => "Home",
	69 => "Contatto",
	70 => "Cerca",
	71 => "Contributo",
	72 => "Risorse Web",
	73 => "Sondaggi",
	74 => "Calendario",
	75 => "Ricerca Avanzata",
	76 => "Statistiche del sito",
	77 => "Plugins",
	78 => "Eventi in arrivo",
	79 => "Novit&agrave;",
	80 => "Articoli nelle ultime",
	81 => "Articolo nelle ultime",
	82 => "ore",
	83 => "COMMENTI",
	84 => "LINKS",
	85 => "<br>nelle ultime 48 ore",
	86 => "Nessun nuovo commento",
	87 => "<br>nelle ultime 2 settimane",
	88 => "Nessun nuovo link",
	89 => "Nessun evento in arrivo",
	90 => "Home",
	91 => "Pagina creata in",
	92 => "secondi",
	93 => "Copyright",
	94 => "Tutti i marchi e copyrights su questa pagina appartengono ai rispettivi proprietari.",
	95 => "Powered By",
	96 => "Gruppi",
        97 => "Lista parole",
	98 => "Plug-ins",
	99 => "ARTICOLI",
        100 => "Nessun nuovo articolo",
        101 => 'Tuoi Eventi',
        102 => 'Eventi nel sito',
        103 => 'DB Backups',
        104 => 'da',
        105 => 'Mail Utility',
        106 => 'Visualizzazioni',
        107 => 'GL Version Test',
        108 => 'Cancella Cache'
);

###############################################################################
# calendar.php

$LANG02 = array(
	1 => "Calendario degli eventi",
	2 => "Nessun evento da visualizzare.",
	3 => "Quando",
	4 => "Dove",
	5 => "Descrizione",
	6 => "Aggiungi un evento",
	7 => "Eventi in arrivo",
	8 => 'Aggiungendo questo evento al tuo calendario potrai accedere in modo veloce a tutti gli eventi a cui sei interessato cliccando su "Mio calendario" dalla sezione "Men&ugrave; Utente".',
	9 => "Aggiungi al mio calendario",
	10 => "Rimuovi dal mio calendario",
	11 => "Aggiungi un evento al calendario di {$_USER['username']}",
	12 => "Evento",
	13 => "Inizio",
	14 => "Fine",
    	15 => "Torna al calendario"
);

###############################################################################
# comment.php

$LANG03 = array(
	1 => "Inserisci un commento",
	2 => "Modo Inserimento",
	3 => "Esci",
	4 => "Crea un Account",
	5 => "Nome Utente",
	6 => "Per poter inserire un commento su questo sito &egrave; necessario loggarsi.  Se ancora non hai un account puoi usare il modulo sottostante per crearne uno.",
	7 => "Il tuo ultimo commento risale a ",
	8 => " secondi f&agrave;  Devi attendere {$_CONF["commentspeedlimit"]} secondi per inserire un nuovo commento",
	9 => "Commento",
	10 => '',
	11 => "Inserisci Commento",
	12 => "Per poter inserire un commento &egrave; necessario riempire tutti i campi.",
	13 => "Le tue info",
	14 => "Anteprima",
	15 => "",
	16 => "Titolo",
	17 => "Errore",
	18 => 'Materiale Importante',
	19 => 'Per favore prova a mantenere questo inserimeno in cima agli argomenti.',
	20 => 'Prova a rispondere ad un commento di un altro utente anzich&egrave; aprire un nuovo inserimento.',
	21 => 'Leggi i messaggi degli altri utenti prima di inviare il tuo in maniera da evitare messaggi doppi.',
	22 => 'Usa un soggetto che descriva il contenuto del messaggio.',
	23 => 'Il tuo indirizzo email non sar&agrave; reso pubblico.',
	24 => 'Utente Anonimo'
);

###############################################################################
# users.php

$LANG04 = array(
	1 => "Profilo Utente di",
	2 => "Nome Utente",
	3 => "Nome Completo",
	4 => "Password",
	5 => "Email",
	6 => "Homepage",
	7 => "Bio",
	8 => "Chiave PGP",
	9 => "Salva Informazioni",
	10 => "Ultimi 10 commenti dell'utente",
	11 => "Nessun commento dell'utente",
	12 => "Preferenze dell'utente",
	13 => "Email Nightly Digest",
	14 => "Questa password &egrave; generata in maniera casuale. Si raccomanda di cambiare la password al pi presto. Per cambiare la password, loggarsi e cliccare su Informazioni Account dal men utente.",
	15 => "Il tuo account su {$_CONF["site_name"]} &egrave; stato creato con successo. Per entrare nel sito usa le informazioni sottostanti. Si consiglia di salvare la mail per non perdere i dati dell'account.",
	16 => "Informazioni del tuo account",
	17 => "L'Account non esiste",
	18 => "L'indirizzo email fornito non &egrave; un indirizzo valido",
	19 => "Il nome utente o l'indirizzo email fornito &egrave; gi&agrave; esistente",
	20 => "L'indirizzo email fornito non &egrave; un indirizzo valido",
	21 => "Errore",
	22 => "Registrati in {$_CONF['site_name']}!",
	23 => "<div align=justify>La creazione di un Account Utente da la possibilit&agrave; di partecipare alla costruzione di {$_CONF['site_name']} e ti permette di inviare commenti e articoli da te realizzati. Senza un Account sarai in grado di inserire solo come Anonimo. Prego nota che il tuo indirizzo email non sar&agrave; <b><i>mai</i></b> disponibile pubblicamente o visualizzata nel sito.<div>",
	24 => "La tua password sar&agrave; inviata all'indirizzo da te inserito.",
	25 => "Ti sei dimenticato la tua password?",
	26 => "Inserisci <em>almeno</em> il tuo nome utente <em>o</em> l'indirizzo email usato per registrarti e clicca su Email Password. Le Istruzioni su come impostare la nuova new password ti saranno inviate all'indirizzo registrato.",
	27 => "Registrati Ora!",
	28 => "Email Password",
	29 => "uscito da",
	30 => "entrato in",
	31 => "La funzione da te selezionata richiede la tua autenticazione",
	32 => "Firma",
	33 => "Mai disponibile pubblicamente",
	34 => "Questo &egrave; il tuo vero nome",
	35 => "Inserisci una password per cambiarla",
	36 => "Iniziando con http://",
	37 => "Applicato ai tuoi commenti",
	38 => "Informazioni Aggiuntive! Tutti possono leggere questo",
	39 => "La tua chiave pubblica PGP key da condividere",
	40 => "No Icone Argomenti",
	41 => "Modera",
	42 => "Formato Data",
	43 => "Articoli massimi",
	44 => "No boxes",
	45 => "Mostra preferenze per",
	46 => "Escludi Oggetti per",
	47 => "Nuovo box di Configurazione per",
	48 => "Articoli",
	49 => "No icone in articoli",
	50 => "Deseleziona se non interessato",
	51 => "Solo i nuovi articoli",
	52 => "Per definizione &egrave;",
	53 => "Ricevi gli articoli giornalieri ogni notte",
	54 => "Seleziona l'opzione per gli articoli e gli autori che non vuoi vedere.",
	55 => "Se lasci questo non selezionato, significa che vuoi lasciare la selezione di definizione. Se inizi a selezionare le opzioni ricordati di settare tutti quelli desiderati in quanto la configurazione di definizione verr&agrave; ignorata. Le selezioni di definizione sono visualizzate in grassetto.",
	56 => "Autori",
	57 => "Modo Visualizzazione",
	58 => "Ordinamento",
	59 => "Limiti per i commenti",
	60 => "Come preferisci siano visualizzati i tuoi commenti?",
	61 => "Nuovi o vecchi prima?",
	62 => "Per definizione &egrave; 100",
	63 => "La tua password &egrave; stata inviata e dovrebbe arrivarti a momenti. Prego segui le istruzioni del messaggio e grazie per la tua partecipazione a " . $_CONF["site_name"],
	64 => "Preferenze Commenti per",
	65 => "Prova a entrare di nuovo",
	66 => "Devi aver digitato male le tue credenziali di accesso.  Prego riprova di nuovo sotto. Sei un <a href=\"{$_CONF['site_url']}/users.php?mode=new\">nuovo utente</a>?",
	67 => "Membro dal",
	68 => "Ricordami per",
	69 => "Per quanto tempo vuoi essere ricordato dopo l'entrata al sito?",
	70 => "Personalizza lo stile e il contenuto per {$_CONF['site_name']}",
	71 => "Una delle funzionalit&agrave; di {$_CONF['site_name']} &egrave; che puoi personalizzare il contenuto che vuoi visualizzare e lo stile con cui visualizzarlo.  Per utilizzare questa funzione devi prima <a href=\"{$_CONF['site_url']}/users.php?mode=new\">registrarti</a> in {$_CONF['site_name']}.  Sei gi&agrave; un membro?  Allora usa il modulo di accesso che trovi alla tua sinistra per entrare!",
        72 => "Tema",
        73 => "Lingua",
        74 => "Cambia lo stile di visualizzazione come preferisci!",
        75 => "Argomento da inviare via mail per",
        76 => "Se selezioni un argomento dalla lista sottostante riceverai via mail ogni nuovo articolo associato all'argomento alla fine della giornata.  Seleziona solo gli argomenti che ti interessano!",
        77 => "Foto",
        78 => "Aggiungi una tua foto!",
        79 => "Seleziona qu&igrave; per cancellare questa immagine",
        80 => "Entra",
        81 => "Invia E-Mail",
        82 => 'Ultimi 10 articoli dagli utenti',
        83 => 'Statistiche di inserimento per utente',
        84 => 'Numero totale di articoli:',
        85 => 'Numero totale di commenti:',
        86 => 'Trova tutti gli inserimenti di',
        87 => 'Tuo Nome di login',
        88 => 'Qualcuno (probabilmente tu) ha richiesto una nuova password per il tuo account "%s" su ' . $_CONF['site_name'] . ', <' . $_CONF['site_url'] . ">.\n\nSe vuoi veramente eseguire questa azione, prego clicca sul link seguente:\n\n",
        89 => "Se non vuoi eseguire questa operazione, semplicemente ignora questo messaggio e la richiesta sar&agrave; scartata (la tua password non sar&agrave; modificata).\n\n",
        90 => 'Puoi inserire una nuova password per il tuo account sotto. Prego nota che la tua vecchia password &egrave; ancora valida fino a che non invii questo modulo.',
        91 => 'Imposta Nuova Password',
        92 => 'Inserisci Nuova Password',
        93 => 'La tua ultima richiesta di una nuova password &egrave; stata eseguita %d secondi f&agrave;. Questo sito richiede almeno %d secondi tra una richiesta e l\'altra.',
        94 => 'Elimina Account "%s"',
        95 => 'Clicca sul bottone "elimina account" qu&igrave;sotto per rimuovere il tuo account dal nostro database. Prego nota che qualsiasi articolo e commento da te inserito con questo account <strong>non</strong> sar&agrave; cancellato ma visualizzato come inviato da un "Anonimo".',
        96 => 'Elimina account',
        97 => 'Conferma Eliminazione Account',
        98 => 'Sei proprio sicuro di voler cancellare il tuo account? Facendo questo, non sarai pi&ugrave; in grado di entrare ancora in questo sito (fintantoch&egrave; non crei un nuovo account). Se sei sicuro, clicca "Elimina account" di nuovo nel modulo qu&igrave; sotto.',
        99 => 'Opzioni della Privacy per',
        100 => 'Email dall\'Amministratore',
        101 => 'Permetti email dagli Amministratori del Sito',
        102 => 'Email dagli Utenti',
        103 => 'Permetti email da altri Utenti',
        104 => 'Visualizza in Online Status',
        105 => 'Mostrami nel blocco Who\'s Online'
);

###############################################################################
# index.php

$LANG05 = array(
	1 => "Nessuna News da visualizzare",
	2 => "<br>Non ci sono nuovi articoli da visualizzare.  Questo perch&egrave; o non ci sono nuovi articoli per questo argomento o le tue preferenze utente sono troppo restrittive ",
	3 => "per l'argomento <b>$topic</b>",
	4 => "Articolo del giorno",
	5 => "Prossimo",
	6 => "Precedente"
);

###############################################################################
# links.php

$LANG06 = array(
	1 => "Risorse Web",
	2 => "Non ci sono risorse da visualizzare.",
	3 => "Aggiungi un Link"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
	1 => "Voto Salvato",
	2 => "Il tuo voto &egrave; stato salvato nel sondaggio",
	3 => "Voto",
	4 => "Sondaggi nel sistema",
	5 => "Voti",
	6 => "Visualizza gli altri sondaggi"
);

###############################################################################
# profiles.php

$LANG08 = array(
	1 => "C'&egrave; stato un errore nell'invio del tuo messaggio. Prego riprova un'altra volta.",
	2 => "Messaggio inviato correttamente.",
	3 => "Prego assicurati di usare un indirizzo email valido nel campo Rispondi a:.",
	4 => "Prego compila i campi Tuo Nome, Rispondi a:,Soggetto e Messaggio",
	5 => "Errore: Nessun Utente.",
	6 => "C'&egrave; stato un errore.",
	7 => "Profilo Utente per",
	8 => "Nome Utente",
	9 => "URL Utente",
	10 => "Invia mail a",
	11 => "Tuo Nome:",
	12 => "Rispondi a:",
	13 => "Soggetto:",
	14 => "Messaggio:",
	15 => "L'HTML non sar&agrave; tradotto.",
	16 => "Invia Messaggio",
	17 => "Spedisci l'Articolo a un amico",
	18 => "A Nome",
	19 => "A Indirizzo Email",
	20 => "Da Nome",
	21 => "Da Indirizzo Email",
	22 => "Tutti i campi sono richiesti",
	23 => "Questa e-mail ti &egrave; stata inviata da $from a $fromemail perch&egrave; pensa possa interessarti questo articolo proveniente da {$_CONF["site_url"]}.  Questa non &egrave; SPAM e il tuo indirizzo e-mail utilizzato in questa operazione non verr&agrave; salvato nella lista per un successivo uso.",
	24 => "Commento su questo articolo a",
	25 => "Devi entrare come utente per questa funzione.  Accreditandoti come utente ci aiuti a prevenire eventuali hackeraggi del sistema",
	26 => "Questo modulo ti permette di inviare una e-mail all'utente selezionato.  Tutti i campi sono richiesti.",
	27 => "Messaggio breve",
	28 => "$from scrive: $shortmsg",
        29 => "Questo &egrave; il daily digest da {$_CONF['site_name']} per ",
        30 => " Daily Newsletter per ",
        31 => "Titolo",
        32 => "Data",
        33 => "Leggi l'articolo completo su",
        34 => "Fine del messaggio",
        35 => 'Spiacenti, l\'Utente preferisce non ricevere nessuna email.'
);

###############################################################################
# search.php

$LANG09 = array(
	1 => "Ricerca Avanzata",
	2 => "Parole chiave",
	3 => "Argomenti",
	4 => "Tutti",
	5 => "Tipo",
	6 => "Articoli",
	7 => "Commenti",
	8 => "Autori",
	9 => "Tutti",
	10 => "Ricerca",
	11 => "Risultati Ricerca",
	12 => "risultati",
	13 => "Risultati Ricerca: Nessun risultato",
	14 => "Non ci sono risultati per la tua ricerca su",
	15 => "Prego riprova.",
	16 => "Titolo",
	17 => "Data",
	18 => "Autore",
	19 => "Ricerca l'intero {$_CONF["site_name"]} database degli articoli correnti e passati e nuove storie",
	20 => "Data",
	21 => "a",
	22 => "(Formato Data YYYY-MM-DD)",
	23 => "Visite",
	24 => "Trovato %d risultati",
	25 => "Ricerca effettuata per",
	26 => "oggetti in",
	27 => "secondi",
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
        38 => 'Risultato Links',
        39 => 'Links',
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
        57 => 'OR'
);

###############################################################################
# stats.php

$LANG10 = array(
	1 => "Statistiche Sito",
	2 => "Visite Totali nel sistema",
	3 => "Articoli(Commenti) nel sistema",
	4 => "Votazioni(Voti) nel sistema",
	5 => "Links(Clicks) nel sistema",
	6 => "Eventi nel sistema",
	7 => "Top 10 Articoli Visitati",
	8 => "Titolo Articolo",
	9 => "Visite",
	10 => "Sembra non ci siano articoli in questo sito.",
	11 => "Top 10 Articoli Commentati",
	12 => "Commenti",
	13 => "Sembra non ci siano articoli disponibili in questo sito o nessuno ha ancora inserito un commento sullo stesso.",
	14 => "Top 10 Sondaggi",
	15 => "Domanda Sondaggio",
	16 => "Voti",
	17 => "Sembra che nessuno abbia ancora inviato un sondaggio in questo sito nessuno abbia ancora votato.",
	18 => "Top 10 Links",
	19 => "Links",
	20 => "Visite",
	21 => "Sembra che nessuno abbia ancora inviato un link in questo sito o nessuno ha cliccato sui link disponibili.",
	22 => "Top 10 Articoli Inseriti",
	23 => "Emails",
	24 => "Sembra che nessuno abbia ancora inviato un articolo in questo sito"
);

###############################################################################
# article.php

$LANG11 = array(
	1 => "Relativo a..",
	2 => "Invia l'Articolo a un amico",
	3 => "Articolo in Formato Stampa",
	4 => "Opzioni"
);

###############################################################################
# submit.php

$LANG12 = array(
	1 => "Per inserire un $type &egrave; richiesto che tu ti autentifichi come utente.",
	2 => "Entra",
	3 => "Nuovo Utente",
	4 => "Invia un Evento",
	5 => "Invia un Link",
	6 => "Invia un Articolo",
	7 => "Autenticazione Richiesta",
	8 => "Invia",
	9 => "Per l'inserimento di informazioni da utilizzare in questo sito ti chiediamo di seguire i seguenti consigli...<ul><li>Inserisci tutti i campi, sono tutti richiesti<li>Fornisci informazioni complete e accurate<li>Controlla bene tutti gli URLs</ul>",
	10 => "Titolo",
	11 => "Link",
	12 => "Data Inizio",
	13 => "Data Termine",
	14 => "Localit&agrave;",
	15 => "Descrizione",
	16 => "Se altro, prego specifica",
	17 => "Categoria",
	18 => "Altro",
	19 => "Leggi prima",
	20 => "Errore: Categoria Mancante",
	21 => "Quando selezionato \"Altro\" fornisci anche il nome della categoria",
	22 => "Errore: Campi Mancanti",
	23 => "Prego compila tutti i campi del modulo.  Tutti i campi sono richiesti.",
	24 => "Inserimento Salvato",
	25 => "Il tuo $type inserimento &egrave; stato salvato correttamente.",
	26 => "Limite Velocit&agrave;",
	27 => "Nome Utente",
	28 => "Argomento",
	29 => "Articolo",
	30 => "Il tuo ultimo inserimento risale a ",
	31 => " secondi f&agrave;.  Questo sito richiede almeno {$_CONF["speedlimit"]} secondi fra un inserimento e l'altro",
	32 => "Anteprima",
	33 => "Anteprima Articolo",
	34 => "Esci",
	35 => "I tags HTML non sono consentiti",
	36 => "Modo Inserimento",
	37 => "L'Inserimento di un evento in  {$_CONF["site_name"]} metter&agrave; il tuo evento nel calendario principale e permetter&agrave; agli utenti di aggiungerlo al loro calendario personale. Questa funzione <b>NON</b> &egrave; stata realizzata per inserire compleanni o anniversari.<br><br>Una volta inserito sar&agrave; inviato al nostro amministratore e se approvato il tuo evento apparir&agrave; sul calendario principale.",
        38 => "Aggiungi Evento a",
        39 => "Calendario Principale",
        40 => "Calendario Personale",
        41 => "Ora Fine",
        42 => "Ora Inizio",
        43 => "Evento Giornaliero",
        44 => 'Indirizzo 1',
        45 => 'Indirizzo 2',
        46 => 'Citt&agrave; Paese',
        47 => 'Stato',
        48 => 'C.A.P.',
        49 => 'Tipo Evento',
        50 => 'Modifica Tipi di Eventi',
        51 => 'Localit&agrave;',
        52 => 'Cancella',
        53 => 'Crea un Account'
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
	1 => "Autenticazione Richiesta",
	2 => "Negato! Informazioni d'accesso non corrette",
	3 => "Password non valida per l'utente",
	4 => "Nome Utente:",
	5 => "Password:",
	6 => "Tutti gli accessi alle parti amministrative di questo sito sono registrate e controllate.<br>Questa pagina e per il solo personale autorizzato.",
	7 => "Entra"
);

###############################################################################
# block.php

$LANG21 = array(
	1 => "Permessi di amministrazione insufficienti",
	2 => "Non hai i permessi necessari per modificare questo blocco.",
	3 => "Editor Blocchi",
	4 => "",
	5 => "Titolo Blocco",
	6 => "Argomento",
	7 => "Tutti",
	8 => "Livello Sicurezza Blocco",
	9 => "Ordine Blocco",
	10 => "Tipo Blocco",
	11 => "Blocco Portale",
	12 => "Blocco Normale",
	13 => "Opzioni Blocco Portale",
	14 => "RDF URL",
	15 => "Ultimo Agg. RDF",
	16 => "Opzioni Blocco Normale",
	17 => "Contenuto Blocco",
	18 => "Please fill in the Block Title, Security Level and Content fields",
	19 => "Manager Blocchi",
	20 => "Titolo Blocco",
	21 => "SecLev Blocco",
	22 => "Tipo Blocco",
	23 => "Ordine Blocco",
	24 => "Argomento Blocco",
	25 => "Per modificare o cancellare un blocco, clicca sul blocco selezionato.  <br>Per creare un nuovo blocco clicca su [ Nuovo Blocco ] sopra.",
	26 => "Layout Blocco",
	27 => "Blocco PHP",
        28 => "Opzioni Blocco PHP",
        29 => "Funzione Blocco",
        30 => "Se desideri avere un blocco che usi il codice PHP, inserisci il nome della funzione sotto.  Il nome della tua funzione deve iniziare con il prefisso \"phpblock_\" (es. phpblock_getweather).  Se non ha questo prefisso, la tua funzione NON verr&agrave; richiamata.  Questo per evitare che altre persone possano hackerare la vostra installazione di Geeklog inserendo funzioni di chiamate a codice arbitrario che possa danneggiare il vostro sistema.  Assicuratevi di inserire le parentesi vuote \"()\" dopo il vostro nome della funzione.  <br><br>Per ultimo, &egrave; raccomandabile mettere tutto il codice del Blocco in /path/to/geeklog/system/lib-custom.php.  <br><b>Questo permette di salvare il tuo codice nel caso di aggiornamenti di Geeklog.</b>",
        31 => 'Errore nel Blocco PHP.  La Funzione, $function, non esiste.',
        32 => "Errore Campo(i) Mancante(i)",
        33 => "Devi inserire il URL per il file .rdf per il blocco portale",
        34 => "Devi inserire il titolo e la funzione per il blocco PHP",
        35 => "Devi inserire il titolo e il contenuto del blocco Normale",
        36 => "Devi inserire il contenuto per il layout blocco",
        37 => "Errato nome della funzione Blocco PHP",
        38 => "La funzione per il Blocco PHP deve avere il prefisso 'phpblock_' (es. phpblock_getweather).  Il prefisso 'phpblock_' &egrave; richiesto per ragioni di sicurezza in particolare per prevenire le esecuzioni di codice arbitrario.",
	39 => "Lato",
	40 => "Sinistro",
	41 => "Destro",
	42 => "Devi inserire l'ordine del blocco e il livello di sicurezza per i blocchi di default di Geeklog",
	43 => "Solo in Homepage",
	44 => "Accesso Negato",
	45 => "Stai tentando di accedere a un blocco del quale non hai i permessi di modifica.  Questo tentativo sar&agrave; registrato. Prego <a href=\"{$_CONF["site_admin_url"]}/block.php\">ritorna alla schermata di amministrazione</a>.",
	46 => 'Nuovo Blocco',
	47 => 'Home Amministrazione',
        48 => 'Nome Blocco',
        49 => ' (nessun spazio e deve essere univoco)',
        50 => 'URL File di Help',
        51 => 'includi http://',
        52 => 'Se lasci in bianco questo spazio non verr&agrave; visualizzata la icona di Help per questo blocco',
        53 => 'Abilitato',
        54 => 'Salva',
        55 => 'cancella',
        56 => 'Elimina'
);

###############################################################################
# event.php

$LANG22 = array(
	1 => "Editor Eventi",
	2 => "",
	3 => "Titolo Evento",
	4 => "URL Evento",
	5 => "Data Inizio Evento",
	6 => "Data Fine Evento",
	7 => "Localit&agrave; Evento",
	8 => "Descrizione Evento",
	9 => "(includi http://)",
	10 => "Devi fornire la data/orario, descrizione e localit&agrave; evento!",
	11 => "Lista Eventi",
	12 => "Per modificare o cancellare un evento, clicca sull'evento selezionato sotto.  <br>Per creare un nuovo evento clicca su [ Nuovo Evento ] sopra. Clicca su [C] per creare una copia di un evento esistente.",
	13 => "Titolo Evento",
	14 => "Data Inizio",
	15 => "Data Fine",
	16 => "Accesso Negato",
	17 => "Stai tentando di accedere a un evento del quale non hai i permessi di modifica.  Questo tentativo sar&agrave; registrato. Prego <a href=\"{$_CONF["site_admin_url"]}/event.php\">ritorna alla schermata di amministrazione</a>.",
	18 => 'Nuovo Evento',
	19 => 'Home Amministrazione',
    20 => 'Salva',
    21 => 'cancella',
    22 => 'Elimina'
);

###############################################################################
# link.php

$LANG23 = array(
	1 => "Editor Link",
	2 => "",
	3 => "Titolo Link",
	4 => "URL Link",
	5 => "Categoria",
	6 => "(includi http://)",
	7 => "Altro",
	8 => "Link Hits",
	9 => "Descrizione Link",
	10 => "Devi fornire un Titolo Link, URL e Descrizione.",
	11 => "Amministrazione Link",
	12 => "Per modificare o cancellare un link, clicca sul link sottostante.  <br>Per creare un nuovo link clicca su [ Nuovo Link ] sopra.",
	13 => "Titolo Link",
	14 => "Categoria Link",
	15 => "Link URL",
	16 => "Accesso Negato",
	17 => "Stai tentando di accedere a un link del quale non hai i permessi di modifica.  Questo tentativo sar&agrave; registrato. Prego <a href=\"{$_CONF["site_admin_url"]}/link.php\">ritorna alla schermata di amministrazione</a>.",
	18 => 'Nuovo Link',
	19 => 'Home Amministrazione',
	20 => 'Se altro, specifica',
        21 => 'Salva',
        22 => 'Cancella',
        23 => 'Elimina'
);

###############################################################################
# story.php

$LANG24 = array(
	1 => "Articolo Precedente",
	2 => "Prossimo Articolo",
	3 => "Modo",
	4 => "Modo Ins.",
	5 => "Editor Articoli",
	6 => "Non ci sono articoli nel sistema",
	7 => "Autore",
	8 => "Salva",
	9 => "Anteprima",
	10 => "Cancella",
	11 => "Elimina",
	12 => "",
	13 => "Titolo",
	14 => "Argomento",
	15 => "Data",
	16 => "Testo Intro",
	17 => "Corpo",
	18 => "Visite",
	19 => "Commenti",
	20 => "",
	21 => "",
	22 => "Lista Articoli",
	23 => "Per modificare o cancellare un articolo, clicca sul numero dell'articolo. <br>Per visualizzare un articolo, clicca sul titolo dell'articolo desiderato. <br>Per creare un nuovo articolo clicca su [ Nuovo Articolo ] sopra.",
	24 => "",
	25 => "",
	26 => "Anteprima Articolo",
	27 => "",
	28 => "",
	29 => "",
	30 => 'Errore nel caricamento File',
	31 => "Prego compila i campi di testo Titolo e Intro",
	32 => "Evidenz.",
	33 => "Ci pu&ograve; essere solo un articolo Evidenziato",
	34 => "Draft",
	35 => "Si",
	36 => "No",
	37 => "Altro da",
	38 => "Altro su",
	39 => "Emails",
	40 => "Accesso negato",
	41 => "Stai tentando di accedere a un articolo dove non hai i permessi di accesso.  Questo tentativo sar&agrave; tracciato.  You may view the article in read-only below. Prego <a href=\"{$_CONF["site_admin_url"]}/story.php\">ritorna alla schermata amministrazione articoli</a> una volta terminato.",
	42 => "Stai tentando di accedere a un articolo dove non hai i permessi di accesso.  Questo tentativo sar&agrave; tracciato.  Prego <a href=\"{$_CONF["site_admin_url"]}/story.php\">ritorna alla schermata amministrazione articoli</a>.",
	43 => 'Nuovo Articolo',
	44 => 'Home Amministrazione',
	45 => 'Accesso',
        46 => '<b>NOTA:</b> se modifichi questa data postadatandola, questo articolo non sar&agrave; pubblicato fino a suddetta data.  Questo significa inoltre che l\'articolo non sar&agrave; incluso nel tuo <em>RDF headline</em> e verr&agrave; ignorato dalla ricerca e dalle statistiche.',
        47 => 'Immagini',
        48 => 'immagine',
        49 => 'destra',
        50 => 'sinistra',
        51 => 'Per aggiungere una delle immagini in allegato a questo articolo devi inserire del codice di testo speciale.  Questo codice speciale &egrave; [immagineX], [immagineX_destra] o [immagineX_sinistra] dove X &egrave; il numero della immagine allegata.  <br>NOTA: Devi utilizzare le immagini allegate.  Altrimenti non sarai in grado di salvare il tuo articolo.<BR><P><B>ANTEPRIMA</B>: L\'Anteprima di un articolo con immagini allegate risulta pi&ugrave; agevole da realizzare salvandolo come un draft AL POSTO di cliccare sul bottone anteprima.  Usare il bottone anteprima solo con immagini che non sono allegate.',
        52 => 'Elimina',
        53 => 'non &egrave; utilizzata.  Devi includere questa immagine nell\'intro o nel corpo per poter salvare le tue modifiche',
        54 => 'Immagini in Allegato Non Usate',
        55 => 'Si sono verificati i seguenti errori durante il salvataggio del tuo articolo.  Prego correggi gli errori prima di salvarlo',
        56 => 'Mostra Icona Argomento',
        57 => 'Mostra Immagine non ridimensionata'
);

###############################################################################
# poll.php

$LANG25 = array(
	1 => "Modo",
	2 => 'Prego inserisci una <em>domanda</em> e almeno una <em>risposta</em>.',
	3 => "Sondaggio Creato il:",
	4 => "Sondaggio $qid salvato",
	5 => "Modifica Sondaggio",
	6 => "ID Sondaggio",
	7 => "(non utilizzare spazi)",
	8 => "Mostra in Homepage",
	9 => "Domanda",
	10 => "Risposte / Voti",
	11 => "Si sono verificati dei problemi durante l'acquisizione dei dati per la risposta a riguardo del sondaggio $qid",
	12 => "Si sono verificati dei problemi durante l'acquisizione dei dati per la domanda a riguardo del sondaggio $qid",
	13 => "Crea Sondaggio",
	14 => "Salva",
	15 => "Cancella",
	16 => "Elimina",
	17 => 'Prego inserisci un ID per il sondaggio',
	18 => "Lista Sondaggi",
	19 => "Per modificare o cancellare un sondaggio, clicca sul sondaggio desiderato.  <br>Per creare un nuovo sondaggio clicca su [ Nuovo Sondaggio ] sopra.",
	20 => "Voti",
	21 => "Accesso Negato",
	22 => "Stai tentando di accedere a un sondaggio del quale non hai i permessi di modifica.  Questo tentativo sar&agrave; registrato. Prego <a href=\"{$_CONF["site_admin_url"]}/poll.php\">ritorna alla schermata amministrazione sondaggi</a>.",
	23 => 'Nuovo Sondaggio',
	24 => 'Home Amministrazione',
	25 => 'Si',
	26 => 'No'
);

###############################################################################
# topic.php

$LANG27 = array(
	1 => "Editor Argomento",
	2 => "ID Argomento",
	3 => "Nome Argomento",
	4 => "Immagine Argomento",
	5 => "(non utilizzare spazi)",
	6 => "Cancellando un argomento cancellerai anche gli articoli e i blocchi associati allo stesso",
	7 => "Prego compila i campi ID Argomento e Nome Argomento",
	8 => "Manager Argomenti",
	9 => "Per modificare o cancellare un argomento, clicca sull'argomento selezionato.  <br>Per creare un nuovo argomento clicca sul [ Nuovo Argomento ] in alto. <br>Dovresti trovare il tuoi permessi di accesso per ogni argomento elencati fra parentesi. L'Asterisco (*) indica l'argomento di default.",
	10=> "Ordinamento",
	11 => "Articoli/Pagina",
	12 => "Accesso negato",
	13 => "Stai cercando di accedere a un argomento del quale non hai i permessi di visualizzazione.  Questo tentativo &egrave; stato registrato. Prego <a href=\"{$_CONF["site_admin_url"]}/topic.php\">ritorna alla pagina amministrazione argomenti</a>.",
	14 => "Metodo Ordinamento",
	15 => "alfabetico",
	16 => "per definizione &egrave;",
	17 => "Nuovo Argomento",
	18 => "Home Amministrazione",
	19 => 'Salva',
    	20 => 'Cancella',
    	21 => 'Elimina',
    	22 => 'Default',
        23 => 'fai di questo l\'argomento di default per gli inserimenti dei nuovi articoli',
        24 => '(*)'
);

###############################################################################
# user.php

$LANG28 = array(
	1 => "Editor Utenti",
	2 => "ID Utente",
	3 => "Nome Utente",
	4 => "Nome Completo",
	5 => "Password",
	6 => "Livello di Sicurezza",
	7 => "Indirizzo E-Mail",
	8 => "Homepage",
	9 => "(non utilizzare spazi)",
	10 => "Prego compila i campi NomeUtente e Indirizzo E-Mail",
	11 => "Manager Utenti",
	12 => "Per modificare o cancellare un utente, clicca su un utente qu&igrave; sotto.  <br>Per creare un nuovo utente clicca sul bottone [ Nuovo Utente ] in alto. <br>Per eseguire una ricerca semplice inserisci parti di nome utente,indirizzo e-mail o nome completo (es.*son* or *.edu) nel modulo sottostante.",
	13 => "SecLev",
	14 => "Data Reg.",
	15 => 'Nuovo Utente',
	16 => 'Home Amministrazione',
	17 => 'modificapw',
	18 => 'Cancella',
	19 => 'Elimina',
	20 => 'Salva',
        21 => 'Il Nome Utente che stai tentando di salvare &egrave; gi&agrave; presente nel database.',
        22 => 'Errore',
        23 => 'Aggiungi Batch ',
        24 => 'Importazione Batch di Utenti',
        25 => 'Puoi importare un batch di utenti in Geeklog.  Il file da importare deve essere delimitato da tab di spaziatura e deve avere i campi nel seguente ordine: nome completo, nome utente, indirizzo e-mail.  a ogni utente che importi sar&agrave; inviata una mail con una password casuale.  Devi avere un utente per ogni riga del file.  La non corretta esecuzione delle seguenti istruzioni potrebbe causare problemi risolvibili solo con del lavoro manuale sul database, quindi fai molta attenzione alle tue operazioni!',
        26 => 'Ricerca',
        27 => 'Risultati limite',
        28 => 'Clicca qu&igrave; per cancellare questa immagine',
        29 => 'Percorso',
        30 => 'Importa',
        31 => 'Nuovo Utente',
        32 => 'Processo Eseguito. Importato $successes e incontrati $failures problemi',
        33 => 'invia',
        34 => 'Errore: Devi specificare un file da caricare.',
        35 => 'Ultimo Login',
        36 => '(mai)'
);


###############################################################################
# moderation.php

$LANG29 = array(
	1 => "Approva",
	2 => "Cancella",
	3 => "Modifica",
	4 => 'Profilo',
	10 => "Titolo",
	11 => "Data inizio",
	12 => "URL",
	13 => "Categoria",
	14 => "Data",
	15 => "Argomento",
	16 => 'Nome Utente',
	17 => 'Nome Completo',
	18 => 'Email',
	34 => "Comandi a Controlli",
	35 => "Inserimento Articolo",
	36 => "Inserimento Link",
	37 => "Inserimento Evento",
	38 => "Invia",
	39 => "Non ci sono inserimenti da moderare al momento",
	40 => "Inserimenti Utente"
);

###############################################################################
# calendar.php

$LANG30 = array(
	1 => "Domenica",
	2 => "Luned&igrave;",
	3 => "Marted&igrave;",
	4 => "Mercoled&igrave;",
	5 => "Gioved&igrave;",
	6 => "Venerd&igrave;",
	7 => "Sabato",
	8 => "Tutti gli eventi",
	9 => "Eventi %s",
	10 => "Eventi per",
	11 => "Calendario Principale",
	12 => "Il mio calendario",
	13 => "Gennaio",
	14 => "Febbraio",
	15 => "Marzo",
	16 => "Aprile",
	17 => "Maggio",
	18 => "Giugno",
	19 => "Luglio",
	20 => "Agosto",
	21 => "Settembre",
	22 => "Ottobre",
	23 => "Novembre",
	24 => "Dicembre",
	25 => "Ritorna a ",
        26 => "Tutti i giorni",
        27 => "Settimana",
        28 => "Calendario personale per",
        29 => "Calendario pubblico",
        30 => "Cancella evento",
        31 => "Inserisci",
        32 => "Evento",
        33 => "Data",
        34 => "Tempo",
        35 => "Inserimento veloce",
        36 => "Invia",
        37 => "Spiacenti, la funzione calendario personale non &egrave; abilitato su questo sito",
        38 => "Editor Eventi Personali",
        39 => 'Giorno',
        40 => 'Settimana',
        41 => 'Mese'
);

###############################################################################
# admin/mail.php
$LANG31 = array(
 	1 => $_CONF['site_name'] . " Mail Utility",
 	2 => "Da",
 	3 => "Rispondi a",
 	4 => "Soggetto",
 	5 => "Commento",
 	6 => "Invia a:",
 	7 => "Tutti gli utenti",
 	8 => "Amministrazione",
	9 => "Opzioni",
	10 => "HTML",
 	11 => "Messaggio urgente!",
 	12 => "Invia",
 	13 => "Azzera",
 	14 => "Ignora preferenze utente",
 	15 => "Errore nell'invio a: ",
	16 => "Messaggio inviato correttamente a: ",
	17 => "<a href=" . $_CONF["site_admin_url"] . "/mail.php>Invia un'altro messaggio</a>",
        18 => "A",
        19 => "NOTA: se vuoi inviare un messaggio a tutti i membri del sito, seleziona il gruppo Logged-in Users dalla lista.",
        20 => "Messaggi inviati con successo <successcount> e messaggi non inviati <failcount>.  Se lo necessiti, i dettagli di ogni messaggio sono elencati sotto.  Altrimenti puoi <a href=\"" . $_CONF['site_admin_url'] . "/mail.php\">Inviare un'altro messaggio</a> o puoi <a href=\"" . $_CONF['site_admin_url'] . "/moderation.php\">ritornare alla pagina amministrazione</a>.",
        21 => 'Fallito',
        22 => 'Eseguito con successo',
        23 => 'Nessun errore',
        24 => 'Nessuna esecuzione',
        25 => '-- Seleziona Gruppo --',
        26 => "Prego compila tutti i campi del modulo e seleziona un gruppo dal men&ugrave;  a tendina."
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "La password &egrave; stata inviata all'indirizzo email da te fornito, dovrebbe arrivare a momenti. Prego segui le istruzioni del messaggio per accedere al sito e grazie per il tuo supporto a " . $_CONF["site_name"],
	2 => "Grazie per aver inserito un articolo in {$_CONF["site_name"]}.  L'evento &egrave; stato inviato al nostro staff per l'approvazione. Se approvato, il tuo articolo sar&agrave; disponibile per la visualizzazione nel nostro sito.",
	3 => "Grazie per aver inserito un link in {$_CONF["site_name"]}.  L'evento &egrave; stato inviato al nostro staff per l'approvazione.  Se approvato il tuo link sar&agrave; visibile nella sezione <a href={$_CONF["site_url"]}/links.php>links</a>.",
	4 => "Grazie per aver inserito un evento in {$_CONF["site_name"]}.  L'evento &egrave; stato inviato al nostro staff per l'approvazione.  Se approvato, il tuo evento sar&agrave; visibile nel nostro <a href={$_CONF["site_url"]}/calendar.php>calendario</a>.",
	5 => "Le tue informazioni utente sono state salvate correttamente.",
	6 => "Le tue preferenze di visualizzazione sono state salvate correttamente.",
	7 => "Le tue preferenze commenti sono state salvate correttamente.",
	8 => "Sei uscito dall'area utenti correttamente.",
	9 => "Il tuo articolo &egrave; stato salvato correttamente.",
	10 => "L'articolo &egrave; stato cancellato correttamente.",
	11 => "Il tuo blocco &egrave; stato salvato correttamente.",
	12 => "Il blocco &egrave; stato cancellato correttamente.",
	13 => "Il tuo argomento &egrave; stato salvato correttamente.",
	14 => "L'argomento e tutte le storie e blocchi associati sono stati cancellati correttamente.",
	15 => "Il tuo link &egrave; stato salvato correttamente.",
	16 => "Il link &egrave; stato cancellato correttamente.",
	17 => "Il tuo evento &egrave; stato salvato correttamente.",
	18 => "L'evento &egrave; stato cancellato correttamente.",
	19 => "Il tuo sondaggio &egrave; stato salvato correttamente.",
	20 => "La votazione &egrave; stata cancellata correttamente.",
	21 => "Il nuovo utente &egrave; stato salvato correttamente.",
	22 => "L'utente &egrave; stato cancellato correttamente",
	23 => "Errore durante il tentativo di aggiungere l'evento al tuo calendario. ID Evento mancante.",
	24 => "L'Evento &egrave; stato salvato correttamente  nel tuo calendario",
	25 => "Impossibile aprire il calendario personale, entra prima nel sito",
	26 => "L'Evento &egrave; stato rimosso correttamente dal tuo calendario personale",
	27 => "Il Messaggio &egrave; stato inviato correttamente.",
	28 => "Il plug-in &egrave; stato salvato correttamente",
	29 => "Spiacenti, il calendario personale non &egrave; abilitato su questo sito",
	30 => "Accesso negato",
	31 => "Spiacenti, non hai i permessi per accedere alla pagina amministrazione articoli.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
	32 => "Spiacenti, non hai i permessi per accedere alla pagina amministrazione argomenti.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
	33 => "Spiacenti, non hai i permessi per accedere alla pagina amminitrazione blocchi.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
	34 => "Spiacenti, non hai i permessi per accedere alla pagina amministrazione link.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
	35 => "Spiacenti, non hai i permessi per accedere alla pagina amministrazione eventi.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
	36 => "Spiacenti, non hai i permessi per accedere alla pagina amministrazione sondaggi.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
	37 => "Spiacenti, non hai i permessi per accedere alla pagina amministrazione utenti.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
	38 => "Spiacenti, non hai i permessi per accedere alla pagina amministrazione plugin.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
	39 => "Spiacenti, non hai i permessi per accedere alla pagina amministrazione mail.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
	40 => "Messaggio di Sistema",
        41 => "Spiacenti, non hai i permessi per accedere alla pagina sostituzione parole.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
        42 => "La tua parola &egrave; stata salvata correttamente.",
        43 => "La parola &egrave; stata cancellata correttamente.",
        44 => 'Il plug-in &egrave; stato installato correttamente!',
        45 => 'Il plug-in &egrave; stato cancellato correttamente.',
        46 => "Spiacenti, non hai i permessi per accedere all'utility database backup.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
        47 => "Questa funzionalit&agrave; lavora solo sotto *nix.  Se Geeklog sta girando sotto un sistema operativo *nix la tua cache verr&agrave; regolarmente azzerata. Se sei su Windows, dovrai necessariamente cercare i files con nome adodb_*.php e rimuoverli manualmente.",
        48 => 'Grazie per la tua richiesta di registrazione a ' .$_CONF['site_name'] . '. Il nostro Team valuter&agrave; la tua richiesta. Se approvata ti verr&agrave; inviata via posta elettronica la password alla casella email da te specificata.',
        49 => "Il tuo gruppo &egrave; stato salvato correttamente.",
        50 => "Il gruppo &egrave; stato cancellato correttamente.",
        51 => 'Questo Nome Utente &egrave; gi&agrave; in uso. Prego selezionane un\'altro.',
        52 => 'L\'indirizzo email da t&egrave; inserito non sembra essere un indirizzo email valido.',
        53 => 'La tua nuova password &egrave; stata accettata. Prego usa la tua nuova password per riaccedere al sito.',
        54 => 'La tua richiesta per una nuova password &egrave; spirata. Prego riprova di nuovo.',
        55 => 'Una email ti &egrave; stata inviata e dovrebbe arrivare a breve. Prego segui le istruzioni contentute nel messaggio per impostare una nuova password per il tup account.',
        56 => 'L\'indirizzo email da te fornito &egrave; gi&agrave; in uso per un altro account.',
        57 => 'Il tuo account &grave; stato eliminato.'
);

// for plugins.php

$LANG32 = array (
	1 => "L'Installazione dei plug-in potrebbe rovinare la tua installazione di Geeklog e presumibilmente anche il tuo sistema.  E' importante che tu installi solo i plugin scaricati da <a href=\"http://www.geeklog.net\" target=\"_blank\">Geeklog Homepage</a> in quanto questi plugin vengono regolarmente testati da noi su numerosi sistemi operativi.  E' altres&igrave; importante che tu capisca che il processo di installazione richiede alcune esecuzioni di comandi di sistema che potrebbero intaccare la sicurezza del sistema stesso (in particolare se utilizzi plugin di terze parti).  Preso per compreso l'avvertimento, noi non garantiamo il successo della installazione e non siamo responsabili di eventuali danni causati dall'installazione del plugin.  In poche parole, installa a tuo rischio!.  Per il modo, indirizzamento e come installare manualmente il plugin consulta gli how-to forniti con il pacchetto del plugin.",
	2 => "Note di Installazione Plug-in",
	3 => "Modulo Installazione Plug-in",
	4 => "Plug-in File",
	5 => "Lista Plug-in",
	6 => "Attenzione: Plug-in gi&agrave; installato!",
	7 => "Il plug-in che vuoi installare &egrave; gia installato nel sistema.  Cancella il plugin esistente prima di reinstallare la nuova versione",
	8 => "Controllo Compatibilit&agrave; Plugin Fallita",
	9 => "Questo plug-in richiede una nuova versione di Geeklog. Puoi aggiornare la tua copia di <a href=http://www.geeklog.net>Geeklog</a> o prendere una nuova versione del plug-in.",
	10 => "<br><b>Al momento nessun plug-in risulta installato.</b><br><br>",
	11 => "Per modificare o cancellare un plug-in, clicca sul numero del plug-in dalla lista sottostante. <br>Per apprendere su come usare il plug-in, clicca sul nome del plug-in e sarai redirezionato direttamente al sito del plug-in. <br>Per installare o aggiornare un plug-in clicca su nuovo-plug-in sopra.",
	12 => 'nessun nome di plugin fornito da plugineditor()',
	13 => 'Editor Plugin',
	14 => 'Nuovo Plug-in',
	15 => 'Home Amministrazione',
	16 => 'Nome Plug-in',
	17 => 'Versione Plug-in',
	18 => 'Versione Geeklog',
	19 => 'Abilitato',
	20 => 'Si',
	21 => 'No',
	22 => 'Installa',
        23 => 'Salva',
        24 => 'Cancella',
        25 => 'Elimina',
        26 => 'Nome Plug-in',
        27 => 'Homepage Plug-in',
        28 => 'Versione Plug-in',
        29 => 'Versione Geeklog',
        30 => 'Cancella Plug-in?',
        31 => 'Sei sicuro di voler cancellare questo plug-in?  Facendo questo cancellerai anche tutti i file associati, dati e struttura che questo plug-in usa.  Se sei sicuro, clicca cancella nel modulo sottostante.'
);

$LANG_ACCESS = array(
	access => "Accessi",
        ownerroot => "Proprietario/Root",
        group => "Gruppo",
        readonly => "Sola-Lettura",
	accessrights => "Permessi di Accesso",
	owner => "Proprietario",
	grantgrouplabel => "Grant Above Group Edit Rights",
	permmsg => "NOTA: membri sono tutti gli utenti registrati nel sito e anonimi tutti i rimanenti visitatori non registrati.",
	securitygroups => "Sicurezza Gruppi",
	editrootmsg => "Ricorda! Anche se sei un Utente Amministratore, non puoi modificare l'utente root senza prima essere entrato con l'account di root.  Puoi modificare tutti gli gli altri utenti ad eccezzione dell'utente root. Prego nota che tutti i tentativi di modificare illegalmente l'utente root vengono registrati.  Ritorna a <a href=\"{$_CONF["site_admin_url"]}/user.php\">Pagina Amministrazione Utenti</a>.",
	securitygroupsmsg => "Seleziona la casella per i gruppi nei quali vuoi inserire l'utente.",
	groupeditor => "Editor Gruppi",
	description => "Descrizione",
	name => "Nome",
 	rights => "Permessi",
	missingfields => "Campi Mancanti",
	missingfieldsmsg => "Devi fornire un nome e una descrizione per il gruppo",
	groupmanager => "Manager Gruppi",
	newgroupmsg => "Per modificare o cancellare un gruppo, selezionalo dalla lista sottostante. <br>Per creare un nuovo gruppo clicca su [ Nuovo Gruppo ] sopra. <br>Considera che il gruppo principale non pu&ograve;  essere cancellato in quanto usato dal sistema.",
	groupname => "Nome Gruppo",
	coregroup => "Gruppo Principale",
	yes => "Si",
	no => "No",
	corerightsdescr => "Questo Gruppo di {$_CONF["site_name"]} &egrave; il gruppo principale.  Per definizione i permessi di questo gruppo non possono essere modificati.  Sotto c'&egrave; la lista in sola lettura dei permessi a cui questo gruppo ha accesso.",
	groupmsg => "Il modello di sicurezza per i Gruppi in questo sito &egrave; di tipo gerarchico.  Aggiungendo questo gruppo a uno qualsiasi dei gruppi elencati sotto fa s&igrave; che il gruppo prenda gli stessi permessi del gruppo superiore.  Dove possibile siete incoraggiati a usare i gruppi sottostanti per dare i permessi al gruppo.  Se avete necessit&agrave; di dare dei permessi personalizzati al gruppo potete selezionare i permessi fra le varie funzioni del sito nella sezione chiamata 'Permessi'.  Per aggiungere questo gruppo a uno dei gruppi sottostanti seleziona la spunta nella caselle del gruppo(i) che desideri modificare.",
	coregroupmsg => "Questo gruppo &egrave; il gruppo principale di {$_CONF["site_name"]} .  Normalmente i gruppi che sono sottostanti a questo gruppo non posono essere modificati.  Sotto puoi trovare una lista in sola lettura dei gruppi associati a questo gruppo.",
	rightsdescr => "Alcuni permessi di accesso ai gruppi possono essere settati direttamente al gruppo o a un gruppo differente facente parte del gruppo.  Quelli che vedi sotto non selezionati sono i permessi che sono stati impostati a questo gruppo in quanto facente parte di altri gruppi e quindi ereditati.  I permessi selezionabili sono i permessi che posono essere dati direttamente a questo gruppo.",
	lock => "Bloccato",
	members => "Membro",
	anonymous => "Anonimo",
	permissions => "Permessi",
	permissionskey => "R = lettura, E = modifica, permesso di modifica implica permessi di lettura",
	edit => "Modifica",
	none => "Nessuno",
	accessdenied => "Accesso negato",
	storydenialmsg => "Non disponi dei permessi per visualizzare questa storia.  Questo perch&egrave; non sei un membro registrato di {$_CONF["site_name"]}.  Prego <a href=users.php?mode=new> diventa un membro</a> of {$_CONF["site_name"]} per avere pieno accesso al sito!",
	eventdenialmsg => "Non disponi dei permessi per visualizzare questo evento.  Questo perch&egrave; non sei un membro registrato di {$_CONF["site_name"]}.  Prego <a href=users.php?mode=new> diventa un membro</a> of {$_CONF["site_name"]} per avere pieno accesso al sito!",
	nogroupsforcoregroup => "Questo Gruppo non ha alcun collegamento con gli altri gruppi",
	grouphasnorights => "Questo Gruppo non ha accesso a nessuna funzione amministrativa del sito",
	newgroup => 'Nuovo Gruppo',
	adminhome => 'Home Amministratore',
	save => 'Salva',
	cancel => 'Cancella',
	delete => 'Elimina',
	canteditroot => 'Hai provato a editare il Gruppo Root ma non fai parte del gruppo stesso e quindi la tua modifica non &egrave; consentita. Prego contatta gli Amministratori se ritieni questo messaggio un errore',
	listusers => 'Lista Utenti',
        listthem => 'lista',
        usersingroup => 'Utenti nel gruppo %s'
);

#admin/word.php
$LANG_WORDS = array(
        editor => "Editor Sostituzione Parole",
        wordid => "ID Parola",
        intro => "Per modificare o cancellare una parola, clicca sulla parola selezionata.  Per creare una nuova sostituzione parola clicca su [ Nuova Parola ] a sinistra.",
        wordmanager => "Lista Parole",
        word => "Parola",
        replacmentword => "Sostituzione Parola",
        newword => "Nuova Parola"
);

$LANG_DB_BACKUP = array(
        not_found => "Percorso non corretto o utility mysqldump non eseguibile.<br>Controlla il percorso <strong>\$_DB_mysqldump_path</strong> in config.php.<br>La variabile attualmente &egrave; definit&agrave; come: <var>{$_DB_mysqldump_path}</var>",
        last_ten_backups => 'Ultimi 10 Back-ups',
        do_backup => 'Esegui il Backup',
        backup_successful => 'Il Back up &egrave; stato eseguito con successo.',
        no_backups => 'Nessun backups del sistema',
        db_explanation => 'Per creare un nuovo Backup del tuo sistema Geeklog, clicca sul bottone sottostante',
        zero_size => 'Backup Fallito: La dimensione del File era di 0 bytes',
        path_not_found => "{$_CONF['backup_path']} non esiste o non &egrave; una directory",
        no_access => "ERRORE: La Directory {$_CONF['backup_path']} non &egrave; accessibile.",
        backup_file => 'Backup file', 
        size => 'Dim.',
        bytes => 'Bytes',
        total_number => 'Numero Totale di backups: %d'
);

$LANG_BUTTONS = array(
        1 => "Home",
        2 => "Contatti",
        3 => "Pubblica",
        4 => "Links",
        5 => "Sondaggi",
        6 => "Calendario",
        7 => "Statistiche Sito",
        8 => "Personalizza",
        9 => "Ricerca",
        10 => "Ricerca Avanzata"
);

$LANG_404 = array(
        1 => "Errore 404",
        2 => "Attenzione, Abbiamo cercato in tutto il sito ma l'argomento <b>%s</b> non &egrave; stato trovato.",
        3 => "Siamo spiacenti, ma il file da te richiesto non esiste.  Prego controlla nella pagina principale o nella pagina di ricerca per vedere se puoi trovare quanto da te richiesto."  
);

$LANG_LOGIN = array (
        1 => 'Login richiesto',
        2 => 'Spiacenti, per accedere a questa area devi essere registrato come utente.',
        3 => 'Entra',
        4 => 'Nuovo Utente'
);

?>

<?php

###############################################################################
# italian.php
# Questa è la traduzione italiana per GeekLog!
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
# COMMERCIABILITA' o USO PER SCOPI PARTICOLARI. Vedi la
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
	25 => "Rispondi",
	26 => "I seguenti commenti sono proprietà di chi li ha inviati. Questo sito non è responsabile dei contenuti degli stessi.",
	27 => "Inserimenti più recenti",
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
	49 => "Visualizza Preferenze",
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
	73 => "Incolla sondaggi",
	74 => "Calendario",
	75 => "Ricerca Avanzata",
	76 => "Statistiche del sito",
	77 => "Plugins",
	78 => "Eventi in arrivo",
	79 => "Novità",
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
	91 => "Crea questa pagina in",
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
    105 => 'Utenti Mail',
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
	8 => 'Aggiungendo questo evento al tuo calendario potrai accedere in modo veloce a tutti gli eventi a cui sei interessato cliccando su "Mio calendario" dalla sezione "Menù Utente".',
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
	5 => "Nomeutente",
	6 => "Per poter inserire un commento su questo sito è necessario loggarsi.  Se ancora non hai un account puoi usare il modulo sottostante per crearne uno.",
	7 => "Il tuo ultimo commento risale a ",
	8 => " secondi fà.  Devi attendere {$_CONF["commentspeedlimit"]} secondi per inserire un nuovo commento",
	9 => "Commento",
	10 => '',
	11 => "Inserisci Commento",
	12 => "Per poter inserire un commento è necessario riempire tutti i campi.",
	13 => "Le tue info",
	14 => "Anteprima",
	15 => "",
	16 => "Titolo",
	17 => "Errore",
	18 => 'Materiale Importante',
	19 => 'Per favore prova a mantenere questo inserimeno in cima agli argomenti.',
	20 => 'Prova a rispondere ad un commento di un altro utente anzichè aprire un nuovo post.',
	21 => 'Leggi i messaggi degli altri utenti prima di inviare il tuo in maniera da evitare messaggi doppi.',
	22 => 'Usa un soggeto che descriva l\'argomento del messaggio.',
	23 => 'Il tuo indirizzo email non sarà reso pubblico.',
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
	14 => "Questa password è generata in maniera casuale. Si raccomanda di cambiare la password al più presto. Per cambiare la password, loggarsi e cliccare su Informazioni Account dal menù utente.",
	15 => "Il tuo account su {$_CONF["site_name"]} è stato creato con successo. Per entrare nel sito usa le informazioni sottostanti. Si consiglia di salvare la mail per non perdere i dati dell'account.",
	16 => "Informazioni del tuo account",
	17 => "L'Account non esiste",
	18 => "L'indirizzo email fornito non è un indirizzo valido",
	19 => "Il nome utente o l'indirizzo email fornito è già esistente",
	20 => "L'indirizzo email fornito non è un indirizzo valido",
	21 => "Errore",
	22 => "Registrati in {$_CONF['site_name']}!",
	23 => "La creazione di un Account Utente da la possibilità di partecipare alla costruzione di {$_CONF['site_name']} e ti permette di inviare commenti e articoli da te realizzati. Senza un Account sarai in grado di inserire solo come Anonimo. Prego nota che il tuo indirizzo email non sarà<b><i>mai</i></b> disponibile pubblicamente o visualizzata nel sito.",
	24 => "La tua password sarà inviata all'indirizzo da te inserito.",
	25 => "Ti sei dimenticato la tua password?",
	26 => "Inserisci il tuo Nome Utente e clicca su Email Password e una nuova password ti sarà inviata all'indirizzo registrato nel nostro database.",
	27 => "Registrati Ora!",
	28 => "Email Password",
	29 => "uscito da",
	30 => "entrato in",
	31 => "La funzione da te selezionata richiede la tua autenticazione",
	32 => "Firma",
	33 => "Mai disponibile pubblicamente",
	34 => "Questo è il tuo vero nome",
	35 => "Inserisci una password per cambiarla",
	36 => "Iniziando con http://",
	37 => "Applicato ai tuoi commenti",
	38 => "Informazioni Aggiuntive! Tutti possono leggere questo",
	39 => "La tua chiave pubblica PGP key da condividere",
	40 => "No Icone Argomenti",
	41 => "Modererà",
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
	52 => "Per definizione è",
	53 => "Ricevi gli articoli giornalieri ogni notte",
	54 => "Seleziona l'opzione per gli articoli e gli autori che non vuoi vedere.",
	55 => "Se lasci questo non selezionato, significa che vuoi lasciare la selezione di definizione. Se inizi a selezionare le opzioni ricordati di settare tutti quelli desiderati in quanto la configurazione di definizione verrà ignorata. Le selezioni di definizione sono visualizzate in grassetto.",
	56 => "Autori",
	57 => "Modo Visualizzazione",
	58 => "Ordinamento",
	59 => "Limiti per i commenti",
	60 => "Come preferisci siano visualizzati i tuoi commenti?",
	61 => "Nuovi o vecchi prima?",
	62 => "Per definizione è 100",
	63 => "La tua password è stata inviata e dovrebbe arrivarti a momenti. Prego segui le istruzioni del messaggio e grazie per la tua partecipazione a " . $_CONF["site_name"],
	64 => "Preferenze Commenti per",
	65 => "Prova a entrare di nuovo",
	66 => "Devi aver digitato male le tue credenziali di accesso.  Prego riprova di nuovo sotto. Sei un <a href=\"{$_CONF['site_url']}/users.php?mode=new\">nuovo utente</a>?",
	67 => "Membro dal",
	68 => "Ricordami per",
	69 => "Per quanto tempo vuoi essere ricordato dopo l'entrata al sito?",
	70 => "Personalizza lo stile e il contenuto per {$_CONF['site_name']}",
	71 => "Una delle funzionalità di {$_CONF['site_name']} è che puoi personalizzare il contenuto che vuoi visualizzare e lo stile con cui visualizzarlo.  Per utilizzare questa funzione devi prima <a href=\"{$_CONF['site_url']}/users.php?mode=new\">registrarti</a> in {$_CONF['site_name']}.  Sei già un membro?  Allora usa il modulo di accesso che trovi alla tua sinistra per entrare!",
    72 => "Tema",
    73 => "Lingua",
    74 => "Cambia lo stile di visualizzazione come preferisci!",
    75 => "Argomento da inviare via mail per",
    76 => "Se selezioni un argomento dalla lista sottostante riceverai via mail ogni nuovo articolo associato all'argomento alla fine della giornata.  Seleziona solo gli argomenti che ti interessano!",
    77 => "Foto",
    78 => "Aggiungi una tua foto!",
    79 => "Seleziona quì per cancellare questa immagine",
    80 => "Entra",
    81 => "Invia E-Mail",
    82 => 'Ultimi 10 articoli dagli utenti',
    83 => 'Statistiche di inserimento per utente',
    84 => 'Numero totale di articoli:',
    85 => 'Numero totale di commenti:',
    86 => 'Trova tutti gli inserimenti di'
);

###############################################################################
# index.php

$LANG05 = array(
	1 => "Nessuna News da visualizzare",
	2 => "<br>Non ci sono nuovi articoli da visualizzare.  Questo perchè o non ci sono nuovi articoli per questo argomento o le tue preferenze utente sono troppo restrittive ",
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
	2 => "Il tuo voto è stato salvato nel sondaggio",
	3 => "Voto",
	4 => "Sondaggi nel sistema",
	5 => "Voti"
);

###############################################################################
# profiles.php

$LANG08 = array(
	1 => "C'è stato un errore nell'invio del tuo messaggio. Prego riprova un'altra volta.",
	2 => "Messaggio inviato correttamente.",
	3 => "Prego assicurati di usare un indirizzo email valido nel campo Rispondi a:.",
	4 => "Prego compila i campi Tuo Nome, Rispondi a:,Soggetto e Messaggio",
	5 => "Errore: Nessun Utente.",
	6 => "C'è stato un errore.",
	7 => "Profilo Utente per",
	8 => "Nome Utente",
	9 => "URL Utente",
	10 => "Invia mail a",
	11 => "Tuo Nome:",
	12 => "Rispondi a:",
	13 => "Soggetto:",
	14 => "Messaggio:",
	15 => "L'HTML non sarà tradotto.",
	16 => "Invia Messaggio",
	17 => "Spedisci l'Articolo a un amico",
	18 => "A Nome",
	19 => "A Indirizzo Email",
	20 => "Da Nome",
	21 => "Da Indirizzo Email",
	22 => "Tutti i campi sono richiesti",
	23 => "Questa e-mail ti è stata inviata da $from aa $fromemail perchè pensa possa interessarti questo articolo proveniente da {$_CONF["site_url"]}.  Questa non è SPAM e il tuo indirizzo e-mail utilizzato in questa operazione non verrà salvato nella lista per un successivo uso.",
	24 => "Commento su questo articolo a",
	25 => "Devi entrare come utente per questa funzione.  Accreditandoti come utente ci aiuti a prevenire eventuali hackeraggi del sistema",
	26 => "Questo modulo ti permette di inviare una e-mail all'utente selezionato.  Tutti i campi sono richiesti.",
	27 => "Messaggio breve",
	28 => "$from scrive: $shortmsg",
    29 => "Questo è il daily digest da {$_CONF['site_name']} per ",
    30 => " Daily Newsletter per ",
    31 => "Titolo",
    32 => "Data",
    33 => "Leggi l'articolo completo su",
    34 => "Fine del messaggio"
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
	24 => "Trovato",
	25 => "risultati per",
	26 => "oggetti in",
	27 => "secondi",
    28 => 'Nessun articolo o commento trovato per la tua ricerca',
    29 => 'Risultato Articoli e Commenti',
    30 => 'Nessun Link trovato per la tua ricerca',
    31 => 'Questo plug-in non restituisce nessun risultato',
    32 => 'Evento',
    33 => 'URL',
    34 => 'Posizione',
    35 => 'Tutti i giorni',
    36 => 'Nessun Evento trovato per la tua ricerca',
    37 => 'Risultato Eventi',
    38 => 'Risultato Links',
    39 => 'Links',
    40 => 'Eventi'
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
	21 => "Sembra che nessuno abbia ancora inviato un link in questo sito o nessuno ha cliccato sui lìnk disponibili.",
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
	1 => "Per inserire un $type è richiesto che tu ti autentifichi come utente.",
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
	14 => "Posizione",
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
	25 => "Il tuo $type inserimento è stato salvato correttamente.",
	26 => "Limite Velocità",
	27 => "Nome Utente",
	28 => "Argomento",
	29 => "Articolo",
	30 => "Il tuo ultimo inserimento risale a ",
	31 => " secondi fa.  Questo sito richiede almeno {$_CONF["speedlimit"]} secondi fra un inserimento e l'altro",
	32 => "Anteprima",
	33 => "Anteprima Articolo",
	34 => "Esci",
	35 => "I tags HTML non sono consentiti",
	36 => "Modo Inserimento",
	37 => "L'Inserimento di un evento in  {$_CONF["site_name"]} metterà il tuo evento nel calendario principale e permetterà agli utenti di aggiungerlo al loro calendario personale. Questa funzione <b>NON</b> è stata realizzata per inserire compleanni o anniversari.<br><br>Una volta inserito sarà inviato al nostro amministratore e se approvato il tuo evento apparirà sul calendario principale.",
    38 => "Aggiungi Evento a",
    39 => "Calendario Principale",
    40 => "Calendario Personale",
    41 => "Ora Fine",
    42 => "Ora Inizio",
    43 => "Evento Giornaliero",
    44 => 'Indirizzo 1',
    45 => 'Indirizzo 2',
    46 => 'Città/Paese',
    47 => 'Stato',
    48 => 'C.A.P.',
    49 => 'Tipo Evento',
    50 => 'Modifica Tipi di Eventi',
    51 => 'Posizione',
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
	1 => "Permessi di Amministratore Insufficienti",
	2 => "Non hai i permessi necessari per modificare questo blocco.",
	3 => "Editor Blocco",
	4 => "",
	5 => "Titolo Blocco",
	6 => "Argomento",
	7 => "Tutti",
	8 => "Livello di Sicurezza Blocco",
	9 => "Ordine Blocco",
	10 => "Tipo Blocco",
	11 => "Blocco Portale",
	12 => "Blocco Normale",
	13 => "Opzioni Blocco Portale",
	14 => "RDF URL",
	15 => "Ultimo Aggiornamento RDF",
	16 => "Opzioni Blocco Normale",
	17 => "Contenuto Blocco",
	18 => "Prego compila i campi Titolo Blocco, Livello di Sicurezza e Contenuto",
	19 => "Manager Blocchi",
	20 => "Titolo Blocco",
	21 => "LivSicur Blocco",
	22 => "Tipo Blocco",
	23 => "Ordine Blocco",
	24 => "Argomento Blocco",
	25 => "Per modificare o cancellare un blocco, clicca sul blocco sotto.  Per creare un nuovo blocco clicca su <b>nuovo blocco</b> sopra.",
	26 => "Layout Blocco",
	27 => "Blocco PHP",
    28 => "Opzioni Blocco PHP",
    29 => "Funzione Blocco",
    30 => "Se hai uno dei tuoi blocchi che usa codice PHP, inserisci il nome della funzione sopra.  Il nome della tua funzione deve iniziare con il prefisso \"phpblock_\" (e.g. phpblock_getweather).  Se la funzione non ha questo prefisso, NON verrà richiamata.  Abbiamo fatto questo per tenere lontano le persone che vogliono hackerare la tua installazione di Geeklog mettendo funzioni arbitrarie che potrebbero danneggiare il tuo sistema.  Assicurati di non inserire parentesi vuote \"()\" dopo il nome della funzione.  Inoltre, ti raccomandiamo che tu metta tutto il tuo codice blocco PHP in /path/to/geeklog/system/lib-custom.php.  Questo permette al codice di rimanere disponibile anche se aggiorni la tua versione di Geeklog ad una nuova versione.",
    31 => "Errore nel blocco PHP.  La funzione, $function, non esiste.",
    32 => "Errore Campo Mancante(i)",
    33 => "Devi inserire l'URL per il file .rdf per il blocco portale",
    34 => "Devi inserire il titolo e la funzione per il blocco PHP",
    35 => "Devi inserire il titolo e il contenuto per il blocco normale",
    36 => "Devi inserire il contenuto per il layout dei blocchi",
    37 => "Nome della funzione blocco PHP errato",
    38 => "Le Funzioni per i blocchi PHP devono avere il prefisso 'phpblock_' (es. phpblock_getweather).  Il prefisso 'phpblock_' prefix è richiesto per ragioni di sicurezza per prevenire l'esecuzione arbitraria del codice.",
	39 => "Lato",
	40 => "Sinistro",
	41 => "Destro",
	42 => "Devi inserire un ordine e un livello di sicurezza per i blocchi di definizione per Geeklog",
	43 => "Solo in Homepage",
	44 => "Accesso negato",
	45 => "Stai cercando di accedere a un blocco del quale non hai i permessi di visualizzazione.  Questo tentativo è stato registrato. Prego <a href=\"{$_CONF["site_admin_url"]}/block.php\">ritorna alla pagina amministrazione blocchi</a>.",
	46 => 'Nuovo Blocco',
	47 => 'Home Amministrazione',
    48 => 'Nome Blocco',
    49 => ' <br>(nessuno spazio e il nome deve essere univoco)',
    50 => 'Help File URL',
    51 => 'includi http://',
    52 => 'Se lasci in bianco l\'icona di help per questo blocco non sarà visualizzata',
    53 => 'Abilitato'
);

###############################################################################
# event.php

$LANG22 = array(
	1 => "Editor Evento",
	2 => "",
	3 => "Titolo Evento",
	4 => "URL Evento",
	5 => "Data Inizio Evento",
	6 => "Data Termine Evento",
	7 => "Posizione Evento",
	8 => "Descrizione Evento",
	9 => "(includi http://)",
	10 => "Devi inserire la data/orario,descrizione e posizionamento evento!",
	11 => "Manager Eventi",
	12 => "Per modificare o cancellare un evento, clicca sull'evento selezionato sottostante.  <br>Per creare un nuovo evento clicca su <b>nuovo evento</b> sopra.",
	13 => "Titolo Evento",
	14 => "Data Inizio",
	15 => "Data Termine",
	16 => "Accesso negato",
	17 => "Stai cercando di accedere a un link del quale non hai i permessi di visualizzazione.  Questo tentativo è stato registrato. Prego <a href=\"{$_CONF["site_admin_url"]}/event.php\">ritorna alla pagina amministrazione eventi</a>.",
	18 => 'Nuovo Evento',
	19 => 'Home Amministrazione'
);

###############################################################################
# link.php

$LANG23 = array(
	1 => "Editor Link",
	2 => "",
	3 => "Titolo Link",
	4 => "Link URL",
	5 => "Categoria",
	6 => "(includi http:// nel URL)",
	7 => "Altro",
	8 => "Visite Link",
	9 => "Descrizione Link",
	10 => "Devi inserire un Titolo, URL e descrizione per il link.",
	11 => "Manager Link",
	12 => "Per modificare o cancellare un link, clicca sul link selezionato sottostante.  <br>Per creare un nuovo link clicca su <b>nuovo link</b> sopra.",
	13 => "Titolo Link",
	14 => "Categoria Link",
	15 => "URL Link",
	16 => "Accesso negato",
	17 => "Stai cercando di accedere a un link del quale non hai i permessi di visualizzazione.  Questo tentativo è stato registrato. Prego <a href=\"{$_CONF["site_admin_url"]}/link.php\">ritorna alla pagina amministrazione link</a>.",
	18 => 'Nuovo Link',
	19 => 'Home Amministrazione',
	20 => 'Se altro, specifica'
);

###############################################################################
# story.php

$LANG24 = array(
	1 => "Articolo Precedente",
	2 => "Prossimo Articolo",
	3 => "Modo",
	4 => "Modo Inserimento",
	5 => "Editor Articoli",
	6 => "",
	7 => "Autore",
	8 => "",
	9 => "",
	10 => "",
	11 => "",
	12 => "",
	13 => "Titolo",
	14 => "Argomento",
	15 => "Data",
	16 => "Testo Intro",
	17 => "Testo Corpo",
	19 => "Commenti",
	20 => "",
	21 => "",
	22 => "Lista Articoli",
	23 => "Per modificare o cancellare un articolo, clicca sul numero della storia selezionata. Per visualizzare l'articolo, clicca sul titolo dell'articolo che desideri vedere. Per creare un nuovo articolo clicca su <b>nuovo articolo</b> sopra.",
	24 => "",
	25 => "",
	26 => "Anteprima articolo",
	27 => "",
	28 => "",
	29 => "",
	30 => "",
	31 => "Prego compila i campi Autore, Titolo, e Testo Intro",
	32 => "Funzione ON",
	33 => "Ci può essere solo un articolo con la Funzione ON",
	34 => "Draft",
	35 => "Si",
	36 => "No",
	37 => "Altro da parte di",
	38 => "Altro da",
	39 => "Emails",
	40 => "Accesso negato",
	41 => "Stai cercando di accedere a un articolo del quale non hai i permessi di modifica.  Questo tentativo è stato registrato.  Puoi vedere l'\articolo in sola letura quì sotto. Prego <a href=\"{$_CONF["site_admin_url"]}/story.php\">ritorna alla pagina amministrazione articoli</a> quando hai finito.",
	42 => "Stai cercando di accedere a un articolo del quale non hai i permessi di modifica.  Questo tentativo è stato registrato.  Prego <a href=\"{$_CONF["site_admin_url"]}/story.php\">ritorna al menu amministrazione</a>.",
	43 => 'Nuovo Articolo',
	44 => 'Amministrazione',
	45 => 'Accesso',
    46 => '<b>NOTA:</b> se modifichi questa data con una data successiva ad oggi questo articolo non sarà pubblicato prima della suddetta data.  Questo significa che l\'articolo non sarà incluso nella testata RDF e sarà ignorato dalle funzioni di ricerca e statistica.',
    47 => 'Immagini',
    48 => 'immagine',
    49 => 'destra',
    50 => 'sinistra',
    51 => 'Per aggiungere una delle immagini che stai allegando a questo articolo è necessario utilizzare dei tag di formattazione particolari.  I tag in questione sono [imageX], [imageX_right] o [imageX_left] dove X è il numero dell\'immagine che hai allegato.  NOTA: Devi utilizzare le immagini che stai allegando.  Se non lo fai non riuscirai a salvare il tuo articolo.<BR><P><B>ANTEPRIMA</B>: Visualizzare una anteprima con le immagini allegate e con metodo draft è il metodo migliore per salvare al posto di cliccare sul bottone Anteprima.  Usa il bottone anteprima solo con immagini non allegate.',
    52 => 'Cancella',
    53 => 'non è utilizzato.  Devi inserire questa immagine nell\'intro o nel corpo dell\'articolo prima di salvare le modifiche',
    54 => 'Immaginini Allegate non utilizzato',
    55 => 'Si sono verificati i seguenti errori durante il salvataggio del tuo articolo.  Prego correggi gli errori prima di salvarlo',
    56 => 'Mostra Icona Argomento'
);

###############################################################################
# poll.php

$LANG25 = array(
	1 => "Modo",
	2 => "",
	3 => "Sondaggio Creato",
	4 => "Sondaggio $qid salvato",
	5 => "Modifica Sondaggio",
	6 => "ID Sondaggio",
	7 => "(non utilizzare spazi)",
	8 => "Visualizza in Homepage",
	9 => "Domanda",
	10 => "Risposte / Voti",
	11 => "C'è un errore nei dati delle risposte riguardo alla votazione $qid",
	12 => "C'è un errore nei dati della domanda riguardo alla votazione $qid",
	13 => "Crea sondaggio",
	14 => "",
	15 => "",
	16 => "",
	17 => "",
	18 => "Lista Sondaggi",
	19 => "Per modificare o cancellare un sondaggio, clicca sul sondaggio selezionato.  <br>Per creare un nuovo sondaggio clicca su <b>nuovo sondaggio</b> sopra.",
	20 => "Votanti",
	21 => "Accesso negato",
	22 => "Stai cercando di accedere a un sondaggio del quale non hai i permessi di visualizzazione.  Questo tentativo è stato registrato. Prego <a href=\"{$_CONF["site_admin_url"]}/poll.php\">ritorna alla pagina amministrazione votazioni</a>.",
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
	9 => "Per modificare o cancellare un argomento, clicca sull'argomento selezionato.  Per creare un nuovo argomento clicca sul bottone a sinistra. Dovresti trovare il tuoi permessi di accesso per ogni argomento elencati fra parentesi.",
	10=> "Ordinamento",
	11 => "Articoli/Pagina",
	12 => "Accesso negato",
	13 => "Stai cercando di accedere a un argomento del quale non hai i permessi di visualizzazione.  Questo tentativo è stato registrato. Prego <a href=\"{$_CONF["site_admin_url"]}/topic.php\">ritorna alla pagina amministrazione argomenti</a>.",
	14 => "Metodo Ordinamento",
	15 => "alfabetico",
	16 => "per definizione è",
	17 => "Nuovo Argomento",
	18 => "Home Amministrazione"
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
	10 => "Prego compila i campi Nomeutente, Nome Completo, Livello di Sicurezza e Indirizzo E-Mail",
	11 => "Manager Utenti",
	12 => "Per modificare o cancellare un utente, clicca su un utente quì sotto.  Per creare un nuovo utente clicca sul bottone <b>nuovo utente</b> a sinistra. Per eseguire una ricerca semplice inserisci parti di nome utente,indirizzo e-mail o nome completo (es.*son* or *.edu) nel modulo sottostante.",
	13 => "SecLev",
	14 => "Data Reg.",
	15 => 'Nuovo Utente',
	16 => 'Home Amministrazione',
	17 => 'modificapw',
	18 => 'azzera',
	19 => 'cancella',
	20 => 'salva',
	18 => 'azzera',
	19 => 'cancella',
	20 => 'salva',
    21 => 'Il nome utente che stai tentando di salvare è già presente nel database.',
    22 => 'Errore',
    23 => 'Aggiungi Batch ',
    24 => 'Importazione Batch di Utenti',
    25 => 'Puoi importare un batch di utenti in Geeklog.  Il file da importare deve essere delimitato da tab di spaziatura e deve avere i campi nel seguente ordine: nome completo, nome utente, indirizzo e-mail.  a ogni utente che importi sarà inviata una mail con una password casuale.  Devi avere un utente per ogni riga del file.  La non corretta esecuzione delle seguenti istruzioni potrebbe causare problemi risolvibili solo con del lavoro manuale sul database, quindi fai molta attenzione alle tue operazioni!',
    26 => 'Ricerca',
    27 => 'Risultati limite',
    28 => 'Clicca quì per cancellare l\'immagine'
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
	2 => "Lunedì",
	3 => "Martedì",
	4 => "Mercoledì",
	5 => "Giovedì",
	6 => "Venerdì",
	7 => "Sabato",
	8 => "Tutti gli eventi",
	9 => "Eventi Geeklog",
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
    30 => "cancella evento",
    31 => "Inserisci",
    32 => "Evento",
    33 => "Data",
    34 => "Tempo",
    35 => "Inserimento veloce",
    36 => "Invia",
    37 => "Spiacenti, la funzione calendario personale non è abilitato su questo sito",
    38 => "Editor Eventi Personali"
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
    19 => "NOTA: se vuoi inviare un messaggio a tutti i membri del sito, selezione il gruppo Logged-in Users dalla lista.",
    20 => "Messaggi inviati con successo <successcount> e messaggi non inviati <failcount>.  Se lo necessiti, i dettagli di ogni messaggio sono elencati sotto.  Altrimenti puoi <a href=\"" . $_CONF['site_admin_url'] . "/mail.php\">Inviare un'altro messaggio</a> o puoi <a href=\"" . $_CONF['site_admin_url'] . "/moderation.php\">ritornare alla pagina amministrazione</a>.",
    21 => 'Fallito',
    22 => 'Eseguito con successo',
    23 => 'Nessun errore',
    24 => 'Nessuna esecuzione',
    25 => '',
    26 => "Prego compila tutti i campi del modulo e seleziona un gruppo dal menù a tendina."
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "La password è stata inviata all'indirizzo email da te fornito, dovrebbe arrivare a momenti. Prego segui le istruzioni del messaggio per accedere al sito e grazie per il tuo supporto a " . $_CONF["site_name"],
	2 => "Grazie per aver inserito un articolo in {$_CONF["site_name"]}.  L'evento è stato inviato al nostro staff per l'approvazione. Se approvato, il tuo articolo sarà disponibile per la visualizzazione nel nostro sito.",
	3 => "Grazie per aver inserito un link in {$_CONF["site_name"]}.  L'evento è stato inviato al nostro staff per l'approvazione.  Se approvato il tuo link sarà visibile nella sezione <a href={$_CONF["site_url"]}/links.php>links</a>.",
	4 => "Grazie per aver inserito un evento in {$_CONF["site_name"]}.  L'evento è stato inviato al nostro staff per l'approvazione.  Se approvato, il tuo evento sarà visibile nel nostro <a href={$_CONF["site_url"]}/calendar.php>calendario</a>.",
	5 => "Le tue informazioni utente sono state salvate correttamente.",
	6 => "Le tue preferenze visualizzazione sono state salvate correttamente.",
	7 => "Le tue preferenze commenti sono state salvate correttamente.",
	8 => "Sei uscito dall'area utenti correttamente.",
	9 => "Il tuo articolo è stato salvato correttamente.",
	10 => "L'articolo è stato cancellato correttamente.",
	11 => "Il tuo blocco è stato salvato correttamente.",
	12 => "Il blocco è stato cancellato correttamente.",
	13 => "Il tuo argomento è stato salvato correttamente.",
	14 => "L'argomento e tutte le storie e blocchi associati sono stati cancellati correttamente.",
	15 => "Il tuo link è stato salvato correttamente.",
	16 => "Il link è stato cancellato correttamente.",
	17 => "Il tuo evento è stato salvato correttamente.",
	18 => "L'evento è stato cancellato correttamente.",
	19 => "Il tuo sondaggio è stato salvato correttamente.",
	20 => "La votazione è stata cancellata correttamente.",
	21 => "Il nuovo utente è stato salvato correttamente.",
	22 => "L'utente è stato cancellato correttamente",
	23 => "Errore durante il tentativo di aggiungere l'evento al tuo calendario. ID Evento mancante.",
	24 => "L'Evento è stato salvato correttamente  nel tuo calendario",
	25 => "Impossibile aprire il calendario personale, entra prima nel sito",
	26 => "L'Evento è stato rimosso correttamente dal tuo calendario personale",
	27 => "Il Messaggio è stato inviato correttamente.",
	28 => "Il plug-in è stato salvato correttamente",
	29 => "Spiacenti, il calendario personale non è abilitato su questo sito",
	30 => "Accesso negato",
	31 => "Spiacenti, non hai i permessi per accedere alla pagina amministrazione articoli.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
	32 => "Spiacenti, non hai i permessi per accedere alla pagina amministrazione argomenti.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
	33 => "Spiacenti, non hai i permessi per accedere alla pagina amminitrazione blocchi.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
	34 => "Spiacenti, non hai i permessi per accedere alla pagina amministrazione link.  Prego nota che tutti i tentativi di accesso non
 autorizzati vengono registrati.",
	35 => "Spiacenti, non hai i permessi per accedere alla pagina amministrazione eventi.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
	36 => "Spiacenti, non hai i permessi per accedere alla pagina amministrazione sondaggi.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
	37 => "Spiacenti, non hai i permessi per accedere alla pagina amministrazione utenti.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
	38 => "Spiacenti, non hai i permessi per accedere alla pagina amministrazione plugin.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
	39 => "Spiacenti, non hai i permessi per accedere alla pagina amministrazione mail.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
	40 => "Messaggio di Sistema",
    41 => "Spiacenti, non hai i permessi per accedere alla pagina sostituzione parole.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
    42 => "La tua parola è stata salvata correttamente.",
	43 => "La parola è stata cancellata correttamente.",
    44 => 'Il plug-in è stato installato correttamente!',
    45 => 'Il plug-in è stato cancellato correttamente.',
    46 => "Spiacenti, non hai i permessi per accedere all'utility database backup.  Prego nota che tutti i tentativi di accesso non autorizzati vengono registrati.",
    47 => "Questa funzionalità lavora solo sotto *nix.  Se Geeklog sta girando sotto un sistema operativo *nix la tua cache verrà regolarmente azzerata. Se sei su Windows, dovrai necessariamente cercare i files con nome adodb_*.php e rimuoverli manualmente.",
    48 => 'Grazie per la tua richiesta di registrazione a ' .
    $_CONF['site_name'] . '. Il nostro Team valuterà la tua richiesta. Se approvata ti verrà inviata via posta elettronica la password all\'indirizzo email da te specificato.',
    49 => "Il tuo gruppo è stato salvato correttamente.",
    50 => "Il gruppo è stato cancellato correttamente."
);

// for plugins.php

$LANG32 = array (
	1 => "L'Installazione dei plug-in potrebbe rovinare la tua installazione di Geeklog e presumibilmente anche il tuo sistema.  E' importante che tu installi solo i plugin scaricati da <a href=\"http://geeklog.sourceforge.net\" target=\"_blank\">Geeklog Homepage</a> in quanto questi plugin vengono regolarmente testati da noi su numerosi sistemi operativi.  E' altresì importante che tu capisca che il processo di installazione richiede alcune esecuzioni di comandi di sistema che potrebbero intaccare la sicurezza del sistema stesso (in particolare se utilizzi plugin di terze parti).  Preso per compreso l'avvertimento, noi non garantiamo il successo della installazione e non siamo responsabili di eventuali danni causati dall'installazione del plugin.  In poche parole, installa a tuo rischio!.  Per il modo, indirizzamento e come installare manualmente il plugin consulta gli how-to forniti con il pacchetto del plugin.",
	2 => "Note di Installazione Plug-in",
	3 => "Modulo Installazione Plug-in",
	4 => "Plug-in File",
	5 => "Lista Plug-in",
	6 => "Attenzione: Plug-in già installato!",
	7 => "Il plug-in che vuoi installare è gia installato nel sistema.  Cancella il plugin esistente prima di reinstallare la nuova versione",
	8 => "Controllo Compatibilità Plugin Fallita",
	9 => "Questo plug-in richiede una nuova versione di Geeklog. Puoi aggiornare la tua copia di <a href=http://www.geeklog.org>Geeklog</a> o prendere una nuova versione del plug-in.",
	10 => "<br><b>Al momento nessun plug-in risulta installato.</b><br><br>",
	11 => "Per modificare o cancellare un plug-in, clicca sul numero del plug-in's dalla lista sottostante. Per apprendere su come usare il plug-in, clicca sul nome del plug-in e sarai redirezionato direttamente al sito del plug-in. Per installare o aggiornare un plug-in clicca su nuovo-plug-in sopra.",
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
    24 => 'Azzera',
    25 => 'Cancella',
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
	editrootmsg => "Ricorda! Anche se sei un Utente Amministratore, non puoi modificare l'utente root senza prima essere entrato con l'account di root.  Puoi modificare tutti gli gli altri utenti ad eccezzione dell'utente root. Prego nota che tutti i tentativi di modificare illegalmente l'utente root vengono registrati.  Ritorna a <a href=\"{$_CONF["site_admin_url"]}/users.php\">Pagina Amministrazione Utenti</a>.",
	securitygroupsmsg => "Seleziona la casella per i gruppi nei quali vuoi inserire l'utente.",
	groupeditor => "Editor Gruppi",
	description => "Descrizione",
	name => "Nome",
 	rights => "Permessi",
	missingfields => "Campi Mancanti",
	missingfieldsmsg => "Devi fornire un nome e una descrizione per il gruppo",
	groupmanager => "Manager Gruppi",
	newgroupmsg => "Per modificare o cancellare un gruppo, selezionalo dalla lista sottostante. Per creare un nuovo gruppo clicca su <b>nuovo gruppo</b> sopra. Considera che il gruppo principale non può essere cancellato in quanto usato dal sistema.",
	groupname => "Nome Gruppo",
	coregroup => "Gruppo Principale",
	yes => "Si",
	no => "No",
	corerightsdescr => "Questo Gruppo di {$_CONF["site_name"]} è il gruppo principale.  Per definizione i permessi di questo gruppo non possono essere modificati.  Sotto c'è la lista in sola lettura dei permessi a cui questo gruppo ha accesso.",
	groupmsg => "Il modello di sicurezza per i Gruppi in questo sito è di tipo gerarchico.  Aggiungendo questo gruppo a uno qualsiasi dei gruppi elencati sotto fa sì che il gruppo prenda gli stessi permessi del gruppo superiore.  Dove possibile siete incoraggiati a usare i gruppi sottostanti per dare i permessi al gruppo.  Se avete necessità di dare dei permessi personalizzati al gruppo potete selezionare i permessi fra le varie funzioni del sito nella sezione chiamata 'Permessi'.  Per aggiungere questo gruppo a uno dei gruppi sottostanti seleziona la spunta nella caselle del gruppo(i) che desideri modificare.",
	coregroupmsg => "Questo gruppo è il gruppo principale di {$_CONF["site_name"]} .  Normalmente i gruppi che sono sottostanti a questo gruppo non posono essere modificati.  Sotto puoi trovare una lista in sola lettura dei gruppi associati a questo gruppo.",
	rightsdescr => "Alcuni permessi di accesso ai gruppi possono essere settati direttamente al gruppo o a un gruppo differente facente parte del gruppo.  Quelli che vedi sotto non selezionati sono i permessi che sono stati impostati a questo gruppo in quanto facente parte di altri gruppi e quindi ereditati.  I permessi selezionabili sono i permessi che posono essere dati direttamente a questo gruppo.",
	lock => "Bloccato",
	members => "Membro",
	anonymous => "Anonimo",
	permissions => "Permessi",
	permissionskey => "R = lettura, E = modifica, permesso di modifica implica permessi di lettura",
	edit => "Modifica",
	none => "Nessuno",
	accessdenied => "Accesso negato",
	storydenialmsg => "Non disponi dei permessi per visualizzare questa storia.  Questo perchè non sei un membro registrato di {$_CONF["site_name"]}.  Prego <a href=users.php?mode=new> diventa un membro</a> of {$_CONF["site_name"]} per avere pieno accesso al sito!",
	eventdenialmsg => "Non disponi dei permessi per visualizzare questo evento.  Questo perchè non sei un membro registrato di {$_CONF["site_name"]}.  Prego <a href=users.php?mode=new> diventa un membro</a> of {$_CONF["site_name"]} per avere pieno accesso al sito!",
	nogroupsforcoregroup => "Questo Gruppo non ha alcun collegamento con gli altri gruppi",
	grouphasnorights => "Questo Gruppo non ha accesso a nessuna funzione amministrativa del sito",
	newgroup => 'Nuovo Gruppo',
	adminhome => 'Home Amministratore',
	save => 'salva',
	cancel => 'cancella',
	delete => 'elimina',
	canteditroot => 'Hai provato a editare il Gruppo Root ma non fai parte del gruppo stesso e quindi la tua modifica non è consentita. Prego contatta l\'Amministratore se ritieni questo messaggio un errore'	
);

$LANG_DB_BACKUP = array(
    not_found => "Percorso non corretto o utility mysqldump non eseguibile.<br>Controlla il percorso <strong>\$_DB_mysqldump_path</strong> in config.php.<br>La variabile attualmente è definità come: <var>{$_DB_mysqldump_path}</var>",
    last_ten_backups => 'Ultimi 10 Back-ups',
    do_backup => 'Esegui il Backup',
    backup_successful => 'Il Back up è stato eseguito con successo.',
    no_backups => 'Nessun backups del sistema',
    db_explanation => 'Per creare un nuovo Backup del tuo sistema Geeklog, clicca sul bottone sottostante',
	zero_size => 'Backup Fallito: La dimensione del File era di 0 bytes',
    path_not_found => "{$_CONF['backup_path']} non esiste o non è una directory", 
    no_access => "ERRORE: La Directory {$_CONF['backup_path']} non è accessibile.",
    backup_file => 'Backup file', 
    size => 'Dim.',
    bytes => 'Bytes'
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
    10 => "ricerca avanzata"
);

$LANG_404 = array(
     1 => "Errore 404",
     2 => "Attenzione, Abbiamo cercato in tutto il sito ma la pagina http://{$HTTP_SERVER_VARS["HTTP_HOST"]}{$HTTP_SERVER_VARS["REQUEST_URI"]} non è stato trovata.",
     3 => "Siamo spiacenti, ma il file da te richiesto non esiste.  Prego controlla nella pagina principale o nella pagina di ricerca per vedere se puoi trovare quanto da te richiesto."  
);

$LANG_LOGIN = array (
    1 => 'Login richiesto',
    2 => 'Spiacenti, per accedere a questa area devi essere registrato come utente.',
    3 => 'Entra',
    4 => 'Nuovo Utente'
);

?>

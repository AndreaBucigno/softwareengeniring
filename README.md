# 🌐 Sistema di Gestione Web Dinamico - PCTO

Un sistema web completo per la gestione aziendale sviluppato durante il percorso PCTO presso Softwarengineering.

## 📋 Descrizione del Progetto

Il progetto consiste in un portale web dinamico che permette la gestione di utenti e servizi aziendali. Il sistema implementa un'architettura basata su template PHP riutilizzabili, garantendo scalabilità e facilità di manutenzione.

## 🚀 Funzionalità Principali

- **Sistema di Autenticazione Sicuro**
  - Login con validazione credenziali
  - Gestione sessioni PHP
  - Logout sicuro con distruzione sessione
  - Recupero password

- **Pannello Amministratore**
  - Creazione e gestione utenti
  - Controllo accessi basato su ruoli
  - Interface amministrativa dedicata

- **Dashboard Utente**
  - Area riservata per utenti registrati
  - Visualizzazione dati personalizzati
  - Tabelle dinamiche con DataTables

- **Pagina Corporate**
  - Presentazione servizi aziendali
  - Design responsive e moderno
  - Sezioni dedicate a ERP, Web Solutions, Consulenza IT

## 🏗️ Architettura e Tecnologie

### Frontend
- **HTML5** - Struttura semantica
- **CSS3** - Styling moderno con tema dark
- **Bootstrap 5** - Framework responsive
- **jQuery** - Interattività e manipolazione DOM
- **DataTables** - Tabelle interattive

### Backend
- **PHP** - Logica server-side
- **MySQL** - Database relazionale
- **Template System** - Architettura modulare personalizzata

### Sicurezza
- Controllo sessioni PHP
- Prepared statements per prevenire SQL injection
- Validazione input lato server
- Controllo accessi basato su ruoli

## 📁 Struttura del Progetto

```
/
├── assets/
│   ├── css/
│   │   └── styles.css          # Stili personalizzati
│   ├── js/
│   │   └── script.js           # JavaScript personalizzato
│   └── images/                 # Risorse grafiche
├── data/
│   └── utenti.json            # Dati utenti (demo)
├── inc/
│   └── template.inc.php       # Template base riutilizzabile
├── index.php                  # Homepage aziendale
├── login.php                  # Pagina di accesso
├── logout.php                 # Script logout
├── admin.php                  # Pannello amministratore
├── dashboard.php              # Dashboard utente
└── recupera-pass.php          # Recupero password
```

## 🔧 Installazione e Configurazione

### Prerequisiti
- Server web (Apache/Nginx)
- PHP 7.4+
- MySQL 5.7+

### Setup Database
1. Creare il database `progettopcto_bucignoconsalvi`
2. Creare la tabella `utenti` con la seguente struttura:
```sql
CREATE TABLE utenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) UNIQUE NOT NULL,
    Nome VARCHAR(255) NOT NULL,
    numero VARCHAR(20),
    azienda VARCHAR(255),
    ruolo ENUM('admin', 'utente') NOT NULL,
    data_registrazione DATE,
    attivo ENUM('true', 'false') DEFAULT 'true',
    password VARCHAR(255) NOT NULL
);
```

### Configurazione
1. Clonare il repository
2. Configurare i parametri di connessione database in `login.php` e `admin.php`
3. Assicurarsi che la cartella sia accessibile dal web server

## 👥 Credenziali di Test

### Amministratore
- **Email:** admin@softwarengineering.com
- **Password:** admin123

### Utente Standard
- **Email:** demo@demo.com
- **Password:** demo123

## 🎯 Caratteristiche Tecniche Innovative

### Sistema Template Personalizzato
Il progetto implementa un sistema template custom che utilizza:
- Placeholder dinamici (`{{title}}`, `{{body}}`)
- Sostituzione tramite `str_replace()` PHP
- Separazione completa tra struttura e contenuto
- Riutilizzabilità del codice al 100%

### Vantaggi dell'Architettura
- **Scalabilità:** Facile aggiunta di nuove pagine
- **Manutenibilità:** Modifiche globali centralizzate
- **Consistenza:** Design uniforme garantito
- **Prestazioni:** Codice ottimizzato e riutilizzabile

## 🔒 Sicurezza Implementata

- Controllo sessioni PHP robusto
- Validazione input lato server
- Prepared statements per query database
- Controllo accessi role-based
- Logout sicuro con pulizia sessione completa

## 📊 Database Schema

Il sistema utilizza una tabella principale `utenti` che gestisce:
- Autenticazione e autorizzazione
- Profili utente completi
- Stati di attivazione account
- Tracciamento ruoli (admin/utente)

## 🚧 Sviluppi Futuri

- [ ] Implementazione sistema di hash password avanzato
- [ ] Dashboard analytics per amministratori
- [ ] Sistema di notifiche in tempo reale

## 👨‍💻 Autore

Sviluppato durante il PCTO presso **Softwarengineering**  

## 📜 Licenza

Progetto educativo sviluppato per scopi didattici nell'ambito del percorso PCTO.

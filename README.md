# Parsifal Yoga Studio Management App

Applicativo web per la gestione dello Yoga Studio, sviluppato in PHP con database MySQL.

## Struttura del Progetto

- **`public/`**: Root pubblica del server web. Contiene `index.php` (router) e gli asset statici.
- **`src/`**: Codice sorgente dell'applicazione (Viste, Controller, Modelli).
- **`config/`**: File di configurazione (es. database).
- **`.github/workflows/`**: Configurazioni per il deploy automatico.

## Setup Locale

1. Clona il repository.
2. Configura un server web (Apache/Nginx) per puntare alla cartella `public/`.
3. Assicurati che `config/database.php` punti a un database MySQL valido.
   - Puoi modificare il file o settare le variabili d'ambiente `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`.

## Deployment

Il progetto utilizza GitHub Actions per il deploy automatico via FTP.

### Staging
- **Branch**: `staging` o `develop`
- **Host**: `staging.parsifalyogastudiovicenza.it`
- **Secrets GitHub richiesti** (Inserire in **Settings > Secrets and variables > Actions > Repository secrets**):
  - `FTP_SERVER_STAGING`
  - `FTP_USERNAME_STAGING`
  - `FTP_PASSWORD_STAGING`

### Produzione
- **Branch**: `main`
- **Host**: `parsifalyogastudiovicenza.it`
- **Secrets GitHub richiesti** (Inserire in **Settings > Secrets and variables > Actions > Repository secrets**):
  - `FTP_SERVER_PROD`
  - `FTP_USERNAME_PROD`
  - `FTP_PASSWORD_PROD`

## Configurazione Server

Assicurati che:
- La document root del dominio punti alla cartella `public` (se possibile) oppure che la struttura caricata via FTP sia compatibile con la configurazione del tuo hosting.
- Se l'hosting punta alla root di `yogastudio`, l'accesso sarà `dominio.it/public/`. Per puntare direttamente a `dominio.it`, configurarare il server web o spostare il contenuto di `public` nella root (sconsigliato per pulizia, meglio configurare la DocumentRoot).

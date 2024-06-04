# Pokemon Crocoite

Pokemon crocoite è un progetto del corso basi di dati

Tutti i dati necessari sono in /documentazione

# Come funziona

Il server di Pokemon Crocoite è un server sviluppata mediante il linguaggio di programmazione PHP(v >= 8.2) assieme al noto framework Laravel (v.11).

E' caldamente consigliato l'utilizzo di docker per l'avvio del server (in altri casi modificare opportunamente il file .env seguendo la documentazione ufficiale di Laravel 11).

L'applicazione avviata con docker tramite sail (o docker compose), consiste in un server laravel, con database mysql.

# Istruzioni di avvio (Docker)

## Preambolo

-   Installare Docker ([Sito ufficiale docker](https://www.docker.com/))

## Avvio tramite docker

-   Andare con la shell nella directory del progetto
-   Eseguire il comando `docker compose up -d` (-d per eseguirlo in background)
-   Ora bisogna eseguire comandi dall'interno del container del container
    -   Tramite GUI:
        -   Aprire l'app Docker
        -   Sezione Container
        -   Cliccare sul container in esecuzione
        -   Cliccare su `sail-8.3/app`
        -   Spostarsi nella sezione `Exec`
    -   Tramite CLI:
        -   Eseguire `docker ps`
        -   Cercare Il Container con la scritta `sail-8.3/app`
        -   Di fianco c'è un ID (es. 90c7342726f9)
        -   Eseguire il comando `docker exec -it {codice precedente} {comando da eseguire}`
        -   esempio: `docker exec -it 90c7342726f9 composer install`
-   Una volta che è possibile eseguire comandi nel container eseguire:
    -   `composer install`
    -   `npm install`
-   Ora eseguire `docker compose down`
-   `./vendor/bin/sail up -d`
-   `./vendor/bin/sail npm run dev`
-   ora in `localhost/` ci sarò il sito ed in `localhost:81` PHPMYADMIN per visualizzare il database

## Avvio tramite vscode task
Per avviare l'applicazione tramite vscode task bisogna eseguire i task nel seguente ordine
- Initialize (Va eseguito solo una volta, serve per installare le dipendenze all'interno del container)
- Run Server (Va eseguito dopo Initialize, viene in seguito esegui ogni volta che viene aperta la cartella tramite vscode)

# Database
## Mantenimento
Il database viene mantenuto tramite il sistema di migrazione di laravel, per ogni modifica al DB eseguire una migrazione su laravel
## Tabelle
E' molto importante eseguire le migrazioni nell'ordine prestabilito in modo da garantire una corretta creazione delle chiavi primarie.

L'ordine è il seguente:
- rarities
- pokemon
- types
- natures
- admins
- positions
- users
- genders
- states
- moves
- boxes
- can_learn_level
- effectivness
- pokemon_type
- zones
- can_be_found
- pokemon_encountereds
- mn_mts
- mn_mt_quantity
- story_tools
- story_tool_user
- battle_tools
- state_battle_tools
- gyms
- battle_tool_users
- npcs
- battle_tool_npcs
- can_learn_from
- exemplaries
- state_exemplaries
- exemplary_move
## Preambolo

-   Installare Docker ([Sito ufficiale docker](https://www.docker.com/))
-   fare una copia del file `.env.example` e rinominarlo in `.env`
-   Assicurarsi di avere le porte 80, 81 e 5173 libere (nel caso le porte 80 e 81 siano occupate sarà sufficiente modificare il file docker-compose.yml opportunamente, secondo il manuale di Docker)

## Avvio tramite docker

-   Andare con la shell nella directory del progetto
-   Eseguire il comando `docker compose up -d` (-d opzione consigliata per eseguire il container in background)
-   Ora bisogna eseguire comandi dall'interno del container
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
        -   Eseguire il comando `docker exec -it {ID container} {comando da eseguire}`
        -   esempio: `docker exec -it 90c7342726f9 composer install`
-   Una volta che è possibile eseguire comandi nel container eseguire:
    -   `composer install`
    -   `npm install`
-   Ora eseguire `docker compose down`
-   `./vendor/bin/sail up -d` (in windows il file si chiama sail.bat)
-   `./vendor/bin/sail npm run dev` (in windows il file si chiama sail.bat)
-   `./vendor/bin/sail artisan migrate` Per creare le tabelle nel Database
-   `./vendor/bin/sail artisan db:seed` Per popolare le tabelle nel Databases
-   ora in `localhost/` ci sarò il sito ed in `localhost:81` PHPMYADMIN per visualizzare il database

## Alternativa: Avvio tramite vscode task
Per avviare l'applicazione tramite vscode task bisogna eseguire i task nel seguente ordine
- Initialize (Va eseguito solo una volta, serve per installare le dipendenze all'interno del container)
- Run Server (Va eseguito dopo Initialize, viene in seguito esegui ogni volta che viene aperta la cartella tramite vscode)
-   `./vendor/bin/sail artisan migrate` Per creare le tabelle nel Database
-   `./vendor/bin/sail artisan db:seed` Per popolare le tabelle nel Databases

## Preambolo

-   Installare Docker ([Sito ufficiale docker](https://www.docker.com/))
-   Se si è su Windows, è necessaria una WSL. Il progetto deve trovarsi lì,
    e bisogna operare con la shell della stessa. Inoltre, Docker va impostato
    ad hoc secondo il manuale per interagire correttamente con la WSL.
-   Assicurarsi di avere le porte 80, 81, 3306 e 5173 libere 
    (nel caso le porte siano occupate sarà sufficiente modificare il 
    file `docker-compose.yml` opportunamente, secondo il manuale di Docker)
-   Assicurarsi di avere "node", "npm", "php" e "composer" installati sulla macchina/WSL
-   Assicurarsi che il file `php.ini` abbia attive le estensioni necessarie

## Avvio tramite Docker

-   Fare una copia del file `.env.example` e rinominarlo in `.env`
-   Assicurarsi che Docker sia aperto e in esecuzione (in Windows si deve tenere sulla macchina fisica,
    se è stato impostato correttamente dovrebbe funzionare)
-   Andare con la shell nella directory del progetto
-   Lanciare il comando `composer install` per costruire la cartella 'vendor'
-   Lanciare il comando `docker compose up -d` (-d opzione consigliata per eseguire il container in background)
-   Ora bisogna eseguire comandi dall'interno del container
    -   Tramite GUI di Docker:
        -   Visualizzare la sezione "Container"
        -   Espandere il container in esecuzione, se questo non è già espanso
        -   Se il container con l'immagine `sail-8.3/app` è in esecuzione, allora
	        è tutto a posto
    -   Tramite CLI:
        -   Eseguire `docker ps`
        -   Cercare Il Container con la scritta `sail-8.3/app`
        -   Di fianco c'è un ID (es. 90c7342726f9), copiarlo.
        -   Eseguire i prossimi comandi con
	        `docker exec -it {ID container} {comando da eseguire}`
	        esempio: `docker exec -it 90c7342726f9 composer install`
-   Eseguire su shell i comandi:
    -   `composer install`
    -   `npm install`
-   Ora lanciare i comandi
-   `docker compose down`
-   `./vendor/bin/sail up -d`
-   `./vendor/bin/sail npm run dev` **(Qui il terminale diventerà inutilizzabile, aprirne un altro)**
-   `./vendor/bin/sail artisan migrate` per creare le tabelle nel Database
-   `./vendor/bin/sail artisan db:seed` per popolare le tabelle nel Databases

ora in `localhost/` ci sarò il sito, in `localhost:81` PHPMYADMIN per visualizzare il database, e in `localhost/db` la visualizzazione grafica della struttura dello schema in laravel

Per accedere come utente: 
- Email: red@pokemon.com
- Password: password

Per accedere come admin: 
- Email: admin@pokemon.com
- Password: password

Per accedere a PHPMYADMIN:
- User: sail
- Password: password

## Alternativa: Avvio tramite vscode task
Per avviare l'applicazione tramite vscode task bisogna eseguire i task nel seguente ordine:
- Initialize (Va eseguito solo una volta, serve per installare le dipendenze all'interno del container)
- Run Server (Va eseguito dopo Initialize, viene in seguito esegui ogni volta che viene aperta la cartella tramite vscode)
-   `./vendor/bin/sail artisan migrate` Per creare le tabelle nel Database
-   `./vendor/bin/sail artisan db:seed` Per popolare le tabelle nel Databases
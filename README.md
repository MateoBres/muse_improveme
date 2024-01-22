<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# Corso Laravel 9.x

---

## Prerequisiti

Il corso Laravel 9.x si focalizza nell'apprendimento del corretto utilizzo del framework Laravel.

Poiché ciascuno studente deve poter essere libero di scegliere quale sistema operativo utilizzare per programmare, è buona norma avere un ambiente di sviluppo comune a tutti. In questo modo non sarà necessario occupare tempo prezioso per allineare o spiegare le varie differenze tra sistemi.

In particolar modo la configurazione di webservers quali ISS, Apache o NGINX che possono essere tranquillamente virtualizzati attraverso l'utilizzo dei containers.

Nel dettaglio parliamo di Docker che, fortunatamente, è nativamente supportato da laravel ed è possibile creare nuovi progetti pronti all'uso.

### IDE

Agli studenti non è imposta né la scelta di un sistema operativo né di un IDE e si consiglia agli studenti di trovare una propria configurazione ideale.

### Riferimenti

**Docker**

* Sito web ufficiale [Docker](https://www.docker.com/)
* Documentazione ufficiale [Docker](https://docs.docker.com)
* Come installare docker:
    * [Installazione mac](https://docs.docker.com/docker-for-windows/install/)
    * [Installazione windows](https://docs.docker.com/docker-for-mac/install/)
    * [Installazione linux](https://docs.docker.com/engine/install/)

**Laravel**
* Sito web ufficiale [Laravel](https://laravel.com/)
* Documentazione ufficiale [Laravel](https://laravel.com/docs)
* Laravel [Sail](https://laravel.com/docs/9.x/sail)

## Nuovo progetto laravel

Per prima cosa creeremo una installazione "fresh" di Laravel o, più semplicemente, un contenitore vuoto pronto a diventare una vera web application.

Per poter procedere con il prossimo punto bisogna verificare di aver Docker correttamente installato come dalle guide presenti nella sezione [Riferimenti](#riferimenti)

### Laravel Sail

Una volta installato Docker possiamo creare una serie di container dedicati al nostro progetto con delle configurazioni comuni a tutti e che ci permettono di essere sicuri di avere tutto il necessario installato.

Per fare ciò è necessario seguire quanto riportato nella documentazione ufficiale:

> [Your first laravel project](https://laravel.com/docs/9.x/installation#your-first-laravel-project)
>
> Laravel Sail is a light-weight command-line interface for interacting with Laravel's default Docker configuration. Sail provides a great starting point for building a Laravel application using PHP, MySQL, and Redis without requiring prior Docker experience.

Questo codice sorgente presenta già tutte le configurazioni necessarie per poter avviare il progetto. Di seguito, verranno semplicemente elencate le caratteristiche principali.

Per approfondimenti, si consiglia di far riferimento alla [documentazione ufficiale di Laravel Sail](https://laravel.com/docs/9.x/sail#introduction). Ma la cosa migliore rimane sempre una:

Entrate nella pagina del progetto [Github](https://github.com/laravel/sail) e studiate il codice sorgente del package.

### docker-compose.yml

L'architettura dei container alla base di questo progetto è formata da quattro container principali:

* Il container [Ubuntu server 20.04](https://hub.docker.com/_/ubuntu) fornito della versione 8.0 di PHP e qualsivoglia libreria utilizzata per far funzionare correttamente la web application Laravel, cioè il nostro progetto.
* Il container [MySQL](https://hub.docker.com/_/mysql) per il database principale della web application
* Il container [Redis](https://hub.docker.com/_/redis) che verrà utilizzato per gestione Cache, code e altri eventi asincroni
* Il container [MailHog](https://hub.docker.com/r/mailhog/mailhog) che verrà utilizzato per testare l'invio e la ricezione di mail provenienti dalla web application.

Dettaglio del file `docker-compose.yml`:

```YAML
# https://docs.docker.com/compose/
services:
    laravel.test:
      # Configurazione container
    mysql:
      # Configurazione container
    redis:
      # Configurazione container
    mailhog:
      # Configurazione container
networks:
  # Configurazione della rete dei container
  # Documentazione: https://docs.docker.com/network/
volumes:
  # Configurazione dei volumi
  # Documentazione: https://docs.docker.com/storage/volumes/
```

### Laravel sail cli

**Attenzione** Per gli esempi non è riportato il path base, ma ricordatevi di posizionarvi nella cartella root del progetto.

```shell
# Riferimento: https://laravel.com/docs/9.x/sail#starting-and-stopping-sail
$ ./vendor/bin/sail up -d   # Avvio dei container in modalità detached.
                            # L'applicazione a questo punto è raggiungibile aprendo il browser:
                            # http://localhost

$ ./vendor/bin/sail down    # Stop dei container.
```

**Attenzione** Non dovrebbe servire, ma se fosse necessario dover ricreare i container:

```shell
$ ./vendor/bin/sail build --no-cache
```

Una volta avviato il container è necessario installare tutte le librerie necessarie al funzionamento della web application:

```shell
# Riferimento: https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies

# Se non è presente né il file composer.lock né la cartella vendor:
$ composer install

# Se presenti:
$ ./vendor/bin/sail composer install
```

Ricordiamoci che le dipendenze di un progetto devono essere periodicamente aggiornate. A livello progettuale potrebbe addirittura essere stata decisa una politica precisa di aggiornamento, a seconda della versione del package ad esempio.

Nel nostro caso, dato che non possiamo prevedere con esattezza se e quando durante il corso sarà necessario aggiornare le dipendenze, potete agire secondo preferenza. Se necessario, dovrà essere lanciato il comando:

```shell
# Riferimento: https://getcomposer.org/doc/01-basic-usage.md#updating-dependencies-to-their-latest-versions

$ ./vendor/bin/sail composer update
```

## Filesystem

In questa sezione analizziamo la struttura di un progetto vuoto Laravel. Come abbiamo visto avviando il container, una pagina web viene già restituita. Il nostro progetto si compone di svariate parti che permettono di svolgere operazioni semplici come visualizzare una pagina web statica, ad altre più complesse come la gestione di più connessioni ad un database o l'invio di notifiche broadcast.

### Riferimenti:

* [PSR](https://www.php-fig.org/psr/) (PHP Standards Recommendations)
* Laravel project configuration:
    * [Documentazione](https://laravel.com/docs/9.x/configuration): Ambienti del progetto laravel e configurazione
    * [Documentazione](https://laravel.com/docs/9.x/structure): Struttura del filesystem

### Ambienti e variabili ambientali

```
{project}:
 |- ...
 |- .env                        # Le variabili ambientali vengono lette da questo file.
 |- .env.{nome_environment}     # Le variabili ambientali specifiche per un certo ambiente.
                                # Viene caricato solo se l'applicazione o un comando dell'applicazione contiene l'opzione `--env`
 |- .env.testing                # Le variabili ambientali per l'ambiente di test (opzionale).
```

### Dipendenze

```
{project}:
|- node_modules/                # Cartella delle librerie NPM
|- vendor/                      # Cartella delle librerie composer
|- ...
|- composer.json                # PHP dependency manager
|- composer.lock
|- pacakge.json                 # NPM dependency manager
```

### CLI

```
{project}:
|- vendor/
    |- bin/
        |- phpunit
        |- sail
|- artisan
```

### Configurazioni

```
{project}:
|- config/                      # Cartella dei file di configurazione
    |- app.php
    |- auth.php
    |- broadcasting.php
    |- ...
|- ...
|- phpunit.xml                  # configurazioni
|- webpack.mix.js
```

### Directory di sistema

**Attenzione**: Tutti dicono che queste cartelle non vanno toccate per nessun motivo. Io sono d'accordo?

... ASSOLUTAMENTE SI!!! NON TOCCATE QUA DENTRO!!!! MAI!!!

... Almeno che non sappiate cosa state facendo...

... Le possibilità che sappiate cosa state facendo e che questa operazione vi serva sul serio è inverosimile che si verifichi mai nella vostra vita.

```
{project}:
|- bootstrap/
    |- cache/                   # Cache delle configurazioni del progetto.
        |- packages.php         # In molti casi sono delle spine nel fianco
        |- services.php         # A causa della loro natura, se si usano più ambienti
                                # è bene tenere questa cartella pulita attraverso il comando
                                # `./vendor/bin/sail artisan config:clear
   |- app.php
|- public/
   |- .htaccess
   |- favicon.ico
   |- index.php                 # Da questo file inizia tutto.
   |- robots.txt
   |- storage/                  # Symlink opzionale, ma fortemente raccomandato
   |- web.config
|- storage/                     # Questa cartella è per buona parte sotto controllo del framework
   |- app/                      # Questa cartella è sotto il controllo dell'applicazione web.
   |- framework/                # Questa cartella è sotto il controllo del framework
   |- logs/                     # Questa anche... Entrambe vanno toccate se necessario per fare pulizia
```

Per creare un symlink allo storage lanciare il comando:
```
./vendor/bin/sail artisan storage:link
```

**Attenzione** Avere un symlink tra lo storage privato e quello pubblico è assolutamente necessario.

### Directory del progetto

```
{project}:
|- app/
    |- Console
    |- Exceptions
    |- HTTP
    |- Models
    |- Providers
|- database/
    |- factories/
    |- migrations/
    |- seeders/
|- resources/
    |- css
    |- js
    |- lang
    |- views
|- routes/
|- tests/
    |- Feature/
    |- Unit/
    |- CreatesApplications.php
    |- TestCase.php
```

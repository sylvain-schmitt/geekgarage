# GeekGarage

App destinée à la prise de rdv avec les centre de maintenance info Onlineformapro.

### Tech

GeekGarage utilise un certain nombre de composants open source pour fonctionner correctement

* Symfony PHP - Framework PHP
* Sass -  préprocesseur CSS
* Webpack - Compiler Javascript.

### Installation

GeekGarage requiert [composer](https://getcomposer.org/download/) et [npm](https://nodejs.org/en/download/) installer nodejs et vous aurez acces a la commande npm.
Vous pouvez également installé la cli [symfony](https://symfony.com/download).

Installez les dépendances  et démarrez le serveur:

```sh
 composer install
```

```sh
 npm install
 puis
 npm run build (ceci crée le dossier build avec le css et js compiler)
```
créer la base de donnée:
```sh
 php bin/console doctrine:database:create
 ou
 symfony console doctrine:database:create
```
créer les tables grace au migration:
```sh
 php bin/console doctrine:migrations:migrate
 ou
 symfony console doctrine:migrations:migrate
```
Enfin démarrer le serveur interne de symfony:

```sh
symfony server:start
ou
symfony serve
```

License
----

MIT

**AccessCodeSchool, Promo-47!**


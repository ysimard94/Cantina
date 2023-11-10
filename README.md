## Installation

Tout d'abord créer un .env avec le nom de la base de données pour la migration ainsi que l'url du serveur local.

Ensuite, insérez ces commandes dans le terminal à partir de la racine du projet :

`composer update`
`npm install`
`php artisan key:generate`
`php artisan jwt:secret`
`php artisan migrate:fresh`

## Exécuter

Pour pouvoir lancer le projet localement, vous devez tourner deux serveurs grâce à ces deux commandes :

`npm run dev`
`php artisan serve`

Vous devriez maintenant pouvoir accéder à l'application à partir de localhost:8000.

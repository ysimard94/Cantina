## Installation

Tout d'abord cloner le projet à la base du document racine de votre serveur apache ou nginx. 
Ensuite créer un .env avec le nom de la base de données pour la migration ainsi que modifier l'URL et le port vers la base de données MySQL si nécessaire.

Ensuite, insérez ces commandes dans le terminal à partir de la racine du projet :
```
composer update
npm install
php artisan key:generate
php artisan jwt:secret
```

Vérifier que le package php-mysql soit installé avant de migrer la base de données avec
```
php artisan migrate:fresh
```

Veuillez ensuite peupler la base de données avec
```
php artisan db:seed
```

## Exécuter

Pour pouvoir lancer le projet localement, vous devez tourner deux serveurs grâce à ces deux commandes :

```
npm run dev
php artisan serve
```

Vous devriez maintenant pouvoir accéder à l'application à partir de localhost:8000.

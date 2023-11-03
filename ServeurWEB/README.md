# Admin Starter

----------------------------------------------------------------------

Système conçu avec le framework Symfony3 afin de faciliter les taches récurrentes de gestion d'un backoffice

----------------------------------------------------------------------

## Prérequis technique et ressources utiles

* [Symfony Doc](http://symfony.com/doc/current/index.html)
* [Doctrine](http://docs.doctrine-project.org/en/latest/)
* [Twig](https://twig.sensiolabs.org/doc/2.x/)
* [Sonata Admin Bundle](http://symfony.com/doc/current/bundles/SonataAdminBundle/index.html)
* [AdminLTE](https://almsaeedstudio.com/themes/AdminLTE/index2.html)
* [ChartJS](http://www.chartjs.org/docs/)
* [Jquery](http://api.jquery.com/)
* [Jquery UI](http://jqueryui.com/)
* [Bootstrap](http://getbootstrap.com/)

----------------------------------------------------------------------

## Installation

* Créer un nouveau repository 
* Dans un invite de commande depuis le dossier cible 
* si le serveur a une limit de memoire (dans la plupart des cas), les commandes php doivent etre remplacées par `php -d memory_limit=2G`

```
#!sh
git init
git remote add origin git@adresse-nouveau-repo.git
git remote add starter git@bitbucket.org:c2i-outremer/tools-starter3.git
git pull starter master
composer install
mkdir -pv web/uploads/media
mkdir -pv web/uploads/xml
chmod -R 777 web/uploads/
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load 
php bin/console assets:install --symlink
```

  
* Afin de profiter de la gestion des médias, il est conseillé de créer un [virtualhost](http://doc.ubuntu-fr.org/tutoriel/virtualhosts_avec_apache2) pointant sur le dossier web du projet 

----------------------------------------------------------------------
 
## Après l'installation
 
* **Front-office** : http://mon-virtual-host.local/app_dev.php
* **Back-office** : http://mon-virtual-host.local/app_dev.php/admin/dashboard (login/pass : admin/admin => à changer en fin de développement)
* Changer le fuseau horaire par defaut dans app/appKernel.php

## Pour profiter de gulp 
```
#!sh
* Se rendre dans web/tools et editer le fichier gulpfile.js pour mettre le virtualhost
* Lancer la commande npm install (la première fois)
* Lancer la commande gulp
```

## drop base et fixture load
```
#!sh
php bin/console doctrine:schema:drop --force && php bin/console doctrine:schema:update --force && php bin/console doctrine:fixtures:load
```

## Création d'un CPT

@todo

##  Utilisation du système de Query

Créer un fichier dans le dossier query du theme courant, puis dans n'importe quel contenu
Le cacheTime est par défaut à 0 afin de garder les blocs completement dynamique dans une page cachée
```
{{ render_esi(controller('CmsBundle:Query:query', {
'cpt':'article', 
'template':'test',
'cache': true,
'cacheTime': 0,
'function': 'findMany'
'numbers':{'offset':0, 'limit':5}
})) }}```
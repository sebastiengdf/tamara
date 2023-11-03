#!/bin/sh
gksu -u root "chmod 777 -R var"
php bin/console cache:clear --env=prod
gksu -u root "chmod 777 -R var"
exit 0;

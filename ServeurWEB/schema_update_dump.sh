#!/bin/sh

php bin/console doctrine:schema:update --dump-sql

exit 0;


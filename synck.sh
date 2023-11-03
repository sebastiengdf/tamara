#!/bin/sh
sshpass -p "&L@foRç&974" rsync  -ave 'ssh -p 15749' admtotal@165.169.242.5:/var/www/html/invoice/total-tamara/sql /home/sebastien/SAVTAMARA/SQL
sshpass -p "&L@foRç&974" rsync  -ave 'ssh -p 15749' admtotal@165.169.242.5:/var/www/html/invoice/total-tamara/web/uploads/media /home/sebastien/SAVTAMARA/INVOICESPDF
exit 0;
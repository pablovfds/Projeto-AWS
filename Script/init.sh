#!/bin/bash
sudo apt-get update
sudo apt-get install -y git wget apache2 libapache2-mod-php5 php5-pgsql
sudo a2enmod php5
sudo service apache2 restart

# o diretorio html/ dentro de /var/www/ sera substituido pelo html/ do repositorio
sudo rm -r /var/www/*
sudo git clone https://github.com/pablovfds/projeto-aws.git

echo "<?php phpinfo(); ?>" > /var/www/html/phpinfo.php
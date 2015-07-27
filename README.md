Inicialização do projeto no GitHub

Comandos a serem utilizados pela maquina EC2

#!/bin/bash
sudo apt-get update
sudo apt-get install -y git wget apache2 libapache2-mod-php5
sudo a2enmod php5
sudo service apache2 restart
sudo apt-get install php50mysql
sudo apt-get install mysql-client

# o diretorio html/ dentro de /var/www/ sera substituido pelo html/ do repositorio
sudo rm -r /var/www/*
sudo git clone https://github.com/pablovfds/Projeto-AWS.git

echo "<?php phpinfo(); ?>" > /var/www/html/phpinfo.php

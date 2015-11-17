# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  config.vm.box = "scotch/box"
  config.vm.network "private_network", ip: "192.168.4.20"
  config.vm.hostname = "local.drupal8.itiden.se"

  config.vm.synced_folder ".", "/var/www"

  config.vm.provider "virtualbox" do |v|

    v.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    v.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
    v.memory = 1024
    v.cpus = 2
    v.customize ["setextradata", :id,   "VBoxInternal2/SharedFoldersEnableSymlinksCreate/v-root", "1"]

  end

  config.vm.provision "shell", privileged: false, inline: <<-SHELL

    sudo a2dissite scotchbox.local.conf
    sudo a2dissite 000-default.conf

    echo "Creating vhost config for local.drupal8.itiden.se..."
    sudo cp /etc/apache2/sites-available/scotchbox.local.conf /etc/apache2/sites-available/local.drupal8.itiden.se.conf
    echo "Updating vhost config for local.drupal8.itiden.se.conf..."
    sudo sed -i s,scotchbox.local,local.drupal8.itiden.se.conf,g /etc/apache2/sites-available/local.drupal8.itiden.se.conf
    sudo sed -i s,/var/www/public,/var/www/web,g /etc/apache2/sites-available/local.drupal8.itiden.se.conf
    echo "Enabling local.drupal8.itiden.se.conf."
    sudo a2ensite local.drupal8.itiden.se.conf

    sudo composer self-update

    cd ~
    # Install Drupal Console
    if [ ! -f "/usr/local/bin/drupal" ]; then
      curl -LSs http://drupalconsole.com/installer | php
      sudo mv console.phar /usr/local/bin/drupal
      drupal init
    fi

    # Install Drush
    if [ ! -f "/usr/local/bin/drush" ]; then
      wget https://github.com/drush-ops/drush/releases/download/8.0.0-rc4/drush.phar
      chmod +x drush.phar
      sudo mv drush.phar /usr/local/bin/drush
      drush init
    fi

    ## Set PHP memory limit to 1024M
    php_memory_limit=1024M
    php_post_max_size=2000M
    php_upload_max_filesize=2000M
    php_error_reporting=E_ALL
    php_display_errors=On
    php_display_startup_errors=On

    sudo sed -i 's/memory_limit = .*/memory_limit = '${php_memory_limit}'/' /etc/php5/apache2/php.ini
    sudo sed -i 's/post_max_size = .*/post_max_size = '${php_post_max_size}'/' /etc/php5/apache2/php.ini
    sudo sed -i 's/upload_max_filesize = .*/upload_max_filesize = '${php_upload_max_filesize}'/' /etc/php5/apache2/php.ini
    sudo sed -i 's/error_reporting = .*/error_reporting = '${php_error_reporting}'/' /etc/php5/apache2/php.ini
    sudo sed -i 's/display_errors = .*/display_errors = '${php_display_errors}'/' /etc/php5/apache2/php.ini
    sudo sed -i 's/display_startup_errors = .*/display_startup_errors = '${php_display_startup_errors}'/' /etc/php5/apache2/php.ini

    # create database if not exists
    mysql -uroot -proot -e 'create database if not exists drupal8'

    # add hosts
    if ! grep -q "teamspeak.com" /etc/hosts; then
      echo '127.0.0.1 local.drupal8.itiden.se' | sudo tee --append /etc/hosts > /dev/null
    fi

    echo "So let's restart apache..."
    sudo service apache2 restart

  SHELL

end
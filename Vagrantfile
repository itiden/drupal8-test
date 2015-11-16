# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  config.vm.box = "scotch/box"
  config.vm.network "private_network", ip: "192.168.4.20"
  config.vm.hostname = "drupal8.itiden.se"

  config.vm.synced_folder ".", "/var/www", type: "rsync",
    rsync__args: ["--verbose", "--archive", "-z", "--copy-links"],
    rsync__exclude: [
      ".git/", ".gitattributes", ".gitmodules", ".gitignore", ".DS_Store", "vendor", ".vagrant"
    ],
    rsync__auto: true

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
    if [ ! -f "~/.composer/vendor/drush" ]; then
      ## Install Drush
      composer global require drush/drush:dev-master
      echo 'export PATH=~/.composer/vendor/bin:$PATH' >> ~/.bashrc
      source ~/.bashrc
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

    echo "So let's restart apache..."
    sudo service apache2 restart

  SHELL

end
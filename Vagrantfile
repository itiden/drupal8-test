# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "rasmus/php7dev"
  config.vm.network "private_network", ip: "192.168.4.20"
  config.vm.hostname = "drupal8-composer"
  config.vm.synced_folder ".", "/var/www"
  
  config.vm.provider "virtualbox" do |v|

    v.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    v.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
    v.memory = 2048
    v.cpus = 2
    v.customize ["setextradata", :id,   "VBoxInternal2/SharedFoldersEnableSymlinksCreate/v-root", "1"]

  end

  config.vm.provision "shell", inline: <<-SHELL
    sudo apt-get update
    sudo apt-get upgrade

    cd ~

    if [ ! -f "/usr/local/bin/drush" ]; then
      ## Install Drush
      wget https://github.com/drush-ops/drush/releases/download/8.0.0-rc3/drush.phar
      chmod +x drush.phar
      sudo mv drush.phar /usr/local/bin/drush
      drush init
    fi

    # install composer
    curl -sS https://getcomposer.org/installer | php
    sudo composer self-update

    sudo sed 's/\/var\/www\/default/\/var\/www\/web/' /etc/nginx/conf.d/default.conf

  SHELL

end

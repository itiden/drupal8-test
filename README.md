# Drupal 8 test
- Clone the repository.
- Make a copy of `.env.example` and name it `.env` and add the correct data.
- Run `vagrant up`.
- Run `vagrant ssh` from a new window and `cd /var/www`
- Run `composer install` to install everything in the VM.
- Make sure `sites/default/files` is writable.

####If something seems broken
- Test running `drush cache-rebuild`(or `drush cr`) from the `/var/www/web` folder from within your virtual host.

####If you have access to the demo-server
- From `/var/www/web` run `drush sql-sync @demo @local` to get a local copy of the database. This command can be run whenever to sync the database with demo.
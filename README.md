# Drupal 8 test
- Clone the repository.
- Make a copy of `.env.example` and name it `.env` and add the correct data.
- Run `vagrant up`.
- Run `vagrant rsync-auto` to auto sync files as they get saved. This terminal window needs to be up.
- Run `vagrant ssh` from a new window and `cd /var/www/baxter`
- Run `composer install` to install everything in the VM.
- From `/var/www/web` run `drush sql-sync @demo @local` to get a local copy of the database. This command can be run whenever to sync the database with demo.
ECP Shows
=========

The app is running on http://ecpshows.herokuapp.com/ .

To set up a dev environment :

Install [Vagrant](https://www.vagrantup.com/downloads.html), [Virtualbox](https://www.virtualbox.org/wiki/Downloads) and, if you are not on Windows, [Ansible](http://docs.ansible.com/ansible/intro_installation.html).

In the app folder:

`cd vagrant && vagrant up`

You may have to run vagrant up multiple times, if it detected missing plugins and installed them. If you had an error with the installation of plugins, try using `vagrant plugin install vagrant-bindfs --plugin-version '0.4.11'`, then run `vagrant up` again.

`vagrant ssh`

`cd /var/www && php composer.phar install`

If /var/www appears to not exist, exit the ssh prompt with `exit` and run `vagrant reload` then `vagrant ssh` again.

Leave the default parameters for the parameters.yml, except for captcha_id and captcha_secret, which you should get from http://google.com/recaptcha if you want to be able to register.

`php bin/console doctrine:schema:update --force` to create the database

`php bin/console hautelook:fixtures:load -n` to add some users

Now you can go to http://myshows.local and login using `user_1` and `password` or `god` and `password`.

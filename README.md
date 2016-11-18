ECP Shows
=========


Install Vagrant, Ansible, Virtualbox.

`cd vagrant && vagrant up` 

`vagrant ssh`

`cd /var/www && php composer.phar install`

Leave the default parameters for the parameters.yml, except for captcha_id and captcha_secret, which you should get from http://google.com/recaptcha.

`php bin/console doctrine:schema:update --force` to create the database

`php bin/console hautelook:fixtures:load -n` to add some users

Now you can go to http://localhost:8090 and login using `user_1` and `password` or `god` and `password`.
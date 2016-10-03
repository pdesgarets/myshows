MyShows
=======

To dev, you'll need vagrant, then :
- `git clone git@gitlab.centralesupelec.fr:2013garnierp/myshows.git && cd $_`
- `cd vagrant && vagrant up`
- `vagrant ssh`
- `cd /var/www && php composer.phar install`

Be careful to have in app/config a file `parameters.yml` with the correct settings (the ones by default should work oob).

I setup a vagrant machine where to run this project. To build the Vagrant machine, you should install:
	- latest Virtual box:  https://www.virtualbox.org/wiki/Downloads
	- latest Vagrant: https://www.vagrantup.com/downloads.html	 

1. Open command prompt in the project root directory and run:
	> Vagrant plugin install vagrant-hostmanager
	> Vagrant up
	
	to setup a vagrant machine where you can run the project
	You have the php info at url 'http://iatanasov.icover/info.php'
	You have the phpMyAdmin at url 'http://iatanasov.icover/phpmyadmin'
	MySql user: root
	MySql pass: vagrant
	
	Vagrant machine tested on Windows 10 host only.

2. Run:
	> Vagrant ssh
	> cd /vagrant
	
	to open a ssh session to the vagrant machine
	
3. Run: 
	> composer install
	
	to install the all of vendor dependencies.
	
4. Open 'http://iatanasov.icover' in your browser.
	Username:	nikola@abv.bg
	Password:	123456
	
Thats All.

I have provided a preprocessed asset's build into public/assets directory
If you want to rebuild the assets, you should apply the next steps:
1. Run 'bower' from the 'resources/themes/NiceAdmin/' directory:
	> cd /vagrant/resources/themes/NiceAdmin
	> bower install 
2. Install Laravel mix and its dependencies from the project root directory '/vagrant':
	> cd /vagrant
	> /vagrant/Vagrant/provision/install_webpack.sh
3. Run laravel-mix with:
	> npm run dev -- --env.theme=app
	
The project mysql dump is into the PROJECT_ROOT . '/resources/sql/dump.sql' , but if you use the provided vagrant machine 
you not needed to import the dump manualy. It is automaticaly imported from the vagrant provisioner

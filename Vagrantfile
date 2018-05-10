# -*- mode: ruby -*-
# vi: set ft=ruby :

###########################################################
# Plugins:
# vagrant plugin install vagrant-hostmanager
###########################################################

# Config Variables
##################################################################################################

VAGRANTFILE_API_VERSION	= '2' 
VAGRANT_BOX       		= "ubuntu/artful64"

MASHINE_NAME			= "iCover_IAtanasov"
HOSTNAME				= "iatanasov.icover"
PUBLIC_IP				= '10.3.3.2'
VBOX_MACHINE_MEMORY		= '1024'			# In Kbytes

##################################################################################################

def fail_with_message(msg)
  fail Vagrant::Errors::VagrantError.new, msg
end

# Run Config
Vagrant.configure( VAGRANTFILE_API_VERSION ) do |vagrant_config|
	
	if ! Vagrant.has_plugin? 'vagrant-hostmanager'
	  fail_with_message "vagrant-hostmanager missing, please install the plugin with this command:\nvagrant plugin install vagrant-hostmanager"
	end
	
	vagrant_config.hostmanager.enabled           	= true
    vagrant_config.hostmanager.manage_host       	= true
	vagrant_config.hostmanager.manage_guest 		= false
    vagrant_config.hostmanager.ignore_private_ip 	= false
    vagrant_config.hostmanager.include_offline   	= true
	vagrant_config.hostmanager.aliases				= ["www.#{HOSTNAME}"]
	
	# Config vagrant machine
	vagrant_config.vm.define MASHINE_NAME do |config|
	  
		config.vm.box				= VAGRANT_BOX
		config.vm.box_check_update	= true
		
		config.vm.hostname 			= HOSTNAME
		config.vm.network :private_network, ip: PUBLIC_IP
    	
		# Virtual Box Configuration
		config.vm.provider :virtualbox do |vb, override|
			vb.gui		= true
			vb.name		= MASHINE_NAME
			vb.memory	= VBOX_MACHINE_MEMORY
			vb.cpus		= 1
		end
	  	
		# Run provision bash scripts to setup puppet environement
		config.vm.provision "shell", path: "Vagrant/provision/init.sh"
		config.vm.provision "shell", path: "Vagrant/provision/make_swap.sh"
		config.vm.provision "shell", path: "Vagrant/provision/install_puppet.sh"
		config.vm.provision "shell", path: "Vagrant/provision/install_puppet_modules.sh"
    
	    # Run puppet provisioner
	    config.vm.provision :puppet do |puppet|
			puppet.manifests_path = 'Vagrant/puppet/manifests'
			puppet.module_path    = 'Vagrant/puppet/modules'
			puppet.options        = ['--verbose', '--debug']
			
			puppet.manifest_file  = "default.pp"
			puppet.facter			= {
				'hostname'		=> HOSTNAME,
				'documentroot'	=> '/vagrant/public',
				'mysqlhost'		=> PUBLIC_IP,
				'mysqldump'		=> '/vagrant/resources/sql/dump.sql'
			}
	    end
		
		#################################################################
		# Workaround for a fucking bug: 
		# Created from puppet virtual host has "AllowOverride None"
		# and Laravel rewrite rules not working
		# The next is a hard fix for this.
		$workaround = <<-SCRIPT
sed "$(grep -n -m1 "AllowOverride None" /etc/apache2/sites-available/25-iatanasov.icover.conf |cut -f1 -d:)s/.*/AllowOverride All/" /etc/apache2/sites-available/25-iatanasov.icover.conf > /etc/apache2/sites-available/25-iatanasov.icover.conf.FIXED
cp -f /etc/apache2/sites-available/25-iatanasov.icover.conf.FIXED /etc/apache2/sites-available/25-iatanasov.icover.conf
rm /etc/apache2/sites-available/25-iatanasov.icover.conf.FIXED
service apache2 restart 
echo "####################################################################"
echo "# DONE!!!"
echo "# Now you can open 'http://iatanasov.icover' in your browser"
echo "# user: nikola@abv.bg"
echo "# pass: 123456"
echo "####################################################################"
SCRIPT

		config.vm.provision "shell", inline: $workaround
	end
end

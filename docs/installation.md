Installation of Augus

Installation

https://www.laravel.com/docs/5.3/installation
You need VirtualBox. Use an older version if you are on windows.

You need homestead
https://www.laravel.com/docs/5.3/homestead
You need vagrant
https://www.vagrantup.com/downloads.html


Get the Homestead Vagrant box: In a terminal (git bash recommended if you are on windows)
vagrant box add laravel/homestead
Then choose 2) virtualbox when asked to choose a provider.

Get Homestead: Clone Homestead
git clone https://github.com/laravel/homestead.git Homestead

Configure Homestead: inside the newly created folder homestead, run
bash init.sh
This creates a hidden directory ~/.homestead Go there and edit the Homestead.yaml file.
provider: virtualbox
folders:
    - map: D:\programming\homestead-code
      to: /home/vagrant/Code

Add this to your computers host file. Run notepad as administrator, and edit the host file at c:/windows/system32/drivers/etc
192.168.10.10  homestead.app

#!/bin/bash 
function toogle_checklock
{
  for file in $(find ./apps/frontend/config/* -type f -name 'settings.yml')
  do
    if [ $1 = "on" ]; then
      sudo sed -e 's|#check_lock|check_lock|g' $file > tempfile
    else
      sudo sed -e 's|check_lock|#check_lock|g' $file > tempfile
    fi
    sudo mv tempfile $file
    echo "*********** Modified: " $file " **************"
    if [ $1 != "on" ]; then
      sudo git checkout ./apps/frontend/config/settings.yml
    fi
  done
}

cd /var/www/dev

sudo git stash

toogle_checklock on
sudo php symfony cc

sudo git checkout master
sudo git pull origin master
sudo php symfony propel:migrate
sudo php symfony propel:build --all-classes

sudo php symfony log:rotate frontend prod --period=7 --history=10
#sudo php symfony log:rotate backend prod --period=7 --history=10
sudo php symfony cc

toogle_checklock off

sudo git stash apply
sudo chown www-data:www-data -R ./*
sudo chmod 777 log

echo "*********** Fuck Yea! All Done! **************"


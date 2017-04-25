#!/bin/bash

set -o errexit # Exit on error

# DEVMACHINE = "$(docker-machine ls -q | grep '^dev-machine$')";
# echo ${DEVMACHINE};

MACHINE="$(docker-machine ls -q | grep '^dev-machine$')"
if [ -z "$MACHINE" ]
then
	echo 'Dev-Machine does not exist: Creating Dev-Machine...';
    docker-machine create --driver virtualbox dev-machine 
fi


echo "Setting dev-machine in docker env";
eval "$(docker-machine env dev-machine)"

echo 'Installing docker-osx-dev...'
docker-osx-dev install

echo 'Installing angular CLI';
npm install -g @angular/cli

echo 'Running portainer...';
docker run --name portainer -d -p 9000:9000 -v /var/run/docker.sock:/var/run/

echo 'Compiling SASS...';
npm run sass:compile

echo 'Running containers';
npm run start

echo 'Fixing Permissions...';
npm run fix-permissions:wordpress

echo 'Syncing Files';
npm run sync

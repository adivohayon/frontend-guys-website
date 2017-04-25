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

echo 'Installing docker-osx-dev...';
curl -o /usr/local/bin/docker-osx-dev https://raw.githubusercontent.com/brikis98/docker-osx-dev/master/src/docker-osx-dev
chmod +x /usr/local/bin/docker-osx-dev
docker-osx-dev install
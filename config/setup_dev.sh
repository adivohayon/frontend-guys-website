#!/bin/bash

set -o errexit # Exit on error

eval "$(docker-machine env dev-machine)"

echo 'Installing angular CLI';
npm install -g @angular/cli

echo 'Running portainer...';
docker run --name portainer -d -p 9000:9000 -v /var/run/docker.sock:/var/run/ portainer/portainer --no-auth

echo 'Compiling SASS...';
npm run sass:compile

echo 'Running containers';
npm run start

echo 'Fixing Permissions...';
npm run fix-permissions:wordpress

echo 'Syncing Files';
npm run sync

operation=$1;

echo $operation;
if [ $operation = "backup" ]; then
	echo "Backing up wordpress database...";
	docker exec fe_guys_server /bin/bash -c "sudo -u www-data wp db export /data/db.sql --allow-root "
	docker cp fe_guys_server:/data/ .
	echo 'Copying Uploads Folder'
	docker cp fe_guys_server:/app/wp-content/uploads/ ./wordpress/wp-content
fi

if [ $operation = "fix-permissions" ]; then
	docker exec fe_guys_server /bin/sh -c "sh /scripts/fix-permissions.sh"
fi

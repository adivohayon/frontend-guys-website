operation=$1;

echo $operation;

docker-machine env dev-machine
eval $(docker-machine env dev-machine)

if [ $operation = "down" ]; then
	docker-compose down
fi

if [ $operation = "up" ]; then
	docker-compose up -d
fi
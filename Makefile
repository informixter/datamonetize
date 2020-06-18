API_CONTAINER_NAME=api-image

build_api:
	cd api && docker build -t $(API_CONTAINER_NAME) -f ./Dockerfile .

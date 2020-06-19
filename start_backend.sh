#!/bin/sh
echo "Starting BackEnd..."
docker-compose up -d nginx postgres api
docker-compose exec api bash

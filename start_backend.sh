#!/bin/sh
echo "Starting BackEnd..."
docker-compose up -d nginx postgres api transcript
docker-compose exec api bash

# Stripe payment system

## Requirements
 - docker
 - docker-compose
 - npm

## Installation

Copy env
```
cp .env.example .env
```

Setup Stripe api keys
``` 
STRIPE_PUBLISHABLE_KEY=
STRIPE_API_KEY=
STRIPE_WEBHOOK_SECRET=
STRIPE_CONNECT_WEBHOOK_SECRET=
```
Run containers
``` 
docker-compose up -d 
```
You need to wait some time to containers startup 

Then you need to build frontend assets with:
```
npm run build
```

Products page
```
http://localhost/products
```

## Setup XDebug For PHPSTORM

Go to Settings -> PHP -> Servers  
Create server for XDebug and remember to set path mappings
on the remote server to /var/www to instruct debug server
that your project files inside docker container are in this 
directory


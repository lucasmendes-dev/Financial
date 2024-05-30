
# Financial

This personal finance project is designed to monitor assets (stocks and REITs) and personal accounts. The goal is to provide an overview of your asset portfolio in one place.

- An API (https://brapi.dev) is used to fetch current asset values, allowing you to check the profitability of each asset based on their average price. Additionally, you can track the total value variation of your portfolio based on the performance of each asset.

![index_financial](https://github.com/lucasmendes-dev/Financial/assets/106750716/3b3331bd-8310-4c8b-9a42-187070f3d785)

- You can also add your personal accounts to monitor balances and gain a comprehensive view of your financial distribution.

![contas_financial](https://github.com/lucasmendes-dev/Financial/assets/106750716/07999b83-911c-4816-bce2-d0dd11b20e6f)

Below is a step-by-step guide to run the project on your machine (Docker required).

### Step by Step
Clone Repository
```sh
git clone https://github.com/lucasmendes-dev/Financial.git
```

```sh
cd Financial/
```

Create the .env File
```sh
cp .env.example .env
```


Update the environment variables in the .env file
```dosini
APP_NAME="Financial"
APP_DEBUG=true
APP_PORT=8989
APP_URL=http://localhost:"${APP_PORT}"

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

#Also, add these API links (acces https://brapi.dev/dashboard , create an account and generate your token, then put you token on BRAPI_TOKEN below)

BRAPI_LINK=https://brapi.dev/api/quote/
BRAPI_TOKEN=yourTokenHere

```

Start the project containers
```sh
docker compose up -d 
```

Access the container app
```sh
docker compose exec app bash
```

Inside the container, install the dependencies
```sh
composer install
```

Generate the Laravel project key
```sh
php artisan key:generate
```

Run migrations
```sh
php artisan migrate
```

Then OUTSIDE the container run NPM
```sh
npm install
```

```sh
npm run dev
```


Access the project at:
[http://localhost:8989](http://localhost:8989)

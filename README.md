
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
APP_PORT=8000
APP_URL=http://localhost:"${APP_PORT}"

FORWARD_DB_PORT=3308
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=my_project
DB_USERNAME=sail
DB_PASSWORD=password

#Also, add these API links (acces https://brapi.dev/dashboard , create an account and generate your token, then put you token on BRAPI_TOKEN below)

BRAPI_LINK=https://brapi.dev/api/quote/
BRAPI_TOKEN=yourTokenHere

```

Installing Composer Dependencies with 'Sail'
```sh
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

Start the project containers
```sh
vendor/bin/sail up -d
```

Install NPM dependencies
```sh
vendor/bin/sail npm install
```

Run migrations
```sh
vendor/bin/sail php artisan migrate
```


Generate the Laravel project key
```sh
vendor/bin/sail php artisan key:generate
```

Run NPM
```sh
npm run dev
```


Access the project at:
[http://localhost:8000](http://localhost:8000)

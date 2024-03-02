
# Financial

Personal project aimed at monitoring assets (stocks & reits) developed in Laravel with Blade Templates. The goal is to have an overview of your asset portfolio in one place, with total balances per category, variations, etc. Only the code, quantity, and average price of each asset need to be registered to view the tables and values.

![Financial_print](https://github.com/lucasmendes-dev/Financial/assets/106750716/cb0dd165-7689-4e21-9af5-5bdeaeeb30cf)

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

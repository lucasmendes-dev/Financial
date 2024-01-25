
# Financial

### Passo a passo
Clone Repositório
```sh
git clone https://github.com/lucasmendes-dev/Financial.git
```

Crie o Arquivo .env
```sh
cp .env.example .env
```


Atualize as variáveis de ambiente do arquivo .env
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
```

Suba os containers do projeto
```sh
vendor/bin/sail up -d
```

Instalar as dependências do projeto
```sh
vendor/bin/sail composer install
```

Instalar as dependências NPM
```sh
vendor/bin/sail npm install
```

Rodar as migrations
```sh
vendor/bin/sail php artisan migrate
```


Gerar a key do projeto Laravel
```sh
vendor/bin/sail php artisan key:generate
```

Rodar o NPM
```sh
vendor/bin/sail npm run dev
```


Acessar o projeto
[http://localhost:8000](http://localhost:8000)

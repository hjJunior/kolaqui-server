
## Dependências do projeto

- [Redis](https://redis.io/download): `>= 5.0.8`
- [ElasticSearch](https://www.elastic.co/downloads/elasticsearch): `>=7.9.1`
- [Postgres](https://www.postgresql.org/download/): `12.4`
- PHP: `^7.2.5`
- Composer

## Setup do projeto
### Configurar variaveis de ambiente

Rode no root do seu projeto:

```
cp .env.example .env
```

E configure as seguintes variaveis de acordo com o seu ambiente (caso necessario)

- DB
- ELASTICSEARCH
- REDIS

### Instalar dependencias

```
composer install
npm install
```

### Configurar banco de dados

```
php artisan migrate
```

### Iniciando o projeto

1. Iniciar servidor

```
php artisan serve
```

2. Iniciar redis

```
redis-server
``` 

3. Iniciar ElasticSearch

```
sudo -i service elasticsearch start
```

4. Iniciar listen de jobs

```
php artisan queue:listen
```

5. Iniciar mix watch

```
npm run watch
```

## Debugging

Para debbugar acesse o `/telescope`

## Rodar testes

Antes de rodar os testes certifique-se de configurar o `.env.testing`
Feito isso, você deverá fazer a migração do banco de dados

```
php aritsan migrate --env=testing
``` 

E então uma vez feito isso, para rodar execute:

```
vendor/bin/phpunit
```

## Bugs & Issues

Criar issue no githug detalhando os passos a passos de como executar.

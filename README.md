#### API Teste Fabrica Info - Admnistrador de Tarefas

##### Sobre tecnologias utilizadas nesse projeto:
- Laravel 10
- Docker 3.7
- Postgre

## Instalação

##### Requisito obrigátorios
Antes de tudo você precisa ter o docker e o docker-compose e também o git.
Caso não tenha instalado, aqui alguns links de referência:
- Aqui encontrar os passos para instalação do Docker => https://docs.docker.com/get-docker/ 
- Aqui encontrar os passos para instalação do Docker Compose => https://docs.docker.com/compose/ 
- Aqui encontrar os passos para instalação do git => https://git-scm.com/book/en/v2/Getting-Started-Installing-Git

##### Clone o projeto
Com o git instalado e em um diretório da sua escolha, baixe o projeto:

```sh
git clone https://github.com/joaovitornunes09/teste-fbinfo-back.git
```

##### Configuração de Arquivos:

1. Copiar o arquivo *.env.example* e colar com nome de *.env*

##### Suba o serviço
Com o Docker-compose instalado, execute esse comando na raiz do projeto:


```sh
docker-compose up -d --build
```
#### Comando dentro do container teste-fb

1. Execute a seguinte linha de comando no terminal:
```
composer install
```

2. Em sequência execute:
```
php artisan key:generate
```

3. Gerar chave JWT referente a Autenticação:
```
php artisan jwt:secret
```

4. Rodar as migrations do projeto:
```
php artisan migrate
```

5. Rodar as seeds do projeto:
```
php artisan db:seed
```
#### Credenciais do banco

1. Host: 
```
localhost
```
2. Database: 
```
teste-fb
```
3. Username:
```
laravel
```
4. Password:
```
112233
```
5. Port:
```
2002
```



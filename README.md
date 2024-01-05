#### API - Admnistrador de Tarefas

##### Sobre tecnologias utilizadas nesse projeto:
- Laravel 10
- Docker 3.7
- Postgres

## Informações

#### Funcionalidade
Este backend foi moldado para um sistema de admnistração de tarefas onde essas tarefas poderiam ser listadas, criadas, atualizadas e deletas.
O sistema consiste em um modelo onde haverá dois tipos de usuários:

###### Administrador: 
Esse usuário será criado assim que você rodar as seeds do projeto nos passos de instalação, ele será capaz de realizar todas as operações dentro do sistema que conta com todo o tipo de manipulação referente as tarefas.

- login: admin
- senha: admin

###### Comum: 
O usuário comum, é aquele que poderá ser criado pelo proprio sistema de cadastro da aplicação, será aquele que só tera disponivel as ações de listagem de tarefas que foram atribuidas a ele ou que foram disponibilizadas para visualização para todos os usuários do sistema pelo administrador, além disso ele poderá Finalizar as tarefas que lhe foram atribuidas.

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
git clone https://github.com/joaovitornunes09/taskriser-back.git
```

##### Configuração de Arquivos:

1. Copiar o arquivo *.env.example* e colar com nome de *.env*

##### Suba o serviço
Com o Docker-compose instalado, execute esse comando na raiz do projeto:


```sh
docker-compose up -d --build
```

#### Comandos dentro do container taskrise

1.Entre no container
```
sudo docker exec -it taskrise bash 
```

2. Execute a seguinte linha de comando no terminal:
```
composer install
```

3. Em sequência execute:
```
php artisan key:generate
```

4. Gerar chave JWT referente a Autenticação:
```
php artisan jwt:secret
```

5. Rodar as migrations do projeto:
```
php artisan migrate
```

6. Rodar as seeds do projeto:
```
php artisan db:seed
```

Pronto agora a api está instalada.

Url: http://localhost:8989/api

#### Credenciais do banco

1. Host: 
```
localhost
```
2. Database: 
```
taskrise
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



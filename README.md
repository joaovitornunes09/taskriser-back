#### API Teste Fabrica Info - Admnistrador de Tarefas -------> João Vitor Raulino Nunes

##### Sobre tecnologias utilizadas nesse projeto:
- Laravel 10
- Docker 3.7
- Postgre

##### Configuração de Arquivos:

1. Copiar o arquivo *.env.example* e colar com nome de *.env*

##### Instalação de pacotes e Docker:

1.Agora vamos iniciar instalação do Docker:
```
sudo docker-compose up -d
sudo docker exec -it teste-fb bash
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



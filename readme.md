
## Import CSV Em Laravel.

Requisitos
--
* php > 7.0
* Beanstalkd
* Mysql server
* Docker (se desejar utilizar filas com Redis)


Tecnologias adotadas
--
* Vue.js
* Laravel 5.6
* Laravel Mix
* Migrations
* Filas com Beanstalkd ou Redis
* Broadcasting + Laravel Echo (com Pusher)

Como Executar a aplicação

---
* Efetue checktout do branch `master`

* Configure a conexão com o banco de dados no arquivo `.env` na raiz do projeto.

* Execute `composer install` para instalar os pacotes do php utilizados no projeto.

* Execute os migrations `php artisan migrate`

* Execute `php artisan queue:work` para as filas do laravel

* Execute o serviço Beanstalkd `~#beanstalkd`

* Execute `php artisan serve` para funcionar o servidor de desenvolviemnto

* Execute `docker-compose up` para rodar uma imagem do Redis (altere a variável `BROADCAST_DRIVER` no `.env` para `redis`

* Será necesssário efetuar o cadastro na aplicação

Simule um acesso real
--
Baixe a velocidade de conexão do navegador para `fast 3g`


Dificuldade Encontrada
--
Pusher, dificuldade em ouvir o pusher após o gatilho do evento disparado. o que não está ocorrendo atualmente



Todo
---
Validação de mapeamento, evitar que ocorra seleção de mais de um campo por coluna.
Fazer o vuejs ouvir o pusher corretamente.
Implementar um Roolback em caso de importação errada








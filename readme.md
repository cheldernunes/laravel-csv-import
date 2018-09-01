
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
Baixe a velocidade de conexão do navegador para `fast 3g` para ter a experiêcia mais próxima do usuário.

1. Selecione o arquivo CSV para importar
![image](https://user-images.githubusercontent.com/1264455/44950672-864c4080-ae24-11e8-8e49-662138961e93.png)


2. Mapeie os campos, enquanto o upload está ocorrendo. 
![image](https://user-images.githubusercontent.com/1264455/44950651-e7274900-ae23-11e8-9153-5b90a5f2cfc9.png)
Após finalizar o upload o botão de import será ativado, permitindo finalizar o processo.


3. Sucesso do upload.
![image](https://user-images.githubusercontent.com/1264455/44950664-46855900-ae24-11e8-82fe-b0dfaddb3544.png)


Dificuldade Encontrada
--
Pusher, dificuldade em ouvir o pusher após o gatilho do evento disparado. o que não está ocorrendo atualmente



Todo
---
* Validação de mapeamento, evitar que ocorra seleção de mais de um campo por coluna.
* Fazer o vuejs ouvir o pusher corretamente.
* Implementar um Roolback em caso de importação errada








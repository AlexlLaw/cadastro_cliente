Uma simples API com apenas uma entidade que ao cadastrar um cliente ele gera um protocolo com 3 letras e 4 numeros.

Api feita em Symfony 4

O que foi Feito
1. CRUD para as Clientes

back-end feito em Symfony 4
Depois que você clonar o codigo do gitHUB

1-Abra o git bash dentro da pasta "vox" e utilize "composer install" -> para instalar todas as dependencias.

Abra o aquiro .env e coloque as configurações do seu banco.

2.1. Exemplo:

DATABASE_NAME=vox

DATABASE_HOST=localhost

DATABASE_PORT=5432

DATABASE_USER=postgres

DATABASE_PASSWORD=123

Obs: O banco deve ser postgreesql

2.2. o drive pdo_pgsql e pgsql devem estar habilitados nas configuracoes do php.ini

2-Logo mais digite "php bin/console doctrine:database:create" ->Para criar o banco de dados

3-Em seguida "php bin/console doctrine:migrations:migrate" -> Para migrar os dados da entity para o banco, assim criando as tabelas

4-Utilize o comando "symfony serve"

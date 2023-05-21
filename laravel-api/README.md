## Configurar e executar um projeto Laravel localmente

• Certifique-se de ter o PHP instalado no seu sistema. Recomenda-se a versão 7.4 ou superior.
• Tenha o Composer instalado. O Composer é um gerenciador de dependências do PHP e é necessário para instalar as dependências do Laravel.

Obtenha o código do projeto:

• Certifique-se de ter o código do projeto Laravel existente em seu computador. Isso pode ser obtido por meio de um repositório Git ou transferindo os arquivos do projeto manualmente.

Configure o arquivo .env:

• No diretório raiz do projeto Laravel, verifique se há um arquivo chamado .env. Se você não encontrar um arquivo .env, procure por um arquivo .env.example e renomeie-o para .env.
• Abra o arquivo .env e configure as informações do banco de dados de acordo com o seu ambiente local. Por exemplo, defina o DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME e DB_PASSWORD de acordo com as suas configurações locais.

Instale as dependências:

• Abra o terminal ou o prompt de comando e navegue até o diretório do seu projeto Laravel.
• Execute o seguinte comando para instalar as dependências do projeto Laravel:
    composer install

Execute o servidor de desenvolvimento:

• No terminal, execute o seguinte comando para iniciar o servidor de desenvolvimento do Laravel:
    php artisan serve
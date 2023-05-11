# sigi

O Sistema de Gerenciamento de Imobiliário (SIGI) foi desenvolvido como trabalho de conclusão do curso de Análise e Desenvolvimento de Sistemas no Instituto Federal de Educação, Ciência e Tecnologia do Rio Grande do Norte (IFRN).

Sobre o projeto

O SIGI é um sistema de gerenciamento de imóveis que permite a gestão de informações sobre imóveis, proprietários, locatários e contratos de locação. O sistema foi desenvolvido em PHP utilizando o framework Laravel e possui diversas funcionalidades, como:

Como executar o projeto

Para executar o projeto em sua máquina, siga os seguintes passos:

Clone o repositório para sua máquina: git clone https://github.com/KeziAntero/sigi-TCC.git
Entre na pasta do projeto: cd sigi-TCC
Crie um arquivo .env na raiz do projeto e configure as variáveis de ambiente com as informações do seu banco de dados. Você pode se basear no arquivo 
.env.example que já está no projeto.
Instale as dependências do projeto: composer install
Gere a chave de criptografia do Laravel: php artisan key:generate
Rode as migrações do banco de dados: php artisan migrate
Inicie o servidor local: php artisan serve
Acesse o sistema pelo endereço http://localhost:8000

Contribuições

Contribuições são bem-vindas! Se você encontrou algum bug ou tem alguma ideia para melhorar o sistema, sinta-se livre para abrir uma issue ou enviar um pull request.

Licença

Este projeto é licenciado sob a licença MIT - veja o arquivo LICENSE.md para mais detalhes.

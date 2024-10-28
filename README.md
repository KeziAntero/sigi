# Sigi

O Sistema de Gerenciamento de Imobiliário (SIGI) foi desenvolvido como trabalho de conclusão do curso de Análise e Desenvolvimento de Sistemas no Instituto Federal de Educação, Ciência e Tecnologia do Rio Grande do Norte (IFRN).

## Sobre o projeto

O SIGI é um sistema de gerenciamento de imóveis que permite a gestão de informações sobre imóveis, proprietários, locatários e contratos de locação. O sistema foi desenvolvido em PHP utilizando o framework Laravel e possui diversas funcionalidades, como:

- Gestão de imóveis
- Controle de proprietários
- Gestão de locatários
- Criação e gerenciamento de contratos de locação

## Como executar o projeto

Para executar o projeto em sua máquina, siga os seguintes passos:

1. Clone o repositório para sua máquina: 
   ```bash
   git clone https://github.com/KeziAntero/sigi-TCC.git

2. Entre na pasta do projeto: 
   ```bash
   cd sigi-TCC

3. Crie um arquivo .env na raiz do projeto e configure as variáveis de ambiente com as informações do seu banco de dados. Você pode se basear no arquivo .env.example que já está no projeto. 

4. Instale as dependências do projeto: 
   ```bash
   composer install

5. Gere a chave de criptografia do Laravel: 
   ```bash
   php artisan key:generate

6. Rode as migrações do banco de dados:
   ```bash
      php artisan migrate

7. Inicie o servidor local:
   ```bash
      php artisan serve
8. Acesse o sistema pelo endereço http://localhost:8000.

## Contribuições
 
 Contribuições são bem-vindas! Se você encontrou algum bug ou tem alguma ideia para melhorar o sistema, sinta-se livre para abrir uma issue ou enviar um pull request.

 



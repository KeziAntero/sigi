# SIGI - Sistema de Gerenciamento Imobiliário

**SIGI** é um Sistema de Informações Geográficas (SIG) desenvolvido para modernizar e otimizar a gestão imobiliária da cidade de Nova Cruz - RN. Ele integra dados cadastrais e croquis em uma plataforma web intuitiva, promovendo uma administração mais eficiente e precisa.

## 🚀 Funcionalidades

- Armazenamento centralizado de croquis cadastrais em banco de dados geográfico.
- Interface web interativa para manipulação de dados.
- Visualização de mapas e consultas espaciais em tempo real.
- Atualização rápida de informações cadastrais.
- Eliminação de limitações do arquivamento físico e desenho manual.

## 🛠️ Tecnologias Utilizadas

- **Framework**: Laravel
- **Frontend**: HTML, CSS, JavaScript
- **Biblioteca de Mapas**: Leaflet.js
- **Banco de Dados**: Mysql
- **Outras Integrações**: Sistema Integrado de Administração Tributária (SIAT)

## 📖 Objetivo

Este projeto foi desenvolvido como parte de um Trabalho de Conclusão de Curso (TCC), buscando atender às demandas da gestão tributária e imobiliária de Nova Cruz, modernizando processos e facilitando a tomada de decisão.

## 📦 Como Usar

1. Clone o repositório:
   ```bash
   git clone https://github.com/KeziAntero/sigi.git

2. Entre na pasta do projeto: 
   ```bash
   cd sigi

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


 # 📝 Licença
  
  Este projeto está sob a licença MIT.

 



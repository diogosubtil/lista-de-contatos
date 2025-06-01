# 📇 Lista de Contatos

API para gerenciamento de contatos, desenvolvida com Laravel 12 e Laravel Sanctum, permitindo cadastro, autenticação e operações CRUD de usuários e contatos.

## 🚀 Funcionalidades

- Registro de novos usuários com validação
- Autenticação via token (Laravel Sanctum)
- Recuperação de senha por e-mail
- Consulta de endereço por CEP (integração com ViaCEP)
- Exclusão de conta com confirmação de senha
- Cadastro de contatos
- Geolocalização do Google maps
- API RESTful com rotas protegidas


## 🛠️ Tecnologias Utilizadas

- PHP 8.2
- Laravel 12
- Laravel Sanctum
- MySQL
- Postman (para testes de API)
- Mailtrap (para testes de e-mail)

## 📦 Instalação

1. Clone o repositório:

   ```bash
   git clone git@github.com:diogosubtil/lista-de-contatos.git
   cd lista-de-contatos
   ```

2. Instale as dependências:

   ```bash
   composer install
   ```

3. Copie o arquivo de ambiente:

   ```bash
   cp .env.example .env
   ```

4. Configure o `.env` com suas credenciais de banco de dados e Mailtrap.

5. Gere a chave da aplicação:

   ```bash
   php artisan key:generate
   ```

6. Execute as migrações:

   ```bash
   php artisan migrate
   ```

7. Inicie o servidor:

   ```bash
   php artisan serve
   ```

## 🔐 Autenticação

A autenticação é realizada via Laravel Sanctum. Após o login, um token é gerado e deve ser utilizado no cabeçalho `Authorization` das requisições subsequentes:

```
Authorization: Bearer {token}
```

## 📬 Configuração do Mailtrap

Para testar o envio de e-mails, configure as seguintes variáveis no arquivo `.env` com suas credenciais do Mailtrap:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu_usuario
MAIL_PASSWORD=sua_senha
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=seu_email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

## ✅ Requisitos

- PHP 8.2+
- Composer
- MySQL
- Laravel 12
- Conta no Mailtrap para testes de e-mail

---


# Sistema de Gestão de Clientes Unicampo

Esta é uma aplicação desenvolvida utilizando Laravel para o backend e Vue.js para o frontend para fazer a gestão de clientes Unicampo.

## Configuração Inicial Backend

Antes de iniciar, você precisará configurar suas variáveis de ambiente.
1. Entre na pasta backend:
    ```bash
    cd backend
   	```
2.  Copie o arquivo de exemplo `.env.example` para um novo arquivo chamado `.env`:
    ```bash
    cp .env.example .env
    ```
3.  O arquivo `.env.example` já vem pré-configurado com as informações para conexão com o banco de dados se você for rodar a aplicação usando Docker. Se você for rodar sem Docker, será preciso alterar o arquivo `.env` com as informações do banco de dados.
4.  Gere uma chave para a aplicação:
    ```bash
    php artisan key:generate
    ```

## Executando o Projeto Backend

Você pode executar o projeto utilizando Docker ou configurando um ambiente PHP local.

### 1. Docker (Recomendado)

Se você tem Docker e docker compose instalados, essa é a melhor forma de rodar o projeto.

1.  Na pasta backend, execute o Docker Compose:
    ```bash
    docker compose up -d
    ```
2. Baixe os vendors:
    ```bash
    docker compose exec app composer install
    ```
3.  Execute as migrações do banco de dados:
    ```bash
    docker compose exec app php artisan migrate
    ```
4. Execute os seeders do banco de dados:
    ```bash
    docker compose exec app php artisan db:seed
    ```

A API estará acessível em `http://localhost:8000/api`

### 2. Com PHP (Ambiente Local)

Se preferir rodar o projeto diretamente com PHP em sua máquina:

**Pré-requisitos:**

*   PHP (versão compatível com o projeto, ex: PHP >= 8.1)
*   Composer
*   Servidor de banco de dados (MySQL, como configurado no `.env.example`)

**Passos:**

1.  **Configure o arquivo `.env`:**
    *   Copie `.env.example` para `.env` se ainda não o fez.
    *   Ajuste as seguintes variáveis de conexão com o banco de dados no seu arquivo `.env`:
        ```ini
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1 # ou o host do seu servidor de banco de dados
        DB_PORT=3306
        DB_DATABASE=unicampo_client_db # Nome do seu banco de dados
        DB_USERNAME=root # Seu usuário do banco de dados
        DB_PASSWORD=root # Sua senha do banco de dados
        ```
    *   Certifique-se de que o banco de dados (`unicampo_client_db` ou o nome que você escolheu) **exista** no seu servidor MySQL. Crie-o manualmente se necessário.

2.  **Instale as dependências do PHP:**
    ```bash
    composer install
    ```

3.  **Gere a chave da aplicação (se ainda não foi feito):**
    ```bash
    php artisan key:generate
    ```

4.  **Execute as migrações do banco de dados:**
    ```bash
    php artisan migrate
    ```
5.  **Execute as seeds do banco de dados:**
    ```bash
    php artisan db:seed
    ```

6.  **Inicie o servidor de desenvolvimento do Laravel:**
    ```bash
    php artisan serve
    ```
    A API estará acessível em `http://localhost:8000/api`

## Rotas da API

### Cliente
As seguintes rotas estão disponíveis para o recurso de clientes:

*   `GET /api/clientes`: Lista todos os clientes (suporta filtros e ordenação via query params, ex: `/api/clientes?filter=nome_cliente&order=asc`).
*   `POST /api/clientes`: Cria um novo cliente.
*   `GET /api/clientes/{id}`: Obtém os detalhes de um cliente específico.
*   `PUT /api/clientes/{id}`: Atualiza um cliente existente.
*   `DELETE /api/clientes/{id}`: Remove um cliente.

## Exemplo de Payload JSON (para POST e PUT)

Ao criar (`POST`) ou atualizar (`PUT`) um cliente, envie os dados no seguinte formato JSON no corpo da requisição:

```json
{
    "nome": "Nome Exemplo",
    "data_nascimento": "2001-01-01",
    "tipo_pessoa": "física",
    "cpf_cnpj": "512.775.330-83",
    "email": "cliente@example.com",
    "telefone": "(99) 99999-9999",
    "id_endereco": 1,
    "id_profissao": 1,
    "status": "ativo"
}
```

**Observações:**
*   Para `tipo_pessoa`, os valores esperados são "física" ou "jurídica".
*   Para `status`, os valores esperados são "ativo" ou "inativo".
*   `id_endereco` e `id_profissao` são IDs numéricos referentes a outras entidades (presume-se que existam).

## TO DO
- [ ] Implementar frontend completo em Vue.js
- [ ] Configurar o frontend (Vue.js) para consumir a API.
- [ ] Implementar a gestão de Endereços e Profissões (CRUD).
- [ ] Adicionar paginação e filtros mais avançados na listagem de clientes.
- [ ] Implementar autenticação/autorização para as rotas da API.
- [ ] Adicionar validação mais robusta nos requests (Form Requests no Laravel).
- [ ] Implementar o resto testes unitários, testes de integração e e2e para o backend.
- [ ] Documentar a API utilizando ferramentas como Swagger.
- [ ] Melhorar a gestão de erros e respostas da API.
- [ ] Ajustar o README quando o frontend tiver completo
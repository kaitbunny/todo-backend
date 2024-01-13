# API REST MVC em PHP 7.4.33 - To-Do

Esta é uma API REST simples desenvolvida em PHP nativo (versão 7.4.33) utilizando o banco de dados MySQL. A API gerencia um banco de dados simples com uma tabela de tasks. O desenvolvedor responsável por esta API é **Patrik Pereira dos Santos**, estudante da Fatec Carapicuíba.

## Configuração do Ambiente

Para utilizar esta API, siga os passos abaixo:

1. Instale o XAMPP 7.4.33 disponível [neste link](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.4.33/).
2. Coloque o arquivo da API na pasta `htdocs` do XAMPP.
3. Execute o script de criação do banco de dados no MySQL.
4. Modifique as configurações de host, usuário e senha no arquivo `config.php` para conectar a API ao seu banco de dados.
5. Se o seu servidor estiver em uma porta diferente, ajuste a base da URI `http://localhost` conforme necessário.
6. Se o seu projeto estiver em outra subpasta, ajuste a variável `$baseUri` no arquivo `index.php` conforme necessário.

## Estrutura da Tabela

A tabela de tasks possui os seguintes campos:

- `id` (int)
- `title` (string)
- `body` (string)
- `create_date` (string)
- `task_status` (boolean)

## Operações CRUD

### Listar Tasks (DTO Simplificado)

- **URI:** `GET http://localhost/cursosphp/projetos-solo/to-do-api/tasks`

### Mostrar Dados de uma Task

- **URI:** `GET http://localhost/cursosphp/projetos-solo/to-do-api/tasks/{id}`

### Criar nova Task

- **URI:** `POST http://localhost/cursosphp/projetos-solo/to-do-api/tasks`
- **Json da Requisição:**
  ```json
  {
    "title": "Título",
    "body": "Corpo",
    "taskStatus": false
  }
  ```

### Atualizar uma Task

- **URI:** `PUT http://localhost/cursosphp/projetos-solo/to-do-api/tasks/{id}`
- **Json da Requisição:**
  ```json
  {
    "title": "Título",
    "body": "Corpo",
    "taskStatus": false
  }
  ```

### Deletar uma Task

- **URI:** `DELETE http://localhost/cursosphp/projetos-solo/to-do-api/tasks/{id}`

## Testando a API

Utilize o Postman ou Insomnia. Certifique-se de ajustar as URIs de consumo se necessário.

## Contato do Desenvolvedor

- **Desenvolvedor:** Patrik Pereira dos Santos
  - **LinkedIn:** [patrik santos](https://www.linkedin.com/in/patriksantos1/)
- **Instituição:** Fatec Carapicuíba

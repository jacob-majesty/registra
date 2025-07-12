---
# Registra

Sistema de cadastro de reservas/tarefas em PHP, usando SQLite com PDO, Composer e Autoload.

---

## Funcionalidades

* Login simples com Bootstrap (usuário fixo: [admin@roomly.com](mailto:admin@roomly.com) / admin)
* Logout em todas as páginas
* CRUD completo para reservas/tarefas
* Prioridade das tarefas (baixa, média, alta)
* Listagem das tarefas ordenada por prioridade
* Filtro por prioridade
* Busca por título
* Mensagens de sucesso ao realizar operações

---

## Estrutura do projeto

* `/public/` — arquivos acessíveis via navegador (páginas, assets)
* `/src/` — código PHP (Controllers, Models, Core)
* `/templates/` — templates HTML reutilizáveis (header, footer, mensagens)
* `/data/` — arquivo do banco SQLite (`database.sqlite`)
* `composer.json` — gerenciador de dependências e autoload

---

## Requisitos

* PHP 7.4 ou superior
* SQLite habilitado
* Composer instalado

---

## Instalação

1. Clone este repositório:

   ```
   git clone <url-do-repositorio>
   ```
2. Entre na pasta do projeto:

   ```
   cd registra
   ```
3. Instale as dependências do Composer:

   ```
   composer install
   ```
4. Configure seu servidor local para apontar para a pasta `/public`.

---

## Uso

* Acesse a página de login em `/public/login.php`.
* Entre com o usuário: `admin@roomly.com` e senha: `admin`.
* Após login, você pode criar, editar, excluir e visualizar reservas/tarefas.
* Use os filtros e a busca para facilitar a visualização.

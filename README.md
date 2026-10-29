# 📚 Mini Biblioteca Online

Projeto acadêmico desenvolvido em grupo para uma disciplina da faculdade. O objetivo era criar um **site interativo** que integra páginas HTML, PHP e banco de dados.

O tema escolhido foi uma **mini biblioteca**: os usuários podem navegar pelos livros disponíveis, ver o resumo (sinopse) de cada um.

## ✨ Funcionalidades

* Página inicial com apresentação da biblioteca (`index.html`)
* Catálogo de livros com capa e sinopse (`livros.html`)
* Cadastro, listagem e edição de contatos, com dados salvos em banco de dados (`contato.html`, `lista\_contatos.html`, `editar\_contato.html`)
* Página sobre a equipe (`equipe.html`)

## 🛠️ Tecnologias

* HTML e CSS
* PHP
* MySQL
* XAMPP (servidor local: Apache + MySQL)

## 🚀 Como executar

1. Instale o [XAMPP](https://www.apachefriends.org/).
2. Copie a pasta do projeto para `C:\\xampp\\htdocs\\`.
3. Abra o **XAMPP Control Panel** e inicie o **Apache** e o **MySQL**.
4. Acesse `http://localhost/phpmyadmin` e crie um banco de dados com o mesmo nome definido em `config.php`.
5. Importe o arquivo `.sql` do projeto (se houver) na aba **Importar** do phpMyAdmin.
6. Ajuste usuário e senha em `config.php`, se necessário.
7. Abra no navegador: `http://localhost/NOME\_DA\_PASTA/index.html`

## 📁 Estrutura

```
├── index.html            # Página inicial
├── livros.html           # Catálogo de livros
├── equipe.html           # Equipe do projeto
├── contato.html          # Formulário de contato
├── lista\_contatos.html   # Lista de contatos
├── editar\_contato.html   # Edição de contato
├── contatos.php          # Lógica dos contatos (banco de dados)
└── config.php            # Conexão com o banco de dados
```

## 👥 Equipe

* Beatriz Nascimento
* Pedro Henriqeu

## 📄 Observação

Projeto feito para fins educacionais.


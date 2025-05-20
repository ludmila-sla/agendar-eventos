# 🗓️ Task Organizer - Sistema Inteligente de Tarefas com Agendamento Automático

Esse projeto é um sistema de organização de tarefas onde o usuário cria uma conta, cadastra suas tarefas, e o sistema — de forma **assíncrona** — gera um **calendário automático** priorizando as tarefas por ordem de prioridade, convertendo o cronograma em **PDF** e enviando para o e-mail do usuário.

## 🚀 Funcionalidades

- Cadastro de usuários com configuração de dias úteis e horas disponíveis por dia
- Criação de tarefas com prioridade e duração
- edição, listagem, e exibição de tarefas
- função de deletar tarefas e usuários
- Organização automática das tarefas em um cronograma semanal
- Geração de PDF com o cronograma
- Envio automático do PDF por e-mail
- Suporte a MongoDB como banco de dados principal
- Jobs assíncronos com fila (`queue`) para performance e escalabilidade

## 🛠️ Tecnologias

- PHP 8+
- Laravel 10
- MongoDB (via `jenssegers/laravel-mongodb`)
- Redis (cache e fila)
- DomPDF (geração de PDF)
- Laravel Queue (trabalhos assíncronos)
- Mail (envio de e-mails)

## 📦 Instalação

```bash
git clone https://github.com/SEU_USUARIO/task-organizer.git
cd task-organizer
composer install
cp .env.example .env
php artisan key:generate
```

### ⚙️ Configure o `.env`

```dotenv
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=task_db
DB_USERNAME=
DB_PASSWORD=

QUEUE_CONNECTION=redis

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu_usuario
MAIL_PASSWORD=sua_senha
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=organizer@exemplo.com
MAIL_FROM_NAME="${APP_NAME}"
```

> 🧠 Atenção: é necessário ter o PHP MongoDB Driver instalado.  
> No Linux: `sudo apt install php-mongodb`

## 🧪 Testes

Para rodar os testes:

```bash
php artisan test
```

> Os testes são feitos com `Queue::fake()` por padrão.  
> Para testar envio real de e-mails/PDFs, remova o fake manualmente do teste.

## 🖼️ Exemplo de uso

1. **Usuário cria conta** informando tempo disponível por dia
2. **Cria tarefas** com duração e prioridade
3. O sistema agenda tudo de forma inteligente
4. Gera o cronograma em PDF
5. Envia por e-mail 📩

## 🤝 Contribuição

Achou algum bug ou quer sugerir uma melhoria? Fique à vontade para abrir uma _issue_ ou mandar um _pull request_.

## 🧙‍♀️ Autora

**Ludmila** – [GitHub](https://github.com/ludmila-sla)  

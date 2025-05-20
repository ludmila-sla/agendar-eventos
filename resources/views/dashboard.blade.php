<!DOCTYPE html>
<html>
<head><title>Minhas Tarefas</title></head>
<body>
    <h1>Tarefas de {{ $user->name }}</h1>

    <a href="/tasks/create">+ Nova Tarefa</a>
    <a href="/generate-pdf">Gerar PDF do Cronograma</a>
    <a href="/delete-account" onclick="return confirm('Tem certeza que quer deletar sua conta?')">Deletar Conta</a>

    <ul>
        @foreach ($tasks as $task)
            <li>
                <a href="/tasks/{{ $task->_id }}">{{ $task->title }}</a> - Prioridade: {{ $task->priority }}
            </li>
        @endforeach
    </ul>
</body>
</html>

<!DOCTYPE html>
<html>
<head><title>{{ $task->title }}</title></head>
<body>
    <h1>{{ $task->title }}</h1>
    <p>Duração: {{ $task->duration }} min</p>
    <p>Prioridade: {{ $task->priority }}</p>

    <a href="/tasks/{{ $task->_id }}/edit">Editar</a>
    <form method="POST" action="/tasks/{{ $task->_id }}/delete" onsubmit="return confirm('Deletar esta tarefa?')">
        @csrf
        <button type="submit">Deletar</button>
    </form>
</body>
</html>

<!DOCTYPE html>
<html>
<head><title>{{ isset($task) ? 'Editar' : 'Nova' }} Tarefa</title></head>
<body>
    <h1>{{ isset($task) ? 'Editar' : 'Nova' }} Tarefa</h1>
    <form method="POST" action="{{ isset($task) ? '/tasks/'.$task->_id.'/update' : '/tasks/store' }}">
        @csrf
        <label>Título: <input type="text" name="title" value="{{ $task->title ?? '' }}" required></label><br>
        <label>Duração (minutos): <input type="number" name="duration" value="{{ $task->duration ?? '' }}" required></label><br>
        <label>Prioridade: 
            <select name="priority">
                @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" {{ isset($task) && $task->priority == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </label><br>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>

<!DOCTYPE html>
<html>
<head><title>Cadastro</title></head>
<body>
    <h1>Cadastro de Usuário</h1>
    <form method="POST" action="/register">
        @csrf
        <label>Nome: <input type="text" name="name" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Senha: <input type="password" name="password" required></label><br>
        <label>Horas disponíveis por dia: <input type="number" name="hours_per_day" required></label><br>
        <label>Incluir finais de semana?
            <select name="weekends">
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>
        </label><br>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>

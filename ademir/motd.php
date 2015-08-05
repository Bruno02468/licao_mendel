<html>
    <head>
        <title>Cadastro de Lições</title>
        <link rel="stylesheet" href="/stylesheets/dark.css">
        <meta charset="UTF-8">
    </head>

    <body style="text-align: center;">
        <h1>Painel Administrativo - Mensagem do Dia</h1>
        <small>
            Tudo programado por Bruno Borges Paschoalinoto (1º E)<br>
            Por um WhatsApp menos confuso :-)<br>
            <a href=".">[Voltar ao Painel]</a><br>
            <a href="..">[Página inicial]</a>
        </small>
        <br>
        <br>
        <br>
        <form method="GET" action="atuadores/set_motd.php">
            <table align="center">
            <tr><td>Mensagem do dia: </td><td><textarea rows="20" cols="75" name="dados"><?php echo htmlspecialchars(file_get_contents("atuadores/motd.txt")); ?></textarea></tr>
            </table>
            <input type="submit" value="Salvar MOTD">
        </form>
    </body>
</html>

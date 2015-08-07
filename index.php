<?php
/* Página inicial para o site de lições.
 * Escrito pelo Bruno Borges Paschoalinoto.
 * Altas programações :-)
 */

// Inclui o arquivo com as funções compartilhadas.
include("extras/funcs.php");

// Usar a timezone daqui.
date_default_timezone_set("America/Sao_Paulo");

// Usar a minha sala como padrão, a não ser que outra seja especificada.
$sala = "1E";
if (isset($_GET['sala'])) {
    $sala = $_GET['sala'];
}

// Nome da sala.
$nome = $sala[0] . "º " . $sala[1];

// Pasta com os arquivos da sala.
$pasta = "salas/" . $sala . "/";

// Checagem para ver se a sala existe, e, caso contrário, voltar à página inicial.
if (!file_exists($pasta) && isset($_GET['sala'])) {
    $host  = $_SERVER['HTTP_HOST'];
    $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/.");
    die();
}

// Formato de data usado nos arquivos.
$formato = "Y/m/d";

// Formato de data mostrado aos usuários.
$formato_display = "d/m/Y";

// Data de hoje, no formato padrão.
$hoje = date($formato, time());

// Dia da semana de hoje.
$hoje_semana = semana(date("l", time()));

// Data de amanhã.
$amanha = date($formato, strtotime('+1 day', strtotime($hoje)));

// Data de depois de amanhã.
$dois = date($formato, strtotime('+2 day', strtotime($hoje)));

// Data de depois de depois de amanhã.
$tres = date($formato, strtotime('+3 day', strtotime($hoje)));

// Data de ontem.
$ontem = date($formato, strtotime('-1 day', strtotime($hoje)));

// Lista de tabelas com as lições para hoje.
$hojes = "";

// Lista de tabelas com as lições para ontem.
$amanhas = "";

// Lista de tabelas com as lições para os demais dias.
$outras = "";

// Tag para ser usada para acomodar as lições para segunda.
$segundas_span = "<span class='importante'>Lições para segunda:</span><br><br>";

// Lista de tabelas com as lições para segunda, caso aplicável.
$segundas = "";

// Ler os arquivos da pasta, e ordená-los pela data de entrega especificada no arquivo.
$arquivos = glob($pasta . "*");
usort($arquivos, function($a, $b) {
    $fa = file($a);
    $fb = file($b);
    $entrega_a = strtotime($fa[1]);
    $entrega_b = strtotime($fb[1]);
    return $entrega_b < $entrega_a;
});

// Ler cada arquivo já ordenado, e executar as operações.
foreach ($arquivos as $full) {
    // Testar o nome base do arquivo para pular arquivos padrão.
    $file = basename($full);
    if ('.' === $file) continue;
    if ('..' === $file) continue;
    if ('.qc' === $file) continue;

    // Array com as linhas do arquivo.
    $arquivo = file($full);

    // A matéria a ser mostrada.
    $mat = formatar(trim($arquivo[0]));

    // Lista de elementos sintáticos para manter a coerência caso o arquivo se trate de uma prova.
    $v = "fez";
    $ent = "de entrega";
    $gabaritei = "Gabaritei";
    $classe = "entrada";

    // Alterar os elementos sintáticos caso o arquivo seja, de fato, uma prova.
    if (strpos($mat, "PROVA - ") !== false) {
        $mat = str_replace("PROVA - ", "", $mat);
        $v = "estudou";
        $ent = "da prova";
        $gabaritei = "Estou careca de estudar";
        $classe .= " prova";
    }

    // Variável a conter a tabela a ser gerada.
    $final = "<acronym title='ID de lição: " . $file . "'><table class='$classe'>\n";

    // Linha 1: a matéria.
    $materia = "<tr class='ent_th'><td valign='top' class='end_td notop'><span class='semiimportante'>Matéria:</span> </td><td class='ent_td notop' valign='top'>$mat<br></td></tr>\n";

    // Ler a data de entrega do arquivo.
    $datastr = $arquivo[1];
    $entrega_time = strtotime($datastr);
    $entrega = date($formato, $entrega_time);

    // Deletar o arquivo caso se trate de uma lição antiga (para ontem ou antes).
    if ($entrega_time < strtotime($hoje)) {
        unlink($pasta . $file);
        continue;
    }

    // Ler a data de entrega e gerar a segunda linha: a data de entrega.
    $datafin = date($formato_display, $entrega_time);
    $semanal = semana(date("l", $entrega_time));
    $datapre = "<tr class='ent_th'><td class='ent_td' valign='top'><span class='semiimportante'>Data $ent:</span> </td><td class='ent_td' valign='top'>$datafin (<b>$semanal</b>)<br></td></tr>\n";

    // Ler as informações da lição, formatá-las e gerar a terceira linha: as informações.
    $dadosarr = $arquivo;
    unset($dadosarr[0]);
    unset($dadosarr[1]);
    $dados = "<tr class='ent_th'><td class='ent_td' valign='top'><span class='semiimportante'>Informações:</span> </td><td class='ent_td' valign='top'>" . formatar_array($dadosarr) . "<br></td></tr>\n";

    // Gera uma checkbox que fica salva nos cookies, para o usuário manter uma lista das lições já feitas.
    $check = "<tr class='ent_th'><td class='ent_td' valign='top'><span class='semiimportante'>Já $v?</span> </td><td class='ent_td' valign='top'><input type='checkbox' id='$file' onclick='toggleFeita(this.id)'>$gabaritei<br></td></tr>\n";

    // Gera a tabela final, com ou sem data, dependendo da situação.
    $final .= $materia;
    $final_sem_data = $final . $dados . $check . "</table></acronym><br>\n";
    $final_com_data = $final . $datapre . $dados. $check . "</table></acronym><br>\n";

    // Coloca a tabela na lista de tabelas, de acordo com a situação.
    if ($entrega == $hoje) {
        $hojes .= $final_sem_data;
    } else if ($entrega == $amanha) {
        $amanhas .= $final_sem_data;
    } else if (($hoje_semana == "sexta" || $hoje_semana == "sábado") && $semanal == "segunda" && ($entrega == $dois || $entrega == $tres)) {
        $segundas .= $final_sem_data;
    } else {
        $outras .= $final_com_data;
    }

    // Próximo arquivo.
}

// Série de checagens para cobrir os casos onde não há uma lição.
if ($hojes == "") {
    $hojes = "<i>Sem lição para hoje, descanse.<br><br></i>\n";
}
if ($amanhas == "") {
    $amanhas = "<i>Oba! Sem lição para amanhã! Mas não se esqueça de fazer as outras!</i><br><br>\n";
}
if ($outras == "") {
    $outras = "<i>Sem outras lições, legal!</i>\n";
}
if ($segundas == "") {
    $segundas = "<i>Sem lição para segunda, boa!<br><br></i>\n";
}

// Imprime o início do arquivo, guardado num arquivo separado por ser muito comum.
include("extras/top.php")

?>
<br>
<br>
<span class="importante">Lições para hoje:</span><br><br>
<?php echo $hojes; ?>
<hr>
<br>
<span class="importante">Lições para amanhã:</span><br><br>
<?php echo $amanhas; ?>
<hr>
<br>
<?php
    // Imprime as lições para segunda caso hoje seja sexta ou sábado.
    if ($hoje_semana == "sexta" || $hoje_semana == "sábado") {
        echo "<span class='importante'>Lições para segunda:</span><br><br>$segundas</table></acronym><hr><br>\n";
    }
?>
<span class="importante">Lições para outros dias:</span><br><br>
<?php echo $outras; ?>

<script type="text/javascript" src="extras/javascript.js"></script>
<br>

</body>
</html>
<?php
// == CONEXÃO COM O BANCO DE DADOS ==
$hostname_cfg = "127.0.0.1";
$username_cfg = "root";
$password_cfg = "";
$database_cfg = "fullcalendar";

try {
    $dbh = new PDO('mysql:host='.$hostname_cfg.';dbname='.$database_cfg, $username_cfg, $password_cfg);
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $dbh->exec("set names utf8");    
} catch(PDOException $e){
    echo 'Não foi possível conectar ao banco de dados.';
    exit();
}
// ===================================

// == Primeiro Exemplo - Campo Date/Time ==
$stmt = $dbh->prepare("SELECT * FROM  compromisso");
$stmt->execute();

$result = $stmt->fetchAll();

foreach ($result as $value) {
    $id_compromisso = $value['id_compromisso'];
    $nome = $value['nome'];
    $start = $value['start'];
    $end = $value['end'];
    $color = $value['color'];

    if(!empty($time_start)){
        $time_end = date('H:i:s', strtotime('+60 minute', strtotime($time_start)));//Acrescenta 60 minutos a hora inicial e atribui na variável
    }

    $eventos[] = [
        //OBS: Os campos do JSON precisam  seguir o padrão do FullCalendar (title, start, end)
        'id' => $id_compromisso,
        'title' => $nome,
        'start' => $start,
        'end' => $end,
        'color' => $color,
    ];
}
// =======================================

// == Segundo Exemplo - Campo Date ==
$stmt = $dbh->prepare("SELECT * FROM  evento");
$stmt->execute();

$result = $stmt->fetchAll();

foreach ($result as $value) {
    $id_compromisso = $value['id_evento'];
    $nome = $value['nome_evento'];
    $start = $value['start'];
    $end = $value['end'];
    $color = $value['color'];

    if(!empty($time_start)){
        $time_end = date('H:i:s', strtotime('+60 minute', strtotime($time_start)));//Acrescenta 60 minutos a hora inicial e atribui na variável
    }

    $eventos[] = [
        //OBS: Os campos do JSON precisam  seguir o padrão do FullCalendar (title, start, end)
        'id' => $id_compromisso,
        'title' => $nome,
        'start' => $start,
        'end' => $end,
        'color' => $color,
    ];
}
//======================================
echo json_encode($eventos);
?>
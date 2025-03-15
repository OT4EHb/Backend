<?php
require_once __DIR__.'/login.php';
header('Content-Type: text/html; charset=UTF-8');
$stmt=$db->prepare("SELECT a.id_app, login FROM applications a LEFT JOIN app_users au
    ON (a.id_app=au.id_app) LEFT JOIN users u ON (au.id_user=u.id_user)");
$stmt->execute();
$apps=$stmt->fetchAll(PDO::FETCH_NUM);
$stmt=$db->prepare("SELECT lang, COUNT(*) FROM app_langs AS a JOIN languages l ON
                (a.id_lang=l.id_lang) GROUP BY lang ORDER BY COUNT(*) DESC");
$stmt->execute();
$langs=$stmt->fetchAll(PDO::FETCH_NUM);
?>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛР5</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
    th {
        text-align: center;
    }
    </style>
</head>
<body>
    <?php flash();?>
    <div class="container-fluid row align-items-start text-center p-0 m-0">
        <div class="row col-12 col-md-3 my-3">
            <table class="table table-warning table-hover table-bordered border-danger p-0 mx-2">
                <thead class="table-danger border-warning">
                    <tr>
                        <th colspan="2">Горячее за неделю</th>
                    </tr>
                    <tr>
                        <th>Язык</th>
                        <th>Популярность</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($langs as $lang){
                        print('<tr><th>'.$lang[0].'</th><th>'.$lang[1]."</th></tr>");
                    }?>
                </tbody>
            </table>
        </div>
        <div class="row col-12 col-md-9 mx-auto my-3 justify-content-evenly">        
        <?php
        if (empty($apps)){
            print('<h1 class="text-danger">Всё удалено</h1>');
        }
        else foreach ($apps as $app){
            print('
            <div class="card col-5 col-md-3 mx-1 my-2">
                <div class="card-header">Таблица '.$app[0].'</div>
                <div class="card-body row">
                    <p>Владелец: '.(empty($app[1])?'читер какой-то':$app[1]).'</p>
                    <a href="form.php?numer='.$app[0].'" class="btn btn-primary my-2">Редактировать</a>
                    <a href="deleter.php?numer='.$app[0].'"
                        class="btn btn-'.(empty($app[1])?'danger':'primary').' my-2">Удалить</a>
                </div>
            </div>');
        }?>
        </div>
    </div>
</body>
</html>
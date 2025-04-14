<?php
require_once __DIR__ . '/session.php';
header('Content-Type: text/html; charset=UTF-8');
$stmt = $db->prepare((isAdmin() ? "SELECT a.id_app, login, a.FIO FROM applications a 
    LEFT JOIN app_users au ON (a.id_app=au.id_app) LEFT JOIN users u
    ON (au.id_user=u.id_user)" : "SELECT id_app FROM app_users WHERE id_user=?"));
$stmt->execute((isAdmin() ? [] : [$_SESSION['login']]));
$apps = $stmt->fetchAll(PDO::FETCH_NUM);
$langs = array();
if (isAdmin()) {
    $stmt = $db->prepare("SELECT lang, COUNT(*) FROM app_langs AS a JOIN languages l ON
                (a.id_lang=l.id_lang) GROUP BY lang ORDER BY COUNT(*) DESC");
    $stmt->execute();
    $langs = $stmt->fetchAll(PDO::FETCH_NUM);
}
?>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛР6</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
    th {
        text-align: center;
    }
    </style>
</head>
<body>
    <?php flash(); ?>
    <div class="container-fluid row align-items-start text-center p-0 m-0">
        <?php if (isAdmin()) { ?>
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
                foreach ($langs as $lang) {
                    print ('<tr><th>' . $lang[0] . '</th><th>' . $lang[1] . "</th></tr>");
                } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
        <div class="row col-12 col-md-9 mx-auto my-3 justify-content-evenly">        
        <?php if (!isAdmin()) { ?>
            <div class="card col-6 col-md-2 mx-1 my-2">
                <div class="card-header">Новая таблица</div>
                <div class="card-body">
                    <a href="form.php" class="btn btn-primary">Создать</a>
                </div>
            </div>
        <?php } else if (empty($apps)) {
            print ('<h1 class="text-danger">Всё удалено</h1>');
        }
        foreach ($apps as $key => $app) {
            print ('
            <div class="card col-6 col-md-3 mx-1 my-2">
                <div class="card-header">Таблица ' . (isAdmin() ? $app[0] : $key + 1) . '</div>
                <div class="card-body row">' . (isAdmin() ? '
                    <p>Владелец: ' . (empty($app[1]) ? 'читер какой-то' : $app[1]) . '</p>
                    <p>Фамилия: '.$app[2].'</p>'
                    : '') . '
                    <a href="form.php?numer=' . $app[0] . '" class="link-info my-2">Редактировать</a>
                    ' . (isAdmin() ? '<form method="post" action="deleter.php?numer=' . $app[0] . '&token=' . $token . '">
                        <button type="submit" class="btn btn-' . (empty($app[1]) ? 'danger' : 'primary') . ' my-2">Удалить</button>
                        </form>' : '') . '
                </div>
            </div>');
        } ?>
        </div>
    </div>
</body>
</html>
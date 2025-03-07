<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабы</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="d-flex row gx-0 text-center w-75 mx-auto my-3 justify-content-evenly">
    <?php
    for ($i=1;$i<=5;$i++){
        print('
        <div class="card col-3 mx-1 my-2">
        <div class="card-header">Лабораторная работа '.$i.'</div>
        <div class="card-body">
            <a href="'.$i.'/" class="btn btn-primary">Приступить к досмотру</a>
            </div>
        </div>');
    }
    ?>
    </div>
</body>
</html>
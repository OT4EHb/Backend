<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛР4</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .maxw960 {
            max-width: 960px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <p class="text-center bg-primary my-4"><?php print_r($messages)?></p>
    <form action="form.php" method="post" class="px-2 maxw960">
        <label class="form-control bg-<?php print($error['fio']?'danger':'warning')?> border-0 form-label">
            <?php print($error['fio']?$error['fio']:'Введите ФИО:')?>
            <input placeholder="Иванов Иван Иванович" name="FIO" required class="form-control req">
        </label>
        <label class="form-control bg-<?php print($error['tel']?'danger':'warning')?> border-0 form-label">
            <?php print($error['tel']?$error['tel']:'Введите номер телефона:'?>
            <input type="tel" placeholder="+7(XXX) XXX-XX-XX" name="tel" required class="form-control req">
        </label>
        <label class="form-control bg-<?php print($error['email']?'danger':'warning')?> border-0 form-label">
            Введите email:
            <input type="email" placeholder="email@email.com" name="email" required class="form-control req">
        </label>
        <label class="form-control bg-<?php print($error['dr']?'danger':'warning')?> border-0 form-label">
            Введите дату рождения:
            <input type="date" name="DR" required class="form-control req">
        </label>

        <div class="form-control bg-<?php print($error['sex']?'danger':'warning')?> border-0">
            <p class="my-2">Выберите ваш пол:</p>
            <label>
                <input type="radio" name="sex" checked class="form-check-input" value="0">
                Мужской
            </label>
            <label>
                <input type="radio" name="sex" class="form-check-input" value="1">
                Женский
            </label>
        </div>

        <label class="form-control bg-<?php print($error['lang']?'danger':'warning')?> border-0 form-label my-2">
            Выберите любимый(-ые) язык(-и) программирования:
            <select multiple class="form-select req" name="lang">
                <option value="1">Pascal</option>
                <option selected value="2">C</option>
                <option selected value="3">C++</option>
                <option value="4">JavaScript</option>
                <option value="5">PHP</option>
                <option selected value="6">Python</option>
                <option selected value="7">Java</option>
                <option value="8">Haskel</option>
                <option value="9">Clojure</option>
                <option value="10">Prolog</option>
                <option value="11">Scala</option>
            </select>
        </label>

        <label class="form-control bg-secondary border-0 my-2 form-label">
            Расскажите о своей жизни (биография):
            <textarea class="form-control req" name="bio" placeholder="Начал писать свои первые произведения﻿ уже в семь лет. Создавал не только стихи﻿, но и произведения в поддержку революционеров — за вольнодумство даже отправляли в ссылки."></textarea>
        </label>

        <label class="form-control bg-warning border-0 my-2 form-label">
            <input type="checkbox" class="form-check-input" required>
            С контрактом ознакомлен(-а)
        </label>
        <input type="submit" value="Сохранить" class="btn-success btn my-2 form-control" id="buttonSave">
    </form>
</body>
</html>
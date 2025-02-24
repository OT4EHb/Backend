<?php
$errors = array();
$values = array();
$languages=empty($_COOKIE['lang_value'])?array():explode("|", $_COOKIE['lang_value']);

function setValue($name) {
    global $values;
    $values[$name] = empty($_COOKIE[$name.'_value']) ? '' : $_COOKIE[$name.'_value'];
}

function setErrors($name) {
    global $errors;
    $errors[$name] = empty($_COOKIE[$name.'_error']) ? '' : $_COOKIE[$name.'_error'];
}

function checkLang($num){
    global $languages;
    print(in_array($num, $languages) ? 'selected' : '');
}

if (!empty($_COOKIE['save'])) {
    setcookie('save', '', strtotime("-1 day"));
    setcookie('DBerror', '', strtotime("-1 day"));
}

foreach (array('fio', 'tel', 'email', 'dr', 'sex', 'bio') as $v) {
    setErrors($v);
    setValue($v);
}
setErrors('lang');
?>
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
    <p class="text-center bg-primary mb-4">
    <?php print(empty($_COOKIE['save']) ? 
    (empty($_COOKIE['DBerror']) ? '' : $_COOKIE['DBerror'])
    : $_COOKIE['save'])?>
    </p>
    <form action="./" method="post" class="px-2 maxw960">
        <label class="form-control bg-<?php print($errors['fio']?'danger':'warning')?> border-0 form-label">
            <?php print($errors['fio']?$errors['fio']:'Введите ФИО:')?>
            <input placeholder="Иванов Иван Иванович" name="FIO" required
            class="form-control req" value="<?php print($values['fio'])?>">
        </label>
        <label class="form-control bg-<?php print($errors['tel']?'danger':'warning')?> border-0 form-label">
            <?php print($errors['tel']?$errors['tel']:'Введите номер телефона:')?>
            <input type="tel" placeholder="+7(XXX) XXX-XX-XX" name="tel" required 
            class="form-control req" value="<?php print($values['tel'])?>">
        </label>
        <label class="form-control bg-<?php print($errors['email']?'danger':'warning')?> border-0 form-label">            
            <?php print($errors['email']?$errors['email']:'Введите email:')?>
            <input type="email" placeholder="email@email.com" name="email" required 
            class="form-control req" value="<?php print($values['email'])?>">
        </label>
        <label class="form-control bg-<?php print($errors['dr']?'danger':'warning')?> border-0 form-label">
            <?php print($errors['dr']?$errors['dr']:'Введите дату рождения:')?>
            <input type="date" name="DR" required 
            class="form-control req" value="<?php print($values['dr'])?>">
        </label>

        <div class="form-control bg-<?php print($errors['sex']?'danger':'warning')?> border-0"> 
            <p class="my-2"><?php print($errors['sex']?$errors['sex']:'Выберите ваш пол:')?></p>            
            <label>
                <input type="radio" name="sex" class="form-check-input" value="0"
                <?php print($values['sex']?'':'checked')?>>
                Мужской
            </label>
            <label>
                <input type="radio" name="sex" class="form-check-input" value="1"
                <?php print($values['sex']?'checked':'')?>>
                Женский
            </label>
        </div>

        <label class="form-control bg-<?php print($errors['lang']?'danger':'warning')?> border-0 form-label my-2">
            <?php print($errors['lang']?$errors['lang']:'Выберите любимый(-ые) язык(-и) программирования:')?>            
            <select multiple class="form-select req" name="lang[]">
                <option <?php checkLang(1)?> value="1">Pascal</option>
                <option <?php checkLang(2)?> value="2">C</option>
                <option <?php checkLang(3)?> value="3">C++</option>
                <option <?php checkLang(4)?> value="4">JavaScript</option>
                <option <?php checkLang(5)?> value="5">PHP</option>
                <option <?php checkLang(6)?> value="6">Python</option>
                <option <?php checkLang(7)?> value="7">Java</option>
                <option <?php checkLang(8)?> value="8">Haskel</option>
                <option <?php checkLang(9)?> value="9">Clojure</option>
                <option <?php checkLang(10)?> value="10">Prolog</option>
                <option <?php checkLang(11)?> value="11">Scala</option>
            </select>
        </label>

        <label class="form-control bg-<?php print($errors['bio']?'danger':'secondary')?> border-0 my-2 form-label">
            <?php print($errors['bio']?$errors['bio']:'Расскажите о своей жизни (биография):')?>   
            <textarea class="form-control req" name="bio"
            placeholder="Начал писать свои первые произведения﻿ уже в семь лет. Создавал не только стихи﻿, но и произведения в поддержку революционеров — за вольнодумство даже отправляли в ссылки."
            ><?php print($values['bio'])?></textarea>
        </label>

        <label class="form-control bg-warning border-0 my-2 form-label">
            <input type="checkbox" class="form-check-input" required>
            С контрактом ознакомлен(-а)
        </label>
        <input type="submit" value="Сохранить" class="btn-success btn my-2 form-control" id="buttonSave">
    </form>
</body>
</html>
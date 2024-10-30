<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Feedback</title>
</head>

<body>

    <?php
    require './engine/Db.php';
    if (array_key_exists('name', $_POST)) {
        if (strlen((string)$_POST['name']) && strlen((string)$_POST['email']) && strlen((string)$_POST['message'])) {
            $db = new Db;
            $db->createFeedBackTable();
            if ($db->insert('feedback', ['name' => $_POST['name'], 'email' => $_POST['email'], 'message' => $_POST['message']]))
                echo "<p class='suscess_text'>Данные успешно отправлены</p>";
        } else $error = "Заполнены не все поля";
    }

    if ($error || !array_key_exists('name', $_POST)) {
    ?>
        <div class="container">
            <h1 class="header_text">Отправить сообщение:</h1>
            <div class="form_container">
                <p class="error_message"><?= $error ?> </p>
                <form action="/" method="POST">
                    <div class="input_wrapper">
                        <label for="name" class="form_label">Имя:</label>
                        <input type="text" name="name" id="name" class="form_input" value="<?= $_POST['name'] ?>">
                    </div>
                    <div class="input_wrapper">
                        <label for="email" class="form_label">Электронная почта:</label>
                        <input type="email" name="email" id="email" class="form_input" value="<?= $_POST['email'] ?>">
                    </div>
                    <div class="input_wrapper">
                        <label for="message" class="form_label">Сообщение:</label>
                        <textarea name="message" id="message" class="form_input form_textarea"><?= $_POST['message'] ?></textarea>
                    </div>

                    <input type="submit" value="Отправить" class="form_submit">



                </form>
            </div>

        </div>
    <?php } ?>
</body>

</html>
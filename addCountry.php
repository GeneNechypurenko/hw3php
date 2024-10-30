<!DOCTYPE html>
<html lang="ru">
<?php include 'partials/head.php'; ?>
<body class="bg-light">
<?php include 'partials/navbar.php'; ?>

<div class="container mt-5 d-flex justify-content-center">
    <div class="card p-4 shadow" style="width: 400px;">
        <h2 class="text-center">Добавить страну</h2>

        <form action="" method="post" class="mt-3">
            <div class="mb-3">
                <input type="text" name="country" class="form-control" placeholder="Введите название страны" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Добавить</button>
        </form>

        <?php
        $countriesFile = 'countries.txt';
        $dictionaryFile = 'dictionary.txt';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $country = trim($_POST['country']);

            if ($country !== '' && isValidCountry($country, $dictionaryFile)) {
                if (!countryExists($country, $countriesFile)) {
                    file_put_contents($countriesFile, $country . PHP_EOL, FILE_APPEND);
                    echo "<div class='alert alert-success mt-3'>Страна добавлена!</div>";
                } else {
                    echo "<div class='alert alert-danger mt-3'>Страна уже существует!</div>";
                }
            } else {
                echo "<div class='alert alert-danger mt-3'>Неверное название страны!</div>";
            }
        }

        function countryExists($country, $file) {
            if (!file_exists($file)) return false;
            $countries = file($file, FILE_IGNORE_NEW_LINES);
            return in_array($country, $countries);
        }

        function isValidCountry($country, $dictionaryFile) {
            if (!file_exists($dictionaryFile)) return false;
            $validCountries = file($dictionaryFile, FILE_IGNORE_NEW_LINES);
            return in_array($country, $validCountries);
        }

        if (file_exists($countriesFile)) {
            $countries = file($countriesFile, FILE_IGNORE_NEW_LINES);
            echo "<div class='mt-4'>
                        <label for='country-select' class='form-label'>Список стран:</label>
                        <select id='country-select' class='form-select'>";
            foreach ($countries as $country) {
                echo "<option>$country</option>";
            }
            echo "</select>
                    </div>";
        }
        ?>
    </div>
</div>
</body>
</html>

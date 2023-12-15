<?php
// URL adresa s daty
$url = "https://www.cnb.cz/cs/financni-trhy/devizovy-trh/kurzy-devizoveho-trhu/kurzy-devizoveho-trhu/denni_kurz.txt";

$data = file_get_contents($url);

// Datum platnosti kurzovního lístku: první řádek do znaku #
$datum = explode("#", $data)[0];

// Rozdělení dat na řádky a odstranění hlavičky
$lines = array_slice(explode("\n", $data), 2);
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Kurzovní lístek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <h1 class="text-center text-nowrap text-uppercase fw-bold m-3 font-monospace">Kurzovní lístek</h1>
    <p class="text-center text-nowrap">Datum platnosti kurzovního lístku: <?= $datum ?></p>
    <div class="d-flex justify-content-center">
        <table class="table table-hover table-responsive-sm table-bordered text-nowrap w-75 border border-4 border-dark-subtle">
            <thead>
                <tr>
                    <th class="bg-dark-subtle">Kód měny</th>
                    <th class="bg-dark-subtle">Název země</th>
                    <th class="bg-dark-subtle">Hodnota 1 mil. Kč</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lines as $line) : ?>
                    <?php if (!empty($line)) {
                        $fields = explode('|', $line);
                        $code = $fields[3];
                        $name = $fields[0];
                        $amount = intval($fields[2]);
                        $rate = floatval(str_replace(",", ".", $fields[4]));
                        $valueInMil = (1000000 / $rate) * $amount;
                    ?>
                        <tr>
                            <td><?= $code ?></td>
                            <td><?= $name ?></td>
                            <td><?= number_format($valueInMil, 2, '.', '') ?></td>
                        </tr>
                    <?php } ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>

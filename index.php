<?php include 'fonks\conn.php';
$sistem = new sistem();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restorant Sipariş Sistemi</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>


<body>
    <div class="container-fluid">
        <div class="row bg-secondary" id="rows">
            <div class="col-md-3 border-right h5 text-white">Toplam Sipariş : <a class="text-warning">10</a></div>
            <div class="col-md-3 border-right h5 text-white">Doluluk Oranı : <a class="text-warning">10</a></div>
            <div class="col-md-3 border-right h5 text-white">Toplam Masa : <a class="text-warning"><?php $sistem->tablerow($conn); ?></a></div>
            <div class="col-md-3 border-right h5 text-white">Tarih : <a class="text-warning"><?php echo date("d.m.Y"); ?></a></div>
        </div>

        <div class="row">
            <?php $sistem->fetchTable($conn); ?>
        </div>

    </div>

    <script src="assets/jquery-3.6.0.min.js"></script>
</body>

</html>
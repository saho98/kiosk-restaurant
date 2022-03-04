<?php include 'fonks\conn.php'; 
    $table= new sistem();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran Sipariş Sistemi</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
</head>
<style>
    
</style>
<body>
<?php 

$tableId = $_GET['tableId'];

if($tableId!=""){



?>



    <div class="container-fluid">
        <div class="row border" style="min-height:700px">
            <div class="col-md-2 border-right border-grey">
                 <div class="row">
                     <div class="col-md-12 border-bottom bg-info text-white" style="min-height: 100px;">
                        <?php 
                        $query =$table->getTableName($conn,$tableId);
                        $array = $query->fetch(PDO::FETCH_ASSOC);
                        echo $array['tableName'];

                    ?>
                    </div>
                     <div class="col-md-12 border-bottom bg-light ">s</div>
                     <div class="col-md-12 border-bottom bg-light ">s</div>
                     <div class="col-md-12 border-bottom bg-light ">s</div>
                 </div>
            </div>
            <div class="col-md-10">

            </div>
        </div>

    </div>
<?php 
}else{
    echo "Hata";
}
?>
<script src="assets/jquery-3.6.0.min.js"></script>
</body>
</html>


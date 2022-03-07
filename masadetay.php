<?php include 'fonks\conn.php';
$table = new sistem();
$tableId = $_GET['tableId'];
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
    if ($tableId != "") {
    ?>



        <div class="container-fluid">
            <div class="row border" style="min-height:700px">

            <!-- TABLE NAME -->
                <div class="col-md-2 border-right border-grey">

                    <div class="row">
                        <div class="col-md-12 border-bottom bg-info text-white text-center mx-auto p-3 h1" style="min-height: 100px;">
                            <?php
                            $query = $table->getTableName($conn, $tableId);
                            $array = $query->fetch(PDO::FETCH_ASSOC);
                            echo $array['tableName'];
                            ?>
                        </div>
                        <div id="orderName"></div>
                    </div>

                </div>



                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12" id="prodList">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">

                        </div>
                    </div>

                    <!-- <form id="form1">
                    <input type="text" name="prodId">
                    <input type="text" name="quantity">
                    <input type="hidden" name="tableId" value="echo $tableId;">
                    <input type="button" id="btn" value="Ekle"></form>-->
                    
             </div>
            
            <!-- CATEGORIES -->
                    <div class="col-md-2 border-left" id="cat">
                        <?php $table->getCategories($conn); ?>
                    </div>

                </div>

        </div>
        <?php
    } else {
        echo "Hata";
    }
        ?>

        <script src="assets/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                var id = "<?php echo $tableId; ?>";

                $("#orderName").load("transactions.php?transaction=show&id=" + id);

                $("#btn").click(function() {
                    $.ajax({

                        type: "POST",
                        url: 'transactions.php?transaction=add',
                        data: $('#form1').serialize(),
                        success: function(url_show) {
                            $("#orderName").load("transactions.php?transaction=show&id=" + id);
                        },


                    })

                })

                $("#cat a").click(function() {
                    var sectionid = $(this).attr('sectionid');
                    $("#prodList").load("transactions.php?transaction=prod&id=" + sectionid).fadeIn();

                })

            })
        </script>
</body>

</html>
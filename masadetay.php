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
    <link rel="stylesheet" href="assets/style.css">
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
                <div class="col-md-3 border-right border-grey" id="leftpanel">

                    <div class="row">
                        <div class="col-md-12 border-bottom bg-info text-white text-center mx-auto p-3 h1" id="tableName">
                            <a href="index.php" class="btn btn-warning ">Ana Sayfa</a>
                            <div class="display-1">
                                <?php
                                $query = $table->getTableName($conn, $tableId);
                                $array = $query->fetch(PDO::FETCH_ASSOC);
                                echo $array['tableName'];
                                ?>
                            </div>
                            
                        </div>

                        <div class="col-md-12 text-center" id="orderName"></div>
                        <div class="col-md-12 text-center" id="success"></div>
                    </div>

                </div>



                <div class="col-md-7" id="middlePanel">
                    <div class="row""><form id="form1">
                        <div class="col-md-12 " style="min-height:600px;" id="prodList">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="tableId" value="<?php echo $tableId; ?>">
                                    <input type="button" id="btn" value="Ekle" class="btn btn-success btn-block mt-4">
                                </div>
                                <div class="col-md-6">
                                    <?php for ($i = 1; $i <= 8; $i++) {
                                        echo '<label class="btn btn-secondary m-2"><input type="radio" name="quantity" value="' . $i . '">' . $i . '</label>';
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    <!-- 
                    <input type="text" name="prodId">
                    
                    <input type="hidden" name="tableId" value="echo $tableId;">
                    <input type="button" id="btn" value="Ekle">-->

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

            $("#orderName").load("transactions.php?transaction=show&id="+id);

            $("#btn").click(function() {
                $.ajax({

                    type: "POST",
                    url: 'transactions.php?transaction=add',
                    data: $('#form1').serialize(),
                    success: function(url_show) {
                        $("#orderName").load("transactions.php?transaction=show&id=" + id);
                        $('#form1').trigger("reset");
                        $('#success').html(url_show).slideDown(1500);
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
<!DOCTYPE html>
<html>

<body>

<?php 
include "fonks/conn.php";


$transaction = $_GET["transaction"];

switch ($transaction) {
    case "show" :
        // 
        $id=$_GET["id"];
        $stmt=$conn->prepare("SELECT * from tblanlıksiparis where tableId=?");
        $stmt->execute(array($id));
        if($stmt->rowCount()==0) {
            echo '<div class="alert alert-info m-3 display-block">Henüz Sipariş Yok</div>';
        }else{
            echo '<table class="table-responsive "><table class="table table-bordered table-striped">
            <thead><tr>
            <th scope="col">Ürün Adı</th>
            <th scope="col">Adet</th>
            <th scope="col">Tutar</th>
            <th scope="col">İşlemler</th>
            </tr></thead>
            <tbody>';
            $adet = 0;
            $sum = 0;
            while($show=$stmt->fetch(PDO::FETCH_ASSOC)){
                $tableId = $show['tableId'];
                $tutar = $show['adet'] * $show['urunFiyat'];
                $adet += $show['adet'];
                $sum += $tutar;
                echo  '<tr>
                <td>'.$show['urunAd'].'</td>
                <td>'.$show['adet'].'</td>
                <td>'.$tutar.'₺'.'</td>
                <td id="catch"><a class="btn btn-danger text-white" sectionId="'.$show['orderId'].'">SİL</a></td>
                </tr>';
            }
            echo '
            
            <tr class="table-danger">
            <td class="font-weight-bold">TOPLAM</td>
            <td>'.$adet.'</td>
            <td>'.$sum.'₺'.'</td>
            <td>
            </tbody></table></table>
            <div class="row">
                <div class="col-md-12">
                    <div id="result2"></div>
                    <form id="billp">
                        <input type="hidden" name="tableId" value="'.$tableId.'">
                        <input type="button" id="billb" value="HESAP AL" class="btn btn-danger btn-block mt-4">
                    </form>
                </div>
            </div>
           ';
        }
        

        break;
    
    case "add" :

        if($_POST){
        @$tableId=htmlspecialchars($_POST["tableId"]);
        @$prodId=htmlspecialchars($_POST["prodId"]);
        @$quantity=htmlspecialchars($_POST["quantity"]);
            if($tableId=="" || $prodId=="" || $quantity==""){        
                    echo '<div class="alert alert-danger m-3 display-block">Eksik veri girişi</div>';
            }else{

            $stm=$conn->prepare("SELECT adet,orderId from tblanlıksiparis where urunId = ? and tableId = ?");
            $stm->execute(array($prodId,$tableId));
            
            if($stm->rowCount()<>0){
                $result = $stm->fetch(PDO::FETCH_ASSOC);
                $addQuant = $quantity + $result["adet"];
                $id = $result['orderId'];
                $stmt = $conn->prepare("UPDATE tblanlıksiparis set adet = ? where orderId = ?");
                $stmt->execute(array($addQuant,$id));
                echo '<div class="alert alert-success m-3 display-block">Ekleme Yapıldı</div>';
            }else{
                $stmt=$conn->prepare("SELECT urunName,urunFiyat from tblurunler where urunId=?");
                $stmt->execute(array($prodId));
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $urunName = $result['urunName'];
                $urunFiyat = $result['urunFiyat']; 
                $stmt2=$conn->prepare("INSERT into tblanlıksiparis (tableId,urunId,urunAd,urunFiyat,adet) values (?,?,?,?,?)");
                $stmt2->execute(array($tableId,$prodId,$urunName,$urunFiyat,$quantity));
                echo '<div class="alert alert-success m-3 display-block">Ekleme Yapıldı</div>';
            }

         }   
        }else{
        echo "Hata Var.";
         }   

        break;
        
    case "delete":

        if(!$_POST){
            echo "Hata!";
        }else{
            $orderId=htmlspecialchars($_POST["orderId"]);
            $stmt=$conn->prepare("DELETE from tblanlıksiparis where orderId=:orderid");
            $stmt->execute(array("orderid" => $orderId));
            echo '<div class="alert alert-danger m-3 display-block">Silindi</div>';
        };

        break;
            
        
    case "prod" :
        $id=$_GET["id"];
        $stmt=$conn->prepare("SELECT * from tblurunler where cat_id=?");
        $stmt->execute(array($id));
        if($stmt->rowCount()==0){
            echo "Bu kategoride ürün bulunamadı.";
        }else
        
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo '<label class="btn btn-secondary m-2"><input type="radio" name="prodId" value="'.$result["urunId"].'">'.$result["urunName"].': '.'<strong>'.$result["urunFiyat"].'</strong>'.'₺'.'</label>';
        }    
        break;
    
    case "checkout" :
        if(!$_POST){
            echo "Hata!";
        }else{

            $tableId=htmlspecialchars($_POST["tableId"]);
            
            $b=$con->prepare("SELECT * from tblanlıksiparis where tableId =: tableid");

            
            $stmt=$conn->prepare("INSERT into tblreport (tableId,urunId,urunAd,urunFiyat,adet) values ()");
            
            $stmt=$conn->prepare("DELETE from tblanlıksiparis where tableId=:tableid");
            $stmt->execute(array("tableid" => $tableId));
            echo '<div class="alert alert-succes m-3 display-block">Hesap Alındı</div>';
        };

        break;


            
           
}
?>


<script src="assets/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#catch a').click(function(){
            var sectionId = $(this).attr('sectionid');
            $.post("transactions.php?transaction=delete",{"orderId":sectionId},function(post_data){
                window.location.reload();
                $("#result2").html(post_data);
            });
        });

        $("#billb").click(function() {
                $.ajax({

                    type: "POST",
                    url: 'transactions.php?transaction=checkout',
                    data: $('#billp').serialize(),
                    success: function(checkout_show) {
                        $('#billb').trigger("reset");
                        window.location.reload();
                    },


                })

            })
    });

</script>
</body>
</html>   


                
        
        
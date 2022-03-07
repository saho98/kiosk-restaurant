<?php 

try{
    //PDO ile bağlantı
    $conn = new PDO("mysql:host=localhost;dbname=db_restaurant","root","");
    $conn->query("set CHARSET UTF8");
    //Bağlantı kurulamaması halinde alınacak mesaj
}catch(PDOException $a){
    die("Bağlantı kurulamadı.".$a->getMessage());
}

$transaction = $_GET["transaction"];

switch ($transaction) {
    case "show" :
        // 
        $id=$_GET["id"];
        $stmt=$conn->prepare("SELECT * from tblanlıksiparis where tableId=?");
        $stmt->execute(array($id));
        if($stmt->rowCount()==0) {
            echo "Henüz Sipariş Yok";
        }else{

            while($show=$stmt->fetch(PDO::FETCH_ASSOC)){
                echo  '<div class="col-md-12 border-bottom bg-light ">'.$show['urunId'].'</div>';
            }
        }
        

        break;
    
    case "add" :
        $tableId=$_POST["tableId"];
        $prodId=$_POST["prodId"];
        $quantity=$_POST["quantity"];

        
        $stmt=$conn->prepare("INSERT into tblanlıksiparis (tableId,urunId,urunAd,urunFiyat,adet) values (?,?,?,?,?)");
        $stmt->execute(array($tableId,$prodId,'cacık',20,$quantity));
        

        break;
        
    case "prod" :
        $id=$_GET["id"];
        $stmt=$conn->prepare("SELECT * from tblurunler where cat_id=?");
        $stmt->execute(array($id));
        if($stmt->rowCount()==0){
            echo "Bu kategoride ürün bulunamadı.";
        }else
        
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            echo "Ürün Adı: ".$result["urunName"]."<br>";
            echo "Fiyatı: ".$result["urunFiyat"]."<br>";
        }


        break;
    

}

?>
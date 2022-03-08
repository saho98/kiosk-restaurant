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
            echo '<table class="table-responsive"><table class="table">
            <thead><tr>
            <th scope="col">Ürün Adı</th>
            <th scope="col">Adet</th>
            <th scope="col">Tutar</th>
            </tr></thead>
            <tbody>';
            while($show=$stmt->fetch(PDO::FETCH_ASSOC)){
                $tutar = $show['adet'] * $show['urunFiyat'];
                echo  '<tr>
                <td>'.$show['urunAd'].'</td>
                <td>'.$show['adet'].'</td>
                <td>'.$tutar.'₺'.'</td>
                </tr>';
            }
            echo '</table></table>';
        }
        

        break;
    
    case "add" :

        if($_POST){
        @$tableId=htmlspecialchars($_POST["tableId"]);
        @$prodId=htmlspecialchars($_POST["prodId"]);
        @$quantity=htmlspecialchars($_POST["quantity"]);
            if($tableId=="" || $prodId=="" || $quantity==""){        
                    echo "Eksik veri girişi";
            }else{
        $stmt=$conn->prepare("SELECT urunName,urunFiyat from tblurunler where urunId=?");
        $stmt->execute(array($prodId));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $urunName = $result['urunName'];
        $urunFiyat = $result['urunFiyat']; 
        $stmt2=$conn->prepare("INSERT into tblanlıksiparis (tableId,urunId,urunAd,urunFiyat,adet) values (?,?,?,?,?)");
        $stmt2->execute(array($tableId,$prodId,$urunName,$urunFiyat,$quantity));
        echo "Ekleme Yapıldı.";
        }   
        }else{
        echo "Hata Var.";
         }   

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
            
           
}

?>

        
    


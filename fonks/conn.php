<?php
try{
    //PDO ile bağlantı
    $conn = new PDO("mysql:host=localhost;dbname=db_restaurant","root","");
    $conn->query("set CHARSET UTF8");
    //Bağlantı kurulamaması halinde alınacak mesaj
}catch(PDOException $a){
    die("Bağlantı kurulamadı.".$a->getMessage());
}

class sistem{
    //tek fonksiyon ile gelecek sorguların parametreleri çekiliyor
    private function sorgu($con,$stmt){
        
        $b=$con->prepare($stmt);
        $b->execute();
        return $b;
    
    }

    
    
    //veritabanındaki masaları fetch_assoc komutu ile yazdırıyoruz
    public function catchmasa($conn){
        
        $stm ="select * from tblmasalar";
        $b=$this->sorgu($conn,$stm);
        while($da = $b->fetch(PDO::FETCH_ASSOC)){

            //pdo prepare parametre gerektirdiği için sorgu fonksiyonunu kullanamadım
            $stm = $conn->prepare('select * from tblanlıksiparis where tableId =?');
            $stm->execute(array($da["id"]));
            
            
            //bu komut eğer anlık sipariş tablosunda veri var ise masa kutucuklarının yeşil olması,aksi durumda kırmızı olması için
            $count = $stm->rowCount();
            if($count==0){$renk = "danger";}else{$renk = "success";}
            
            //çekilecek her tablo için bu html kodları gelicek.    
            echo '<div class="col-md-2 col-sm-3 border ml-5  bg-'.$renk.' text-center text-white" id="masalar">
            <div class="mx-auto p-2 text-center text-white"  id="masa" ><a href="masadetay.php?tableId='.$da["id"].'">'.$da["tableName"].'</a></div></div>';

        }

    }

    public function masarow($conn){
        
        $stm ="select * from tblmasalar";
        $b=$this->sorgu($conn,$stm); 
        echo count($b->fetchAll(PDO::FETCH_ASSOC));

    }


}




?>

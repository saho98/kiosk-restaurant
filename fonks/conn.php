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
    //tek fonksiyon ile gelecek sorguları hazır execute edilmesi
    private function mainquery($con,$stmt){
        
        $b=$con->prepare($stmt);
        $b->execute();
        return $b;
    
    }
    //parametreli sorguları çekmek için
    private function mainparam1($con,$stmt,$p1){
        
        $b=$con->prepare($stmt);
        $b->execute(array("$p1"));
        return $b;
    
    }
    
    
    //veritabanındaki masaları fetch_assoc komutu ile yazdırıyoruz
    public function fetchTable($conn){
        
        $stm ="select * from tblmasalar";
        $b=$this->mainquery($conn,$stm);
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

    public function tablerow($conn){
        
        $stm ="select * from tblmasalar";
        $b=$this->mainquery($conn,$stm); 
        echo count($b->fetchAll(PDO::FETCH_ASSOC));

    }

    public function getTableName($conn,$p1){
        
        $get = "SELECT * from tblmasalar where id = ?";
        return $this->mainparam1($conn,$get,$p1);
    }

    public function getCategories($conn){
        
        $stmt = "SELECT * from tblcategory";
        $func = $this->mainquery($conn,$stmt);
        while($array = $func->fetch(PDO::FETCH_ASSOC)){
            echo '<a class="btn btn-info m-1 text-white" sectionId="'.$array["cat_id"].'">'.$array["cat_name"].'</a>';
        }
    }

}
    



?>

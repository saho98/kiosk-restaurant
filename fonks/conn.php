<?php
try{
    $conn = new PDO("mysql:host=localhost;dbname=db_restaurant","root","");
    $conn->query("set CHARSET UTF8");
}catch(PDOException $a){
    die("Bağlantı kurulamadı.".$a->getMessage());
}
class sistem{
    
    private function sorgu($con,$stmt){

        $b=$con->prepare($stmt);
        $b->execute();
        return $b;
    }
    
    public function catchmasa($conn){
        $stm ="select * from tblmasalar";
        $b=$this->sorgu($conn,$stm);
        while($da = $b->fetch(PDO::FETCH_ASSOC)){
            echo '<div class="col-md-2 col-sm-3 border ml-5  bg-danger text-center text-white" id="masalar">'.$da["tableName"].'</div>';
        }

    }


}



?>

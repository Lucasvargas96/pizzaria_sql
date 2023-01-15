<?php
include_once("conn.php");

$method= $_SERVER["REQUEST_METHOD"];


if($method === "GET"){
    $bordasQuery= $conn->query("SELECT * FROM bordas");
    $bordas = $bordasQuery->fetchAll();
    
    $massasQuery = $conn->query("SELECT * FROM massas;");
    $massas=$massasQuery->fetchAll();
    
    $saboresQuery =$conn->query("SELECT * FROM 
    sabores;");
    $sabores =$saboresQuery->fetchAll();
    
} else if($method === "POST") {
    $data =$_POST;
    $borda=$data["borda"];
    $massa=$data["massa"];
    $sabores=$data["sabores"];

    if(count($sabores) > 3) {
        $_SESSION["msg"]= "Selecione no máximo 3 sabores";
        $_SESSION["status"]="warning";

    } else{
        //validação para pedido com sucesso
        $_SESSION["msg"]= "Pedido realizado com sucesso";
        $_SESSION["status"]="success";
        //inserindo nas tabelas os dados que vieram do input
        $stmt = $conn->prepare("INSERT INTO pizzas (borda_id,massa_id) VALUES (:borda,:massa)");
        $stmt->bindParam(":borda",$borda,PDO::PARAM_INT);
        $stmt->bindParam(":massa",$massa,PDO::PARAM_INT);
        $stmt->execute();
        //inserindo nas tabeleas os dados com os dados dos sabores que vieram do input
        $pizzaId =$conn->lastInsertId();//esse metodo retorna o ultimo id,(isso vem do auto_increment)
        $stmt2=$conn->prepare("INSERT INTO pizza_sabor (pizza_id,sabor_id) VALUES (:pizza,:sabor)");

        foreach ($sabores as $sabor) {
            $stmt2->bindParam(":pizza",$pizzaId, PDO::PARAM_INT);
            $stmt2->bindParam(":sabor",$sabor,PDO::PARAM_INT);
            $stmt2->execute();
            
        }
        //criando o pedido da pizza
        $stmt3 =$conn->prepare("INSERT INTO pedidos (pizza_id,status_id) VALUES (:pizza,:status)");

        $statusId=1;

        $stmt3->bindParam(":pizza",$pizzaId);
        $stmt3->bindParam(":status",$statusId);

        $stmt3->execute();
    }
    header("Location:..");
}
    
?>
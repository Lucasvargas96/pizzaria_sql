<?php
include_once("conn.php");

$method= $_SERVER["REQUEST_METHOD"];

if($method === "GET") {
    $pedidosQuery = $conn->query ("SELECT * FROM pedidos;");

    $pedidos = $pedidosQuery->fetchAll();
    
    $pizzas =[];
   // Nesse foreach nós vamos montar essa pizza
    foreach ($pedidos as $pedido) {
        $pizza = [];
       //aqui pegamos da tabela pedidos, qual é o id da pizza que foi selecionada no pedido
        $pizza["id"] = $pedido["pizza_id"];
       //aqui estamos pegando o que vem na pizza que foi selecionada no pedido
        $pizzaQuery =$conn->prepare("SELECT * FROM pizzas WHERE id = :pizza_id");
        $pizzaQuery->bindParam(":pizza_id",$pizza["id"]);
        $pizzaQuery->execute();

        $pizzaData = $pizzaQuery->fetch(PDO::FETCH_ASSOC);
        
        //aqui estamos pegando um dos conteudos da pizza (borda)
        $bordaQuery =$conn->prepare("SELECT * FROM bordas WHERE id = :borda_id");
        $bordaQuery->bindParam(":borda_id",$pizzaData["borda_id"]);
        $bordaQuery->execute();

        $borda = $bordaQuery->fetch(PDO::FETCH_ASSOC);
        //aqui estamos pegando um coluna do banco, a coluna tipo.
        $pizza["borda"]= $borda["tipo"];

        //aqui estamos pegando mais dos conteudos da pizza (massa)
        $massaQuery =$conn->prepare("SELECT * FROM massas WHERE id = :massa_id");
        $massaQuery->bindParam(":massa_id",$pizzaData["massa_id"]);
        $massaQuery->execute();

        $massa = $massaQuery->fetch(PDO::FETCH_ASSOC);
        //aqui estamos pegando um coluna do banco, a coluna tipo.
        $pizza["massa"]= $massa["tipo"];

        //aqui estamos pegando os sabores
        $saboresQuery =$conn->prepare("SELECT * FROM pizza_sabor WHERE pizza_id = :pizza_id");
        $saboresQuery->bindParam(":pizza_id",$pizza["id"]);
        $saboresQuery->execute();

        $sabores = $saboresQuery->fetchAll(PDO::FETCH_ASSOC);
        

        $saboresdaPizza = [];
        
        $saborQuery = $conn->prepare("SELECT * FROM sabores WHERE id=:sabor_id");

        foreach ($sabores as $sabor) {

            $saborQuery->bindParam(":sabor_id",$sabor["sabor_id"]);
            $saborQuery->execute();
            $saborPizza= $saborQuery->fetch(PDO::FETCH_ASSOC);

            array_push($saboresdaPizza,$saborPizza["nome"]);
        }

        $pizza["sabores"]= $saboresdaPizza;

        $pizza['status'] =$pedido['status_id'];
        //aqui estou colocando o conteudo do array pizza no array pizzas
        array_push($pizzas,$pizza);
    }

    $statusQuery = $conn->query("SELECT * FROM status;");
    $status =$statusQuery->fetchAll();
    

}elseif ($method === "POST") {
    $type= $_POST["type"];
    
    if($type=== "delete"){
        $pizzaId = $_POST["id"];

        $deleteQuery=$conn->prepare("DELETE FROM pedidos WHERE pizza_id =:pizza_id");
        $deleteQuery->bindParam(":pizza_id",$pizzaId,PDO::PARAM_INT);
        $deleteQuery->execute();

        $_SESSION["msg"] ="Pedido removido com sucesso";
        $_SESSION["status"]="success";
        
    }else if($type === "update"){
        $pizzaId= $_POST["id"];
        $statusId= $_POST["status"];
        $updateQuery= $conn->prepare("UPDATE pedidos SET status_id = :status_id WHERE pizza_id =:pizza_id");
        $updateQuery->bindParam(":pizza_id",$pizzaId,PDO::PARAM_INT);
        $updateQuery->bindParam(":status_id",$statusId,PDO::PARAM_INT);
        $updateQuery->execute();
        
        $_SESSION["msg"] ="Pedido atualizado com sucesso";
        $_SESSION["status"]="success";
    };
    header("Location:../dashboard.php");
}

?>
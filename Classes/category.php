<?php
$pdo = new PDO ("mysql:host=localhost;dbname=webshop", "root", "");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category= ["Smartphone","Keyboards","Headphones","Gaming"];
    foreach($category as $cat){
       $check=$pdo->prepare("SELECT * FROM categories WHERE name=?");
         $check->execute([$cat]);
        if($check->rowCount() == 0){
            $insert = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
            $insert->execute([$cat]);
            echo "Toegevoegd: $cat <br>";
        }else{
            echo "Bestaat al: $cat <br>";
        }
    }

    if ($stmt->execute()) {
        echo "Category added successfully.";
    } else {
        echo "Error adding category.";
    }

?>
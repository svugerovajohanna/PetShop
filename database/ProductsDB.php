<?php require_once __DIR__.'/Database.php'; 

class ProductsDB extends Database {

    protected $tableName = 'products';
    public function fetchAll() {
        $sql = 'SELECT * FROM ' . $this->tableName;
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
 
    public function create($args){
        $sql = 'INSERT INTO ' . $this->tableName . 
            '(product_name, price, image, description, category, stock)
            VALUES (:product_name, :price, :image, :description, :category, :stock)';
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'product_name' => $args['product_name'], 
            'price' => $args['price'],
            'image' => $args['image'],
            'description' => $args['description'],
            'category' => $args['category'],
            'stock' => $args['stock']
        ]);
    }
}
?>
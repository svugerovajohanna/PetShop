<?php require_once __DIR__.'/Database.php'; ?>

<?php
class ItemsDB extends Database {

    protected $tableName = 'items';
    public function fetchAll() {
        $sql = 'SELECT * FROM ' . $this->tableName;
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
 
    public function create($args){
        $sql = 'INSERT INTO ' . $this->tableName . 
            '(product, unit_price, order_code)
            VALUES (:product, :unit_price, :order_code)';
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'product' => $args['product'],
            'unit_price' => $args['unit_price'],
            'order_code' => $args['order_code']
        ]);
    }
}
?>
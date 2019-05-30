<?php require_once __DIR__.'/Database.php'; ?>

<?php



class OrdersDB extends Database {


    protected $tableName = 'orders';
    public function fetchAll() {
        $sql = 'SELECT * FROM ' . $this->tableName;
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
 
    public function create($args){
        $sql = 'INSERT INTO ' . $this->tableName . 
            '(user_id, order_date, shipping, payment)
            VALUES (:user_id, :order_date, :shipping, :payment)';
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'user_id' => $args['user_id'],
            'order_date' => $args['order_date'],
            'shipping' => $args['shipping'],
            'payment'=> $args['payment'],
 
           
        ]);
    }
}
?>
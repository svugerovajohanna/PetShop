<?php require_once __DIR__.'/Database.php'; 

class UsersDB extends Database {

    protected $tableName = 'users';
    public function fetchAll() {
        $sql = 'SELECT * FROM ' . $this->tableName;
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
 
    public function create($args){
        $sql = 'INSERT INTO ' . $this->tableName . 
            '(first_name, last_name, password, phone_number, email, street, house_number, city, post_code)
            VALUES (:first_name, :last_name, :password, :phone_number, :email, :street, :house_number, :city, :post_code )';
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'first_name' => $args['first_name'], 
            'last_name' => $args['last_name'],
            'password' => $args['password'],
            'phone_number' => $args['phone_number'],
            'email' => $args['email'],
            'street' => $args['street'],
            'house_number' => $args['house_number'],
            'city' => $args['city'],
            'post_code' => $args['post_code']
        ]);
    }
}
?>
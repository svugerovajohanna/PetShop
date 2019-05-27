<?php require_once __DIR__.'/Database.php'; 

class CategoriesDB extends Database {

    protected $tableName = 'categories';
    public function fetchAll() {
        $sql = 'SELECT * FROM ' . $this->tableName;
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
 
    public function create($args){
        $sql = 'INSERT INTO ' . $this->tableName . 
            '(name, animal)
            VALUES (:name, :animal)';
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'name' => $args['name'], 
            'animal' => $args['animal']
        ]);
    }
}
?>
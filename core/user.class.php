<?php

/**
 * Class user
 */
class User
{
    /**
     * @var
     */
    private $pdo;

    /**
     * @param $pdo
     */
    public function __construct($pdo)
    {
        if (is_object($pdo)) {
            $this->pdo = $pdo;
        }
    }

    /**
     * @return bool
     */
    public function getUserData()
    {
        $data = ['login' => $_SESSION['login'], 'id' => $_SESSION['id']];
        $data = array_map('strip_tags', $data);

        if (empty($data['login']) || empty($data['id'])) {
            return false;
        } else {
            $stmt = $this->pdo->prepare('SELECT ip, user_agent, date FROM users WHERE id = :id AND login = :login');
            $stmt->bindParam(':login', $data['login'], PDO::PARAM_STR);
            $stmt->bindParam(':id', $data['id'], PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
}

?>
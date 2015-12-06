<?php

/**
 * Class auth
 */
class Auth
{
    /**
     * @var null
     */
    private $pdo = null;

    /**
     * @var null
     */
    private $session = null;

    /**
     * @var array
     */
    private $info = [];

    /**
     * @param $pdo
     * @param $session
     */
    public function __construct($pdo, $session)
    {
        if (is_object($pdo)) {
            $this->pdo = $pdo;
        }

        if (is_object($session)) {
            $this->session = $session;
        }

        $langPath = 'text/auth.lang.php';

        if (file_exists($langPath)) {
            $lang = [];
            require_once $langPath;
            $this->info = $lang['auth'];
        }
    }

    /**
     * @param $data
     * @return array|bool
     */
    public function login($data)
    {
        if (!is_array($data)) {
            return false;
        } elseif (!array_key_exists('login', $data) || !array_key_exists('password', $data)) {
            return false;
        } else {
            $data = array_map('strip_tags', $data);

            if (empty($data['login']) || empty($data['password'])) {
                $return = $this->info[0];
            } else {
                $data['password'] = hash('sha512', $data['password']);

                $stmt = $this->pdo->prepare('SELECT count(id) as number, id FROM users WHERE login = :login AND password = :password');
                $stmt->bindParam(':login', $data['login'], PDO::PARAM_STR);
                $stmt->bindParam(':password', $data['password'], PDO::PARAM_STR);
                $stmt->execute();

                $result = $stmt->fetch();

                if ($result['number'] == 1) {
                    $this->session->set(['login' => $data['login'], 'id' => $result['id']], true);
                    $return = [0 => $this->info[1], 1 => true];
                } else {
                    $return = $this->info[2];
                }
            }
        }
        return $return;
    }

    /**
     * @param $data
     * @return array|bool
     */
    public function register($data)
    {
        if (!is_array($data)) {
            return false;
        } elseif (!array_key_exists('login', $data) || !array_key_exists('password', $data) || !array_key_exists('email', $data)) {
            return false;
        } else {
            $data = array_map('strip_tags', $data);
            $data = array_map('trim', $data);

            if (empty($data['login']) || empty($data['password']) || empty($data['email'])) {
                $return = $this->info[0];
            } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $return = $this->info[3];
            } else if ($this->UserExists($data['login'])) {
                $return = $this->info[4];
            } else if ($this->EmailExists($data['email'])) {
                $return = $this->info[5];
            } else {
                $data['password'] = hash('sha512', $data['password']);

                $additional = ['IP' => $_SERVER['REMOTE_ADDR'], 'user_agent' => $_SERVER['HTTP_USER_AGENT']];
                $additional = array_map('strip_tags', $additional);
                $additional = array_map('trim', $additional);

                $stmt = $this->pdo->prepare('INSERT INTO users VALUES ("", :login, :password, :email, "' . $additional['IP'] . '", "' . $additional['user_agent'] . '", now())');
                $stmt->bindParam(':login', $data['login'], PDO::PARAM_STR);
                $stmt->bindParam(':password', $data['password'], PDO::PARAM_STR);
                $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    $return = [0 => $this->info[6], 1 => true];
                } else {
                    $return = $this->info[7];
                }
            }
            return $return;
        }
    }

    /**
     * @param $login
     * @return bool
     */
    private function UserExists($login)
    {
        $stmt = $this->pdo->prepare('SELECT count(id) as number FROM users WHERE login = :login LIMIT 1');
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch();

        return ($result['number'] == 1) ? true : false;
    }

    /**
     * @param $email
     * @return bool
     */
    private function EmailExists($email)
    {
        $stmt = $this->pdo->prepare('SELECT count(id) as number FROM users WHERE email = :email LIMIT 1');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch();

        return ($result['number'] == 1) ? true : false;
    }

    /**
     * @return null
     */
    public function logout()
    {
        session_destroy();
        header('Location: index.php');
        return null;
    }
}

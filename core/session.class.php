<?php

/**
 *
 * @author Dominik Ryńko
 * @contact: http://www.rynko.pl/
 * @version 1.0.0
 * @license http://creativecommons.org/licenses/by-sa/3.0/pl/
 */
class Session
{
    /**
     * @param none
     * @return string || bool
     */
    public function getSessionId()
    {
        if (session_id()) {
            return session_id();
        } else {
            return false;
        }
    }

    /**
     * @param bool $type
     * @return bool
     */
    public function regenerateId($type = true)
    {
        if ($type === true) {
            return session_regenerate_id(true);
        } else {
            return session_regenerate_id();
        }
    }

    /**
     * @param string $key
     * @param bool $multi
     * @return string || array
     */
    public function readSession($key, $multi = false)
    {
        if ($multi === false) {
            return $_SESSION[$key];
        } else {
            return $_SESSION;
        }
    }

    /**
     * @param array $data
     * @param bool $multi
     * @return string || array
     */
    public function set($data = [], $multi = false)
    {
        if ($multi === false) {
            if (version_compare(PHP_VERSION, '5.4.0') <= 0) {
                $keys = array_keys($data);
                $values = array_values($data);

                $_SESSION[$keys[0]] = $values[0];
            } else {
                $_SESSION[array_keys($data)[0]] = array_values($data)[0];
            }
        } else {
            foreach ($data as $key => $value) {
                $_SESSION[$key] = $value;
            }
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function exists($name)
    {
        if (empty($name)) {
            return null;
        } else {
            return array_key_exists($name, $_SESSION) ? true : false;
        }
    }

    /**
     * @param bool $type
     */
    public function remove($type = false)
    {
        if ($type === false) {
            session_destroy();
        } else {
            session_unset();
        }
    }

    /**
     * @param string $key
     * @return bool
     */
    public function removeOne($key)
    {
        if (empty($key)) {
            return null;
        }

        $variable = $_SESSION[$key];

        if (isset($variable)) {
            // Destroy variable
            unset($variable);
        }

        if (empty($variable)) {
            return true;
        } else {
            return false;
        }
    }
}


<?php
class DatabasePDO
{

    public $build_time;
    private static $pdo_instance = null;
    private $link;

    public function __construct()
    {

        $this->link = $this->getPDOInstance();
        $this->build_time = date('Y-m-d H:i:s');

    }// end function __construct

    public function insert($sql, $param = array())
    {

        $statement = $this->link->prepare($sql);
        $query_result = $statement->execute($param);

        if (!$query_result) {

            echo '<h2>'.get_class($this).'</h2>';
            echo '<pre>';
            var_dump($this->link->errorInfo());
            echo '</pre>';
            exit;

        }// end if (!$query_result)

        return $this->link->lastInsertId();

    }// end function insert

    public function select($sql, $param = array())
    {

        $statement = $this->link->prepare($sql);
        $query_result = $statement->execute($param);

        if (!$query_result) {

            echo '<h2>'.get_class($this).'</h2>';
            echo '<pre>';
            var_dump($this->link->errorInfo());
            echo '</pre>';
            exit;

        }// end if (!$query_result)

        return $statement->fetchAll();

    }// end function select

    public function update($sql, $param = array())
    {

        $statement = $this->link->prepare($sql);
        $query_result = $statement->execute($param);

        if (!$query_result) {

            echo '<h2>'.get_class($this).'</h2>';
            echo '<pre>';
            var_dump($this->link->errorInfo());
            echo '</pre>';
            exit;

        }// end if (!$query_result)

        return $statement->rowCount();

    }// end function update

    public function delete($sql, $param=array())
    {

        $statement = $this->link->prepare($sql);
        $query_result = $statement->execute($param);

        if (!$query_result) {

            echo '<h2>'.get_class($this).'</h2>';
            echo '<pre>';
            var_dump($this->link->errorInfo());
            echo '</pre>';
            exit;

        }// end if (!$query_result)

        return $statement->rowCount();

    }// end function delete

    private function getPDOInstance()
    {

        if (is_null(self::$pdo_instance)) {

            try {

                include DB_CONFIG_FILE;

                self::$pdo_instance = new PDO(
                    'mysql:dbname='.$database_name.';host='.$database_host,
                    $database_user,
                    $database_password
                );

                self::$pdo_instance->query("SET time_zone='+8:00'");
                self::$pdo_instance->query("SET NAMES UTF8");

                self::$pdo_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                self::$pdo_instance->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                self::$pdo_instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {

                echo $e->getMessage();

            }

        }

        return self::$pdo_instance;

    }

}// end class DatabasePDO
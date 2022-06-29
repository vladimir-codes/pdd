<?php

 class DataBase
 {
    private $connection_string = "";
    public function __construct()
    {
        $this->connection_string = mysqli_connect('localhost', 'root', 'newpassword', 'pdd');
        if (mysqli_connect_errno()) {
            printf("Не удалось подключиться: %s\n", mysqli_connect_error());
        }
    }
    public function Query(string $QueryText)
    {
        $result = mysqli_query($this->connection_string, $QueryText);
        if (!$result) {
            $message  = 'Неверный запрос: ' . mysqli_error($this->connection_string) . "\n";
            $message .= 'Запрос целиком: ' . $QueryText;
            die($message);
        } else return $result;
    }
    public function FetchQuery(string $QueryText)
    {
        $result = mysqli_query($this->connection_string, $QueryText);
        if (!$result) {
            $message  = 'Неверный запрос: ' . mysqli_error($this->connection_string) . "\n";
            $message .= 'Запрос целиком: ' . $QueryText;
            die($message);
        } else return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    public function CloseConnection()
    {
        if (mysqli_connect()) mysqli_close($this->connection_string);
    }
 }
 
?>
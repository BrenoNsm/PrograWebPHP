<?php
Class Banco{
    private static $dbNome = "dbaula";
    private static $dbHost = "localhost";
    private static $dbUsuario="root";
    private static $dbSenha = "sva337rro";
    
    private static $cont = null;
    
    public function __construct() {
        die("A função init não é permitida");
    }
    
    public static function connectar() {
        if(null == self::$cont){
            try {
                self::$cont = new PDO("mysql:host=".self::$dbHost.";"."dbname=".self::$dbNome, self::$dbUsuario, self::$dbSenha);    
            } catch (Exception $ex) {
                die($ex->getMessage());
            }
        }
        return self::$cont;
    }
    
    public static function desconectar() {
        self::$cont = null;
    }
    
}

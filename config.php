<?php
$server = 'localhost';
$database = 'jequiti';
$uid = 'root';
$password = '';

header("Content-Type: text/html; charset=utf8");

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('SERVER', "mysql:host=$server;dbname=$database;charset=utf8");
define('UID', $uid);
define('PASSWORD', $password);

class Util
{
  static function Money($string)
  {
    $string = floatval($string);
    return number_format($string, 2, ',', '.');
  }

  static function Error($string)
  {
    echo "<script>alert(`$string`)</script>";
  }
}

class Connection
{
  static function Connect()
  {
    return new PDO(SERVER, UID, PASSWORD);
  }

  public static function Query($sql)
  {
    try {
      $sql = self::Connect()->prepare($sql);
      $sql->execute();

      return true;
    } catch (PDOException $e) {
      Util::Error($e->getMessage());
    }
  }

  public static function QueryAll($sql)
  {
    try {
      $sql = self::Connect()->prepare($sql);
      $sql->execute();

      return $sql->fetchAll(PDO::FETCH_CLASS);
    } catch (PDOException $e) {
      Util::Error($e->getMessage());
    }
  }

  public static function QueryObject($sql)
  {
    try {
      $sql = self::Connect()->prepare($sql);
      $sql->execute();

      return $sql->fetchObject();
    } catch (PDOException $e) {
      Util::Error($e->getMessage());
    }
  }

  function __construct()
  {
    $action = $_REQUEST['action'] ?? null;

    switch ($action) {
      case 'create':
        $tipo = $_REQUEST['tipo'];
        $codigo_barra = $_REQUEST['codigo'];
        $nome = $_REQUEST['nome'];
        $quantidade_estoque = $_REQUEST['quantidade'];
        $preco_compra = $_REQUEST['compra'] ?? 0;
        $preco_venda = $_REQUEST['venda'] ?? 0;
        $volume = $_REQUEST['volume'];
        $unidade_medida = $_REQUEST['medida'];
        $categoria_id = $_REQUEST['categoria'];
        $fornecedor_id = $_REQUEST['fornecedor'];
        switch ($tipo) {
          case 'compra':
            break;
          case 'venda':
            break;
          default:
            return;
            break;
        }
        self::Query("insert into produto (codigo_barra, nome, quantidade_estoque, preco_compra, preco_venda, volume, unidade_medida, categoria_id, fornecedor_id) values ('$codigo_barra', '$nome', '$quantidade_estoque', '$preco_compra', '$preco_venda', '$volume', '$unidade_medida', '$categoria_id', '$fornecedor_id')");
    }
  }
}

new Connection();

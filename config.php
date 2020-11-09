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
      var_dump($sql->errorInfo()[0]);
      if ($sql->errorInfo()[0] !== '00000') throw new PDOException($sql->errorInfo()[2]);

      return true;
    } catch (PDOException $e) {
      Util::Error($e->getMessage());
      return false;
    }
  }

  public static function QueryAll($sql)
  {
    try {
      $sql = self::Connect()->prepare($sql);
      $sql->execute();
      if ($sql->errorInfo()[0] !== '00000') throw new PDOException($sql->errorInfo()[2]);

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
      if ($sql->errorInfo()[0] !== '00000') throw new PDOException($sql->errorInfo()[2]);

      return $sql->fetchObject();
    } catch (PDOException $e) {
      Util::Error($e->getMessage());
    }
  }

  function __construct()
  {
    if (PAGE !== 'login' && PAGE !== 'cadastro' && PAGE !== 'search') self::Auth();

    $action = $_REQUEST['action'] ?? null;
    $class = $_REQUEST['class'] ?? null;

    switch ($action) {
      case 'create':
        if ($class === 'categoria') self::CategoriaCreate();
        if ($class === 'fornecedor') self::FornecedorCreate();
        if ($class === 'produto') self::ProdutoCreate();
        if ($class === 'transacao') self::TransacaoCreate();
        break;
      case 'delete':
        if ($class === 'categoria') self::CategoriaDelete();
        if ($class === 'fornecedor') self::FornecedorDelete();
        if ($class === 'produto') self::ProdutoDelete();
        if ($class === 'transacao') self::TransacaoDelete();
        break;
      case 'search':
        self::Search();
        break;
      case 'login':
        self::Login();
        break;
      case 'logout':
        self::Logout();
        break;
      case 'register':
        self::Register();
        break;
    }
  }

  static function Auth()
  {
    if ($_SESSION['usuario'] === null) {
      header('location: ./login');
      exit;
    }
  }

  static function Login()
  {
    $email = $_REQUEST['email'];
    $senha = sha1($_REQUEST['senha']);

    $res = self::QueryObject("select * from usuario where email = '$email' and senha = '$senha'");

    if ($res) {
      $_SESSION['usuario'] = $res;
      header("location: produtos.php");
    } else Util::Error('Usuário ou senha incorretos');
  }

  static function Register()
  {
    $nome = $_REQUEST['nome'];
    $email = $_REQUEST['email'];
    $senha = sha1($_REQUEST['senha']);

    $res = self::Query("insert into usuario (nome, email, senha) values ('$nome', '$email', '$senha')");

    if ($res === true) {
      header("location: login.php");
      Util::Error('Usuário criado');
    } else Util::Error('Usuário não criado');
  }

  static function Logout()
  {
    $_SESSION['usuario'] = null;
  }

  static function CategoriaCreate()
  {
    $nome = $_REQUEST['nome'];

    self::Query("insert into categoria (nome) values ('$nome')");
  }

  static function CategoriaDelete()
  {
    $id = $_REQUEST['id'];

    self::Query("delete from categoria where id = '$id'");
  }

  static function FornecedorCreate()
  {
    $cnpj = $_REQUEST['cnpj'];
    $razao_social = $_REQUEST['razao_social'];
    $nome_fantasia = $_REQUEST['nome_fantasia'];

    self::Query("insert into fornecedor (cnpj, razao_social, nome_fantasia) values ('$cnpj', '$razao_social', '$nome_fantasia')");
  }

  static function FornecedorDelete()
  {
    $id = $_REQUEST['id'];

    self::Query("delete from fornecedor where id = '$id'");
  }

  static function ProdutoCreate()
  {
    $codigo_barra = $_REQUEST['codigo'];
    $nome = $_REQUEST['nome'];
    $volume = $_REQUEST['volume'];
    $unidade_medida = $_REQUEST['medida'];
    $categoria_id = $_REQUEST['categoria'];
    $fornecedor_id = $_REQUEST['fornecedor'];

    self::Query("insert into produto (codigo_barra, nome, volume, unidade_medida, categoria_id, fornecedor_id) values ('$codigo_barra', '$nome', '$volume', '$unidade_medida', '$categoria_id', '$fornecedor_id')");
  }

  static function ProdutoDelete()
  {
    $id = $_REQUEST['id'];

    self::Query("delete from produto where id = '$id'");
  }

  static function TransacaoCreate()
  {
    $tipo = $_REQUEST['tipo'];
    $data = $_REQUEST['data'];
    $quantidade = $_REQUEST['quantidade'];
    $preco = $_REQUEST['preco'];
    $produto_id = $_REQUEST['produto_id'];
    $usuario_id = $_SESSION['usuario']->id;

    self::Query("insert into transacao (tipo, data, quantidade, preco, produto_id, usuario_id) values ('$tipo', '$data', '$quantidade', '$preco', '$produto_id', '$usuario_id')");
  }

  static function TransacaoDelete()
  {
    $id = $_REQUEST['id'];

    self::Query("delete from transacao where id = '$id'");
  }

  static function Search()
  {
    header("content-type: application/json");

    $codigo_barra = $_REQUEST['codigo'] ?? null;

    if ($codigo_barra === null) {
      echo json_encode(false);
      exit;
    }

    $res = self::QueryObject("select * from ver_produto where codigo_barra = '$codigo_barra'");
    echo json_encode($res);
  }
}

new Connection();

<?php   

 /*   
 * Constantes de parâmetros para configuração da conexão
 define('DBNAME', 'fpf_store');
  define('DBNAME', 'id19373281_fpf_store'); 
   define('PASSWORD', '*g=!}7_#5^|lX\vg'); 
 define('PASSWORD', ''); 
 */   
 define('HOST', 'LOCALHOST');   
 define('DBNAME', 'fpf_store');     
 define('USER', 'root');   
 define('PASSWORD', '');   


 class Conexao {  

  /*   
  * Atributo estático para instância do PDO   
  */   
  private static $pdo;  

  /*   
  * Escondendo o construtor da classe   
  */   
  private function __construct() {   
   //   
  }  

  /*   
  * Método estático para retornar uma conexão válida   
  * Verifica se já existe uma instância da conexão, caso não, configura uma nova conexão   
  */   
  public static function getInstance() {   
   if (!isset(self::$pdo)) {   
    try {    
     self::$pdo = new PDO("mysql:host=" . HOST . "; dbname=" . DBNAME . ";", USER, PASSWORD);
     self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
    } catch (PDOException $e) {   
     print "Erro: " . $e->getMessage();   
    }   
   }   
   return self::$pdo;   
  }   
 }  
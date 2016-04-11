  <?php
  header("Access-Control-Allow-Origin: *");

  $valid_ip="127.0.0.1"; //Cambiare questo parametro con l'IP del client

  if(!is_null($_SERVER['HTTP_X_FORWARDED_FOR']) || $_SERVER['REMOTE_ADDR']!=$valid_ip){
    http_response_code (400);
    echo "Errore il tuo ip e' ".$_SERVER['REMOTE_ADDR']."!";
    exit();
  }

  if (isset($_POST["stato"]) && !empty($_POST["stato"])) {
    $stato = $_POST["stato"];
  }else{
    http_response_code (400);
    echo "Errore stato non impostato!";
    exit();
  }

  if (isset($_POST["key"]) && !empty($_POST["key"])) {
    $key = $_POST["key"];
  }else{
    http_response_code (400);
    echo "Errore password non impostata!";
    exit();
  }

  if (isset($_POST["nome"]) && !empty($_POST["nome"])) {
    $nome = $_POST["nome"];
  }else{
    http_response_code (400);
    echo "Errore nome non impostato!";
    exit();
  }

  /*Password per l'autenticazione del client*/
  $keyCorretta['Campus'] = "";
  $keyCorretta['Arata'] = "";

  if($key!=$keyCorretta[$nome]){
    http_response_code (401);
   echo "Errore Password non valida!";
   exit();
 }

 if(strlen($stato)>100){
  http_response_code (400);
   echo "Errore Stringa troppo lunga!";
   exit();
 }

 if (!preg_match("/^[01]*$/", $stato)) {
  http_response_code (400);
  echo "Errore Stringa non valida!";
  exit();
}

$myfile = fopen("stato".$nome.".txt", "w") or die("Errore Impossibile aprire il file!");
fwrite($myfile, $stato);
fclose($myfile);
echo "ok";

?>

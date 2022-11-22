<?php
/***VALIDAÇÃO DOS DADOS RECEBIDOS DO FORMULÁRIO ***/
if($_REQUEST['nome_cad'] == ""){
echo "O campo Nome não pode ficar vazio.";
exit;
}
if(strlen($_REQUEST['cpf_cad']) != 11){
echo "O campo CPF precisa ter 11 caracteres.";
exit;
}
if(!stripos($_REQUEST['email_cad'], "@") || !stripos($_REQUEST['email_cad'], ".")){
echo "O campo E-mail não é válido.";
exit;
}
if($_REQUEST['data_nasc'] == ""){
echo "O campo Data de Nascimento não pode ficar vazio.";
exit;
}
if($_REQUEST['senha_cad'])!= 6){
    echo "O campo senha não pode ficar vazio.";
    exit;
    }


/***FIM DA VALIDAÇÃO DOS DADOS RECEBIDOS DO FORMULÁRIO ***/

/***CONEXÃO COM O BD ***/
//Constantes para armazenamento das variáveis de conexão.
define('HOST', '192.168.52.128');
define('PORT', '5432');
define('DBNAME', 'minimundo');
define('USER', 'postgres');
define('PASSWORD', '159753');
try {
$dsn = new PDO("pgsql:host=". HOST . ";port=".PORT.";dbname=" . DBNAME . ";user=" . USER . ";password=" . PASSWORD);
} catch (PDOException $e) {
echo 'A conexão falhou e retorno a seguinte mensagem de erro: ' . $e->getMessage();
}
/*** FIM DOS CÓDIGOS DE CONEXÃO COM O BD ***/

/***PREPARAÇÃO E INSERÇÃO NO BANCO DE DADOS ***/
$instrucaoSQL = "Select id_cliente, nome_cliente, cpf_cliente, email_cliente, data_nascimento_cliente From cliente";
$resultSet = $dsn->query($instrucaoSQL);

$stmt = $dsn->prepare("INSERT INTO cliente(nome_cad, cpf_cad, email_cad, data_nasc) VALUES (?, ?, ?, ?) ");
$resultSet = $stmt->execute([$_REQUEST['nome_cliente'],
$_REQUEST['cpf_cliente'], $_REQUEST['email_cliente'],
$_REQUEST['data_nascimento_cliente']]);
if($resultSet){
echo "Os dados foram inseridos com sucesso.";
}else{
echo "Ocorreu um erro e não foi possível inserir os dados.";
}
//Destruindo o objecto statement e fechando a conexão
$stmt = null;
$dsn = null;
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <title>Erdnaxela Informática</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>  
/* Remove the navbar's default rounded borders and increase the bottom margin */ 
.navbar {
  margin-bottom: 50px;
  border-radius: 0;
}

/* Remove the jumbotron's default bottom margin */ 
 .jumbotron {
    background-color: black;
    color: rgb(254, 255, 255);
    margin-bottom: 0;
}

/* Add a gray background color and some padding to the footer */
footer {
  background-color: #f2f2f2;
  padding: 25px;
}

.content{
  width: 500px;
  min-height: 300px;    
  margin: 0px auto;
  position: relative;   
}

h1:after{
  content: ' ';
  display: block;
  width: 100%;
  height: 2px;
  margin-top: 10px;
  background: -webkit-linear-gradient(left, rgba(147,184,189,0) 0%,rgba(147,184,189,0.8) 20%,rgba(147,184,189,1) 53%,rgba(147,184,189,0.8) 79%,rgba(147,184,189,0) 100%); 
  background: linear-gradient(left, rgba(147,184,189,0) 0%,rgba(147,184,189,0.8) 20%,rgba(147,184,189,1) 53%,rgba(147,184,189,0.8) 79%,rgba(147,184,189,0) 100%); 
}
p{
  margin-bottom:15px;
}
 
.content p:first-child{
  margin: 0px;
}
 
label{
  color: #405c60;
  position: relative;
}
/* placeholder */
::-webkit-input-placeholder  {
  color: #bebcbc; 
  font-style: italic;
}
 
input:-moz-placeholder,
textarea:-moz-placeholder{
  color: #bebcbc;
  font-style: italic;
}

input {
  outline: none;
}
 
/*estilo dos input,  menos o checkbox */
input:not([type="checkbox"]){
  width: 95%;
  margin-top: 4px;
  padding: 10px;    
  border: 1px solid #b2b2b2;
 
  -webkit-border-radius: 3px;
  border-radius: 3px;
 
  -webkit-box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
  box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
 
  -webkit-transition: all 0.2s linear;
  transition: all 0.2s linear;
}
 
/*estilo do botão submit */
input[type="submit"]{
  width: 100%!important;
  cursor: pointer;  
  background: rgb(61, 157, 179);
  padding: 8px 5px;
  color: #fff;
  font-size: 20px;  
  border: 1px solid #fff;   
  margin-bottom: 10px;  
  text-shadow: 0 1px 1px #333;
 
  -webkit-border-radius: 5px;
  border-radius: 5px;
 
  transition: all 0.2s linear;
}
 
/*estilo do botão submit no hover */
input[type="submit"]:hover{
  background: #4ab3c6;
}

/* Efeito ao clicar no botão ( Ir para Login ) */
#paracadastro:target ~ .content #cadastro,
#paralogin:target ~ .content #login{
  z-index: 2;
  -webkit-animation-name: fadeInLeft;
  animation-name: fadeInLeft;
 
  -webkit-animation-delay: .1s;
  animation-delay: .1s;
}
 
/* Efeito ao clicar no botão ( Cadastre-se ) */
#registro:target ~ .content #login,
#paralogin:target ~ .content #cadastro{
  -webkit-animation-name: fadeOutLeft;
  animation-name: fadeOutLeft;
}
</style>
</head>
<body>

<div class="jumbotron">
  <div class="container text-center">
    <h1><img src="Imagens\Erdnaxela logo.png" alt="Logotipo Erdnaxela"></h1>    
    <p>Soluções em Informática</p>
  </div>
</div>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.html">Home</a></li>
        <li><a href="servicos.html">Serviços</a></li>
        <li><a href="stories.html">Stories</a></li>
        <li><a href="contatos.html">Contatos</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="entrar.html"><span class="glyphicon glyphicon-user"></span> Sua conta</a></li>
        <li><a href="#"><span class="glyphicon glyphicon-shopping-cart"></span> Carrinho</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container" >
  <a class="links" id="paracadastro"></a>
  <a class="links" id="paralogin"></a>
   
  <div class="container" >
    <a class="links" id="paracadastro"></a>
    <a class="links" id="paralogin"></a>
     
      <!--FORMULÁRIO DE CADASTRO-->
      <center><div id="cadastro">
        <form method="post" action=""> 
          <h1>Cadastro</h1>           
          <p> 
            <label for="nome_cad">Seu nome</label>
            <input id="nome_cad" name="nome_cad" required="required" type="text" placeholder="nome" />
          </p>
          <p> 
            <label for="email_cad">Seu E-mail</label>
            <input id="email_cad" name="email_cad" required="required" type="email" placeholder="contato@htmlecsspro.com"/> 
          </p>
          <p> 
            <label for="cpf_cad">Seu CPF</label>
            <input id="cpf_cad" name="cpf_cad" required="required" type="cpf" placeholder="111.222.3333-00"/> 
          </p>
          <p> 
            <label for="data_nasc">Sua data nascimento</label>
            <input id="data_nasc" name="data_nasc" required="required" type="data_nasc" placeholder="11/04/1993"/> 
          </p>           
          <p> 
            <label for="senha_cad">Sua senha</label>
            <input id="senha_cad" name="senha_cad" required="required" type="password" placeholder="ex. 1234"/>
          </p>           
          <p> 
            <input type="submit" value="Cadastrar" onclick="Evento()"/>
            <script>
                function Evento(){
                    alert('Usuário cadastrado')
                }
            </script>
          </p>           
          <p class="link">  
            Já tem conta?
            <a href="entrar.html"> Ir para Login </a>
          </p>
        </form>
      </div>
    </div>

    

  </div></center>  
      <footer class="container-fluid text-center">
        <p>Loja Online Erdnaxela</p>  
        <form class="form-inline">Nossas ofertas:
          <input type="email" class="form-control" size="50" placeholder="Endereço E-mail">
          <button type="button" class="btn btn-danger" onclick="Evento()">Inscrever</button>      
          <script>
              function Evento(){
                  alert('E-mail cadastrado')
              }
          </script>
        </form>
      </footer>  
  </body>
  </html>


<?php
    require_once 'Database.php';
	require_once 'usuarios.php';
    $u = new Usuario;
?>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
	<title>Login</title>
	<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<div id="corpo-form-cad">
    <h1>Cadastrar</h1>
	<form method="POST">
		<label><input class="fields" type="text" name="nome" placeholder="Nome Completo" maxlength="30"></label>
        <label><input class="fields" type="text" name="telefone" placeholder="Telefone" maxlength="30"></label>
        <label><input class="fields" type="email" name="email" placeholder="e-mail" maxlength="40"></label>
		<label><input class="fields" type="password" name="senha" placeholder="Senha" maxlength="15"></label>
        <label><input class="fields" type="password" name="confSenha" placeholder="Confirmar Senha" maxlength="15"></label>
		<label><input class="fields" type="submit" value="Cadastrar"></label>
    </form>
</div>
<?php
//Verificar se o usuÃ¡rio clicou no botÃ£o
if (isset($_POST['nome']))
{
    $nome = addslashes($_POST['nome']);
    $telefone = addslashes($_POST['telefone']);
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);
    $confirmarSenha = addslashes($_POST ['confSenha']);
    //Verificar se estÃ¡ preenchido
    if(!empty($nome) && !empty($telefone) && !empty($email)  && !empty($senha)  && !empty($confirmarSenha))
    {
          $u->conectar("db_exemplo", "localhost", "root", "");
          if($u->msgErro == "")//Se esta tudo Ok
          {
              if ($senha == $confirmarSenha)
              {
                  if ($u->cadastrar($nome,$telefone,$email,$senha))
                  {
                    echo "Cadastrado com Sucesso! Acesse para entrar!";
                  }
                  else
                  {
                    echo "Email jÃ¡ cadastrado...!";
                  }
              }
          else
          {
            echo "Senha e confirmar senha nÃ£o correspondem...!!!";
          }
          }
    else
    {
      echo "Erro: ".$u->msgErro;
    }
    }
    else
    {
      echo "Preencha todos os Campos...!";
    }
}
?>
</body>
</html>
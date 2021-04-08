<?php /** @noinspection ALL */

Class Usuario
{
    private $pdo;
    public $msgErro= " ";
    public function conectar($nome, $host, $usuario, $senha)
    {
        global $pdo;
        global $msgErro;
        try
        {
            $pdo = new PDO("mysql: dbname=".$nome.";host=".$host, $usuario, $senha);
        }
        catch (PDOException $e)
        {
            $msgErro= $e->getMessage();
        }
    }

    public function cadastrar($nome, $telefone, $email, $senha)
    {
        global $pdo;
        global $msgErro;
        //Verificar se já existe o e-mail cadastrado
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email =:e");
        $sql->bindValue(":e",$email);
        $sql->execute();
        if($sql->rowCount() > 0)
        {
            return false; // Já está cadastrada...
        }
        else
        {
            //Caso não exista
            $sql = $pdo->prepare("INSERT INTO ususarios (nome, telefone, email, senha) VALUES (:n, :t, :e, :s)");
            $sql->bindValue(":n",$nome);
            $sql->bindValue(":t",$telefone);
            $sql->bindValue(":e",$email);
            $sql->bindValue(":s",$senha);
            $sql->execute();
            return true;
        }
    }
    public function logar($email, $senha)
    {
        global $pdo;
        global $msgErro;
         //Verificar se já existe o e-mail cadastrado, se sim
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email =:e AND senha = :s");
        $sql->bindValue(":e",$email);
        $sql->bindValue(":s",$senha);
        $sql->execute();
        if($sql->rowCount() > 0)
        {
            //Entrar no sistema (sessao)
            $dado = $sql->fetch();
            session_start();
            $_SESSION['id_usuario'] = $dado['id_usuario'];
            return true;  //Logado com Sucesso
        }
        else
        {
            return false;  // Não foi possível logar
        }
    }
}
?>
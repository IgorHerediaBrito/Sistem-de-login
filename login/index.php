<?php
include('conexao.php');

#verificando a existência do email e senha no banco de dados;
if(isset($_POST['email']) || isset($_POST['senha'])) {

#verifica se a pessoa prencheu o e-mail e a senha;

    if(strlen($_POST['email']) == 0) {#se tiver 0 caracteries da erro
        echo "Preencha seu e-mail";
    } else if(strlen($_POST['senha']) == 0) {#se tiver 0 caracteries da erro
        echo "Preencha sua senha";
    } else {

        $email = $mysqli->real_escape_string($_POST['email']);#limpa o email
        $senha = $mysqli->real_escape_string($_POST['senha']);#limpa a senha
        $criptografada=md5($senha);#criptografa

        #seleciona os campos da tabela
        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$criptografada'";

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
        #roda meu sql ou caso haja erro ele mata o cod
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        $quantidade = $sql_query->num_rows;#verifica se tem alguma linha no banco de dados
        
        if($quantidade == 1) {#se tiver 1 linha é vdd
            
            #transfere os dados da tabela para a variavel usuario
            $usuario = $sql_query->fetch_assoc();
            
            #se não tiver sessão, inicia uma nova sessão 
            if(!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
           

            header("Location: conteudo.php");#manda para a minha pagina com o conteudo.

        } else {
            echo "Falha ao logar! E-mail ou senha incorretos";
        }

    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
    <div class="conteiner ">
        <div class="row">
            <div class="col-12 text-center mt-4">
                <h1>Acesse sua conta</h1>
            </div>
        </div>

        <div class="row">
        
            <div class="col-4 text-center mt-4">
                
            </div>
      
        
            <div class="col-4 text-center my-5">
                <form action="" method="POST">
                    <p>
                        <label>E-mail</label>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping">@</span>
                            <input type="text" name="email" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping">
                        </div>
                    </p>
                    <p>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Senha</span>
                            <input type="password" name="senha" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>     
                    </p>
                    <p>
                        <button type="submit" class="btn btn-outline-dark">Entrar</button>
                    </p>
                </form>
            </div>

            
            <div class="col-4 text-center mt-4">
                
            </div>
        
        </div>
    </div>
    
    
</body>
</html>
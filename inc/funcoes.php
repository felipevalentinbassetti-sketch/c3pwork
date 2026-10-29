<?php

function conexao(){
    //configura parametros de entrada
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $bd = "c3pwork";
    $porta = 3306;

    //realiza a conexao com o banco
    $conexao = mysqli_connect($servidor,$usuario, $senha, $bd, $porta);

    //verificar se a conexão foi bem sucedida
    if(!$conexao){
        die("Erro ao conectar no banco de dados ". mysqli_connect_error());
    }

    //define charset para aceitar acentos e caracteres especiais
    mysqli_set_charset($conexao,"utf8");
    
    //retorna a conexão
    return $conexao;
}

function adicionarProduto($conexao, $nome, $preco_v, $preco_c, $codigo_barras, $quantidade, $qtd_min, $descricao,$situacao,$idempresa){
    $sql = "INSERT INTO produtos(nome,preco_v,preco_c,codigo_barras,quantidade,qtd_min,descricao,situacao,id_empresa) VALUES(?,?,?,?,?,?,?,?,?)";

    $stmt = mysqli_prepare($conexao,$sql);

    mysqli_stmt_bind_param($stmt, "sddiiisii", $nome, $preco_v, $preco_c, $codigo_barras, $quantidade, $qtd_min, $descricao,$situacao,$idempresa);

    $result = mysqli_stmt_execute($stmt);

    return $result? mysqli_insert_id($conexao):false;
}

function adicionarEmpresa($conexao, $nome, $razao_social, $cnpj, $senha, $data_cadastro){
    $sql = "insert into empresas(nome,razao_social,cnpj,senha,data_cadastro) VALUES(?,?,?,?,?)";
    
    $senhaCripto = password_hash($senha, PASSWORD_DEFAULT);
    
    $stmt = mysqli_prepare($conexao,$sql);

    mysqli_stmt_bind_param($stmt, "sssss", $nome, $razao_social, $cnpj, $senhaCripto, $data_cadastro);

    $result = mysqli_stmt_execute($stmt);

    return $result ? mysqli_insert_id($conexao) : false;
}

function listarProdutos($conexao, $id_empresa){
    
    $sql = "select * from produtos where id_empresa = $id_empresa";

    $stmt = mysqli_prepare($conexao,$sql);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    $linhas = array();

    if($resultado){
        while($l = mysqli_fetch_assoc($resultado)){
            array_push($linhas,$l);
        }
    }

    return $linhas;

}

function verificaSenha($conexao,$cnpj,$senha){
    $empresa = false;

    $sql = "Select * FROM empresas WHERE cnpj = ?";

    $stmt = mysqli_prepare($conexao,$sql);

    mysqli_stmt_bind_param($stmt,"s",$cnpj);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if($resultado && $resultado->num_rows != 0){
        $empresa = mysqli_fetch_assoc($resultado);

        if(!password_verify($senha, $empresa["senha"])){
            $empresa = false;
        }
        else{
            unset($empresa["senha"]);
        }
    }
    
    return $empresa;
}


function gerarToken($conexao, $empresa){
    $bytes = random_bytes(16);
    $token = bin2hex($bytes);
    $validade = date('Y-m-d H:i:s', strtotime('+10 days'));

    $sqlCheck = "SELECT id_empresa FROM empresa_token WHERE id_empresa = ?";
    $stmtCheck = mysqli_prepare($conexao, $sqlCheck);
    mysqli_stmt_bind_param($stmtCheck, "i", $empresa["id"]);
    mysqli_stmt_execute($stmtCheck);
    mysqli_stmt_store_result($stmtCheck);

    if (mysqli_stmt_num_rows($stmtCheck) > 0) {
        $sqlUpdate = "UPDATE empresa_token SET token = ?, data_expedicao = ? WHERE id_empresa = ?";
        $stmtUpdate = mysqli_prepare($conexao, $sqlUpdate);
        mysqli_stmt_bind_param($stmtUpdate, "ssi", $token, $validade, $empresa["id"]);
        $result = mysqli_stmt_execute($stmtUpdate);
    } else {
        $sqlInsert = "INSERT INTO empresa_token (id_empresa, token, data_expedicao) VALUES (?, ?, ?)";
        $stmtInsert = mysqli_prepare($conexao, $sqlInsert);
        mysqli_stmt_bind_param($stmtInsert, "iss", $empresa["id"], $token, $validade);
        $result = mysqli_stmt_execute($stmtInsert);
    }

    return $result ? $token : false;
}


function buscarEmpresaPorToken($conexao, $token){
    $sql = "Select token, id_empresa, data_expedicao from empresa_token where token = ?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt,'s',$token);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    $id = NULL;

    if($resultado){
        $id = mysqli_fetch_assoc($resultado);
    }
    
    return $id;
}

function removeToken($conexao, $token, $id_empresa){
    $sql = "DELETE FROM empresa_token WHERE id_empresa = $id_empresa AND token = '$token'";

    $resultado = mysqli_query($conexao, $sql);

    return $resultado ? mysqli_insert_id($conexao) : false;
}

function buscarEmpresaPorID($conexao, $id){
    $sql = "Select * from empresas where id = $id";
    
    $stmt = mysqli_prepare($conexao,$sql);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    $resultado = mysqli_fetch_assoc($resultado);

    return $resultado;
}

function verificaCnpj($conexao, $cnpj){
    $sql = "Select cnpj from empresas where cnpj = ?";

    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $cnpj);
    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado && $resultado->num_rows != 0){
        $verifcnpj = false;//cnpj já existe
    }else{
        $verifcnpj = true;
    }

    return $verifcnpj;
}

function verificaCodigo($conexao,$codigo_barras,$id_empresa){
    $sql = "Select codigo_barras from produtos where codigo_barras = ? and id_empresa = ?";

    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "si", $codigo_barras, $id_empresa);
    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado && $resultado->num_rows != 0){
        $verifcodigo = false;//codigo de barras já existe nessa empresa
    }else{
        $verifcodigo = true;
    }

    return $verifcodigo;
}

function verificaEmailCliente($con, $email, $id_empresa) {
    $sql = "Select * from clientes where email = ? and id_empresa = ?";
    
    $stmt = mysqli_prepare($con,$sql);

    mysqli_stmt_bind_param($stmt, "si", $email, $id_empresa);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result && $result->num_rows != 0){
        $verifcodigo = false;
    }else{
        $verifcodigo = true;
    }

    return $verifcodigo;
}

function adicionarCliente($con, $nome, $email, $numero_c, $numero_t, $cep, $id_empresa){
$sql = "INSERT INTO clientes(nome, email, numero_celular, numero_telefone, cep, id_empresa) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param($stmt, "ssssii", $nome, $email, $numero_c, $numero_t, $cep, $id_empresa);

    $result = mysqli_stmt_execute($stmt);

    return $result? mysqli_insert_id($con):false;
}

function listarClientes($conexao, $id_empresa){
    
    $sql = "select * from clientes where id_empresa = $id_empresa";

    $stmt = mysqli_prepare($conexao,$sql);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    $linhas = array();

    if($resultado){
        while($l = mysqli_fetch_assoc($resultado)){
            array_push($linhas,$l);
        }
    }

    return $linhas;

}

function adicionarVenda($conexao, $id_cliente, $id_empresa, $codigo_barras, $quantidade, $pagamento, $parcelas, $data_venda) {
    $sql = "INSERT INTO vendas (id_cliente, id_empresa, codigo_barras, quantidade, pagamento, parcelas, data_venda) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexao, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "iiiisis", $id_cliente, $id_empresa, $codigo_barras, $quantidade, $pagamento, $parcelas, $data_venda);

    $result = mysqli_stmt_execute($stmt);

    return $result;
}

function vendaProduto($conexao, $id_empresa, $codigo_barras, $quantidade_vendida) {
    $sql = "UPDATE produtos SET quantidade = quantidade - ? WHERE codigo_barras = ? AND id_empresa = ?";
    $stmt = mysqli_prepare($conexao, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "iii", $quantidade_vendida, $codigo_barras, $id_empresa);
    $result = mysqli_stmt_execute($stmt);

    return $result;
}

function pesquisarProdutos($conexao, $id_empresa, $codigo_barras){
    
    $sql = "select * from produtos where id_empresa = $id_empresa and codigo_barras = $codigo_barras";

    $stmt = mysqli_prepare($conexao,$sql);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    $linhas = array();

    if($resultado){
        while($l = mysqli_fetch_assoc($resultado)){
            array_push($linhas,$l);
        }
    }

    return $linhas;

}

function atualizarProduto($conexao, $preco_v, $preco_c, $codigo_barras, $quantidade, $id_empresa) {
    $sql = "UPDATE produtos SET preco_v = ?, preco_c = ?, quantidade = ?, situacao = ? WHERE codigo_barras = ? AND id_empresa = ?";
    $stmt = mysqli_prepare($conexao, $sql);

    if (!$stmt) {
        return false;
    }

    $situacao = 1;

    mysqli_stmt_bind_param($stmt, "ddiiii", $preco_v, $preco_c, $quantidade, $situacao ,$codigo_barras, $id_empresa);
    $result = mysqli_stmt_execute($stmt);

    return $result;
}

function verificaProduto($con, $id_empresa) {
    $produtosAbaixoMin = [];

    $sql = "SELECT id, nome, quantidade, qtd_min FROM produtos WHERE id_empresa = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id_empresa);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($produto = $result->fetch_assoc()) {
        if ($produto['quantidade'] <= $produto['qtd_min']) {
            $update = $con->prepare("UPDATE produtos SET situacao = 0 WHERE id = ?");
            $update->bind_param("i", $produto['id']);
            $update->execute();

            $produtosAbaixoMin[] = $produto['nome'];
        }
    }

    $stmt->close();

    return $produtosAbaixoMin;
}

?>
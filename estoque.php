<?php

    require_once 'verifica.php';
    require_once './classes/CrudEstoque.class.php';
    require_once './classes/CrudComponentes.class.php';
    ob_start();
    $estoque = new Estoque();
    $componentes = new Componente();

?>
<!DOCTYPE html>
<html lang="pr-BR">

    <head>
        <link rel="icon" type="image/png"
            href="https://info.mch.ifsuldeminas.edu.br/wp-content/uploads/2019/04/android-icon-48x48.png">
        <link rel="apple-touch-icon" sizes="76x76"
            href="https://info.mch.ifsuldeminas.edu.br/wp-content/uploads/2019/04/android-icon-48x48.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <meta property="og:url" content="https://info.mch.ifsuldeminas.edu.br/projetos">
        <meta property="og:type" content="webpage">
        <meta property="og:title" content="Projetos">
        <meta property="og:description" content="Conheça nossos Projetos, Laboratórios e Grupos de Estudos e Pesquisas">
        <meta property="og:image"
            content="https://info.mch.ifsuldeminas.edu.br/wp-content/uploads/2019/05/home-2910592_1920.jpg">

        <title>Cadastro</title>

        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
        <meta name="viewport" content="width=device-width">

        <link href="https://info.mch.ifsuldeminas.edu.br/wp-content/themes/informatica/assets/css/bootstrap.min.css"
            rel="stylesheet">
        <link href="https://info.mch.ifsuldeminas.edu.br/wp-content/themes/informatica/assets/css/style.css"
            rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>

        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,300,700" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">

        <!--    jquery      -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
        
    </head>

    <body class="off-canvas-menu">
        <!--    menu navbar     -->
        <nav class="navbar navbar-expand-lg fixed-top bg-danger navbar-transparent" color-on-scroll="40">
            <div class="container">
                <div class="navbar-translate">
                    <div class="row navbar-header">
                        <a class="navbar-brand">
                            <img src="https://info.mch.ifsuldeminas.edu.br/wp-content/uploads/2019/04/logo.png"> Bem vindo 
                            <?php 
                                $idUser = (int)$_SESSION['id'];
                                echo $componentes->selectUser($idUser);
                            ?>
                        </a>
                    </div>
                    <button class="navbar-toggler navbar-burger" type="button" data-toggle="collapse"
                        data-target="#navbarToggler" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar"></span>
                        <span class="navbar-toggler-bar"></span>
                        <span class="navbar-toggler-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="baixas.php"
                                data-scroll="true">Baixas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cadastro.php"
                                data-scroll="true">Cadastro</a>
                        </li>
                        <form method="POST" class="form-inline my-2 my-lg-0" autocomplete="off">
                            <input class="form-control mr-sm-2" type="search" name="pesquisar">
                            <button class="btn btn-primary my-2 my-sm-0" type="submit">Pesquisar</button>
                        </form>
                        <li class="nav-item">
                            <a class="btn btn-warning" href="logout.php">Sair</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!--    fim menu navbar     -->
        <div class="page-header page-header-xs" data-parallax="true"
            style="background-image: url(&quot;https://info.mch.ifsuldeminas.edu.br/wp-content/uploads/2019/04/industry-3087398_1280.jpg&quot;); transform: translate3d(0px, 0px, 0px);">
            <div class="filter"></div>
            <div class="content-end">
                <div class="motto">
                    <h1 class="title-uppercase text-center"><b>Tela de Estoque</b></h1>
                    <h3 class="text-center"></h3>
                    <br>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <section id="right" class="col-md-12">
                        <?php
                            if (isset($_POST['pesquisar'])){
                                $name = addslashes($_POST['pesquisar']);
                                if (!empty($name)) {
                                    $name = ucwords(strtolower($name));
                                    $pesquisar = $estoque->pesquisar($name);
                                    if(count($pesquisar) > 0){
                                    ?>
                                        <h4 class="title-uppercase text-center mt-4 mb-4">Itens encontrados</h4>
                                        <table>
                                            <tr id="title-register">
                                                <th id="title-register">Nome</th>
                                                <th id="title-register">Descrição</th> 
                                                <th id="title-register">Quantidade</th> 
                                                <th id="title-register">Localização</th> 
                                                <th id="title-register">Funções</th> 
                                            </tr>
                                    <?php  
                                        for ($i=0; $i < count($pesquisar); $i++) { 
                                            echo "<tr>";         
                                            foreach ($pesquisar[$i] as $key => $value) {
                                                if ($key != "idestoque") {
                                                    echo "<td>".$value."</td>";
                                                }
                                            }
                                        ?>           
                                            <td>
                                                <a href="estoque.php?id_up=<?php echo $pesquisar[$i]["idestoque"];?>" id="to-edit">Editar</a> 
                                                <a data-toggle="modal" data-target="#myModal" id="delete" <?php $_SESSION["idestoque"] = $pesquisar[$i]["idestoque"];?>>Excluir</a> <!-- pegando idestoque para poder exclui-lo --> 
                                            </td>
                                        <?php 
                                            echo "</tr>";   
                                        }
                                    ?>
                                        </table>
                                        <div class="text-center mt-3">
                                            <a href="estoque.php" class="btn btn-danger">Fechar</a>
                                        </div>
                                    <?php  
                                    } else {
                                    ?>
                                        <div class="title-uppercase text-center mt-4 mb-4">
                                            <p>O nome informado não consta em nossos registros.</p>
                                        </div>
                                    <?php
                                    }   
                                } else {
                                    ?>
                                        <div class="title-uppercase text-center mt-4 mb-4">
                                            <p>O campo de pesquisa esta vazio.</p>
                                        </div>
                                    <?php
                                }
                            }
                        ?>
                    </section>
                </div>
            </div>
            <div class="main">
                <div class="section section-gray">
                    <div class="container-fluid">
                        <section class="container-register row">
                            <?php

                                if (isset($_POST['idcomponentes']) || isset($_POST['quantidade']) || isset($_POST['observacao'])) {//clicou no botão cadastrar ou atualizar.
                                    //verifica se é o botão atualizar que foi clicado.
                                    if (isset($_GET['id_up']) && !empty($_GET['id_up'])){

                                        $id_update = (int)$_GET['id_up'];
                                        $quantidade = intval($_POST['quantidade']);
                                        $observacao = addslashes($_POST['observacao']);

                                        if (!empty($quantidade) && !empty($observacao)) {

                                            $observacao = ucwords(strtolower($observacao));
                                            
                                            if($estoque->atualiza($observacao, $quantidade, $id_update)){
                                            
                                                header("Location: estoque.php");

                                            }else {
                            ?>
                                                    <div class="alert-erro">
                                                        <span class="fa fa-thumbs-o-up"></span>
                                                        <span class="msg">Erro ao tentar atualizar o componente</span>
                                                        <span class="close-btn">
                                                            <span class="fa-time"></span>
                                                        </span>
                                                    </div>
                            <?php                
                                            }
                                        }    
                                    } else { // caso contrario foi o botão cadastrar.

                                        $dados = $componentes->selectComponentes();

                                        $idcomponentes = intval($_POST['idcomponentes']);
                                        $quantidade = (int)$_POST['quantidade'];
                                        $observacao = addslashes($_POST['observacao']);

                                        if (!empty($quantidade) && !empty($observacao)){

                                            $observacao = ucwords(strtolower($observacao));
                                            
                                            if(!$estoque->insertEstoque($observacao, $quantidade, $idcomponentes)){
                            ?>
                                                <div class="alert-erro">
                                                    <span class="fas fa-exclamation-triangle"></span>
                                                    <span class="msg">Componente já esta cadastrado</span>
                                                    <span class="close-btn">
                                                        <span class="fa-time"></span>
                                                    </span>
                                                </div>
                            <?php
                                            }else {
                            ?>
                                                    <div class="alert-acerto">
                                                        <span class="fa fa-thumbs-o-up"></span>
                                                        <span class="msg">Componente cadastrado com sucesso</span>
                                                        <span class="close-btn">
                                                            <span class="fa-time"></span>
                                                        </span>
                                                    </div>
                            <?php                
                                            }
                                        } else {
                            ?>
                                            <div class="alert-erro">
                                                    <span class="fas fa-exclamation-triangle"></span>
                                                    <span class="msg"><?php echo "Preencha todos os dados"; ?></span>
                                                    <span class="close-btn">
                                                        <span class="fa-time"></span>
                                                    </span>
                                                </div>
                            <?php
                                            }
                                        }
                                    }
                                //verificar se o usuraio clicou no botão editar, e retornara os dados selecionados pelo id
                                if (isset($_GET['id_up'])) {

                                    $id_update = addslashes($_GET['id_up']);
                                    $result = $estoque->selectId($id_update);

                                }
                            ?>
                            <section id="left" class="col-md-4">
                                <form method="POST" class="form-register" autocomplete="off">
                                    <h3>Estoque</h3>
                                    <div class="textboxregister">
                                        <label for="name">Nome</label>
                                        <?php
                                            if(empty($_GET['id_up'])){
                                        ?>
                                                <select name="idcomponentes" id="idcomponentes" title="Selecione o nome do componente">
                                        <?php   
                                                    $dados = $componentes->selectComponentes();
                                                        
                                                    foreach ($dados as  $value){           
                                        ?>  
                                                        <option value="<?php echo $value['idcomponentes']?>">
                                                                <?php
                                                                    echo $value['nome'];
                                                                ?>
                                                        </option>
                                        <?php
                                                    }
                                        ?>
                                                </select>  
                                        <?php           
                                            } else {
                                        ?>
                                                <input type="text" name="name" id="name" title="O Nome do componente não pode ser alterado"
                                                value="<?php //verifica se a variavel $result possui dados, caso a mesma possua printara o resultado
                                                    if (isset($result)) {
                                                        echo $result['nome'];
                                                    }
                                                ?>" disabled>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="textboxregister">
                                        <label for="quantidade">Quantidade</label>
                                        <input type="number" name="quantidade" id="quantidade" title="Informe a quantidade de componentes"
                                        value="<?php //verifica se a variavel $result possui dados, caso a mesma possua printara o resultado
                                                    if (isset($result)) {
                                                        echo $result['quantidade'];
                                                    }
                                                ?>">
                                        <span class="check-message-register hidden">Obrigatório</span>
                                    </div>
                                    <div class="textboxregister">
                                        <label for="observacao">Localização</label>
                                        <input type="text" name="observacao" id="observacao" title="Informe onde o componente está localizado"
                                        value="<?php //verifica se a variavel $result possui dados, caso a mesma possua printara o resultado
                                                    if (isset($result)) {
                                                        echo $result['descricaoEstoque'];
                                                    }
                                                ?>">
                                        <span class="check-message-register hidden">Obrigatório</span>
                                    </div>
                                    <input type="submit" 
                                        value="<?php // trocara o botão de cadastrar pelo de atualizar
                                                    if (isset($result)) {
                                                        echo "Atualizar";
                                                    }else {
                                                        echo "Cadastrar";
                                                    }
                                                ?>"  
                                        name="login" id="login" class="register-btn" disabled>
                                </form>
                            </section>
                            <section id="right" class="col-md-8">
                                <table>
                                    <?php
                                        $dados = $estoque->selectEstoque();
                                        //defini o numero de paginas
                                        $limit = 10;
                                        //pagina atual
                                        $pagina = (!isset($_GET['pagina'])) ? 1 : $_GET['pagina'];
                                        $total = ceil((count($dados) / $limit));
                                        $inicio = ($limit * $pagina)-$limit;
                                        
                                        $selectLimit = $estoque->selectEstuqueLimit($inicio, $limit);
                                        

                                        if(count($dados) > 0){
                                    ?>
                                            <tr id="title-register">
                                                <th id="title-register">Nome</th>
                                                <th id="title-register">Descrição</th> 
                                                <th id="title-register">Quantidade</th> 
                                                <th id="title-register">Localização</th> 
                                                <th id="title-register">Funções</th> 
                                            </tr>
                                    <?php        
                                            for ($i=0; $i < count($selectLimit); $i++) { 
                                                echo "<tr>";
                                                foreach ($selectLimit[$i] as $key => $value) {
                                                    if ($key != "idestoque") {
                                                        echo "<td>".$value."</td>";
                                                    }
                                                }
                                    ?>
                                                <td>
                                                    <a href="estoque.php?id_up=<?php echo $dados[$i]["idestoque"];?>" id="to-edit">Editar</a>
                                                    <a data-toggle="modal" data-target="#myModal" id="delete" <?php $_SESSION["idestoque"] = $dados[$i]["idestoque"];?>>Excluir</a> <!-- pegando idestoque para poder exclui-lo -->
                                                </td>
                                    <?php
                                                echo "</tr>";
                                            }
                                    ?>
                                </table>
                                <!-- Modal -->
                                <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tem certeza de que deseja excluir os dados ?</h5>
                                        </div>
                                        <div class="text-center mt-3">
                                            <?php

                                                $dados = $estoque->selectId((int)$_SESSION["idestoque"]);
                                                if(count($dados) > 0){
                                                    
                                                    echo "<h5> Nome: ".$dados['nome']."</h5>";

                                                }
                                            ?>
                                        </div>  
                                        <div class="modal-body">
                                            <p>Caso os dados sejam excluidos, não sera possível desfazer essa ação!!.</p>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <a href="#" class="btn btn-danger" data-dismiss="modal">Não</a>
                                            <a href="estoque.php?id=<?php echo $_SESSION["idestoque"];?>" class="btn btn-success">Sim</a>
                                            <?php
                                                // vefificando se o iditen foi pego corretamente, caso ele tenha sido pego a função deleteItens irá exclui-lo
                                                if (isset($_GET["id"])) {
                                                    $idEstoque = addslashes($_GET["id"]);
                                                    $estoque->deleteEstoque($idEstoque);
                                                    header("Location: estoque.php");
                                                }
                                            ?>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Final Modal -->
                                <div class="pagina">
                                    <?php
                                            for ($i=1; $i <= $total; $i++){
                                                if ($i ==  $pagina) {
                                                    echo ' '.$i.' ';
                                                }else{
                                                    echo ' <a href="? pagina='.$i.'"> '.$i.' </a> ';
                                                }
                                            }
                                        }else { // DB vasio
                                            echo "<p class='text-center'>Ops !!! não exixte dados cadastrados.</p>";
                                        }
                                    ?>
                                </div>
                            </section>
                            <div class="relatorio col-md-12">
                                <p>
                                Clique aqui para gerar o relátorio.
                                <a target="_brack" href="geradorPdf.php" class="fa fa-file-pdf-o" aria-hidden="true"></a>
                                </p>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <!-- inicio do footer -->
        <footer class="footer footer-big">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-sm-12 col-12 ml-auto mr-auto">
                        <div class="row justify-content-md-center">
                            <div class="col-md-2 col-sm-2 col-6">
                                <div class="links">
                                    <ul class="uppercase-links stacked-links">
                                        <li>
                                            <a href="https://info.mch.ifsuldeminas.edu.br/home#courses">
                                                Cursos </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-6">
                                <div class="links">
                                    <ul class="uppercase-links stacked-links">
                                        <li>
                                            <a href="https://info.mch.ifsuldeminas.edu.br/posts">
                                                Notícias </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-6">
                                <div class="links">
                                    <ul class="uppercase-links stacked-links">
                                        <li>
                                            <a href="projetos">
                                                Projetos </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-6">
                                <div class="links">
                                    <ul class="uppercase-links stacked-links">
                                        <li>
                                            <a href="https://info.mch.ifsuldeminas.edu.br/professores">
                                                Professores </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-6">
                                <div>
                                    <a href="https://www.facebook.com/informaticaifmachado" target="_blank"
                                        class="btn btn-just-icon btn-round btn-facebook">
                                        <i class="fa fa-facebook" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="copyright">
                            <div>
                                &copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> | Informática</div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer fim -->
        <!-- srcipts da tela logio -->
        <script type="text/javascript">
            $(".textboxregister input").focusout(function () {
                if ($(this).val() == "") {
                    $(this).siblings().removeClass("hidden");
                } else {
                    $(this).siblings().addClass("hidden");
                }
            });
            $(".textboxregister input").keyup(function () {
                let inputs = $(".textboxregister input");
                if (inputs[0].value != "" && inputs[1].value) {
                    $(".register-btn").attr("disabled", false);
                    $(".register-btn").addClass("active");
                } else {
                    $(".register-btn").attr("disabled", true);
                    $(".register-btn").removeClass("active");
                }
            });
        </script>
        <!-- Core JS Files -->
        <script src="https://info.mch.ifsuldeminas.edu.br/wp-content/themes/informatica/assets/js/jquery-3.2.1.min.js"
            type="text/javascript"></script>
        <script
            src="https://info.mch.ifsuldeminas.edu.br/wp-content/themes/informatica/assets/js/jquery-ui-1.12.1.custom.min.js"
            type="text/javascript"></script>
        <script src="https://info.mch.ifsuldeminas.edu.br/wp-content/themes/informatica/assets/js/popper.js"
            type="text/javascript"></script>
        <script src="https://info.mch.ifsuldeminas.edu.br/wp-content/themes/informatica/assets/js/bootstrap.min.js"
            type="text/javascript"></script>
        <script
            src="https://info.mch.ifsuldeminas.edu.br/wp-content/themes/informatica/assets/js/paper-kit.js?v=2.1.0"></script>
    </body>
</html>
<?php
    ob_end_flush();
?>
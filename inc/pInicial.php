<!--
<div id="wrapper" class="cpanel">

            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="brand">
                    <a href="">
                            <img src="/expotecsc/application/geteventlogo?eventid=1" alt="9&ordf; EXPOTEC/SC" />
                    </a>
                </div>
                <div class="container-fluid">
                    <div class="navbar-btn">
                        <button type="button" class="btn-toggle-fullwidth">
                            <i class="lnr lnr-arrow-left-circle"></i>
                        </button>
		    </div>
                    <div id="navbar-menu">
                        <ul class="nav navbar-nav navbar-right">

                        <?php// if ($usuario->getIdPerfil()==1) {?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"> 
                                    <i class=" lnr lnr-cog"></i> 
                                    <span>Administração</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="./gerenciarAreas.php">
                                            <i class="lnr lnr-star"></i>
                                            <span>Areas</span>
                                        </a>
                                    </li>
		
                                    <li>
                                        <a href="./gerenciarAvaliacoes.php">
                                            <i class="lnr lnr-list"></i>
                                            <span>Avaliações</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="./gerenciarAvaliadores.php">
                                                <i class="lnr lnr-checkmark-circle"></i>
                                                <span>Avaliadores</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="./gerenciarEventos.php">
                                                <i class="lnr lnr-layers"></i>
                                                <span>Eventos</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="./gerenciarModalidades.php">
                                            <i class="lnr lnr-graduation-hat"></i>
                                            <span>Modalidades de Submissão</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="./gerenciarCertificados.php">
                                            <i class="lnr lnr-graduation-hat"></i>
                                            <span>Certificados</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="./gerenciarSolicitacoesAvaliadores.php">
                                            <i class="lnr lnr-star"></i>
                                            <span>Solicitacoes de Avaliadores</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="./gerenciarSubmissoes.php">
                                            <i class="lnr lnr-arrow-left-circle"></i>
                                            <span>Submissões</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="./gerenciarUsuarios.php">
                                            <i class="lnr lnr-arrow-left-circle"></i>
                                            <span>Usuários</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php // }?>
                        <?php //if ($usuario->getIdPerfil()==2) {?>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"> 
                                    <i class=" lnr lnr-screen"></i> 
                                    <span>Atendimento</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="administrators/listusers">
                                            <i class="lnr lnr-users"></i>
                                            <span>Usuários</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="lnr lnr-select"></i>
                                            <span>Presença</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php //}?>
                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"> 
                                        <img class="img-circle inline-block user-profile-pic" src="/expotecsc/attendees/getuserpicture/<?php //echo $usuario->getId() ?>/"/>
                                        <span><?php //echo $usuario->getNome() ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="/expotecsc/attendees/viewmyprofile">
                                            <i class="lnr lnr-exit"></i> 
                                            <span>Meu Perfil </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/expotecsc/security/logout">
                                            <i class="lnr lnr-exit"></i> 
                                            <span>Sair </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
   
            <div id="sidebar-nav" class="sidebar">
                <div class="sidebar-scroll">
                    <nav>
                        <ul class="nav">
                            <li>
                                <a href="/expotecsc/cpanel" class="">
                                    <i class="lnr lnr-home"></i> 
                                    <span>Início</span>
                                </a>
                            </li>
                            <li>
                                <a href="minhasSubmissoes.php" class="">
                                    <i class="lnr lnr-pencil"></i> 
                                    <span>Minhas Submissões</span>
                                </a>
                            </li>
                            <li>
                                <a href="/expotecsc/attendees/listmyinscriptions" class="">
                                    <i class="lnr lnr-pencil"></i> 
                                    <span>Minhas Inscrições</span>
                                </a>
                            </li>
                            <li>
                                <a href="solicitacaoAvaliador.php" class="">
                                    <i class="lnr lnr-checkmark-circle"></i> 
                                    <span>Minhas Solicitações</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="minhasAvaliacoes.php" class="">
                                    <i class="lnr lnr-spell-check"></i> 
                                    <span>Minhas Avaliações </span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
 
            <div class="main">
 
                <?php include dirname(__FILE__) . '/mensagensGET.php'; ?>

                <div class="main-content">
                    <div class="container-fluid">
                        <div class="breadcrumbs">9&ordf; EXPOTEC/SC</div>
                        <div class="panel panel-headline"> 
                         <?php 
                
                require_once './inc/modal.php';
            ?>
-->
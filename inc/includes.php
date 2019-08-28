<?php

    

    require_once dirname(__DIR__) . '/dao/Conexao.php';
    require_once dirname(__DIR__) . '/funcoes/funcoes.php';
    require_once dirname(__DIR__) . '/classes/EnviarEmail.php';
    require_once dirname(__DIR__) . '/inc/varGlobais.php';
    
    
    require_once dirname(__DIR__) . '/classes/Area.php';
    require_once dirname(__DIR__) . '/classes/AreaEvento.php';
    require_once dirname(__DIR__) . '/classes/Avaliacao.php';
    require_once dirname(__DIR__) . '/classes/AvaliacaoCriterio.php';
    require_once dirname(__DIR__) . '/classes/Avaliador.php';
    require_once dirname(__DIR__) . '/classes/Certificado.php';
    require_once dirname(__DIR__) . '/classes/Criterio.php';
    require_once dirname(__DIR__) . '/classes/Evento.php';
    require_once dirname(__DIR__) . '/classes/Modalidade.php';
    require_once dirname(__DIR__) . '/classes/ModalidadeEvento.php';
    require_once dirname(__DIR__) . '/classes/Perfil.php';
    require_once dirname(__DIR__) . '/classes/SituacaoAvaliacao.php';
    require_once dirname(__DIR__) . '/classes/SituacaoSubmissao.php';
    require_once dirname(__DIR__) . '/classes/SolicitacaoAvaliador.php';
    require_once dirname(__DIR__) . '/classes/Submissao.php';
    require_once dirname(__DIR__) . '/classes/TipoCertificado.php';
    require_once dirname(__DIR__) . '/classes/TipoSubmissao.php';
    require_once dirname(__DIR__) . '/classes/TipoUsuario.php';
    require_once dirname(__DIR__) . '/classes/Usuario.php';
    require_once dirname(__DIR__) . '/classes/UsuariosDaSubmissao.php';
    
    
    require_once dirname(__DIR__) . '/dao/AreaDAO.php';
    require_once dirname(__DIR__) . '/dao/AreaEventoDAO.php';
    require_once dirname(__DIR__) . '/dao/AvaliacaoDAO.php';
    require_once dirname(__DIR__) . '/dao/AvaliacaoCriterioDAO.php';
    require_once dirname(__DIR__) . '/dao/AvaliadorDAO.php';
    require_once dirname(__DIR__) . '/dao/CertificadoDAO.php';
    require_once dirname(__DIR__) . '/dao/CriterioDAO.php';
    require_once dirname(__DIR__) . '/dao/EventoDAO.php';
    require_once dirname(__DIR__) . '/dao/ModalidadeDAO.php';
    require_once dirname(__DIR__) . '/dao/ModalidadeEventoDAO.php';
    require_once dirname(__DIR__) . '/dao/PerfilDAO.php';
    require_once dirname(__DIR__) . '/dao/SituacaoAvaliacaoDAO.php';
    require_once dirname(__DIR__) . '/dao/SituacaoSubmissaoDAO.php';
    require_once dirname(__DIR__) . '/dao/SolicitacaoAvaliadorDAO.php';
    require_once dirname(__DIR__) . '/dao/SubmissaoDAO.php';
    require_once dirname(__DIR__) . '/dao/TipoCertificadoDAO.php';
    require_once dirname(__DIR__) . '/dao/TipoSubmissaoDAO.php';
    require_once dirname(__DIR__) . '/dao/TipoUsuarioDAO.php';
    require_once dirname(__DIR__) . '/dao/UsuarioDAO.php';
    require_once dirname(__DIR__) . '/dao/UsuariosDaSubmissaoDAO.php';
    
    
?>


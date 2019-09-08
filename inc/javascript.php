
        <script src="scripts/scripts.js"></script>
        <script src="scripts/popups.js"></script>
        <script src="scripts/requisicoesAjax.js"></script>

        <script src="scripts/jquery-3.2.1.min.js"></script>
        <script src="scripts/jquery-ui-1.12.min.js"></script>
        <script src="scripts/jquery.mask.min.js"></script>

        <script src="scripts/tablesorter.js"></script>
        
        

        <script>
            $(document).ready(function (e){
                $(function(){
                    $('.table_list_2').tablesorter();
                });
                $(function(){
                    $('.table_list').tablesorter();
                });
                $(function(){
                    $('.table_list_3').tablesorter();
                });
                $(function(){
                    $('.table').tablesorter();
                });
                
                $('.editarObjeto').click(function (){
                   $('#modal').fadeIn(500);
                   var x = $(this).attr('id');
                   var name = $(this).attr('name');
                   $('.modal-box-conteudo').load("editItens/editar"+name+".php?id="+x);
                });
                
                $('.addObjeto').click(function (){
                   $('#modal').fadeIn(500);
                   var name = $(this).attr('name');
                   var id = "";
                   
                   if (name == 'ModalidadeEvento' || name == 'AreaEvento' || name == 'Avaliacao' || name=='AvaliacaoRepetida' || name=='VersaoCorrigida') id = "?id="+$(this).attr('id');
                   $('.modal-box-conteudo').load("addItens/add"+name+".php"+id);
                });
                
                $('.excluirObjeto').click(function (){
                   $('#modal').fadeIn(500);
                   var x = $(this).attr('id');
                   var name = $(this).attr('name');
                   $('.modal-box-conteudo').load("excluirItens/excluir"+name+".php?id="+x);
                });

                $(document).on('click', '.visualizarObjeto', function(){
                   $('#modal').fadeIn(500);
                   var x = $(this).attr('id');
                   var name = $(this).attr('name');
                   $('.modal-box-conteudo').load("visualizarItens/visualizar"+name+".php?id="+x);
                });
                
                $('.fechar,#modal').click(function (event){
                    if (event.target !== this) return;
                    $('#modal').fadeOut(500);
                    $('.modal-box-conteudo').html("");
                });
               
                $(document).keyup(function(e) { 
                    if (e.keyCode === 27) {
                        $('#modal').fadeOut(300);
                        $('.modal-box-conteudo').html("");
                    }
                });
                
                $('.addCriterio').click(function (){
                   $('#modal').fadeIn(500);
                   var x = $(this).attr('id');
                   var tipo = $(this).attr('name');
                   $('.modal-box-conteudo').load("addItens/addCriterio.php?idModalidade="+x+"&idTipo="+tipo);
                });
                $(document).on('click', '.addDistribuicao', function(){
                    $('#modal').fadeIn(500); 
                    var evento = $('#select-Eventos').val();
                    var tipoAvaliacao = $('#select-tipoAvaliacao').val();
                    var avaliadoresDaArea = $('#avaliadoresDaArea').val();
                    var avaliadoresOutraArea = $('#avaliadoresOutraArea').val();
                    
                    $('.modal-box-conteudo').load("addItens/addDistribuicao.php?idEvento="+evento+"&idTipoAvaliacao="+tipoAvaliacao+"&avArea="+avaliadoresDaArea+"&avOutraArea="+avaliadoresOutraArea);
                    
                });
                
            });
    </script>
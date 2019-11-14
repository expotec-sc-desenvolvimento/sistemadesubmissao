function loadAreas() {
    
    
    var xhttp = new XMLHttpRequest();
    var id = document.getElementById("select-Eventos").value;

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("select-Areas").innerHTML = this.responseText;
        }
    };

    xhttp.open("GET", "reqAjax/wsAreasAjax.php?evento="+id, true);
    xhttp.send();

}

function loadModalidades(campo) {
    
    
    var xhttp = new XMLHttpRequest();
    var id = document.getElementById("select-Eventos").value;

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("select-Modalidades").innerHTML = this.responseText;
	    if (campo!='') document.getElementById('select-Modalidades').value = campo;
        }
    };

    xhttp.open("GET", "reqAjax/wsModalidadesAjax.php?evento="+id, true);
    xhttp.send();

}

function loadUsers(busca,resposta) {
      
    if (document.getElementById(busca).value.length>=3) {
        document.getElementById("resposta").style.display = "block";
        var xhttp = new XMLHttpRequest();
        var nome = document.getElementById(busca).value;
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById(resposta).innerHTML = this.responseText;
          }
        };

        xhttp.open("GET", "reqAjax/wsUsuariosAjax.php?nome="+nome, true);
        xhttp.send();

  }
}

function usuariosSubmissao(busca,resposta,idSubmissor) {
      
    if (document.getElementById(busca).value.length>=3) {
        document.getElementById("resposta").style.display = "block";
        var xhttp = new XMLHttpRequest();
        var nome = document.getElementById(busca).value;
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById(resposta).innerHTML = this.responseText;
          }
        };

        xhttp.open("GET", "reqAjax/wsUsuariosAjax.php?nome="+nome+"&idSubmissor="+idSubmissor, true);
        xhttp.send();
    }
    else {
        //document.getElementById("resposta").innerHTML = "Digite ao menos 4 letras";
        document.getElementById("resposta").style.display = "none";
    }

  }

function gerarLista(icon) {

    // Existe a variavel global 'idUsersSelected' e 'nomesUsers', que guarda o nome dos usuários, que guardam os ids e nomes dos usuarios escolhidos, respectivamente
    var nomesUsers = "";
    //var idUsers = "";

    for (var i=0;i<idUsersSelected.length;i++) {
        var inserir = "&nbsp;&nbsp;<span class='link-users' onclick=\"retirarNome('"+idUsersSelected[i]+"','"+icon+"')\">"+nomeUsersSelected[i]+"<img src='"+icon+"' class='img-miniatura' style='cursor:pointer;'></span>";

        nomesUsers = nomesUsers + inserir + " ";
        
    }
    
    document.getElementById("users-selected").innerHTML = nomesUsers;
    
}
function adicionarId(id,nome,iconExcluir) {

    
    if (idUsersSelected.indexOf(id)!=-1) alert('Usuário já adicionado');
    else {
        idUsersSelected.push(id);
        nomeUsersSelected.push(nome)
        gerarLista(iconExcluir);
    }
    
    // Código acrescentados rescentemente
    document.getElementById('buscaUsers').value = '';
    document.getElementById('resposta').innerHTML = '';
    document.getElementById('resposta').style.display = "none";
}


function retirarNome(id,iconExcluir) {
        
    var index = idUsersSelected.indexOf(id);

    if (index>-1) {

         nomeUsersSelected.splice(index, 1);
         idUsersSelected.splice(index, 1);

         gerarLista(iconExcluir);

    }
}

function listaIds() {
    
    if (idUsersSelected.length<=0) {
        alert("Nenhum Usuario selecionado!")
        return false;
    }
    else {        
        var ids = "";
        for (var i=0;i<idUsersSelected.length;i++) ids = ids + idUsersSelected[i] + ";";
        document.getElementById('idUsuariosAdd').value = ids;
        return true;

    }
}

function submeterAutores(idSubmissor) {

    
    var ids = idSubmissor+";";
    for (var i=0;i<idUsersSelected.length;i++) ids = ids + idUsersSelected[i] + ";";
    document.getElementById('idUsuariosAdd').value = ids;
    
    document.getElementById('botaoSubmeter').value = "Aguarde...";
    document.getElementById('botaoSubmeter').disabled = true;
    return true;

}

function loadInfoEvento(evento,tipoAvaliacao,resposta) {
    
    if (evento!="") {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById(resposta).innerHTML = this.responseText;
          }
        };

        xhttp.open("GET", "reqAjax/wsLoadInfoEvento.php?evento="+evento+"&tipoAvaliacao="+tipoAvaliacao, true);
        xhttp.send();
    }
    else document.getElementById(resposta).innerHTML = "";
}

function loadUsuariosAptos(tipo,resposta) {
   
    document.getElementById(resposta).innerHTML = "<h3>Aguarde...</h3>";
   // alert(idAvaliadorAtual+" ; "+idSubmissao+" ; "+evento+" ; "+area+" ; "+tipo);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById(resposta).innerHTML = this.responseText;
      }
    };

    xhttp.open("GET", "./reqAjax/wsLoadUsuariosAptos.php?tipo="+tipo, true);
    xhttp.send();
}

function loadAvaliadores(idAvaliadorAtual,idSubmissao,evento,area,tipo,resposta) {
    
    
    document.getElementById(resposta).innerHTML = "<option value=''>Aguarde...</option>";
   // alert(idAvaliadorAtual+" ; "+idSubmissao+" ; "+evento+" ; "+area+" ; "+tipo);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById(resposta).innerHTML = this.responseText;
      }
    };

    xhttp.open("GET", "./reqAjax/wsLoadAvaliadores.php?idAvaliadorAtual="+idAvaliadorAtual+"&idSubmissao="+idSubmissao+"&evento="+evento+"&area="+area+"&tipo="+tipo, true);
    xhttp.send();
    
}

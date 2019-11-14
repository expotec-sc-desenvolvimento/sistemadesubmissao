/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function formatar(mascara, documento){
    var i = documento.value.length;
    var saida = mascara.substring(0,1);
    var texto = mascara.substring(i)

    if (texto.substring(0,1) != saida){
        documento.value += texto.substring(0,1);
    }
}

function reiniciarSenha(id,nome) {
    result = confirm("Deseja reiniciar a Senha do Usuário "+nome+"?");
    if (result) {
        location.href='submissaoForms/wsSetarSenha.php?id='+id;
    }
}

function emailValido(field) {
    
    
    usuario = field.value.substring(0, field.value.indexOf("@"));
    dominio = field.value.substring(field.value.indexOf("@")+ 1, field.value.length);
        
    if (//(usuario.length >=1) &&
        (dominio.length >=3) && 
  //      (usuario.search("@")==-1) && 
        (dominio.search("@")==-1) &&
  //      (usuario.search(" ")==-1) && 
        (dominio.search(" ")==-1) &&
        (dominio.search(".")!=-1) &&      
        (dominio.indexOf(".") >=1)&& 
        (dominio.lastIndexOf(".") < dominio.length - 1)) {
            return true;

    }
    else{
        return false;
    }
}
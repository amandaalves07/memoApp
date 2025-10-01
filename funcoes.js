function validaFormCad(){ //usada no cadUser01.php
    //função para validar dados digitados pelo usuário
    //é necessário adaptar após a manutenção do estilo do site
    var enviar=true;

    if (document.form1.nome.value=="") {
        //document.getElementById("erroNome").innerHTML="Nome deve ser preenchido!";
        enviar=false;
    }

    if (document.form1.email.value=="") {
        //document.getElementById("erroEmail").innerHTML="E-mail deve ser preenchido!";
        enviar=false;
    }

    if (document.form1.senha01.value=="") {
        //document.getElementById("erroSenha").innerHTML="Senha deve ser preenchida!";
        enviar=false;
    }

    if (document.form1.senha02.value=="") {
        //document.getElementById("erroSenha").innerHTML="Senha deve ser preenchida!";
        enviar=false;
    }

    if (document.form1.dataNasc.value=="") {
        //document.getElementById("erroDNasc").innerHTML="Data de nascimento deve ser preenchida!";
        enviar=false;
    }

    if (document.form1.tel.value=="") {
        //document.getElementById("erroDNasc").innerHTML="Data de nascimento deve ser preenchida!";
        enviar=false;
    }

    return enviar;
}

function validarSenhaCad() { //usada no cadUser01.php
    //função para verificar formatação da senha informada no cadastro
    var enviar=true;
    var senha=document.form1.senha01.value;

    if(senha.length<8){
        document.getElementById("password-length").style.color="red";
        enviar=false;
    } else {
        document.getElementById("password-length").style.color="green";
    }

    var maiuscCont=(senha.match(/[A-Z]/g) || []).length;
    var minuscCont=(senha.match(/[a-z]/g) || []).length;
    var sinaisCont=(senha.match(/[!@#$%^&*(),.?":{}|<>]/g) || []).length;
    var numCont=(senha.match(/[0-9]/g) || []).length;

    if (maiuscCont<1) {
        document.getElementById("password-uppercase").style.color="red";
        enviar=false;
    } else {
        document.getElementById("password-uppercase").style.color="green";
    }
    if (minuscCont<1) {
        document.getElementById("password-lowercase").style.color="red";
        enviar=false;
    } else {
        document.getElementById("password-lowercase").style.color="green";
    }
    if (sinaisCont<1) {
        document.getElementById("password-symbol").style.color="red";
        enviar=false;
    } else {
        document.getElementById("password-symbol").style.color="green";
    }
    if(numCont<1){
        document.getElementById("password-number").style.color="red";
        enviar=false;
    } else {
        document.getElementById("password-number").style.color="green";
    }
    return enviar;
}

function validaFormLogin(){ //usada no login01.html
    var enviar=true;
    if (document.form1.email.value==""){
        document.getElementById("erroEmail").innerHTML="E-mail deve ser preenchido!";
        enviar=false;
    } else {
        document.getElementById("erroEmail").innerHTML="";
    }

    if (document.form1.senha.value==""){
        document.getElementById("erroSenha").innerHTML="Senha deve ser preenchida!";
        enviar=false;
    } else {
        document.getElementById("erroSenha").innerHTML="";
    }
    return enviar;
}

//função para validar form para envio
function validaFormMudaSenha(){ //usada no mudaSenha01.php
    var enviar=true;
    var msgErro=""; //variável para concatenar mensagens de erro

    if (document.form1.senhaAntiga.value=="") {
        document.getElementById("erroSenhaAnt").innerHTML="Preencha a senha atual!";
        enviar=false;
    } else {
        document.getElementById("erroSenhaAnt").innerHTML="";
    }
    if (document.form1.senhaNova1.value=="") {
        document.getElementById("erroSenhaNova1").innerHTML="Preencha a senha nova!";
        enviar=false;
    } else {
        document.getElementById("erroSenhaNova1").innerHTML="";
    }
    if (document.form1.senhaNova2.value=="") {
        msgErro+="Confirme a senha nova! <br>";
        enviar=false;
    }
    if (document.form1.senhaNova1.value!=document.form1.senhaNova2.value) {
        msgErro+="Senhas não conferem! <br>";
        enviar=false;
        }
    if(document.form1.senhaNova1!="" && document.form1.senhaNova2!="" && document.form1.senhaAntiga.value==document.form1.senhaNova1.value){
        msgErro+="Senha nova não pode ser igual à atual!";
        enviar=false;
    }

    if(!validarSenha()){
        enviar=false;
    }

    document.getElementById("erroSenhaNova2").innerHTML=msgErro; //mostrando mensagens de erro
        return enviar;
}

function validarSenha(){ //usada no mudaSenha01.php e no novaSenha03.php
    //função para validar senha nova informada no mudaSenha
    var enviar=true;
    var senhaNova1=document.form1.senhaNova1.value;

    if(senhaNova1.length<8){
        document.getElementById("password-length").style.color="red";
        enviar=false;
    } else {
        document.getElementById("password-length").style.color="green";
    }

    var maiuscCont=(senhaNova1.match(/[A-Z]/g) || []).length;
    var minuscCont=(senhaNova1.match(/[a-z]/g) || []).length;
    var sinaisCont=(senhaNova1.match(/[!@#$%^&*(),.?":{}|<>]/g) || []).length;
    var numCont=(senhaNova1.match(/[0-9]/g) || []).length;

    if (maiuscCont<1) {
        document.getElementById("password-uppercase").style.color="red";
        enviar=false;
    } else {
        document.getElementById("password-uppercase").style.color="green";
    }
    if (minuscCont<1) {
        document.getElementById("password-lowercase").style.color="red";
        enviar=false;
    } else {
        document.getElementById("password-lowercase").style.color="green";
    }
    if (sinaisCont<1) {
        document.getElementById("password-symbol").style.color="red";
        enviar=false;
    } else {
        document.getElementById("password-symbol").style.color="green";
    }
    if(numCont<1){
        document.getElementById("password-number").style.color="red";
        enviar=false;
    } else {
        document.getElementById("password-number").style.color="green";
    }
    return enviar;
}

function validaFormNovaSenha(){ //usada no novaSenha01.php
    var enviar=true;
    var email=document.form1.email.value;
    const emailRegex=/^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email=="") {
        document.getElementById("erroEmail").innerHTML+="Preencha o e-mail!";
        enviar=false;
    } else {
        document.getElementById("erroEmail").innerHTML="";
    }
    if(!emailRegex.test(email)){
        //e-mail informado não é válido
        document.getElementById("erroEmail").innerHTML+="Informe um e-mail válido!";
    }
    return enviar;
}

function validarFormCadPaciente(){ //usada no cadPaciente01.php e no modPaciente01.php
    var enviar=true;

    if (document.form1.nome.value=="") {
        enviar=false;
    }

    if (document.form1.sexo.value=="") {
        enviar=false;
    }

    if (document.form1.dataNasc.value=="") {
        enviar=false;
    }

    if (document.form1.tel.value=="") {
        enviar=false;
    }
    return enviar;
}

//funções referentes à lista de pacientes cadastrados (vizualizarPacientes.php)
function mudaPagina($pag){ //usada no vizualizarPacientes.php
    document.form1.pag.value=$pag;
    document.form1.submit();
}

function confirmarExclusao(nome){ //usada no vizualizarPacientes.php
    return confirm("Você deseja excluir o usuário "+nome+"?");
}

function validaFormModUser(){ //usada no modUser01.php
    var enviar=true;

    if (document.form1.nome.value=="") {
        //document.getElementById("erroNome").innerHTML="Nome deve ser preenchido!";
        enviar=false;
    }

    if (document.form1.email.value=="") {
        //document.getElementById("erroEmail").innerHTML="E-mail deve ser preenchido!";
        enviar=false;
    }

    if (document.form1.dataNasc.value=="") {
        //document.getElementById("erroDNasc").innerHTML="Data de nascimento deve ser preenchida!";
        enviar=false;
    }

    if (document.form1.tel.value=="") {
        //document.getElementById("erroDNasc").innerHTML="Data de nascimento deve ser preenchida!";
        enviar=false;
    }

    return enviar;
}
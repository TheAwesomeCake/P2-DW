document.getElementById('submitButton').addEventListener('click', createUser);
function createUser() {
    const nomeUsuario = document.getElementById('nome').value;
    const emailUsuario = document.getElementById('email').value;
    const dataNascimentoUsuario = document.getElementById('dataNascimento').value;
    const senhaUsuario = document.getElementById('senha').value;
    const cepUsuario = document.getElementById('cep').value;
    const ruaUsuario = document.getElementById('rua').value;
    const bairroUsuario = document.getElementById('bairro').value;
    const cidadeUsuario = document.getElementById('cidade').value;
    const ufUsuario = document.getElementById('uf').value;

    // 0000
    if (!nomeUsuario && !emailUsuario && dataNascimentoUsuario && !senhaUsuario) {
        alert("Por favor, insira um nome, um email, uma data de nascimento e uma senha!");
        return;
    // 0001
    } else if (!nomeUsuario && !emailUsuario && !dataNascimentoUsuario) {
        alert("Por favor, insira um nome, um email e uma data de nascimento!");
        return;
    // 0010
    } else if (!nomeUsuario && !emailUsuario && !senhaUsuario) {
        alert("Por favor, insira um nome, um email e senha!");
        return;
    // 0011
    } else if (!nomeUsuario && !emailUsuario) {
        alert("Por favor, insira um nome e um email!");
        return;
    // 0100
    } else if (!nomeUsuario && !dataNascimentoUsuario && !senhaUsuario) {
        alert("Por favor, insira um nome, uma data de nascimento e uma senha!");
        return;
    // 0101
    } else if (!nomeUsuario && !dataNascimentoUsuario) {
        alert("Por favor, insira um nome e uma data de nascimento!");
        return;
    // 0110
    } else if (!nomeUsuario && !senhaUsuario) {
        alert("Por favor, insira um nome e uma senha!");
        return;
    // 0111
    } else if (!nomeUsuario) {
        alert("Por favor, insira um nome!");
        return;
    // 1000
    } else if (!emailUsuario && !dataNascimentoUsuario && !senhaUsuario) {
        alert("Por favor, insira um email, uma data de nascimento e uma senha!");
        return;
    // 1001
    } else if (!emailUsuario && dataNascimentoUsuario) {
        alert("Por favor, insira um email e uma data de nascimento!");
        return;
    // 1010
    } else if (!emailUsuario && !senhaUsuario) {
        alert("Por favor, insira um email e uma senha!");
        return;
    // 1011
    } else if (!emailUsuario) {
        alert("Por favor, insira um email!");
        return;
    // 1100
    } else if (!dataNascimentoUsuario && !senhaUsuario) {
        alert("Por favor, insira uma data de nascimento e uma senha!");
        return;
    // 1101
    } else if (!dataNascimentoUsuario) {
        alert("Por favor, insira uma data de nascimento!");
        return;
    // 1110
    } else if (!senhaUsuario) {
        alert("Por favor, insira uma senha!");
        return;
    }
    // Função tirada de https://www.w3resource.com/javascript/form/email-validation.php
    function validateEmail(email) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
            return true;
        }  else {
            return false;
        }
    }

    if (validateEmail(emailUsuario) === false) {
        alert("Por favor, insira um email válido!");
        return;
    }

    const usuario = {
        nome: nomeUsuario,
        email: emailUsuario,
        dataNascimento: dataNascimentoUsuario,
        senha: senhaUsuario,
        cep: cepUsuario,
        rua:ruaUsuario,
        bairro:bairroUsuario,
        cidade:cidadeUsuario,
        uf:ufUsuario
    };

    fetch('/backend/UsuarioRouter.php', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(usuario)
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 401) {
                throw new Error('Não autorizado');
            } else {
                throw new Error('Sem rede ou não conseguiu localizar o recurso');
            }
        }
        return response.json();
    })
    .then(data => {
        if(!data.status){
            alert('Usuário já existe');
        }else{
            alert("Usuário criado com sucesso!");
        } 
       
    })
    .catch(error => alert('Erro na requisição: ' + error));
}

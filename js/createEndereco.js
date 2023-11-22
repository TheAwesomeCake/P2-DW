document.getElementById('createEnderecoSubmitBtn').addEventListener('click', function () {
    const cepUsuario = document.getElementById('cep').value;
    const ruaUsuario = document.getElementById('rua').value;
    const bairroUsuario = document.getElementById('bairro').value;
    const cidadeUsuario = document.getElementById('cidade').value;
    const ufUsuario = document.getElementById('uf').value;
    const userId = document.getElementById('getUserId').value;

    const endereco = {
        cep: cepUsuario,
        rua: ruaUsuario,
        bairro: bairroUsuario,
        cidade: cidadeUsuario,
        uf: ufUsuario,
        iduser: userId, 
    };
    fetch('/backend/EnderecoRouter.php', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(endereco)
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
        if (!data.status){
            alert('Endereço já existe para o usuário');
        } else {
            alert("Endereço adicionado com sucesso!");
        } 
    })
    .catch(error => alert('Erro na requisição: ' + error));
})
document.getElementById('createVendaSubmitBtn').addEventListener('click', function () {
    const idUsuario = document.getElementById('id_usuario').value;
    const idProduto = document.getElementById('id_produto').value;

    const endereco = {
        id_usuario: idUsuario,
        id_produto: idProduto,

    };
    fetch('/backend/VendaRouter.php', { 
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
            alert('Venda já existe!');
        } else {
            alert("Venda criada com sucesso!");
        } 
    })
    .catch(error => alert('Erro na requisição: ' + error));
})
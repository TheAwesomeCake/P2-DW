function displayVendaList(data) {
    const enderecoList = data.enderecos;  
    const enderecoDiv = document.getElementById('enderecoList');
    enderecoDiv.innerHTML = ''; 

    const list = document.createElement('ul');
    enderecoList.forEach(endereco => {
        const listItem = document.createElement('li');
        listItem.textContent = `${endereco.id} - ${endereco.cep} - ${endereco.rua} - ${endereco.bairro} - ${endereco.cidade} - ${endereco.uf}`;
        list.appendChild(listItem);
    });

    enderecoDiv.appendChild(list);
}
const getUserByIdSubmitBtn = document.getElementById('getUserByIdSubmitBtn');
getUserByIdSubmitBtn.addEventListener('click', function () {
    const userId = document.getElementById("getUserId").value;
    fetch('/backend/EnderecoRouter.php?userId=' + userId, {
        method: 'GET'
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
        displayVendaList(data);
    })
    .catch(error => alert('Erro na requisição: ' + error));
});

function displayVendaList(data) {
    const vendaList = data.vendas;  
    const vendaDiv = document.getElementById('vendaList');
    vendaDiv.innerHTML = ''; 

    const list = document.createElement('ul');
    vendaList.forEach(venda => {
        const listItem = document.createElement('li');
        listItem.textContent = `${venda.id} - ${venda.data_registro} - ${venda.id_usuario} - ${venda.id_produto}`;
        list.appendChild(listItem);
    });

    vendaDiv.appendChild(list);
}
function displayVendaListGraph(data) {
    let legendas = [];
    let valores = [];
    const vendas = data.vendas;
    vendas.forEach(venda => {
        legendas.push(venda.id_usuario);
        valores.push(venda.qtd_produtos);
    });
    const barColors = ["red", "green","blue","orange","brown"];
    new Chart("myChart", {
        // type: "bar",
        type: "pie",
        data: {
        labels: legendas,
        datasets: [{
            backgroundColor: barColors,
            data: valores
        }]
        },
        options: {
            legend: {display: false},
            title: {
                display: true,
                text: "Vendas cadastradas"
            }
        }
    });
}
function getVendaList() {
    fetch('/backend/VendaRouter.php', {
        method: 'GET'
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        } else {
            if (response.status === 401) {
                throw new Error('Não autorizado');
            } else {
                throw new Error('Sem rede ou não conseguiu localizar o recurso');
            }

        }
    })
    .then(data => {
        displayVendaList(data);
    })
    .catch(error => alert('Erro na requisição: ' + error));

    fetch('/backend/VendasPorUsuario', {
        method: 'GET'
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        } else {
            if (response.status === 401) {
                throw new Error('Não autorizado');
            } else {
                throw new Error('Sem rede ou não conseguiu localizar o recurso');
            }

        }
    })
    .then(data => {
        displayVendaListGraph(data);
    })
    .catch(error => alert('Erro na requisição: ' + error));
}
getVendaList();

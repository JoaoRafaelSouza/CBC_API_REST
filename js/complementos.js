function listarClubes() {
    fetch('index.php?rota=clubes')
        .then(response => response.json())
        .then(data => {
            const tabela = document.getElementById('tabela-clubes');
            tabela.innerHTML = '';

            if (Array.isArray(data)) {
                data.forEach(clube => {
                    tabela.innerHTML += `
                        <tr>
                            <td>${clube.id}</td>
                            <td>${clube.clube}</td>
                            <td>R$ ${parseFloat(clube.saldo_disponivel).toFixed(2)}</td>
                        </tr>`;
                });
            } else {
                tabela.innerHTML = `<tr><td colspan="3">Erro ao carregar dados.</td></tr>`;
            }
        })
        .catch(error => {
            document.getElementById('tabela-clubes').innerHTML =
                `<tr><td colspan="3">Erro: ${error}</td></tr>`;
        });
}

function cadastrarClube(event) {
    event.preventDefault();

    const nome = document.getElementById('clube').value;
    const saldo = document.getElementById('saldo').value;

    fetch('index.php?rota=clubes', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            clube: nome,
            saldo_disponivel: saldo
        })
    })
    .then(response => response.json())
    .then(data => {
        const div = document.getElementById('mensagemCadastro');
        if (data.mensagem) {
            div.innerHTML = `<div class="alert alert-success">${data.mensagem}</div>`;
            document.getElementById('formClube').reset();
            listarClubes(); // Atualiza a lista se quiser
        } else if (data.erro) {
            div.innerHTML = `<div class="alert alert-danger">${data.erro}</div>`;
        }
    })
    .catch(error => {
        document.getElementById('mensagemCadastro').innerHTML =
            `<div class="alert alert-danger">Erro: ${error}</div>`;
    });
}
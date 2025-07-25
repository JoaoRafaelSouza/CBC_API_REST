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
            // listarClubes();
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else if (data.erro) {
            div.innerHTML = `<div class="alert alert-danger">${data.erro}</div>`;
        }
    })
    .catch(error => {
        document.getElementById('mensagemCadastro').innerHTML =
            `<div class="alert alert-danger">Erro: ${error}</div>`;
    });
}

function cadastrarRecurso(event) {
    event.preventDefault();

    const nome = document.getElementById('recurso').value;
    const saldo = document.getElementById('saldoRecurso').value;

    fetch('index.php?rota=recursos', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            recurso: nome,
            saldo_disponivel: saldo
        })
    })
    .then(response => response.json())
    .then(data => {
        const div = document.getElementById('mensagemCadastroRecurso');
        if (data.mensagem) {
            div.innerHTML = `<div class="alert alert-success">${data.mensagem}</div>`;
            document.getElementById('formRecurso').reset();

            // Fechar o modal após sucesso
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalRecursos'));
                modal.hide();
                location.reload();
            }, 1000);
        } else if (data.erro) {
            div.innerHTML = `<div class="alert alert-danger">${data.erro}</div>`;
        }
    })
    .catch(error => {
        document.getElementById('mensagemCadastroRecurso').innerHTML =
            `<div class="alert alert-danger">Erro: ${error}</div>`;
    });
}

// Carrega clubes e recursos nos <select> ao abrir o modal de consumo
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modalConsumo');
    modal.addEventListener('show.bs.modal', () => {
        carregarSelect('clubes', 'clubeSelect', 'clube');
        carregarSelect('recursos', 'recursoSelect', 'recurso');
    });
});

function carregarSelect(rota, selectId, campoNome) {
    fetch(`index.php?rota=${rota}`)
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById(selectId);
            select.innerHTML = '<option value="">Selecione</option>';
            data.forEach(item => {
                select.innerHTML += `<option value="${item.id}">${item[campoNome]}</option>`;
            });
        })
        .catch(() => {
            document.getElementById(selectId).innerHTML = '<option value="">Erro ao carregar</option>';
        });
}

function consumirRecurso(event) {
    event.preventDefault();

    const clube_id = document.getElementById('clubeSelect').value;
    const recurso_id = document.getElementById('recursoSelect').value;
    const valor_consumo = document.getElementById('valorConsumo').value;

    fetch('index.php?rota=consumir', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ clube_id, recurso_id, valor_consumo })
    })
    .then(res => res.json())
    .then(data => {
        const div = document.getElementById('mensagemConsumo');
        if (data.erro) {
            div.innerHTML = `<div class="alert alert-danger">${data.erro}</div>`;
        } else {
            div.innerHTML = `
                <div class="alert alert-success">
                    O clube <strong>${data.clube}</strong> consumiu R$ ${valor_consumo}.
                    Saldo anterior: R$ ${data.saldo_anterior}.<br>
                    Saldo atual: <strong>R$ ${data.saldo_atual}</strong>.
                </div>`;
            document.getElementById('formConsumo').reset();

            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalConsumo'));
                modal.hide();
                location.reload(); // opcional
            }, 2500);
        }
    })
    .catch(err => {
        document.getElementById('mensagemConsumo').innerHTML =
            `<div class="alert alert-danger">Erro: ${err}</div>`;
    });
}
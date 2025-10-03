$(document).ready(function () {

    renderTamanhosDisponiveis()
    adicionarCarrinhoCokkie()
    renderCarrinho()

})

function renderTamanhosDisponiveis() {
    $("#cores").change(function () {
        const cor_id = $(this).val()
        $.ajax({
            url: "ajax/ajax.php",
            type: "POST",
            data: {
                action: "tamanho",
                produto_id: produto_id,
                cor_id: cor_id,
            },
            success: function (results) {
                const input_tamanhos = $("#tamanhos")
                input_tamanhos.children().not(":first").remove()
                results.forEach(function (tamanho) {
                    input_tamanhos.append(`<option value="${tamanho.tamanho_id}">${tamanho.tamanho}</option>`)
                })
            }
        })
    })

}

function adicionarCarrinhoCokkie() {
    let carrinho = getCokkie("carrinho") ?? []
    $("#btnAdicionar").click(function () {

        const produto = {
            id: produto_id,
            cor_id: $("#cores").val(),
            tamanho_id: $("#tamanhos").val(),
            quantidade: parseInt($("#quantidade").val()),
        }

        if (produto.quantidade > 0 && produto.cor_id && produto.tamanho_id) {
            const itemExistente = carrinho.find(function (item) {
                return item.id === produto.id &&
                    item.cor_id === produto.cor_id &&
                    item.tamanho_id === produto.tamanho_id
            })

            if (itemExistente) {
                itemExistente.quantidade += produto.quantidade
            } else {
                carrinho.push(produto)
            }

            document.cookie = `carrinho=${JSON.stringify(carrinho)}; max-age=604800; path=/; secure`;
            renderCarrinho()
        }
    })
}

function renderCarrinho() {
    const carrinho = getCokkie("carrinho");

    const ulCarrinho = $("#carrinho-ul");
    ulCarrinho.children().not(":nth-last-child(-n+2)").remove()

    if (!carrinho) {
        ulCarrinho.prepend(`<li class="text-muted"> Carrinho Vazio </li>`)
    }
    $.ajax({
        type: "POST",
        url: "ajax/ajax.php",
        data: {
            action: "carrinho",
            itens: carrinho
        },
        success: function (results) {
            results.forEach(function (item) {
                const totalProduto = item.valor * item.quantidade;
                ulCarrinho.prepend(`
                <li class="d-flex align-items-center mb-3">
                    <img src="${item.img}" class="me-3" style="width: 80px; height: auto;">
                    <div>
                        <h6 class="fw-bold">${item.nome} - ${item.cor} </h6>
                        <small>Tamanho: ${item.tamanho}</small><br>
                        <small>Quantidade: ${item.quantidade}</small><br>
                        <small class="text-muted">R$${totalProduto.toFixed(2).replace(".", ",")}</small>
                    </div>
                </li>`)
            })
        },
    })
}

function getCokkie(nome) {
    const cookies = document.cookie.split("; ")
    for (cookie of cookies) {
        const [chave, valor] = cookie.split("=");
        if (chave == nome) {
            return JSON.parse(valor)
        }
    }
    return null
}
window.onload = link();
$(document).ready(function () {
    totalCarrinho();
    listaCarrinho();
});
function listaCarrinho() {

    $.getJSON('ajax/listar-carrinho', function (data) {

        if (data.length >= 0) {
            var iten = '';
            for (var i = 0; i < data.length; i++) {
                iten += '<li>';
                iten += '<span class="item">';
                iten += '<span class="item-left">';
                iten += '<img alt="" src="' + data[i].img + '">';
                iten += '<span class="item-info">';
                iten += '<span> ' + data[i].nome + '</span>';
                iten += '<span> $R$ ' + data[i].preco + '</span>';
                iten += '</span>';
                iten += '</span>';
                iten += '<span class="item-right">';
                iten += '<a href="javascript:void(0);" onClick="removerCarrinho(' + data[i].cod_produto + ',1)" class="btn btn-xs btn-danger pull-right"> x </a>';
                iten += '</span>';
                iten += '</span>';
                iten += '</li>';
            }
        }
        iten += '<li class="divider"></li>';
        iten += '<li>';
        iten += "<a class='text-center' href='javascript:void(0);' onclick='carrinho_()'>Ver Carrinho</a>";
        iten += '</li>';
        $("#carrinho").html(iten);

    });
}

function totalCarrinho() {
    $.getJSON('ajax/total-carrinho', function (data) {
        $('#carrinho_total').text(data.total);
        //$('#carrinho_totalpg').text(data.total_pg);
        if (data.total != '0') {
            $('#carrinho_total').attr('class', 'badge progress-bar-warning');
        } else {
            $('#carrinho_total').toggleClass('progress-bar-warning ');
        }
    });
}
function carrinho_() {
    $("#conteudo").html("Carregando..");
    $("#conteudo").load('carrinho');
}

function link(link_pg) {
//listaCarrinho();
    if (link_pg != null && link_pg !== undefined) {
        $("#conteudo").html("Carregando..");
        $("#conteudo").load(link_pg);
    } else {
        $("#conteudo").load('index/principal');
    }
}

function addCart(id) {
    $('#carrinho_total').attr('class', 'badge progress-bar-danger');
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: "ajax/add-cart/",
        data: "id=" + id,
        success: function (data) {
            if (data.retorno == true) {
                $('#carrinho_total').text(data.total);
                $('#carrinho_total').attr('class', 'badge progress-bar-warning');
                listaCarrinho();
            } else {
                alert('Erro ao retornar dados, tente novamente mais tarde!');
            }
        },
        error: function (data) {
            alert('Erro: Serviço indisponivel, tente novamente mais tarde!');
        }
    });
}

function calcular_subtotal(id) {
    $('#subtotal_' + id).text('Calculando');
    var qtd = $('#qtd_' + id).val();
    if (qtd <= 0 || qtd == 0 || qtd == '') {
//removerCarrinho(id);
        qtd = 1;
    }

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: "ajax/calcular-item/",
        data: "id=" + id + "&qtd=" + qtd,
        success: function (data) {
            if (data.retorno == true) {
                $('#subtotal_' + id).text(data.subTotal);
                $('#qtd_' + id).text(data.id);
                $('#totalCompra').text(data.precoTotal);
                $('#totalCompra2').text(data.precoTotal);
            } else {
                alert('Erro ao retornar dados, tente novamente mais tarde!');
            }
        }
        ,
        error: function (data) {
            alert('Erro: Serviço indisponivel, tente novamente mais tarde!');
        }
    });
}

function removerCarrinho(id, atualizarCarrinho) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: "ajax/remover-item/",
        data: "id=" + id,
        success: function (data) {
            if (data.retorno == true) {
                $('#prod_' + id).fadeOut();
                totalCarrinho();
                listaCarrinho();
                if (atualizarCarrinho == '' || data.total == '0') {
                    carrinho_();
                }
            } else {
                alert('Erro ao retornar dados, tente novamente mais tarde!');
            }
        }
        ,
        error: function (data) {
            alert('Erro: Serviço indisponivel, tente novamente mais tarde!');
        }
    });
}
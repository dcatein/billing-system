@extends('layouts.app')

@section('page-title', 'Create Order')

@section('content')

    <div class="card">

        <div class="card-header">

            <h5>Nova Venda</h5>

        </div>

        <div class="card-body">


<form method="POST" action="{{ route('orders.store') }}">
    @csrf

    <!-- Vendedor -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Vendedor</label>
            <select name="user_id" class="form-select" required>
                <option value="">Selecione o vendedor</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Produtos -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Produtos</label>
            <select id="product-select" class="form-select">
                <option value="">Selecione um produto</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                        {{ $product->name }} (R$ {{ number_format($product->price, 2, ',', '.') }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Quantidade</label>
            <input type="number" id="product-qty" class="form-control" min="1" value="1">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" id="add-product" class="btn btn-secondary">Adicionar</button>
        </div>
    </div>

    <!-- Resumo dos itens -->
    <div class="row mb-3">
        <div class="col-md-12">
            <h5>Itens adicionados</h5>
            <table class="table table-sm" id="items-table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Qtd</th>
                        <th>Unitário</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Desconto e Total -->
    <div class="row mb-3">
        <div class="col-md-1">
            <label class="form-label">Tipo</label>
            <select id="discount-type" name="discount_type" class="form-select">
                <option value="valor">R$</option>
                <option value="percentual">%</option>
            </select>
        </div>
        <div class="col-md-1">
            <label class="form-label">Desconto</label>
            <input type="number" step="0.01" id="discount-value" name="discount_value" class="form-control" value="0">
        </div>
        <div class="col-md-2">
            <label class="form-label">Total</label>
            <input type="text" id="order-total" name="total" class="form-control" readonly>
        </div>
    </div>

    <!-- Pagamentos -->
    <div class="row mb-3">
        <div class="col-md-12">
            <h5>Pagamentos</h5>
            <div id="payments-container"></div>
            <button type="button" id="add-payment" class="btn btn-outline-primary">Adicionar pagamento</button>
        </div>
    </div>

    <div class="mt-4">
        <button class="btn btn-primary">Salvar</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const itemsTable = document.querySelector('#items-table tbody');
        const addProductBtn = document.getElementById('add-product');
        const productSelect = document.getElementById('product-select');
        const productQty = document.getElementById('product-qty');
        const discountType = document.getElementById('discount-type');
        const discountValue = document.getElementById('discount-value');
        const orderTotal = document.getElementById('order-total');

        function recalcTotal() {
            let subtotal = 0;
            itemsTable.querySelectorAll('tr').forEach(row => {
                subtotal += parseFloat(row.dataset.total);
            });

            let discount = parseFloat(discountValue.value) || 0;
            if (discountType.value === 'percentual') {
                discount = subtotal * (discount / 100);
            }

            const total = subtotal - discount;
            orderTotal.value = 'R$ ' + total.toFixed(2);
        }

        addProductBtn.addEventListener('click', function () {
            const productId = productSelect.value;
            const productName = productSelect.options[productSelect.selectedIndex].text;
            const unitPrice = parseFloat(productSelect.options[productSelect.selectedIndex].dataset.price);
            const qty = parseInt(productQty.value);

            if (!productId || qty <= 0) return;

            const total = unitPrice * qty;

            const row = document.createElement('tr');
            row.dataset.total = total;
            row.innerHTML = `
                <td>${productName}<input type="hidden" name="items[${productId}][product_id]" value="${productId}"></td>
                <td>${qty}<input type="hidden" name="items[${productId}][quantity]" value="${qty}"></td>
                <td>R$ ${unitPrice.toFixed(2)}<input type="hidden" name="items[${productId}][unit_price]" value="${unitPrice}"></td>
                <td>R$ ${total.toFixed(2)}<input type="hidden" name="items[${productId}][total]" value="${total}"></td>
                <td><button type="button" class="btn btn-sm btn-danger remove-item">Remover</button></td>
            `;
            itemsTable.appendChild(row);

            row.querySelector('.remove-item').addEventListener('click', function () {
                row.remove();
                recalcTotal();
            });

            recalcTotal();
        });

        discountType.addEventListener('change', recalcTotal);
        discountValue.addEventListener('input', recalcTotal);

        // Pagamentos
        const paymentsContainer = document.getElementById('payments-container');
        const addPaymentBtn = document.getElementById('add-payment');

        addPaymentBtn.addEventListener('click', function () {
            const index = paymentsContainer.children.length;
            const block = document.createElement('div');
            block.classList.add('border', 'p-3', 'mb-2');
            block.innerHTML = `
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class="form-label">Tipo de pagamento</label>
                        <select name="payments[${index}][method]" class="form-select payment-method">
                            <option value="dinheiro">Dinheiro</option>
                            <option value="pix">Pix</option>
                            <option value="cartao">Cartão de Crédito</option>
                        </select>
                    </div>
                    <div class="col-md-2 parcelas-block d-none">
                        <label class="form-label">Parcelas</label>
                        <input type="number" name="payments[${index}][installments]" class="form-control" min="1">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Valor pago</label>
                        <input type="number" step="0.01" name="payments[${index}][amount]" class="form-control" required>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-danger remove-payment">Remover pagamento</button>
            `;
            paymentsContainer.appendChild(block);

            // Mostrar parcelas apenas se for cartão
            const methodSelect = block.querySelector('.payment-method');
            const parcelasBlock = block.querySelector('.parcelas-block');
            methodSelect.addEventListener('change', function () {
                if (this.value === 'cartao') {
                    parcelasBlock.classList.remove('d-none');
                } else {
                    parcelasBlock.classList.add('d-none');
                }
            });

            block.querySelector('.remove-payment').addEventListener('click', function () {
                block.remove();
            });
        });
    });
</script>


        </div>
    </div>


@endsection
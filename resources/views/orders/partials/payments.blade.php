<!-- resources/views/orders/partials/payments.blade.php -->

<div class="row mb-3">
    <div class="col-md-12">
        <div id="payments-container"></div>
        <button type="button" id="add-payment" class="btn btn-outline-primary">Adicionar pagamento</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
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
                            <option value="money">Dinheiro</option>
                            <option value="pix">Pix</option>
                            <option value="credit-card">Cartão de Crédito</option>
                            <option value="debit-card">Cartão de Débito</option>
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
                if (this.value === 'credit-card') {
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

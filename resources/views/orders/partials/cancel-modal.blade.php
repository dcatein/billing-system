<div class="modal fade" id="cancelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-secondary text-white border-0 shadow-lg">
            <div class="text-end p-3">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pb-4">
                <h2 class="fw-bold mb-3 text-center">Confirmar Cancelamento</h2>
                <p class="mb-4 text-center">Deseja realmente cancelar este pedido? Informe o motivo abaixo:</p>

                <form id="cancel-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="cancel-reason" class="form-label">Motivo</label>
                        <textarea id="cancel-reason" name="cancel_reason" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Voltar</button>
                        <button type="submit" class="btn btn-dark px-4">Confirmar Cancelamento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const cancelModal = document.getElementById('cancelModal');
    const cancelForm = document.getElementById('cancel-form');

    cancelModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget; // botão que abriu o modal
    const orderId = button.getAttribute('data-order-id');

    cancelForm.action = `/orders/${orderId}/cancel`;
    });
    });
</script>

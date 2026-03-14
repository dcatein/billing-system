<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-success text-white border-0 shadow-lg">
            <div class="text-end p-3">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center pb-5">
                <div class="mb-4 text-success">
                    <i class="bi bi-check-circle-fill display-1"></i>
                </div>

                <h2 class="fw-bold mb-3 text-white">
                    {{ __('Registro realizado com sucesso!') }}
                </h2>

                <p class="mb-4 text-white">
                    {{ __('Seus dados foram salvos com sucesso.') }}
                </p>

                <button type="button" class="btn btn-light px-5 py-2" data-bs-dismiss="modal">
                    {{ __('Fechar') }}
                </button>
            </div>
        </div>
    </div>
</div>

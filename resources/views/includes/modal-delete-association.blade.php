<!-- Modal -->
<div class="modal fade" id="associationModal" tabindex="-1" aria-labelledby="associationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="associationModalLabel">Remover associação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Ao apagar ou remover a associação, não poderá mais fazer lançamentos nem visualizar este produto e
                </p>
                <p>Tem certeza que quer continuar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não apagar</button>
                <a type="button" class="btn btn-danger" href="{{ route('admin.associate.remove', [$company->id, $prod->id]) }}">Apagar</a>
            </div>
        </div>
    </div>
</div>

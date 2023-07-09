    <!-- Modal -->
    <div class="modal fade" id="yearModal" tabindex="-1" aria-labelledby="yearModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="yearModalLabel">Apagar Ano</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Ao remover o ano, removerá permanentemente todas as publicações associadas a ele, é um processo irreversível.</p>
                    <p>Tem certeza que quer continuar?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não apagar</button>
                    <a type="button" class="btn btn-danger"
                        href="{{ route('admin.year.delete', $year->id) }}">Apagar</a>
                </div>
            </div>
        </div>
    </div>

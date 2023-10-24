@vite('resources/css/app.css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

<div class="modal fade" id="editSpecificationModal" tabindex="-1" aria-labelledby="editSpecificationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSpecificationModalLabel">Rol Aanpassen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.specifications.update', ['specification' => 'id']) }}" method="post"
                    id="editSpecificationForm">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="name" class="form-label">Naam</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Opslaan">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#editSpecificationModal').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget);
        let statusId = button.data('id');
        let statusName = button.data('name');
        let modal = $(this);

        let form = modal.find('#editSpecificationForm');
        let action = form.attr('action').replace('id', statusId);
        form.attr('action', action);

        let nameInput = modal.find('#name');
        nameInput.val(statusName);
    });
</script>

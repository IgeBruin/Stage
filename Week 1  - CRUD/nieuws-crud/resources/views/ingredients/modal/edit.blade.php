@vite('resources/css/app.css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

<div class="modal fade" id="editIngredientModal" tabindex="-1" aria-labelledby="editIngredientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editIngredientModalLabel">Ingredient Aanpassen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.ingredients.update', ['ingredient' => 'ingredient_id']) }}" method="post"
                    id="editRoleForm">
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
    $('#editIngredientModal').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let name = button.data('name');
        let modal = $(this);

        let form = modal.find('#editRoleForm');
        let action = form.attr('action').replace('ingredient_id', id);
        form.attr('action', action);

        let nameInput = modal.find('#name');
        nameInput.val(name);
    });
</script>

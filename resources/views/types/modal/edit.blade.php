@vite('resources/css/app.css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

<div class="modal fade" id="editTypeModal" tabindex="-1" aria-labelledby="editTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTypeModalLabel">Type model Aanpassen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.types.update', ['type' => $type->id]) }}" method="post" id="editTypeForm">
                    @csrf
                    @method('put')
                    <input type="hidden" id="type_id" name="type_id" value="{{ old('type_id', $type->id) }}">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Naam</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" placeholder="Naam" value="{{ old('name', $type->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
    $(document).ready(function () {
        let modal = $('#editTypeModal');
        @if ($errors->any())
            let typeId = '{{ old("type_id") }}';
            if (typeId) {
                modal.modal('show');
                modal.data('type-id', typeId);
            }
        @endif

        modal.on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let typeId = button.data('id') || modal.data('type-id');
            let form = modal.find('#editTypeForm');
            modal.data('type-id', typeId);
            let action = '{{ route("dashboard.types.update", ["type" => "type_id"]) }}';
            action = action.replace('type_id', typeId);
            form.attr('action', action);
            document.getElementById('type_id').value = typeId;
            let nameInput = modal.find('#name');
            nameInput.val(button.data('name'));
        });

        $('#editTypeForm').on('submit', function (e) {
            e.preventDefault();
            let typeId = modal.data('type-id');
            this.action = '{{ route("dashboard.types.update", ["type" => "type_id"]) }}';
            this.action = this.action.replace('type_id', typeId);
            this.submit();
        });
    });
</script>




    

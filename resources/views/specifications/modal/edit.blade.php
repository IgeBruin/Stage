@vite('resources/css/app.css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

<div class="modal fade" id="editSpecificationModal" tabindex="-1" aria-labelledby="editSpecificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSpecificationModalLabel">Specificatie Aanpassen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.specifications.update', ['specification' => $specification->id]) }}" method="post" id="editSpecificationForm">
                    @csrf
                    @method('put')
                    <input type="hidden" id="specification_id" name="specification_id" value="{{ old('specification_id', $specification->id) }}">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Naam</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" placeholder="Naam" value="{{ old('name', $specification->name) }}">
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
        let modal = $('#editSpecificationModal'); 

        @if ($errors->any())
            let specificationId = '{{ old("specification_id") }}';
            if (specificationId) {
                modal.modal('show');
                modal.data('specification-id', specificationId);
            }
        @endif

        modal.on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let specificationId = button.data('id') || modal.data('specification-id');
            let form = modal.find('#editSpecificationForm'); 
            modal.data('specification-id', specificationId);
            let action = '{{ route("dashboard.specifications.update", ["specification" => "specification_id"]) }}';
            action = action.replace('specification_id', specificationId);
            form.attr('action', action);
            document.getElementById('specification_id').value = specificationId;
            let nameInput = modal.find('#name');
            nameInput.val(button.data('name'));
        });

        $('#editSpecificationForm').on('submit', function (e) { 
            e.preventDefault();
            let specificationId = modal.data('specification-id');
            this.action = '{{ route("dashboard.specifications.update", ["specification" => "specification_id"]) }}';
            this.action = this.action.replace('specification_id', specificationId);
            this.submit();
        });
    });
</script>





    

@vite('resources/css/app.css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

<div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBrandModalLabel">Merk Aanpassen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.brands.update', ['brand' => $brand->id]) }}" method="post" id="editBrandForm">
                    @csrf
                    @method('put')
                    <input type="hidden" id="brand_id" name="brand_id" value="{{ old('brand_id', $brand->id) }}">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Naam</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" placeholder="Naam" value="{{ old('name', $brand->name) }}">
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
        let modal = $('#editBrandModal');
        @if ($errors->any())
            let brandId = '{{ old("brand_id") }}';
            if (brandId) {
                modal.modal('show');
                modal.data('brand-id', brandId);
            }
        @endif

        modal.on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let brandId = button.data('id') || modal.data('brand-id');
            let form = modal.find('#editBrandForm');
            modal.data('brand-id', brandId);
            let action = '{{ route("dashboard.brands.update", ["brand" => "brand_id"]) }}';
            action = action.replace('brand_id', brandId);
            form.attr('action', action);
            document.getElementById('brand_id').value = brandId;
            let nameInput = modal.find('#name');
            nameInput.val(button.data('name'));
        });

        $('#editBrandForm').on('submit', function (e) {
            e.preventDefault();
            let brandId = modal.data('brand-id');
            this.action = '{{ route("dashboard.brands.update", ["brand" => "brand_id"]) }}';
            this.action = this.action.replace('brand_id', brandId);
            this.submit();
        });
    });
</script>




    

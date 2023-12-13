@vite('resources/css/app.css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

<div class="modal fade" id="editFuelModal" tabindex="-1" aria-labelledby="editFuelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFuelModalLabel">Brandstof Aanpassen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.fuels.update', ['fuel' => $fuel->id]) }}" method="post" id="editFuelForm">
                    @csrf
                    @method('put')
                    <input type="hidden" id="fuel_id" name="fuel_id" value="{{ old('fuel_id', $fuel->id) }}">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Naam</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" placeholder="Naam" value="{{ old('name', $fuel->name) }}">
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
        let modal = $('#editFuelModal');
        @if ($errors->any())
            let fuelId = '{{ old("fuel_id") }}';
            if (fuelId) {
                modal.modal('show');
                modal.data('fuel-id', fuelId);
            }
        @endif

        modal.on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let fuelId = button.data('id') || modal.data('fuel-id');
            let form = modal.find('#editFuelForm');
            modal.data('fuel-id', fuelId);
            let action = '{{ route("dashboard.fuels.update", ["fuel" => "fuel_id"]) }}';
            action = action.replace('fuel_id', fuelId);
            form.attr('action', action);
            document.getElementById('fuel_id').value = fuelId;
            let nameInput = modal.find('#name');
            nameInput.val(button.data('name'));
        });

        $('#editFuelForm').on('submit', function (e) {
            e.preventDefault();
            let fuelId = modal.data('fuel-id');
            this.action = '{{ route("dashboard.fuels.update", ["fuel" => "fuel_id"]) }}';
            this.action = this.action.replace('fuel_id', fuelId);
            this.submit();
        });
    });
</script>




    

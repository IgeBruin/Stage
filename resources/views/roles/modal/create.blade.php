    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoleModalLabel">Rol Aanmaken</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dashboard.roles.store') }}" method="post">
                        @csrf
                        @method('post')
                        <div class="mb-3">
                            <label for="name" class="form-label">Naam</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" placeholder="Naam" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="Toevoegen">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            let modal = $('#createRoleModal');
            
            @if ($errors->any())
                modal.modal('show');
            @endif
    
            modal.on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });
        });
    </script>

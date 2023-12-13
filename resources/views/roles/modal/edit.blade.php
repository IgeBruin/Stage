@vite('resources/css/app.css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Rol Aanpassen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.roles.update', ['role' => 'role_id']) }}" method="post"
                    id="editRoleForm">
                    @csrf
                    @method('put')
                    <input type="hidden" id="role_id" name="role_id" value="{{ old('role_id', $role->id) }}">

                    <div class="mb-3">
                        <label for="name" class="form-label">Naam</label>
                        <input type="text" class="form-control" id="name" name="name">
                        @if($errors->has('name'))
                            <div class="text-danger">{{ $errors->first('name') }}</div>
                        @endif
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
        let modal = $('#editRoleModal'); 

        @if ($errors->any())
            let roleId = '{{ old("role_id") }}'; 
            if (roleId) {
                modal.modal('show');
                modal.data('role-id', roleId);
            }
        @endif

        modal.on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let roleId = button.data('id') || modal.data('role-id');
            let form = modal.find('#editRoleForm');
            modal.data('role-id', roleId);
            let action = '{{ route("dashboard.roles.update", ["role" => "role_id"]) }}';
            action = action.replace('role_id', roleId);
            form.attr('action', action);
            document.getElementById('role_id').value = roleId;
            let nameInput = modal.find('#name');
            nameInput.val(button.data('name'));
        });

        $('#editRoleForm').on('submit', function (e) { 
            e.preventDefault();
            let roleId = modal.data('role-id');
            this.action = '{{ route("dashboard.roles.update", ["role" => "role_id"]) }}';
            this.action = this.action.replace('role_id', roleId);
            this.submit();
        });
    });
</script>


@vite('resources/css/app.css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">


<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-2" id="contactModalLabel">Contact aanbieder</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('contact.store') }}" method="POST" class="d-flex flex-column">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <label for="message" class="form-label">Uw opmerking of vraag</label>
                        <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message"
                            rows="4" placeholder="Hallo, Ik ben geïnteresseerd in jouw voertuig. Wil je zo snel mogelijk contact met mij opnemen?">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Uw naam</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" placeholder="Naam" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Uw E-mailadres</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                            id="email" name="email" placeholder="E-mailadres" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Uw telefoonnummer</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Telefoonnummer" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <input type="hidden" name="car_id" value="{{ $car->id }}">
                    <button type="submit" class=" btn btn-lg bg-primary text-white mt-auto align-self-end">Verstuur</button>
                </form>
                
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let modal = $('#contactModal');

        @if($errors->any())
            $(document).ready(function () {
                modal.modal('show');
            });
        @endif

        modal.on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
        });
    });
</script>

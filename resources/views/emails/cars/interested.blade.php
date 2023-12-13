

@component('mail::message')
Iemand heeft interesse getoond in uw auto "{{ $car->title }}" die te koop staat.

<b>Naam:</b> {{ $visitorName }} <br>
<b>Email:</b> {{ $visitorEmail }} <br>
<b>Telefoon:</b> {{ $visitorPhone }} <br>
<b>Reactie:</b> {!! $visitorMessage !!} <br>

<b>Auto:</b> {{ $car->title }} <br>
<b>Beschrijving:</b> {!! $car->description !!} <br>
<b>Jaar:</b> {{ $car->year }} <br>
<b>Kilometerstand:</b> {{ $car->mileage }} km <br>
<b>Prijs:</b> €{{ $car->price }} <br>

@component('mail::button', ['url' => route('showCar', ['car' => $car->id])])
Bekijk de auto
@endcomponent

Deze persoon is te bereiken via: <br>
<b>Email:</b> {{ $visitorEmail }} <br>
<b>Telefoon:</b> {{ $visitorPhone }} <br>

Met vriendelijke groet, Igenius
@endcomponent

@component('mail::message')
# Bedankt voor je bestelling

Je bestelling is geplaatst en wordt zo snel mogelijk verwerkt.

@component('mail::button', ['url' => route('user.showOrder', ['order' => $order->id])])
Bekijk je bestelling
@endcomponent


Bedankt voor het winkelen bij ons!

Met vriendelijke groet, Igenius
@endcomponent

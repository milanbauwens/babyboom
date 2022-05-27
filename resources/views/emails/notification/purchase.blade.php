@component('mail::message')
# Someone bought something of your wishlist!

## Product details
<hr>

<img src="{{ asset(public_path() . 'storage/' . $article->Image->path)}}" />

Name:<br>
{{$article->name}} <br>

Category:<br>
{{$article->Category->name}} <br>

Shop:<br>
{{$article->Shop->name}} <br>

Date:
{{date('m-d-Y h:i')}} <br>

## Wishlist details
<hr>

Name:<br>
{{$wishlist->name}} <br>

Expiration date:<br>
{{$wishlist->expiration_date}} <br>

## Guest details
<hr>

Name:<br>
{{$guest->firstname . ' ' . $guest->lastname}} <br>

Email:<br>
{{$guest->email}} <br>

<br>
{{ config('app.name') }}
@endcomponent

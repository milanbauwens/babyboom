<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin -scraped articles</title>
</head>
<body>
    <h1>Ikea Articles</h1>
    @foreach ($ikeaArticles as $article)
    <article>
        <h5>{{$article->title}}</h5>
        <p>{{$article->price}}</p>
        <p>{{$article->url}}</p>
        {{-- <img src="{{$article->img}}" /> --}}
        <p>{{$article->description}}</p>
        <p>{{$article->identifier}}</p>
    </article>
    @endforeach
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin - Scraper</title>
</head>
<body>
    <h1>Scrape products</h1>

    <form action="{{route('scrape.categories')}}" method="POST">
        @csrf
        <div class="div">
            <label for="shop">Webshop</label>
            <select name="shop" id="shop" >
                @foreach ($shops as $key => $shop)
                    <option value="{{$key}}">{{$shop}}</option>
                @endforeach
            </select>
        </div>
        <div class="div">
            <label for="url">Url collection</label>
            <input type="url" required name="url" id="id" placeholder="e.g. http://bol.com/speelgoed">
        </div>
        <div class="div">
            <button type="submit">Scrape categories</button>
        </div>
    </form>

    <table>
        @foreach ($categories as $category )
            <tr>
                <td>{{$category->name}}</td>
                <td>
                    <form action="{{ route('scrape.articles') }}" method="POST">
                        @csrf
                        <input type="hidden" name="url" value="{{$category->url}}">
                        <input type="hidden" name="shop" value="ikea">
                        <button type="submit">Scrape all articles</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>

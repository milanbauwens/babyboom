<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <link rel="stylesheet" href={{ asset('css/app.css')}}>
    <title>Babyboom</title>
</head>
<body>
    <main class="landing">
        <div class="landing__container">
            <img class="landing__img" src="images/landingpage.png" alt="https://www.freepik.com/vectors/different-ages'>Different ages vector created by pch.vector - www.freepik.com">
            <div class="landing__inner">
                <div class="landing__text">
                    <h1 class="landing__header">Welcome to <span class="landing__header--pink">babyboom</span></h1>
                    <p class="landing__paragraph">Create birthlists so friends and family know what to buy for your newborn!</p>
                </div>
                <div class="landing__actions">
                    <a class="button__login" href="{{route('login')}}">Log in</a>
                    <a class="button__register" href="{{route('register')}}">Sign up</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

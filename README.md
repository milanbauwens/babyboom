<img src="public/192x192.png">



# Babyboom 

## Link to site

[Link to babyboom](http://babyboom.milanbauwens.be)

## What is the application about

Babyboom is an application designed to help young families create wishlists which they can share with their family and friends. The application provides products from May Mays, Bollebuik and Mimi Baby which users can add to their wishlists. A wishlist can be visited without logging in. 

This application provides a section for authenticated users:
- create wishlists
- add products to wishlists
- add products to favorites
- change user information
- search products

There is also a section for guests, which is made for family and friends from the user. This section can be entered with a password choses by the user who made the wishlist. This section contains: 
- wishlist detail with all the products added by the user
- product basket
- payment page with Mollie

This app is made purely for educational purposes.

## Authors

- [@milanbauwens](https://www.instagram.com/milanbauwens)


## Prerequisites

- PHP8.0 or higher
- MySQL

## Built with

- Laravel 9
- SASS
- Composer
- MySQL
- Mollie

## Deployment

Clone the repository and go to {application directory} directory

```bash
git clone https://github.com/{username}/{repository name}.git

cd {application directory}
```


To deploy this project run

```bash
  npm run deploy
```

Generate .env file

```bash
cp .env.example .env
```

Then, configure the .env file according to your use case.

Install the dependencies and then compile the assets

```bash
composer install

npm install
npm run dev
```

Populate the tables of the database

```bash
php artisan migrate
```

Generate app key

```bash
php artisan key:generate
```

Run the application

```bash
php artisan serve
```

Finally, visit http://localhost:8000 to see the site.
## License

Distributed under the [MIT](https://choosealicense.com/licenses/mit/) License. See LICENSE for more information.


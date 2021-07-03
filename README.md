# TurnoverBnb ProductList Challenge API

This project was built using laravel as an backend api for [the frontend webapp](https://github.com/williamtcastro/TurnoverBNB-Challenge-WebAPP).

The deployed app is avialable [at this link](https://turnoverbnb-api.herokuapp.com/api/)

## Routes avialable in this api

-   get - `/api/product` - return an array of products
-   get - `/api/prodcut/{id}` - return specified product and its quantity history
-   post - `/api/product` - create new product
-   post - `/api/product/bulk` - create many new products
-   put - `/api/product/{id}` - update the specified product
-   put - `/api/product/bulk` - updata many products
-   post - `/api/product/bulk` - create many new products
-   delete - `/api/product/{id}` - delete the specified product
-   delete - `/api/product/bulk` - delete many products

---

## Commands to set up the server

Install dependencies

```
composer install
```

Copy example .env file

```
cp .env.example .env
```

Generate new key

```
php artisan key:generate
```

Create a new database

Update the .env file according to your database config\
 Example: `DB_DATABASE= test_api`

Run migrations with seed:

```
php artisan migrate --seed
```

Run server localy:

```
php artisan serve
```

---

## Run automated tests

```
vendor/bin/phpunit
```

### Avialable automated feature tests
- `test_get_products` - test if can get an array of products
- `test_creat_single_product` - test if can create a single product
- `test_get_single_product` - test if can get a single product
- `test_update_single_product` - test if can update a single product
- `test_delete_single_product` - test if can delete a single product
- `test_delete_bulk_product` - test if can delete many products
- `test_create_bulk_product` - test if can create many products
- `test_update_bulk_product` - test if can update many products

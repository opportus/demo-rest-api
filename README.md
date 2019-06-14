Demo Symfony 4 REST API using HAL as hypermedia format standard.

## Installation

### Step 1 - Clone And Compose The Application

Clone the repository:
```shell
git clone https://github.com/opportus/demo-rest-api.git path/to/my/project
```

Change the working directory:
```shell
cd path/to/my/project
```

Install dependencies:
```shell
composer install
```

### Step 2 - Configure The Application

Configure Doctrine:

https://symfony.com/doc/current/doctrine.html#configuring-the-database

### Step 3 - Load Intitial Data To The Application Database

Create the database:
```shell
php bin/console doctrine:database:create
```

Create the database schema:
```shell
php bin/console doctrine:schema:create
```

Load fixtures:
```shell
php bin/console doctrine:fixtures:load
```

## API Documentation

### Authentication

Authentication is done on each request to the API and is required in order to run any operation. The API's authentication system uses Google OAuth 2.0 as authentication provider. In order to get authenticated, you have to send in your requests to the API an `X-AUTH-TOKEN` header field having as value your Google access token (obtained for example via [OAuth Playground](https://developers.google.com/oauthplayground)). An access token with the minimal `email` scope is all the API's authentication system needs.

If the email of the Google account for which the access token has been generated matches the username of a registered user, you get authenticated as this user. Otherwise you get a `403` response status code.

### Authorization

There are 2 levels of authorization:

1. To each authenticated user is granted the first level of authorization allowing access to a limited set of operations.
2. To each authenticated user belonging to the *BileMo* Business is granted the second level of authorization allowing access to the whole set of operations.

We refer to the actor having the first level of authorization as to the *client* and we refer to the actor having the second level of authorization as to the *admin*.

### Operation List

All operations listed below return a response with `application/hal+json` content type **except** if the response has a `400` status code; in this case the response has an `application/vnd+json` content type.

| Operation                                       | Decription                                                | Actor          | Response Status Code             |
|-------------------------------------------------|-----------------------------------------------------------|----------------|----------------------------------|
| GET products                                    | Gets a list of products.                                  | Admin\|Client  | `200`\|`400`\|`403`\|`404`       |
| GET products/{id}                               | Gets a specific product.                                  | Admin\|Client  | `200`\|`403`\|`404`              |
| POST products                                   | Posts a new product.                                      | Admin          | `201`\|`400`\|`403`\|`415`       |
| PATCH products/{id}                             | Patches a specific product.                               | Admin          | `204`\|`400`\|`403`\|`404`|`415` |
| DELETE products/{id}                            | Deletes a specific product.                               | Admin          | `204`\|`403`\|`404`              |
| GET users                                       | Gets a list of users.                                     | Admin          | `200`\|`400`\|`403`\|`404`       |
| GET users/{id}                                  | Gets a specific user.                                     | Admin          | `200`\|`403`\|`404`              |
| POST users                                      | Posts a new user.                                         | Admin          | `201`\|`400`\|`403`\|`415`       |
| DELETE users/{id}                               | Deletes a specific user.                                  | Admin          | `204`\|`403`\|`404`              |
| GET businesses                                  | Gets a list of businesses.                                | Admin          | `200`\|`400`\|`403`\|`404`       |
| GET businesses/{id}                             | Gets a specific business.                                 | Admin\|Client* | `200`\|`403`\|`404`              |
| POST businesses                                 | Posts a new business.                                     | Admin          | `201`\|`400`\|`403`\|`415`       |
| DELETE businesses/{id}                          | Deletes a specific business.                              | Admin          | `204`\|`403`\|`404`              |
| GET businesses/{business_id}/users              | Gets a list of users belonging to a specific business.    | Admin\|Client* | `200`\|`400`\|`403`\|`404`       |
| GET businesses/{business_id}/users/{user_id}    | Gets a specific user belonging to a specific business.    | Admin\|Client* | `200`\|`403`\|`404`              |
| POST businesses/{business_id}/users             | Posts a new user belonging to a specific business.        | Admin\|Client* | `201`\|`400`\|`403`\|`415`       |
| DELETE businesses/{business_id}/users/{user_id} | Deletes a specific user belonging to a specific business. | Admin\|Client* | `204`\|`403`\|`404`              |

*Client\* can only access to his own business.*

### Request Body Models

The system expects requests body to be formated in JSON, otherwise it returns a `415` response.

`POST products` request body model ([`ProductPostRequestBodyModel`](https://github.com/opportus/demo-rest-api/blob/master/src/HttpMessageBodyModel/ProductPostRequestBodyModel.php)):

```json
{
    "gtin14": "11111111111111",
    "price": 1024.16,
    "priceCurrency": "EUR"
}
```

- `gtin14`: asserted by [`Constraints\GtinValidator`](https://github.com/opportus/demo-rest-api/blob/master/src/Validator/Constraints/GtinValidator.php).
- `price`: asserted by [`Constraints\PriceValidator`](https://github.com/opportus/demo-rest-api/blob/master/src/Validator/Constraints/PriceValidator.php).
- `priceCurrency`: asserted by [`Constraints\CurrencyValidator`](https://github.com/symfony/symfony/blob/4.4/src/Symfony/Component/Validator/Constraints/CurrencyValidator.php).

`PATCH products/{id}` request body model (either of both of the properties) ([`ProductPatchRequestBodyModel`](https://github.com/opportus/demo-rest-api/blob/master/src/HttpMessageBodyModel/ProductPatchRequestBodyModel.php)):

```json
{
    "price": 1024.16,
    "priceCurrency": "EUR"
}
```

- `price`: asserted by [`Constraints\PriceValidator`](https://github.com/opportus/demo-rest-api/blob/master/src/Validator/Constraints/PriceValidator.php).
- `priceCurrency`: asserted by [`Constraints\CurrencyValidator`](https://github.com/symfony/symfony/blob/4.4/src/Symfony/Component/Validator/Constraints/CurrencyValidator.php).

`POST users` request body model ([`UserPostRequestBodyModel`](https://github.com/opportus/demo-rest-api/blob/master/src/HttpMessageBodyModel/UserPostRequestBodyModel.php)):

```json
{
    "username": "example@gmail.com",
    "business": "298375b0-f702-4e61-a517-d9cd80c12472"
}
```

- `username`: asserted by [`Constraints\EmailValidator`](https://github.com/symfony/symfony/blob/4.4/src/Symfony/Component/Validator/Constraints/EmailValidator.php).
- `business`: asserted by [`Constraints\InclusiveEntityValidator`](https://github.com/opportus/ExtendedFrameworkBundle/blob/master/Validator/Constraints/InclusiveEntityValidator.php).

`POST businesses` request body model ([`BusinessPostRequestBodyModel`](https://github.com/opportus/demo-rest-api/blob/master/src/HttpMessageBodyModel/BusinessPostRequestBodyModel.php)):

```json
{
    "name": "BileMo"
}
```

- `name`: asserted by [`Constraints\ExclusiveEntityValidator`](https://github.com/opportus/ExtendedFrameworkBundle/blob/master/Validator/Constraints/ExclusiveEntityValidator.php).

`POST businesses/{business_id}/users` request body model ([`BusinessUserPostRequestBodyModel`](https://github.com/opportus/demo-rest-api/blob/master/src/HttpMessageBodyModel/BusinessUserPostRequestBodyModel.php)):

```json
{
    "username": "example@gmail.com"
}
```

- `username`: asserted by [`Constraints\EmailValidator`](https://github.com/symfony/symfony/blob/4.4/src/Symfony/Component/Validator/Constraints/EmailValidator.php).

### Request Query Models

The `GET products` query model is constrained by: [`Constraints\ProductCollectionQuery`](https://github.com/opportus/demo-rest-api/blob/master/src/Validator/Constraints/ProductCollectionQuery.php)

The `GET users` query model is constrained by: [`Constraints\UserCollectionQuery`](https://github.com/opportus/demo-rest-api/blob/master/src/Validator/Constraints/UserCollectionQuery.php)

The `GET businesses` query model is constrained by: [`Constraints\BusinessCollectionQuery`](https://github.com/opportus/demo-rest-api/blob/master/src/Validator/Constraints/BusinessCollectionQuery.php)

The `GET businesses/{business_id}/users` query model is constrained by: [`Constraints\BusinessUserCollectionQuery`](https://github.com/opportus/demo-rest-api/blob/master/src/Validator/Constraints/BusinessUserCollectionQuery.php)
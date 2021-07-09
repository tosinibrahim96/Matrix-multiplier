# Matrix multiplier API

> Laravel application for Matrix multiplication. The app features a REST API with authentication.


### Clone

- Clone the repository using `git clone https://github.com/tosinibrahim96/Matrix-multiplier.git`
- Create a `.env` file in the root folder and copy everything from `.env-sample` into it
- Fill the `.env` values with your Database details as required


### Setup

- Download WAMP or XAMPP to manage APACHE, MYSQL and PhpMyAdmin. This also installs PHP by default. You can follow [this ](https://youtu.be/h6DEDm7C37A)tutorial
- Download and install [composer ](https://getcomposer.org/)globally on your system

> install all project dependencies and generate application key

```shell
$ composer install
$ php artisan key:generate
```
> migrate all tables and seed required data into the database

```shell
$ php artisan migrate:fresh --seed
```
> start your Apache server and MySQL on WAMP or XAMPP interface
> serve your project using the default laravel PORT or manually specify a PORT

```shell
$ php artisan serve (Default PORT)
$ php artisan serve --port={PORT_NUMBER} (setting a PORT manually)
```


### Available Endpoints

<details><summary class="section-title">POST <code>/api/v1/register</code> -> Create a new account </summary>

<div class="collapsable-details">
<div class="json-object-array">
	<pre>{
Headers
&nbsp; "Accept":"application/json",
Body
&nbsp; "name": Firstname Lastname,
&nbsp; "email":"fnamelname@gmail.com",
&nbsp; "password": "randompassword,
&nbsp; "password_confirmation":"randompassword"
}</pre>
<pre>
Sample response
&nbsp; "status": 201,
&nbsp; "data": {
          "user": {
            "id": 25,
            "name": "Second account",
            "email": "secondaccount@gmail.com",
            "created_at": "2021-06-13T12:23:47.000000Z"
          },
          "token": "9|23AejhmabdkrAgTH5tEEJSzpF9zXnLrpmWeNtjbs"
        },

&nbsp; "message": "Account Created Successfully."
</pre>
</div>
</div>
</details>

<details><summary class="section-title">POST <code>/api/v1/login</code> -> Login into created account </summary>

<div class="collapsable-details">
<div class="json-object-array">
	<pre>{
Headers
&nbsp; "Accept":"application/json",
Body
&nbsp; "email": "fnamelname@gmail.com",
&nbsp; "password":"randompassword"
}</pre>
<pre>
Sample response
&nbsp; "status": 200,
&nbsp; "data": {
          "user": {
            "id": 25,
            "name": "Second account",
            "email": "secondaccount@gmail.com",
            "created_at": "2021-06-13T12:23:47.000000Z"
          },
          "token": "9|23AejhmabdkrAgTH5tEEJSzpF9zXnLrpmWeNtjbs"
        },

&nbsp; "message": "Login Successful."
</pre>
</div>
</div>
</details>

<details><summary class="section-title">POST <code>/api/v1/logout</code> -> Logout of your account </summary>

<div class="collapsable-details">
<div class="json-object-array">
	<pre>{
Headers
&nbsp; "Authorization":"Bearer $token",
&nbsp; "Accept":"application/json",
}</pre>
<pre>
Sample response
&nbsp; "status": 200,
&nbsp; "data":[],
&nbsp; "message": "Logout Successful."
</pre>
</div>
</div>
</details>

<details><summary class="section-title">POST <code>/api/v1/matrix/multiply</code> -> Multiply matrices and generate resulting matrix </summary>

<div class="collapsable-details">
<div class="json-object-array">
	<pre>{
Headers
&nbsp; "Authorization":"Bearer $token",
&nbsp; "Accept":"application/json",
Body
&nbsp; "matrix1_row_count":2,
&nbsp; "matrix1_column_count":3,
&nbsp; "matrix2_row_count":3,
&nbsp; "matrix2_column_count":4,
&nbsp; "matrix1_data":[1,1,1,2,2,2],
&nbsp; "matrix2_data":[1,4,7,10,2,5,8,11,3,6,9,12]
}</pre>
<pre>
Sample response
&nbsp; "status": 200,
&nbsp; "data": {
          "matrix": [
              ["F","O","X","AG"],
              ["L","AD","AV","BN"]
          ],
          "rows_count": 2,
          "columns_count": 4
        },
&nbsp; "message": "New Matrix Generated Successfully."
</pre>
</div>
</div>
</details>


### License

- **[MIT license](http://opensource.org/licenses/mit-license.php)**
- Copyright 2021 © <a href="https://tosinibrahim96.github.io/Resume/" target="_blank">Ibrahim Alausa</a>.

<h1 align="center">
    PMSoyer Framework
</1h>

<p align="center">
    <a href="https://packagist.org/packages/soyer/framework">
        <img src="https://img.shields.io/packagist/dt/soyer/framework" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/soyer/framework">
        <img src="https://img.shields.io/packagist/v/soyer/framework" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/soyer/framework">
        <img src="https://img.shields.io/badge/PHP-7.4.30-blue" alt="PHP Version">
    </a>
    <a href="https://packagist.org/packages/soyer/framework">
        <img src="https://img.shields.io/github/license/mantvmass/PMSoyer" alt="License">
    </a>
</p>


## About PMSoyer

This is a PHP Web framework, Quick and easy to use.


<!-- ## Installation
```shell
composer require soyer/framework -s dev
``` -->

## Donation
Your donation will help us budget to develop the framework. Thank you.
- **Thai Bank & E-Payment**
  - Kasikorn Bank ```0608905863```
- **Cryptocurrency Wallet**
  - USDT ( Network: BEP20 ) ```0x2d0db066a033361bcb709976104eede3443415a4```
  - Bitcoin ( Network: BTC ) ```1Kxj79HHV87ENyYB4Fvmdwu2pvacfKvFPx```
  - BNB ( Network: BEP20 ) ```0x2d0db066a033361bcb709976104eede3443415a4```

  
## Guide 
 
**Docs:** [**soon**](https://github.com/PMSoyer)

#### Routing
```php
    use Soyer\PMSoyer as app;
    use Soyer\Http\Request as request;

    app::route('/', ["GET"], function() {
        echo "Hello World!"
    });
    // req: 127.0.0.1:5000/
    // res: Hello World!

    app::route('/<username>/setting', ["GET"], function($username) {
        echo $username . "<br>";
    });
    // req: 127.0.0.1:5000/mantvmass/setting
    // res: mantvmass

    app::route('/admin/panel', ["GET", "POST"], function(){
        $role = false;
        if(!$role){
            abort(403, "Forbidden");
        }
    });
    // req: 127.0.0.1:5000/admin/panel
    // res: Error 403: Forbidden
    // You can custom error page by app::errorHandler(statusCode, callfunction)

	app::route('/redirect', ["GET", "POST"], function(){
        if(request::args["next"] == "go")
            return redirect("/");
    });
    // req: 127.0.0.1:5000/redirect?next=go
    // res: redirect to route("/")

    app::errorHandler(403, function(){
        echo "This is custom error page for 403"; 
    });

    app::errorHandler(404, function(){
        echo "404 Page not found!."; 
    });

    // Run Application //
    request::handleRequest();
    app::listen(request::$path, request::$method);
```

#### Routing and Middleware
```php
    use Soyer\PMSoyer as app;
    use Soyer\Http\Request as request;


    // function middleware
    $func_isLogin = function () {
        abort(401, "Unauthorized");
    }
    app::route('/function', ["GET"], function() {
        echo "Hello World";
    }, [ [$func_isLogin] ]);


    // class middleware
    class ClassAuth {
        public static function isLogin(){
            abort(401, "Unauthorized");
        }
    }
    app::route('/class', ["GET"], function() {
        echo "Hello World";
    }, [ [ClassAuth::class, "isLogin"] ]);


    // multiple use
    app::route('/class', ["GET"], function() {
        echo "Hello World";
    }, [ [$func_isLogin], [ClassAuth::class, "isLogin"] ]);
```

#### Routing and Template
```php
    use Soyer\PMSoyer as app;
    use Soyer\Http\Request as request;

    app::route('/', ["GET"], function() {
        return render_template('welcome.twig', ['title' => 'PMSoyer Framework']);
    });
```

#### Templates (  Twig Template Engine 3.5.1 )
> Read More: [Twig Documents](https://twig.symfony.com/doc/3.x/)
```twig
<!-- welcome.twig or welcome.twig.html -->
<html>
    <body>
        <h1> {{ title }} </h1>
    </body>
</html>
```

## License
The PMSoyer framework is open-sourced software licensed under the [MIT license](https://github.com/mantvmass/PMSoyer/blob/main/LICENSE).
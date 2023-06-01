# Auduct Framework
![GitHub](https://img.shields.io/github/license/mantvmass/auduct-framework)
<img src="https://img.shields.io/badge/PHP-7.4.30-blue">


This is a PHP Web framework, Quick and easy to use.

> <h2>Illuminati</h2><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Illuminati_triangle_eye.png/576px-Illuminati_triangle_eye.png" width="180" >

## Required
- Twig Template Engine 3.5.1

## Installation
**Composer:** [**Download**](https://getcomposer.org/download/)  
Create file composer.json in root project and paste the example below
```json
{
  "minimum-stability": "dev"
}
```
After that, use the command below to install the framework.
```shell
composer require auduct/framework
```
or install with **Project Structure:** [**Download**](https://github.com/mantvmass/auduct/archive/refs/heads/main.zip) 

## Donation
Your donation will help us budget to develop the framework. Thank you.
- **Thai Bank & E-Payment**
  - Kasikorn Bank ```0608905863```
- **Cryptocurrency Wallet**
  - USDT ( Network: BEP20 ) ```0x2d0db066a033361bcb709976104eede3443415a4```
  - Ethereum ( Network: ERC20 ) ```0x2d0db066a033361bcb709976104eede3443415a4```
  - Bitcoin ( Network: BTC ) ```1Kxj79HHV87ENyYB4Fvmdwu2pvacfKvFPx```
  - BNB ( Network: BEP20 ) ```0x2d0db066a033361bcb709976104eede3443415a4```
  - Monero ( Network: XMR ) ```8ARwh4HUH2Z7DCAwWyEHwD5p3wsTnUX65PKdpSZqAH2deh9wsnp4pQ256HLKpxeDxwfkrLfEFSYNv5aKruED8Mi416tx6RD```
  - Dogecoin ( Network: DOGE ) ```DGq7QhcfQRSovVcGKotJinMNE2ki4bJWdH```
  
## Guide 
 
**Project Example:** [**See**](https://github.com/mantvmass/auduct)

#### Basic Routing
```php
    use Illuminati\Auduct as app;
    use Illuminati\Http\Request as request;

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

#### Basic Template
```php
    use Illuminati\Auduct as app;
    use Illuminati\Http\Request as request;

    app::route('/', ["GET"], function() {
        return render_template('welcome.twig', ['title' => 'Auduct Framework']);
    });
```

#### Routing and Template ( Twig Default )
```php
    use Illuminati\Auduct as app;
    use Illuminati\View\Template;
    use Illuminati\View\TemplateFileSystemLoader;

    $loader = new TemplateFileSystemLoader('templates/');
    $page = new Template($loader);

    app::route('/', ["GET"], function() use($page) {
        echo $page -> render('welcome.twig', ['title' => 'Auduct Framework']);
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

## Features
This is only part  
"-------------------------------------------------------------------------------------------------"
- ClassName: **Auduct**
- ClassConstructor: **No**
- ClassGlobalParms: **No**

|      Method         |           ParamType         |           Param              |  Details     |
|     :--------       |           --------          |         ---------:           |  ---------:  |
|      route()        |   string, array, callable   |   $path, $methods, $func     |  Coming soon |
|   errorHandler()    |        int, callable        |     $statusCode, $func       |  Coming soon |
|      listen()       |        string, string       |        $path, $method        |  Coming soon |

"-------------------------------------------------------------------------------------------------"
- ClassName: **Request**
- ClassConstructor: **No**
- ClassGlobalParms: **string: $method, string: $path, string: $full_path, array: $form, array: $args, array: $files**

|      Method         |           ParamType         |           Param              |  Details     |
|     :--------       |           --------          |         ---------:           |  ---------:  |
|   handleRequest()   |               -             |              -               |  Coming soon |

"-------------------------------------------------------------------------------------------------"

- Other functions that are not in the class

|      Function       |           ParamType         |           Param              |  Details     |
|     :--------       |           --------          |         ---------:           |  ---------:  |
|  render_template()  |         string, array       |       $name, $context        |  Coming soon |
|     redirect()      |          string, int        |      $to, $statusCode        |  Coming soon |
|      abort()        |          int, string        |    $statusCode, message      |  Coming soon |


## License
[Apache License, version 2.0](https://github.com/mantvmass/Auduct/blob/main/LICENSE.md)

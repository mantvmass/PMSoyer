# Auduct Framework
PHP Web Framework  
> Illuminati 👩‍💻👩‍💻 <br>
> <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Illuminati_triangle_eye.png/576px-Illuminati_triangle_eye.png" width="40" > 

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
  - Prompt Pay ```0639723211```
- **Cryptocurrency Wallet**
  - USDT ( Network: BEP20 ) ```0x2d0db066a033361bcb709976104eede3443415a4```
  - Ethereum ( Network: ERC20 ) ```0x2d0db066a033361bcb709976104eede3443415a4```
  - Bitcoin ( Network: BTC ) ```1Kxj79HHV87ENyYB4Fvmdwu2pvacfKvFPx```
  - BNB ( Network: BEP20 ) ```0x2d0db066a033361bcb709976104eede3443415a4```
  - Monero ( Network: XMR ) ```8ARwh4HUH2Z7DCAwWyEHwD5p3wsTnUX65PKdpSZqAH2deh9wsnp4pQ256HLKpxeDxwfkrLfEFSYNv5aKruED8Mi416tx6RD```
  - Dogecoin ( Network: DOGE ) ```DGq7QhcfQRSovVcGKotJinMNE2ki4bJWdH```
  
## Examples
 
**Project Example:** [**See**](https://github.com/mantvmass/auduct)

#### Routing
```php
    use Illuminati\Auduct;
    
    $app = new Auduct();

    $app::route("/", ["GET", "POST"], function(){
        echo "Hello World";
    })
    // request url = 127.0.0.1/
    // output Hello World

    $app::route("/hi/:name", ["GET", "POST"], function() use($app){
        echo "Hi " . $app::params["name"];
    })
    // request url = 127.0.0.1/hi/Jack
    // output Hi Jack

    $app::route("/hi", ["GET", "POST"], function() use($app){
        echo "Hi " . $app::params["name"];
    })
    // request url = 127.0.0.1/hi?name=Jack
    // output Hi Jack
```

#### Routing and Template ( Twig Mod )
```php
    use Illuminati\Auduct;

    $app = new Auduct();

    $app::route('/', ["GET"], function() {
        return render_template('welcome.html.twig', ['title' => 'Auduct Framework']);
    });
```

#### Routing and Template ( Twig Default )
```php
    use Illuminati\Auduct;
    use Illuminati\View\Template;
    use Illuminati\View\TemplateFileSystemLoader;

    $app = new Auduct();

    $loader = new TemplateFileSystemLoader('templates/');
    $page = new Template($loader);

    $app::route('/', ["GET"], function() use($app, $page) {
        echo $page -> render('welcome.html.twig', ['title' => 'Auduct Framework']);
    });
```

#### Templates (  Twig Template Engine 3.5.1 )
> Read More: [Twig Documents](https://twig.symfony.com/doc/3.x/)
```html
<!-- welcome.html.twig -->
<html>
    <body>
        <h1> {{ title }} </h1>
    </body>
</html>
```

## Features
This is only part
| Class | Constructor |  Function | Parameters | Details |
| :-------- | :--------: | ---------: | ---------: | ---------: |
|  Auduct   |   $templates_path   |    route()   |    string, array, callback   | Coming soon |
|  -------  |   null   |    render_template()   |    string, array   |  Coming soon |

## License
[Apache License, version 2.0](https://github.com/mantvmass/Auduct/blob/main/LICENSE.md)

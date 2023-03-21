# Auduct Framework
PHP Web Framework
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
## Donation
Your donation will help us budget to develop the framework. Thank you.
- **Thai Bank & E-Payment**
  - Kasikorn Bank ```0608905863```
  - Prompt Pay ```0639723211```
- **Cryptocurrency Wallet**
  - USDT(Network: BEP20) ```0x2d0db066a033361bcb709976104eede3443415a4```
  - Ethereum(Network: ERC20) ```0x2d0db066a033361bcb709976104eede3443415a4```
  - Bitcoin((Network: BTC) ```1Kxj79HHV87ENyYB4Fvmdwu2pvacfKvFPx```
  - BNB(Network: BEP20) ```0x2d0db066a033361bcb709976104eede3443415a4```
  - Monero(Network: XMR) ```8ARwh4HUH2Z7DCAwWyEHwD5p3wsTnUX65PKdpSZqAH2deh9wsnp4pQ256HLKpxeDxwfkrLfEFSYNv5aKruED8Mi416tx6RD```
  - Dogecoin(Network: DOGE) ```DGq7QhcfQRSovVcGKotJinMNE2ki4bJWdH```
  
## Examples
**Project structure:** [**Download**](https://github.com/mantvmass/auduct/archive/refs/heads/main.zip)  
**Examples:** [**See**](https://github.com/mantvmass/auduct)  
Routing
```php
  use Illuminati\Routing\Router;
  
  $app = new Router();
  $app::route("/", ["GET", "POST"], function(){
    echo "Hello World";
  })
  // request url = 127.0.0.1/
  // output Hello World
  
  $app::route("/hi/:name", ["GET", "POST"], function(){
    global $app;
    echo "Hi " . $app::params["name"];
  })
  // request url = 127.0.0.1/hi/Jack
  // output Hi Jack
  
  $app::route("/hi", ["GET", "POST"], function(){
    global $app;
    echo "Hi " . $app::params["name"];
  })
  // request url = 127.0.0.1/hi?name=Jack
  // output Hi Jack
```
Routing and view
```php
  use Illuminati\Routing\Router;
  use Illuminati\View\View;

  View::$prefix_make = __DIR__ . "/../templates/"; // This setting depends on your project structure.
  $app = new Router();
  
  $app::route("/", ["GET", "POST"], function(){
    return View::make("index"); // templates/index.php
  })
```
### Features
This is only part
| Class | Constructor |  Function | Parameters | Details |
| :-------- | :--------: | ---------: | ---------: | ---------: |
|   Router   |   null   |    route()   |    string, array, callback   | Coming soon |
|   View   |   null   |    make()   |    string   |  Coming soon |
|   View   |   null   |    assets()   |    string   |  Coming soon |

## License
[Apache License, version 2.0](https://github.com/mantvmass/Auduct/blob/main/LICENSE.md)

# P4M Package Shopping Cart Basic Demo


This is a demo implementation of the **[parcel4me php shopping cart package](https://github.com/ParcelForMe/parcel4me-php)**.

This repo is the most basic implementation of the parcel4me web components.    
The [P4M Widgets](https://github.com/ParcelForMe/p4m-widgets) need to be included when implementing Parcel4Me in a shopping cart.   

## Quick Start

[PHP](http://php.net/manual/en/intro-whatis.php) (at least version 7) and [Composer](https://getcomposer.org/) are required.    
  

### Install

**Composer Install**

    $ composer install

**Widgets Install** *(requires bash, git and bower)*

    $ ./install-widgets.sh
  
*(Note that if the [p4m-widget repo](https://github.com/ParcelForMe/p4m-widgets) gets updated; use `$ ./update-widgets.sh`)*


  
### Run

**Start the server**

	$ php -S localhost:8000

	
**Open the basic demo**   
 
 * <a href="http://localhost:8000/">http://localhost:8000/</a>




----


## What is this and what do I do with it ?


`index.php` is a "demo" implementation of the parcel4me PHP abstract class, it has a router that handles each of the required P4M endpoints.
It has no UI (other than what the P4M widgets provide) and only hardcoded sample data.

The purpose of this demo is to provide a sample that can be copied to implement a P4M checkout into an existing PHP based shopping cart.   
Taking the code in `index.php` and replacing the router and the hardcoded sample method with methods that correctly access the database and methods of another existing shopping cart is all that is required to implement P4M checkout with that shopping cart.


See the **[parcel4me php shopping cart package](https://github.com/ParcelForMe/parcel4me-php)** for more information.

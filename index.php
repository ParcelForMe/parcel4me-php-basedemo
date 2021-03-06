<?php 

    // Require composer autoloader
    require_once __DIR__.'/vendor/autoload.php';


    // Require the P4M Shop Abstract Class
    
    // I'm sure that this really shouldn't be required 
    //  but I obviously haven't figured out composer autoloader correctly yet :
    require_once __DIR__.'/vendor/parcel4me/parcel4me/src/parcel4me/p4m-shop.php';

    // likewise I assume this should get handled by autoloader ? :
    require __DIR__.'/vendor/smarty/smarty/libs/Smarty.class.php';



    /*       
        DDDDDDDDDDDDD                                                                     
        D::::::::::::DDD                                                                  
        D:::::::::::::::DD                                                                
        DDD:::::DDDDD:::::D                                                               
        D:::::D    D:::::D     eeeeeeeeeeee       mmmmmmm    mmmmmmm      ooooooooooo   
        D:::::D     D:::::D  ee::::::::::::ee   mm:::::::m  m:::::::mm  oo:::::::::::oo 
        D:::::D     D:::::D e::::::eeeee:::::eem::::::::::mm::::::::::mo:::::::::::::::o
        D:::::D     D:::::De::::::e     e:::::em::::::::::::::::::::::mo:::::ooooo:::::o
        D:::::D     D:::::De:::::::eeeee::::::em:::::mmm::::::mmm:::::mo::::o     o::::o
        D:::::D     D:::::De:::::::::::::::::e m::::m   m::::m   m::::mo::::o     o::::o
        D:::::D     D:::::De::::::eeeeeeeeeee  m::::m   m::::m   m::::mo::::o     o::::o
        D:::::D    D:::::D e:::::::e           m::::m   m::::m   m::::mo::::o     o::::o
        DDD:::::DDDDD:::::D  e::::::::e          m::::m   m::::m   m::::mo:::::ooooo:::::o
        D:::::::::::::::DD    e::::::::eeeeeeee  m::::m   m::::m   m::::mo:::::::::::::::o
        D::::::::::::DDD       ee:::::::::::::e  m::::m   m::::m   m::::m oo:::::::::::oo 
        DDDDDDDDDDDDD            eeeeeeeeeeeeee  mmmmmm   mmmmmm   mmmmmm   ooooooooooo   
                                                                                                                          
        _________ _______  _______  _        _______  _______  _______  _       _________ _______ __________________ _______  _       
        \__   __/(       )(  ____ )( \      (  ____ \(       )(  ____ \( (    /|\__   __/(  ___  )\__   __/\__   __/(  ___  )( (    /|
           ) (   | () () || (    )|| (      | (    \/| () () || (    \/|  \  ( |   ) (   | (   ) |   ) (      ) (   | (   ) ||  \  ( |
           | |   | || || || (____)|| |      | (__    | || || || (__    |   \ | |   | |   | (___) |   | |      | |   | |   | ||   \ | |
           | |   | |(_)| ||  _____)| |      |  __)   | |(_)| ||  __)   | (\ \) |   | |   |  ___  |   | |      | |   | |   | || (\ \) |
           | |   | |   | || (      | |      | (      | |   | || (      | | \   |   | |   | (   ) |   | |      | |   | |   | || | \   |
        ___) (___| )   ( || )      | (____/\| (____/\| )   ( || (____/\| )  \  |   | |   | )   ( |   | |   ___) (___| (___) || )  \  |
        \_______/|/     \||/       (_______/(_______/|/     \|(_______/|/    )_)   )_(   |/     \|   )_(   \_______/(_______)|/    )_)  
    */



    session_start(); // this is important for the P4M_Shop->getCurrentSessionId() to work !!
                     // if you do not have a session, then you must override this method


    // This is a bare bones demo implementation,
    // an empty shell to be filled out for a real shopping cart

    class DemoShop extends P4M\P4M_Shop {


        function userIsLoggedIn() {
            //return false;
            return true;
        }

        function createNewUser( $p4m_consumer ) {
            /*
                logic here to create a new user record
                in the shopping cart database
            */
            $user = new stdClass();
            $user->first = 'First';
            $user->last  = 'Last';
            $user->email = 'new_person@mailinator.com';
            $user->id    = 1234567;

            return $user;
        }

        public function isValidUserId( $localUserId ) {
            if ($localUserId==1234567) return true;
            else return false;
        }

        function loginUser( $localUserId ) {
            /*
                logic to log the user out of the shopping cart 
            */
            return true;
        }

        function logoutCurrentUser() {
            /*
                logic to logout the current user from the shopping cart 
            */
            return true;
        }

        function setCurrentUserDetails( $p4m_consumer ) {
            /* 
                logic to copy fields from the p4m_consumer onto the current local user 
            */
            return true;
        }
        

        function getCurrentUserDetails() {
            /* 
                some logic goes here to fetch the 
                details of the current user 
            */
            $user = new stdClass();
            $user->first = 'First';
            $user->last  = 'Last';
            $user->email = 'new_person@mailinator.com';

            
            $p4m_address = new P4M\Model\Address();
            $p4m_address->addressType   = 'Address';
            $p4m_address->street1       = '21 Pine Street';
            $p4m_address->state         = 'Qld';
            $p4m_address->countryCode   = 'AU';
            $p4m_address->removeNullProperties();

            // Convert the user from the shopping cart DB into a 
            // P4M Consumer
            $consumer = new P4M\Model\Consumer();
            $consumer->givenName  = $user->first;
            $consumer->familyName = $user->last;
            $consumer->email      = $user->email;
            $consumer->addresses  = array ( $p4m_address ); 
            $consumer->removeNullProperties();

            return $consumer;
        }

        function getCartOfCurrentUser() {
            /*
                some logic goes here to fetch my cart from 
                my shopping cart DB and put the details into 
                this $cart object 
            */

            // Convert the shopping cart from the shopping cart DB into a 
            // P4M Cart

            $cartItem = new P4M\Model\CartItem();
            $cartItem->desc         = "A great thing I am buying";
            $cartItem->qty          = 1;
            $cartItem->price        = 100;
            $cartItem->linkToImage  = "http://cdn2.wpbeginner.com/wp-content/uploads/2015/12/pixabay.jpg";
            $cartItem->removeNullProperties();

            $cart = new P4M\Model\Cart();
            $cart->sessionId    = $this->getCurrentSessionId();
            $cart->paymentType  = "DB";
            $cart->items        = [ $cartItem ];
            $cart->currency     = "USD";
            $cart->reference    = "12345"; //.rand(); // This is REQUIRED (and needs to change for subsequent Paypal payments)
            $cart->removeNullProperties();

            return $cart;
        }


        function setCartOfCurrentUser( $p4m_cart ) {
            /* 
                some logic goes here to set local shopping cart DB
                based on the passed in p4m shopping cart object 
            */

            return true;
        }
        

        function setAddressOfCurrentUser( $which_address, $p4m_address ) {
            /*
                logic here to find the address in the local DB
                and update it, or add if not exists
            */

            return true;
        }


        function updateShipping( $shippingServiceName, $amount, $dueDate, $address ) {
            /*
                some logic goes here to set these shipping amounts and 
                possibly recalculate the tax on the current shopping cart 
            */

            return true;
        }


        function getCartTotals() {
            /*
                some logic goes here to fetch these values from
                the current shopping cart 
            */

            $r = new stdClass();
            $r->tax      = 10.00;
            $r->shipping = 20.00;
            $r->discount = 5.00;
            $r->total    = 112.22;

            return $r;
        }


        function updateWithDiscountCode( $discountCode ) {
            /* 
                some logic goes here to check if this discount code is valid,
                if not throw an error, if so then apply it to the cart and return the discount details 
            */

            $dis = new P4M\Model\Discount();

            if ($discountCode != 'valid_code') // special discount code "valid_code" works, else fails
            {
                throw new Exception('Unknown discount code.'); 
            }

            $dis->code          = $discountCode;
            $dis->description   = 'A demo valid coupon code!';
            $dis->amount        = 0.01;

            return $dis;
        }


        function updateRemoveDiscountCode( $discountCode ) {
            /* 
                some logic goes here to remove this discount code from the cart 
                throw error if it is not on there
            */

            $dis = new P4M\Model\Discount();

            if ($discountCode != 'valid_code') // special discount code "valid_code" works, else fails
            {
                throw new Exception('Unknown discount code.'); 
            }

            $dis->code          = $discountCode;
            $dis->description   = 'A demo valid coupon code!';
            $dis->amount        = 0.01;

            return $dis;
        }
        

         public function updateCartItemQuantities( $itemsUpdateArray ) {
             /*
                some logic to update the quantities on the cart lines
            */

            $dis = new P4M\Model\Discount();
            $dis->code           = 'valid_code';
            $dis->description    = 'A demo valid coupon code!';
            $dis->amount         = 0.01;

            $disArray = [ $dis ];

            return $disArray;
         }


         public function completePurchase ( $purchase_data ) {
             /*
                some logic to update the db to show that the purchase has happened and clear the cart 
            */

             return true;
         }
         
         public function fetchLocalUserByEmail( $localUserEmailAddress ) {
            /*
                some logic to find the local user and return a p4m consumer
            */
            return false;
         }


        function handleError($message) {
            $error_url = 'http://' . $_SERVER['HTTP_HOST'] . '/error/' . urlencode($message);
            header("Location: {$error_url}");
            exit();
        }


    }


    // Set the config
    $parcel4me_shop_config = array(
        'environment'                   => 'dev',
        'p4m_client_id'                 => '10004',
        'p4m_secret'                    => 'secret',
        'gfs_client_id'                 => 'parcel_4_me',
        'gfs_secret'                    => 'needmoreparcels',
        'redirect_url_checkout'         => '/parcel4me_checkout',
        'redirect_url_payment_complete' => '/demo_paymentcomplete'
    );

    /// Define the Instance :
    $my_shopping_cart = new DemoShop( $parcel4me_shop_config );



    /*
        _______  _______          _________ _______  _______ 
        (  ____ )(  ___  )|\     /|\__   __/(  ____ \(  ____ )
        | (    )|| (   ) || )   ( |   ) (   | (    \/| (    )|
        | (____)|| |   | || |   | |   | |   | (__    | (____)|
        |     __)| |   | || |   | |   | |   |  __)   |     __)
        | (\ (   | |   | || |   | |   | |   | (      | (\ (   
        | ) \ \__| (___) || (___) |   | |   | (____/\| ) \ \__
        |/   \__/(_______)(_______)   )_(   (_______/|/   \__/
    */

    // In case one is using PHP 5.4's built-in server
    $filename = __DIR__ . '/../' . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
    if (php_sapi_name() === 'cli-server' && is_file($filename)) {
        return false;
    }

    // Create a Router
    $router = new \Bramus\Router\Router();


    // Custom 404 Handler
    $router->set404(function () {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
        echo '404, route not found!';
    });


    // Static route: / (homepage)
    $router->get('/', function () {

        $supportedEndPoints = array( 
                '/p4m/signup',
                '/p4m/getP4MAccessToken',
                '/p4m/isLocallyLoggedIn',
                '/p4m/localLogin',
                '/p4m/restoreLastCart',
                '/p4m/checkout',
                '/p4m/updShippingService',
                '/p4m/applyDiscountCode',
                '/p4m/removeDiscountCode',
                '/p4m/itemQtyChanged',
                '/p4m/purchase',
                '/p4m/paypalSetup',
                '/p4m/paypalCancel',
                '/p4m/purchaseComplete',
                '/error/(message)'
        );

        $smarty = new Smarty;

        $smarty->assign('supportedEndPoints',   $supportedEndPoints);
        $smarty->assign('idSrvUrl',             P4M\Settings::getPublic('Server:P4M_OID_SERVER'));
        $smarty->assign('clientId',             P4M\Settings::getPublic('OpenIdConnect:ClientId'));
        $smarty->assign('redirectUrl',          P4M\Settings::getPublic('OpenIdConnect:RedirectUrl'));
        
        $smarty->display(__DIR__.'/view/template/index.tpl');


    });


    // Define routes
    // as per : http://developer.parcelfor.me/docs/documentation/parcel-for-me-widgets/p4m-login-widget/host-server/
    // and : https://github.com/ParcelForMe/p4m-demo-shop/blob/master/OpenOrderFramework/Controllers/P4MTokenController.cs
    // Subrouting

    // Dynamic route: p4m/*
    // GET
    $router->get('/p4m/(\w+)', function ($p4mEndpoint) {
        global $my_shopping_cart;
        switch($p4mEndpoint) {
            
            case 'signup' :                 $my_shopping_cart->signUp();                    break;
            case 'getP4MAccessToken' :      $my_shopping_cart->getP4MAccessToken();         break;
            case 'isLocallyLoggedIn' :      $my_shopping_cart->isLocallyLoggedIn();         break;                
            case 'localLogin' :             $my_shopping_cart->localLogin();                break;                
            case 'restoreLastCart' :        $my_shopping_cart->restoreLastCart();           break;
            case 'getP4MCart' :             $my_shopping_cart->getP4MCart();                break;
            case 'paypalSetup' :            $my_shopping_cart->paypalSetup();               break;
            case 'paypalCancel' :           $my_shopping_cart->paypalCancel();              break;
            case 'purchaseComplete' :       /* handled specially below */                   break;
            
            default:
                echo 'Hello unhandled GET endpoint : ' . htmlentities($p4mEndpoint);
        }
    });
    // this endpoint need only be implemented if your cart supports 3d secure transactions
    $router->get('/p4m/purchaseComplete/([a-z0-9_-]+)', function($cartId) {
        global $my_shopping_cart;
        $my_shopping_cart->purchaseComplete($cartId);          
    });

    // POST 
    $router->post('/p4m/(\w+)', function ($p4mEndpoint) {
        global $my_shopping_cart;
        switch($p4mEndpoint) {

            case 'updShippingService' :     $my_shopping_cart->udpShippingService();        break;
            case 'applyDiscountCode' :      $my_shopping_cart->applyDiscountCode();         break;
            case 'removeDiscountCode' :     $my_shopping_cart->removeDiscountCode();        break;
            case 'itemQtyChanged' :         $my_shopping_cart->itemQtyChanged();            break;
            case 'purchase' :               $my_shopping_cart->purchase();                  break;
            
            default:
                echo 'Hello unhandled POST endpoint : ' . htmlentities($p4mEndpoint);
        }
    });

    // and the redirect endpoints for checkout and payment
    $router->get('/parcel4me_checkout', function() {

            global $my_shopping_cart;
            
            $my_shopping_cart->checkout();

            $smarty = new Smarty;

            $smarty->assign('idSrvUrl',         P4M\Settings::getPublic( 'Server:GFS_SERVER' ));
            $smarty->assign('clientId',         P4M\Settings::getPublic( 'OpenIdConnect:ClientId' ));
            $smarty->assign('redirectUrl',      P4M\Settings::getPublic( 'OpenIdConnect:RedirectUrl' ));
            
            $checkoutConfig = array (
                'sessionId'           => session_id(),
                'gfsAccessToken'      => (array_key_exists('gfsCheckoutToken', $_COOKIE) ? $_COOKIE['gfsCheckoutToken'] : ''),
                'initialAddress'      => (array_key_exists('p4mInitialAddress', $_COOKIE) ? $_COOKIE['p4mInitialAddress'] : ''),
                'initialPostCode'     => (array_key_exists('p4mDefaultPostCode', $_COOKIE) ? $_COOKIE['p4mDefaultPostCode'] : ''),
                'initialCountryCode'  => (array_key_exists('p4mDefaultCountryCode', $_COOKIE) ? $_COOKIE['p4mDefaultCountryCode'] : '')
            );
            $smarty->assign('config', $checkoutConfig);
     
            $pageHtml = $smarty->fetch(__DIR__.'/view/template/checkout.tpl');
            echo $pageHtml;
    });
    $router->get('/demo_paymentcomplete', function() {

            $smarty = new Smarty;

            $smarty->assign('p4mServer',    P4M\Settings::getPublic( 'Server:P4M_OID_SERVER' ));

            $pageHtml = $smarty->fetch(__DIR__.'/view/template/checkoutcomplete.tpl');
            echo $pageHtml;
    });

    // Dynamic route: /error/(message)
    $router->get('/error/(.*)', function ($msg) {
        echo '<h1>Error: <span style="color: red;">' . urldecode(htmlentities($msg)) . '</span></h1>';
    });
    $router->run();


?>
Cache Bundle
========================
Installation
------------

Add the bundle to your `composer.json`:

    "igdr/cache-bundle" : "dev-master"

and run:

    php composer.phar update

Then add the CacheBundle to your application kernel:

    // app/IgdrKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Igdr\Bundle\CacheBundle\IgdrCacheBundle(),
            // ...
        );
    }

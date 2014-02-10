Wwwision.Neos.FrontendLogin
===========================

TYPO3 Neos plugin demonstrating a simple "frontend login"

How-To:
-------

* Install the package to ``Packages/Plugin/Wwwision.Neos.FrontendLogin``
* Login to the TYPO3 Neos backend and create a new page ``/login``
* On that page insert the new plugin ``Frontend login form``
* Somewhere else create a page "User Profile" and tick the ``hidden in index`` checkbox
* On that page insert a ``Plugin View`` and select the "User profile (protected)" view from the "Frontend login form" plugin in the inspector
* Publish all changes
* Create a new account (you can use the ``user:create`` command an then adjust via db)
 * authenticationProviderName: ``FrontendLoginProvider``
 * roles: [``Wwwision.Neos.FrontendLogin:User``]

Now you should be able to test the frontend login by navigating to ``/login.html``

Known issues:
-------------

* You can be logged in in backend *and* frontend with different accounts! But if you logout one, the other one is logged out as well
* If you try to access the page with the protected profile view w/o authentication you won't be redirected but a (in production mode hidden) exception message is rendered. If you set the TypoScript exceptionHandler to ``ThrowingHandler`` this can be worked around though
* ~~The "profile" plugin view renders an "Access denied" exception in backend~~ This is fixed with 619b026ce7
* The "logout" button in the profile view doesn't work due to an access denied exception - This is most likely just a configuration issue I didn't get my head around yet

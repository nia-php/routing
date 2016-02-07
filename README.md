# nia - Routing Component

The routing component routes a request through filters to a handler that will convert it to a response.

The router is very flexible because there is no environment context limitation such as HTTP, CLI, Voice or anything else - even no configuration files or *black annotation magic*. It uses a unique concept of conditions to find the best matching route, intercepting filters to encapsulate logic and handlers to generate a response - all of them are environment independent.

## Installation

Require this package with Composer.

```bash
	composer require nia/routing
```

## Tests
To run the unit test use the following command:

    $ cd /path/to/nia/component/
    $ phpunit --bootstrap=vendor/autoload.php tests/

## Conditions
A route has a condition (or multiple conditions using a composite) to determine the best matching route.

The component provides several conditions but you are able to write your own by implementing the `Nia\Routing\Condition\ConditionInterface` interface for a more specific use case condition.

| Condition | Description |
| --- | --- |
| `Nia\Routing\Condition\ArgumentCondition` | Condition to check whether a request argument is set. |
| `Nia\Routing\Condition\ClosureCondition` | Allows to set a closure as a condition. |
| `Nia\Routing\Condition\CompositeCondition` | This condition gives you the ability to combine multiple conditions using logical AND. |
| `Nia\Routing\Condition\MethodCondition` | Checks whether the request uses a specific method. |
| `Nia\Routing\Condition\NullCondition` | Condition is always `true` |
| `Nia\Routing\Condition\OrCompositeCondition` | This condition gives you the ability to combine multiple conditions using logical OR. |
| `Nia\Routing\Condition\PathCondition` | Condition to check whether the request patch matches against a static path. |
| `Nia\Routing\Condition\RegexPathConidition` | Checks the request path against a regex. |

## Filters
Requests to handlers and the generated responses can be filtered by the intercepting filters. Filters can be used to move common business logic from the handler to filters. Such stuff like *"If the session is not started, display forbidden page"* or running *AB-tests*.

The componend privides some conditions but your are able to write your own by implementing the `Nia\Routing\Filter\FilterInterface` interface.

| Filter | Description |
| --- | --- |
| `Nia\Routing\Filter\CompositeFilter` | Combine multiple filters. |
| `Nia\Routing\Filter\NullFilter` | This filter makes nothing. Just set this filter if you do not need a filter. |
| `Nia\Routing\Filter\RegexPathContentFillerFilter` | This filter fills up the `context` parameter of the `filterRequest` by using a regex for the request path with named matches. You can combine this filter with the `Nia\Routing\Condition\RegexPathCondition`. |

## Handlers
Handlers are implementations which uses a request and create a response. Handlers can be actions of controllers, closures (using the `Nia\Routing\Handler\ClosureHandler`) or something else, just implement the `Nia\Routing\Handler\HandlerInterface`.

## Sample: Simple CLI Application
The following sample shows you a simple cli application to welcome you if you pass *name* and *age*. The sample is uncommon, because it is better to build a facade for CLI routing (see *Sample: Simple HTTP Router*) but gives you a good view of the router usage.

```php
	$router = new Router();

	// route if age and name are set.
	// ------------------------------
	$condition = new CompositeCondition([
	    new ArgumentCondition('age'),
	    new ArgumentCondition('name')
	]);
	$handler = new ClosureHandler(function (RequestInterface $request, WriteableMapInterface $context) {
	    $name = $request->getArguments()->get('name');
	    $age = $request->getArguments()->get('age');

	    $content = sprintf("Hello, %s! You are %d years old.\n", $name, $age);

	    $response = $request->createResponse();
	    $response->setContent($content);

	    return $response;
	});

	$router->addRoute(new Route($condition, new NullFilter(), $handler));

	// route if no name or age set.
	// ----------------------------
	$handler = new ClosureHandler(function (RequestInterface $request, WriteableMapInterface $context) {
	    $content = 'Just call this script with --age=your-age and --name=your-name' . PHP_EOL;

	    $response = $request->createResponse();
	    $response->setContent($content);

	    return $response;
	});

	$router->addRoute(new Route(new NullCondition(), new NullFilter(), $handler));

	// run the application.
	$request = new CliRequest($_SERVER['argv']);
	$response = $router->handle($request, new Map());

	echo $response->getContent();
	exit($response->getStatusCode());

```

## Sample: Is User Logged-In Filter
This sample shows you to move a common controller logic to a filter. In this case: *"Is no session started, show 403 forbidden"*.

```php
	/**
	 * Filter to check if the user is logged in.
	 */
	class UserIsLoggedInFilter implements FilterInterface
	{

	    /**
	     *
	     * {@inheritDoc}
	     *
	     * @see \Nia\Routing\Filter\FilterInterface::filterRequest($request, $context)
	     */
	    public function filterRequest(RequestInterface $request, WriteableMapInterface $context): ResponseInterface
	    {
	        // if the session is started the request can pass to the handler.
	        if (isset($_SESSION)) {
	            throw new IgnoreFilterException();
	        }

	        // user has no session, so the request is forbidden.
	        $response = $request->createResponse();
	        $response->setStatusCode(403);
	        $response->setContent('You are not logged in.');

	        return $response;
	    }

	    /**
	     *
	     * {@inheritDoc}
	     *
	     * @see \Nia\Routing\Filter\FilterInterface::filterResponse($response, $context)
	     */
	    public function filterResponse(ResponseInterface $response, WriteableMapInterface $context): ResponseInterface
	    {
	        return $response;
	    }
	}
```

## Sample: Running AB-Tests
If you need to run an AB-Test you must modify templates and/or a controller. If you use an intercepting filter (like in this case) you are able to run AB-Tests without modify any code of your template nor controller.

```php
	/**
	 * AB test to check if the brighter layout increases the conversion rate.
	 * The filter adds (if the test is running) an additional css file to the <head>-tag.
	 */
	class BrighterLayoutAbTestFilter implements FilterInterface
	{

	    /**
	     * Whether the test is forced.
	     *
	     * @var bool
	     */
	    private $forceTest = false;

	    /**
	     *
	     * {@inheritDoc}
	     *
	     * @see \Nia\Routing\Filter\FilterInterface::filterRequest($request, $context)
	     */
	    public function filterRequest(RequestInterface $request, WriteableMapInterface $context): ResponseInterface
	    {
	        $this->forceTest = $request->getArguments()->has('force-test');

	        throw IgnoreFilterException;
	    }

	    /**
	     *
	     * {@inheritDoc}
	     *
	     * @see \Nia\Routing\Filter\FilterInterface::filterResponse($response, $context)
	     */
	    public function filterResponse(ResponseInterface $response, WriteableMapInterface $context): ResponseInterface
	    {
	        // only set brighter layout if the test is forced or is one of two.
	        if ($this->forceTest || mt_rand(0, 1) === 0) {
	            // brighter layout to test.
	            $replacement = '<link href="/css/brighter.css" rel="stylesheet" type="text/css" />';

	            // append new css-file to header.
	            $content = $response->getContent();
	            $content = str_replace('</head>', $replacement . '</head>', $content);

	            $response->setContent($content);
	        }

	        return $response;
	    }
	}
```

## Sample: Simple HTTP Router
Using the router in a plain way produces much code and decreases the usability. A good way is to write a facade for a routing environment like the following avoid this effect.

```php
	/**
	 * Simple router facade for common HTTP routing usages.
	 */
	class HttpRouterFacade
	{

	    /** @var RouterInterface */
	    private $router = null;

	    /**
	     * Constructor.
	     *
	     * @param RouterInterface $router
	     */
	    public function __construct(RouterInterface $router)
	    {
	        $this->router = $router;
	    }

	    /**
	     * Creates a HTTP/GET route.
	     *
	     * @param string $pathRegex
	     *            The regex for the route.
	     * @param HandlerInterface $handler
	     *            The used handler to handle the match.
	     * @param FilterInterface $filter
	     *            Optional filter.
	     * @return HttpRouterFacade Reference to this instance.
	     */
	    public function get($pathRegex, HandlerInterface $handler, FilterInterface $filter = null): HttpRouterFacade
	    {
	        $condition = new CompositeCondition([
	            new MethodCondition(HttpRequestInterface::METHOD_GET),
	            new RegexPathCondition($pathRegex)
	        ]);

	        $filter = new CompositeFilter([
	            $filter ?? new NullFilter(),
	            new RegexPathContextFillerFilter($pathRegex)
	        ]);

	        $this->router->addRoute(new Route($condition, $filter, $handler));

	        return $this;
	    }

	    /**
	     * Creates a HTTP/POST route.
	     *
	     * @param string $pathRegex
	     *            The regex for the route.
	     * @param HandlerInterface $handler
	     *            The used handler to handle the match.
	     * @param FilterInterface $filter
	     *            Optional filter.
	     * @return HttpRouterFacade Reference to this instance.
	     */
	    public function post($pathRegex, HandlerInterface $handler, FilterInterface $filter = null): HttpRouterFacade
	    {
	        $condition = new CompositeCondition([
	            new MethodCondition(HttpRequestInterface::METHOD_POST),
	            new RegexPathCondition($pathRegex)
	        ]);

	        // for POST add a CSRF token filter to check if the CSRF is valid.
	        $filter = new CompositeFilter([
	            $filter ?? new NullFilter(),
	            new CsrfTokenFilter(),
	            new RegexPathContextFillerFilter($pathRegex)
	        ]);

	        $this->router->addRoute(new Route($condition, $filter, $handler));

	        return $this;
	    }
	}

	$router = new Router();
	$httpRouter = new HttpRouterFacade($router);

	// start page: /
	$httpRouter->get('@^/$@', new ClosureHandler(function (RequestInterface $request, WriteableMapInterface $context) {
	    $response = $request->createResponse();
	    $response->setContent('<h1>Startpage</h1>');

	    return $response;
	}))
	    ->
	// hello-page: /hello/your-name/
	get('@^/hello/(?P<name>\w+)/?$@', new ClosureHandler(function (RequestInterface $request, WriteableMapInterface $context) {
	    $response = $request->createResponse();
	    $response->setContent('<h1>Welcome ' . $context->get('name') . '</h1>');

	    return $response;
	}))
	    ->
	// contact form: /company/contact/
	get('@^/company/contact/?$@', new ClosureHandler(function (RequestInterface $request, WriteableMapInterface $context) {
	    $response = $request->createResponse();
	    $response->setContent('<h1>Contact</h1><form>...</form>');

	    return $response;
	}))
	    ->
	// contact form: /company/contact/
	post('@^/company/contact/?$@', new ClosureHandler(function (RequestInterface $request, WriteableMapInterface $context) {
	    $response = $request->createResponse();
	    $response->setContent('<h1>Contact</h1><p>Thank you for your message!</p>');

	    return $response;
	}));

	// -----------

	// [...]

	// handle the request
	$response = $router->handle($request, $context);

	// [...]
```

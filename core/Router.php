<?php
namespace app\core;

class Router
{
    public Request $request; 
    public Response $response;              
    protected array $routes = [];  

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @param mixed $path
     * @param mixed $callback
     * 
     * @return [type]
     */
    /**
     * @param mixed $path
     * @param mixed $callback
     * 
     * @return [type]
     */
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }


    /**
     * @param mixed $path
     * @param mixed $callback
     * 
     * @return [type]
     */
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * @return [type]
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) 
        {
            $this->response->setStatusCode(404);
            return $this->renderView('_404');
        }

        if(is_string($callback)){
            return $this->renderView($callback);
        }

        if(is_array($callback))
        {
            $callback[0] = new $callback[0]();
        }

        dump($callback);
        return call_user_func($callback);
    }


    /**
     * @param mixed $view
     * 
     * @return [type]
     */
    public function renderView($view, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
        include_once Application::$ROOT_DIR."/views/$view.php";
    }

    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
        include_once Application::$ROOT_DIR."/views/$viewContent.php";
    }

    protected function layoutContent()
    {
        ob_start();
        include_once  Application::$ROOT_DIR."/views/layouts/main.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params)
    {
        foreach($params as $key => $value)
        {           
            $$key = $value;
        }
        ob_start();
        include_once  Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }

}
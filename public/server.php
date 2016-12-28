<?php
/**
 * Swoole HttpServer 启动服务脚本
 */
error_reporting(E_ALL);
date_default_timezone_set('Asia/Shanghai');
define('APP_PATH', realpath(dirname(__FILE__) . '/../'));

class HttpServer
{

    public static $instance;

    // http服务对象
    private $httpServer;
    // phalcon框架应用对象
    private $application;
    
    public function __construct()
    {
        // 创建swoole_http_server对象
        $this->httpServer = new swoole_http_server('0.0.0.0', 8080);
        // 设置参数（http://wiki.swoole.com/wiki/page/274.html）
        $this->httpServer->set([
            'worker_num' => 16,
            'daemonize' => false, // 是否开启守护进程
            'max_request' => 10000,
            'dispatch_mode' => 1
        ]);
        // 回调事件（http://wiki.swoole.com/wiki/page/41.html）
        // 绑定WorkerStart
        $this->httpServer->on('WorkerStart', [
            $this,
            'onWorkerStart'
        ]);
        // 绑定request
        $this->httpServer->on('request', [
            $this,
            'onRequest'
        ]);
        // 开启服务器
        $this->httpServer->start();
    }

    /**
     * WorkerStart回调
     */
    public function onWorkerStart($serv, $workId)
    {
        /**
         * Read the configuration
         */
        $config = require_once APP_PATH . "/app/config/config.php";
        /**
         * Read auto-loader
         */
        require_once APP_PATH . "/app/config/loader.php";
        /**
         * Read services
         */
        require_once APP_PATH . "/app/config/services.php";
        $this->application = new \Phalcon\Mvc\Application($di);
    }

    /**
     * 处理http请求
     */
    public function onRequest(swoole_http_request $request, swoole_http_response $response)
    {
        $_SERVER = $request->server;
        
        // 注册捕获错误函数
        register_shutdown_function([
            $this,
            'handleFatal'
        ]);
        if ($request->server['request_uri'] == '/favicon.ico' || $request->server['path_info'] == '/favicon.ico') {
            $response->header('Content-Type', 'image/jpeg');
            $faviconImg = file_get_contents('./favicon.ico');
            return $response->end($faviconImg);
        }
        
        // 构造url请求路径，phalcon需要$_GET['_url']参数来解析请求路径，以此来达到在nginx下伪静态效果，否则默认为‘/’
        $_GET['_url'] = $request->server['request_uri'];
        if ($request->server['request_method'] == 'GET' && isset($request->get)) {
            $_GET = $request->get;
        }
        if ($request->server['request_method'] == 'POST' && isset($request->post)) {
            $_POST = $request->post;
        }
        // 处理请求
        ob_start();
        try {
            echo $this->application->handle()->getContent();
        } catch (Exception $e) {
            echo $e->getMessage();
            // echo '<pre>' . $e->getTraceAsString() . '</pre>';
        }
        $result = ob_get_contents();
        ob_end_clean();
        $response->header("Content-Type", "text/html;charset=utf-8");
        $response->header("X-Server", "Swoole");
        $response->end($result);
    }

    /**
     * 捕获Server运行期致命错误
     * 参考网址：http://wiki.swoole.com/wiki/page/305.html
     */
    public function handleFatal()
    {
        $error = error_get_last();
        if (isset($error['type'])) {
            switch ($error['type']) {
                case E_ERROR:
                case E_PARSE:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                    $message = $error['message'];
                    $file = $error['file'];
                    $line = $error['line'];
                    $log = "$message ($file:$line)\nStack trace:\n";
                    $trace = debug_backtrace();
                    foreach ($trace as $i => $t) {
                        if (! isset($t['file'])) {
                            $t['file'] = 'unknown';
                        }
                        if (! isset($t['line'])) {
                            $t['line'] = 0;
                        }
                        if (! isset($t['function'])) {
                            $t['function'] = 'unknown';
                        }
                        $log .= "#$i {$t['file']}({$t['line']}): ";
                        if (isset($t['object']) and is_object($t['object'])) {
                            $log .= get_class($t['object']) . '->';
                        }
                        $log .= "{$t['function']}()\n";
                    }
                    if (isset($_SERVER['REQUEST_URI'])) {
                        $log .= '[QUERY] ' . $_SERVER['REQUEST_URI'];
                    }
                    $this->application->logger->info('error log:' . $log);
                    $this->response->end($this->currentFd . '_' . 'log');
                    break;
                default:
                    break;
            }
        }
    }

    /**
     * 获取实例对象
     *
     * @return HttpServer
     */
    public static function getInstance()
    {
        if (! self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

HttpServer::getInstance();
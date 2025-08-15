<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Test URL rewriting
     * Access: http://localhost/cx_shipment/test
     */
    public function index()
    {
        $data = array(
            'title' => 'URL Rewriting Test',
            'message' => 'If you can see this page, URL rewriting is working!',
            'current_url' => current_url(),
            'base_url' => base_url(),
            'environment' => ENVIRONMENT,
            'timestamp' => date('Y-m-d H:i:s')
        );

        echo "<h1>{$data['title']}</h1>";
        echo "<p><strong>{$data['message']}</strong></p>";
        echo "<ul>";
        echo "<li><strong>Current URL:</strong> {$data['current_url']}</li>";
        echo "<li><strong>Base URL:</strong> {$data['base_url']}</li>";
        echo "<li><strong>Environment:</strong> {$data['environment']}</li>";
        echo "<li><strong>Timestamp:</strong> {$data['timestamp']}</li>";
        echo "</ul>";

        echo "<h2>Test Links:</h2>";
        echo "<ul>";
        echo "<li><a href='" . base_url() . "'>Homepage</a></li>";
        echo "<li><a href='" . base_url('welcome') . "'>Welcome Page</a></li>";
        echo "<li><a href='" . base_url('test/hello') . "'>Test Hello</a></li>";
        echo "</ul>";
    }

    /**
     * Test method
     * Access: http://localhost/cx_shipment/test/hello
     */
    public function hello()
    {
        echo "<h1>Hello from Test Controller!</h1>";
        echo "<p>This confirms that URL rewriting is working correctly.</p>";
        echo "<p><a href='" . base_url('test') . "'>Back to Test</a></p>";
    }

    /**
     * Test with parameters
     * Access: http://localhost/cx_shipment/test/params/123/abc
     */
    public function params($param1 = '', $param2 = '')
    {
        echo "<h1>Parameter Test</h1>";
        echo "<p>Parameter 1: " . htmlspecialchars($param1) . "</p>";
        echo "<p>Parameter 2: " . htmlspecialchars($param2) . "</p>";
        echo "<p><a href='" . base_url('test') . "'>Back to Test</a></p>";
    }
}

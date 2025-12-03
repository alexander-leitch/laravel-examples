<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;
use Exception;
use EnvValidator\Facades\EnvValidator;

class TestDbConnect extends Command
{
    protected $signature = 'test:db-connect';
    protected $description = 'Test database connection with various hardcoded configurations';

    public function handle()
    {
        $this->info('Testing ENV ');
        // Validate with default Laravel rules
        EnvValidator::validate();

        $this->info('Testing Database Connections...');

        $configs = [
            'Docker Service (mysql)' => [
                'host' => 'mysql',
                'port' => 3306,
            ],
            'Localhost (127.0.0.1)' => [
                'host' => '127.0.0.1',
                'port' => 3306,
            ],
            'Container Name (laravel_mysql)' => [
                'host' => 'laravel_mysql',
                'port' => 3306,
            ],
            'Host Internal (host.docker.internal)' => [
                'host' => 'host.docker.internal',
                'port' => 3306,
            ],
        ];

        foreach ($configs as $name => $config) {
            $this->testConnection($name, $config);
        }
    }

    private function testConnection($name, $config)
    {
        $this->line('');
        $this->info("Testing: $name");
        $this->line("Host: {$config['host']}, Port: {$config['port']}");

        try {
            // Create a new raw PDO connection to bypass Laravel config
            $dsn = "mysql:host={$config['host']};port={$config['port']};dbname=laravel_queue_demo";
            $username = 'root';
            $password = 'root';
            
            $start = microtime(true);
            $pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_TIMEOUT => 5, // 5 second timeout
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $duration = round((microtime(true) - $start) * 1000, 2);

            $this->info("✅ SUCCESS! Connected in {$duration}ms");
            
            // Test query
            $version = $pdo->query('SELECT VERSION()')->fetchColumn();
            $this->line("MySQL Version: $version");

        } catch (Exception $e) {
            $this->error("❌ FAILED: " . $e->getMessage());
        }
    }
}

<?php
namespace Tests\Unit;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Filesystem\Filesystem;
use PHPUnit\Framework\TestCase;

class MigrationTest extends TestCase
{
    protected $capsule;

    public function setUp() {
        $this->capsule = new Capsule;
        $this->capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'munkireport_test',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]);
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }

    public function testMigrations() {
        $repository = new DatabaseMigrationRepository($this->capsule->getDatabaseManager(), 'migrations');
        if (!$repository->repositoryExists()) {
            $repository->createRepository();
        }

        $files = new Filesystem();
        $migrator = new Migrator($repository, $this->capsule->getDatabaseManager(), $files);
        $dirs = [__DIR__ . '/../database/migrations'];
        //$this->appendModuleMigrations($dirs);
        $migrationFiles = $migrator->run($dirs, ['pretend' => false]);

        echo $migrationFiles;

    }
}

<?php
namespace Tests\Unit;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Filesystem\Filesystem;
use PHPUnit\Framework\TestCase;
use munkireport\lib\Modules as ModuleMgr;

class MigrationTest extends TestCase
{
    protected $capsule;

    protected $migrationDirList;

    public function setUp() {
        $this->capsule = new Capsule;
        $this->capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'munkireport_test',
            'username' => 'travis',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]);

        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();

        // Load migrations within modules
        $moduleMgr = new ModuleMgr;
        $moduleMgr->loadinfo(true);
        foreach($moduleMgr->getInfo() as $moduleName => $info){
            if($moduleMgr->getModuleMigrationPath($moduleName, $migrationPath)){
                $this->migrationDirList[] = $migrationPath;
            }
        }
    }

    public function testMigrations() {
        $repository = new DatabaseMigrationRepository($this->capsule->getDatabaseManager(), 'migrations');
        if (!$repository->repositoryExists()) {
            $repository->createRepository();
        }

        $files = new Filesystem();
        $migrator = new Migrator($repository, $this->capsule->getDatabaseManager(), $files);
        $dirs = [__DIR__ . '/../database/migrations'];
        $migrationFiles = $migrator->run(array_merge($dirs, $this->migrationDirList));

        echo $migrationFiles;

    }
}

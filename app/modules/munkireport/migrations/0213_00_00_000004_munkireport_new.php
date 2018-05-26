<?php
/**
 * MunkiReport Legacy Migration
 * 2.13
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class Munkireport_New extends Migration {

    use \munkireport\lib\LegacyMigrationSupport;

    public static $legacySchemaVersion = 4;
    public static $legacyTableName = 'munkireport';

//    public function up() {
//        $legacyVersion = $this->getLegacyModelSchemaVersion('munkireport');
//        $capsule = new Capsule();
//
//        if ($legacyVersion < static::$legacySchemaVersion) {
//            $capsule::schema()->table('munkireport', function (Blueprint $table) {
//                $table->binary('error_json');
//                $table->binary('warning_json');
//            });
//
//            $this->markLegacyMigrationRan();
//        }
//    }
//
//    public function down() {
//        $legacyVersion = $this->getLegacyModelSchemaVersion('munkireport');
//
//        if ($legacyVersion == static::$legacySchemaVersion) {
//            $capsule::schema()->table('munkireport', function (Blueprint $table) {
//                $table->dropColumn(['error_json', 'warning_json']);
//            });
//
//            $this->markLegacyRollbackRan();
//        }
//    }
}
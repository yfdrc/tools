<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2018/9/26
 * Time: 8:58
 */

declare(strict_types=1);

namespace Drc\AutoMaker;

use Drc\AutoMaker\Common\abstractCommon;
use Drc\AutoMaker\Configration\ConfigDB;

class MakeDB extends abstractCommon
{
    const Version = "V1.0.0";

    public static function CreateAll()
    {
        self::CreateModel();
        self::CreateFactory();
        self::CreateMigration();
        self::CreateSeed();
    }

    public static function CreateModel($pz = null)
    {
        if(is_null($pz)) {
            $pz = ConfigDB::getPzModel();
        }

        $nr = static::GetModel($pz["name"], $pz["farr"], $pz["harr"]);
        static::CreateDir("Models","app");
        static::WritetoFile("Models",$pz["name"] . ".php" ,$nr,"app");
    }

    public static function CreateFactory($pz = null)
    {
        if(is_null($pz)) {
            $pz = ConfigDB::getPzModel();
        }

        $nr = static::GetFactory($pz["name"], $pz["col"]);
        static::CreateDir("factories","database");
        static::WritetoFile("factories",$pz["name"] . "Factory.php", $nr,"database");
    }

    public static function CreateMigration($pz = null)
    {
        if(is_null($pz)) {
            $pz = ConfigDB::getPzModel();
        }

        $nr = static::GetMigration($pz["name"], $pz["col"]);
        static::CreateDir("Migrations","database");
        static::WritetoFile("Migrations","2020_01_01_090102_create_" . $pz["name"] . "s_table" . ".php", $nr,"database");
    }

    public static function CreateSeed($pz = null)
    {
        if(is_null($pz)) {
            $pz = ConfigDB::getPzModel();
        }

        $nr = static::GetSeed($pz["name"], $pz["cs"]);
        static::CreateDir("seeds","database");
        static::WritetoFile("seeds",$pz["name"] . "Seeder" . ".php", $nr,"database");
    }

    private static function GetModel($name,$farr, $harr)
    {
        $s0 = "   ";
        $s1 = " " .$s0;
        $s2 = $s1 . $s1;

        $nr1 = "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Model;\n\nclass $name extends Model\n{\n";
        $nr2 = "$s0 protected \$fillable = [\n";
        $nr3 = "$s0 protected \$hidden = [\n";
        $nr4 = "$s0 ];\n";
        $nr5 = "}\n";

        $nr = $nr1 . $nr2;
        foreach ($farr as $item){
            $nr .= $s2 . "\"" . $item . "\",\n";
        }
        $nr .= $nr4 . "\n" . $nr3;
        foreach ($harr as $item){
            $nr .= $s2 . "\"" . $item . "\",\n";
        }
        $nr .= $nr4 . "\n" . $nr5;

        return $nr;
    }

    private static function GetFactory($name,$col)
    {
        $s0 = "   ";
        $s1 = " " .$s0;
        $s2 = $s1 . $s1;

        $nr1 = "<?php\n\nuse App\Models\\$name;\nuse Faker\Generator as Faker;\n\n\$factory->define($name ::class, function (Faker \$faker)\n{\n$s0 return [\n";
        $nr2 = "$s0 ];\n";
        $nr3 = "});\n";

        $nr = $nr1;
        foreach ($col as $item=>$value){
            switch ($value){
                case "name":
                    $nr .= "$s2'" . $item . "' => \$faker" . "->name," . "\n";
                    break;
                case "address":
                    $nr .= "$s2'" . $item . "' => \$faker" . "->unique()->address," . "\n";
                    break;
                case "text":
                    $nr .= "$s2'" . $item . "' => \$faker" . "->unique()->text," . "\n";
                    break;
            }
        }
        $nr .= $nr2 .$nr3;

        return $nr;
    }

    private static function GetMigration($name,$col)
    {
        $s0 = "   ";
        $s1 = " " .$s0;
        $s2 = $s1 . $s1;
        $s3 = $s1 . $s2;

        $nr1 = "<?php\n\nuse Illuminate\Support\Facades\Schema;\nuse Illuminate\Database\Schema\Blueprint;\nuse Illuminate\Database\Migrations\Migration;\n\nclass Create".$name."sTable extends Migration\n{\n$s0 public function up()\n$s1{\n$s0$s1 Schema::create('".strtolower($name) ."s', function (Blueprint \$table) {\n";
        $nr2 = "$s3\$table->bigIncrements('id');\n";
        $nr3 = "$s3\$table->timestamps();\n";
        $nr4 = "$s0$s1 });\n$s1}\n\n$s0 public function down()\n$s1{\n$s1$s0 Schema::dropIfExists('".strtolower($name) ."s');\n$s1}\n}\n";

        $nr = $nr1 . $nr2;
        foreach ($col as $item=>$value){
            switch ($value){
                case "name":
                    $nr .= "$s3\$table->string('" . $item . "',32);\n";
                    break;
                case "address":
                    $nr .= "$s3\$table->string('" . $item . "',256);\n";
                    break;
                case "text":
                    $nr .= "$s3\$table->text('" . $item . "');\n";
                    break;
            }
        }
        $nr .= $nr2 .$nr3 .$nr4;

        return $nr;
    }

    private static function GetSeed($name,$cs)
    {
        $s0 = "   ";
        $s1 = " " .$s0;

        $nr1 = "<?php\n\nuse Illuminate\Database\Seeder;\n\nclass ".$name."Seeder extends Seeder\n{\n$s0 public function run()\n$s1{\n";
        $nr2 = "$s0$s1 factory(App\Models\\$name::class, $cs)->create();\n$s1}\n}\n";

        $nr = $nr1 . $nr2;

        return $nr;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2018/9/26
 * Time: 8:58
 */

declare(strict_types=1);

namespace Drc\AutoMaker;

use Drc\AutoMaker\Configration\ConfigControl;
use Drc\AutoMaker\Control\abstractFormat;

class MakeControl extends abstractFormat
{
    const Version = "V1.0.0";

    public static function CreateAll()
    {
        self::Create(ConfigControl::getPzDepartment());
        self::Create(ConfigControl::getPzUser());
        self::Create(ConfigControl::getPzRole());
        self::Create(ConfigControl::getPzPermission());
        self::Create(ConfigControl::getPzRolePerm());
        self::Create(ConfigControl::getPzUserRole());
    }

    public static function Create($pz = null)
    {
        if (is_null($pz)) {
            $pz = ConfigControl:: getPzDepartment();
        }

        $s1 = "    ";
        $qxspace = "";
        if ($pz["qxflag"]) {
            $qxspace = $s1;
        }

        $nr = static::GetPre($pz["classname"], $pz["namespace"], $pz["OverrideClassname"], $pz["usearray"]);
        $nr .= static::GetConstruct($pz["classname"], $pz["namespace"]);
        $nr .= static::GetIndex($pz["classname"], $pz["Overrideindex"], $pz["cxflag"], $pz["cxkeyname"], $pz["cxnrname"], $pz["cxhsname"], $pz["pageflag"], $pz["qxflag"], $pz["qxindex"], $qxspace);
        $nr .= static::GetCreate($pz["showcreate"], $pz["belongto"], $pz["selectcreate"], $pz["qxflag"], $pz["qxcreate"], $qxspace);
        $nr .= static::GetStore($pz["showcreate"], $pz["classname"], $pz["vaildcreate"], $pz["qxflag"], $pz["qxcreate"], $qxspace, $pz["addstore"]);
        $nr .= static::GetShow($pz["classname"], $pz["OverrideClassname"], $pz["qxflag"], $pz["qxshow"], $qxspace);
        $nr .= static::GetEdit($pz["belongto"], $pz["classname"], $pz["OverrideClassname"], $pz["Overrideedit"], $pz["qxflag"], $pz["qxedit"], $qxspace);
        $nr .= static::GetUpdate($pz["classname"], $pz["Overrideupdate"], $pz["ignoreupdate"], $pz["vaildedit"], $pz["qxflag"], $pz["qxedit"], $qxspace, $pz["addupdate"]);
        $nr .= static::GetDestroy($pz["showdelete"], $pz["classname"], $pz["qxflag"], $pz["qxdelete"], $qxspace);

        $nr .= "}\n";

        static::CreateDir($pz["namespace"],"app\\Http\\Controllers");
        static::WritetoFile($pz["namespace"], $pz["classname"] . "Controller.php", $nr,"app\\Http\\Controllers");
    }

    private static function GetPre($classname, $namespace, $OverrideClassname, $usearray)
    {
        $user = "yfdrc";
        $date = date("Y-m-d");
        $time = date("H:i");

        $nr = "<?php\n/**\n * Created by AutoMaker from drc/tools.\n * User: $user\n * Date: $date\n * Time: $time\n */\n\n";
        $nr .= "namespace App\Http\Controllers\\" . $namespace . ";\n\n";
        $nr .= "use App\Http\Controllers\\Controller;\nuse Illuminate\Http\Request;\nuse App\Models\Role;\n";
        if ("Role" != $classname & $OverrideClassname == "") $nr .= "use App\Models\\" . $classname . ";\n";
        foreach ($usearray as $item) {
            $nr .= "use " . $item . ";\n";
        }
        $nr .= "\n";
        return $nr;
    }

    private static function GetConstruct($classname, $namespace)
    {
        $s0 = "   ";
        $s1 = $s0 . " ";
        $s2 = $s1 . $s1;
        $sm = "$s1/**\n$s1* Create a new controller instance.\n$s1*\n$s1* @return void\n$s1*/\n";
        $nr = $sm . "class " . $classname . "Controller extends Controller\n{\n$s0 protected \$urltoparent;\n$s0 protected \$urltoview;\n\n";
        $nr .= "$s1/**\n$s1* Create a new controller instance.\n$s1*\n$s1* @return void\n$s1*/\n";
        $pathclass = $namespace . "\\" . $classname;
        $pathview = str_replace("/", ".", str_replace("\\", ".", $namespace)) . "." . $classname;
        if ($namespace == "") {
            $pathclass = $classname;
            $pathview = $classname;
        }
        $nr .= "$s0 public function __construct()\n$s1{\n$s2\$this->urltoparent = url(\"$pathclass\");\n$s2\$this->urltoview = \"$pathview\";\n$s1}\n\n";
        return $nr;
    }

    private static function GetIndex($classname, $Overrideindex, $cxflag, $cxkeyname, $cxnrname, $cxhsname, $pageflag, $qxflag = false, $qxindex = "", $qxspace = "")
    {
        $s0 = "   ";
        $s1 = $s0 . " ";
        $s2 = $s1 . $s1;
        $s3 = $s2 . $s1;
        $s4 = $s3 . $s1;
        $smindex = "$s1/**\n$s1* Display a listing of the resource.\n$s1*\n$s1* @return \Illuminate\Http\Response\n$s1*/\n";

        if ($cxflag || $pageflag) {
            $nr = $smindex . "$s0 public function index(Request \$request)\n";
        } else {
            $nr = $smindex . "$s0 public function index()\n";
        }
        $nr .= "$s1{\n" . self::checkQx($qxindex, $qxflag, $s2);
        $cxtemp = "";
        if ($cxflag && $pageflag) {
            $cxtemp .= "$s3\$cachename = \"" . $cxnrname . "\";\n";
            $cxtemp .= "$s3\$cachevalue = \"" . $cxhsname . "\";\n";
            $cxtemp .= "$s2$s0 if(!\$request->exists(\"xshs\")){\n";
            $cxtemp .= "$s4\$cxnr = Cache::get(\$cachename);\n";
            $cxtemp .= "$s4\$xshs = Cache::get(\$cachevalue);\n";
            $cxtemp .= "$s3$s0 if (!is_numeric(\$xshs) || \$xshs < 1) { \$xshs = 10; Cache::forever(\$cachevalue, \$xshs); }\n";
            $cxtemp .= "$s3}else {\n";
            $cxtemp .= "$s4\$cxnr = \$request[\"cxnr\"];\n";
            $cxtemp .= "$s3$s0 Cache::forever(\$cachename, \$cxnr);\n";
            $cxtemp .= "$s4\$xshs = \$request[\"xshs\"];\n";
            $cxtemp .= "$s3$s0 if (!is_numeric(\$xshs) || \$xshs < 1) { \$xshs = 10; }\n";
            $cxtemp .= "$s3$s0 Cache::forever(\$cachevalue, \$xshs);\n";
            $cxtemp .= "$s3}\n";
            $cxtemp .= "$s3\$cxtj = '%' . \$cxnr . '%';\n";
        } else {
            if ($cxflag) {
                $cxtemp .= "$s3\$cachename = \"" . $cxnrname . "\";\n";
                $cxtemp .= "$s2$s0 if(!\$request->exists(\"cxnr\")){\n";
                $cxtemp .= "$s4\$cxnr = Cache::get(\$cachename);\n";
                $cxtemp .= "$s3}else {\n";
                $cxtemp .= "$s4\$cxnr = \$request[\"cxnr\"];\n";
                $cxtemp .= "$s3$s0 Cache::forever(\$cachename, \$cxnr);\n";
                $cxtemp .= "$s3}\n";
                $cxtemp .= "$s3\$cxtj = '%' . \$cxnr . '%';\n";
            }
            if ($pageflag) {
                $cxtemp .= "$s3\$cachevalue = \"" . $cxhsname . "\";\n";
                $cxtemp .= "$s2$s0 if(!\$request->exists(\"xshs\")){\n";
                $cxtemp .= "$s4\$xshs = Cache::get(\$cachevalue);\n";
                $cxtemp .= "$s3$s0 if (!is_numeric(\$xshs) || \$xshs < 1) { \$xshs = 10; Cache::forever(\$cachevalue, \$xshs); }\n";
                $cxtemp .= "$s3}else {\n";
                $cxtemp .= "$s4\$xshs = \$request[\"xshs\"];\n";
                $cxtemp .= "$s3$s0 if (!is_numeric(\$xshs) || \$xshs < 1) { \$xshs = 10; }\n";
                $cxtemp .= "$s3$s0 Cache::forever(\$cachevalue, \$xshs);\n";
                $cxtemp .= "$s3}\n";
            }
        }
        $nr .= $cxtemp;
        if ($Overrideindex == []) {
            if ($cxflag) {
                if ($pageflag) {
                    $nr .= "$s2$qxspace\$models = " . $classname . "::where('" . $cxkeyname . "', 'like', \$cxtj)->paginate(\$xshs);\n";
                } else {
                    $nr .= "$s2$qxspace\$models = " . $classname . "::where('" . $cxkeyname . "', 'like', \$cxtj)->get();\n";
                }
            } else {
                if ($pageflag) {
                    $nr .= "$s2$qxspace\$models = " . $classname . "::paginate(\$xshs);\n";
                } else {
                    $nr .= "$s2$qxspace\$models = " . $classname . "::get();\n";
                }
            }
            $nr .= "$s2$qxspace" . self::reViewModel("index", "models", "tasks") . self::checkQxend($qxflag, $s2) . "$s1}\n\n";
        } else {
            foreach ($Overrideindex as $key => $value) {
                $nr .= "$s2$qxspace\$$key = $value;\n";
            }
            $nr .= "$s2$qxspace" . self::reViewArr("index", $Overrideindex) . self::checkQxend($qxflag, $s2) . "$s1}\n\n";
        }
        return $nr;
    }

    private static function GetCreate($showflag, $belongto, $selectcreate, $qxflag = false, $qxcreate = "", $qxspace = "")
    {
        if (!$showflag) return "";
        $s0 = "   ";
        $s1 = $s0 . " ";
        $s2 = $s1 . $s1;
        $smcrete = "$s1/**\n$s1* Show the form for creating a new resource.\n$s1*\n$s1* @return \Illuminate\Http\Response\n$s1*/\n";
        $nr = $smcrete . "$s0 public function create()\n$s1{\n" . self::checkQx($qxcreate, $qxflag, $s2);
        if ($selectcreate == []) {
            if ($belongto == []) {
                $nr .= "$s2$qxspace" . self::reView("create");
            } else{
                foreach ($belongto as $key=>$value) {
                    $nr .= "$s2$qxspace\$$key = drc_selectAll(\"$key"."s\");\n";
                }
                $nr .= "$s2$qxspace" . self::reViewArr("create", $belongto);
            }
        } else {
            foreach ($selectcreate as $key => $value) {
                $nr .= "$s2$qxspace\$$key = $value;\n";
            }
            $nr .= "$s2$qxspace" . self::reViewArr("create", $selectcreate);
        }
        $nr .= self::checkQxend($qxflag, $s2) . "$s1}\n\n";
        return $nr;
    }

    private static function GetStore($showflag, $classname, $vaildcreate, $qxflag = false, $qxcreate = "", $qxspace = "", $addstores = [])
    {
        if (!$showflag) return "";
        $s0 = "   ";
        $s1 = $s0 . " ";
        $s2 = $s1 . $s1;
        $smstore = "$s1/**\n$s1* Store a newly created resource in storage.\n$s1*\n$s1* @param  \Illuminate\Http\Request \$request\n$s1* @return \Illuminate\Http\Response\n$s1*/\n";
        $nr = $smstore . "$s0 public function store(Request \$request)\n$s1{\n";
        $nr = $nr . self::checkQx($qxcreate, $qxflag, $s2);
        if ($vaildcreate != "") $nr .= "$s2$qxspace\$this->validate(\$request, " . $vaildcreate . ");\n";
        $nr .= "$s2$qxspace\$input = \$request->all();\n";
        foreach ($addstores as $addstore){
            $nr .= "$s2$qxspace$addstore;\n";
        }
        $nr .= "$s2$qxspace" . $classname . "::create(\$input);\n$s2$qxspace" . self::reParent();
        if ($qxflag) {
            $nr .= "$s2}\n$s2" . self::reParentErr("你没有新建权限。") . "$s1}\n\n";
        } else {
            $nr .= "$s1}\n\n";
        }
        return $nr;
    }

    private static function GetShow($classname, $OverrideClassname, $qxflag = false, $qxshow = "", $qxspace = "")
    {
        $s0 = "   ";
        $s1 = $s0 . " ";
        $s2 = $s1 . $s1;
        $smshow = "$s1/**\n$s1* Display the specified resource.\n$s1*\n$s1* @param  int \$id\n$s1* @return \Illuminate\Http\Response\n$s1*/\n";
        $nr = $smshow . "$s0 public function show(\$id)\n$s1{\n" . self::checkQx($qxshow, $qxflag, $s2);
        if ($OverrideClassname == "") {
            $nr .= "$s2$qxspace\$model = " . $classname . "::findOrFail(\$id);\n";
        } else {
            $nr .= "$s2$qxspace\$model = " . $OverrideClassname . "::findOrFail(\$id);\n";
        }
        $nr .= "$s2$qxspace" . self::reViewModel("show", "model");
        if ($qxflag) {
            $nr .= "$s2}\n$s2" . self::reParentErr("你没有详情权限。") . "$s1}\n\n";
        } else {
            $nr .= "$s1}\n\n";
        }
        return $nr;
    }

    private static function GetEdit($belongto, $classname, $OverrideClassname, $Overrideedit, $qxflag = false, $qxedit = "", $qxspace = "")
    {
        $s0 = "   ";
        $s1 = $s0 . " ";
        $s2 = $s1 . $s1;
        $smedit = "$s1/**\n$s1* Show the form for editing the specified resource.\n$s1*\n$s1* @param  int \$id\n$s1* @return \Illuminate\Http\Response\n$s1*/\n";
        $nr = $smedit . "$s0 public function edit(\$id)\n$s1{\n";
        $nr .= self::checkQx($qxedit, $qxflag, $s2);
        if ($Overrideedit==[]) {
            if ($OverrideClassname == "") $OverrideClassname = $classname;
            if ($belongto == []) {
                $nr .= "$s2$qxspace\$model = " . $OverrideClassname . "::findOrFail(\$id);\n";
                $nr .= "$s2$qxspace" . self::reViewModel("edit", "model");
            } else {
                $nr .= "$s2$qxspace\$model = " . $OverrideClassname . "::findOrFail(\$id);\n";
                foreach ($belongto as $key=>$value) {
                    $nr .= "$s2$qxspace\$$key = drc_selectAll(\"$key"."s\");\n";
                }
                $nr .= "$s2$qxspace" . self::reViewArrmodel("edit", $belongto);
            }
        } else {
            if ($OverrideClassname == "") $OverrideClassname = $classname;
            $nr .= "$s2$qxspace\$model = " . $OverrideClassname . "::findOrFail(\$id);\n";
            foreach ($Overrideedit as $key => $value) {
                $nr .= "$s2$qxspace\$$key = $value;\n";
            }
            $nr .= "$s2$qxspace" . self::reViewArrmodel("edit", $Overrideedit);
        }
        if ($qxflag) {
            $nr .= "$s2}\n$s2" . self::reParentErr("你没有编辑权限。") . "$s1}\n\n";
        } else {
            $nr .= "$s1}\n\n";
        }
        return $nr;
    }

    private static function GetUpdate($classname, $Overrideupdate, $ignoreupdate, $vaildedit, $qxflag = false, $qxedit = "", $qxspace = "", $addupdates=[])
    {
        $s0 = "   ";
        $s1 = $s0 . " ";
        $s2 = $s1 . $s1;
        $s3 = $s2 . $s1;
        $smupdate = "$s1/**\n$s1* Update the specified resource in storage.\n$s1*\n$s1* @param  \Illuminate\Http\Request \$request\n$s1* @param  int \$id\n$s1* @return \Illuminate\Http\Response\n$s1*/\n";
        $nr = $smupdate . "$s0 public function update(Request \$request, \$id)\n$s1{\n";
        $nr .= self::checkQx($qxedit, $qxflag, $s2);
        if ($vaildedit != "") $nr .= "$s2$qxspace\$this->validate(\$request, " . $vaildedit . ");\n";
        if ($Overrideupdate==[]) {
            $nr .= "$s2$qxspace\$model = " . $classname . "::findOrFail(\$id);\n";
            if ($ignoreupdate == "") {
                $nr .= "$s2$qxspace\$input = \$request->all();\n";
            } else if ($ignoreupdate == "password"){
                $nr .= "$s1$qxspace$s0 if(\$request[\"" . $ignoreupdate . "\"]==\"\"){\n$s3$qxspace\$input = \$request->except([\"password\"]);\n";
                $nr .= "$s2$qxspace}else{\n$s3$qxspace\$input = \$request->all();\n$s3$qxspace\$input[\"password\"] =  bcrypt(\$request[\"password\"]);\n$s2$qxspace}\n";
            }else{
                $nr .= "$s1$qxspace$s0 if(\$request[\"" . $ignoreupdate . "\"]==\"\"){\n$s3$qxspace\$input = \$request->except([\"$ignoreupdate\"]);\n";
                $nr .= "$s2$qxspace}else{\n$s3$qxspace\$input = \$request->all();\n$s2$qxspace}\n";
            }
            foreach ($addupdates as $addupdate){
                $nr .= "$s2$qxspace$addupdate;\n";
            }
            $nr .= "$s2$qxspace\$model->fill(\$input)->save();\n";
        } else {
            foreach ($Overrideupdate as $pzupdate) {
                $nr .= "$s2$qxspace" . $pzupdate . "\n";
            }
        }
        $nr .= "$s2$qxspace" . self::reParent();
        if ($qxflag) {
            $nr .= "$s2}\n$s2" . self::reParentErr("你没有编辑权限。") . "$s1}\n\n";
        } else {
            $nr .= "$s1}\n\n";
        }
        return $nr;
    }

    private static function GetDestroy($showflag, $classname = "", $qxflag = false, $qxdelete = "", $qxspace = "")
    {
        if (!$showflag) return "";
        $s0 = "   ";
        $s1 = $s0 . " ";
        $s2 = $s1 . $s1;
        $smdestory = "$s1/**\n$s1* Remove the specified resource from storage.\n$s1*\n$s1* @param  int \$id\n$s1* @return \Illuminate\Http\Response\n$s1*/\n";
        $nr = $smdestory . "$s0 public function destroy(\$id)\n$s1{\n" . self::checkQx($qxdelete, $qxflag, $s2);
        $nr .= "$s2$qxspace\$model = " . $classname . "::findOrFail(\$id);\n$s2$qxspace\$model->delete();\n$s2$qxspace" . self::reParent();
        if ($qxflag) {
            $nr .= "$s2}\n$s2" . self::reParentErr("你没有删除权限。") . "$s1}\n";
        } else {
            $nr .= "$s1}\n";
        }
        return $nr;
    }
}

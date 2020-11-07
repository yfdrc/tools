<?php
/**
 * Created by AutoMaker from drc/tools.
 * User: yfdrc
 * Date: 2020-11-03
 * Time: 01:25
 */

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function cat(Request $request)
    {
        return response()->json(drc_selectAll("goods","name","cat_id",$request["id"]));
    }

}

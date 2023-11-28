<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Validator;
use App\Models\Shorts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShortsController extends Controller
{
    public function index()
    {
        try {
            $user_id = Auth::user()->id;
            $shorts = Shorts::where('user_id', "=", $user_id)->latest()->paginate(10);
            return response()->json([
                'success' => true,
                'shorts' => $shorts,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function create(Request $request)
    {
        $nowDate = date('d, F, Y g:i A');

        function random_strings($length)
        {
            $str = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            return substr(str_shuffle($str), 0, $length);
        }

        $uniqid = random_strings(6);

        try {
            $validator = Validator::make($request->all(), [
                'url' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $shorts = Shorts::create([
                'user_id' => Auth::user()->id,
                'uniqid' => $uniqid,
                'url' => $request->url,
                'views' => 0,
                'date_at' => $nowDate,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'URL short create successfully',
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function short_info($id)
    {
        try {
            $short = Shorts::where('id', "=", $id)->first();
            return response()->json([
                'success' => true,
                'short' => $short,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }


    public function delete(Shorts $Shorts)
    {
        try {
            if ($Shorts) {
                $Shorts->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Delete successfully',
                ], 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

}

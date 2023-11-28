<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Models\User;
use App\Models\Shorts;
use App\Models\Views;
use App\Models\IpBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class ApiController extends Controller
{
    public function index(Request $request)
    {

    }

    public function short_view(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'uniqid' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $url = 'https://ifconfig.co/json?ip=' . $request->user_ip;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        $ifconfig = json_decode($data);

        if (!empty($ifconfig->asn)) {
            $time_zone = $ifconfig->time_zone;
            $asn = $ifconfig->asn;
            $asn_org = $ifconfig->asn_org;
        } else {
            $time_zone = '';
            $asn = '';
            $asn_org = '';
        }

        $short = Shorts::where('uniqid', $request->uniqid)->first();

        $post_id = $short->id;
        $user_ip = $request->user_ip;
        $method = "GET";
        $host = $request->host;
        $url = $request->url;
        $referer = $request->referer;
        $user_agent = $request->user_agent;
        $country = $request->country;
        $device = $request->device;
        $operating = $request->operating;
        $browser = $request->browser;
        $browser_version = $request->browser_version;

        $date = date('Y-m-d H:i:s');
        $timeNow = strtotime($date);

        // Add 5 minutes
        $timestamp = strtotime($date) + (1 * 60);
        $nextBlock = strtotime($date) + (5 * 60);

        $date_at = date('d, F, Y');

        $visitor = [
            'post_id' => $post_id,
            'user_ip' => $user_ip,
            'method' => $method,
            'host' => $host,
            'url' => $url,
            'referer' => $referer,
            'user_agent' => $user_agent,
            'country' => $country,
            'device' => $device,
            'operating' => $operating,
            'browser' => $browser,
            'browser_version' => $browser_version,
            'time_zone' => $time_zone,
            'asn' => $asn,
            'asn_org' => $asn_org,
            'view_at' => $timestamp,
            'date_at' => $date_at,
        ];

        $views = Views::where('post_id', "=", $post_id)->where('user_ip', "=", $user_ip)->where('date_at', "=", $date_at)->orderBy('id', 'asc')->get();
        $IpBlock = IpBlock::where('user_ip', "=", $user_ip)->first();

        if (!empty($IpBlock)) {
            $block_at = $IpBlock->block_at;

            if ($block_at > $timeNow) {

                foreach ($views as $view) {
                    $del_view = Views::where('id', "=", $view->id)->delete();
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Your IP address has been blocked. Please try again later.',
                ], 400);
            } else {
                $blocks = IpBlock::where('user_ip', "=", $user_ip)->get();
                foreach ($blocks as $block) {
                    $del_view = IpBlock::where('id', "=", $block->id)->delete();
                }
            }
        }

        $viewCount = $views->count();

        if ($viewCount >= 3 && $views[0]->view_at > $timeNow) {
            $user_block = [
                'user_ip' => $user_ip,
                'block' => true,
                'block_at' => $nextBlock,
            ];

            $ipBlock = IpBlock::create($user_block);

            return response()->json([
                'success' => false,
                'message' => 'Your limit has been reached.Please try again later.',
            ], 400);
        }

        $UpdateShort = Shorts::where('id', $post_id)->update([
            'views' => $viewCount,
        ]);

        $ViewsCreate = Views::create($visitor);

        $ViewsUpdate = Views::where('id', $views[0]->id)->update([
            'view_at' => $timestamp,
        ]);

        return response()->json([
            'success' => true,
            'short' => $short,
            'IpBlock' => $IpBlock,
        ]);

    }

}

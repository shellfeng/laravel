<?php
/**
 * 分发任务#
 */
namespace App\Http\Controllers\Redis;

use App\Jobs\ProcessPodcast;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PodcastController extends Controller
{
    /**
     * 保存播客
     * @param Request $request
     */
    public function store (Request $request)
    {
        // 创建播客...

        //dispatch(new ProcessPodcast($request));

        $job = (new ProcessPodcast($request))
            ->delay(Carbon::now()->addMinutes(10));
        dispatch($job);
        dump($job);
    }
}

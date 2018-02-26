<?php

namespace App\Jobs;

//ShouldQueue 接口，该接口表明 Laravel 应该将该任务添加到后台的任务队列中，而不是同步执行
//SerializesModels trait，Eloquent 模型会被优雅的序列化和反序列化 只序列化模型的ID

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;

class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $topic;

    public function __construct(Topic $topic)
    {
        //
        $this->topic = $topic;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    //handle 方法会在队列任务执行时被调用
    public function handle()
    {
        // 请求百度 API 接口进行翻译
        $slug = app(SlugTranslateHandler::class)->translate($this->topic->title);
        // 为了避免模型监控器死循环调用，我们使用 DB 类直接对数据库进行操作
        \DB::table('topics')->where('id', $this->topic->id)->update(['slug' => $slug]);
    }
}

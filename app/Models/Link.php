<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['title', 'link'];

    public $cache_key = 'source_links';

    public $cache_expire_in_minutes = 1440;

    public function getAllCachedLinks()
    {
        // 尝试从缓存中取出 cache_key 对应的数据。如果能取到，便直接返回数据。
        // 否则运行匿名函数中的代码来取出 links 表中所有的数据，返回的同时做了缓存。
        return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function () {
            return $this->orderBy('updated_at', 'desc')->get();
        });
    }
}

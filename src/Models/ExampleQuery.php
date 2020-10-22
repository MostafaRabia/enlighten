<?php

namespace Styde\Enlighten\Models;

use Illuminate\Database\Eloquent\Model;

class ExampleQuery extends Model
{
    protected $connection = 'enlighten';

    protected $table = 'enlighten_example_queries';

    protected $guarded = [];

    protected $casts = [
        'bindings' => 'array',
        'http_data_id' => 'int',
        'snippet_call_id' => 'int',
    ];

    public function http_data()
    {
        return $this->belongsTo(HttpData::class);
    }

    public function snippetCall()
    {
        return $this->belongsTo(ExampleSnippetCall::class);
    }


    // Accessors

    public function getContextAttribute($value)
    {
        return is_null($this->http_data_id) ? 'test' : 'request';
    }
}

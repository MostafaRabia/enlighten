<?php

namespace Styde\Enlighten\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ExampleSnippetCall extends Model
{
    const CLASS_NAME = '--class_name';
    const ATTRIBUTES = '--attributes';

    protected $connection = 'enlighten';

    protected $table = 'enlighten_example_snippet_calls';

    protected $guarded = [];

    protected $casts = [
        'arguments' => 'array',
        'result' => 'array',
    ];

    public function getArgumentsCodeAttribute(): string
    {
        return collect($this->arguments)->map(function ($value, $key) {
            return '$'.$key.' = '.var_export($value, true).';';
        })->implode("\n");
    }

    public function getResultCodeAttribute(): string
    {
        // we need to wrap the object a the top level to make the recursive call consistent
        if ($this->isResultObject($this->result)) {
            $output = array_map([$this, 'mapObjectAttributes'], [$this->result])[0];
        } elseif(is_array($this->result)) {
            $output = array_map([$this, 'mapObjectAttributes'], $this->result);
        } else {
            return var_export($this->result, true);
        }

        $output = json_encode($output, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);

        return trim(Str::after(Str::beforeLast($output, '}'), '{'));

    }

    private function mapObjectAttributes($attrs)
    {
        if (!isset($attrs[static::CLASS_NAME]) && is_array($attrs)) {
            return array_map([$this, 'mapObjectAttributes'], $attrs);
        }

        if (!isset($attrs[static::CLASS_NAME] )) {
            return $attrs;
        }

        return [
            $attrs[static::CLASS_NAME] => array_map([$this, 'mapObjectAttributes'], $attrs[static::ATTRIBUTES])
        ];
    }

    private function isResultObject($value): bool
    {
        return isset($value[static::CLASS_NAME]);
    }

}

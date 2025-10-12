<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'key',
        'name',
        'description',
        'subject',
        'body',
        'available_variables',
        'is_active',
    ];

    protected $casts = [
        'available_variables' => 'array',
        'is_active' => 'boolean',
    ];

    public function render(array $variables = []): string
    {
        $content = $this->body;
        
        foreach ($variables as $key => $value) {
            $content = str_replace("{{" . $key . "}}", $value, $content);
        }
        
        return $content;
    }

    public function renderSubject(array $variables = []): string
    {
        $subject = $this->subject;
        
        foreach ($variables as $key => $value) {
            $subject = str_replace("{{" . $key . "}}", $value, $subject);
        }
        
        return $subject;
    }
}


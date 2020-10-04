<?php

namespace App\Services;

class HtmlSanitizer {
    protected string $subject;

    public function __construct(string $subject)
    {
        $this->subject = $subject;
    }

    public function perform(): string {
        return $this->sanitize();
    }

    private function sanitize(): string {
        $allowedTags = ['img', 'a', 'video', 'audio', 'table', 'tr', 'tbody', 'td', 'thead'];

        return trim(strip_tags($this->subject, $allowedTags));
    }
}

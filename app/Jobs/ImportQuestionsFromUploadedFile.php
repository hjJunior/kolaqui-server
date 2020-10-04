<?php

namespace App\Jobs;

use App\Answer;
use App\Question;
use App\Reply;
use App\UploadedFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;

class ImportQuestionsFromUploadedFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $args;

    public function __construct(UploadedFile $uploadedFile)
    {
        $this->args = ParseAttemptHtmlDocument::dispatchNow($uploadedFile);
    }

    public function handle()
    {
        foreach ($this->args['questions'] as $question) {
            $this->handleQuestion($question);
        }
    }

    private function handleQuestion($questionArgs) {
        $question = Question::firstOrCreate([
            'slug' => $questionArgs['slug']
        ], $questionArgs);

        dump($question);

        $question->save();

        foreach ($questionArgs['answers'] as $answer) {
            $this->addAnswerToQuestion($answer, $question);
        }
    }

    private function addAnswerToQuestion($answerArgs, $question) {
        $answer = Answer::firstOrCreate([
            'checksum' => sha1($answerArgs['pure_content']),
            'question_id' => $question->id,
        ], [
            'content' => $answerArgs['content'],
            'pure_content' => $answerArgs['pure_content'],
        ]);

        $answer->save();

        if ($answerArgs['selected']) {
            $this->addReply([
                'question_id' => $question->id,
                'answer_id' => $answer->id,
                'correct' => $answerArgs['correct'],
            ]);
        }

        return $answer;
    }

    private function addReply($args) {
        $reply = Reply::firstOrCreate($args);
        $reply->save();
    }
}

<?php

namespace App\Jobs;

use App\Mail\MailCvToEnterprise;
use App\Models\Candidate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendCvToEnterprise implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $candidates;

    public $post;

    public $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post, $candidates, $email)
    {
        $this->candidates = $candidates;
        $this->post = $post;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    private function removeSpecialChar($str){
        $res = preg_replace('/[^a-z0-9A-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễếệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]/u',' ', $str);

        return $res;
    }

    public function handle()
    {
        $position = $this->post->position;

        $cvs = [];

        foreach ($this->candidates as $candidate) {
            $file_name = $this->removeSpecialChar($position)
                . ' - '
                . $this->removeSpecialChar($candidate->student_code)
                . '_'
                . $this->removeSpecialChar($candidate->name)
                . '.pdf';

            $fileContents = Storage::disk('s3')->get($candidate->file_link);

            $tempPath = storage_path('app/temp/' . $file_name);

            file_put_contents($tempPath, $fileContents);

            $cvs[] = [
                'path' => $tempPath,
                'as' => $file_name,
                'mime' => 'application/pdf'
            ];
        }

        Mail::to($this->email)->send(new MailCvToEnterprise($this->post, $cvs));

        foreach ($cvs as $cv) {
            unlink($cv['path']);
        }

        Candidate::query()->whereIn('id', $this->candidates->pluck('id'))->update(['status' => 1]);

        $email = new SendEmailWhenSendCvToEnterpriseBCC($this->candidates);

        dispatch($email);
    }
}

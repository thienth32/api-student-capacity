<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SampleChallenge extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'sample_challenge';
    protected $guarded = [];
    protected $appends = [
        'code_run',
    ];
    public function code_language()
    {
        return $this->belongsTo(CodeLanguage::class, 'code_language_id');
    }
    public function challenge()
    {
        return $this->belongsTo(Challenge::class, 'challenge_id');
    }
    public function  getCodeRunAttribute()
    {
        if (request()->is('api/v1/challenge')) return "";
        $PARAMS = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'q', 'k'];
        $code_language = $this->code_language;
        $challenge = $this->challenge->load(['test_case']);
        if (count($challenge->test_case) == 0) return 'No code';
        $input = $challenge->test_case[0]->input;
        $inputs = explode(',', $input);
        array_splice($PARAMS, count($inputs));
        $inputDone = "";
        foreach ($PARAMS as $key => $PARAM) {
            switch ($code_language->type) {
                case 'php':
                    $inputDone .= '$' . $PARAM . (($key == (count($PARAMS) - 1)) ? '' : ',');
                    break;
                case 'javascript':
                    $inputDone .= $PARAM . (($key == (count($PARAMS) - 1)) ? '' : ',');
                    break;
                case 'python':
                    $inputDone .= $PARAM . (($key == (count($PARAMS) - 1)) ? '' : ',');
                    break;
                default:
                    break;
            }
        }
        $code = str_replace('FC', $this->code, config('util.CHALLENEGE')[$code_language->ex]['INOPEN']);
        $code = str_replace('INPUT', $inputDone, $code);
        // $code = trim($code);
        return $code;
    }
}
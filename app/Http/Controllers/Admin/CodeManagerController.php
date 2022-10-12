<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Modules\MChallenge\MChallengeInterface;
use App\Services\Modules\MCodeLanguage\MCodeLanguageInterface;
use App\Services\Modules\MResultCode\MResultCodeInterface;
use Illuminate\Http\Request;

class CodeManagerController extends Controller
{
    public function __construct(
        private MChallengeInterface $challenge,
        private MCodeLanguageInterface $codeLanguage,
        private MResultCodeInterface $resultCode
    ) {
    }

    public function index()
    {
        $data = [];

        return view('pages.code.index', $data);
    }

    public function create()
    {
        $data = [];
        $data['code_languages'] = $this->codeLanguage->getAllCodeLanguage();
        return view('pages.code.create', $data);
    }

    public function store(Request $request)
    {
        dd($request->all());
    }


    private function unlinkFile($path)
    {
        if (file_exists($path))
            unlink($path);
    }

    private function createWriteRemoveAndOpenFile($path = null, $forder = null, $extensionFile = null, $content = null, $flagRemove = false): void
    {
        if ($flagRemove) {
            $this->unlinkFile("$path$forder/output.txt");
            $this->unlinkFile("$path$forder/main.$extensionFile");
            $this->unlinkFile("$path$forder/a.out");
            rmdir($path . $forder);
        } else {
            $mainPhp = fopen($path . $forder . "/main.$extensionFile", 'a+');
            fopen($path . $forder . '/output.txt', 'a+');
            fwrite($mainPhp, $content);
            fclose($mainPhp);
        }
    }

    private function execBashCommand($path = null, $forder = null, $imageBuildDocker = null, $type = null, $extensionFile = null)
    {
        //Command
        $command = "docker run --rm -v $path$forder:$forder $imageBuildDocker $type $forder/main.$extensionFile $forder/output.txt"; // command
        if ($type == "gcc") {
            if ($extensionFile == "cpp") $type  = "c++";
            $command = "docker run --rm -v $path$forder:$forder $imageBuildDocker $type $forder/main.$extensionFile $forder/a.out $forder/output.txt";
        }
        if ($type == "javascript") {
            $type  = "node";
            $command = "docker run --rm -v $path$forder:$forder $imageBuildDocker $type $forder/main.$extensionFile $forder/output.txt";
        }
        $content = exec($command);
        return $content;
    }

    private function readFile($path = null, $forder = null): string
    {
        $read = file("$path$forder/output.txt");
        $result = '';
        foreach ($read as $line) {
            $result .= $line;
        }
        return $result;
    }

    private function acrMultyLgCode($lg = [], $imageBuildDocker = null, $path = null, $content): array
    {
        $extensionFile = $lg['extensionFile'];
        $type = $lg['type'];
        $forder = "/tmp/" . time();
        mkdir($path . $forder, 0777, true);

        $this->createWriteRemoveAndOpenFile($path, $forder, $extensionFile, $content);
        $content = $this->execBashCommand($path, $forder, $imageBuildDocker, $type, $extensionFile);
        $result = $this->readFile($path, $forder);
        $this->createWriteRemoveAndOpenFile($path, $forder, $extensionFile, null, true);

        if ($content == "false") return [
            'result' => $result,
            'time' => $content,
        ];
        return [
            'result' => $result,
            'time' => $content,
        ];
    }

    public function run()
    {
        try {
            $cwd = str_replace("\\", "/", getcwd());
            $cwd = str_replace("/public", "", $cwd);

            $content = request()->content . " ";
            $imageBuildDocker = config('util.NAME_DOCKER') . request()->type;
            $path = $cwd;
            $stout = $this->acrMultyLgCode(
                [
                    "extensionFile" => request()->ex,
                    "type" => request()->type,
                ],
                $imageBuildDocker,
                $path,
                $content
            );
            return $stout;
        } catch (\Throwable $th) {
            return response()->json([
                'error' => "Không thể đưa vào luồng chạy !",
                'time' => false,
            ]);
        }
    }

    private function runCode($id, $type_id, $status_type_code = false)
    {
        $cwd = str_replace("\\", "/", getcwd());
        $cwd = str_replace("/public", "", $cwd);
        $path = $cwd;
        $challenge = $this->challenge->getChallenge(
            $id,
            [
                'test_case' => function ($q) use ($status_type_code) {
                    if ($status_type_code) return $q;
                    return $q
                        ->where("status", 1);
                },
                'sample_code' => function ($q) use ($type_id) {
                    return $q->where('code_language_id', $type_id);
                }
            ]
        );

        $nameDocker = config('util.NAME_DOCKER');
        $codelanguage = $this->codeLanguage->getCodeLanguage($type_id);

        if (!$codelanguage) return [
            "time" => false,
            "result" => "Không tìm thấy ngôn ngữ bạn đang yêu cầu !",
        ];

        $imageBuildDocker = $nameDocker . "$codelanguage->type";

        $extensionFile = $codelanguage->ex;
        $type = $codelanguage->type;

        $RUNDCODE = str_replace("INOPEN", request()->content, config('util.CHALLENEGE')[$type]['TEST_CASE']);
        $OUTPEN = str_replace("FC", $challenge->sample_code[0]->code, config('util.CHALLENEGE')[$type]['OUTPEN']);
        $RUNDCODE = str_replace("OUTPEN", $OUTPEN, $RUNDCODE);

        // $resultend = $challenge->sample_code[0]->code;
        // $fistResultend = explode("(", $resultend)[0] . "(";
        $arrResult = [];

        foreach ($challenge->test_case as $key => $value) {
            $arrSave = [];
            $content = str_replace("INPUT", $value->input, $RUNDCODE);
            // dd($content);
            // $content =  request()->content . $fistResultend . $value->input . ");";
            $stout = $this->acrMultyLgCode(
                [
                    "extensionFile" => $extensionFile,
                    "type" => $type,
                ],
                $imageBuildDocker,
                $path,
                $content
            );
            $resultStout = str_replace("\n", "", $stout['result']);
            if ($stout['time'] != "false") {
                if (trim($resultStout) != $value->output) $stout = [
                    'time' => $stout['time'],
                    'result' => $resultStout,
                    'flag' => false,
                    'hasError' => false
                ];
                if (trim($resultStout) == $value->output) $stout = array_merge($stout, ['flag' => true, 'hasError' => false]);
            } else {
                $stout = array_merge($stout, ['flag' => false, 'hasError' => true]);
            }
            $arrSave = array_merge($arrSave, [...$value->toArray(), ...$stout]);
            array_push($arrResult, $arrSave);
        }
        return $arrResult;
    }

    public function runCodechall($id)
    {
        try {
            $arrResult = $this->runCode($id, request()->type_id, false);
            return $arrResult;
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage() . 'LINE : ' . $th->getLine(),
                'time' => false,
            ]);
        }
    }

    public function runCodeSubmitChall($id)
    {
        try {
            $arrResult = $this->runCode($id, request()->type_id, true);
            $flag = 0;
            $flagPass = false;
            $flagUpdate = false;
            $flagStatusReturn = false;
            foreach ($arrResult as $k => $v) {
                if ($v['flag'] == true) $flag++;
            }

            if ($result = $this->resultCode->getResultCodeByAuthAndChallenge($id)) $flagUpdate = true;

            if ($flag === count($arrResult)) {
                $flagPass = true;
                $challenge =  $this->challenge->getChallenge($id);
                if ($flagUpdate) {

                    $flagPoint = $result->flag_run_code + 1;
                    $pointSv = ($flagPoint == 2
                        ? $challenge->rank_point->top2
                        : $flagPoint == 3)
                        ?  $challenge->rank_point->top3
                        :  $challenge->rank_point->leave;
                    if ($result->point > 0) {
                        $pointSv = $result->point;
                    } else {
                        $flagStatusReturn = true;
                    }
                    $dataUpdate = [
                        "code_result" => request()->content,
                        "flag_run_code" => $flagPoint,
                        "code_language_id" => request()->type_id,
                        "point" => $pointSv,
                        'status' => 1
                    ];
                } else {
                    $dataCreate = [
                        "user_id" => auth('sanctum')->user()->id,
                        "challenge_id" => $id,
                        "code_result" => request()->content,
                        "flag_run_code" => 1,
                        "point" => $challenge->rank_point->top1,
                        "code_language_id" => request()->type_id,
                    ];
                    $flagStatusReturn = true;
                }
            } else {
                if ($flagUpdate) {
                    $flagPoint = $result->flag_run_code + 1;
                    $pointDD = 0;
                    if ($result->point > 0) $pointDD = $result->point;
                    $dataUpdate = [
                        "code_result" => request()->content,
                        "flag_run_code" => $flagPoint,
                        "point" => $pointDD,
                        "code_language_id" => request()->type_id,
                    ];
                } else {
                    $dataCreate = [
                        "user_id" => auth('sanctum')->user()->id,
                        "challenge_id" => $id,
                        "code_language_id" => request()->type_id,
                        "code_result" => request()->content,
                        "flag_run_code" => 1,
                        "point" => 0
                    ];
                }
            }
            if ($flagUpdate) $this->resultCode->updateResultCode($result, $dataUpdate);
            if (!$flagUpdate) $result = $this->resultCode->createResultCode($dataCreate);

            if ($flagPass) return response()->json(
                [
                    "status" => $flagStatusReturn,
                    "data_result" => $result,
                    "data" => $arrResult
                ]
            );
            return response()->json(
                [
                    "status" => $flagStatusReturn,
                    "data_result" => $result,
                    "data" => $arrResult
                ]
            );
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage() . 'LINE : ' . $th->getLine(),
                'time' => false,
            ]);
        }
    }

    public function getCodechallAll()
    {
        return response()->json([
            "status" => true,
            "payload" => $this->challenge->getChallenges(['limit' => request()->limit ?? 10], ['sample_code']),
        ]);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\CodeLanguage;
use Illuminate\Http\Request;

class CodeManagerController extends Controller
{
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
        // dd($command);
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
        $challenge = Challenge::whereId($id)
            ->with(
                [
                    'type_test' => function ($q) use ($status_type_code) {
                        if ($status_type_code) return $q;
                        return $q
                            ->where("status", 1);
                    },
                    'has_cod' => function ($q) use ($type_id) {
                        return $q->where('type_id', $type_id);
                    }
                ]
            )
            ->first();
        $nameDocker = config('util.NAME_DOCKER');
        $codelanguage = CodeLanguage::find($type_id);

        if (!$codelanguage) return [
            "time" => false,
            "result" => "Không tìm thấy ngôn ngữ bạn đang yêu cầu !",
        ];

        $imageBuildDocker = $nameDocker . "$codelanguage->type";

        $extensionFile = $codelanguage->ex;
        $type = $codelanguage->type;

        $path = "/home/vanquang/Htdocs/laravel/LaravelCodChallenge";

        $resultend = $challenge->has_cod[0]->run_qs_code;
        $fistResultend = explode("(", $resultend)[0] . "(";
        $arrResult = [];

        foreach ($challenge->type_test as $key => $value) {
            $arrSave = [];
            $content =  request()->content . $fistResultend . $value->input . ");";
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

            if ($stout['time'] !== "false") {
                if ($resultStout != $value->output) $stout = [
                    'time' => false,
                    'result' => $resultStout,
                    'flag' => false,
                    'hasError' => false
                ];
                if ($resultStout == $value->output) $stout = array_merge($stout, ['flag' => true, 'hasError' => false]);
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
            dd($th->getMessage());
            return response()->json([
                'error' => "Không thể đưa vào luồng chạy !",
                'time' => false,
            ]);
        }
    }

    // public function runCodeSubmitChall($id)
    // {
    //     try {
    //         $arrResult = $this->runCode($id, request()->type_id, true);
    //         $flag = 0;
    //         $flagPass = false;
    //         $flagUpdate = false;
    //         $flagStatusReturn = false;
    //         foreach ($arrResult as $k => $v) {
    //             if ($v['time'] !== false) $flag++;
    //         }


    //         if ($result = Resul::where('user_id', 1)->where("challenge_id", $id)->first()) $flagUpdate = true;
    //         if ($flag === count($arrResult)) {
    //             $flagPass = true;
    //             $challenge =  Challenge::find($id);
    //             if ($flagUpdate) {
    //                 $flagPoint = $result->flag_point + 1;
    //                 $pointSv = ($flagPoint == 2
    //                     ? $challenge->rank_point->top2
    //                     : $flagPoint == 3)
    //                     ?  $challenge->rank_point->top3
    //                     :  $challenge->rank_point->none;
    //                 if ($result->point > 0) {
    //                     $pointSv = $result->point;
    //                 } else {
    //                     $flagStatusReturn = true;
    //                 }
    //                 $dataUpdate = [
    //                     "content" => request()->content,
    //                     "flag_point" => $flagPoint,
    //                     "type_id" => request()->type_id,
    //                     "point" => $pointSv
    //                 ];
    //             } else {
    //                 $dataCreate = [
    //                     "user_id" => auth('sanctum')->user()->id,
    //                     "challenge_id" => $id,
    //                     "content" => request()->content,
    //                     "flag_point" => 1,
    //                     "point" => $challenge->rank_point->top1,
    //                     "type_id" => request()->type_id,
    //                 ];
    //                 $flagStatusReturn = true;
    //             }
    //         } else {
    //             if ($flagUpdate) {
    //                 $flagPoint = $result->flag_point + 1;
    //                 $pointDD = 0;
    //                 if ($result->point > 0) $pointDD = $result->point;
    //                 $dataUpdate = [
    //                     "content" => request()->content,
    //                     "flag_point" => $flagPoint,
    //                     "point" => $pointDD,
    //                     "type_id" => request()->type_id,
    //                 ];
    //             } else {
    //                 $dataCreate = [
    //                     "user_id" => auth('sanctum')->user()->id,
    //                     "challenge_id" => $id,
    //                     "type_id" => request()->type_id,
    //                     "content" => request()->content,
    //                     "flag_point" => 1,
    //                     "point" => 0
    //                 ];
    //             }
    //         }
    //         if ($flagUpdate) $result->update($dataUpdate);
    //         if (!$flagUpdate) $result = Result::create($dataCreate);

    //         if ($flagPass) return response()->json(
    //             [
    //                 "status" => $flagStatusReturn,
    //                 "data_result" => $result,
    //                 "data" => $arrResult
    //             ]
    //         );
    //         return response()->json(
    //             [
    //                 "status" => $flagStatusReturn,
    //                 "data_result" => $result,
    //                 "data" => $arrResult
    //             ]
    //         );
    //     } catch (\Throwable $th) {
    //         dd($th->getMessage());
    //         return response()->json([
    //             'error' => "Không thể đưa vào luồng chạy !",
    //             'time' => false,
    //         ]);
    //     }
    // }

    public function getCodechall($id)
    {
        return response()->json([
            "status" => true,
            "payload" => Challenge::find($id)->load(['type_test' => function ($q) {
                return $q
                    ->where("status", 1);
            }, 'has_cod', 'result' => function ($q) {
                $id = auth('sanctum')->user()->id;
                return $q->where('user_id', $id);
            }]),
        ]);
    }

    public function getCodechallAll()
    {
        return response()->json([
            "status" => true,
            // "payload" => Challenge::with(['has_cod'])->paginate(request()->limit ?? 10),
        ]);
    }
}
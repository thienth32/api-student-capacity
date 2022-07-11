<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class QuestionsImport implements ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection  $rows)
    {
        foreach ($rows as $row) {
            Question::create([
                'content' => $row[0],
                'status' => $row[1],
                'type' => $row[2],
                'rank' => $row[3],
            ]);
        }
    }
}

<?php

namespace App\Exports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class QuestionsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'id',
            'content',
            'status',
            'type',
            'rank'
        ];
    }

    public function map($question): array
    {
        return [
            $question->id,
            $question->content,
            $question->status,
            $question->type,
            $question->rank
        ];
    }
    public function collection()
    {
        return Question::all();
    }
}

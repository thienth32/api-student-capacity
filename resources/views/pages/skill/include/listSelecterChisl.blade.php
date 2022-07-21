@if ($majorPrent->majorChils->count())
    @php
        $dash .= '-- ';
    @endphp
    @foreach ($majorPrent->majorChils as $majorChirent)
        <option
            @foreach ($major->majorSkill as $item) @if ($item->id == $majorChirent->id)
        {{ 'selected="selected"' }} @endif
            @endforeach
            value="{{ $majorChirent->id }}">{{ $dash . $majorChirent->name }}
        </option>
        @if ($majorChirent->majorChils->count())
            @include('pages.skill.include.listSelecterChisl', [
                'majorPrent' => $majorChirent,
                'major' => $major,
            ])
        @endif
    @endforeach
@endif

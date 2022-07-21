@if ($majorPrent->majorChils->count())
    @php
        $dash .= '-- ';
    @endphp
    @foreach ($majorPrent->majorChils as $majorChirent)
        <option {{ collect(old('major_id'))->contains($majorChirent->id) ? 'selected' : '' }}
            value="{{ $majorChirent->id }}">{{ $dash . $majorChirent->name }}
        </option>
        @if ($majorChirent->majorChils->count())
            @include('pages.skill.include.listSelecterChislAdd', [
                'majorPrent' => $majorChirent,
            ])
        @endif
    @endforeach
@endif

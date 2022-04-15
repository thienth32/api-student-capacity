@if ($majorPrent->majorChils->count())
    @php
        $dash .= '-- ';
    @endphp
    @foreach ($majorPrent->majorChils as $majorChirent)
        <option @selected(request('major_id') == $majorChirent->id) value="{{ $majorChirent->id }}">{{ $dash . $majorChirent->name }}
        </option>
        @if ($majorChirent->majorChils->count())
            @include('pages.major.include.listSelecterChislAdd', [
                'majorPrent' => $majorChirent,
            ])
        @endif
    @endforeach
@endif

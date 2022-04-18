@if ($majorPrent->majorChils->count())
    @php
        $dash .= '-- ';
    @endphp
    @foreach ($majorPrent->majorChils as $majorChirent)
        @if ($major->parent !=null)
            <option @selected($major->parent->id == $majorChirent->id) value="{{ $majorChirent->id }}">{{ $dash . $majorChirent->name }}
            </option>
        @else
            <option value="{{ $majorChirent->id }}">{{ $dash . $majorChirent->name }}
            </option>
        @endif
        @if ($majorChirent->majorChils->count())
            @include('pages.major.include.listSelecterChisl', [
                'majorPrent' => $majorChirent,
            ])
        @endif
    @endforeach
@endif

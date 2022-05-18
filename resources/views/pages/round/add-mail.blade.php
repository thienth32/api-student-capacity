@component('components.mails.index', ['round' => $round, 'judges' => $judges, 'users' => $users])
    @slot('bred')
        <div class=" mb-4">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb text-muted fs-6 fw-bold">
                        <li class="breadcrumb-item pe-3">
                            <a href="{{ route('admin.contest.list') }}" class="pe-3">Cuộc thi </a>
                        </li>
                        <li class="breadcrumb-item px-3 ">
                            <a href="{{ route('admin.contest.show', ['id' => $round->contest->id]) }}" class="pe-3">
                                {{ $round->contest->name }}
                            </a>
                        </li>
                        <li class="breadcrumb-item pe-3">
                            <a href="{{ route('admin.contest.detail.round', ['id' => $round->contest_id]) }}"
                                class="pe-3">Vòng thi </a>
                        </li>
                        <li class="breadcrumb-item px-3 text-muted">
                            <a href="{{ route('admin.round.detail', ['id' => $round->id]) }}"
                                class="pe-3">{{ $round->name }}
                            </a>

                        </li>
                        <li class="breadcrumb-item px-3 text-muted">Thông báo </li>
                    </ol>
                </div>
            </div>
        </div>
    @endslot
    @slot('link')
        {{ route('round.send.mail.pass', ['id' => $round->id]) }}
    @endslot
@endcomponent

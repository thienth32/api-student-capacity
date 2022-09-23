@component('components.mails.index', ['contest' => $contest, 'users' => $users, 'judges' => $judges])
    @slot('bred')
        <div class=" mb-4">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb text-muted fs-6 fw-bold">
                        <li class="breadcrumb-item pe-3">
                            <a href="{{ route('admin.contest.list') }}" class="pe-3">
                                Danh sách cuộc thi</a>
                        </li>
                        <li class="breadcrumb-item px-3 text-muted"> <a
                                href="{{ route('admin.contest.show', ['id' => $contest->id]) }}" class="pe-3">
                                {{ $contest->name }}</a></li>
                        <li class="breadcrumb-item px-3 text-muted">Thông báo</li>
                    </ol>
                </div>
            </div>
        </div>
    @endslot
    @slot('link')
        {{ route('contest.send.mail.pass', ['id' => $contest->id]) }}
    @endslot
@endcomponent

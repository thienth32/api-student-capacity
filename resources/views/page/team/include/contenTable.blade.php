<?php $index = 0; ?>
@foreach ($dataTeam as $valueTeam)
    <tr>
        <th scope="row">{{ $index += 1 }}</th>
        <td>{{ $valueTeam->name }}</td>
        <td><img style="width:200px;height:200px"
                src="{{ Storage::disk('google')->has($valueTeam->image)? Storage::disk('google')->url($valueTeam->image): 'https://skillz4kidzmartialarts.com/wp-content/uploads/2017/04/default-image.jpg' }}"
                alt=""></td>
        <td>{{ $valueTeam->contest->name }}</td>
        <td>{{ date('d-m-Y', strtotime($valueTeam->created_at)) }}</td>
        <td>
            <div class="btn-group dropup">
                <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Xem Thêm...
                </button>
                <ul class="dropdown-menu">

                    @foreach ($valueTeam->members as $member)
                        <li><a class="dropdown-item" href="javascript:void()"> Thành Viên
                                : {{ $member->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </td>
        >
        <td> <a onclick="removeTeam({{ $valueTeam->id }})" data-url="{{ route('admin.delete.teams', $valueTeam->id) }}" id="{{ $valueTeam->id }}"
                class="btn btn-danger deleteTeams"><i class="fas fa-trash-alt"></i></a>
            <a href="{{ route('admin.teams.edit', $valueTeam->id) }}" class="btn  btn-success "><i
                    class="fas fa-edit"></i></a>
        </td>
    </tr>
@endforeach


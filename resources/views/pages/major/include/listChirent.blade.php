@if($majorPrent->majorChils->count())

@php
    $dash .= '-- ';
@endphp
    @foreach ($majorPrent->majorChils  as $majorChirent)
        <tr>
            {{-- @if (request()->has('sort'))
                <th scope="row">
                    @if (request('sort') == 'desc')
                        {{ (request()->has('page') && request('page') !== 1 ? $majorChirent->perPage() * (request('page') - 1) : 0) +$key +1 }}
                    @else
                        {{ request()->has('page') && request('page') !== 1? $total - $majorChirent->perPage() * (request('page') - 1) - $key: ($total -= 1) }}
                    @endif
                </th>
            @else
                <th scope="row">
                    {{ (request()->has('page') && request('page') !== 1 ? $majorChirent->perPage() * (request('page') - 1) : 0) +$key +1 }}
                </th>
            @endif --}}
            <td></td>
            <td>{{$dash. $majorChirent->name }}

            </td>
            <td>{{ $majorChirent->slug }}

            </td>
            <td>
                <div class="btn-group dropstart">
                    <button type="button" class="btn   btn-sm dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <span class="svg-icon svg-icon-success svg-icon-2x">
                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/General/Settings-2.svg--><svg
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                        fill="#000000" />
                                </g>
                            </svg>

                        </span>
                    </button>
                    <ul class="dropdown-menu ps-5   ">
                        <li class="py-3">
                            <a href="{{ route('admin.major.edit', ['slug' => $majorChirent->slug]) }}">
                                <span role="button" class="svg-icon svg-icon-success svg-icon-2x">
                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Design/Edit.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) " />
                                            <rect fill="#000000" opacity="0.3" x="5" y="20" width="15"
                                                height="2" rx="1" />
                                        </g>
                                    </svg>
                                    Chỉnh sửa
                                </span>
                            </a>
                        </li>
                        <li class="py-3">

                            @hasrole(config('util.ROLE_DELETE'))
                                <form action="{{ route('admin.major.destroy', ['slug' => $majorChirent->slug]) }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <button onclick="return confirm('Bạn có chắc muốn xóa không !')"
                                        style=" background: none ; border: none ; list-style : none"
                                        type="submit">
                                        <span role="button" class="svg-icon svg-icon-danger svg-icon-2x">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none"
                                                    fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path
                                                        d="M6,8 L18,8 L17.106535,19.6150447 C17.04642,20.3965405 16.3947578,21 15.6109533,21 L8.38904671,21 C7.60524225,21 6.95358004,20.3965405 6.89346498,19.6150447 L6,8 Z M8,10 L8.45438229,14.0894406 L15.5517885,14.0339036 L16,10 L8,10 Z"
                                                        fill="#000000" fill-rule="nonzero" />
                                                    <path
                                                        d="M14,4.5 L14,3.5 C14,3.22385763 13.7761424,3 13.5,3 L10.5,3 C10.2238576,3 10,3.22385763 10,3.5 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                                        fill="#000000" opacity="0.3" />
                                                </g>
                                            </svg>
                                            Xóa bỏ
                                        </span>
                                    </button>
                                </form>
                            @else
                                <span style="cursor: not-allowed; user-select: none"
                                    class="svg-icon svg-icon-danger svg-icon-2x">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                                            <path
                                                d="M14.5,11 C15.0522847,11 15.5,11.4477153 15.5,12 L15.5,15 C15.5,15.5522847 15.0522847,16 14.5,16 L9.5,16 C8.94771525,16 8.5,15.5522847 8.5,15 L8.5,12 C8.5,11.4477153 8.94771525,11 9.5,11 L9.5,10.5 C9.5,9.11928813 10.6192881,8 12,8 C13.3807119,8 14.5,9.11928813 14.5,10.5 L14.5,11 Z M12,9 C11.1715729,9 10.5,9.67157288 10.5,10.5 L10.5,11 L13.5,11 L13.5,10.5 C13.5,9.67157288 12.8284271,9 12,9 Z"
                                                fill="#000000" />
                                        </g>
                                    </svg>
                                    Xóa bỏ
                                </span>
                            @endhasrole


                        </li>

                    </ul>
                </div>

            </td>
        </tr>
        @if($majorChirent->majorChils->count())
            @include('pages.major.include.listChirent',['majorPrent'=>$majorChirent])
        @endif

    @endforeach
@endif

@extends('layouts.admin')

@section('content')
    <div class="container">
        @include('helpers.flash-messages')
        <div class="row">
            <div class="col-6">
                <h1><i class="fa-solid fa-users"></i> {{__('shop.user.index_title')}}</h1>
            </div>
        </div>

        {{--  Desktop  --}}
        <table class="table table-hover table-desktop d-none d-md-table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Email</th>
                <th scope="col">Imie</th>
                <th scope="col">Nazwisko</th>
                <th scope="col">Numer telefonu</th>
                <th scope="col">Akcje</th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->email}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->surname}}</td>
                    <td>{{$user->phone_number}}</td>
                    <td>
                        <button class="btn btn-danger btn-sm delete" data-id="{{$user->id}}" data-url="{{ route('admin.users.index') }}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Mobile --}}
        <div class="table-mobile d-block d-md-none">
            @foreach($users as $user)
                <div class="user-card mb-3 p-3 border rounded shadow-sm bg-light">
                    <p><strong>ID:</strong> {{$user->id}}</p>
                    <p><strong>Email:</strong> {{$user->email}}</p>
                    <p><strong>Imię:</strong> {{$user->name}}</p>
                    <p><strong>Nazwisko:</strong> {{$user->surname}}</p>
                    <p><strong>Telefon:</strong> {{$user->phone_number}}</p>

                    <div class="d-flex justify-content-end mt-2">
                        <button class="btn btn-danger btn-sm delete"
                                data-id="{{$user->id}}"
                                data-url="{{ route('admin.users.index') }}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $users->links() }}
    </div>
@endsection
@section('scripts')
    <script data-url="{{ route('admin.users.index') }}"></script>
    @vite('resources/js/delete.js')
@endsection


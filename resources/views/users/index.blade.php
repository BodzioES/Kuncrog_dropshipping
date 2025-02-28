@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-hover">
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
                        <button class="btn btn-outline-danger btn-sm delete" data-id="{{$user->id}}">
                            X
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
@endsection
@section('javascript')
    $(function (){
        $('.delete').click(function (){
            Swal.fire({
            title: "Czy na pewno chcesz usunąć rekord?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: 'Tak, usuń',
            dangerMode: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "DELETE",
                        url: "kuncrog.test/users/" + $(this).data("id")
                    })
                    .done(function( response ) {
                        window.location.reload();
                    })
                    .fail(function (response){
                        Swal.fire("Oops!", "Something went wrong!", "error");
                    });
                }
            });
        });
    });
@endsection


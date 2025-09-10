@extends('layouts.admin')

@section('content')
    <div class="container">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Adres IP</th>
                <th scope="col">Kraj</th>
                <th scope="col">Miasto</th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
            @foreach($visitors as $visitor)
                <tr>
                    <td>{{ $visitor->ip_address }}</td>
                    <td>{{ $visitor->country }}</td>
                    <td>{{ $visitor->city }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
@section('scripts')

@endsection


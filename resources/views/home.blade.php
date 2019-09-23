@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Users Dashboard</div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <th>Users</th>
                            <th>n1</th>
                            <th>n2</th>
                            <th>n3</th>
                            <th>n4</th>
                            <th>n5</th>
                            <th>n6</th>
                            <th>n7</th>
                            <th>n8</th>
                            <th>n9</th>
                            <th>n10</th>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    @foreach($user->numbers as $n)
                                        <td>{{$n}}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Lucky Draw Panel</div>

                <div class="card-body">
                    <form method="post" action="/draw">
                        @csrf
                        <div class="form-group">
                            <label for="prize">Prize Types</label>
                            <select class="form-control" id = "prize" name="prize_type">
                                <option style="text-align: center" disabled selected value> -- select a prize -- </option>
                                <option value = "1">Grand Prize</option>
                                <option value = "2">Second Prize - 1st Winner</option>
                                <option value = "3">Second Prize - 2nd Winner</option>
                                <option value = "4">Third Prize - 1st Winner</option>
                                <option value = "5">Third Prize - 2nd Winner</option>
                                <option value = "6">Third Prize - 3rd Winner</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rand">Generate Randomly</label>
                            <select class="form-control" id = "rand" name="random">
                                <option disabled selected value> -- select yes/no -- </option>
                                <option value = "yes">yes</option>
                                <option value = "no">no</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-top: 20px">
                            <label>Winning Number</label>
                            <input class="form-control" name="wnumber" type="text"/>
                            <small>Needed if not generating randomly</small>
                        </div>
                        <button class="btn btn-primary" type="submit">Draw</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

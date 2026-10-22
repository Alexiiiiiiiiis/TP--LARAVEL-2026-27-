{{-- Liste des feedbacks des clients, avec suppression (template : mfeedback.html) --}}
@extends('layouts.manager')

@section('title', 'Feedback')

@section('contenu')
<div class="container">
    <div class="card w-100 text-center shadowBlue">
        <div class="card-header">
            Feedback from Account Holders
        </div>
        <div class="card-body">
            @include('layouts.partials.alerts')

            <table class="table table-bordered table-sm bg-dark text-white">
                <thead>
                    <tr>
                        <th scope="col">From</th>
                        <th scope="col">Account No.</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Message</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($feedbacks as $feedback)
                        <tr>
                            <td>{{ $feedback->name }}</td>
                            <td>{{ $feedback->account_no }}</td>
                            <td>{{ $feedback->contact }}</td>
                            <td>{{ $feedback->message }}</td>
                            <td>{{ $feedback->created_at }}</td>
                            <td>
                                <form action="{{ url('/manager/deletefeedback/'.$feedback->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this message ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete this Message">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No feedback yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted">
            MCB Bank
        </div>
    </div>
</div>
@endsection

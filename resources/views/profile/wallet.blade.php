@extends('layout')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Wallet Balance</h5>
                    <div>
                        <span class="text-muted">Total Coins</span>
                        <h3 class="text-success mb-0">{{ $wallet ? $wallet->coins : 0 }}</h3>
                    </div>
                </div>
                <hr>
                <p class="text-muted mb-0">User: <strong>{{ auth()->user()->name }}</strong></p>
                <p class="text-muted mb-0">Role: <strong>{{ ucfirst(auth()->user()->role) }}</strong></p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Transaction History</h6>
            </div>
            <div class="card-body">
                @if($transactions->isEmpty())
                    <p class="text-muted text-center py-4">No transactions yet.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $t)
                                <tr>
                                    <td><small class="text-muted">#{{ $t->id }}</small></td>
                                    <td>
                                        @if($t->type === 'credit')
                                            <span class="badge bg-success">Credit</span>
                                        @else
                                            <span class="badge bg-danger">Debit</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong class="{{ $t->type === 'credit' ? 'text-success' : 'text-danger' }}">
                                            {{ $t->type === 'credit' ? '+' : '-' }}{{ $t->amount }}
                                        </strong>
                                    </td>
                                    <td>{{ $t->description }}</td>
                                    <td><small class="text-muted">{{ $t->created_at->format('M d, Y H:i') }}</small></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


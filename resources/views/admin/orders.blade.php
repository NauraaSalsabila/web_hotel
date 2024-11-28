@extends('admin.layout.app')

@section('heading', 'Customer Orders')

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Order No</th>
                                    <th>Payment Method</th>
                                    <th>Booking Date</th>
                                    <th>Paid Amount</th>
                                    <th>Payment Status</th>
                                    <th>Payment Proof</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->order_no }}</td>
                                    <td>{{ $row->payment_method }}</td>
                                    <td>{{ $row->booking_date }}</td>
                                    <td>{{ $row->paid_amount }}</td>
                                    <td>
                                        @if ($row->payment_status == 1)
                                            <span class="badge bg-success">Verified</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->payment_proof)
                                        <a href="{{ asset('storage/payment_proofs/' . $row->payment_proof) }}" target="_blank" class="btn btn-info btn-sm">View Proof</a>
                                        @else
                                            <span class="badge bg-secondary">No Proof</span>
                                        @endif
                                    </td>
                                    <td class="pt_10 pb_10">
                                        <a href="{{ route('admin_invoice', $row->id) }}" class="btn btn-primary">Detail</a>
                                        
                                        @if ($row->payment_status == 0 && $row->payment_proof)
                                            <a href="{{ route('admin_order_verify_payment', $row->id) }}" class="btn btn-success">Verify Payment</a>
                                        @endif

                                        <a href="{{ route('admin_order_delete', $row->id) }}" class="btn btn-danger" onClick="return confirm('Are you sure?');">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

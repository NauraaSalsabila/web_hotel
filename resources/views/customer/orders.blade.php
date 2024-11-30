@extends('customer.layout.app')

@section('heading', 'My Orders')

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
                                    <th>Payment Proof</th> <!-- New Column -->
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
                                    <td>Rp{{ number_format($row->paid_amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($row->payment_status == 1)
                                            <span class="badge bg-success">Verified</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->payment_method == 'Cash')
                                            <span>No proof needed for Cash payment</span>
                                        @elseif($row->payment_proof)
                                            <!-- Provide a link to view/download the payment proof -->
                                            <a href="{{ asset('storage/payment_proofs/' . $row->payment_proof) }}" target="_blank" class="btn btn-info btn-sm">View Proof</a>
                                        @else
                                            <span>No proof uploaded</span>
                                        @endif
                                    </td>
                                    <td class="pt_10 pb_10">
                                        @if ($row->payment_status == 1)
                                            <!-- Show Detail button if payment is verified -->
                                            <a href="{{ route('customer_invoice', $row->id) }}" class="btn btn-primary">Detail</a>
                                        @elseif($row->payment_proof && $row->payment_status == 0)
                                            <!-- Show message if proof is uploaded and pending verification -->
                                            <p>Payment proof uploaded. Waiting for admin verification.</p>
                                        @endif

                                        @if ($row->payment_status == 0 && !$row->payment_proof && $row->payment_method != 'Cash')
                                            <!-- Upload payment proof if not cash -->
                                            <form action="{{ route('customer_upload_payment_proof', $row->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="payment_proof">Upload Payment Proof</label>
                                                    <input type="file" name="payment_proof" class="form-control" required>
                                                </div>
                                                <button type="submit" class="btn btn-success">Upload Proof</button>
                                            </form>
                                        @endif
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

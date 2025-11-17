@extends('layouts.admin')

@section('title', 'Inbox / Contacts')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Inbox</h1>

    <div class="card">
        <div class="card-header">
            <strong>All Messages</strong>
        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="200">Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th width="140">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($contacts as $c)
                        <tr>
                            <td>{{ $c->name }}</td>
                            <td>{{ $c->email }}</td>
                            <td>{{ Str::limit($c->message, 50) }}</td>
                            <td>
                                @if($c->is_replied)
                                    <span class="badge badge-success">Replied</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm"
                                    data-toggle="modal"
                                    data-target="#viewMsg{{ $c->id }}">
                                    View
                                </button>

                                @if(!$c->is_replied)
                                    <button class="btn btn-success btn-sm"
                                        data-toggle="modal"
                                        data-target="#replyMsg{{ $c->id }}">
                                        Reply
                                    </button>
                                @endif
                            </td>
                        </tr>

                        {{-- ================================
                            VIEW Message Modal
                        ================================= --}}
                        <div class="modal fade" id="viewMsg{{ $c->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5>Message from {{ $c->name }}</h5>
                                    </div>

                                    <div class="modal-body">
                                        <p><strong>Email:</strong> {{ $c->email }}</p>
                                        <p><strong>Message:</strong></p>
                                        <p>{{ $c->message }}</p>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </div>
                        </div>


                        {{-- ================================
                            REPLY Modal
                        ================================= --}}
                        <div class="modal fade" id="replyMsg{{ $c->id }}">
                            <div class="modal-dialog">
                                <form action="{{ route('admin.contacts.reply', $c->id) }}" method="POST" class="modal-content">
                                    @csrf

                                    <div class="modal-header">
                                        <h5>Reply to {{ $c->name }}</h5>
                                    </div>

                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Reply Message</label>
                                            <textarea name="reply" rows="4" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-primary">Send Reply</button>
                                    </div>

                                </form>
                            </div>
                        </div>

                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection

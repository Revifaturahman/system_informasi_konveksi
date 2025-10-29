@extends('layouts.master')

@section('content')
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#courierModal" type="button" onclick="openCreateModal()">
    <i class="bi bi-plus-circle"></i> Tambah Kurir
</button>
<div class="row text-center g-3">
    <div class="col-md-4">
        <div class="p-4 bg-white shadow-sm rounded">
            <h6>Kurir 1</h6>
            <h2 class="text-primary">Fadil</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-4 bg-white shadow-sm rounded">
            <h6>Kurir 2</h6>
            <h2 class="text-primary">Tegar</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-4 bg-white shadow-sm rounded">
            <h6>Kurir 3</h6>
            <h2 class="text-primary">Abil</h2>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="courierModal" tabindex="-1" aria-labelledby="courierModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('courier.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="id" id="courier_id">

            <div class="modal-header">
                <h5 class="modal-title" id="courierModalLabel">Add Courier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">User</label>
                    <select class="form-select" name="user_id" id="user_id" required>
                        <option value="">-- Select User --</option>
                        @foreach ($couriers as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="phone_number" id="phone_number" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

@endsection

@extends('layouts.layout')

@section('page-name', 'Version Control')

@section('content')
    <!--suppress JSUnresolvedReference -->
    <div class="container-fluid py-4">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Versions</h6>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">+ Add Version
                </button>
            </div>

            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                    <tr>
                        <th>Version</th>
                        <th>Code</th>
                        <th>Enabled</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($versions as $v)
                        <tr data-id="{{ $v->_id }}" data-version="{{ $v->version }}" data-enabled="{{ $v->enabled }}">
                            <td class="ps-4">{{ $v->version }}</td>
                            <td class="ps-4">{{ $v->code }}</td>
                            <td>
                                @if($v->enabled)
                                    <span class="badge bg-success">Enabled</span>
                                @else
                                    <span class="badge bg-danger">Disabled</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-secondary btn-sm editBtn">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>


    {{-- ADD MODAL --}}
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><h6>Add Version</h6></div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label>Version</label>
                        <input type="text" step="0.1" class="form-control" id="add_version">
                    </div>

                    <div class="mb-3">
                        <label>Code</label>
                        <input type="text" step="0.1" class="form-control" id="add_code">
                    </div>

                    <div class="mb-3">
                        <label>Enabled</label>
                        <select class="form-control" id="add_enabled">
                            <option value="1">Enabled</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="saveAdd">Save</button>
                </div>
            </div>
        </div>
    </div>


    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><h6>Edit Version</h6></div>
                <div class="modal-body">

                    <input type="hidden" id="edit_id">

                    <div class="mb-3">
                        <label>Version</label>
                        <input type="text" step="0.1" class="form-control" id="edit_version">
                    </div>

                    <div class="mb-3">
                        <label>Code</label>
                        <input type="text" step="0.1" class="form-control" id="edit_code">
                    </div>

                    <div class="mb-3">
                        <label>Enabled</label>
                        <select class="form-control" id="edit_enabled">
                            <option value="1">Enabled</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="saveEdit">Update</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.querySelector("#saveAdd").onclick = function () {
            fetch("{{ route('version-control.add') }}", {
                method: "POST",
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}", "Content-Type": "application/json"},
                body: JSON.stringify({
                    version: document.querySelector('#add_version').value,
                    code: document.querySelector('#add_code').value,
                    enabled: document.querySelector('#add_enabled').value,
                })
            }).then(r => r.json()).then(() => {
                location.reload()
            })
        }

        document.querySelectorAll(".editBtn").forEach(btn => {
            btn.onclick = function () {
                let tr = this.closest("tr")
                document.querySelector("#edit_id").value = tr.dataset.id
                document.querySelector("#edit_version").value = tr.dataset.version
                document.querySelector("#edit_code").value = tr.dataset.code
                document.querySelector("#edit_enabled").value = tr.dataset.enabled === "1" ? "1" : "0"
                new bootstrap.Modal(document.getElementById("editModal")).show();
            }
        })

        document.querySelector("#saveEdit").onclick = function () {
            fetch("{{ route('version-control.edit') }}", {
                method: "POST",
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}", "Content-Type": "application/json"},
                body: JSON.stringify({
                    id: document.querySelector('#edit_id').value,
                    version: document.querySelector('#edit_version').value,
                    code: document.querySelector('#edit_code').value,
                    enabled: document.querySelector('#edit_enabled').value,
                })
            }).then(r => r.json()).then(() => {
                location.reload()
            })
        }
    </script>

@endsection

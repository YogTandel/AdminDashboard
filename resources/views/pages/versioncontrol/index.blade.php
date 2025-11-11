@extends('layouts.layout')

@section('page-name', 'Version Control')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg border-0">
                    <!-- Card Header -->
                    <div class="card-header bg-primary p-4">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-white text-capitalize mb-0">Version Management</h6>
                                <p class="text-white text-sm mb-0 opacity-8">Manage application versions and updates</p>
                            </div>
                            <div class="col-6 text-end">
                                <button class="btn bg-gradient-light mb-0" data-bs-toggle="modal"
                                        data-bs-target="#addModal">
                                    <i class="fas fa-plus me-2"></i>Add Version
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">
                                        Version
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Code
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        URL
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($versions as $v)
                                    <tr data-id="{{ $v->_id }}" data-version="{{ $v->version }}"
                                        data-code="{{ $v->code }}" data-url="{{ $v->url }}"
                                        data-enabled="{{ $v->enabled }}">
                                        <td class="ps-4">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $v->version }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $v->code }}</p>
                                        </td>
                                        <td>
                                            @if(!empty($v->url))
                                                <a href="{{ $v->url }}" target="_blank"
                                                   class="text-xs font-weight-bold text-info">
                                                    <i class="fas fa-external-link-alt me-1"></i>Open Link
                                                </a>
                                            @else
                                                <span class="text-xs text-secondary font-weight-bold">No URL</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if($v->enabled)
                                                <span class="badge badge-sm bg-gradient-success">Enabled</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-danger">Disabled</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <button class="btn btn-link text-secondary mb-0 editBtn"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Edit Version">
                                                <i class="fas fa-edit text-lg"></i>
                                            </button>
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


    {{-- ADD MODAL --}}
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal">Add New Version</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold">Version Number</label>
                        <input type="text" class="form-control" id="add_version"
                               placeholder="e.g., 1.0.0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold">Version Code</label>
                        <input type="text" class="form-control" id="add_code"
                               placeholder="e.g., v100">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold">URL</label>
                        <input type="text" class="form-control" id="add_url"
                               placeholder="https://example.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold">Status</label>
                        <select class="form-select" id="add_enabled">
                            <option value="1">Enabled</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn bg-gradient-primary" id="saveAdd">
                        <i class="fas fa-save me-2"></i>Save Version
                    </button>
                </div>
            </div>
        </div>
    </div>


    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal">Edit Version</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id">

                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold">Version Number</label>
                        <input type="text" class="form-control" id="edit_version">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold">Version Code</label>
                        <input type="text" class="form-control" id="edit_code">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold">URL</label>
                        <input type="text" class="form-control" id="edit_url">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold">Status</label>
                        <select class="form-select" id="edit_enabled">
                            <option value="1">Enabled</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn bg-gradient-info" id="saveEdit">
                        <i class="fas fa-check me-2"></i>Update Version
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        document.querySelector("#saveAdd").onclick = function () {
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
            btn.disabled = true;

            fetch("{{ route('version-control.add') }}", {
                method: "POST",
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}", "Content-Type": "application/json"},
                body: JSON.stringify({
                    version: document.querySelector('#add_version').value,
                    code: document.querySelector('#add_code').value,
                    url: document.querySelector('#add_url').value,
                    enabled: document.querySelector('#add_enabled').value,
                })
            }).then(r => r.json()).then(() => {
                location.reload();
            }).catch(err => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                alert('Error saving version');
            });
        }

        document.querySelectorAll(".editBtn").forEach(btn => {
            btn.onclick = function () {
                let tr = this.closest("tr");
                document.querySelector("#edit_id").value = tr.dataset.id;
                document.querySelector("#edit_version").value = tr.dataset.version;
                document.querySelector("#edit_code").value = tr.dataset.code;
                document.querySelector("#edit_url").value = tr.dataset.url;
                document.querySelector("#edit_enabled").value = tr.dataset.enabled === "1" ? "1" : "0";
                new bootstrap.Modal(document.getElementById("editModal")).show();
            }
        });

        document.querySelector("#saveEdit").onclick = function () {
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
            btn.disabled = true;

            fetch("{{ route('version-control.edit') }}", {
                method: "POST",
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}", "Content-Type": "application/json"},
                body: JSON.stringify({
                    id: document.querySelector('#edit_id').value,
                    version: document.querySelector('#edit_version').value,
                    code: document.querySelector('#edit_code').value,
                    url: document.querySelector('#edit_url').value,
                    enabled: document.querySelector('#edit_enabled').value,
                })
            }).then(r => r.json()).then(() => {
                location.reload();
            }).catch(err => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                alert('Error updating version');
            });
        }
    </script>

@endsection

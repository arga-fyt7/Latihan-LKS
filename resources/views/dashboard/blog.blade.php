@extends('dashboard.layouts.main')
@section('blog')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pages /</span> Blog</h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Blog Data View</h5>
            <button data-bs-toggle="offcanvas" data-bs-target="#offcanvasScroll" aria-controls="offcanvasScroll"
                class="btn btn-primary"><i class="bx bx-plus me-2"></i> Add</button>
            <div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
                id="offcanvasScroll" aria-labelledby="offcanvasScrollLabel" style="width: auto;">
                <div class="offcanvas-header">
                    <h5 id="offcanvasScrollLabel" class="offcanvas-title">Add New Blog</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body my-auto mx-0 flex-grow-0" style="width: auto;">
                    <form action="create-blog" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <label for="title" class="form-label">Title</label>
                            <div class="col-md-10 w-100">
                                <input name="title" class="form-control" type="text" id="title" required />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="status" class="form-label">Status</label>
                            <div class="col-md-10 w-100">
                                <select name="status" id="status" class="form-control" required>
                                    <option value="Created">Created</option>
                                    <option value="Processing">Processing</option>
                                    <option value="Published">Published</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="date" class="form-label">Datetime</label>
                            <div class="col-md-10 w-100">
                                <input name="date" class="form-control" type="datetime-local"
                                    value="{{ date('Y-m-d\TH:i') }}" id="date" required />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="attachment" class="form-label">Attachment</label>
                            <div class="col-md-10 w-100">
                                <input name="attachment" class="form-control" type="file" id="attachment" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="tags" class="form-label">Tag</label>
                            <div class="col-md-10 w-100">
                                <input name="tags" class="form-control" type="text" id="tags" required />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="content" class="form-label">Contents</label>
                            <div class="col-md-10 w-100">
                                <textarea name="contents" class="form-control" type="text" id="content" style="height: 200px" required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2 d-grid w-100">Continue</button>
                        <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
                            Cancel
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Attachment</th>
                        <th>Tags</th>
                        <th class="text-nowarp">Contents</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($blogs as $project)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fab fa-angular fa-lg text-danger me-2"></i>
                                    <strong>{{ $project->title }}</strong>
                                </div>
                            </td>
                            <td>{{ $project->date }}</td>
                            <td>
                                @if ($project->attachment)
                                    <img src="{{ asset('storage/attachment/' . $project->attachment) }}" alt="Attacment"
                                        class="rounded">
                                @else
                                    Empty
                                @endif
                            </td>
                            <td>{{ $project->tags }}</td>
                            <td>
                                <p class="mb-0">{{ $project->contents }}</p>
                            </td>
                            <td>
                                @if ($project->status == 'Created')
                                    <span class="badge bg-label-info">{{ $project->status }}</span>
                                @elseif($project->status == 'Processing')
                                    <span class="badge bg-label-primary">{{ $project->status }}</span>
                                @elseif($project->status == 'Published')
                                    <span class="badge bg-label-success">{{ $project->status }}</span>
                                @endif
                            </td>

                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('projects.edit', $project->id) }}"><i
                                                class="bx bx-edit-alt me-2"></i> Edit</a>
                                        <a class="dropdown-item" href="{{ route('projects.view', $project->id) }}"><i
                                                class="bx bx-menu me-2"></i> View</a>
                                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="bx bx-trash me-2"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td style="text-align: center" colspan="7">Empty</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@extends('dashboard.layouts.main')
@section('shopping')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Shop /</span> Shopping</h4>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Procucts Data View</h5>
            <button data-bs-toggle="offcanvas" data-bs-target="#offcanvasScroll" aria-controls="offcanvasScroll"
                class="btn btn-primary"><i class="bx bx-plus me-2"></i> Tambah</button>
            <div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
                id="offcanvasScroll" aria-labelledby="offcanvasScrollLabel" style="width: auto;">
                <div class="offcanvas-header">
                    <h5 id="offcanvasScrollLabel" class="offcanvas-title">Tambah Barang Baru</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body my-auto mx-0 flex-grow-0" style="width: auto;">
                    <form action="create-shop" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <label for="name" class="form-label">Nama Barang</label>
                            <div class="col-md-10 w-100">
                                <input name="name" class="form-control" type="text" id="name" required />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="amount" class="form-label">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="text" class="form-control" placeholder="Amount"
                                    aria-label="Amount (to the nearest dollar)" id="amount" name="amount" />
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="size" class="form-label">Ukuran</label>
                            <div class="col-md-10 w-100">
                                <select name="size" id="size" class="form-control" required>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                    <option value="XXL">XXL</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="color" class="col-md-2 col-form-label">Warna</label>
                            <div class="col-md-10">
                                <input class="form-control" type="color" value="#666EE8" id="color" name="color" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="attachment" class="form-label">Gambar Barang</label>
                            <div class="col-md-10 w-100">
                                <input name="attachment" class="form-control" type="file" id="attachment" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="sku" class="form-label">SKU</label>
                            <div class="col-md-10 w-100">
                                <input name="sku" class="form-control" type="text" id="sku" required />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="category" class="form-label">Kategori</label>
                            <div class="col-md-10 w-100">
                                <input name="category" class="form-control" type="text" id="category" required />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="tags" class="form-label">Tag</label>
                            <div class="col-md-10 w-100">
                                <input name="tags" class="form-control" type="text" id="tags" required />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="contents" class="form-label">Deskripsi Barang</label>
                            <div class="col-md-10 w-100">
                                <textarea name="contents" class="form-control" type="text" id="contents" style="height: 200px" required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2 d-grid w-100">Continue</button>
                        <button type="button" class="btn btn-outline-secondary d-grid w-100"
                            data-bs-dismiss="offcanvas">
                            Cancel
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="tableshop">
                <thead class="table-light">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Ukuran</th>
                        <th>Warna</th>
                        <th>Gambar Barang</th>
                        <th>SKU</th>
                        <th>Kategori</th>
                        <th>Tag</th>
                        <th>Deskripsi Barang</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shops as $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fab fa-angular fa-lg text-danger me-2"></i>
                                    <strong>{{ $product->name }}</strong>
                                </div>
                            </td>
                            <td>${{ $product->amount }}</td>
                            <td>{{ $product->size }}</td>
                            <td>
                                <div style="display: inline-block; text-align: center;">
                                    <div style="width: 50px; height: 50px; background-color: {{ $product->color }};"></div>
                                    <div>{{ substr($product->color, 1) }}</div>
                                </div>                                
                            </td>
                            <td>
                                @if ($product->attachment)
                                    <img src="{{ asset('storage/shop/' . $product->attachment) }}" alt="Shop Image"
                                        class="rounded">
                                @else
                                    Empty
                                @endif
                            </td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->category }}</td>
                            <td>{{ $product->tags }}</td>
                            <td>
                                <p class="mb-0">{{ $product->contents }}</p>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}"><i
                                                class="bx bx-edit-alt me-2"></i> Edit</a>
                                        <a class="dropdown-item" href="{{ route('products.view', $product->id) }}"><i
                                                class="bx bx-menu me-2"></i> View</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
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

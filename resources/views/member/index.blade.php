@extends('member.layout')

@section('content')
    <img src="{{ asset('/assets/icon/banner5.jpg') }}" style="width: 100%;" height="600">
    <div class="text-center mt-3 mb-3">
        <p class="font-weight-bold" style="font-size: 16px; letter-spacing: 1px; color: #117d17">Temukan Produk Material
            Sesuai Kebutuhan Anda.</p>
    </div>
    <div class="text-center mt-3 mb-3">
        <p class="font-weight-bold" style="font-size: 24px; letter-spacing: 1px; color: #117d17">Produk Material Di Toko
            Kami.</p>
    </div>
    <div class="pl-5 pl-5 pt-2 pb-2 mt-3">
        <div class="row w-100">
            <div class="col-lg-2">
                <div class="card" style="border-color: #117d17">
                    <div class="card-header" style="background-color: #117d17 ">
                        <p class="font-weight-bold mb-0" style="color: whitesmoke; font-size: 18px">Kategori</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($categories as $category)
                            <li class="list-group-item">
                                <a href="/">{{ $category->nama }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <ul class="list-group">

                </ul>
            </div>
            <div class="col-lg-10">
                <div class="d-flex mb-3">
                    <div class="flex-grow-1 mr-2">
                        <input type="text" class="form-control" id="filter" placeholder="Cari Nama barang"
                               name="filter">
                    </div>
                    <div>
                        <a href="#" class="btn btn-primary" id="btn-search"><i
                                class="fa fa-search mr-1"></i><span>Cari</span></a>
                    </div>
                </div>

                <div class="panel-product" id="panel-product">
                    <div class="row">
                        @foreach($data as $v)
                            <div class="col-lg-3 col-md-4 mb-4">
                                <div class="card card-item" data-id="{{ $v->id }}" style="cursor: pointer">
                                    <img class="card-img-top" src="{{ asset('/assets/barang'). "/" . $v->gambar }}"
                                         alt="Card image cap" height="150">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $v->nama }}</h5>
                                        <p class="card-text">Rp. {{ $v->harga }}</p>
                                        <a href="#" class="btn btn-sm btn-primary">Tambah Keranjang</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

        function emptyElementProduct() {
            return '<div class="col-lg-12 col-md-12" >' +
                '<div class="d-flex align-items-center justify-content-center" style="height: 600px"><p class="font-weight-bold">Tidak Ada Produk</p></div>' +
                '</div>';
        }

        function singleProductElement(data) {
            return '<div class="col-lg-3 col-md-4 mb-4">' +
                '<div class="card card-item" data-id="' + data['id'] + '" style="cursor: pointer">' +
                '<img class="card-img-top"  src="/assets/barang/' + data['gambar'] + '" alt="Card image cap" height="150"/>' +
                '<div class="card-body">' +
                '<h5 class="card-title">' + data['nama'] + '</h5>' +
                '<p class="card-text">Rp. ' + data['harga'] + '</p>' +
                '<a href="#" class="btn btn-sm btn-primary">Tambah Keranjang</a>' +
                '</div>' +
                '</div>' +
                '</div>';
        }

        function createElementProduct(data) {
            let child = '';
            $.each(data, function (k, v) {
                child += singleProductElement(v);
            });
            return '<div class="row">' + child + '</div>';
        }

        async function getProductByName() {
            let el = $('#panel-product');
            el.empty();
            el.append(createLoader());
            let name = $('#filter').val();
            try {
                let response = await $.get('/product/data?name=' + name);
                el.empty();
                if (response['status'] === 200) {
                    if (response['payload'].length > 0) {
                        el.append(createElementProduct(response['payload']));
                        $('.card-item').on('click', function () {
                            let id = this.dataset.id;
                            window.location.href = '/product/' + id + '/detail';
                        });
                    } else {
                        el.append(emptyElementProduct());
                    }
                }
            } catch (e) {
                console.log(e);
            }
        }

        $(document).ready(function () {
            $('.card-item').on('click', function () {
                let id = this.dataset.id;
                window.location.href = '/product/' + id + '/detail';
            });

            $('#btn-search').on('click', function (e) {
                e.preventDefault();
                getProductByName();
            })
        });
    </script>
@endsection

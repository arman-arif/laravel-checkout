@push('extra-css')
    {{-- <link rel="stylesheet" href="{{ asset('css/datatables.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endpush
@push('extra-js')
    {{-- <script src="{{ asset('js/jquery.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/datatables.js') }}"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#productsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}',
                columns: [{
                        name: 'DT_RowIndex',
                        data: 'DT_RowIndex',
                        searchable: false,
                        className: 'text-center align-middle'
                    },
                    {
                        name: 'image',
                        data: 'image',
                        className: '',
                    },
                    {
                        name: 'name',
                        data: 'name',
                        className: 'align-middle'
                    },
                    {
                        name: 'price',
                        data: 'price',
                        className: 'text-right align-middle'
                    },
                    {
                        name: 'action',
                        data: 'action',
                        className: 'text-center align-middle'
                    }
                ]
            });
        });
    </script>
@endpush
<x-app-layout>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="border-b border-gray-200 bg-white p-6">
                <table class="table" id="productsTable">
                    <thead>
                        <tr class="text-center">
                            <th>S/N</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

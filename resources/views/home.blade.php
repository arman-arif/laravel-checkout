@push('extra-css')
    <link rel="stylesheet" href="css/bootstrap.css">
@endpush
@push('extra-js')
    <script src="{{ asset('js/bootstrap.js') }}"></script>
@endpush

<x-guest-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 bg-white p-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th>S/N</th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td class="text-center align-middle"> {{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }} </td>
                                        <td class="text-center">
                                            <img class="img-thumbnail mx-auto" src="{{ $product->image }}" alt="" width="50">
                                        </td>
                                        <td class="align-middle">{{ $product->name }}</td>
                                        <td class="text-right align-middle">${{ number_format($product->price, 2) }}</td>
                                        <td class="text-center align-middle">
                                            <a href="{{ route('purchase', $product->id) }}" class="rounded bg-yellow-400 px-2 py-1 text-black no-underline">Buy Now</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="py-3 text-center">
                                        <td colspan="5">No product found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

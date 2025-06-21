<x-layout>
    <x-slot:title>Keranjang Belanja</x-slot:title>

    {{-- Initialize totals --}}
    @php
        $totalOriginalPrice = 0;
        $totalDiscountAmount = 0;
        $subTotal = 0;
        $totalItems = $cartItems->sum('quantity');
    @endphp

    <div class="bg-gray-100 min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="mx-auto max-w-7xl">
            <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-8">

                {{-- Left Column: Cart Items --}}
                <section class="lg:col-span-2">
                    <ul class="space-y-4">
                        @forelse ($cartItems as $item)
                            @php
                                // ... (blok kalkulasi Anda tetap sama)
                                $hasDiscount = $item->book->harga < $item->book->harga_sebelum_diskon;
                                $originalPricePerItem = $item->book->harga_sebelum_diskon;
                                $finalPricePerItem = $item->book->harga;
                                $lineItemOriginalTotal = $originalPricePerItem * $item->quantity;
                                $lineItemFinalTotal = $finalPricePerItem * $item->quantity;
                                $lineItemDiscount = $lineItemOriginalTotal - $lineItemFinalTotal;

                                $totalOriginalPrice += $lineItemOriginalTotal;
                                $totalDiscountAmount += $lineItemDiscount;
                                $subTotal += $lineItemFinalTotal;
                            @endphp

                            <li class="bg-white rounded-xl shadow p-4 flex flex-col sm:flex-row gap-4">
                                {{-- Image --}}
                                <div class="w-24 h-36 flex-shrink-0 mx-auto sm:mx-0">
                                    @if ($item->book->cover_image)
                                        <img src="{{ asset('storage/' . $item->book->cover_image) }}"
                                            alt="{{ $item->book->judul }}" class="h-full w-full object-cover rounded-md">
                                    @else
                                        <img src="{{ asset('storage/img/books/Book1.jpg') }}" alt="No image"
                                            class="h-full w-full object-cover rounded-md">
                                    @endif
                                </div>

                                {{-- Item Details --}}
                                <div class="flex-grow flex flex-col sm:flex-row gap-4">
                                    {{-- Info: Title, Price, Quantity --}}
                                    <div class="flex-grow">
                                        <span
                                            class="text-xs bg-gray-200 {{ $item->book->category->color ?? 'bg-gray-600' }} font-medium px-2 py-1 rounded-full">{{ $item->book->category->name ?? 'Umum' }}</span>
                                        <a href="/books/{{ $item->book->slug }}">
                                            <h3 class="text-lg font-bold text-gray-800 mt-2">{{ $item->book->judul }}
                                            </h3>
                                        </a>
                                        @if ($hasDiscount)
                                            {{-- Tampilan harga diskon Anda --}}
                                        @else
                                            <p class="text-xl font-bold text-gray-800 mt-1">
                                                Rp{{ number_format($finalPricePerItem, 0, ',', '.') }}</p>
                                        @endif

                                        <div class="flex items-center mt-4">
                                            {{-- Quantity Selector --}}
                                            <div class="flex items-center border border-gray-200 rounded-lg w-fit">
                                                {{-- Tombol Kurang (-) --}}
                                                <form action="{{ route('keranjang.update', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="action" value="decrease">
                                                    <button type="submit"
                                                        class="px-3 py-1 text-lg font-bold text-gray-600 hover:bg-gray-100 rounded-l-lg">-</button>
                                                </form>

                                                <span
                                                    class="px-4 py-1 font-semibold text-center w-12">{{ $item->quantity }}</span>

                                                {{-- Tombol Tambah (+) --}}
                                                <form action="{{ route('keranjang.update', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="action" value="increase">
                                                    <button type="submit"
                                                        class="px-3 py-1 text-lg font-bold text-gray-600 hover:bg-gray-100 rounded-r-lg">+</button>
                                                </form>
                                            </div>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('keranjang.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-sm ms-4 font-medium text-red-600 hover:text-red-800 flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Price Breakdown --}}
                                    <div
                                        class="flex-shrink-0 flex sm:flex-col justify-around sm:justify-start gap-2 text-center">
                                        <div class="bg-gray-100 p-2 rounded-md w-full">
                                            <p class="text-xs text-gray-500">Harga Buku
                                            </p>
                                            <p class="font-semibold text-sm">
                                                Rp{{ number_format($item->book->harga, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="bg-gray-100 p-2 rounded-md w-full">
                                            <p class="text-xs text-gray-500">Total Harga</p>
                                            <p class="font-bold text-base">
                                                Rp{{ number_format($lineItemFinalTotal, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <div class="bg-white rounded-xl shadow p-8 text-center">
                                <p class="text-gray-500">Keranjang belanja Anda kosong.</p>
                                <a href="/books"
                                    class="mt-4 inline-block font-medium text-indigo-600 hover:text-indigo-500">
                                    Mulai Belanja &rarr;
                                </a>
                            </div>
                        @endforelse
                    </ul>
                </section>

                {{-- Right Column: Cart Summary --}}
                <aside class="lg:col-span-1 mt-8 lg:mt-0">
                    <div class="bg-white rounded-xl shadow sticky top-8">
                        <div class="bg-primary-700 text-white p-4 rounded-t-xl">
                            <h2 class="font-bold text-lg">Ringkasan Keranjang</h2>
                        </div>
                        <div class="p-4 space-y-3 text-sm">
                            <div class="flex justify-between">
                                <p class="text-gray-600">Total Harga ({{ $totalItems }} Barang)</p>
                                <p class="font-medium">Rp{{ number_format($subTotal, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-gray-600">Total Diskon Belanja</p>
                                <p class="font-medium text-red-600">
                                    -Rp.0</p>
                            </div>
                            <hr>
                            <div class="flex justify-between text-base font-bold">
                                <p>SubTotal</p>
                                <p>Rp{{ number_format($subTotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="p-4">
                            <button
                                class="w-full bg-primary-700 text-white font-bold py-3 rounded-lg hover:bg-primary-600 transition-colors">
                                Checkouts
                            </button>
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </div>
</x-layout>

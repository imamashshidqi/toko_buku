<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Keranjang Belanja Anda</h1>

        @if (session('success'))
            <div class="mt-4 rounded-md bg-green-100 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mt-4 rounded-md bg-red-100 p-4 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="mt-8">
            <div class="flow-root">
                <ul role="list" class="-my-6 divide-y divide-gray-200">
                    @php $totalPrice = 0; @endphp
                    @forelse ($cartItems as $item)
                        <li class="flex py-6">
                            <div class="h-24 w-24 shrink-0 overflow-hidden rounded-md border border-gray-200">
                                @if ($item->book->cover_image)
                                    <img src="{{ asset('storage/' . $item->book->cover_image) }}"
                                        class="h-full w-full object-cover object-center">
                                @else
                                    <img src="{{ asset('storage/img/books/Avenger Endgame.jpeg') }}" alt="No image"
                                        class="mx-auto h-full rounded dark:hidden">
                                @endif
                            </div>

                            <div class="ml-4 flex flex-1 flex-col">
                                <div>
                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                        <h3>
                                            <a href="/books/{{ $item->book->slug }}">{{ $item->book->judul }}</a>
                                        </h3>
                                        <p class="ml-4">
                                            Rp{{ number_format($item->book->harga * $item->quantity, 0, ',', '.') }}</p>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">{{ $item->book->penulis->nama }}</p>
                                </div>
                                <div class="flex flex-1 items-end justify-between text-sm">
                                    <p class="text-gray-500">Qty {{ $item->quantity }}</p>

                                    <div class="flex">
                                        <form action="{{ route('keranjang.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="font-medium text-primary-600 hover:text-primary-500">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @php $totalPrice += $item->book->harga * $item->quantity; @endphp
                    @empty
                        <div class="text-center py-10">
                            <p class="text-gray-500">Keranjang belanja Anda kosong.</p>
                            <a href="/books" class="mt-4 inline-block text-primary-600 hover:text-primary-500">Mulai
                                Belanja &rarr;</a>
                        </div>
                    @endforelse
                </ul>
            </div>
        </div>

        @if ($cartItems->isNotEmpty())
            <div class="border-t border-gray-200 px-4 py-6 sm:px-6 mt-8">
                <div class="flex justify-between text-base font-medium text-gray-900">
                    <p>Subtotal</p>
                    <p>Rp{{ number_format($totalPrice, 0, ',', '.') }}</p>
                </div>
                <p class="mt-0.5 text-sm text-gray-500">Biaya pengiriman akan dihitung saat checkout.</p>
                <div class="mt-6">
                    <a href="#"
                        class="flex items-center justify-center rounded-md border border-transparent bg-primary-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-primary-700">Checkout</a>
                </div>
            </div>
        @endif
    </div>
</x-layout>

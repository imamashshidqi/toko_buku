<x-layout>
    <x-slot:title>Favorites</x-slot:title>
    <div class="container mx-auto px-4 mt-10 mb-10">

        <div class="space-y-6">
            @foreach ($wishlists as $wishlist)
                @php $book = $wishlist->book; @endphp
                <div class="flex flex-col md:flex-row border rounded-lg overflow-hidden shadow-sm">
                    @if ($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->judul }}"
                            class="w-full md:w-32 object-cover">
                    @else
                        <img src="{{ asset('storage/img/books/Book1.jpg') }}" alt="No image"
                            class="w-full md:w-32 object-cover">
                    @endif
                    <div class="flex flex-col md:flex-row justify-between flex-grow p-4">
                        <div>
                            <h5 class="font-semibold text-lg">{{ $book->judul }}</h5>
                            <p class="text-gray-500">{{ $book->name }}</p>
                            <p class="text-blue-600 font-bold mt-2">Rp {{ number_format($book->harga, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 mt-4 md:mt-0 md:self-center">
                            <form method="POST" action="{{ route('wishlist.destroy', $book->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="group p-2 rounded-full hover:bg-red-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200"
                                    title="Hapus dari Wishlist">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-6 h-6 text-gray-400 group-hover:text-red-500 transition-colors duration-200">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.134-2.09-2.134H8.09c-1.18 0-2.09.954-2.09 2.134v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>

                                    <span class="sr-only">Hapus</span>
                                </button>
                            </form>
                            <form action="{{ route('keranjang.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button type="submit"
                                    class="inline-flex items-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                    <svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                                    </svg>
                                    Add to cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>

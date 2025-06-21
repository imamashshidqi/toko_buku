<x-layout-dash>
    <main class="p-4 md:ml-64 h-auto pt-20">

        @if (session()->has('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <!-- Start block -->
        <div class="mx-auto max-w-screen">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div
                    class="flex flex-col md:flex-row items-stretch md:items-center md:space-x-3 space-y-3 md:space-y-0 justify-between mx-4 py-4 dark:border-gray-700">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                        fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" id="simple-search"
                                    placeholder="Search for products" required=""
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            </div>
                        </form>
                    </div>
                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <button type="button" id="defaultModalButton" data-modal-target="addBook"
                            data-modal-toggle="addBook"
                            class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                            <svg class="h-3.5 w-3.5 mr-1.5 -ml-1" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Add Book
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        @foreach ($books as $book)
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-4">Product</th>
                                    <th scope="col" class="p-4">Category</th>
                                    <th scope="col" class="p-4">Stock</th>
                                    <th scope="col" class="p-4">Rating</th>
                                    <th scope="col" class="p-4">Price</th>
                                    <th scope="col" class="p-4">Last Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <th scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center mr-3">
                                            @if ($book->cover_image)
                                                <img src="{{ asset('storage/' . $book->cover_image) }}"
                                                    alt="{{ $book->judul }}"
                                                    class="w-14 h-14 object-cover rounded me-2">
                                            @else
                                                <img src="{{ asset('storage/img/books/book1.jpg') }}" alt="No image"
                                                    class="w-14 h-14 object-cover rounded me-2">
                                            @endif
                                            {{ Str::limit($book->judul, '15') }}
                                        </div>
                                    </th>
                                    <td class="px-4 py-3">
                                        <span
                                            class="{{ $book->category->color }} text-primary-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-primary-900 dark:text-primary-300">{{ $book->category->name }}</span>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $book->stok }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $book->rating)
                                                    <svg class="h-4 w-4 text-yellow-300" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                                    </svg>
                                                @else
                                                    <svg class="h-4 w-4 text-gray-300 dark:text-gray-500"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                                    </svg>
                                                @endif
                                            @endfor
                                            <span
                                                class="text-gray-500 dark:text-gray-400 ml-1">{{ $book->rating }}.0</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24"
                                                fill="currentColor" class="w-5 h-5 text-gray-400 mr-2"
                                                aria-hidden="true">
                                                <path
                                                    d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" />
                                            </svg>
                                            Rp {{ number_format($book->harga, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center space-x-4">
                                            <button type="button" data-modal-target="updateBook-{{ $book->id }}"
                                                data-modal-toggle="updateBook-{{ $book->id }}" aria-controls="true"
                                                class="edit-button py-2 px-3 flex items-center text-sm font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 -ml-0.5"
                                                    viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                    <path fill-rule="evenodd"
                                                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Edit
                                            </button>
                                            <button type="button" data-modal-target="readBook-{{ $book->id }}"
                                                data-modal-toggle="readBook-{{ $book->id }}" aria-controls="true"
                                                class="py-2 px-3 flex items-center text-sm font-medium text-center text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24"
                                                    fill="currentColor" class="w-4 h-4 mr-2 -ml-0.5">
                                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" />
                                                </svg>
                                                Preview
                                            </button>
                                            <button type="button"
                                                data-modal-target="delete-modal-{{ $book->id }}"
                                                data-modal-toggle="delete-modal-{{ $book->id }}"
                                                class="flex items-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 -ml-0.5"
                                                    viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Delete
                                            </button>
                                        </div>
                                        <x-read-modal :book="$book"></x-read-modal>
                                        <x-update-modal :book="$book" :categories="$categories"></x-update-modal>
                                        <x-delete-modal :book="$book"></x-delete-modal>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
                {{-- Pagination --}}
                <nav class=" justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                    aria-label="Table navigation">

                    {{ $books->links() }}
                </nav>
            </div>
        </div>
        <!-- End block -->
    </main>

    <x-create-modal :categories="$categories"></x-create-modal>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const dropzoneFileInput = document.getElementById('dropzone-file');
            const dropzoneContent = document.getElementById('dropzone-content');

            const originalContent = dropzoneContent.innerHTML;

            dropzoneFileInput.addEventListener('click', function(event) {
                event.target.value = null;
            });

            dropzoneFileInput.addEventListener('change', function(event) {

                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        dropzoneContent.innerHTML = '';

                        const previewImage = document.createElement('img');
                        previewImage.setAttribute('src', e.target.result);
                        previewImage.setAttribute('class', 'mx-auto mb-2 h-32 w-auto object-contain');

                        const fileNameText = document.createElement('p');
                        fileNameText.textContent = file.name;
                        fileNameText.setAttribute('class',
                            'text-sm font-semibold text-gray-700 dark:text-gray-200');

                        const helpText = document.createElement('p');
                        helpText.textContent = 'Klik lagi untuk mengganti file.';
                        helpText.setAttribute('class', 'text-xs text-gray-500 dark:text-gray-400');

                        dropzoneContent.appendChild(previewImage);
                        dropzoneContent.appendChild(fileNameText);
                        dropzoneContent.appendChild(helpText);
                    };

                    reader.readAsDataURL(file);

                } else {
                    dropzoneContent.innerHTML = originalContent;
                }
            });

        });
    </script>

</x-layout-dash>

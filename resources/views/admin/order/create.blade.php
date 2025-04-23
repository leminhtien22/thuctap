@extends('layouts.dashboard')

@section('title')
    {{ __('Create Counter Order') }}
@endsection

@section('content')
    <x-ui.breadcrumb :breadcrumbs="[
        ['url' => 'admin.order', 'label' => 'Order Management'],
        ['url' => 'admin.order.create', 'label' => 'Create Counter Order'],
    ]" />

    <form class="space-y-4 md:space-y-6 mt-8" action="{{ route('admin.order.create') }}" method="POST">
        @csrf

        @if (session('error'))
            <x-ui.alert type="danger">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <x-form.textarea-field name="notes" label="Notes" :value="old('notes') ?? ' at counter'" required
            placeholder="E.g.: Placing for customer: John Doe - Phone: 0123456789" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h2 class="text-sm">All Products</h2>

                <x-ui.alert type="info">
                    Only products with price greater than 0 or quantity greater than 0 will be displayed.
                </x-ui.alert>

                <div class="space-y-4 max-h-[600px] overflow-y-auto">
                    @forelse  ($products as $product)
                        <div class="flex space-x-2 shadow rounded-lg p-4 hover:shadow-xl product-item"
                            data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                            data-price="{{ $product->formatted_price }}"
                            data-image="{{ asset('storage/' . $product->thumbnail) }}">
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                                class="size-12 rounded-md inline-block">
                            <div>
                                <h1>{{ $product->name }}</h1>
                                <p class="text-sm text-green-700 font-bold underline">Price: {{ $product->formatted_price }} đ
                                </p>
                                <p class="text-sm text-gray-500">Quantity: {{ $product->quantity }}</p>
                                <p class="text-sm text-gray-500">Description: {{ $product->description }}</p>

                                <button type="button"
                                    class="select-product-btn mt-2 flex items-center justify-center px-3 py-1.5 text-sm font-medium text-white rounded-lg bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                                    Select Product
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm">
                            <p class="text-red-500 mt-2">No products available. <a href="{{ route('admin.collection') }}"
                                    class="underline">Add new product</a></p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="border-l border-gray-200 px-4">
                <h2 class="text-sm">Selected Products</h2>

                <x-ui.alert type="warning">
                    No products selected.
                </x-ui.alert>

                <div id="selected-products"></div>

                @error('quantities')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="is_paid" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Status') }}
            </label>

            <select required id="is_paid" name="is_paid"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected value="" disabled>{{ __('Select status') }}</option>

                @if (old('is_paid'))
                    <option value="true" selected>
                        {{ __('Paid') }}
                    </option>

                    <option value="false">
                        {{ __('Unpaid') }}
                    </option>
                @else
                    <option value="false" selected>
                        {{ __('Unpaid') }}
                    </option>

                    <option value="true">
                        {{ __('Paid') }}
                    </option>
                @endif
            </select>
        </div>

        <x-ui.button type="submit" class="w-full md:w-auto">
            {{ __('Create Order') }}
        </x-ui.button>
    </form>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const selectedProductsContainer = document.getElementById("selected-products");

        document.querySelectorAll(".select-product-btn").forEach(button => {
            button.addEventListener("click", function() {
                const productCard = this.closest(".product-item");
                const productId = productCard.dataset.id;
                const productName = productCard.dataset.name;
                const productPrice = productCard.dataset.price;
                const productImage = productCard.dataset.image;

                if (document.getElementById(`selected-product-${productId}`)) {
                    alert("This product has already been selected.");
                    return;
                }

                const selectedProduct = document.createElement("div");
                selectedProduct.id = `selected-product-${productId}`;
                selectedProduct.className = "flex items-center space-x-2 shadow p-4 rounded-lg";

                selectedProduct.innerHTML = `
                    <img src="${productImage}" class="size-12 rounded-md">
                    <div class="flex-grow">
                        <h1>${productName}</h1>
                        <p class="text-sm text-green-700 font-bold">Price: ${productPrice} đ</p>
                        <input type="number" name="quantities[${productId}]" class="border rounded px-2 py-1 w-16" min="1" value="1">
                    </div>
                    <button type="button" class="remove-product-btn bg-red-500 text-white px-3 py-1.5 rounded-md hover:bg-red-700" data-id="${productId}">
                        Remove
                    </button>
                `;

                selectedProductsContainer.appendChild(selectedProduct);
            });
        });

        selectedProductsContainer.addEventListener("click", function(event) {
            if (event.target.classList.contains("remove-product-btn")) {
                const productId = event.target.dataset.id;
                document.getElementById(`selected-product-${productId}`).remove();
            }
        });
    });
</script>

@extends('client.layouts.app')

@section('title', 'Bee Phone - ' . $product->name)

@section('content')
<style data-purpose="custom-styles">
    body { background-color: #F9FAFB; color: #111111; }
    .custom-shadow { box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); }
    .spec-row:nth-child(even) { background-color: #F9FAFB; }
    .thumb-scroll::-webkit-scrollbar { height: 4px; }
    .thumb-scroll::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 10px; }
    
    .zoom-container { position: relative; overflow: hidden; cursor: crosshair; }
    .zoom-image { transition: transform 0.1s ease-out; width: 100%; height: 100%; object-fit: contain; }
    .zoom-container:hover .zoom-image { transform: scale(2); }

    .toast-notification {
        position: fixed; top: 20px; right: -300px; background: #10B981; color: white;
        padding: 15px 25px; border-radius: 10px; font-weight: bold; box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
        transition: right 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55); z-index: 9999; display: flex; align-items: center; gap: 10px;
    }
    .toast-notification.show { right: 20px; }

    /* CSS làm mờ nút khi hết hàng */
    .btn-disabled { opacity: 0.5; cursor: not-allowed; filter: grayscale(100%); }
</style>

<main class="max-w-7xl mx-auto px-4 py-8 lg:py-12 relative">
    <nav class="flex text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center"><a href="{{ url('/') }}" class="hover:text-bee-yellow transition-colors">Trang chủ</a></li>
            <li><div class="flex items-center"><span class="mx-2">/</span><a href="#" class="hover:text-bee-yellow transition-colors">{{ $product->categories->first()?->name ?? 'Sản phẩm' }}</a></div></li>
            <li aria-current="page"><div class="flex items-center"><span class="mx-2">/</span><span class="text-gray-900 font-semibold truncate w-48 sm:w-auto">{{ $product->name }}</span></div></li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <section class="lg:col-span-7" data-purpose="product-gallery">
            <div class="bg-white rounded-2xl p-6 custom-shadow mb-4 sticky top-4">
                @php
                    $mainImg = $product->thumbnail ?? '';
                    $mainUrl = 'https://placehold.co/600x600/f8f9fa/1a1a1a?text=BeePhone';
                    if ($mainImg) {
                        $mainUrl = Str::startsWith($mainImg, ['http://', 'https://']) ? $mainImg : asset('storage/' . $mainImg);
                    }
                @endphp
                
                <div class="aspect-square flex items-center justify-center mb-6 rounded-xl bg-white p-4 border border-gray-100 zoom-container" id="image-zoom-wrapper">
                    <img alt="{{ $product->name }}" class="zoom-image mix-blend-multiply" id="main-product-image" src="{{ $mainUrl }}"/>
                </div>
                
                <div class="flex gap-4 overflow-x-auto pb-2 thumb-scroll">
                    <button class="thumb-btn flex-shrink-0 w-20 h-20 border-2 border-bee-yellow rounded-lg p-1 bg-white transition-colors">
                        <img alt="Thumb Main" class="w-full h-full object-contain mix-blend-multiply" src="{{ $mainUrl }}"/>
                    </button>
                    
                    @if(isset($product->images) && $product->images->count() > 0)
                        @foreach($product->images as $gallery)
                            @php
                                $galImg = $gallery->image_path ?? $gallery->image ?? $gallery->path ?? ''; 
                                $galUrl = $galImg ? (Str::startsWith($galImg, ['http://', 'https://']) ? $galImg : asset('storage/' . $galImg)) : 'https://placehold.co/200x200';
                            @endphp
                            <button class="thumb-btn flex-shrink-0 w-20 h-20 border border-gray-200 rounded-lg p-1 bg-white hover:border-bee-yellow transition-colors">
                                <img alt="Gallery" class="w-full h-full object-contain mix-blend-multiply" src="{{ $galUrl }}"/>
                            </button>
                        @endforeach
                    @endif
                </div>
                
                <div class="mt-8 p-5 bg-gradient-to-r from-yellow-50 to-white rounded-xl border border-yellow-100 shadow-sm">
                    <h3 class="font-bold text-bee-dark mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-bee-yellow" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        Đặc điểm nổi bật
                    </h3>
                    <div class="text-sm space-y-2 text-gray-700 leading-relaxed line-clamp-4">
                        {!! strip_tags($product->description) !!}
                    </div>
                </div>
            </div>
        </section>

        <section class="lg:col-span-5" data-purpose="product-info-actions">
            <form action="#" method="POST" id="add-to-cart-form" class="flex flex-col gap-6">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="variant_id" id="selected-variant-id" value="">

                <div class="bg-white p-6 rounded-2xl custom-shadow relative overflow-hidden">
                    <h1 class="text-2xl lg:text-3xl font-bold text-bee-dark mb-2 pr-12">{{ $product->name }}</h1>
                    
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex text-bee-yellow">
                            @for($i=0; $i<5; $i++) <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"></path></svg> @endfor
                        </div>
                        <span class="text-sm text-gray-300">|</span>
                        <span id="header-stock-status" class="text-sm text-green-600 bg-green-50 px-2 py-0.5 rounded font-bold transition-all">
                            Đang kiểm tra kho...
                        </span>
                    </div>

                    <div class="flex items-baseline gap-4 mt-6 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <span id="main-price" class="text-3xl font-black text-bee-red transition-opacity duration-200">
                            Đang cập nhật giá...
                        </span>
                        <span id="old-price" class="text-lg text-gray-400 line-through transition-opacity duration-200"></span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl custom-shadow space-y-6">
                    @php
                        // CHUẨN BỊ DỮ LIỆU ĐỂ TẠO UI KIỂU CELLPHONES
                        $groupedAttributes = [];
                        $variantsJS = [];

                        if($product->type == 'variable' && isset($product->variants)) {
                            foreach($product->variants as $variant) {
                                $attrIds = [];
                                foreach($variant->attributeValues as $val) {
                                    $attrName = $val->attribute->name;
                                    $groupedAttributes[$attrName][$val->id] = $val->value;
                                    $attrIds[] = $val->id;
                                }
                                sort($attrIds); // Sort để tý so sánh JS cho dễ

                                $variantsJS[] = [
                                    'id' => $variant->id,
                                    'attributes' => $attrIds,
                                    'price' => $variant->price,
                                    'sale_price' => $variant->sale_price,
                                    'stock' => $variant->stock,
                                    'image' => $variant->thumbnail ? asset('storage/' . $variant->thumbnail) : null
                                ];
                            }
                        }
                    @endphp

                    @if(!empty($groupedAttributes))
                        @foreach($groupedAttributes as $attrName => $values)
                            <div class="attr-group" data-name="{{ $attrName }}">
                                <p class="font-bold mb-3 text-bee-dark text-sm uppercase tracking-wide">{{ $attrName }}:</p>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    @foreach($values as $valId => $valName)
                                        <button type="button" 
                                            class="attr-btn relative border border-gray-200 rounded-xl py-3 px-2 text-center transition-all hover:border-bee-yellow"
                                            data-id="{{ $valId }}">
                                            
                                            <div class="check-icon absolute top-0 right-0 bg-bee-yellow text-bee-dark rounded-bl-lg p-1 hidden">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            
                                            <span class="block font-bold text-sm text-gray-700 attr-text">{{ $valName }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div>
                            <p class="font-bold mb-3 text-bee-dark">Phiên bản:</p>
                            <button type="button" class="border-2 border-bee-yellow bg-yellow-50 rounded-xl py-3 px-6 font-bold text-sm">
                                Sản phẩm tiêu chuẩn
                            </button>
                        </div>
                    @endif
                </div>

                <div class="bg-white p-6 rounded-2xl custom-shadow">
                    <div class="flex items-center justify-between">
                        <p class="font-bold text-bee-dark">Số lượng:</p>
                        <div class="flex items-center border-2 border-gray-200 rounded-xl overflow-hidden focus-within:border-bee-yellow transition-colors">
                            <button type="button" id="btn-minus" class="px-4 py-2 bg-gray-50 hover:bg-bee-yellow font-bold text-lg">-</button>
                            <input type="number" id="input-qty" name="quantity" value="1" min="1" class="w-14 text-center border-0 focus:ring-0 p-2 font-bold bg-white" readonly>
                            <button type="button" id="btn-plus" class="px-4 py-2 bg-gray-50 hover:bg-bee-yellow font-bold text-lg">+</button>
                        </div>
                    </div>
                    <p class="text-xs text-right text-gray-400 mt-2">Trong kho còn: <span id="stock-text" class="font-bold text-green-600">0</span> máy</p>
                </div>

                <div class="flex flex-col gap-3 mt-2">
                    <button type="button" id="btn-buy-now" class="w-full bg-gradient-to-r from-bee-yellow to-[#f1c40f] hover:from-[#f1c40f] hover:to-bee-yellow text-bee-dark font-black py-4 rounded-xl shadow-lg transition-all flex flex-col items-center">
                        <span class="text-lg uppercase">Mua ngay</span>
                        <span class="text-xs font-medium opacity-80">(Giao hàng tận nơi)</span>
                    </button>
                    <button type="button" id="btn-add-cart" class="w-full bg-bee-dark text-white font-bold py-4 rounded-xl flex items-center justify-center gap-2 hover:bg-gray-800 transition shadow-lg mt-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        THÊM VÀO GIỎ HÀNG
                    </button>
                </div>
            </form>
        </section>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mt-12">
        <section class="lg:col-span-8 space-y-8">
            <div class="bg-white p-8 rounded-2xl custom-shadow relative">
                <h2 class="text-2xl font-bold mb-6 pb-2 border-b-2 border-bee-yellow inline-block uppercase">Đánh giá chi tiết</h2>
                <div class="prose max-w-none text-gray-700 leading-relaxed overflow-hidden" id="product-content" style="max-height: 800px;">
                    {!! $product->description !!}
                </div>
                <div class="mt-8 text-center relative">
                    <div class="absolute bottom-full left-0 w-full h-32 bg-gradient-to-t from-white to-transparent" id="content-gradient"></div>
                    <button id="read-more-btn" class="text-bee-dark font-bold hover:bg-bee-yellow px-8 py-3 rounded-full border-2 border-bee-dark transition-all">Xem thêm</button>
                </div>
            </div>
        </section>

        <section class="lg:col-span-4">
            <div class="bg-white p-6 rounded-2xl custom-shadow sticky top-4">
                <h2 class="text-xl font-bold mb-6 uppercase tracking-wide border-b-2 border-bee-yellow pb-2 inline-block">Thông số kỹ thuật</h2>
                <div class="border border-gray-100 rounded-xl overflow-hidden text-sm">
                    @if(is_array($product->specifications) && count($product->specifications) > 0)
                        <div class="w-full">
                            @foreach($product->specifications as $key => $value)
                            <div class="spec-row p-3 flex justify-between border-b border-gray-100">
                                <span class="text-sm text-gray-500 w-1/3 font-medium">{{ $key }}:</span>
                                <span class="text-sm font-bold text-bee-dark text-right w-2/3">{{ is_array($value) ? implode(', ', $value) : $value }}</span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-8 text-center"><span class="text-gray-400 italic">Đang cập nhật...</span></div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- LOGIC ĐỔI ẢNH GALLERY ---
        const mainImage = document.getElementById('main-product-image');
        const thumbBtns = document.querySelectorAll('.thumb-btn'); 

        thumbBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                thumbBtns.forEach(b => { b.classList.remove('border-bee-yellow', 'border-2'); b.classList.add('border-gray-200', 'border'); });
                this.classList.remove('border-gray-200', 'border'); this.classList.add('border-bee-yellow', 'border-2');
                
                mainImage.style.opacity = '0.3';
                setTimeout(() => { mainImage.src = this.querySelector('img').src; mainImage.style.opacity = '1'; }, 150);
            });
        });

        // --- DỮ LIỆU TỪ SERVER SANG JS ---
        const productType = "{{ $product->type }}";
        const basePrice = {{ $product->price ?? 0 }};
        const baseSalePrice = {{ $product->sale_price ?? 0 }};
        const baseStock = {{ $product->stock ?? 0 }};
        
        // Mảng các biến thể (Nhận từ PHP)
        const variantsList = @json($variantsJS ?? []);
        
        const priceEl = document.getElementById('main-price');
        const oldPriceEl = document.getElementById('old-price');
        const stockStatusEl = document.getElementById('header-stock-status');
        const stockTextEl = document.getElementById('stock-text');
        const inputVariantId = document.getElementById('selected-variant-id');
        const inputQty = document.getElementById('input-qty');
        
        const btnBuyNow = document.getElementById('btn-buy-now');
        const btnAddCart = document.getElementById('btn-add-cart');

        let currentMaxStock = baseStock;

        function formatCurrency(num) {
            return new Intl.NumberFormat('vi-VN').format(num) + 'đ';
        }

        function updateUI(price, salePrice, stock, image, variantId) {
            // Update Giá
            const finalPrice = (salePrice > 0 && salePrice < price) ? salePrice : price;
            priceEl.textContent = formatCurrency(finalPrice);
            
            if (salePrice > 0 && salePrice < price) {
                oldPriceEl.textContent = formatCurrency(price);
            } else {
                oldPriceEl.textContent = '';
            }

            // Update Kho & Trạng thái Header
            currentMaxStock = stock;
            stockTextEl.textContent = stock;
            
            if(stock > 0) {
                stockStatusEl.textContent = 'Còn hàng';
                stockStatusEl.className = 'text-sm text-green-600 bg-green-50 px-2 py-0.5 rounded font-bold';
                btnBuyNow.classList.remove('btn-disabled');
                btnAddCart.classList.remove('btn-disabled');
                btnBuyNow.disabled = false; btnAddCart.disabled = false;
            } else {
                stockStatusEl.textContent = 'Hết hàng';
                stockStatusEl.className = 'text-sm text-red-600 bg-red-50 px-2 py-0.5 rounded font-bold';
                btnBuyNow.classList.add('btn-disabled');
                btnAddCart.classList.add('btn-disabled');
                btnBuyNow.disabled = true; btnAddCart.disabled = true;
            }

            // Update ảnh chính nếu có
            if (image && image !== mainImage.src) {
                mainImage.style.opacity = '0.3';
                setTimeout(() => { mainImage.src = image; mainImage.style.opacity = '1'; }, 150);
            }

            // Cập nhật ID ẩn cho form
            inputVariantId.value = variantId || '';
            inputQty.value = 1; // Reset số lượng
        }

        // --- XỬ LÝ CHỌN THUỘC TÍNH ---
        if(productType === 'variable' && variantsList.length > 0) {
            let selectedAttributes = {};

            // Khởi tạo: Mặc định chọn nút đầu tiên của mỗi nhóm
            document.querySelectorAll('.attr-group').forEach(group => {
                const groupName = group.getAttribute('data-name');
                const firstBtn = group.querySelector('.attr-btn');
                if (firstBtn) {
                    selectButton(firstBtn, group);
                    selectedAttributes[groupName] = parseInt(firstBtn.getAttribute('data-id'));
                }
            });

            // Lắng nghe sự kiện click
            document.querySelectorAll('.attr-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const group = this.closest('.attr-group');
                    const groupName = group.getAttribute('data-name');
                    
                    selectButton(this, group);
                    selectedAttributes[groupName] = parseInt(this.getAttribute('data-id'));
                    
                    findMatchingVariant();
                });
            });

            function selectButton(btn, group) {
                // Tắt các nút khác
                group.querySelectorAll('.attr-btn').forEach(b => {
                    b.classList.remove('border-bee-yellow', 'bg-yellow-50', 'border-2');
                    b.classList.add('border-gray-200', 'border');
                    b.querySelector('.check-icon').classList.add('hidden');
                    b.querySelector('.attr-text').classList.remove('text-bee-dark');
                });
                // Bật nút hiện tại
                btn.classList.remove('border-gray-200', 'border');
                btn.classList.add('border-bee-yellow', 'bg-yellow-50', 'border-2');
                btn.querySelector('.check-icon').classList.remove('hidden');
                btn.querySelector('.attr-text').classList.add('text-bee-dark');
            }

            function findMatchingVariant() {
                // Lấy mảng các ID thuộc tính đang được chọn
                let selectedIds = Object.values(selectedAttributes).sort((a,b) => a-b).join(',');
                
                // Tìm biến thể khớp 100% trong variantsList
                let matchedVariant = variantsList.find(v => v.attributes.join(',') === selectedIds);

                if (matchedVariant) {
                    updateUI(matchedVariant.price, matchedVariant.sale_price, matchedVariant.stock, matchedVariant.image, matchedVariant.id);
                } else {
                    // Nếu khách chọn 1 combo không tồn tại (vd: Đỏ - 1TB)
                    stockStatusEl.textContent = 'Phiên bản này đã ngừng kinh doanh';
                    stockStatusEl.className = 'text-sm text-gray-600 bg-gray-100 px-2 py-0.5 rounded font-bold';
                    priceEl.textContent = 'Liên hệ';
                    oldPriceEl.textContent = '';
                    stockTextEl.textContent = 0;
                    
                    btnBuyNow.classList.add('btn-disabled');
                    btnAddCart.classList.add('btn-disabled');
                    btnBuyNow.disabled = true; btnAddCart.disabled = true;
                }
            }

            // Chạy kiểm tra ngay khi load web
            findMatchingVariant();
        } else {
            // Sản phẩm đơn giản
            updateUI(basePrice, baseSalePrice, baseStock, null, null);
        }

        // --- TĂNG GIẢM SỐ LƯỢNG ---
        const btnMinus = document.getElementById('btn-minus');
        const btnPlus = document.getElementById('btn-plus');

        if (btnMinus && btnPlus && inputQty) {
            btnMinus.addEventListener('click', () => {
                let currentVal = parseInt(inputQty.value);
                if (currentVal > 1) inputQty.value = currentVal - 1;
            });
            btnPlus.addEventListener('click', () => {
                let currentVal = parseInt(inputQty.value);
                if (currentVal < currentMaxStock) inputQty.value = currentVal + 1;
                else alert('Bạn đã chọn tối đa số lượng trong kho rồi!');
            });
        }
    });
</script>
@endsection
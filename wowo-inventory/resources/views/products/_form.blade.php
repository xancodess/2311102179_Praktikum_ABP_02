{{--
    Partial: _form.blade.php
    Dipakai oleh create.blade.php dan edit.blade.php
    Variabel yang dibutuhkan: $product (optional), $categories, $units
--}}

@php $isEdit = isset($product) && $product->exists; @endphp

<div class="grid lg:grid-cols-3 gap-6">

    {{-- ── Kolom Kiri: Informasi Utama ─────────── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Card: Informasi Produk --}}
        <div class="card p-6">
            <h3 class="font-semibold text-ink-700 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 bg-ink-800 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-jade-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                Informasi Produk
            </h3>

            <div class="space-y-4">
                {{-- Nama Produk --}}
                <div>
                    <label for="name" class="form-label">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text" id="name" name="name"
                        value="{{ old('name', $product->name ?? '') }}"
                        placeholder="Contoh: Mie Instan Goreng Indomie"
                        class="form-input @error('name') border-red-400 bg-red-50 @enderror"
                        required
                    >
                    @error('name')
                    <p class="form-error">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Kategori & Unit --}}
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="category" class="form-label">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select id="category" name="category"
                                class="form-select @error('category') border-red-400 bg-red-50 @enderror"
                                required>
                            <option value="">— Pilih Kategori —</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat }}"
                                    {{ old('category', $product->category ?? '') === $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                            @endforeach
                        </select>
                        @error('category')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="unit" class="form-label">
                            Satuan <span class="text-red-500">*</span>
                        </label>
                        <select id="unit" name="unit"
                                class="form-select @error('unit') border-red-400 bg-red-50 @enderror"
                                required>
                            @foreach($units as $unit)
                            <option value="{{ $unit }}"
                                    {{ old('unit', $product->unit ?? 'pcs') === $unit ? 'selected' : '' }}>
                                {{ $unit }}
                            </option>
                            @endforeach
                        </select>
                        @error('unit')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea
                        id="description" name="description"
                        rows="3"
                        placeholder="Deskripsi singkat tentang produk ini (opsional)..."
                        class="form-textarea @error('description') border-red-400 bg-red-50 @enderror"
                    >{{ old('description', $product->description ?? '') }}</textarea>
                    @error('description')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                    <p class="form-hint">Maksimal 1000 karakter</p>
                </div>
            </div>
        </div>

        {{-- Card: Harga --}}
        <div class="card p-6">
            <h3 class="font-semibold text-ink-700 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 bg-ink-800 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-jade-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                Harga & Margin
            </h3>

            <div class="grid sm:grid-cols-2 gap-4">
                {{-- Harga Beli --}}
                <div>
                    <label for="cost_price" class="form-label">
                        Harga Beli (Modal) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-ink-400 font-medium">Rp</span>
                        <input
                            type="number" id="cost_price" name="cost_price"
                            value="{{ old('cost_price', $product->cost_price ?? '') }}"
                            placeholder="0"
                            min="0" step="100"
                            class="form-input pl-10 @error('cost_price') border-red-400 bg-red-50 @enderror"
                            x-ref="costPrice"
                            @input="calcMargin()"
                            required
                        >
                    </div>
                    @error('cost_price')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga Jual --}}
                <div>
                    <label for="price" class="form-label">
                        Harga Jual <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-ink-400 font-medium">Rp</span>
                        <input
                            type="number" id="price" name="price"
                            value="{{ old('price', $product->price ?? '') }}"
                            placeholder="0"
                            min="0" step="100"
                            class="form-input pl-10 @error('price') border-red-400 bg-red-50 @enderror"
                            x-ref="sellPrice"
                            @input="calcMargin()"
                            required
                        >
                    </div>
                    @error('price')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Margin Preview --}}
            <div x-data="{
                margin: 0,
                calcMargin() {
                    const cost  = parseFloat(this.$refs.costPrice?.value) || 0;
                    const sell  = parseFloat(this.$refs.sellPrice?.value) || 0;
                    this.margin = sell > 0 ? Math.round(((sell - cost) / sell) * 100 * 10) / 10 : 0;
                }
            }"
            x-init="calcMargin()"
            class="mt-4 p-3.5 bg-ink-50 rounded-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-ink-500">Estimasi Margin Keuntungan</span>
                    </div>
                    <span class="font-display font-bold text-base"
                          :class="margin >= 30 ? 'text-jade-700' : (margin >= 15 ? 'text-amber-600' : 'text-red-600')"
                          x-text="margin + '%'">
                        {{ $isEdit ? $product->profit_margin : 0 }}%
                    </span>
                </div>
                <div class="mt-2 w-full bg-ink-200 rounded-full h-1.5">
                    <div class="h-1.5 rounded-full transition-all duration-300"
                         :class="margin >= 30 ? 'bg-jade-500' : (margin >= 15 ? 'bg-amber-400' : 'bg-red-400')"
                         :style="'width: ' + Math.min(margin, 100) + '%'"></div>
                </div>
                <p class="text-[11px] text-ink-400 mt-1.5">
                    Ideal: margin ≥ 30% untuk keuntungan optimal
                </p>
            </div>
        </div>
    </div>

    {{-- ── Kolom Kanan: Stok & Status ──────────── --}}
    <div class="space-y-5">

        {{-- Card: Stok --}}
        <div class="card p-6">
            <h3 class="font-semibold text-ink-700 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 bg-ink-800 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-jade-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7C5 4 4 5 4 7z"/>
                    </svg>
                </span>
                Stok Barang
            </h3>
            <div class="space-y-4">
                <div>
                    <label for="stock" class="form-label">
                        Jumlah Stok <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number" id="stock" name="stock"
                        value="{{ old('stock', $product->stock ?? 0) }}"
                        min="0"
                        class="form-input @error('stock') border-red-400 bg-red-50 @enderror"
                        required
                    >
                    @error('stock')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="min_stock" class="form-label">
                        Stok Minimum <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number" id="min_stock" name="min_stock"
                        value="{{ old('min_stock', $product->min_stock ?? 5) }}"
                        min="0"
                        class="form-input @error('min_stock') border-red-400 bg-red-50 @enderror"
                        required
                    >
                    @error('min_stock')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                    <p class="form-hint">Sistem akan memberi peringatan jika stok ≤ nilai ini</p>
                </div>
            </div>
        </div>

        {{-- Card: Status --}}
        <div class="card p-6">
            <h3 class="font-semibold text-ink-700 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 bg-ink-800 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-jade-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                Status Produk
            </h3>

            <label class="flex items-center gap-3 cursor-pointer group"
                   x-data="{ checked: {{ old('is_active', $product->is_active ?? true) ? 'true' : 'false' }} }">
                <div class="relative shrink-0">
                    <input
                        type="checkbox" name="is_active"
                        class="sr-only peer"
                        :checked="checked"
                        @change="checked = $event.target.checked"
                    >
                    <div class="w-11 h-6 rounded-full transition-all duration-200 peer-checked:bg-jade-500 bg-ink-200 cursor-pointer"
                         @click="checked = !checked; $el.previousElementSibling.checked = checked"></div>
                    <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-all duration-200 pointer-events-none"
                         :class="checked ? 'translate-x-5' : 'translate-x-0'"></div>
                </div>
                <div>
                    <p class="text-sm font-medium text-ink-700"
                       x-text="checked ? 'Aktif' : 'Nonaktif'">
                        {{ old('is_active', $product->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}
                    </p>
                    <p class="text-xs text-ink-400">Produk akan tampil / disembunyikan</p>
                </div>
            </label>
        </div>

        {{-- Card: SKU (edit only) --}}
        @if($isEdit)
        <div class="card p-5">
            <p class="text-xs font-semibold uppercase tracking-wider text-ink-400 mb-2">SKU Produk</p>
            <code class="font-mono text-sm text-ink-600 bg-ink-50 px-3 py-2 rounded-lg block break-all">
                {{ $product->sku }}
            </code>
            <p class="form-hint mt-2">SKU tidak dapat diubah setelah produk dibuat</p>
        </div>
        @endif

        {{-- Submit Buttons --}}
        <div class="space-y-2.5">
            <button type="submit" class="btn-jade w-full justify-center py-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>
                {{ $isEdit ? 'Simpan Perubahan' : 'Tambahkan Produk' }}
            </button>
            <a href="{{ route('products.index') }}" class="btn-outline w-full justify-center">
                Batal
            </a>
        </div>

    </div>
</div>

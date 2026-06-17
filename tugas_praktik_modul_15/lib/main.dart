import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

void main() {
  runApp(const ProductCartApp());
}

class Product {
  const Product({
    required this.id,
    required this.name,
    required this.description,
    required this.price,
  });

  final int id;
  final String name;
  final String description;
  final int price;
}

class CartCubit extends Cubit<List<Product>> {
  CartCubit() : super(const []);

  void addProduct(Product product) {
    emit([...state, product]);
  }

  void removeProduct(Product product) {
    final updatedCart = List<Product>.from(state);
    final productIndex = updatedCart.indexWhere(
      (item) => item.id == product.id,
    );

    if (productIndex != -1) {
      updatedCart.removeAt(productIndex);
      emit(updatedCart);
    }
  }

  int quantityOf(Product product) {
    return state.where((item) => item.id == product.id).length;
  }
}

const products = [
  Product(
    id: 1,
    name: 'Laptop Lenovo IdeaPad',
    description: 'Laptop ringan untuk tugas, kuliah, dan kerja harian.',
    price: 7500000,
  ),
  Product(
    id: 2,
    name: 'Mouse Wireless Logitech',
    description: 'Mouse ergonomis dengan koneksi stabil.',
    price: 185000,
  ),
  Product(
    id: 3,
    name: 'Keyboard Mechanical',
    description: 'Keyboard nyaman dengan switch responsif.',
    price: 450000,
  ),
  Product(
    id: 4,
    name: 'Headset Gaming',
    description: 'Audio jernih dengan mikrofon untuk meeting dan game.',
    price: 320000,
  ),
  Product(
    id: 5,
    name: 'Monitor 24 Inch',
    description: 'Monitor Full HD untuk tampilan kerja lebih luas.',
    price: 1650000,
  ),
];

class ProductCartApp extends StatelessWidget {
  const ProductCartApp({super.key});

  @override
  Widget build(BuildContext context) {
    return BlocProvider(
      create: (_) => CartCubit(),
      child: MaterialApp(
        debugShowCheckedModeBanner: false,
        title: 'Daftar Produk',
        theme: ThemeData(
          colorScheme: ColorScheme.fromSeed(seedColor: Colors.teal),
          useMaterial3: true,
        ),
        home: const ProductListPage(),
      ),
    );
  }
}

class ProductListPage extends StatelessWidget {
  const ProductListPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Toko Praktik'),
        actions: const [
          Padding(padding: EdgeInsets.only(right: 16), child: CartItemBadge()),
        ],
      ),
      body: ListView(
        padding: const EdgeInsets.all(16),
        children: [
          Text(
            'Daftar Produk',
            style: Theme.of(
              context,
            ).textTheme.headlineSmall?.copyWith(fontWeight: FontWeight.w700),
          ),
          const SizedBox(height: 4),
          Text(
            'Tambahkan produk ke keranjang, lalu jumlah item akan berubah secara real-time.',
            style: Theme.of(context).textTheme.bodyMedium,
          ),
          const SizedBox(height: 16),
          const CartCountBanner(),
          const SizedBox(height: 16),
          ...products.map((product) => ProductCard(product: product)),
          const SizedBox(height: 12),
          const CartSummary(),
        ],
      ),
    );
  }
}

class CartItemBadge extends StatelessWidget {
  const CartItemBadge({super.key});

  @override
  Widget build(BuildContext context) {
    return BlocBuilder<CartCubit, List<Product>>(
      builder: (context, cartItems) {
        return Badge(
          label: Text('${cartItems.length}'),
          child: const Icon(Icons.shopping_cart_outlined),
        );
      },
    );
  }
}

class CartCountBanner extends StatelessWidget {
  const CartCountBanner({super.key});

  @override
  Widget build(BuildContext context) {
    return BlocBuilder<CartCubit, List<Product>>(
      builder: (context, cartItems) {
        return Container(
          padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 14),
          decoration: BoxDecoration(
            color: Theme.of(context).colorScheme.primaryContainer,
            borderRadius: BorderRadius.circular(8),
          ),
          child: Row(
            children: [
              const Icon(Icons.shopping_cart_checkout),
              const SizedBox(width: 12),
              Expanded(
                child: Text(
                  'Jumlah item keranjang',
                  style: Theme.of(context).textTheme.titleMedium,
                ),
              ),
              Text(
                '${cartItems.length} item',
                style: Theme.of(
                  context,
                ).textTheme.titleMedium?.copyWith(fontWeight: FontWeight.w700),
              ),
            ],
          ),
        );
      },
    );
  }
}

class ProductCard extends StatelessWidget {
  const ProductCard({super.key, required this.product});

  final Product product;

  @override
  Widget build(BuildContext context) {
    return Card(
      margin: const EdgeInsets.only(bottom: 12),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: BlocBuilder<CartCubit, List<Product>>(
          builder: (context, _) {
            final cartCubit = context.read<CartCubit>();
            final quantity = cartCubit.quantityOf(product);

            return Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            product.name,
                            style: Theme.of(context).textTheme.titleMedium
                                ?.copyWith(fontWeight: FontWeight.w700),
                          ),
                          const SizedBox(height: 6),
                          Text(product.description),
                        ],
                      ),
                    ),
                    const SizedBox(width: 12),
                    Text(
                      formatRupiah(product.price),
                      style: Theme.of(context).textTheme.titleSmall?.copyWith(
                        color: Theme.of(context).colorScheme.primary,
                        fontWeight: FontWeight.w700,
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 16),
                Wrap(
                  spacing: 8,
                  runSpacing: 8,
                  crossAxisAlignment: WrapCrossAlignment.center,
                  children: [
                    FilledButton.icon(
                      onPressed: () => cartCubit.addProduct(product),
                      icon: const Icon(Icons.add_shopping_cart),
                      label: const Text('Tambah'),
                    ),
                    OutlinedButton.icon(
                      onPressed: quantity == 0
                          ? null
                          : () => cartCubit.removeProduct(product),
                      icon: const Icon(Icons.remove_shopping_cart_outlined),
                      label: const Text('Hapus'),
                    ),
                    Chip(
                      avatar: const Icon(Icons.inventory_2_outlined, size: 18),
                      label: Text('Di keranjang: $quantity'),
                    ),
                  ],
                ),
              ],
            );
          },
        ),
      ),
    );
  }
}

class CartSummary extends StatelessWidget {
  const CartSummary({super.key});

  @override
  Widget build(BuildContext context) {
    return BlocBuilder<CartCubit, List<Product>>(
      builder: (context, cartItems) {
        final groupedProducts = <Product, int>{};

        for (final product in cartItems) {
          groupedProducts[product] = (groupedProducts[product] ?? 0) + 1;
        }

        return Card(
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
          child: Padding(
            padding: const EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  children: [
                    const Icon(Icons.shopping_bag_outlined),
                    const SizedBox(width: 8),
                    Text(
                      'Keranjang',
                      style: Theme.of(context).textTheme.titleLarge?.copyWith(
                        fontWeight: FontWeight.w700,
                      ),
                    ),
                    const Spacer(),
                    Text(
                      '${cartItems.length} item',
                      style: Theme.of(context).textTheme.titleMedium,
                    ),
                  ],
                ),
                const Divider(height: 24),
                if (cartItems.isEmpty)
                  const Text('Keranjang masih kosong.')
                else
                  ...groupedProducts.entries.map(
                    (entry) => ListTile(
                      contentPadding: EdgeInsets.zero,
                      title: Text(entry.key.name),
                      subtitle: Text('Jumlah: ${entry.value}'),
                      trailing: IconButton(
                        tooltip: 'Hapus ${entry.key.name}',
                        onPressed: () =>
                            context.read<CartCubit>().removeProduct(entry.key),
                        icon: const Icon(Icons.delete_outline),
                      ),
                    ),
                  ),
              ],
            ),
          ),
        );
      },
    );
  }
}

String formatRupiah(int value) {
  final text = value.toString();
  final buffer = StringBuffer();

  for (var i = 0; i < text.length; i++) {
    final remainingDigits = text.length - i;
    buffer.write(text[i]);

    if (remainingDigits > 1 && remainingDigits % 3 == 1) {
      buffer.write('.');
    }
  }

  return 'Rp $buffer';
}

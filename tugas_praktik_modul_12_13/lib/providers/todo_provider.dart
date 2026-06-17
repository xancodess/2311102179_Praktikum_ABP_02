import 'package:flutter/foundation.dart';

import '../models/todo.dart';

class TodoProvider extends ChangeNotifier {
  final List<Todo> _todos = [];

  List<Todo> get todos => List.unmodifiable(_todos);

  int get totalTodos => _todos.length;

  bool get isEmpty => _todos.isEmpty;

  void addTodo(String title) {
    final trimmedTitle = title.trim();
    if (trimmedTitle.isEmpty) return;

    _todos.insert(
      0,
      Todo(
        id: DateTime.now().microsecondsSinceEpoch.toString(),
        title: trimmedTitle,
        createdAt: DateTime.now(),
      ),
    );
    notifyListeners();
  }

  void clearTodos() {
    if (_todos.isEmpty) return;

    _todos.clear();
    notifyListeners();
  }
}

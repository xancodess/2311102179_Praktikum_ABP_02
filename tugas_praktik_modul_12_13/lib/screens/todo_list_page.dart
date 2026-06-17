import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../providers/todo_provider.dart';
import '../services/fcm_service.dart';

class TodoListPage extends StatefulWidget {
  const TodoListPage({super.key});

  @override
  State<TodoListPage> createState() => _TodoListPageState();
}

class _TodoListPageState extends State<TodoListPage> {
  final TextEditingController _taskController = TextEditingController();

  @override
  void dispose() {
    _taskController.dispose();
    super.dispose();
  }

  void _addTask() {
    context.read<TodoProvider>().addTodo(_taskController.text);
    _taskController.clear();
    FocusScope.of(context).unfocus();
  }

  @override
  Widget build(BuildContext context) {
    final colorScheme = Theme.of(context).colorScheme;

    return Scaffold(
      appBar: AppBar(
        title: const Text('To-Do List'),
        backgroundColor: colorScheme.primary,
        foregroundColor: colorScheme.onPrimary,
        actions: [
          IconButton(
            tooltip: 'Hapus semua tugas',
            onPressed: () => context.read<TodoProvider>().clearTodos(),
            icon: const Icon(Icons.delete_sweep),
          ),
        ],
      ),
      body: SafeArea(
        child: ListView(
          padding: const EdgeInsets.all(16),
          children: [
            _TaskInput(controller: _taskController, onSubmitted: _addTask),
            const SizedBox(height: 16),
            const _FcmStatus(),
            const SizedBox(height: 16),
            Consumer<TodoProvider>(
              builder: (context, todoProvider, _) {
                if (todoProvider.isEmpty) {
                  return const _EmptyTodoState();
                }

                return Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      '${todoProvider.totalTodos} tugas tersimpan',
                      style: Theme.of(context).textTheme.titleMedium,
                    ),
                    const SizedBox(height: 8),
                    ...todoProvider.todos.map(
                      (todo) => Card(
                        margin: const EdgeInsets.only(bottom: 8),
                        child: ListTile(
                          leading: CircleAvatar(
                            backgroundColor: colorScheme.secondaryContainer,
                            foregroundColor: colorScheme.onSecondaryContainer,
                            child: const Icon(Icons.checklist),
                          ),
                          title: Text(todo.title),
                          subtitle: Text(
                            'Ditambahkan ${_formatTime(todo.createdAt)}',
                          ),
                        ),
                      ),
                    ),
                  ],
                );
              },
            ),
          ],
        ),
      ),
    );
  }

  String _formatTime(DateTime dateTime) {
    final hour = dateTime.hour.toString().padLeft(2, '0');
    final minute = dateTime.minute.toString().padLeft(2, '0');
    return '$hour:$minute';
  }
}

class _TaskInput extends StatelessWidget {
  const _TaskInput({required this.controller, required this.onSubmitted});

  final TextEditingController controller;
  final VoidCallback onSubmitted;

  @override
  Widget build(BuildContext context) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Expanded(
          child: TextField(
            key: const Key('taskField'),
            controller: controller,
            decoration: const InputDecoration(
              labelText: 'Tugas baru',
              hintText: 'Contoh: Belajar Provider',
            ),
            textInputAction: TextInputAction.done,
            onSubmitted: (_) => onSubmitted(),
          ),
        ),
        const SizedBox(width: 12),
        FilledButton.icon(
          key: const Key('addTaskButton'),
          onPressed: onSubmitted,
          icon: const Icon(Icons.add),
          label: const Text('Tambah'),
        ),
      ],
    );
  }
}

class _FcmStatus extends StatelessWidget {
  const _FcmStatus();

  @override
  Widget build(BuildContext context) {
    return Consumer<FcmService>(
      builder: (context, fcmService, _) {
        return Container(
          padding: const EdgeInsets.all(12),
          decoration: BoxDecoration(
            border: Border.all(color: Theme.of(context).colorScheme.outline),
            borderRadius: BorderRadius.circular(8),
          ),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                children: [
                  const Icon(Icons.notifications_active_outlined),
                  const SizedBox(width: 8),
                  Expanded(
                    child: Text(
                      fcmService.status,
                      style: Theme.of(context).textTheme.bodyMedium,
                    ),
                  ),
                ],
              ),
              if (fcmService.token != null) ...[
                const SizedBox(height: 8),
                SelectableText(
                  'Token: ${fcmService.token}',
                  style: Theme.of(context).textTheme.bodySmall,
                ),
              ],
              if (fcmService.lastMessageTitle != null ||
                  fcmService.lastMessageBody != null) ...[
                const Divider(height: 24),
                Text(
                  fcmService.lastMessageTitle ?? 'Notifikasi baru',
                  style: Theme.of(context).textTheme.titleSmall,
                ),
                if (fcmService.lastMessageBody != null)
                  Text(fcmService.lastMessageBody!),
              ],
            ],
          ),
        );
      },
    );
  }
}

class _EmptyTodoState extends StatelessWidget {
  const _EmptyTodoState();

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: Theme.of(context).colorScheme.surfaceContainerHighest,
        borderRadius: BorderRadius.circular(8),
      ),
      child: const Column(
        children: [
          Icon(Icons.assignment_outlined, size: 48),
          SizedBox(height: 12),
          Text('Belum ada tugas. Tambahkan tugas pertama kamu.'),
        ],
      ),
    );
  }
}

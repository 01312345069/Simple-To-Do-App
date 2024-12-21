<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple To-Do App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css">
    <style>
        .done {
            text-decoration: line-through;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>To-Do List</h1>
        <form action="task.php" method="post">
            <input type="text" name="task" placeholder="Enter a new task" required>
            <button type="submit" name="action" value="add">Add Task</button>
        </form>
        <ul>
            <?php
            if (file_exists('tasks.json')) {
                $tasks = json_decode(file_get_contents('tasks.json'), true);
                foreach ($tasks as $id => $task) {
                    echo '<li>';
                    echo '<span class="' . ($task['done'] ? 'done' : '') . '" data-id="' . $id . '">' . htmlspecialchars($task['name']) . '</span>';
                    echo ' <button type="button" onclick="deleteTask(' . $id . ')">Delete</button>';
                    echo '</li>';
                }
            }
            ?>
        </ul>
    </div>

    <script>
        function deleteTask(id) {
            if (confirm("Are you sure you want to delete this task?")) {
                window.location.href = "task.php?action=delete&id=" + id;
            }
        }
        document.querySelectorAll('span[data-id]').forEach(item => {
            item.addEventListener('click', function () {
                window.location.href = "task.php?action=toggle&id=" + this.getAttribute('data-id');
            });
        });
    </script>
</body>

</html>
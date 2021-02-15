$(document).ready(function()
{
    getTodos();
    //Add listener to add button
    $('.todo-add').on('click', addTodo);
    //Add listener to ul
    $('.todo-list').on('click', handleTodo);
});

function addTodo(event)
{
    event.preventDefault();
    
    let todo = createTodo();
    saveToLocalStorage(todo)
    createTodoElement(todo);
    
    $(".todo-input").val("");
}

function createTodo()
{
    let todo;
    todo = new todoObj($(".todo-input").val());
    return todo;
}

function handleTodo(event)
{
    event.preventDefault();

    const item = event.target;
    const index = Array.from(item.parentElement.parentNode.children).indexOf(item.parentElement);
    const todos = loadFromLocalStorage();
    if(item.classList[0] === "delete-btn")
    {
        todos.splice(index, 1);
        item.parentElement.remove();
    }
    if(item.classList[0] === "complete-btn")
    {
        item.parentElement.classList.toggle("completed");
        if(todos[index].completed)
            todos[index].completed = false;
        else
            todos[index].completed = true;
    }
    localStorage.setItem("todos", JSON.stringify(todos));
}

function saveToLocalStorage(todo)
{
    let todos = loadFromLocalStorage();
    todos.unshift(todo);
    localStorage.setItem("todos", JSON.stringify(todos));
}

function loadFromLocalStorage()
{
    let todos;
    if(localStorage.getItem("todos") === null)
        todos = [];
    else
        todos = JSON.parse(localStorage.getItem("todos"));
    return todos;
}

function getTodos()
{
    let todos = loadFromLocalStorage().reverse();

    todos.forEach(function(todo)
    {
        createTodoElement(todo);
    });
}

function createTodoElement(todo)
{
    const todoDiv = document.createElement('div');
    todoDiv.classList.add('todo');
    if(todo.completed)
        todoDiv.classList.add("completed");

    const newTodo = document.createElement('li');
    newTodo.innerText = todo.title;
    newTodo.classList.add('todo-item');
    todoDiv.appendChild(newTodo);

    const completeButton = document.createElement('button');
    completeButton.innerHTML = '<i class="fas fa-check"></i>';
    completeButton.classList.add('complete-btn');
    todoDiv.appendChild(completeButton);

    const deleteButton = document.createElement('button');
    deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
    deleteButton.classList.add('delete-btn');
    todoDiv.appendChild(deleteButton);

    $(".todo-list").prepend(todoDiv);
}
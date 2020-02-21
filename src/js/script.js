let jsonString = localStorage.getItem('database');
var num_click = 0;
const data = JSON.parse(jsonString) || [];
readItems();

function updateStorage(newData) {
    localStorage.setItem('database', JSON.stringify(newData));
}

function createItem(){
    // Pulls in form data from DOM, formats it to JSON, and saves it to localStorage
    let task = document.getElementById("inputtext").value;
    task = task.replace(/</g, '&lt;');
    task = task.replace(/>/g, '&gt;');
    let due_date = document.getElementById("dueDate").value;
    let item = {
        text: task,
        date: due_date,
        done: false
       // time: due_date.getTime()
    };
    data.push(item);
    updateStorage(data);
    readItems();
}

function readItems() {
    // Pulls in data from localStorage, parses it, and updates DOM accordingly
    let list = document.getElementById("myUL");
    let tasks = "";
    for(let i = 0; i < data.length; i++) {
        tasks +=`<li class ="collection-item" id="${i}">
                    <label>
                        <input type="checkbox" class ="check" id ="check${i}" value="${data[i].done}" onclick ="updateItem(${i})" ${data[i].done ? "checked" : ""}/>
                        <span>${data[i].text}</span>
                        <span class="secondary-content">
                            <span>Due on: ${data[i].date}</span>
                            <button class ="waves-effect waves-light btn" id ="del-btn${i}" onclick ="deleteItem(${i})">Delete</button>
                        </span>
                    </label>
                 </li>`;
    };
    list.innerHTML = tasks;
}

function updateItem(index) {
    // Updates item in data, saves it to localStorage
    data[index].done === false ? data[index].done = true : data[index].done = false;
    updateStorage(data);
    readItems();
}

function deleteItem(index) {
    // Deletes item from data, saves it to localStorage
    data.splice(index, 1);
    updateStorage(data);
    readItems();
}

function sortList(){
    // Sort tasks by due date on 1st click, restore on 2nd click
    num_click++;
    console.log(num_click);
    if(num_click % 2 === 0){
        data.sort(function(a,b) {
            let firstDate = new Date(a.date);
            let secondDate = new Date(b.date);
         return firstDate - secondDate;
        });
    } 
    else if (num_click % 2 === 1) {
        data.sort(function(a,b) {
            let firstDate = new Date(b.date);
            let secondDate = new Date(a.date);
         return firstDate - secondDate;
        });
    }
    updateStorage(data);
    readItems();
}

//document.getElementById("submit-btn").addEventListener("click", createItem);
//document.getElementById("sort-btn").addEventListener("click", sortList);

var input = document.getElementsByTagName('input');

for (var i = 0; i < input.length; i++){
    input[i].value = localStorage.getItem(i);
}

jQuery("input").keyup(function () {
    for (var i = 0; i < input.length; i++){
        localStorage.setItem(i, input[i].value);
    }
});

jQuery("input").click(function () {
    for (var i = 0; i < input.length; i++){
        localStorage.setItem(i, input[i].value);
    }
});
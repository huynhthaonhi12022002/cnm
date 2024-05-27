const form = document.querySelector(".typing-area"),
incoming_id = form.querySelector(".incoming_id").value,
inputField = form.querySelector(".content-msg"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chats");
const chatWapper = document.querySelector(".chat-wrap-inner");
const notification = document.querySelector(".notification-list");
const usersList = document.querySelector(".chat-user-list");
const searchBar = document.querySelector(".search-input");
const searchIcon = document.querySelector(".btn-search");
const link  = document.querySelector(".link-item");
const btnDelete = document.querySelectorAll(".del-msg");

form.onsubmit = (e)=>{
    e.preventDefault();
}

inputField.focus();
inputField.onkeyup = ()=>{
    if(inputField.value != ""){
        sendBtn.classList.add("active");
    }else{
        sendBtn.classList.remove("active");
    }
}

sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/insert-chat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              inputField.value = "";
              scrollToBottom();
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active");
}

chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
}


function startInterval() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/get-chat-emp.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                chatBox.innerHTML = data;
                if(!chatBox.classList.contains("active")){
                    scrollToBottom();
                  }
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id=" + incoming_id);
}

intervalId = setInterval(startInterval, 500);



function startIntervalNoti() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/get-notification.php", true);
    xhr.onload = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.responseText;
                notification.innerHTML = data;
            } else {
                console.error('Error:', xhr.status);
            }
        }
    };
    xhr.onerror = function() {
        console.error('Request failed');
    };
    xhr.send();
}

var intervalId1 = setInterval(startIntervalNoti, 500);

function startIntervalUser() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "../php/users.php", true);
    xhr.onload = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.responseText;
                if(!searchBar.classList.contains("active")){
                    usersList.innerHTML = data;
                }
            } else {
                console.error('Error:', xhr.status);
            }
        }
    };
    xhr.onerror = function() {
        console.error('Request failed');
    };
    xhr.send();
}

var intervalId2 = setInterval(startIntervalUser, 500);


searchIcon.onclick = ()=>{
    searchBar.classList.toggle("show");
    searchIcon.classList.toggle("active");
    searchBar.focus();
    if(searchBar.classList.contains("active")){
      searchBar.value = "";
      searchBar.classList.remove("active");
    }
  }

searchBar.onkeyup = () => {
    let searchTerm = searchBar.value;
    if(searchTerm != ""){
        searchBar.classList.add("active");
    }else{
        searchBar.classList.remove("active");
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/search.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            usersList.innerHTML = data;
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + searchTerm);
}



// function startInterval() {
//     sendAjaxRequest("POST", "php/get-chat.php", "incoming_id=" + incoming_id, function(data) {
//         chatBox.innerHTML = data;
//         if (!chatBox.classList.contains("active")) {
//             scrollToBottom();
//         }
//     });
// }

// function startIntervalNoti() {
//     sendAjaxRequest("POST", "php/get-notification.php", "", function(data) {
//         notification.innerHTML = data;
//     });
// }

// function startIntervalUser() {
//     sendAjaxRequest("GET", "php/users.php", "", function(data) {
//         usersList.innerHTML = data;
//     });
// }

// function sendSearchRequest(searchTerm) {
//     sendAjaxRequest("POST", "php/search.php", "searchTerm=" + searchTerm, function(data) {
//         usersList.innerHTML = data;
//     });
// }

// // Gọi các hàm startInterval tương ứng mỗi 500ms
// var intervalId = setInterval(startInterval, 500);
// var intervalId1 = setInterval(startIntervalNoti, 500);
// var intervalId2 = setInterval(startIntervalUser, 500);
// document.querySelector('.del-msg').onclick = function() {
//     intervalId = setInterval(startInterval, 10000);
// };


function scrollToBottom(){
    chatWapper.scrollTop = chatWapper.scrollHeight;
  }
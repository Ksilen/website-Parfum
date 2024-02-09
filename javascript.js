var result = [];
function select_db() {
  d = document.getElementById("select_id").value;
  switch (d) {
    case "alfabet":
      postPHP("alfabet");
      break;
    case "non_alfabet":
      postPHP("non_alfabet");
      break;
    case "desk":
      postPHP("desk");
      break;
    case "asc":
      postPHP("asc");
      break;
    default:
      postPHP("default");
  }
}
function postPHP(texts) {
  var obj = {};
  obj.choice = texts;
  var jsonString = JSON.stringify(obj);
  fetch('qudata.php', {
    method: 'POST',
    headers: {
      "Content-Type": "application/json",
      "Access-Control-Allow-Origin": "*",
      "Access-Control-Allow-Credentials": true
    },
    body: jsonString
  })
    .then(response => response.json())
    .then(data => document.getElementById("textdb").innerHTML = createDataTable(data));
}

function createDataTable(data) {
  result = [];
  for (var i in data) {
    if (data[i][0] != null) {
      result.push(data[i][0]);
    } else {
      result.push("0");
    }
    if (data[i][1] != null) {
      result.push(data[i][1]);
    } else {
      result.push("0");
    }
  }
  return createDataHtml(result);
}

function showProduct(name, price) {
  var modal = document.getElementById("myModal");
  modal.style.display = "block";

 document.getElementsByClassName("close")[0].onclick = function () {
    modal.style.display = "none";
  }
  
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
  document.getElementById("modal_text").innerHTML = name;
  document.getElementById("modal_price").innerHTML = "Цена: " + price +"  ₽";
}

function createDataHtml(result) {
  var str = "";
  for (i = 0; i < result.length; i += 2) {
     str += "<div class=\"my-flex-cont\" onclick= \"showProduct(\'" +
      result[i].replace(/"/g, " ") + "\',\'" + result[i + 1].replace(/"/g, " ") + "\')\">" +
      "<div class=\"my-flex-box\">" +
      result[i] +
      "<br> </div><div class=\"my-flex-box-price\">" +
      result[i + 1] +
      " ₽</div></div>";
  }
    str += `
      <a href="#top" id="back-to-top" class="back-to-top" title="Back to top">
          <img src="main_img/uparrowbutton.svg" />
      </a>" 
  `
  str += " <div class=\"footer\">"
    + "<p>г.Ульяновск, ул.Камышинская, 16а<br>"
    + "<a href=\"tel:89084704551\">тел.: +7 908 470 45 51</a> <br></p></div>";
  str += `<div id="myModal" class="modal">
    <div class="modal-content">
      <div class="modal-text">
         <span class="close">&times;</span>
         &nbsp;
      </div>
      <div id = "modal_text" class = "modal-text">
      </div>
      <div id = "modal_price" class="modal-price">
      </div>
    </div>
  </div>
  `
  return str;
}

function findWord(word, str) {
  return RegExp('\\b' + word + '\\b').test(str)
}

function find_word() {
  let inputs = document.getElementById("searchIn");
  let input_text = inputs.value;
  if (input_text == "") {
    document.getElementById("textdb").innerHTML = createDataHtml(result);
  } else {
    let find_array = result.map((item, i) => item.toUpperCase().indexOf(
      input_text.toUpperCase()) >= 0 ? i % 2 == 0 ? i : i - 1 : -1).filter(item => item >= 0);
    var result_array = [];
    find_array.forEach(function (item) {
      result_array.push(result[item]);
      result_array.push(result[item + 1]);
    });
    document.getElementById("textdb").innerHTML = createDataHtml(result_array);
  }
}

window.onload = function () {
  window.onscroll = function () {
    if (window.scrollY < 25) {
      document.getElementById("back-to-top").style.cssText = `
      .back-to-top {
        background: #c7c3c3;
        opacity: 0;
      }     
      .back-to-top:hover {
        background:#f8f7f7;
      }
      .back-to-top:active {
        background-color: #fff;        
      }
      `
    } else { document.getElementById("back-to-top").style.opacity = '1'; }
  }
}
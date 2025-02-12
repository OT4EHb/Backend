function saveForm(event) {
    event.preventDefault();
    if (!document.querySelector("form").reportValidity()) {
        return;
    }
    let httpRequest = new XMLHttpRequest();
    httpRequest.open("POST", "form.php");
    httpRequest.setRequestHeader("Content-Type", "application/json");
    httpRequest.setRequestHeader("Accept", "application/json");
    let obj = {};
    let inputs = document.querySelectorAll(".req");
    inputs.forEach(function (i) {
        obj[i.name] = i.value;
    });
    obj["sex"] = document.querySelector("input[name=sex]:checked").value;
    let selected = document.querySelector("select[name=lang]").selectedOptions;
    obj["lang"] = Array.from(selected).map(option => option.value);
    httpRequest.send(JSON.stringify(obj));
    httpRequest.onreadystatechange = function () {
        if (this.readyState === 4) {
            let otvet = document.querySelector(".otvet");
            otvet.innerHTML = this.responseText;
            window.location.href = window.location.pathname + "#otvet";
        }
    };
}

window.addEventListener("DOMContentLoaded", function () {
    document.getElementById("buttonSave").addEventListener("click", saveForm);
});
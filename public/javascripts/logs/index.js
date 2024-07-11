// Select DOM elements 
const hambergerBtn = document.querySelector("#hambergerBtn")
const attributesDiv = document.querySelector(".attributes")

function showDetail(row) {
    document.querySelector(".modal").style.display = "block"

    let deviceId = row.innerHTML

    fetch(`?controller=logs&action=new&deviceId=${deviceId}`)
        .then(response => response.json())
        .then(data => {
            let attributes = attributesDiv.querySelectorAll(".attribute")

            document.querySelector(".modalTitle span").innerHTML = data.name;
            attributes[0].querySelector("span").textContent = data.deviceId;
            let lastAction = data.action
            let currenStatus = "OFF";

            if (lastAction == "Turn On") {
                currenStatus = "ON";
            } else {
                currenStatus = "OFF"
            }
            attributes[1].querySelector("span").textContent = currenStatus
            attributes[2].querySelector("span").textContent = data.lastTimeAction
            
            document.querySelector("#deviceId").value = data.deviceId;


            if (currenStatus == "ON") { // turn off
                document.querySelector("#turnOff").style.display = "block"
                document.querySelector("#turnOn").style.display = "none"

                document.querySelector("#logAction").value = "Turn Off"
            } else {
                document.querySelector("#turnOff").style.display = "none"
                document.querySelector("#turnOn").style.display = "block"

                document.querySelector("#logAction").value = "Turn On";
            }
        });
}

function closeModal() {
    document.querySelector(".modal").style.display = "none"
}

function toggleStatus(button) {
    let action = ""
    if (button.id == "turnOn") {
        document.querySelector("#turnOff").style.display = "block"
        document.querySelector("#turnOn").style.display = "none"
        action = "Turn On"
    } else {
        document.querySelector("#turnOff").style.display = "none"
        document.querySelector("#turnOn").style.display = "block"
        action = "Turn Off"
    }
}


// Select DOM elements 
const dataTable = document.querySelector(".dataTable")
const hambergerBtn = document.querySelector("#hambergerBtn")
const dashboard = document.querySelector(".dashboard")
const addDeviceDiv = document.querySelector(".addDevice")
const editDeviceDiv = document.querySelector(".editDevice")


// Draw chart with chart.js
let chartInstance = null
function drawChart() {
    const ctx = document.getElementById('chart')
    const rows = document.querySelectorAll('.dataTable tbody tr')

    if (rows[0].childNodes.length < 6) {
        return
    }

    let deviceNames = []
    let powerConsumptions = []
    let backgroundColors = []

    rows.forEach(row => {
        const deviceName = row.cells[0].textContent
        const powerConsumption = row.cells[4].textContent
        deviceNames.push(deviceName)
        powerConsumptions.push(powerConsumption)
    });

    // handle same device name
    let dataMap = new Map();
    for (let i = 0; i < deviceNames.length; i++) {
        if (!dataMap.has(deviceNames[i])) {
            dataMap.set(deviceNames[i], powerConsumptions[i])
        } else {
            let currentPowerConsumption = dataMap.get(deviceNames[i])
            dataMap.set(deviceNames[i], (parseInt(currentPowerConsumption) + parseInt(powerConsumptions[i])).toString())
        }
    }

    deviceNames = Array.from(dataMap.keys())
    powerConsumptions = Array.from(dataMap.values())

    for (let i = 0; i < deviceNames.length; i++) {
        let red = Math.floor(Math.random() * 256)
        let green = Math.floor(Math.random() * 256)
        let blue = Math.floor(Math.random() * 256)
        backgroundColors.push(`rgb(${red}, ${green}, ${blue})`)
    }

    const data = {
        labels: deviceNames,
        datasets: [{
            label: ' Power consumption',
            data: powerConsumptions,
            backgroundColor: backgroundColors,
            hoverOffset: 4
        }]
    };

    const config = {
        type: 'doughnut',
        data: data,
    };

    if (chartInstance) {
        chartInstance.destroy();
    }

    chartInstance = new Chart(ctx, config)
}


function toggleEditForm(button, id) {
    if (addDeviceDiv.style.display === "none") {
        addDeviceDiv.style.display = "flex";
        editDeviceDiv.style.display = "none";
    } else {
        addDeviceDiv.style.display = "none";
        editDeviceDiv.style.display = "flex";

        let currentValues = button.parentElement.parentElement.querySelectorAll("td");

        const deviceIdEdit = editDeviceDiv.querySelector("#deviceIdEdit");
        const deviceNameEdit = editDeviceDiv.querySelector("#deviceNameEdit");
        const deviceMACEdit = editDeviceDiv.querySelector("#deviceMACEdit");
        const deviceIPEdit = editDeviceDiv.querySelector("#deviceIPEdit");
        const devicePowerEdit = editDeviceDiv.querySelector("#devicePowerEdit");

        if (deviceIdEdit) deviceIdEdit.value = id
        if (deviceNameEdit) deviceNameEdit.value = currentValues[0].textContent;
        if (deviceMACEdit) deviceMACEdit.value = currentValues[1].textContent;
        if (deviceIPEdit) deviceIPEdit.value = currentValues[2].textContent;
        if (devicePowerEdit) devicePowerEdit.value = currentValues[4].textContent;
    }
}

// DOM initialization
document.addEventListener('DOMContentLoaded', () => {
    let tableBody = dataTable.querySelector("tbody");
    if(tableBody.querySelectorAll("tr").length == 0) {
        tableBody.innerHTML = `<td colspan="6" >There is no device!</td>`
        dashboard.style.display = "none"
        addDeviceDiv.style.width = "100%"
        return
    }
    drawChart();
})

const sidebar = document.querySelector(".sidebar")
const title = document.querySelector(".title")

// Hide/show sidebar on mobile devices
function showSidebar() {
    sidebar.style.left = 0
}

function hideSidebar() {
    sidebar.style.left = "-250px"
}

// Event listener for click events to show/hide sidebar
document.addEventListener('click', function (event) {
    if (hambergerBtn.contains(event.target)) {
        showSidebar()
        title.querySelector("i").className = "fas fa-user-circle fa-2x"
        title.querySelector("span").textContent = "Welcome John"
    } else if (screen.width <= 414 && !sidebar.contains(event.target)) {
        hideSidebar()
    }
});

// Event listener for window resize to handle UI errors
window.addEventListener('resize', function (event) {
    if (screen.width > 414) {
        showSidebar()
        title.querySelector("i").className = "fa-solid fa-fax icon-header fa-2x"
        title.querySelector("span").textContent = "Device Management"
    } else if (screen.width <= 414) {
        hideSidebar()
        title.querySelector("i").className = "fas fa-user-circle fa-2x"
        title.querySelector("span").textContent = "Welcome John"
    }
}, true);

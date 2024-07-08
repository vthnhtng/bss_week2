<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>
    <link rel="stylesheet" href="../stylesheets/logs/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="title">
            <i class="fa-solid fa-fax icon-header fa-2x"></i>
            <span>Device Management</span>
        </div>
        <div class="itemContainer">
            <a href="?controller=devices&action=index" class="sidebarItem"><i class="fa fa-bar-chart fa-2x"></i></i><span>Dashboard</span></a>
            <a href="#" class="sidebarItem"><i class="fa fa-history fa-2x" aria-hidden="true"></i><span class="highlight">Logs</span></a>
            <a href="#" class="sidebarItem"><i class="fa fa-cog fa-2x" aria-hidden="true"></i><span>Settings</span></a>
        </div>

    </div>

    <!-- container -->
    <div class="main">
        <div class="header">
            <div class="account">
                <i class="fas fa-user-circle fa-2x"></i>
                <span>Welcome John</span>
            </div>
        </div>
        <div class="container">
            <div class="hamberger">
                <button id="hambergerBtn"><i class="fa-solid fa-bars fa-2x"></i></button>
            </div>
            <div class="upper">
                <span class="tableTitle">Action Logs</span>
                <div class="search">
                    <input id="searchInput" type="text" placeholder="name">
                    <button id="searchBtn" onclick="searchDevice()">Search</button>
                </div>
            </div>
            <table class="dataTable">
                <thead>
                    <tr>
                        <th>Device ID#</th>
                        <th>Name</th>
                        <th>Action</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($logs as $log) {
                        echo '<tr>
                                <td>' . htmlspecialchars($log->deviceId) . '</td>
                                <td>' . htmlspecialchars(Device::findById($log->deviceId)->name) . '</td>
                                <td>' . htmlspecialchars($log->logAction) . '</td>
                                <td>' . htmlspecialchars($log->logDate) . '</td>
                            </tr>';
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td colspan="2"></td>
                        <?php 
                            echo '<td id="total">'.Log::getTotalLogs().'</td>';
                        ?>
                    </tr>
                </tfoot>
            </table>
            <div class="pages">
            </div>
        </div>
    </div>

    <div class="modal">
        <div class="modalTitle">
            <span>TITLE</span>
            <button onclick="closeModal()"><i class="fa fa-close fa-2x"></i></button>
        </div>
        <div class="attributes">
            <div class="attribute">
                <label>Device ID: </label>
                <span></span>
            </div>
            <div class="attribute">
                <label>Device Status: </label>
                <span>OFF</span>
            </div>
            <div class="attribute">
                <label>Last Time Action: </label>
                <span></span>
            </div>
        </div>
        <div class="control">
            <button id="turnOn" onclick="toggleStatus(this)">Turn ON</button>
            <button id="turnOff" onclick="toggleStatus(this)">Turn OFF</button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/logs.js"></script>
</body>

</html>
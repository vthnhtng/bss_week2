<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device Dashboard</title>
    <link rel="stylesheet" href="../stylesheets/devices/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="title">
            <i class="fa-solid fa-fax icon-header fa-2x"></i>
            <span>Device Management</span>
        </div>
        <div class="itemContainer">
            <a href="" class="sidebarItem"><i class="fa fa-bar-chart fa-2x"></i></i><span
                    class="highlight">Dashboard</span></a>
            <a href="?controller=logs&action=index" class="sidebarItem"><i class="fa fa-history fa-2x"
                    aria-hidden="true"></i><span>Logs</span></a>
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
            <table class="dataTable">
                <thead>
                    <tr>
                        <th>Devices</th>
                        <th>MAC Address</th>
                        <th>IP</th>
                        <th>Created Date</th>
                        <th>Power Consumption (Kw/H)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalConsumption = 0;
                    foreach ($devices as $device) {
                        echo '<tr>
                                <td>' . htmlspecialchars($device->name) . '</td>
                                <td>' . htmlspecialchars($device->MAC) . '</td>
                                <td>' . htmlspecialchars($device->IP) . '</td>
                                <td>' . htmlspecialchars($device->createdDate) . '</td>
                                <td>' . htmlspecialchars($device->powerConsumption) . '</td>
                                <td class="action">
                                    <button onclick="toggleEditForm(this, ' . $device->id . ')">Edit</button>|
                                    <a href="?controller=devices&action=delete&id=' . htmlspecialchars($device->id) . '">Delete</a>
                                </td>
                            </tr>';
                        $totalConsumption += $device->powerConsumption;
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td colspan="3"></td>
                        <?php
                        echo '<td id="total">' . $totalConsumption . '</td>';
                        ?>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <div class="bottomPart">
                <div class="dashboard">
                    <span>Power Consumption</span>
                    <canvas id="chart"></canvas>
                </div>

                <div class="addDevice">
                    <h1>ADD A NEW DEVICE</h1>
                    <form action="?controller=devices&action=create" method="post" id="addForm">
                        <input id="deviceName" name="deviceName" type="text" placeholder="name">
                        <input id="deviceIP" name="deviceIP" type="text" placeholder="IP Address">
                        <input id="deviceMAC" name="deviceMAC" type="text" placeholder="MAC Address">
                        <?php
                        session_start();
                        if (isset($_SESSION['create_error'])) {
                            echo '<div class="error-message">' . $_SESSION['create_error'] . '</div>';
                            unset($_SESSION['create_error']); // Clear the error message from session
                        }
                        ?>
                        <button type="submit">ADD DEVICE</button>
                    </form>
                </div>
                <div class="editDevice">
                    <form action="?controller=devices&action=update" method="post" id="">
                        <input type="hidden" id="deviceIdEdit" name="deviceId" value="" />
                        <label>Device Name</label>
                        <input type="text" id="deviceNameEdit" name="deviceName" />
                        <label>MAC Address</label>
                        <input type="text" id="deviceMACEdit" name="deviceMAC" />
                        <label>IP Address</label>
                        <input type="text" id="deviceIPEdit" name="deviceIP" />
                        <label>Power Consumption</label>
                        <input type="text" id="devicePowerEdit" name="powerConsumption" />
                        <?php
                        session_start();
                        if (isset($_SESSION['update_error'])) {
                            echo '<div class="error-message">' . $_SESSION['update_error'] . '</div>';
                            unset($_SESSION['update_error']); // Clear the error message from session
                        }
                        ?>
                        <button>SAVE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../javascripts/devices/index.js"></script>
</body>

</html>
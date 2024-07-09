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
                    <form method="GET" action="">
                        <input type="hidden" name="controller" value="logs">
                        <input type="hidden" name="action" value="index">
                        <input type="hidden" name="page" value=1>
                        <input id="logsPerPage" type="number" name="rows" value="<?php echo $rows; ?>" step="5" min="1" placeholder="Logs/page">
                        <input id="searchInput" type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="Search">
                        <button id="searchBtn" type="submit">Search</button>
                    </form>
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
                                <td>' . $log->deviceId . '</td>
                                <td>' . Device::findById($log->deviceId)->name . '</td>
                                <td>' . $log->logAction . '</td>
                                <td>' . $log->logDate . '</td>
                            </tr>';
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td colspan="2"></td>
                        <td id="total">
                            <?php
                            if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
                                echo Log::getTotalLogsByKeyword($_GET['keyword']);
                            } else {
                                echo Log::getTotalLogs();
                            }
                            ?>
                        </td>

                    </tr>
                </tfoot>
            </table>
            <div class="pages">
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <a class="pageNumber <?php echo ($i == $currentPage) ? 'chosing' : ''; ?>" href="?controller=logs&action=index&page= <?php echo $i; ?>
                        <?php
                        if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
                            echo '&keyword=' . $_GET['keyword'];
                        }
                        if (isset($_GET['rows']) && !empty($_GET['rows'])) {
                            echo $i . '&rows=' . $_GET['rows'];
                        }
                        ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
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

    <script src="js/logs.js"></script>
</body>

</html>
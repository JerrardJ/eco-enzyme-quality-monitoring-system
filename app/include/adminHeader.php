<header>
    <div class="containernav-admin">
        <div class="titleAdmin">
        <!-- <img class="img-logo" src="asset/images/favicon.png" alt="logo dapur ambu"> -->
            <a href="index.php">
                <h1>Eco-Enzyme Monitoring System</h1>
            </a>
        </div>

        <div class="menuAdmin">
            <li>
            <form action="index.php">
            </form>
            </li>
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="dropdownAdmin">
                        <li>
                            <form action="#">
                                <button type="submit">                                
                                    <i class="fa fa-user"></i>
                                        <?php echo $_SESSION['username']; ?>
                                    <i class="fa fa-chevron-down" style="font-size: .8em;"></i>
                                    </button>
                            </form>
                        </li>
                        
                        <div class="dropdown-contentAdmin">
                            <li class="dropcont">
                                <form action="indexDashboard.php">
                                    <button type="submit">Dashboard</button>
                                </form>
                            </li>
                            <li class="dropcont">
                                <form action="indexUser.php">
                                    <button type="submit">Manage User</button>
                                </form>
                            </li>
                            <li class="dropcont">
                                <form action="logout.php">
                                    <button type="submit">Logout</button>
                                </form>
                            </li>
                        </div>
                    </div>
                
                <?php endif; ?>
        </div>
        <div class="menu-toggle" id="menutoggle">
                        <span></span>
                        <span></span>
                        <span></span>
        </div>
    </div>
</header>
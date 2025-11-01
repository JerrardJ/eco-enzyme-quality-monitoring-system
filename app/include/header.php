<header>
    <div class="containernav">
    <div class="title">
    <!-- <img class="img-logo" src="asset/images/favicon.png" alt="logo dapur ambu"> -->
        <a href="index.php">
            <h1>Eco-Enzyme Monitoring System</h1>
        </a>
    </div>

        <div class="menu">
        <?php if (isset($_SESSION['id'])): ?>
                    <div class="dropdown">
                        <li>
                            <form action="#">    
                            <button type="submit">
                                <i class="fa fa-user"></i>
                                    <span><?php echo $_SESSION['username']; ?></span>
                                <i class="fa fa-chevron-down" style="font-size: .8em;"></i>
                            </button>
                            </form>
                        </li>
                            <div class="dropdown-content">
                            <div class="dropcont">
                                    <?php if($_SESSION['admin']): ?>
                                        <li>
                                            <form action="index.php">
                                                <button type="submit">Welcome To Eco-Enzyme Monitoring System</button>
                                            </form>
                                            <!-- <a href="<?php echo "index.php"?>">Dashboard</a> -->
                                        </li>
                                    <?php endif; ?>

                                <li>
                                    <form action="logout.php">
                                        <button type="submit">Logout</button>
                                    </form>
                                </li>    
                                </div>
                            </div>
                    </div>
                    <?php else: ?>
                        <li style="color:white;">
                            <form action="login.php">
                            <button type="submit">Login
                            </button>
                            </form>
                        </li>                        
                <?php endif; ?>
        </div>
        <div class="menu-toggle" id="menutoggle">
                    <span></span>
                    <span></span>
                    <span></span>
        </div>
</div>

</header>


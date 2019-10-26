<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
    <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars" aria-hidden="true"></i></a></li>
    </ul>

    <!-- Nav Links-->
    <ol class="navbar-nav ml-2 text-sm">
        <?php foreach ($navbar_link as $key => $value){?>
        <li class="breadcrumb-item <?php echo ($value[2]?"active":""); ?>">
        <?php if ($value[2]==false) {?> <a href="#" id="<?php echo $value[0]; ?>"><?} echo $key;?></a></li>
        <?php } ?>
    </ol>
    <script type="text/javascript">
        <?php foreach ($navbar_link as $key => $value){ if ($value[1] != "#"){?>
            $("#<?php echo $value[0]; ?>").click(function(){ redirect("/", {"page": "<?php echo $value[1]; ?>" }); });
        <?php }} ?>
    </script>

    <!-- SEARCH FORM -->
    <!--form class="form-inline ml-3">
    <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
        <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
        </button>
        </div>
    </div>
    </form -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#"><i class="fa fa-user" aria-hidden="true"></i></a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header ctext-usertype">User Type</span>
        <span class="dropdown-item dropdown-header ctext-username">User Name</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item"> Profile </a>
        <a href="#" class="dropdown-item" id="user-inbox"> Inbox </a>
        <a href="#" class="dropdown-item" id="user-logout"> Logout </a>
    </li>
    </ul>
</nav>
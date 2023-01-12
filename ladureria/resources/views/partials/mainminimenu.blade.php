<div class="col-sm-12 col-xs-12 pull-left">
    <div class="minimenu3 hidden-md hidden-lg">
        <div style="position: absolute; z-index: 1000">
            <div class="dosmenu_bar">
                <a href="#!" class=" bt-menu" style="text-align: left; left: 0"><i class="fa fa-bars" aria-hidden="true"></i></a>
            </div>
            <nav class="nmen">
                <ul style="background: #d4d4d4;">
                    <li><a href="#" style="z-index: 1000">Why us</a> </li>
                    <li><a href="/destinations" style="z-index: 1000">Destinations</a> </li>
                    <li><a href="/ourtrips" style="z-index: 1000">Our trips</a></li>
                    <li><a href="#" style="z-index: 1000">About Us</a> </li>
                    <li><a href="#" style="z-index: 1000">Contact</a> </li>
                    <li><a href="#" style="z-index: 1000">Cusco Tips</a> </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<style>
    /*minimenu sandwich*/
    .minimenu3 {
        width:100%;
    }
    .minimenu3 nav {
        width:90%;
        max-width:1000px;
        margin:20px auto;
        /*background:#024959;*/
    }
    .dosmenu_bar {
        display:none;
    }
    .minimenu3 nav ul {
        overflow:hidden;
        list-style:none;
    }
    .minimenu3 nav ul li {
        float:left;
    }
    .minimenu3 nav ul li a {
        color:#fff;
        padding:20px;
        display:block;
        text-decoration:none;
    }
    .minimenu3 nav ul li span {
        margin-right:10px;
    }

    .minimenu3 nav ul li a:hover {
        background:#037E8C;
    }
    section {
        padding:20px;
    }
    @media screen and (max-width:991px ) {
        .minimenu3 nav {
            width:80%;
            height:100%;
            left:-100%;
            margin:0;
            position: fixed;
        }
        .minimenu3 nav ul li {
            display:block;
            float:none;
            border-bottom:1px solid rgba(255,255,255, .3);
        }
        .dosmenu_bar {
            display:block;
            width:100%;
            /*background:#ccc;*/
        }
        .dosmenu_bar .bt-menu {
            display:block;
            padding:20px;
            /*background:#024959;*/
            color:#fff;
            text-decoration:none;
            font-weight: bold;
            font-size:25px;
            -webkit-box-sizing:border-box;
            -moz-box-sizing:border-box;
            box-sizing:border-box;
        }
        .dosmenu_bar span {
            float:left;
            font-size:40px;
        }
    }/**fin minimenu2**/
</style>
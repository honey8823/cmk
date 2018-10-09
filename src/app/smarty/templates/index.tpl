<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{$smarty.const.SITE_NAME_FULL}</title>
  {include file='common/adminlte_css.tpl'}

  <style>
    .box-child{
        margin-left: 10px;
    }
    .box-header-icon{
        color: gray;
    }

    hr.recipe{
        margin-top: 5px;
        margin-bottom: 5px;
    }

    .recipe-menu{
        margin: 10px;
        letter-spacing: 5px;
    }
    .recipe-menu .normal{
        float: left;
    }
    .recipe-menu .report{
        float: right;
    }



.menu-tooltip {
position: relative;
display: inline-block;
cursor: pointer;
}
.menu-tooltip .menu-tooltiptext {
position: absolute;
z-index: 1;
bottom: 110%;
visibility: hidden;
width: auto;
white-space: nowrap;
padding: 0.3em 0.5em;
transition: opacity 1s;
text-align: center;
opacity: 0;
color: #ffffff;
border-radius: 6px;
letter-spacing: 0px;
}
.normal .menu-tooltip .menu-tooltiptext {
left: -10px;
background-color: #666666;
}
.report .menu-tooltip .menu-tooltiptext {
right: -10px;
background-color: #999999;
}
.menu-tooltip .menu-tooltiptext::after {
position: absolute;
top: 100%;
margin-left: -5px;
content: ' ';
border: 5px solid transparent;

}
.normal .menu-tooltip .menu-tooltiptext::after {
left: 15px;
border-top-color: #666666;
}
.report .menu-tooltip .menu-tooltiptext::after {
right: 15px;
border-top-color: #999999;
}
.menu-tooltip:hover .menu-tooltiptext {
visibility: visible;
opacity: 1;
}


  </style>


</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  {include file='common/header.tpl'}
  {include file='common/sidebar.tpl'}

  <!-- Main content start -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>sandbox</h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">


test



    </section>

  </div>

  <!-- Main content end -->

  {include file='common/footer.tpl'}

</div>
<!-- ./wrapper -->

<!-- JS start -->
{include file='common/adminlte_js.tpl'}
<script src="/js/common.js"></script>

<script>


</script>
<!-- JS end -->
</body>
</html>
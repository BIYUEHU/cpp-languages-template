<div class="row">
    <div class="col-md-12">
        <div class="tile" style="margin-bottom: 0px;">
            <div class="tile-body"><?php echo APP_COPYRIGHT ?></div>
        </div>
    </div>
</div>
</main>
<script src="//cdn.staticfile.org/layui/2.8.7/layui.js"></script>
<script src="/index.php/assets/js/user/jquery.min.js"></script>
<script src="/index.php/assets/js/user/popper.min.js"></script>
<script src="/index.php/assets/js/user/bootstrap.min.js"></script>
<script src="/index.php/assets/js/user/main.js"></script>
<script src="/index.php/assets/js/user/index.js"></script>
<script src="/index.php/assets/js/index.js"></script>
<script>
    const dom = document.getElementById('goodMsg');
    dom && (dom.innerHTML = '主人,' + goodMsg());
</script>
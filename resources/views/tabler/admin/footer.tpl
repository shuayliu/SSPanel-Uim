<footer class="ui-footer">
    <div class="container">
        &copy;{date("Y")} {$config['appName']} | Powered by <a href="/staff">SSPANEL</a>
        {if $config['enable_analytics_code'] === true}{include file='analytics.tpl'}{/if}
    </div>
</footer>

<!-- js -->
<script src="https://cdn.staticfile.org/clipboard.js/2.0.11/clipboard.min.js"></script>
<script src="https://cdn.staticfile.org/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdn.staticfile.org/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.staticfile.org/datatables/1.10.19/js/dataTables.material.min.js"></script>
<script src="/theme/tabler/js/base.min.js"></script>
<script src="/theme/tabler/js/project.min.js"></script>

</body>
</html>

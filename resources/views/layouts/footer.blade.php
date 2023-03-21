<footer class="footer mt-auto">
    <div class="copyright bg-white">
        <p>
            &copy; <span id="copy-year">2023</span> Copyright {{ env('APP_NAME') }}, Develop by
            <a class="text-primary" href="https://msarweb.net/" target="_blank">MSARWEB</a>.
        </p>
    </div>
    <script>
        var d = new Date();
        var year = d.getFullYear();
        document.getElementById("copy-year").innerHTML = year;
    </script>
</footer>

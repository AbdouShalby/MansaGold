<footer class="footer mt-auto">
    <div class="copyright bg-white">
        <p>
            &copy; <span id="copy-year">2023</span> {{ __('footer.copy') }} {{ env('APP_NAME') }}, {{ __('footer.dev') }}
            <a class="text-primary" href="https://msarweb.net/" target="_blank">{{ __('footer.msar') }}</a>.
        </p>
    </div>
    <script>
        var d = new Date();
        var year = d.getFullYear();
        document.getElementById("copy-year").innerHTML = year;
    </script>
</footer>

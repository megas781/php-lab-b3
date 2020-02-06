        </div>
    </div>
</main>
    <footer class="footer js-footer _flex-centering">

<!--        --><?php //echo App::$footerContent; ?>
        <span style="color: var(--dark-theme_secondary-color)">Выполнил Калачев Глеб, 181-321</span>


        <script>
            let footerPaddingDiv = document.createElement("div");
            footerPaddingDiv.style.height = getComputedStyle(document.querySelector(".js-footer")).getPropertyValue('height');
            // footerPaddingDiv.style.background = "var(--light-theme_background)";
            document.querySelector(".js-footer").insertAdjacentElement("afterend", footerPaddingDiv);
        </script>
    </footer>

    <script src="<?php echo HTTP_ROOT . '/script.js' ?>"></script>
</body>
</html>
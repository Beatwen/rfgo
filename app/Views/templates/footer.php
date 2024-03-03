    </main>
    <footer>
        <p>&copy; RF_Go</p>
    </footer>
    <script type="module" src="./public/ressources/js/app.js"></script>
    <?php if (isset($pageInfos['action']) && $pageInfos['action'] == 'contact'): ?>
    <script type="module" src="./public/ressources/js/modules/contact.js"></script>
    <script type="module" src="./public/ressources/js/modules/MadScroll.js"></script>
    <script type="module" src="./public/ressources/js/modules/GetImages.js"></script>
    <?php endif; ?> 
</body>
</html> 
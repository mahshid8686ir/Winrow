            <div class="mx-4 md:mx-50">
                <footer class="mt-100 border-t border-gray-300 py-10">
                    <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center text-gray-600 text-sm">
                        <div class="flex items-center justify-center md:justify-end">
                            <a href="<?php echo home_url(); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/shadowed.png" alt="لوگو" class="h-18">
                            </a>            
                        </div>

                        <div class="text-center">
                            <p class="text-gray-700 text-base font-medium">© کلیه حقوق این سایت برای پارت محفوظ می‌باشد.</p>
                        </div>
                        
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-slate-950 hover:bg-blue-50 transition-colors duration-200">
                                <i class="fab fa-twitter text-lg"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-slate-950 hover:bg-blue-50 transition-colors duration-200">
                                <i class="fab fa-linkedin-in text-lg"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-slate-950 hover:bg-blue-50 transition-colors duration-200">
                                <i class="fab fa-facebook-f text-lg"></i>
                            </a>
                        </div>   
                    </div>
                </footer>
            </div>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>
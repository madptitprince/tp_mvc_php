<?php
class View {
    private static $data = [];
    
    /**
     * Set view data
     */
    public static function setData($key, $value) {
        self::$data[$key] = $value;
    }
    
    /**
     * Render a view with layout
     */
    public static function render($view, $data = []) {
        // Combine default data with view-specific data
        $viewData = array_merge(self::$data, $data);
        
        // Extract variables for the view
        extract($viewData);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        $viewFile = __DIR__ . "/../views/{$view}.php";
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo "<div class='alert alert-danger'>View file not found: {$view}</div>";
        }
        
        // Get the view content
        $content = ob_get_clean();
        
        // Load the main layout with the content
        $layoutFile = __DIR__ . "/../views/layouts/main.php";
        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            echo $content;
        }
    }
    
    /**
     * Render a partial view (without layout)
     */
    public static function renderPartial($view, $data = []) {
        extract($data);
        require __DIR__ . "/../views/{$view}.php";
    }
}
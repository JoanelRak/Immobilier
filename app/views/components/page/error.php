<div class="error-container">
    <h2 class="error-title">Error</h2>
    <div class="error-message">
        <?php use app\components\ErrorHandler;

        echo htmlspecialchars(ErrorHandler::getError()); ?>
    </div>
    <a href="/" class="error-back">Back to Home</a>
</div>
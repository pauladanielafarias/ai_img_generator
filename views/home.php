<!-- INCLUDE VARIABLES FILE -->
<?php include_once './variables.php'; ?>

<!DOCTYPE html>
<html lang="en">

<!-- INCLUDE HEAD FILE -->
<?php include_once './views/partials/head.html'; ?>

<body>
    <!-- Hero Section -->
    <div class="hero">
        <div class="text-center">
            <h1>AI Image Generator</h1>
            <p>Enter a description of an image and click the button to generate it.</p>
        </div>
    </div>

    <!-- Instructions -->
    <div class="container my-5">
        <div class="row">
            <div class="col">
                <h2>Instructions</h2>
                <p>Enter a description of an image in the text area below. For example, you could enter "A red apple on
                    a white background" or "A cat sitting on a chair".</p>
                <p>AI will generate an image based on the description you provide.</p>
                <p>You can choose between two different styles: Vivid and Natural. Vivid style causes the model to lean
                    towards generating hyper-real and dramatic images. Natural style causes the model to produce more
                    natural, less hyper-real looking images.</p>
                <p>You can also choose the size and quality of the image.</p>
                <p>Once you click the "Generate Image" button, AI will generate the image based on your description.
                    Motored by OpenAI's DALL-E 3.
                </p>
                <p>The image may take a few seconds to generate. Please be patient.</p>
                
                <p>Once the image is generated, you can download it to your device.</p>
            </div>
        </div>
    </div>

    <!-- Image Generator -->
    <div class="container my-5">
        <!-- Image Generator Form -->
        <div class="row" id="imageGeneratorForm">
            <h2 class="mb-4">Image Generator</h2>
            <div class="col p-3 border rounded">
                <form action="" onsubmit="generateImage(event); return false;">

                    <!-- Image Description -->
                    <div class="mb-3">
                        <textarea class="form-control" id="textInput" name="textInput" rows="4" cols="50"
                            aria-describedby="textDescription" placeholder="Enter your image description here..."
                            required></textarea>

                        <div id="textDescription" class="form-text">
                            Be as descriptive as possible. Maximum length 1000 characters.
                        </div>
                    </div>

                    <!-- Image Style -->
                    <div class="mb-3">
                        <label for="imageStyle" class="form-label">Image Style:</label>
                        <select id="imageStyle" name="imageStyle" class="form-select"
                            aria-describedby="styleDescription">
                            <option value="vivid">Vivid</option>
                            <option value="natural">Natural</option>
                        </select>

                        <div id="styleDescription" class="form-text">
                            Vivid style generates hyper-real and dramatic images.
                            Natural style generates more natural, less hyper-real looking images.
                        </div>
                    </div>

                    <!-- Image Size -->
                    <div class="mb-3">
                        <label for="imageSize" class="form-label">Image Size:</label>
                        <select id="imageSize" name="imageSize" class="form-select">
                            <option value="1024x1024">1024x1024</option>
                            <option value="1792x1024">1792x1024</option>
                            <option value="1024x1792">1024x1792</option>
                        </select>
                    </div>

                    <!-- Image Quality -->
                    <div class="mb-3">
                        <label for="imageQuality" class="form-label">Image Quality:</label>
                        <select id="imageQuality" name="imageQuality" class="form-select">
                            <option value="standard">Standard</option>
                            <option value="hd">HD</option>
                        </select>
                    </div>

                    <!-- Generate Image Button -->
                    <button type="submit" class="btn btn-primary">Generate Image</button>
                </form>
            </div>
        </div>

        <!-- Generated Image -->
        <div class="row">
            <div id="generatedImage" style="display: none;">
                <h2 class="mb-3">Generated Image</h2>
                <p>Here is the image generated based on your description:</p>

                <em id="prompt" class="my-2"></em>

                <img class="img-fluid my-3" src="" alt="Generated AI img">

                <a id="downloadButton" class="btn btn-primary">Download Image</a>

                <button class="btn btn-warning" onclick="tryAgain()"> Create another image </button>
            </div>
        </div>

        <!-- Loader -->
        <div class="row">
            <div id="loader" style="display:none;" class="text-center">
                <h2 class="my-3">Generating image...</h2>
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p>The image may take a few seconds to generate. Please be patient.</p>
            </div>
        </div>

        <!-- Error Message -->
        <div class="row">
            <div id="error" style="display:none;">
                <p class="text-danger"> An error occurred. Please try again.</p>
                <button class="btn btn-warning" onclick="tryAgain()">Try again</button>
            </div>
        </div>

    </div>

    <!-- INCLUDE FOOTER FILE -->
    <?php include_once './views/partials/footer.php'; ?>


    <!-- INCLUDE SCRIPTS FILE -->
    <?php include_once './views/partials/scripts.html'; ?>
</body>

</html>
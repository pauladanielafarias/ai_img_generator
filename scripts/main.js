// Function to generate the image
const generateImage = async (event) => {
    event.preventDefault();
    try {
        const prompt = $('#textInput').val().trim();
        const style = $('#imageStyle').val();
        const size = $('#imageSize').val();
        const quality = $('#imageQuality').val();

        const data = {
            "prompt": prompt,
            "style": style,
            "size": size,
            "quality": quality,
        };

        //console.log(data);

        // Hide the form
        $('#imageGeneratorForm').hide();
        // Show the loader
        $('#loader').show();

        // Fetch request to generate the image using OpenAI API
        const response = await fetch('../services/generateImg.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

    
        // Check the response status
        if (!response.ok) {
            throw new Error(response.statusText);
        }

        // Get the data from the response
        const responseData = await response.json();
        //console.log(responseData)

        if (responseData.error) {
            throw new Error(responseData.error);
        }

        
        const imageUrl = responseData.imageUrl;
        //console.log(imageUrl);

        // Hide the loader
        $('#loader').hide();

        // Add the image and prompt to #generatedImage div
        $('#generatedImage img').attr('src', imageUrl);
        $('#generatedImage #prompt').text(prompt);

        // Convert the image to blob
        await fetch(imageUrl)
            .then(res => res.blob())
            .then(blob => {

                const objectURL = URL.createObjectURL(blob);
                
                // Add the download link
                $('#generatedImage #downloadButton').attr('href', objectURL);
                $('#generatedImage #downloadButton').attr('download');
                $('#generatedImage #downloadButton').attr('target', '_blank');
            })
            .catch(error => {
                console.error('Error converting image to blob.', error);

                // Add the download link
                $('#generatedImage #downloadButton').attr('href', imageUrl);
                $('#generatedImage #downloadButton').attr('download');
                $('#generatedImage #downloadButton').attr('target', '_blank');
                
            });
        
        // Show the generated image
        $('#generatedImage').show();
    }
    catch (error) {
        console.error('Error generating image.', error);
        
        // Hide the loader
        $('#loader').hide();

        // Show error message
        $("#error").show();
    }
}


const tryAgain = () => {

    // Console clear
    console.clear();

    // Reset the form
    $('form').trigger('reset');

    // Delete the generated image src
    $('#generatedImage img').attr('src', '');

    // Hide the generated image and error message
    $('#generatedImage').hide();
    $('#error').hide();

    // Show the form
    $('#imageGeneratorForm').show();

}
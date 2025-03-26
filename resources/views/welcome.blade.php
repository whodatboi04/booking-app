<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="result"></div>
    <script>
        async function getData() {

            
            const url = "http://127.0.0.1:8000/api/auth/refresh";
            try {    
                const headerTOken = localStorage.getItem('token')
                const response = await fetch(url,{
                    headers: {'Authorization': `Bearer ${headerTOken}`}
                });
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }
                const json = await response.json();
                const TOKEN = json.data.access_token
                localStorage.setItem('token', TOKEN)

                document.querySelector('.result').innerHTML = JSON.stringify(json.message); // Show result on page
            } catch (error) {
                console.error(error.message);
                document.querySelector('.result').innerHTML = `Error: ${error.message}`; // Show error on page
            }
        }

        // Automatically call getData when the page loads
        window.onload = getData;
    </script>
</body>
</html>

// Parse the JSON data and create book cards
function displayBooks(data) {
    const bookResults = document.getElementById('slibrary-results');

    // Clear any existing content
    bookResults.innerHTML = '';
    // console.log(data.output);

    data = JSON.parse(data.output);

    // Loop through each book in the data
    data.forEach((book) => {
        // Create a div element for the book card
        var card = document.createElement('div');
        card.classList.add('book-card');

        // Construct the HTML content for the card
        card.innerHTML = `
            <p><b>${book.title}</b></p>
            <p>Author: ${book.author}</p>
            <p>${book.publisher}</p>
            <p>${book.availability}</p>
            <a href="${book.link}" target="_blank">View Details</a>
        `;

        // Append the card to the bookResults container
        bookResults.appendChild(card);
    });
}

// Function to fetch data from PHP
function fetchData() {
    if(user === false) {
        const bookResults = document.getElementById('slibrary-results');
        bookResults.innerHTML = `
            <p>Please Login to access this section..!! <a href= "login.html">Click Here for Login</a></p>
        `;
    }
    else {


    var query = document.getElementById('searchInput').value;

    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Define the URL of the PHP script
    var url = 'http://localhost/BookStore/link.php?query=' + encodeURIComponent(query);

    // Open a GET request to the PHP script
    xhr.open('GET', url, true);

    // Define a function to handle the response
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                if (xhr.responseText) {
                    try {
                        var data = JSON.parse(xhr.responseText);
                        displayBooks(data);
                        // console.log(data);
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                    }
                } else {
                    console.error("Empty response from server");
                }
            } else {
                console.error("Request failed with status:", xhr.status);
            }
        }
    };

    // Send the request
    xhr.send();
}
}

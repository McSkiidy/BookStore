function handleKeyPress(event) {
    if (event.key === "Enter") {
        // If Enter key is pressed, trigger the button click event
        document.getElementById("searchButton").click();
    }
}

async function searchBooksGoogle() {
    const searchInput = document.getElementById('searchInput').value;
    const resultsContainer = document.getElementById('google-results');
    
    if (searchInput.trim() === '') {
        resultsContainer.innerHTML = '<p>Please enter a book name.</p>';
        return;
    }

    try {
        const response = await fetch(`https://www.googleapis.com/books/v1/volumes?q=${searchInput}&maxResults=40`);
        const data = await response.json();

        if (data.items && data.items.length > 0) {
            const books = data.items.map(item => ({
                title: item.volumeInfo.title,
                author: item.volumeInfo.authors ? item.volumeInfo.authors.join(', ') : 'Unknown',
                thumbnail: item.volumeInfo.imageLinks ? item.volumeInfo.imageLinks.thumbnail : '',
                categories: item.volumeInfo.categories ? item.volumeInfo.categories:'',
                publisher: item.volumeInfo.publisher ? item.volumeInfo.publisher:'',
                publishedDate: item.volumeInfo.publishedDate ? item.volumeInfo.publishedDate:'',
                pageCount: item.volumeInfo.pageCount ? item.volumeInfo.pageCount:'',
                infoLink: item.volumeInfo.infoLink ? item.volumeInfo.infoLink: '',

            }));

            const resultsHTML = books.map(book => `
                <div class="book">
                    <p><strong>${book.title}</strong></p>
                    <img src="${book.thumbnail}" alt="${book.title} cover" style="width: auto; height: auto;"> 
                    <p><strong>Publisher:${book.publisher}</strong></p>
                    <p><strong> Published Date:${book.publishedDate}</strong></p>
                    <p> <strong>Category:</strong>${book.categories}</p>
                    <p> <strong>Pages: </strong>${book.pageCount}</p>
                    <p> <strong>Preview: </strong><a href="${book.infoLink}" target="_blank">Click Here..</a></p>
                    </div>
            `).join('');

            resultsContainer.innerHTML = resultsHTML;
        } else {
            resultsContainer.innerHTML = '<p>No results found.</p>';
        }
    } catch (error) {
        console.error('Error fetching data:', error);
        resultsContainer.innerHTML = '<p>An error occurred while fetching data.</p>';
    }
}



function isEmptyObject(obj) {
    return Object.keys(obj).length === 0;
  }


// Function to check if the image exists at the specified URL
async function checkImageExists(url) {
    try {
        const response = await fetch(url, { method: 'HEAD' });

        if (!response.ok) {
            return true; // Image doesn't exist
        }

        const headers = response.headers;
        const contentLength = headers.get('content-length');
        const contentType = headers.get('content-type');

        if (contentLength === '0' || !contentType.startsWith('image')) {
            return true; // Image is empty or not an image
        }

        // Check content size without loading the entire image
        if (parseInt(contentLength) <= 2) {
            return true; // Image size is <= 2 bytes, considering it as 1x1
        }

        return false; // Image exists and has a reasonable size
    } catch (error) {
        return true; // An error occurred, use custom image
    }
}


async function searchBooksOpenL() {
    const searchInput = document.getElementById('searchInput').value;
    const resultsContainer = document.getElementById('openl-results');
    
    if (searchInput.trim() === '') {
        resultsContainer.innerHTML = '<p>Please enter a book name.</p>';
        return;
    }


    try {
        const response = await fetch(`https://openlibrary.org/search.json?q=${searchInput}`);
        const data = await response.json();

        if (!isEmptyObject(data)) {
            const books = data.docs.slice(0, 40);

            for (const book of books) {
                const title = book.title;
                const author = book.author_name ? book.author_name.join(', ') : 'N/A';
                const publicationYear = book.first_publish_year || 'N/A';
                const isbn = book.isbn ? book.isbn[0] : 'N/A'; // Select the first ISBN
                const editionCount = book.edition_count;
                const publishPlace = book.publish_place ? book.publish_place[0] : 'N/A'; // Select the first publish place

                // Fetch the cover image
                let imageUrl = `https://covers.openlibrary.org/b/isbn/${isbn}-M.jpg`;
                // Check if the image exists before attempting to display it
                const imageExists = await checkImageExists(imageUrl);   
                if (imageExists) {
                    imageUrl = "./no-image.png";
                }

                // Display information in the resultsContainer
                const bookDiv = document.createElement('div');
                bookDiv.classList.add('book-container');


                bookDiv.innerHTML = `
                    <p><strong>${title}</strong></p>
                    <img src="${imageUrl}" style="width:150px; height: 200px;" alt="${title} cover">
                    <p><strong>Author:</strong> ${author}</p>
                    <p><strong>Publication Year:</strong> ${publicationYear}</p>
                    <p><strong>Edition:</strong> ${editionCount}</p>
                    <p><strong>ISBN:</strong> ${isbn}</p>
                    <p><strong>Publish Place:</strong> ${publishPlace}</p>
                `;

                resultsContainer.appendChild(bookDiv);
            }
        } else {
            resultsContainer.innerHTML = '<p>No matching books.</p>';
        }
    } catch (error) {
        console.error('Error fetching data:', error);
        resultsContainer.innerHTML = '<p>An error occurred while fetching data.</p>';
    }
}

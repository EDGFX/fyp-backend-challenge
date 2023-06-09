<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="You can walk backwards down a flight of stairs, but is it possible to STAND backwards on a flight of stairs? Xfiles theme song starts to play menacingly." />
  <meta property="og:site_name" content="FYP Coding Challenge" />
  <meta property="og:title" content="FYP Coding Challenge" />
  <meta property="og:description" content="You can walk backwards down a flight of stairs, but is it possible to STAND backwards on a flight of stairs? Xfiles theme song starts to play menacingly." />
  <meta property="og:url" content="https://edgfx.github.io/fyp-coding-challenge/" />
  <meta property="og:image" content="https://raw.githubusercontent.com/EDGFX/fyp-coding-challenge/main/og-image.jpg" />
  <meta property="og:locale" content="en_US" />
  <meta property="og:type" content="website" />
  <link rel='canonical' href='https://edgfx.github.io/fyp-coding-challenge/' /> 
  <title>FYP Coding Challenge</title> 
  <style>
  .category {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      border-radius: 10px;
      background-color: #1e1e1e;
      color: #e5e5e5;
      cursor: pointer;
      font-family: arial;
      text-transform: capitalize;
      padding: 20px;
      border: none;
      outline: none;
      transition: 0.4s;
      margin: 20px;
    }

    .category :first-child {
      grid-column: 1 / -1;
    }

    .category__heading {
      background-color: #2b2b2b;
      padding: 20px;
      border-radius: 10px;
    }

    .category__heading:after {
      content: "v";
      float: right;
      margin-top: 5px;
      transform: rotate(0deg);
      transition: .5s;
      font-size: 16px;
    }

    .category.active .category__heading:after {
      transform: rotate(180deg) translate(0px, 4px);
      transition: .5s;
    }

    .category__heading:hover {
      background-color: #363535;
      transition: 1s;
    }

    .category .product {
        display: none;
        font-size: 20px;
        transition: 1s;
    }

    .category.active .product {
        display: block;
        text-align: center;
        transition: 1s;
    }

    .product {
      background-color: #ccc;
      padding: 20px;
      color: #1e1e1e;
      border-radius: 10px;
      align-items: center;
      cursor: pointer;
      margin: 20px;
    }

    .product__heading {
        font-size: 18px;
        text-align: center;
    }

    .product__price {
      font-size: 12px;
    }

    .product__saleprice {
      background-color:goldenrod;
      opacity: 0;
      font-size: 12px;
      padding: 8px;
      border-radius: 4px;
    }

    .product:hover > .product__price {
      text-decoration: line-through;
    }

    .product:hover > .product__saleprice {
      transition-property: opacity;
      transition-duration: 1s;
      opacity: 1;
    }
  </style>
</head>

<body>
  <header>
    <hgroup>
      <h1>FYP Programming Challenge (Full Stack)</h1>
    </hgroup>
  </header>
  <main id="app">
    <div id="category-container"></div>
  </main>
  <script>

    const container = document.getElementById('app');
    const productContainer = document.getElementById('category-container');

    fetch('http://localhost:8000/api/products')
      .then(response => response.json())
      .then(data => {
        // Pass JSON data into categorizeData() function.
        const categorizedData = categorizeData(data);
        // Send categorizedData into generateHtmlElements() function for client-side rendering.
        generateHtmlElements(categorizedData);
      })
    .catch(error => console.error(error)); // Catch Error If It Occurs

    function categorizeData(data) {
        const categorizedData = {};
        data.forEach(product => {
            // Iterate through each product (incoming from JSON file), and determine whether or not respective product category already exists.
            // If it doesn't, add it.
            if (!categorizedData[product.cat]) {
              categorizedData[product.cat] = [];
            }
            // If product category already exists, add products to their respective categories within "categorizedData" object.
            categorizedData[product.cat].push(product);
        });
        return categorizedData;
    }

    function generateHtmlElements(data) {
        // Iterate through the categorizedData object and generate HTML elements and Event Listeners for each category.
        Object.entries(data).forEach(([cat, products]) => {
            const categoryDiv = document.createElement('div');
            categoryDiv.classList.add('category');
            categoryDiv.setAttribute("id", cat)
            categoryDiv.innerHTML = `
            <h2 class="category__heading">${cat}</h2>
            `;
            //If category heading is clicked, add active class to the product category container (Category Container > Category > Products)
            categoryDiv.querySelector('.category__heading').addEventListener('click', function(event) {
                categoryDiv.classList.toggle('active');
            });
            productContainer.appendChild(categoryDiv);
            
            // Iterate through products in category and generate HTML elements and Event Listeners for each product.
            products.forEach(product => {
            const productDiv = document.createElement('div');
            productDiv.dataset.productId = product.product;
            productDiv.classList.add('product');
            productDiv.setAttribute("id", product.product);
            productDiv.innerHTML = `
                <h3 class="product__heading">${product.product}</h3>
                <svg class="heart" width="24" height="24" xmlns="http://www.w3.org/2000/svg" ><path fill="${isFavorite(product.product) ? 'red' : 'white'}" d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402m5.726-20.583c-2.203 0-4.446 1.042-5.726 3.238-1.285-2.206-3.522-3.248-5.719-3.248-3.183 0-6.281 2.187-6.281 6.191 0 4.661 5.571 9.429 12 15.809 6.43-6.38 12-11.148 12-15.809 0-4.011-3.095-6.181-6.274-6.181"/></svg>
                <p class="product__price">Price: $${product.price}</p>
                <p class="product__saleprice">Sale Price: $${product.sale}</div>
            `;
            productDiv.addEventListener('click', toggleFavorite);
            // Logic to handle Heart SVG behavior based on whether or not a product is favorited.
            productDiv.addEventListener('mouseover', function(event) {
                const heart = event.currentTarget.querySelector('.heart');
                if (!isFavorite(product.product)) {
                    heart.querySelector('path').setAttribute('fill', 'red');
                }
                });
                productDiv.addEventListener('mouseout', function(event) {
                const heart = event.currentTarget.querySelector('.heart');
                if (!isFavorite(product.product)) {
                    heart.querySelector('path').setAttribute('fill', 'white');
                }
                });
            categoryDiv.appendChild(productDiv);
            });
        });
    }


    function toggleFavorite(event) {
        const productId = event.currentTarget.dataset.productId;
        const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        const index = favorites.indexOf(productId);
        
        // If product doesn't exist within Local Storage, push the product in.
        if (index === -1) {
            favorites.push(productId);
             console.log(`gtag("event": "product_favorited", "product_id": "${productId}")`); // Mock Analytics Event
        } else {
            // If product is already favorited, remove it from Local Storage.
            favorites.splice(index, 1);
            console.log(`gtag("event": "product_unfavorited", "product_id": "${productId}")`); // Mock Analytics Event
        }
        // Convert our JS values into JSON strings
        localStorage.setItem('favorites', JSON.stringify(favorites));
        event.currentTarget.classList.toggle('favorite'); // Add "favorite" class and heart to targeted product.
        const heart = event.currentTarget.querySelector('.heart');
        heart.querySelector('path').setAttribute('fill', isFavorite(productId) ? 'red' : 'white'); // Logic to handle heart color based on whether favorited or not.

        document.querySelectorAll(`[id="${productId}"] .heart path`).forEach(path => {
            path.setAttribute('fill', isFavorite(productId) ? 'red' : 'white');
        });
    }

    // Check whether product is favorited or not, to be used to determine color of Heart SVG for products.
    function isFavorite(productId) {
        const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        return favorites.includes(productId);
    }
  </script>
</body>
</html>
document.addEventListener("DOMContentLoaded", () => {
    
    let slideIndex = 0;
    const slides = document.querySelector('.slides');
    const slideCount = slides ? slides.children.length : 0;
    const slideWidth = 100;
    let slideInterval = setInterval(autoMoveSlide, 3000);
    let isTransitioning = false;

    function autoMoveSlide() {
        moveSlide(1, true);
    }

    function moveSlide(n, isAuto = false) {
        if (isTransitioning || !slides) return;
        isTransitioning = true;

        slideIndex += n;
        if (slideIndex >= slideCount) {
            slideIndex = 0;
        } else if (slideIndex < 0) {
            slideIndex = slideCount - 1;
        }

        slides.style.transition = 'transform 0.5s ease';
        slides.style.transform = `translateX(-${slideIndex * slideWidth}%)`;

        slides.addEventListener('transitionend', () => {
            isTransitioning = false;
        }, { once: true });

        if (!isAuto) {
            resetInterval();
        }
    }

    function resetInterval() {
        clearInterval(slideInterval);
        slideInterval = setInterval(autoMoveSlide, 3000);
    }

    document.querySelector('.prev')?.addEventListener('click', () => {
        moveSlide(-1);
    });

    document.querySelector('.next')?.addEventListener('click', () => {
        moveSlide(1);
    });
    
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let isPersistentHoverActive = false;
    
    const updateCartCount = () => {
        const totalCount = cart.reduce((acc, item) => acc + item.quantity, 0);
        const cartCountElement = document.getElementById('cart-count');
        if (cartCountElement) {
            cartCountElement.innerText = totalCount;
        }
    };

    const updateCartDisplay = () => {
        const cartItemsContainers = document.querySelectorAll('#cart-items');
        cartItemsContainers.forEach(cartItemsContainer => {
            if (!cartItemsContainer) return;

            cartItemsContainer.innerHTML = '';

            if (cart.length === 0) {
                const emptyCartMessage = document.getElementById('empty-cart-message');
                if (emptyCartMessage) {
                    emptyCartMessage.style.display = 'block';
                }
                const totalPriceElement = document.getElementById('total-price');
                if (totalPriceElement) {
                    totalPriceElement.innerText = 'Total: 0€';
                }
            } else {
                const emptyCartMessage = document.getElementById('empty-cart-message');
                if (emptyCartMessage) {
                    emptyCartMessage.style.display = 'none';
                }
                let total = 0;

                cart.forEach(item => {
                    const itemDiv = document.createElement('div');
                    itemDiv.classList.add('cart-item');
                    itemDiv.innerHTML = `
                        <img src="${item.image}" class="cart-item-image" alt="Product Image">
                        <div class="cart-item-name" alt="Product Name">${item.name}</div>
                        <div class="quantity-controls">
                            <button class="decrease-quantity" data-name="${item.name}">-</button>
                            <span class="quantity">${item.quantity}</span>
                            <button class="increase-quantity" data-name="${item.name}">+</button>
                        </div>
                        <p class="item-price">${(item.price * item.quantity).toFixed(2)}€</p>
                    `;
                    cartItemsContainer.appendChild(itemDiv);
                    total += item.price * item.quantity;
                });

                const totalPriceElement = document.getElementById('total-price');
                if (totalPriceElement) {
                    totalPriceElement.innerText = `Total: ${total.toFixed(2)}€`;
                }
            }
        });

        localStorage.setItem('cart', JSON.stringify(cart));
    };

    const updateCartDisplayMain = () => {
        const cartItemsContainerMain = document.querySelector('main #cart-items');
        const totalPriceElementMain = document.querySelector('main #total-price');
        const emptyCartMessageMain = document.querySelector('main #empty-cart-message');

        if (!cartItemsContainerMain) return;

        cartItemsContainerMain.innerHTML = '';

        if (cart.length === 0) {
            if (emptyCartMessageMain) {
                emptyCartMessageMain.style.display = 'block';
            }
            if (totalPriceElementMain) {
                totalPriceElementMain.innerText = 'Total: 0.00€';
            }
        } else {
            if (emptyCartMessageMain) {
                emptyCartMessageMain.style.display = 'none';
            }
            let total = 0;

            cart.forEach(item => {
                const itemDiv = document.createElement('div');
                itemDiv.classList.add('cart-item');
                itemDiv.innerHTML = `
                    <img src="${item.image}" class="main-item-image" alt="Product Image">
                    <div class="main-item-name" alt="Product Name">${item.name}</div>
                    <div class="quantity-controls">
                        <button class="decrease-quantity" data-name="${item.name}">-</button>
                        <input type="number" class="quantity-input" data-name="${item.name}" value="${item.quantity}" min="1">
                        <button class="increase-quantity" data-name="${item.name}">+</button>
                    </div>
                    <p class="item-price">${(item.price * item.quantity).toFixed(2)}€</p>
                    <button class="remove-item" data-name="${item.name}">🗑️</button>
                `;
                cartItemsContainerMain.appendChild(itemDiv);
                total += item.price * item.quantity;
            });

            if (totalPriceElementMain) {
                totalPriceElementMain.innerText = `Total: ${total.toFixed(2)}€`;
            }
        }
    };
    
    const calculateFinalPrice = () => {
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        const livraisonElement = document.getElementById('livraison');
        const promoElement = document.getElementById('promo');
        const totalPriceElement = document.getElementById('total-price');
        const finalPriceElement = document.getElementById('final-price');
        
        let totalPrice = parseFloat(totalPriceElement.innerText.replace('Total: ', '').replace('€', ''));
        let livraison = 8.00;
        if (document.getElementById('cash-on-delivery').checked) {
            livraison = 0.00;
        }
        const promoCodeInput = document.getElementById('promo-code').value;
        let promoPercent = JSON.parse(localStorage.getItem('promoPercent')) || 0;
        let promoCode = localStorage.getItem('promoCode') || '';
    
        if (promoCodeInput) {
            if (promoCodeInput === 'Bienvenue10') {
                promoPercent = -0.1;
                promoCode = promoCodeInput;
                localStorage.setItem('promoPercent', JSON.stringify(promoPercent));
                localStorage.setItem('promoCode', promoCode);
            } else {
                promoPercent = 0;
                promoCode = '';
                localStorage.removeItem('promoPercent');
                localStorage.removeItem('promoCode');
            }
        }
    
        const promoAmount = totalPrice * promoPercent;
        const finalPrice = totalPrice + livraison + promoAmount;
        
        promoElement.innerText = `Code promo: ${promoAmount.toFixed(2)}€`;
        livraisonElement.innerText = `Livraison: ${livraison.toFixed(2)}€`;
        finalPriceElement.innerText = `Total à régler: ${finalPrice.toFixed(2)}€`;
        
        let selectedPaymentMethod = '';
        paymentMethods.forEach(method => {
            method.addEventListener('change', calculateFinalPrice);
            if (method.checked) {
                selectedPaymentMethod = method.value;
            }
        });
    
        document.querySelector("input[name='cart_data']").value = JSON.stringify(cart);
        document.querySelector("input[name='promo_code']").value = promoCode;
        document.querySelector("input[name='montant_promo']").value = promoAmount.toFixed(2);
        document.querySelector("input[name='methode_paiement']").value = selectedPaymentMethod;
        document.querySelector("input[name='shipping_cost']").value = livraison.toFixed(2);
        document.querySelector("input[name='total_cost']").value = totalPrice.toFixed(2);
        document.querySelector("input[name='final_cost']").value = finalPrice.toFixed(2);
    };
    
    document.getElementById('apply-promo')?.addEventListener('click', () => {
        const promoCode = document.getElementById('promo-code').value;
        if (promoCode === 'Bienvenue10') {
            showMessage('Le code a bien été ajouté!', true);
        } else {
            showMessage('Veuillez essayer un autre code', false);
        }
        calculateFinalPrice();
    });

    document.getElementById('empty-cart')?.addEventListener('click', () => {
        cart = [];
        document.getElementById('promo').innerText = 'Code promo: 0.00€';
        updateCartCount();
        updateCartDisplay();
        updateCartDisplayMain();
        calculateFinalPrice();
    });
    
    const cartElement = document.getElementById('cart');
    const cartHover = document.getElementById('cart-hover');

    cartElement.addEventListener('mouseover', () => {
        isPersistentHoverActive = true;
        cartElement.classList.add('persistent-hover');
    });

    cartElement.addEventListener('mouseleave', () => {
        isPersistentHoverActive = false;
        cartElement.classList.remove('persistent-hover');
    });

    document.addEventListener('click', (e) => {
        if (!cartElement.contains(e.target) && !isPersistentHoverActive) {
            cartElement.classList.remove('persistent-hover');
        }
    });

    const modifyQuantity = (e) => {
        const button = e.target;
        const productName = button.getAttribute('data-name');
        const product = cart.find(item => item.name === productName);

        if (product) {
            if (button.classList.contains('decrease-quantity')) {
                if (product.quantity > 1) {
                    product.quantity--;
                } else {
                    cart = cart.filter(item => item.name !== productName);
                }
            } else if (button.classList.contains('increase-quantity')) {
                product.quantity++;
            }

            updateCartCount();
            updateCartDisplay();
            updateCartDisplayMain();
            calculateFinalPrice();
        }
    };

    const modifyQuantityInput = (e) => {
        const input = e.target;
        const productName = input.getAttribute('data-name');
        const product = cart.find(item => item.name === productName);

        if (product) {
            const newQuantity = parseInt(input.value);
            if (newQuantity > 0) {
                product.quantity = newQuantity;
            } else {
                cart = cart.filter(item => item.name !== productName);
            }

            updateCartCount();
            updateCartDisplay();
            updateCartDisplayMain();
            calculateFinalPrice();
        }
    };

    const removeItem = (e) => {
        const button = e.target;
        const productName = button.getAttribute('data-name');
        cart = cart.filter(item => item.name !== productName);

        updateCartCount();
        updateCartDisplay();
        updateCartDisplayMain();
        calculateFinalPrice();
    };
    
    const increaseInput = () => {
        const input = document.getElementById('quantity');
        input.value = parseInt(input.value) + 1;
    };

    const decreaseInput = () => {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    };
    
    const increaseButton = document.querySelector('.quantity-buttons button:first-child');
    if (increaseButton) {
        increaseButton.addEventListener('click', increaseInput);
    }

    const decreaseButton = document.querySelector('.quantity-buttons button:last-child');
    if (decreaseButton) {
        decreaseButton.addEventListener('click', decreaseInput);
    }
    
    const showMessage = (message, success = true) => {
        const promoMessageElement = document.getElementById('promo-message');
        if (promoMessageElement) {
            promoMessageElement.innerText = message;
            promoMessageElement.style.color = success ? 'green' : 'red';
            promoMessageElement.style.display = 'block';
            
            setTimeout(() => {
                promoMessageElement.style.display = 'none';
            }, 2000);
        }    
            
        const cartMessageElement = document.getElementById('add-to-cart-message');
        if (cartMessageElement) {
            cartMessageElement.innerText = message;
            cartMessageElement.style.color = success ? 'green' : 'red';
            cartMessageElement.style.display = 'block';
            
            setTimeout(() => {
                cartMessageElement.style.display = 'none';
            }, 2000);
        }
    };    

    setTimeout(function() {
        var messageDiv = document.getElementById("compteMessage");
        if (messageDiv) {
            messageDiv.style.transition = "opacity 0.5s ease";
            messageDiv.style.opacity = "0";
            setTimeout(function() {
                messageDiv.style.display = "none";
            }, 500);
        }
        var messageDiv = document.getElementById("connexionMessage");
        if (messageDiv) {
            messageDiv.style.transition = "opacity 0.5s ease";
            messageDiv.style.opacity = "0";
            setTimeout(function() {
                messageDiv.style.display = "none";
            }, 500);
        }
        var messageDiv = document.getElementById("enregistrementMessage");
        if (messageDiv) {
            messageDiv.style.transition = "opacity 0.5s ease";
            messageDiv.style.opacity = "0";
            setTimeout(function() {
                messageDiv.style.display = "none";
            }, 500);
        }
        var messageDiv = document.getElementById("indexMessage");
        if (messageDiv) {
            messageDiv.style.transition = "opacity 0.5s ease";
            messageDiv.style.opacity = "0";
            setTimeout(function() {
                messageDiv.style.display = "none";
            }, 500);
        }
        var messageDiv = document.getElementById("contactMessage");
        if (messageDiv) {
            messageDiv.style.transition = "opacity 0.5s ease";
            messageDiv.style.opacity = "0";
            setTimeout(function() {
                messageDiv.style.display = "none";
            }, 500);
        }
    }, 2500);

    const addToCart = () => {
        const color1 = document.querySelector('.colors[data-type="color1"] .selected')?.getAttribute('data-color') || '';
        const color2 = document.querySelector('.colors[data-type="color2"] .selected')?.getAttribute('data-color') || '';
        const size = document.querySelector('.sizes .selected')?.getAttribute('data-size') || '';
        const quantity = parseInt(document.getElementById('quantity').value);
        const price = parseFloat(document.getElementById('price').innerText.replace('€', ''));
        const composition = document.querySelector('.selected-option').textContent.trim();
        const macaronType = document.querySelector('h1').innerText;
        if (!color1 || !color2 || !composition || !size || isNaN(quantity) || quantity <= 0) {
            showMessage('Veuillez sélectionner un choix pour chaque option.', false);
        } else {
            showMessage('Macaron(s) ajouté(s) au panier', true);
        }

        const product = {
            name: `${macaronType} ${color1} ${composition} saveur ${color2} ${size}`,
            quantity: quantity,
            price: price,
            image: captureCanvas()
        };

        const existingProduct = cart.find(item => item.name === product.name);
        if (existingProduct) {
            existingProduct.quantity += quantity;
        } else {
            cart.push(product);
        }

        updateCartCount();
        updateCartDisplay();
        updateCartDisplayMain();
        
        localStorage.setItem('cart', JSON.stringify(cart));
    };

    const selectOption = (e) => {
        const parent = e.target.closest('.colors, .sizes');
        parent.querySelectorAll('.color-circle, .size-circle').forEach(el => el.classList.remove('selected'));
        e.target.classList.add('selected');

        mergeImages();
    };

    const mergeImages = () => {
        const canvas = document.getElementById('merged-image');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const image1Src = document.querySelector('.colors[data-type="color1"] .selected')?.getAttribute('data-image') || '';
        const image2Src = document.querySelector('.colors[data-type="color2"] .selected')?.getAttribute('data-image') || '';

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        if (image1Src) {
            const image1 = new Image();
            image1.src = image1Src;

            image1.onload = () => {
                ctx.globalAlpha = 1.0;
                ctx.drawImage(image1, 0, 0, canvas.width, canvas.height);

                if (image2Src) {
                    const image2 = new Image();
                    image2.src = image2Src;

                    image2.onload = () => {
                        ctx.globalAlpha = 0.5;
                        ctx.drawImage(image2, 0, 0, canvas.width, canvas.height);
                        ctx.globalAlpha = 1.0;
                    };
                }
            };
        }
    };

    const captureCanvas = () => {
        const canvas = document.getElementById('merged-image');
        return canvas.toDataURL('image/png');
    };

    const initializeCommonFeatures = () => {
        const toggleMenu = () => {
            document.querySelector('.nav-links').classList.toggle('active');
            document.querySelector('.burger').classList.toggle('active');
        };

        document.querySelector('.burger').addEventListener('click', toggleMenu);
        document.querySelectorAll('.colors .color-circle').forEach(el => el.addEventListener('click', selectOption));
        document.querySelectorAll('.sizes .size-circle').forEach(el => el.addEventListener('click', selectOption));
    };

    const selectSuggestedOptions = () => {
        const color1Option = document.querySelector('.colors[data-type="color1"] .color-circle[data-color="rouge"]');
        const compositionOption = document.querySelector('.options-composition .option-item[data-value="mix poudres amandes et noisettes"]');
        const color2Option = document.querySelector('.colors[data-type="color2"] .color-circle[data-color="framboise"]');
        const sizeOption = document.querySelector('.sizes .size-circle[data-size="M"]');

        if (color1Option) color1Option.classList.add('selected');
        if (color2Option) color2Option.classList.add('selected');
        if (sizeOption) sizeOption.classList.add('selected');
    };
    
    selectSuggestedOptions();
    updateCartCount();
    updateCartDisplay();
    updateCartDisplayMain();
    initializeCommonFeatures();
    mergeImages();
    
    const customSelect = document.querySelector(".custom-select");
    if (customSelect) {
        const selectedOption = customSelect.querySelector(".selected-option");
        const optionsComposition = customSelect.querySelector(".options-composition");
        const optionItems = customSelect.querySelectorAll(".option-item");

        function hideAllInfoContainers() {
            document.querySelectorAll(".info-container").forEach(info => {
                info.style.display = "none";
            });
            document.querySelectorAll(".info-icon").forEach(icon => {
                icon.classList.remove("clicked");
            });
        }

        selectedOption.addEventListener("click", function() {
            optionsComposition.style.display = optionsComposition.style.display === "block" ? "none" : "block";
        });

        optionItems.forEach(function(item) {
            item.addEventListener("click", function() {
                const value = this.getAttribute("data-value");
                selectedOption.innerHTML = `${value} <i class="fas fa-chevron-down dropdown-icon"></i>`;
                optionsComposition.style.display = "none";
            });

            const infoIcon = item.querySelector(".info-icon");
            const infoContainer = document.createElement('div');
            infoContainer.classList.add('info-container');
            infoContainer.innerHTML = `<p class="info-text">${item.getAttribute('data-info')}</p>`;
            item.appendChild(infoContainer);

            infoIcon.addEventListener("mouseover", function() {
                hideAllInfoContainers();
                infoContainer.style.display = "block";
            });

            infoIcon.addEventListener("mouseout", function() {
                if (!this.classList.contains("clicked")) {
                    infoContainer.style.display = "none";
                }
            });

            infoIcon.addEventListener("click", function(event) {
                event.stopPropagation();
                if (this.classList.contains("clicked")) {
                    this.classList.remove("clicked");
                    infoContainer.style.display = "none";
                } else {
                    hideAllInfoContainers();
                    this.classList.add("clicked");
                    infoContainer.style.display = "block";
                }
            });
        });

        document.addEventListener("click", function(event) {
            if (!customSelect.contains(event.target)) {
                optionsComposition.style.display = "none";
                hideAllInfoContainers();
            }
        });

        document.getElementById('add-to-cart').addEventListener('click', addToCart);
    }
    
    const cartItemsContainerHeader = document.querySelector('header #cart-items');
    if (cartItemsContainerHeader) {
        cartItemsContainerHeader.addEventListener('click', modifyQuantity);
    }

    const cartItemsContainerMain = document.querySelector('main #cart-items');
    if (cartItemsContainerMain) {
        cartItemsContainerMain.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-item')) {
                removeItem(e);
            } else if (e.target.classList.contains('decrease-quantity') || e.target.classList.contains('increase-quantity')) {
                modifyQuantity(e);
            }
        });

        cartItemsContainerMain.addEventListener('input', (e) => {
            if (e.target.classList.contains('quantity-input')) {
                modifyQuantityInput(e);
            }
        });
    }
    
    calculateFinalPrice();
    
});

document.addEventListener('DOMContentLoaded', function () {
    const checkoutButton = document.getElementById('checkout-button');
    const emptyCartWarning = document.getElementById('empty-cart-warning');
    const cartItems = JSON.parse(localStorage.getItem('cart')) || [];

    checkoutButton.addEventListener('click', function (event) {
        if (!cartItems || cartItems.length === 0) {
            event.preventDefault();
            emptyCartWarning.style.display = 'block';
            setTimeout(() => {
                emptyCartWarning.style.display = 'none';
            }, 2000);
        } else {
            emptyCartWarning.style.display = 'none';
        }
    });
    document.getElementById('checkout').addEventListener('submit', function() {
        const cartData = localStorage.getItem('cart');
        document.getElementById('cart_data').value = cartData;
    });
});

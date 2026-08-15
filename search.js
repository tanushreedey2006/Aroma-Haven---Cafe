(() => {

const conte = document.querySelector(".search-bar-container");
const magnifi = document.querySelector(".magnifier");

if (magnifi && conte) {
    magnifi.addEventListener("click", () => {
        conte.classList.toggle("active");
    });
}

window.addEventListener("load", () => {
    const params = new URLSearchParams(window.location.search);

    if (params.has("newcategory")) {
        setTimeout(() => {
            document.getElementById("newcollection")
                ?.scrollIntoView({ behavior: "smooth" });
        }, 100);
    }

    loadWishlist();
    loadCartCount();
});

})();


// ================= SAFE JSON PARSER =================
// ================= SAFE JSON PARSER =================
async function safeJSON(res) {
    const text = await res.text();

    try {
        return JSON.parse(text);
    } catch (e) {
        console.error("JSON PARSE ERROR ❌", e);
        return null;
    }
}


// ================= CART =================
function toggleCart(id, name, image, price) {

    let btn = document.getElementById("cartBtn" + id);
    if (!btn) return;

    let action = btn.dataset.state || "add";

    fetch("cart_action.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `product_id=${id}
        &name=${encodeURIComponent(name)}
        &image=${encodeURIComponent(image)}
        &price=${price}
        &action=${action}`
    })

    .then(safeJSON)
    .then(data => {

        if (!data) return;

        let cartCount = document.getElementById("cartCount");
        if (cartCount) {
            cartCount.innerText = data.cart_count ?? 0;
        }

        if (action === "add") {

            btn.innerHTML =
                `<i class="fa-solid fa-trash"></i> Remove From Cart`;

            btn.style.background =
                "linear-gradient(135deg,#c40000,#ff2020)";

            btn.dataset.state = "remove";

            showToast("🛒 Added To Cart");
        }
        else {

            btn.innerHTML =
                `<i class="fa-solid fa-cart-shopping"></i> Add To Cart`;

            btn.style.background =
                "linear-gradient(135deg,#58260f,#7a1f06)";

            btn.dataset.state = "add";

            showToast("❌ Removed From Cart");
        }
    })
    .catch(error => console.log("Cart Error:", error));
}




function removeWishlist(id){

    fetch("wishlist_action.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `wishlist_id=${id}&action=remove`
    })

    .then(res => res.json())
    .then(data => {

        if(!data.success) return;

        // remove UI instantly
        let card = document.querySelector(`[data-wish-id="${id}"]`);
        if(card) card.remove();

        // update count
        let el = document.getElementById("wishlistCount");
        if(el){
            el.innerText = data.wishlist_count ?? 0;
        }

        showToast("💔 Removed From Wishlist");
    })
    .catch(err => console.log(err));
}




// ================= WISHLIST =================
function toggleWishlist(id, name, image, price) {

    let icon = document.getElementById("wishBtn" + id);
    if (!icon) return;

    let action = icon.classList.contains("active") ? "remove" : "add";

    fetch("wishlist_action.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `product_id=${id}
        &product_name=${encodeURIComponent(name)}
        &product_image=${encodeURIComponent(image)}
        &price=${price}
        &action=${action}`
    })

    .then(res => res.json())
    .then(data => {

        if (!data || !data.success) return;

        // UI toggle
        if (action === "add") {
            icon.classList.add("active");
            showToast("❤️ Added To Wishlist");
        } else {
            icon.classList.remove("active");
            showToast("💔 Removed From Wishlist");
        }

        // ✅ SAFE COUNT UPDATE
        let wishlistCount = document.getElementById("wishlistCount");
        if (wishlistCount) {
            wishlistCount.innerText = data.wishlist_count ?? 0;
        }

        // ❌ REMOVE extra sync call (this was causing confusion)
    })
    .catch(err => console.log("Wishlist error:", err));
}

// ================= LOAD WISHLIST =================
function loadWishlist() {

    fetch("wishlist_action.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "action=load"
    })

    .then(safeJSON)
    .then(data => {

        if (!data) return;

        let wishlistCount = document.getElementById("wishlistCount");
        if (wishlistCount) {
            wishlistCount.innerText = data.wishlist_count ?? 0;
        }
    })
    .catch(error => console.log("Load Wishlist Error:", error));
}


// ================= LOAD CART COUNT =================
function loadCartCount() {

    fetch("cart_action.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "action=load"
    })

    .then(safeJSON)
    .then(data => {

        if (!data) return;

        let cartCount = document.getElementById("cartCount");
        if (cartCount) {
            cartCount.innerText = data.cart_count ?? 0;
        }
    })
    .catch(error => console.log("Load Cart Error:", error));
}


// ================= TOAST =================
function showToast(message) {

    let toast = document.createElement("div");
    toast.innerHTML = message;

    Object.assign(toast.style, {
        position: "fixed",
        bottom: "30px",
        right: "30px",
        background: "#1f1f1f",
        color: "#fff",
        padding: "14px 22px",
        borderRadius: "14px",
        fontWeight: "bold",
        boxShadow: "0 12px 25px rgba(0,0,0,0.25)",
        zIndex: "99999"
    });

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 2000);
}

function renderWishlist(html) {
    let container = document.getElementById("wishlistContainer");
    if (container) {
        container.innerHTML = html;
    }
}

function syncWishlist(){

    fetch("wishlist_action.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "action=load"
    })

    .then(res => res.json())
    .then(data => {

        let countEl = document.getElementById("wishlistCount");
        if(countEl){
            countEl.innerText = data.wishlist_count ?? 0;
        }
    })
    .catch(err => console.log("Sync error:", err));
}

// ================= REDIRECT =================
function redirectPage(select) {

    let page = select.value;

    if (page) {
        window.location.href = page;
    }

    select.selectedIndex = 0;
}



